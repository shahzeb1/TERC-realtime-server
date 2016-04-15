<!DOCTYPE html>
<html lang="en">
<head>
	<title>Lake Data | @yield('title')</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="{{url('/')}}/css/style.css">
	<!-- Bootflat -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<link rel="stylesheet" href="http://cdn.jsdelivr.net/bootflat/2.0.0/css/bootflat.css">
	<link rel="stylesheet" href="http://cdn.jsdelivr.net/bootflat/2.0.0/css/bootflat.css.map">
  <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
  </head>
  <body>
  	<div class="container">
      <div class="row">
        <div class="col-md-9">
          <h3>Lake Data</h3>
        </div>
        <div class="col-md-3">
          <div class="btn-group">
                  <a type="button" href="/dashboard" class="btn btn-primary"><i class="glyphicon glyphicon-home"></i></a>
                  <a type="button" href="/logoutThisUser" class="btn btn-primary"><i class="glyphicon glyphicon-log-out"></i></a>
                  <a type="button" class="btn btn-primary"><i class="glyphicon glyphicon-info-sign"></i></a>
            </div>
        </div>
      </div>
      @yield('content')
  		<!-- Scripts -->
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
      <script src="http://bootflat.github.io/js/site.min.js"></script>
  		<script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
  	</body>
  	</html>