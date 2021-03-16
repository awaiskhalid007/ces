<!DOCTYPE html>
<html lang="en">
<head>
	<base href="/">
	<meta charset="UTF-8">
  <meta name="csrf-token" content="{{csrf_token()}}">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Projects</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel='stylesheet' href='css/style.css' type='text/css' />
  <link rel='stylesheet' href='css/dropzone.css' type='text/css' />
  <link rel='stylesheet' href='css/basic.css' type='text/css' />
  <link rel='stylesheet' href='fontawesome/css/all.min.css' type='text/css' />
</head>
<body class="projectPage">

  @include('dashboard.partials.header')
  <div class="container-fluid">
    <div class="nav-create--1">
      <label for="">PROJECT</label>
      <h5>{{$project_name}}</h5>
    </div>
    <section class="projects_tabs">
      <div class="container">
        @include('dashboard.partials.bottom-header')
      </div>
    </section>
    <div class="container">
      <div class="row">
          <div class="col-lg-2">
            @include('dashboard.partials.project-sidebar')
          </div>
          <div class="col-lg-10 add-details-div">
            <div class="row add-detail-heading--row">
              <div class="add-detail-heading mr-auto">
                <h3>Attachments</h3>
              </div>
              <div class="ml-auto">
                <button type="button" class="btn btn-primary" id="openFile">
                  <i class="fas fa-plus"></i>&nbsp; Attachments
                </button>
              </div>
            </div>
            <hr>
            <div class="col-md-12">
              <table class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th></th>
                    <th>Name</th>
                    <th>Date Uploaded</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody id="attachs">
                 
                </tbody>
              </table>
            </div>
            <div>
              <div class="col-md-12 text-center">
                <form action="{{url('/projects/attachment/upload')}}" method="POST" enctype="multipart/form-data" class="dropzone" id="dropzone">
                  @csrf
                  <img src="img/drag.png" class="img-fluid" />
                  <input name="id" type="hidden" value="{{$project_id}}" />
                  <div class="fallback">
                    
                    <input name="file" type="file" multiple />
                  </div>
                  <p id="file_error" style="color: red;"></p>
                </form>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>



  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/popper.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/dropzone.js"></script>
  <script src="js/ajax.js"></script>
  <script type="text/javascript" src="fontawesome/js/all.min.js"></script>
  <script>
      var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
      var project_id = $('#dropzone input[name="id"]').val();
      function fetchAttachments()
      {
        $.ajax({
          type: 'POST',
          url: '/projects/attachment/fetch',
          data: {_token: CSRF_TOKEN, project_id: project_id},
          success: function(res)
          {
            console.log(res)
            $("#attachs").html(res);
          }
        });
      }
      $(document).ready(function(){
        fetchAttachments();
        $("#openFile").click(function(){
          $("#dropzone").click();
        });
      });
      
      Dropzone.options.dropzone =
      {
        maxFilesize: 25,
        acceptedFiles: ".jpeg,.jpg,.png,.gif,.pdf,.csv",
        addRemoveLinks: true,
        timeout: 5000,
        success: function(file, response) 
        {
          fetchAttachments();
          console.log(response);

        },
        error: function(file, response)
        {
           $("#file_error").html(response);
        }
      };
  </script>
</body>
</html>
 