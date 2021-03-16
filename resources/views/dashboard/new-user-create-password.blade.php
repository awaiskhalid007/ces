<!DOCTYPE html>
<html lang="en">
<head>
	<base href="/">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Update Password</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel='stylesheet' href='css/style.css' type='text/css' />
    <link rel='stylesheet' href='fontawesome/css/all.min.css' type='text/css' />
</head>
<body id="login" class="forgot-password">

	<div class="container">
		<div class="col-md-4 offset-md-4">
			<div class="box">
				<img src="https://my.groundplan.com/images/gp_logo_color.svg" class="img-fluid" />
				<div class="clearfix"><br></div>

				<form action="{{route('user.reset.password')}}" method="POST">
					@csrf
					<div class="input-group mb-3">
					  <div class="input-group-prepend">
					    <span class="input-group-text" id="basic-addon1">
					    	<i class="fa fa-key"></i>
					    </span>
					  </div>
					  <input type="password" class="form-control" placeholder="Enter new password" name="password" minlength="5" maxlength="25" required />
					  <input type="hidden" name="user_id" value="{{$user[0]->id}}">
					</div>
					@error('password')
						<p style="color: red;">* {{$message}}</p>
					@enderror
					<div class="input-group mb-3">
					  <div class="input-group-prepend">
					    <span class="input-group-text" id="basic-addon1">
					    	<i class="fa fa-key"></i>
					    </span>
					  </div>
					  <input type="password" class="form-control" placeholder="Enter password again" name="confirm_password" minlength="5" maxlength="25" required />
					</div>
					@error('confirm_password')
						<p style="color: red;">* {{$message}}</p>
					@enderror
					@if($errors->any())
	  					@if($errors->first() == 'matchError')
	  						<p style="color: red;">
	  							*Passwords does not match!
	  						</p>
	  					@endif
  					@endif	
					<div class="row">
						<div class="col-md-6">
							
						</div>
						<div class="col-md-6 text-right">
							<button class="btn btn-primary submit">Reset Password</button>
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
