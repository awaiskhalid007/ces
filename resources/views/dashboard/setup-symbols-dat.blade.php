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
<body class="symbolsPage">

  @include('dashboard.partials.header')

  <section id="wrapper">
  	<div class="col-md-12">
	  	<div class="row">
	  		@include('dashboard.partials.setting-sidebar')
	  		<div class="col-lg-9 rightpanel">
	  			<div class="errors">
	  				@if($errors->any())
	  					@if($errors->first() == 'categoryupdated')
		  					<div class="alert alert-success">
		  						Category updated successfully.
		  					</div>
	  					@endif
	  				@endif
	  			</div>
	  			<div class="alert" style="background: #f7f7f7;">
	  				<div class="row">
	  					<div class="col-md-6">
	  						<button class="btn" data-toggle="modal" data-target="#addCategoryModal" style="background: #fff;">
	  							<i class="fa fa-table"></i>
	  							Add a Category
	  						</button>
	  						<button class="btn" style="background: #fff;">
	  							<i class="fa fa-plus-square"></i>
	  							Add a Symbol Pack
	  						</button>
	  					</div>
	  					<div class="col-md-6"></div>
	  				</div>
	  			</div>

	  			<section class="general">
	  				<div class="col-md-12">
	  					<div class="row">
		  					<div class="col-md-6">
		  						<div class="row">
		  							<h3 class="heading">Generic</h3>
		  							<i class="fa fa-caret-square-down dropsymbol"></i>
		  						</div>
		  					</div>
		  					<div class="col-md-6 text-right">
		  						<span class="categorytag">
		  							<i class="fa fa-lock"></i>
			  						Symbol Pack
			  					</span>
		  					</div>
	  					</div>
	  					<hr>
	  					<div class="row" id="pack_div">
	  						<div class="col-md-2">
	  							<div class="card">
	  								<img src="img/symbols/generic/1.png" class="img-fluid" />
	  								<div class="info text-center">
	  									<p class="name">Bolt</p>
	  									<p class="category">generic</p>
	  								</div>
	  							</div>
	  						</div>
	  					</div>
	  				</div>
	  			</section>

	  			@if(!$categories->isEmpty())
	  			<?php $i=0; ?>
	  			@foreach($packs as $pack)
	  			<?php $i++; ?>
		  			<section class="general" style="margin-top:40px;">
		  				<div class="col-md-12">
		  					<div class="row">
			  					<div class="col-md-9">
			  						<div class="row" >
			  							<h3 class="heading">
			  								{{$pack['name']}}
			  							</h3>
				  						<div class="row" id="editable" style="margin-left:5px;">
				  							<div style="margin-right:8px;margin-top:8px;display: flex;" >
				  								<form action="{{route('category.edit')}}" method="POST" id="categoryEditForm" class="categoryEditForm_{{$i}}">
				  									@csrf
				  									<input type="text" name="name" value="{{$pack['name']}}" class="renameSymbolsInput" placeholder="Category Name">
				  									<button class="btn btn-primary btn-sm" value="{{$pack['id']}}" name="id">Save</button>
				  								</form>
				  								<button class="edits no-bg" id="openEditForm" onclick="categoryEdit({{$i}})" data-uniqe="{{$i}}">
					  								<i class="fa-pencil-alt fa dropsymbol"></i>
				  								</button>
				  							</div>
				  						</div>
				  						<div style="margin-top:8px;margin-left:14px;">
				  							<form action="{{route('category.delete')}}" method="POST">
				  							@csrf
				  								<button class="edits no-bg" value="{{$pack['id']}}" name="id">
				  								<i class="fa-trash-alt fa dropsymbol"></i>
						  						</button>
											</form>
				  						</div>
			  						</div>
			  					</div>
			  					<div class="col-md-3 text-right">
			  						<button style="font-size: 14px;background: none;border: none;outline:none;box-shadow: none;" id="uploadSymbol" data-toggle="modal" data-target="#addSymbolModal" >
			  							<i class="fa fa-upload"></i>
				  						Upload Symbols
				  					</button>
			  					</div>
		  					</div>
		  					<hr>
		  					<div class="row">
		  						@foreach($pack['symbols'] as $pic)
		  						<div class="col-md-2">
		  							<div class="card">
		  								<img src="img/symbols/{{$pic->image}}" class="img-fluid" />
		  								<div class="info text-center">
		  									<p class="name">{{$pic->name}}</p>
		  								</div>
		  							</div>
		  						</div>
		  						@endforeach
		  					</div>
		  				</div>
		  			</section>
	  			@endforeach
				@endif
	  		</div>
	  	</div>
  	</div>
  </section>


<!-- Modals -->
{{-- Add Category Modal --}}
<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
  	
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <form action="{{route('symbol.category.add')}}" method="POST">
          @csrf
	      <div class="modal-body">
	        	<div class="form-group">
	        		<label for="name">Category name</label>
	        		<input type="text" name="name" id="name" class="form-control" />
	        	</div>
	      </div>
	      <div class="modal-footer">
	        <button class="btn btn-primary" >Save</button>
	      </div>
	  	  </form>
	    </div>
  </div>
</div>
{{-- Add Icon Modal --}}
<div class="modal fade" id="addSymbolModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
  	
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Add Symbol</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <form action="{{route('symbol.add')}}" method="POST" enctype="multipart/form-data">
          @csrf
	      <div class="modal-body">
	        	<div class="form-group">
	        		<label for="name">Choose Symbol</label>
	        		<input type="file" name="file" id="file" class="form-control" />
	        	</div>
	        	<div class="form-group">
	        		<label for="name">Choose Category</label>
	        		<select name="category" id="category" class="form-control">
	        			<option disabled selected>Choose a category</option>
	        			@if(!$categories->isEmpty())
	        			 @foreach($categories as $category)
	        			   <option value="{{$category->id}}">{{$category->name}}</option>
	        			 @endforeach
	        			@else

	        			@endif
	        		</select>
	        	</div>
	      </div>
	      <div class="modal-footer">
	        <button class="btn btn-primary">Save</button>
	      </div>
	  	  </form>
	    </div>
  </div>
</div>


  {{-- Scripts --}}
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="fontawesome/js/all.min.js"></script>
  <script src="js/ajax.js"></script>
  <script src="js/fonts/generic.js"></script>
  <script>
  	var path = window.location.href; // because the 'href' property of the DOM element is the absolute path
     $('ul#navlinks a').each(function() {
      if (this.href === path) {
       $(this).addClass('active');
      }
     });
  	$(function() {

	    var bar = $('.progress-bar');
	    var percent = $('.percent');
	    var status = $('#status');	

	    $('#uploadSymbol').click(function(e){
	    	e.preventDefault();
	    	$('#select_symbol').click();

	    	$("#select_symbol").on('change', function(){
	    		$("form#symbols").submit();
	    	});

	    	$("form#symbols").on('submit', function(event){
    			event.preventDefault();
	    		$.ajax({
	    			
	    			url: "{{ route('symbol.add') }}",
	    			type: 'POST',
	    			data:new FormData(this),
				    dataType:'JSON',
				    contentType: false,
				    cache: false,
				    processData: false,
	    			beforeSend: function(){
	    				console.log('sending');
	    			},
	    			success: function(response){
	    				console.log(response);
	    			}
	    		});
    		});
	    });

	    $('form').ajaxForm({
	        beforeSend: function() {
	            status.empty();
	            var percentVal = '0%';
	            bar.width(percentVal);
	            percent.html(percentVal);
	        },
	        uploadProgress: function(event, position, total, percentComplete) {
	            var percentVal = percentComplete + '%';
	            bar.width(percentVal);
	            percent.html(percentVal);
	        },
	        complete: function(xhr) {
	            status.html(xhr.responseText);
	        }
	    });
	});

	function categoryEdit(id)
	{
		$(".categoryEditForm_"+id).toggle();
	}
	let html = '';
	allFonts.forEach( function(element, index) {
		html += '<div class="col-md-2"><div class="card" style="text-align:center;"><div class="text-center"><i class="fa '+element.c+' fa-3x"></i></div><div class="info text-center"><p class="name">'+element.l+'</p><p class="category">generic</p></div></div></div>'
	});

	$("#pack_div").html(html);
  </script>
</body>
</html>
