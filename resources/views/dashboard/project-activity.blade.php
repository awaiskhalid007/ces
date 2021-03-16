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
                <h3>Activity</h3>
              </div>
            </div>
            <hr>
            <div class="col-md-12">
              {{-- <div class="row">
                <div class="ml-auto">
                  <div class="input-group">
                    <input type="date" class="form-control" aria-describedby="basic-addon1" style="margin-right: 30px;">
                    <span class="input-group-text" id="basic-addon1">
                      <button class="activity-date-button">
                        <i class="fas fa-search"></i>
                      </button>
                    </span>
                  </div>
                </div>
              </div> --}}
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th class="text-left" style="border-top: none!important;">Action</th>
                    <th class="text-right" style="border-top: none!important;">When &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                  </tr>
                </thead>
                <tbody>
                 {{--  <tr>
                    <td></td>
                    <td class="text-right"><b>23/02/2021 &nbsp;&nbsp;&nbsp;</b></td>
                  </tr> --}}
                  @if(!$activities->isEmpty())
                  @foreach($activities as $a)
                    <tr>
                      <td class="text-left"><b>{{$username}}</b> - {{$a->message}}</td>
                      <td class="text-right"><?php echo  date('d M,Y h:i A', strtotime($a->created_at)); ?> &nbsp;&nbsp;&nbsp;</td>
                    </tr>
                  @endforeach
                  @else
                    <tr>
                      <td colspan="2" class="text-center">No data to show</td>
                    </tr>
                  @endif
                 
                </tbody>
              </table>
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
</body>
</html>
 