<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Aws\S3\S3Client;
use Cookie;
use Crypt;
use Input;
use DB;

class API extends Controller
{
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
			'key'    => 'AKIAIN3B2CSQW6UEPITQ',
			'secret' => '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'
			]
			]);

		// Instantiate the client.
		$bucket = 'realtime-terc-data';						

		// Use the plain API (returns ONLY up to 1000 of your objects).
		$result = $s3->listObjects(array('Bucket' => $bucket));
		if($name == "Sunnyside"){
			$name = "S";
		}
		foreach ($result['Contents'] as $object) {
			if(preg_match("*".$name."*", $object['Key'])){
				$found = $object['Key'];
				break;
			}
		}

		// Now display the content:
		try {
		    // Get the object
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
