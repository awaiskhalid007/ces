 <header>
 	<input type="hidden" id="current_session_id" value="{{$sessionData[0]->id}}">
 	<input type="hidden" id="current_session_csrf" value="{{csrf_token()}}">
  	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	  <div class="container">
	  	<a class="navbar-brand" href="/projects/open">
	  		{{-- <img src="img/logo-white.png" class="img-fluid logo" /> --}}
	  		<h1 class="slim" style="font-size: 20px;color: #fff!important;font-weight: 600;">
	  			<img src="img/symbol.png" class="img-fluid" style="width: 50px;" />
	  		</h1>
	  	</a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		  </button>

		  <div class="collapse navbar-collapse" id="navbarSupportedContent">
		    <ul class="navbar-nav mr-auto pane">
		      <li class="nav-item dropdown btnli">
		        <a class="btn btn-primary btn-sm dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		          New
		        </a>
		        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
		          <a class="dropdown-item" href="/projects/create">Project</a>
		          <a class="dropdown-item" data-toggle="modal" data-target="#add_template_modal">Project Template</a>
		          <a class="dropdown-item" data-toggle="modal" data-target="#add_takeoff_template_modal">Take-Off Template</a>
		        </div>
		      </li>
		      <li class="nav-item">
		      	<a href="/projects/open" class="nav-link">Projects</a>
		      </li>
		      <li class="nav-item dropdown">
		        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		          Recent
		        </a>
		        <div class="dropdown-menu" id="recently_viewed_projects_div" aria-labelledby="navbarDropdown">
		          <a class="dropdown-item"><b>Viewed Projects</b></a>
		        </div>
		      </li>
		      <li id="headerUploadsButton">
		      	<a class="nav-item">
		      		<a class="nav-link" style="cursor: pointer;">
		      			Uploaded
		      			<span class="badge badge-success">0</span>
		      		</a>
		      	</a>
		      </li>
		    </ul>
		    <ul class="navbar-nav ml-auto pane">
		    	<li class="nav-item dropdown">
		    		<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">My Account</a>
			        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
			          <p class="dropdown-item" disabled>{{$sessionData[0]->name}}</p>
			          <a class="dropdown-item" href="/setup/profile"><i class="fa fa-cog"></i> &nbsp;Setup</a>
			          <form action="{{route('user.logout')}}" method="POST">
			          	@csrf
			          	<button class="dropdown-item btn"><i class="fa fa-chevron-right"></i> &nbsp;Logout</a>
			          </form>
			        </div>
		    	</li>
		    	<li class="nav-item dropdown">
		    		<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Help</a>
			        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
			            
			          <a href="javascript::void(0)" class="dropdown-item">
			          	<i class="fa fa-keyboard"></i> Shortcut Keys
			          </a>
			          <a class="dropdown-item" href="javascript::void(0)">Send us a message</a>
			         
			        </div>
		    	</li>
		    </ul>
		  </div>
	  </div>
	</nav>
 </header>


{{-- Create Template Modal --}}
<div class="modal fade" id="add_template_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form action="{{route('template.add')}}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Create Project Template</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <b>Template Name</b>
          <input type="text" name="name" class="form-control">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </form>
  </div>
</div>
{{-- Create Take-Off Template Modal --}}
<div class="modal fade" id="add_takeoff_template_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form action="{{route('takeoff-template.add')}}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Create Project Template</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <b>Template Name</b>
          <input type="text" name="name" class="form-control">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </form>
  </div>
</div>

<div id="uploader-container">
   <div class="uploader-container-title">
      <div class="btn-group pull-right">
         <button class="btn btn-sm btn-link no-bg" id="close" style="margin-top: 0px;"><i class="fa fa-times"></i> <span>Close</span></button>
      </div>
      <div class="btn-group pull-right">
         <form action="{{route('uploads.delete')}}" method="POST">
         	@csrf
         	<button class="btn btn-sm btn-link" data-action="clearCompletedUploads"><i class="fa fa-eraser"></i> <span>Clear Finished</span></button>
         </form>
      </div>
      <h1 style="margin-top: 4px;">Uploaded <span id="UploadedCount" class="badge badge-success">0</span></h1>
      <div class="clearfix"></div>
   </div>
   <div class="uploader-container-body">
      <table class="queue-list table-striped hidden-xs">
         <colgroup>
            <col style="width: 45%">
            <col style="width: 30%">
            <col style="width: 25%">
         </colgroup>
         <tbody>
           
         </tbody>
      </table>
   </div>
</div>