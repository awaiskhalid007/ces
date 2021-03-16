<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Forgot Password</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel='stylesheet' href='css/style.css' type='text/css' />
    <link rel='stylesheet' href='fontawesome/css/all.min.css' type='text/css' />
</head>
<body id="login" class="forgot-password">

	<div class="container">
		<div class="col-md-4 offset-md-4">
			<div class="box">
				<div class="text-center">
					<img src="img/logo.png" style="width: 200px;" class="img-fluid" />
				</div>
				<div class="clearfix"><br></div>

				<div class="errors">
					@if($errors->any())
	  					@if($errors->first() == 'emailError')
	  						<div class="alert alert-warning">
	  							Email address is not registered. Please <a href="/signup" class="alert-link">Sign Up</a>.
	  						</div>
	  					@elseif($errors->first() == 'success')
	  						<div class="alert alert-warning">
	  							Success. Please check your email for further instructions.
	  						</div>
	  					@endif
  					@endif	
				</div>
				<form action="{{route('user.recover')}}" method="POST">
					@csrf
					<div class="input-group mb-3">
					  <div class="input-group-prepend">
					    <span class="input-group-text" id="basic-addon1">
					    	<i class="fa fa-envelope"></i>
					    </span>
					  </div>
					  <input type="email" class="form-control" placeholder="Enter your email address" name="email" />
					</div>
					<div class="row">
						<div class="col-md-6">
							
						</div>
						<div class="col-md-6 text-right">
							<button class="btn btn-danger submit">Recover Password</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
  	

  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="fontawesome/js/all.min.js"></script>
</body>
</html>
