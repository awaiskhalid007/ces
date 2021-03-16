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
  <div class="container-fluid">
    <div class="nav-create--1">
      <label for="">PROJECT</label>
      <h5>New Project</h5>
      
    </div>
    <nav>
      <div class="nav nav-tabs naav--tabs--create" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">
          Projects
        </a>
        <a class="nav-item nav-link" style="pointer-events: none;" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">
          Plans
        </a>
        <a class="nav-item nav-link" style="pointer-events: none;" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">
          Worksheet
        </a>
        <a class="nav-item nav-link" style="pointer-events: none;" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">
          Quantities
        </a>
      </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="row">
          {{-- Sidebar Start--}}
          <div class="col-lg-2">
              <ul class="navbar-nav ul--sidebar--create">
                <li><a>Overview</a></b></li>
                <li><a>To-do</a></li>
                <li><a>Stages</a></li>
                <li><a>Sharing</a></li>
                <li><a>Attachments</a></li>
                <li><a>Exports</a></li>
                <li><a>Activity Log</a></li>
              </ul>
          </div>
          {{-- Sidebar End--}}

          <div class="col-lg-7 add-details-div">
            <form action="{{route('project.create')}}" method="POST">
            @csrf
            <div class="add-details-heading">
              <h3>Project Details</h3>
            </div>
            <div class="form-group row">
              <label for="name" class="col-sm-2 col-form-label text-right">Name</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="name" placeholder="Enter Project Name" name="name" value="New Project">
              </div>
            </div>
            <div class="form-group row">
              <label for="template" class="col-sm-2 col-form-label text-right">Template</label>
              <div class="col-sm-10">
                <select name="template" id="template" class="form-control">
                  <option value="0" selected>Default Template</option>
                  @if($shared_templates != '')
                  @foreach ($shared_templates as $template)
                    <option value="{{$template->id}}">{{$template->name}}</option>
                  @endforeach
                  @endif
                  @foreach ($templates as $templates)
                    <option value="{{$templates->id}}">{{$templates->name}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="text-right">
              <a href="/project-templates/open"><i class="fas fa-plus"></i>&nbsp;Create Template</a>
            </div>
            <div class="text-center">
              <span id="show--more" class="show-more-button">Show more details</span>
            </div>
            <div id="more--details" style="display: none;">
              <div class="form-group row">
                <label for="des" class="col-sm-2 col-form-label text-right">Description</label>
                <div class="col-sm-10">
                  <textarea name="description" id="des" cols="30" rows="2" class="form-control"></textarea>
                </div>
              </div>
              <div class="form-group row">
                <label for="client" class="col-sm-2 col-form-label text-right">Client</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="client" id="client" placeholder="Enter Client Name">
                </div>
              </div>
              <div class="form-group row">
                <label for="template" class="col-sm-2 col-form-label text-right">Status</label>
                <div class="col-sm-10">
                  <select name="status" id="template" class="form-control">
                    @if(!$statuses->isEmpty())
                      @foreach($statuses as $status)
                        <option value="{{$status->id}}" style="color:{{$status->color}};">
                          {{$status->status}}
                        </option>
                      @endforeach
                    @else
                      <option selected disabled>Choose....</option>
                    @endif
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="labels" class="col-sm-2 col-form-label text-right">Labels</label>
                <div class="col-sm-10">
                  <select name="labels" id="labels" class="form-control">
                    <option selected disabled>Choose....</option>
                    @if(!$labels->isEmpty())
                      @foreach($labels as $label)
                        <option value="{{$label->id}}" style="color:{{$label->color}};">{{$label->label}}</option>
                      @endforeach
                    @endif
                  </select>
                </div>
              </div>
            </div>
            <div class="text-right">
              <button type="submit" class="btn btn-primary">Create</button>
              <a href="#" class="btn btn-light" style="background-color: #E9E9E9;">Close</a>
            </div>
            </form>
            <div class="text-center">
              <span id="show--less" class="show-more-button hide">Show less</span>
            </div>
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
      $("#show--more").click(function(){
        $("#more--details").toggle();
        $("#show--more").toggle();
        $("#show--less").toggle();
      });
      $("#show--less").click(function(){
        $("#more--details").toggle();
        $("#show--more").toggle();
        $("#show--less").toggle();
      });
    });
</script>
</body>
</html>
