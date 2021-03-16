<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Sign Up</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel='stylesheet' href='css/style.css' type='text/css' />
    <link rel='stylesheet' href='fontawesome/css/all.min.css' type='text/css' />
</head>
<body id="register">

  <div class="container text-center mainheading">
  	<h2>Try Groundplan Free for 14 days</h2>
  	<p>FREE Training available with an actual qualified trades expert</p>
  </div>
  <section id="pricing_form" class="container">
  	<div class="row">
  		<div class="col-md-6">
  			<div class="box pricingbox">
            
            <label class="toggler toggler--is-active" id="filt-monthly">Monthly</label>
            <div class="toggle">
              <input type="checkbox" id="switcher" class="check">
              <b class="b switch"></b>
            </div>
            <label class="toggler" id="filt-yearly">Yearly</label>

            <div id="monthly" class="wrapper-full">
              <h3 class="mt-4"><span class="symbol">$</span><span>69</span><span class="month">/ month</span></h3>
              <h4>per <a href="javascript::void(0)">seat</a></h4>
              <div class="alternative"><span>Or commit to a year and <strong>save $138</strong></span></div>
              <h4>Prices in <a href="javascript::void(0)">USD</a></h4>
            </div>
            <div id="yearly" class="wrapper-full hide">
              <h3 class="mt-4"><span class="symbol">$</span><span>690</span><span class="month">/ year</span></h3>
              <h4>per <a href="javascript::void(0)">seat</a></h4>
              <div class="alternative"><span>Or commit to a year and <strong>save $138</strong></span></div>
              <h4>Prices in <a href="javascript::void(0)">USD</a></h4>
            </div>

            <hr style="margin-top: 40px;">

            <ul>
              <li><strong>Unlimited</strong> Projects and Plans</li>
              <li><strong>Free</strong> Training & Support</li>
              <li><strong>No Contracts</strong>. Pay-as-you-go.</li>
              <li>Concurrent Licensing</li>
            </ul>
        </div>
  		</div>
  		<div class="col-md-6 pb-4">
  			<div class="box signup-form" style="padding-bottom: 45px;">
          <div class="title" style="border: none;
          padding-top: 30px; margin-bottom: -60px;">
            {{-- <a href="/signup/google" class="btn" style="
            font-size: 20px; 
            -webkit-box-shadow: 0px 2px 10px 0px rgba(0,0,0,0.75);
            -moz-box-shadow: 0px 2px 10px 0px rgba(0,0,0,0.75);
            box-shadow: 0px 2px 10px 0px rgba(0,0,0,0.75);
            border-radius: none!important;
            "><img src="img/gicon.png" style="width: 25px;" alt="">&nbsp;Sign up with Google</a> --}}
            <div class="text-center">
              <a href="/signup/google" id="signup-with-google" class="google-sign-in white">
                <span>Sign up with Google</span>
              </a>
            </div>
          
          </div>
  				{{-- <div class="title">
  					<h3>30 Second Sign Up</h3>
  				</div> --}}
  				<div class="errors">
  					@if($errors->any())
	  					@if($errors->first() == 'unknownError')
	  						<div class="alert alert-warning">
	  							Unknown error. Please try again later!
	  						</div>
	  					@elseif($errors->first() == 'emailError')
	  						<div class="alert alert-warning">
	  							This email address is already registered!
	  						</div>
	  					@endif
  					@endif
  				</div>
  				<form action="{{route('user.register')}}" method="POST">
  					@csrf
            <input type="hidden" name="subscription" value="0" id="subscription" />
  					<input type="text" placeholder="Your name" name="name" required="required" />
            @error('name')
              <p style="color:red;font-size:15px;text-align: left;">{{ $message }}</p>
            @enderror
  					<input type="text" placeholder="Organisation/ Company" name="company" />
  					<input type="email" placeholder="Your Email" name="email" required="required"/>
            @error('email')
              <p style="color:red;font-size:15px;text-align: left;">{{ $message }}</p>
            @enderror
  					<input id="passbtn" type="password" onClick="myFunction()" placeholder="Your Password" name="password" required="required"/>
            @error('password')
              <p style="color:red;font-size:15px;text-align: left;">{{ $message }}</p>
            @enderror
                    <small id="passwordhelp" class="form-text text-muted" style="float: left">Password must contain Uppercase, Lowercase and Special Characters.</small>
  					<input type="text" placeholder="Phone Number" name="phone" />
  					<button class="btn btn-block">Get Started</button>
  					<p class="terms">
  						By signing up, you agree to our <a href="javascript::void(0)">Terms and Conditions</a>
  					</p>
  					<p class="terms">
  						You Already have an account?<a href="/login"> Sign In</a>
  					</p>
  				</form>
  			</div>
  		</div>
  	</div>
  </section>
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="fontawesome/js/all.min.js"></script>
  <script type="text/javascript" src="js/main.js"></script>
</body>
</html>
<script>
 var x = document.getElementById("passwordhelp");
 x.style.display = 'none';
    function myFunction() {
         var x = document.getElementById("passwordhelp");
        if (x.style.display === "none") {
            x.style.display = "block";
            } else {
             x.style.display = "none";
            }
}

</script>
