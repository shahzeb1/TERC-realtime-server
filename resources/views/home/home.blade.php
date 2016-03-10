<!DOCTYPE html>
<html lang="en">
<head>
	<title>Lake Data</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/style.css">
	<!-- Bootflat -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<link rel="stylesheet" href="http://cdn.jsdelivr.net/bootflat/2.0.0/css/bootflat.css">
	<link rel="stylesheet" href="http://cdn.jsdelivr.net/bootflat/2.0.0/css/bootflat.css.map">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
  </head>
  <body>
  	<div class="container">
  		<h2>Lake Data</h2>
  		<div class="loginButton">
  			<form action="/loginNewUser" method="post">
  				<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
  				<div class="row">
  					<div class="col-md-6">
  						<input type="email" name="email" class="form-control" placeholder="Email">
  					</div>
  					<div class="col-md-3">
  						<input type="submit" class="btn btn-primary btn-block" value="Login">
  					</div>
  				</div>
  			</form>
  		</div>
  		<!-- Scripts -->
  		<script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
  	</body>
  	</html>