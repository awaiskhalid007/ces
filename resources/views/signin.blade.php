<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel='stylesheet' href='css/style.css' type='text/css' />
    <link rel='stylesheet' href='fontawesome/css/all.min.css' type='text/css' />
</head>
<body id="login">

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
	  							Incorrect email address.
	  						</div>
	  					@elseif($errors->first() == 'passError')
	  						<div class="alert alert-warning">
	  							Incorrect password.
	  						</div>
	  					@elseif($errors->first() == 'pass_reset')
	  						<div class="alert alert-success">
	  							Password changed. Please login to continue.
	  						</div>
	  					@elseif($errors->first() == 'confirmation_email_sent')
	  						<div class="alert alert-success">
	  							A confirmation email is sent. Please verify your account to login.
	  						</div>
	  					@elseif($errors->first() == 'email_verified')
	  						<div class="alert alert-success">
	  							Account verification successfull. Please signin to continue.
	  						</div>
	  					@elseif($errors->first() == 'email_not_verified')
	  						<div class="alert alert-warning">
	  							Account not verified. Please try again later.
	  						</div>
	  					@elseif($errors->first() == 'not_verified')
	  						<div class="alert alert-warning">
	  							Account not verified yet. <a style="cursor: pointer;" class="alert-link" data-toggle="modal" data-target="#resendEmailModal" >Click here</a> to verify.
	  						</div>
	  					@elseif($errors->first() == 'invalid_confirmation_email')
	  						<div class="alert alert-warning">
	  							No account found with this email address.
	  						</div>
	  					@elseif($errors->first() == 'user_not_activated')
	  						<div class="alert alert-warning">
	  							Link expired. Please try to forget your password.
	  						</div>
	  					@endif
  					@endif	
				</div>
				<form action="{{route('user.login')}}" method="POST">
					@csrf
					<div class="input-group mb-3">
					  <div class="input-group-prepend">
					    <span class="input-group-text" id="basic-addon1">
					    	<i class="fa fa-envelope"></i>
					    </span>
					  </div>
					  <input type="email" class="form-control" placeholder="E-mail" name="email" />
					</div>
					<div class="input-group mb-3">
					  <div class="input-group-prepend">
					    <span class="input-group-text" id="basic-addon1">
					    	<i class="fa fa-lock"></i>
					    </span>
					  </div>
					  <input type="password" class="form-control" placeholder="Password" name="password" />
					</div>
					<div class="row">
						<div class="col-md-6">
							<a href="/forgot-password" class="text-primary forgotBtn">Forgot Password?</a>
						</div>
						<div class="col-md-6 text-right">
							<button class="btn btn-danger submit">Login</button>
						</div>
					</div>
				</form>
				<div class="hr margin-bottom-lg">
					<span class="no-bg">OR</span>
				</div>
				<div class="text-center">
	            	<a href="/signup/google" id="signin-with-google" class="google-sign-in white">
	              		<span>Sign in with Google</span>
	            	</a>
		        </div>
			</div>
		</div>
	</div>
  	
{{-- Send confirmation email modal --}}
 <div class="modal fade" id="resendEmailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="modal-title" id="exampleModalLongTitle">
          Type your email address to send a confirmation email.
        </p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('resend.accountconfirmationemail')}}">
      @csrf
      <div class="modal-body">
      	<div class="form-group">
      	  <label>Your Email Address</label>
          <input type="email" id="email" name="email" class="form-control" placeholder="Your email address.." />
      	</div>
      </div>
      <div class="modal-footer" style="border-top: none!important;">
        <button class="btn btn-primary" type="submit">Send Confirmation Email</button>
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
