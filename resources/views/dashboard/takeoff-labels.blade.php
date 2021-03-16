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
				<div class="card profile" style="width: 100%; margin-bottom: 20px;" >
					<div class="card-header table--card--header">
				    	<span style="font-weight: 500;"> Take Off Labels</span>
						<span style="float:right">
    						<button id="add_status" class="btn btn-primary btn-sm" onclick="showDiv()"><i class="fas fa-plus"></i>&nbsp;&nbsp;New Label</button>
    					</span>
					</div>
	                <div class="card-body table--card--body">
		                	<table class="table table-responsive-md table-sm ">
							    <tbody>
							    	<?php $i=0; ?>
							    	@if($labels->count() > 0)
							    	@if ($labels_count == 1)
							    		@foreach ($labels as $labels)
							    			<tr>
								        		<td>
								        			<i style="
								        				color: {{$labels->color}};
								        			" class="fas fa-tag">
								        				
								        			</i>
								        			<b style="
								        				background-color: #ffffff;
								        				color: {{$labels->color}};
								        			">
								        				{{$labels->label}}
								        			</b>
								        		</td>
								        		<td id="categoryEditForm" class="statusEditForm_{{$i}}">
								        			<form action="{{ route('takeofflabel.update') }}" method="POST" class="categoryEditForm">
				  									@csrf
					  									<input type="text" name="label" value="{{$labels->label}}" class="renameSymbolsInput" placeholder="Enter Status">
					  									<select name="color" class="add--status--colors">
								        					<option class="color" selected disabled>Colors</option>
								        					<option class="color1" value="#333333">Black</option>
								        					<option class="color2" value="#34B27D">Green</option>
								        					<option class="color3" value="#DBDB57">Yellow</option>
								        					<option class="color4" value="#E09952">Orange</option>
								        					<option class="color5" value="#CB4D4D">Red</option>
								        					<option class="color6" value="#9933CC">Purple</option>
								        					<option class="color7" value="#4D77CB">Blue</option>
								        				</select>
					  									<button class="btn btn-primary btn-sm" value="{{$labels->id}}" name="id">Save</button>
				  									</form>
								        		</td>
								        		<td class="action--td">	
								        			<button class="no-bg" style="color:#337AB7;" onclick="statusEdit({{$i}})" data-uniqe="{{$i}}">	<i class="fas fa-pen"></i>&nbsp;Edit
								        			</button>
								        			<a href="/setup/takeofflabel/delete/{{$labels->id}}" class="dis--remove disabled"><i class="fas fa-times"></i>&nbsp;Remove</a>
								        		</td>
								    		</tr>
								    		<?php $i++; ?>
								    	@endforeach
							    	@else
							    		@foreach ($labels as $labels)
								    		<tr>
								        		<td>
								        			<i style="
								        				color: {{$labels->color}};
								        			" class="fas fa-tag">
								        				
								        			</i>
								        			<b style="
								        				background-color: #ffffff;
								        				color: {{$labels->color}};
								        			">
								        				{{$labels->label}}
								        			</b>
								        		</td>
								        		<td id="categoryEditForm" class="statusEditForm_{{$i}}">
								        			<form action="{{ route('takeofflabel.update') }}" method="POST" class="categoryEditForm">
				  									@csrf
					  									<input type="text" name="label" value="{{$labels->label}}" class="renameSymbolsInput" placeholder="Enter Status">
					  									<select name="color" class="add--status--colors">
								        					<option class="color" selected disabled>Colors</option>
								        					<option class="color1" value="#333333">Black</option>
								        					<option class="color2" value="#34B27D">Green</option>
								        					<option class="color3" value="#DBDB57">Yellow</option>
								        					<option class="color4" value="#E09952">Orange</option>
								        					<option class="color5" value="#CB4D4D">Red</option>
								        					<option class="color6" value="#9933CC">Purple</option>
								        					<option class="color7" value="#4D77CB">Blue</option>
								        				</select>
					  									<button class="btn btn-primary btn-sm" value="{{$labels->id}}" name="id">Save</button>
				  									</form>
								        		</td>
								        		<td class="action--td">	
								        			<button class="no-bg" style="color:#337AB7;" onclick="sort({{$labels->id}},'UP')"><i class="fas fa-arrow-up"></i></button>
							        				<button class="no-bg" style="color:#337AB7;" onclick="sort({{$labels->id}},'DOWN')"><i class="fas fa-arrow-down"></i></button>
								        			<button class="no-bg" style="color:#337AB7;" onclick="statusEdit({{$i}})" data-uniqe="{{$i}}">	<i class="fas fa-pen"></i>&nbsp;Edit
								        			</button>
								        			<a href="/setup/takeofflabel/delete/{{$labels->id}}"><i class="fas fa-times"></i>&nbsp;Remove</a>
								        		</td>
								    		</tr>
								    		<?php $i++; ?>
								    	@endforeach
							    	@endif					    	
								    @else
								    	<div class="alert alert-info" style="margin-top:10px;">No record found.</div>
								    @endif
								    @error('label')
								        <p style="margin-top:10px;margin-left:15px;font-size:15px;" class="text-danger">*{{$message}}</p>
								    @enderror
								    @error('user_id')
								       <p style="margin-top:10px;margin-left:15px;font-size:15px;" class="text-danger">Please refresh and try again!</p>
								    @enderror
								    <form action="{{route('label.add')}}" method="POST">
						    			<tr id="tableformdiv" style="display: none;">
							    			@csrf
							    			<td>
							        			<div class="">
							        				<input type="text" class="form-control form-input-sm" name="label" placeholder="New Status">
							        				<input type="text" class="form-control form-input-sm" name="user_id" style="display: none;" value="{{$user[0]->id}}">
							        			</div>
							        		</td>
							        		<td>
						        				<select name="color" class="add--status--colors">
						        					<option class="color" selected disabled>Colors</option>
						        					<option class="color1" value="#333333">Black</option>
						        					<option class="color2" value="#34B27D">Green</option>
						        					<option class="color3" value="#DBDB57">Yellow</option>
						        					<option class="color4" value="#E09952">Orange</option>
						        					<option class="color5" value="#CB4D4D">Red</option>
						        					<option class="color6" value="#9933CC">Purple</option>
						        					<option class="color7" value="#4D77CB">Blue</option>
						        				</select>
							        		</td>
							        		<td>
							        			<button type="submit" class="btn btn-sm btn-primary" name="add_status">
							        				Add
							        			</button>
							        			<a href="/setup/takeoff-label" class="btn btn-sm btn-default">
							        				Cancel
							        			</a>
							        		</td>
							    		</tr>	
							    	</form>	
							    </tbody>
							 </table>
					        
					        <script type="text/javascript">
					        	function showDiv() {
								   document.getElementById('tableformdiv').style.display = "block";
								}
					        </script>
		            </div>
				</div>
	  		</div>
	  	</div>
  	</div>
  </section>
  <section>
  	    
  </section>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="fontawesome/js/all.min.js"></script>
  <script src="js/ajax.js"></script>
  <script type="text/javascript">
  	var path = window.location.href; // because the 'href' property of the DOM element is the absolute path
     $('ul#navlinks a').each(function() {
      if (this.href === path) {
       $(this).addClass('active');
      }
     });
  	function statusEdit(id)
	{
		$(".statusEditForm_"+id).toggle();
	}
	function sort(id, flag){
		$.ajax({
			url: "{{route('takeofflabels.sort')}}",
			type:"POST",
			data:{"_token": "{{ csrf_token() }}", id:id,flag:flag},
			success: function(res){
				console.log(res);
			}
		});
		window.open('/setup/takeoff-label','_self');
	}
  </script>
</body>
</html>





