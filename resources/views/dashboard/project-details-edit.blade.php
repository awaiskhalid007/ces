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
          <div class="col-lg-2 col-md-2">
            @include('dashboard.partials.project-sidebar')
          </div>
          {{-- Sidebar End--}}
          <div class="col-lg-7 col-md-7 add-details-div">
            <div class="row add-detail-heading--row" style="border-bottom: 1px solid #eee;">
              <div class="add-detail-heading mr-auto">
                <h3>Project Details</h3>
              </div>
            </div>
            <form action="{{ route('project.update') }}" method="POST">
            @csrf
            <div class="form-group row">
              <label for="name" class="col-sm-2 col-form-label text-right">Name</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Project Name" value="{{$data['project'][0]->name}}">
                <input type="hidden" name="id" value="{{$data['project'][0]->id}}">
                <input type="hidden" name="salt" value="{{$data['project'][0]->salt}}">
              </div>
            </div>
            <div class="form-group row">
              <label for="template" class="col-sm-2 col-form-label text-right">Template</label>
              <div class="col-sm-10">
                <select name="template" id="template" class="form-control">
                  @if($data['project'][0]->template_id == 0)
                    <option value="0">Default Template</option>
                  @else
                    @if(!empty($project_template))
                    <option selected value="{{$project_template->id}}" style="color: orange;">{{$project_template->name}}</option>
                    @endif
                    <option disabled>
                      <p style="width: 100%;border:1px solid #333;"></p>
                    </option>
                    @foreach($templates as $temp)
                      <option value="{{$temp->id}}">{{$temp->name}}</option>
                    @endforeach
                  @endif
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="des" class="col-sm-2 col-form-label text-right">Description</label>
              <div class="col-sm-10">
                <textarea name="description" id="des" cols="30" rows="2" class="form-control">{{$data['project'][0]->description}}</textarea>
              </div>
            </div>
            <div class="form-group row">
              <label for="client" class="col-sm-2 col-form-label text-right">Client</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="client" name="client" placeholder="Enter Client Name" value="{{$data['project'][0]->client}}">
              </div>
            </div>
            <div class="form-group row">
              <label for="template" class="col-sm-2 col-form-label text-right">Status</label>
              <div class="col-sm-10">
                <select name="status" id="template" class="form-control">
                  <option selected value="{{$data['project'][0]->status_id}}" style="color:orange;">{{$data['status']}}</option>
                  @if($data['statuses']->isEmpty())
                    <option disabled>No status available</option>
                  @else
                    @foreach($data['statuses'] as $status)
                      <option value="{{$status->id}}">{{$status->status}}</option>
                    @endforeach
                  @endif
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="labels" class="col-sm-2 col-form-label text-right">Labels</label>
              <div class="col-sm-10">
                <select name="label" id="labels" class="form-control">
                  <option selected value="{{$data['project'][0]->label_id}}" style="color:orange;">{{$data['label']}}</option>
                  @if($data['labels']->isEmpty())
                    <option disabled>No labels available</option>
                  @else
                    @foreach($data['labels'] as $label)
                      <option value="{{$label->id}}">{{$label->label}}</option>
                    @endforeach
                  @endif
                </select>
              </div>
            </div>
            <div class="text-right">
              <button type="submit" class="btn btn-success">Save Changes</button>
              <a href="/project/{{$data['project'][0]->salt}}/overview/details" class="btn btn-light" style="background-color: #E9E9E9;">Close</a>
            </div>
          </div>
        </div>
    </div>
  </div>
  
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="fontawesome/js/all.min.js"></script>
  <script src="js/ajax.js"></script>
</body>
</html>
