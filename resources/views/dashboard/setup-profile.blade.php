<!DOCTYPE html>
<html lang="en">
<head>
	<base href="/">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Projects</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel='stylesheet' href='css/style.css' type='text/css' />
    <link rel='stylesheet' href='fontawesome/css/all.min.css' type='text/css' />
</head>
<body>

  @include('dashboard.partials.header')

  <section id="wrapper">
  	<div class="col-md-12">
	  	<div class="row">
	  		@include('dashboard.partials.setting-sidebar')
	  		<div class="col-lg-9 rightpanel">
	  			<div class="errors">
	  				@if($errors->any())
	  					@if($errors->first() == 'namechanged')
	  						<div class="alert alert-success">Name updated successfully.</div>
	  					@endif
	  					@if($errors->first() == 'timezonechanged')
	  						<div class="alert alert-success">Timezone updated successfully.</div>
	  					@endif
	  				@endif
	  			</div>
	  			<div class="card profile" style="width: 100%" >
				  <div class="card-header">
				    Profile
				  </div>
				  <div class="card-body">
				  	<form action="{{route('user.changename')}}" method="POST">
				  	@csrf
				  		<div class="form-group">
				  			<label>Username</label>
				  			<input type="text" class="form-control" value="{{$user[0]->email}}" id="email" disabled />
				  		</div>
				  		<div class="form-group">
				  			<label>Name</label>
				  			<input type="text" class="form-control" name="name" value="{{$user[0]->name}}" id="name" required />
				  		</div>
				  		<button class="btn btn-primary btn-md">Save</button>
				  	</form>
				  </div>
				</div>
				<div class="card organisation mt-20" style="width: 100%" >
				  <div class="card-header">
				    Organisation Settings
				  </div>
				  <div class="card-body">
				  	<form action="{{route('user.changetimezone')}}" method="POST">
				  	@csrf
				  		<div class="form-group">
				  			<label>Timezone</label>
				  			<select name="timezone" class="form-control" >
				  				@if(!$sessionData->isEmpty())
				  					<option value="{{$sessionData[0]->timezone}}" selected disabled>{{$sessionData[0]->timezone}}</option>
				  				@else
				  			   		<option disabled selected>Choose your timezone</option>
				  			   	@endif
				  			   <option value="Etc/GMT+12">(GMT-12:00) International Date Line West</option>
							   <option value="Pacific/Midway">(GMT-11:00) Midway Island, Samoa</option>
							   <option value="Pacific/Honolulu">(GMT-10:00) Hawaii</option>
							   <option value="US/Alaska">(GMT-09:00) Alaska</option>
							   <option value="America/Los_Angeles">(GMT-08:00) Pacific Time (US & Canada)</option>
							   <option value="America/Tijuana">(GMT-08:00) Tijuana, Baja California</option>
							   <option value="US/Arizona">(GMT-07:00) Arizona</option>
							   <option value="America/Chihuahua">(GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
							   <option value="US/Mountain">(GMT-07:00) Mountain Time (US & Canada)</option>
							   <option value="America/Managua">(GMT-06:00) Central America</option>
							   <option value="US/Central">(GMT-06:00) Central Time (US & Canada)</option>
							   <option value="America/Mexico_City">(GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
							   <option value="Canada/Saskatchewan">(GMT-06:00) Saskatchewan</option>
							   <option value="America/Bogota">(GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>
							   <option value="US/Eastern">(GMT-05:00) Eastern Time (US & Canada)</option>
							   <option value="US/East-Indiana">(GMT-05:00) Indiana (East)</option>
							   <option value="Canada/Atlantic">(GMT-04:00) Atlantic Time (Canada)</option>
							   <option value="America/Caracas">(GMT-04:00) Caracas, La Paz</option>
							   <option value="America/Manaus">(GMT-04:00) Manaus</option>
							   <option value="America/Santiago">(GMT-04:00) Santiago</option>
							   <option value="Canada/Newfoundland">(GMT-03:30) Newfoundland</option>
							   <option value="America/Sao_Paulo">(GMT-03:00) Brasilia</option>
							   <option value="America/Argentina/Buenos_Aires">(GMT-03:00) Buenos Aires, Georgetown</option>
							   <option value="America/Godthab">(GMT-03:00) Greenland</option>
							   <option value="America/Montevideo">(GMT-03:00) Montevideo</option>
							   <option value="America/Noronha">(GMT-02:00) Mid-Atlantic</option>
							   <option value="Atlantic/Cape_Verde">(GMT-01:00) Cape Verde Is.</option>
							   <option value="Atlantic/Azores">(GMT-01:00) Azores</option>
							   <option value="Africa/Casablanca">(GMT+00:00) Casablanca, Monrovia, Reykjavik</option>
							   <option value="Etc/Greenwich">(GMT+00:00) Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London</option>
							   <option value="Europe/Amsterdam">(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>
							   <option value="Europe/Belgrade">(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>
							   <option value="Europe/Brussels">(GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>
							   <option value="Europe/Sarajevo">(GMT+01:00) Sarajevo, Skopje, Warsaw, Zagreb</option>
							   <option value="Africa/Lagos">(GMT+01:00) West Central Africa</option>
							   <option value="Asia/Amman">(GMT+02:00) Amman</option>
							   <option value="Europe/Athens">(GMT+02:00) Athens, Bucharest, Istanbul</option>
							   <option value="Asia/Beirut">(GMT+02:00) Beirut</option>
							   <option value="Africa/Cairo">(GMT+02:00) Cairo</option>
							   <option value="Africa/Harare">(GMT+02:00) Harare, Pretoria</option>
							   <option value="Europe/Helsinki">(GMT+02:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius</option>
							   <option value="Asia/Jerusalem">(GMT+02:00) Jerusalem</option>
							   <option value="Europe/Minsk">(GMT+02:00) Minsk</option>
							   <option value="Africa/Windhoek">(GMT+02:00) Windhoek</option>
							   <option value="Asia/Kuwait">(GMT+03:00) Kuwait, Riyadh, Baghdad</option>
							   <option value="Europe/Moscow">(GMT+03:00) Moscow, St. Petersburg, Volgograd</option>
							   <option value="Africa/Nairobi">(GMT+03:00) Nairobi</option>
							   <option value="Asia/Tbilisi">(GMT+03:00) Tbilisi</option>
							   <option value="Asia/Tehran">(GMT+03:30) Tehran</option>
							   <option value="Asia/Muscat">(GMT+04:00) Abu Dhabi, Muscat</option>
							   <option value="Asia/Baku">(GMT+04:00) Baku</option>
							   <option value="Asia/Yerevan">(GMT+04:00) Yerevan</option>
							   <option value="Asia/Kabul">(GMT+04:30) Kabul</option>
							   <option value="Asia/Yekaterinburg">(GMT+05:00) Yekaterinburg</option>
							   <option value="Asia/Karachi">(GMT+05:00) Islamabad, Karachi, Tashkent</option>
							   <option value="Asia/Calcutta">(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
							   <option value="Asia/Calcutta">(GMT+05:30) Sri Jayawardenapura</option>
							   <option value="Asia/Katmandu">(GMT+05:45) Kathmandu</option>
							   <option value="Asia/Almaty">(GMT+06:00) Almaty, Novosibirsk</option>
							   <option value="Asia/Dhaka">(GMT+06:00) Astana, Dhaka</option>
							   <option value="Asia/Rangoon">(GMT+06:30) Yangon (Rangoon)</option>
							   <option value="Asia/Bangkok">(GMT+07:00) Bangkok, Hanoi, Jakarta</option>
							   <option value="Asia/Krasnoyarsk">(GMT+07:00) Krasnoyarsk</option>
							   <option value="Asia/Hong_Kong">(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
							   <option value="Asia/Kuala_Lumpur">(GMT+08:00) Kuala Lumpur, Singapore</option>
							   <option value="Asia/Irkutsk">(GMT+08:00) Irkutsk, Ulaan Bataar</option>
							   <option value="Australia/Perth">(GMT+08:00) Perth</option>
							   <option value="Asia/Taipei">(GMT+08:00) Taipei</option>
							   <option value="Asia/Tokyo">(GMT+09:00) Osaka, Sapporo, Tokyo</option>
							   <option value="Asia/Seoul">(GMT+09:00) Seoul</option>
							   <option value="Asia/Yakutsk">(GMT+09:00) Yakutsk</option>
							   <option value="Australia/Adelaide">(GMT+09:30) Adelaide</option>
							   <option value="Australia/Darwin">(GMT+09:30) Darwin</option>
							   <option value="Australia/Brisbane">(GMT+10:00) Brisbane</option>
							   <option value="Australia/Canberra">(GMT+10:00) Canberra, Melbourne, Sydney</option>
							   <option value="Australia/Hobart">(GMT+10:00) Hobart</option>
							   <option value="Pacific/Guam">(GMT+10:00) Guam, Port Moresby</option>
							   <option value="Asia/Vladivostok">(GMT+10:00) Vladivostok</option>
							   <option value="Asia/Magadan">(GMT+11:00) Magadan, Solomon Is., New Caledonia</option>
							   <option value="Pacific/Auckland">(GMT+12:00) Auckland, Wellington</option>
							   <option value="Pacific/Fiji">(GMT+12:00) Fiji, Kamchatka, Marshall Is.</option>
							   <option value="Pacific/Tongatapu">(GMT+13:00) Nuku'alofa</option>
				  			</select>
				  		</div>
				  		<button class="btn btn-primary btn-md">Save</button>
				  	</form>
				  </div>
				</div>
				{{-- <div class="card two-factor mt-20" style="width: 100%" >
				  <div class="card-header">
				    Two-Factor Authentication
				  </div>
				  <div class="card-body">
				  	<p>
				  		This method provides an <a href="#">extra layer of security to your account</a>.
				  	</p>
				  	<p>
				  		Instead of immediately gaining access to the account by just entering the username and password, a second piece of information will be required to login. This way even if your login credentials are compromised, it will not be enough to access your Groundplan data.
				  	</p>
				  	<button class="btn btn-primary">Enable Two-Factor Authentication</button>
				  </div>
				</div> --}}
				<div class="card change-password mt-20 mb-20" style="width: 100%" >
				  <div class="card-header">
				    Change Password
				  </div>
				  <div class="card-body">
				  	@if($errors->any())
	  					@if($errors->first() == 'passupdated')
	  						<div class="alert alert-success">Password updated successfully.</div>
	  					@endif
	  					@if($errors->first() == 'oldpasserror')
	  						<div class="alert alert-danger">Invalid old password. Please try again!</div>
	  					@endif
	  				@endif
				  	<form action="{{route('user.changepassword')}}" method="POST">
				  	@csrf
				  		<div class="form-group">
				  			<label>Old Password</label>
				  			<input type="password" class="form-control" name="old" />
				  		</div>
				  		<div class="form-group">
				  			<label>New Password</label>
				  			<input type="password" class="form-control" name="new" id="newPassword" />
				  		</div>
				  		
				  		<div class="cautions">
				  			<ul>
				  				<li class="one">
				  					<i class="fa-sm" style="color:green;"></i>  
				  					<span>At least 8 characters</span>
				  				</li>
				  				<li class="two">
				  					<i class="fa-sm" style="color:green;"></i>  
				  					<span>Contains a number or symbol</span>
				  				</li>
				  				<li class="three">
				  					<i class="fa-sm" style="color:green;"></i>  
				  					<span>Cannot contain your name or email address</span>
				  				</li>
				  			</ul>
				  		</div>
				  		<button class="btn btn-primary btn-md" id="updatePass" disabled>Update Password</button>
				  	</form>
				  </div>
				</div>
	  		</div>
	  	</div>
  	</div>
  </section>


  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="fontawesome/js/all.min.js"></script>
  <script src="js/ajax.js"></script>
  <script>
  	var path = window.location.href; // because the 'href' property of the DOM element is the absolute path
     $('ul#navlinks a').each(function() {
      if (this.href === path) {
       $(this).addClass('active');
      }
     });
  	flag = 0;
  	$('#newPassword').keyup(function(){
  		var eightletters = /^(?=.*\d).{8,}$/;
  		if($('#newPassword').val().match(eightletters)) {
		    $('.one i').addClass('fa fa-check');
		  		flag == 1
				
		  } else {
		    $('.one i').removeClass('fa fa-check');
		    flag = 0;
		    
		}

		var number_symbol = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[^\w\s]).{8,}$/;
		if($('#newPassword').val().match(number_symbol)) {
		    $('.two i').addClass('fa fa-check');
		  	flag = 1;
		  	$("#updatePass").attr('disabled',false);
		  } else {
		    $('.two i').removeClass('fa fa-check');
		    flag = 0;
		    $("#updatePass").attr('disabled',true);
		}

		var email = $('#email').val();
		var name = $('#name').val();

		if($('#newPassword').val().match(email) || $('#newPassword').val().match(name)) {
		    $('.three i').removeClass('fa fa-check');
		  	flag = 0;
		  } else {
		    $('.three i').addClass('fa fa-check');
		    flag = 1;
		}
		
  	});
  </script>
</body>
</html>
