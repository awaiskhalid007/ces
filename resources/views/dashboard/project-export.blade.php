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
                <h3>Exports</h3>
              </div>
            </div>
            <hr>
            <div class="col-md-12">
              <div class="row">
                <div class="exports--div container-fluid">
                  <button class="export--plans--btn" data-toggle="modal" data-target="#exampleModal">
                    <i class="fas fa-arrow-circle-down"></i> Export Plans
                  </button>
                </div>
              </div>
              <table class="table table-hover table-sm borderless">
                <thead>
                  <tr>
                    <th>Plans</th>
                    <th>Date</th>
                    <th>User</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
    </div>
  </div>

{{-- Export Model --}}
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Export Plans</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Plans are exported in PDF format with all markup, measurements and annotations included. A separate legend in A4 is also provided for each plan.</p>
        <div class="form-group">
          <label for=""><b>Select Plan:</b></label>
          <select name="" class="form-control" id="">
            <option value="">Plan 1</option>
          </select>  
        </div>
        <div class="export-stages-div" style="padding-bottom: 15px; margin-bottom: 15px; border-bottom: 1px solid #DEE2E6;">
          <div class="form-check">
            <label class="form-check-label">
              <input type="radio" class="form-check-input" name="stages" value="asd" onclick="show1();">Include all stages
            </label>
          </div>
          <div class="form-check">
            <label class="form-check-label">
              <input type="radio" class="form-check-input" name="stages" value="asd" onclick="show2();">Only include selected stages
            </label>
          </div>
          <div class="form-group select-stage">
            <label for=""><b>Select Stages:</b></label>
            <select name="" class="form-control" id="">
              <option value="">Stage 1</option>
            </select>  
          </div>
        </div>
        <div>
          <div class="form-check">
            <label class="form-check-label">
              <input type="radio" class="form-check-input" name="optradio">Create one PDF file per plan (better for digital use)
            </label>
          </div>
          <div class="form-check">
            <label class="form-check-label">
              <input type="radio" class="form-check-input" name="optradio">Create one PDF file per group (better for printing)
            </label>
          </div>
        </div>
      </div>
        
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
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
    function show1(){
      document.getElementById('select-stage').style.display ='none';
    }
    function show2(){
      document.getElementById('select-stage').style.display = 'block';
    }
  </script>
</body>
</html>
 