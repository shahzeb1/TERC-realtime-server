<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Aws\S3\S3Client;
use Cookie;
use Crypt;
use Input;
use DB;
use DateTime;

use Parse\ParseClient;
use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParseACL;
use Parse\ParsePush;
use Parse\ParseUser;
use Parse\ParseInstallation;
use Parse\ParseException;
use Parse\ParseAnalytics;
use Parse\ParseFile;
use Parse\ParseCloud;

class API extends Controller
{
	/**
	 * Show the data form the NASA db
	 * @param  Request $request [description]
	 * @return JSON           API response
	 */
	public function showNASA(Request $request){
		$limit = $request->input('limit');
		$start = $request->input('start');
		$end = $request->input('end');
		$tb = $request->input('tb');

		// Check if start is set
		if($start == null){
			return response()->json(["error" => "The start parameter is missing."]);
		}

		// Check if tb is set
		if($tb == null){
			return response()->json(["error" => "Must provide a tb dataset (1-4)."]);
		}

		// Check if there is a limit
		if($limit == null){
			$limit = 100;
		}

		if($end != null){
			$results = DB::select('select * from tb'.$tb.' where (date >= :start) AND (date <= :end) limit :limit', ['start' => $start, 'end' => $end, 'limit' => $limit]);
		}else{
			$results = DB::select('select * from tb'.$tb.' where date = :start limit :limit', ['start' => $start, 'limit' => $limit]);	
		}

		return response()->json($results);

	}

	/**
	 * Show the Homewood data from the MS SQL DB
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function showHomewood(Request $request){
		$limit = $request->input('limit');
		$start = $request->input('start');
		$end = $request->input('end');

		// Check if start is set
		if($start == null){
			return response()->json(["error" => "The start parameter is missing."]);
		}

		// Otherwise go ahead with the IP query:
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, "http://52.9.252.205/data.php?start=".$start."&end=".$end."&limit=".$limit); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch); 
        curl_close($ch);    

		return $output;
	}

	/**
	 * Shows parse data for any other table other than the users table
	 * @param  [type]  $type    Algae / Beach / Species / Water
	 * @param  Request $request [description]
	 * @return [type]           JSON of the data from table
	 */
	public function showParseData($type, Request $request){
		ParseClient::initialize(env('PARSE_1'), env('PARSE_2'), env('PARSE_3'));
		$limit = $request->input('limit');
		$skip = $request->input('skip');
		$type = ucfirst($type);
		if($type == "Algae" || $type == "Beach" || $type == "Species" || $type == "Water"){
			// Make the query:
			$query = new ParseQuery($type);
			if(isset($limit) && $limit <= 200){
				$query->limit($limit);
			}else{
				$query->limit(10);
			}

			if(isset($skip) && $skip > 0){
				$query->skip($skip);
			}
			$results = $query->find();

			$final = [];

			for ($i = 0; $i < count($results); $i++) {
				$data = (array)$results[$i];
				$data = $data["\x00*\x00serverData"];

				$date = (array)$results[$i];
				$date = (array)$date["\x00Parse\ParseObject\x00createdAt"];
				$date = $date["date"];
				$data["createdAt"] = $date;

				if(array_key_exists('Location', $data)){
					$geo = (array)$data["Location"];
					$lat = $geo["\x00Parse\ParseGeoPoint\x00latitude"];
					$long = $geo["\x00Parse\ParseGeoPoint\x00longitude"];
					$location = array("latitude" => $lat, "longitude" => $long);
					$data["Location"] = $location;
				}
				if(array_key_exists('User', $data)){
					$user = (array)$data["User"];
					$user_id = $user["\x00Parse\ParseObject\x00objectId"];
					$data["User"] = $user_id;
				}
				if(array_key_exists('Image', $data)){
					$img = (array)$data["Image"];
					$img_url = $img["\x00Parse\ParseFile\x00url"];
					$data["Image"] = $img_url;
				}

				$final[$i] = $data;
			}

			return response()->json($final);
		}else{
			return response()->json(['error' => $type.' is not a valid Parse table.']);
		}
	}

	/**
	 * Show a single Parse user based on the `user_id`
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function showParseUser(Request $request){
		ParseClient::initialize(env('PARSE_1'), env('PARSE_2'), env('PARSE_3'));
		$user_id = $request->input('user_id');

		if(!isset($user_id)){
			return response()->json(["error" => "Please make sure the user_id field is set."]);
		}
		
		$query = ParseUser::query();
		$query->equalTo("objectId", $user_id); 
		$query->limit(1);
		$results = $query->find();

		if(count($results) != 0){
			$date = (array)$results[0];
			$date = (array)$date["\x00Parse\ParseObject\x00createdAt"];
			$date = $date["date"];

			$user = array(
						"anon" => $results[0]->get('anon'),
						"email" => $results[0]->get('email'),
						"eyes" => $results[0]->get('eyes'),
						"fbid" => $results[0]->get('fbid'),
						"name" => $results[0]->get('name'),
						"pipe" => $results[0]->get('pipe'),
						"points" => $results[0]->get('points'),
						"team" => $results[0]->get('team'),
						"username" => $results[0]->get('username'),
						"createdAt" => $date);

			return response()->json($user);
		}else{
			return response()->json(["error" => "No user found for ".$user_id]);
		}

	}

	/**
	 * Show Historic data API
	 * @param  [type]  $name    [description]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function showHistoric($name, Request $request){
		$key = $request->input('key');
		$format = $request->input('format');
		$start = $request->input('start');
		$end = $request->input('end');

		$startDay = date("z", strtotime($start));
		$endDay = date("z", strtotime($end));
		$startYear = date("Y", strtotime($start));
		$endYear = date("Y", strtotime($end));

		// Check if start is set
		if($start == null){
			return response()->json(["error" => "The start parameter is missing."]);
		}

		// Error if startYear and endYear aren't the same
		if($end != null && $startYear != $endYear){
			return response()->json(["error" => "Currently, only query's within the same year are supported."]);
		}
		
		if($end == null){
			$results = DB::select('select * from '.$name.' where year = :year and day = :day', ['year' => $startYear, 'day' => $startDay]);
		}else{
			$results = DB::select('select * from '.$name.' where year = :yearA AND day between :dayA and :dayB', ['yearA' => $startYear, 'dayA' => $startDay, 'dayB' => $endDay]);
		}
		return response()->json($results);
	}

	/**
	 * Show Realtime data
	 * @param  [type]  $name    [description]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function showRealtime($name, Request $request){
		$key = $request->input('key');
		$format = $request->input('format');

    	// Instantiate the S3 client with your AWS credentials and desired AWS region
		$s3 = new S3Client([
				'version'     => 'latest',
				'region'      => 'us-west-1',
				'credentials' => [
				'key'    => env('S3_KEY'),
				'secret' => env('S3_SECRET')
				]
			]);

		// Instantiate the client.
		$bucket = env('S3_BUCKET');	

		try{
			// Get the objects in the new/ folder
			$objects = $s3->getIterator('ListObjects', array(
				"Bucket" => $bucket,
				"Prefix" => "new/"
			));
			// Loop through all the $objects
			foreach ($objects as $object) {
				// Correction for Sunnyside
				if($name == "Sunnyside"){
					$name = "S";
				}
			    // Stop search as soon as we've matched
				if(preg_match("*".$name."*", $object['Key'])){
					$found = $object['Key'];
					break;
				}
			}

		// Now display the content:
		$result = $s3->getObject(array(
			'Bucket' => $bucket,
			'Key'    => $found
		));

	    // Display the object in the browser
		header("Content-Type: text/plain");
		echo $result['Body'];
		} catch (S3Exception $e) {
			echo $e->getMessage() . "\n";
		}
	}
}
