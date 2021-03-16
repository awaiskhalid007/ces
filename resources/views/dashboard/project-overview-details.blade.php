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
<body class="projectPage">

  @include('dashboard.partials.header')
  <div class="container-fluid">
    <div class="nav-create--1">
      <label for="">PROJECT</label>
      <h5>{{$data["project"][0]->name}}</h5>
    </div>
    <section class="projects_tabs">
      <div class="container">
        @include('dashboard.partials.bottom-header')
      </div>
    </section>
    <div class="container">
      <div class="row">
        {{-- Sidebar Start--}}
        <div class="col-lg-2">
            @include('dashboard.partials.project-sidebar')
        </div>
        {{-- Sidebar End--}}
        <div class="col-lg-7 add-details-div">
          <div class="row add-detail-heading--row" style="border-bottom: 1px solid #eee;">
            <div class="add-detail-heading mr-auto">
              <h3>Project Details</h3>
            </div>
            <div class="ml-auto">
              <a href="/projects/{{$data['project'][0]->salt}}/overview/details/edit">EDIT</a>
            </div>
          </div>
          <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label text-right label-details-edit">Name</label>
            <div class="col-sm-10">
              <a href="/projects/{{$data['project'][0]->salt}}/overview/details/edit" class="text-dark a-details-edit opt1">{{$data['project'][0]->name}}</a>
              <a href="/projects/{{$data['project'][0]->salt}}/overview/details/edit" class="pen icon1">&nbsp;<i class="fas fa-pen"></i></a>
            </div>
          </div>
          <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label text-right label-details-edit">Description</label>
            <div class="col-sm-10">
              @if($data['project'][0]->description != "")
              <a href="/projects/{{$data['project'][0]->salt}}/overview/details/edit" class="text-dark a-details-edit opt2">
                <?php echo substr($data['project'][0]->description,0, 150).'...'; ?>
              </a>
              @else
              <a href="/projects/{{$data['project'][0]->salt}}/overview/details/edit" class="text-muted a-details-edit opt2">
                <i>Click to add description</i>
              </a>
              @endif
              </a>
              <a href="/projects/{{$data['project'][0]->salt}}/overview/details/edit" class="pen icon2">&nbsp;<i class="fas fa-pen"></i></a>
            </div>
          </div>
          <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label text-right label-details-edit">Client</label>
            <div class="col-sm-10">
              @if($data['project'][0]->client != "")
                <a href="/projects/{{$data['project'][0]->salt}}/overview/details/edit" class="text-dark a-details-edit opt3" >
                  {{$data['project'][0]->client}}
                </a>
              @else
                <a href="/projects/{{$data['project'][0]->salt}}/overview/details/edit" class="text-muted a-details-edit opt3">
                  <i>Click to add client name</i>
                </a>
              @endif
              <a href="/projects/{{$data['project'][0]->salt}}/overview/details/edit" class="pen icon3">&nbsp;<i class="fas fa-pen"></i></a>
            </div>
          </div>
          <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label text-right label-details-edit-status">Status</label>
            <div class="col-sm-10">
              @if($data['project'][0]->status_id != null)
                @if($data['project'][0]->status == 1)
                  <a href="/projects/{{$data['project'][0]->salt}}/overview/details/edit" class="btn btn-sm a-details-edit opt4" style="border:1px solid {{$data['status']->color}};color:{{$data['status']->color}};">
                    {{$data['status']->status}}
                  </a>
                @elseif($data['project'][0]->status == 2)
                  @if($data['reason'] != 'undefined')
                    <a class="btn btn-sm a-details-edit opt4" style="border:1px solid {{$data['reason']->color}};color:{{$data['reason']->color}};">
                      {{$data['reason']->reason}}
                    </a>
                  @endif
                @endif
              @else
                <a href="/projects/{{$data['project'][0]->salt}}/overview/details/edit" class="text-muted a-details-edit opt4">
                  <i>Click to change status</i>
                </a>
              @endif
              <a href="/projects/{{$data['project'][0]->salt}}/overview/details/edit" class="pen icon4">&nbsp;<i class="fas fa-pen"></i></a>
            </div>
          </div>
          <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label text-right label-details-edit">Labels</label>
            <div class="col-sm-10">
              @if($data['label'] != "")
                <a href="/projects/{{$data['project'][0]->salt}}/overview/details/edit" class="btn btn-sm a-details-edit opt5" style="border:1px solid {{$data['label'][0]->color}};color:{{$data['label'][0]->color}};">
                  {{$data['label'][0]->label}}
                </a>
              @else
                <a href="/projects/{{$data['project'][0]->salt}}/overview/details/edit" class="text-muted a-details-edit opt5">
                  <i>Click to add label</i>
                </a>
              @endif
              <a href="/projects/{{$data['project'][0]->salt}}/overview/details/edit" class="pen icon5">&nbsp;<i class="fas fa-pen"></i></a>
            </div>
          </div>
          <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label text-right label-details-edit">Owner</label>
            <div class="col-sm-10">
              <a href="/projects/{{$data['project'][0]->salt}}/overview/details/edit" class="text-dark a-details-edit opt6">{{$data['username']}}</a>
              <a href="/projects/{{$data['project'][0]->salt}}/overview/details/edit" class="pen icon6">&nbsp;<i class="fas fa-pen"></i></a>
            </div>
          </div>
          <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label text-right label-details-edit">Date</label>
            <div class="col-sm-10">
              <span class="text-dark a-details-edit">
                <?php  echo date('F d, Y').' at '.date('h:ma'); ?>
              </span>
            </div>
          </div>
          <div class="text-right">
            <a href="/projects/open" class="btn btn-light" style="background-color: #E9E9E9;">Close</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="fontawesome/js/all.min.js"></script>
  <script src="js/ajax.js"></script>
  <script>
    $(document).ready(function(){
      $(".opt1").hover(function(){
        $(".icon1").show();
      });
      $(".icon1").mouseout(function(){
        setTimeout(() => {
           $(".icon1").hide();
        }, 1200)
      });
      $(".icon1").hover(function(){
        $(".icon1").show();
      });
      $(".opt2").hover(function(){
        $(".icon2").show();
      });
      $(".icon2").mouseout(function(){
        setTimeout(() => {
           $(".icon2").hide();
        }, 1200)
      });
      $(".icon2").hover(function(){
        $(".icon2").show();
      });
      $(".opt3").hover(function(){
        $(".icon3").show();
      });
      $(".icon3").mouseout(function(){
        setTimeout(() => {
           $(".icon3").hide();
        }, 1200)
      });
      $(".icon3").hover(function(){
        $(".icon3").show();
      });
      $(".opt4").hover(function(){
        $(".icon4").show();
      });
      $(".icon4").mouseout(function(){
        setTimeout(() => {
           $(".icon4").hide();
        }, 1200)
      });
      $(".icon4").hover(function(){
        $(".icon4").show();
      });
      $(".opt5").hover(function(){
        $(".icon5").show();
      });
      $(".icon5").mouseout(function(){
        setTimeout(() => {
           $(".icon5").hide();
        }, 1200)
      });
      $(".icon5").hover(function(){
        $(".icon5").show();
      });
      $(".opt6").hover(function(){
        $(".icon6").show();
      });
      $(".icon6").mouseout(function(){
        setTimeout(() => {
           $(".icon6").hide();
        }, 1200)
      });
      $(".icon6").hover(function(){
        $(".icon6").show();
      });
    });
  </script>
</body>
</html>
