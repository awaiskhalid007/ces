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
				    User Activity
				  </div>
				  <div class="card-body">
				  	<table class="table borderless table-sm">
				  		<thead>
				  			<tr>
				  				<th class="text-left">Action</th>
				  				<th class="text-right">When</th>
				  			</tr>
				  		</thead>
				  		<tbody>
				  			@foreach ($activities as $activity)
					  			<tr>
					  				<td><b>Groundplan Team: </b>{{$activity->message}}</td>
					  				<td class="text-right">
					  				@php
					  					$activity_date = date('d-m-Y', strtotime($activity->created_at));	
					  				@endphp
					  				{{$activity_date}}
					  				</td>
					  			</tr>
					  		@endforeach
				  		</tbody>
				  	</table>
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
  </script>
</body>
</html>
