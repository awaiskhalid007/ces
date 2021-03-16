<!DOCTYPE html>
<html lang="en">
<head>
	<base href="/">
	<meta charset="UTF-8">
	<meta name="csrf" content="{{csrf_token()}}">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Symbols</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel='stylesheet' href='css/style.css' type='text/css' />
    <link rel='stylesheet' href='fontawesome/css/all.min.css' type='text/css' />
    <script type="text/javascript" src="js/jquery.min.js"></script>
  	<script src="js/fonts/generic.js"></script>
  	<script src="js/fonts/arrows.js"></script>
    <script>
    	function loadSymbols(div, pack)
		{
			let html = '';

			if(pack == 'generic')
			{
				GENERIC.forEach( function(element, index) {
					html += '<div class="col-md-2"><div class="card" style="text-align:center;"><div class="text-center"><i class="fa '+element.c+' fa-3x"></i></div><div class="info text-center"><p class="name">'+element.l+'</p><p class="category">generic</p></div></div></div>'
				});
				$('#' + div).html(html);
			}else if(pack == 'arrows')
			{
				ARROWS.forEach( function(element, index) {
					html += '<div class="col-md-2"><div class="card" style="text-align:center;"><div class="text-center"><i class="fa '+element.c+' fa-3x"></i></div><div class="info text-center"><p class="name">'+element.l+'</p><p class="category">generic</p></div></div></div>'
				});
				$('#' + div).html(html);
			}
		}
    </script>
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
	  						<button class="btn" data-toggle="modal" data-target="#addSymbolPackModal" style="background: #fff;">
	  							<i class="fa fa-plus-square"></i>
	  							Add a Symbol Pack
	  						</button>
	  					</div>
	  					<div class="col-md-6"></div>
	  				</div>
	  			</div>

	  			@if(!empty($data))
	  			<?php $i=0; ?>
	  			@foreach($data as $obj)
	  			<?php $i++; ?>
		  			{{-- @if($obj['pack'] != null) --}}
		  			<section class="general" id="iconsPageDiv" style="margin-top:40px;">
		  				<div class="col-md-12">
		  					<div class="row">
			  					<div class="col-md-9">
			  						<div class="row" >
			  							<h3 class="heading">
			  								{{$obj['name']}}
			  							</h3>
				  						<div class="row" id="editable" style="margin-left:5px;">
				  							<div style="margin-right:8px;margin-top:8px;display: flex;" >
				  								<form action="{{route('category.edit')}}" method="POST" id="categoryEditForm" class="categoryEditForm_{{$i}}">
				  									@csrf
				  									<input type="text" name="name" value="{{$obj['name']}}" class="renameSymbolsInput" placeholder="Category Name">
				  									<button class="btn btn-primary btn-sm" value="{{$obj['id']}}" name="id">Save</button>
				  								</form>
				  								<button class="edits no-bg" id="openEditForm" onclick="categoryEdit({{$i}})" data-uniqe="{{$i}}">
					  								<i class="fa-pencil-alt fa dropsymbol"></i>
				  								</button>
				  							</div>
				  						</div>
				  						<div style="margin-top:8px;margin-left:14px;">
				  							<form action="{{route('category.delete')}}" method="POST">
				  							@csrf
				  								<button class="edits no-bg" value="{{$obj['id']}}" name="id">
				  								<i class="fa-trash-alt fa dropsymbol"></i>
						  						</button>
											</form>
				  						</div>
			  						</div>
			  					</div>
			  					<div class="col-md-3 text-right" style="padding-top: 10px!important;">
			  						@if($obj['pack'] != null || $obj['pack'] != '')
			  							<span class="categorytag">
				  							<i class="fa fa-lock"></i>
					  						Symbol Pack
					  					</span>
					  				@else
				  						<button style="font-size: 14px;background: none;border: none;outline:none;box-shadow: none;margin-top:10px;" id="uploadSymbol" onclick="addSymbolCategory('{{$obj['id']}}')" >
				  							<i class="fa fa-upload"></i>
					  						Upload Symbols
					  					</button>
					  				@endif
			  					</div>
		  					</div>
		  					<hr>
		  					<div class="row"  id="pack-{{$obj['id']}}">
		  					</div>
		  					@if($obj['pack'] != null || $obj['pack'] != '')
		  					<script>
		  						loadSymbols('pack-{{$obj['id']}}','{{$obj['pack']}}');
		  					</script>
		  					@else
	  						<div class="row">
	  						@foreach($obj['symbols'] as $pic)
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
		  					@endif
		  				</div>
		  			</section>
		  			{{-- @endif --}}
	  			@endforeach
	  			@else
	  				<div class="jumbotron">
	  					<div class="text-center">
	  						<i class="fa fa-spider fa-4x" style="color: #999;margin-bottom: 13px;"></i>
	  						<h4 style="color: #999;font-weight: 600;">No symbols or categories found!</h4>
	  					</div>
	  				</div>
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
{{-- Add Single Symbol Modal --}}
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
	        		<input type="hidden" id="id" name="category" />
	        	</div>
	      </div>
	      <div class="modal-footer">
	        <button class="btn btn-primary">Save</button>
	      </div>
	  	  </form>
	    </div>
  </div>
</div>
{{-- Add Symbol Pack Modal --}}
<div class="modal fade" id="addSymbolPackModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width: 700px!important;">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Add a Symbol Pack</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
        	<div class="form-group">
        		<label for="name">Select Symbol Pack</label>
        		<select name="selectedPack" id="selectedPack" class="form-control">
        			<option disabled class="disabledPackTitles">Available Packs</option>
        			@if(!empty($available_packs))
        			@foreach($available_packs as $a)
        			<option value="{{$a['pack']}}">{{$a['name']}}</option>
        			@endforeach
        			@endif
        			@if(!$packs->isEmpty())
        			<option disabled class="disabledPackTitles">Installed Packs</option>
        			@foreach($packs as $p)
        			<option disabled>{{$p->name}}</option>
        			@endforeach
        			@endif
        		</select>
        	</div>
	        <div class="row" id="modalSymbols">
	        	
	        </div>	
	      </div>
	      <div class="modal-footer">
	        <button class="btn btn-primary" id="installSymbol">Install</button>
	        <button class="btn btn-default bg-grey" data-dismiss="modal" aria-label="Close">Close</button>
	      </div>
	    </div>
  </div>
</div>


  {{-- Scripts --}}
  
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
	async function get_generic_symbols_for_modal()
	{
		let html = '';
		let len = GENERIC.length;
		if(len > 35)
		{
			len = 35;
		}
		for(var i=0; i<len;i++){
			html += '<div class="col-md-2"><div class="symbolsModalCard" style="text-align:center;"><i class="fa '+GENERIC[i].c+' fa-3x"></i></div></div>'
		}
		$('#modalSymbols').html(html);
	}
	get_generic_symbols_for_modal();


	$("#selectedPack").on('change', function(){
		let val = $("#selectedPack").val();
		let html = '';
		if(val == 'generic')
		{
			let len = GENERIC.length;
			if(len > 35)
			{
				len = 35;
			}
			for(var i=0; i<len;i++){
			html += '<div class="col-md-2"><div class="" style="text-align:center;"><i class="fa '+GENERIC[i].c+' fa-3x"></i></div></div>'
			}
			$('#modalSymbols').html(html);
		}else if(val == 'arrows'){

			let len = ARROWS.length;
			if(len > 35)
			{
				len = 35;
			}
			for(var i=0; i<len;i++){
			html += '<div class="col-md-2"><div class="" style="text-align:center;"><i class="fa '+ARROWS[i].c+' fa-3x"></i></div></div>'
			}
			$('#modalSymbols').html(html);
		}
	});
	$("#installSymbol").click(function(){
		let val = $("#selectedPack").val();
		let csrf = $("meta[name='csrf']").attr('content');

		$("#installSymbol").prop('disabled', true);

		$.ajax({
			type: 'POST',
			url: '/symbols/pack/install',
			data: {_token: csrf, val:val},
			success: function(res)
			{
				$("#installSymbol").prop('disabled', false);
				$("#addSymbolPackModal").modal('hide');
				location.reload();
			}
		})
	});
	function addSymbolCategory(id)
	{
		$("#addSymbolModal input#id").val(id);
		$("#addSymbolModal").modal('show');
	}
  </script>
</body>
</html>
