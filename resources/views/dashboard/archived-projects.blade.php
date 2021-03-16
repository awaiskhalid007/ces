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
   
    <section class="projects_tabs">
      <div class="container">
        <ul>
          <li class="tab active"><a href="/projects/open">Projects</a></li>
          <li class="tab"><a href="/project-templates/open">Projects Templates</a></li>
          <li class="tab"><a href="/takeoff-templates/open">Take Off Templates</a></li>
        </ul>
      </div>
    </section>
    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="row">
          {{-- Sidebar Start--}}
          @include('dashboard.partials.projects-sidebar')
          {{-- Sidebar End--}}
          <div class="col-lg-9">
            <nav class="navbar navbar-expand-lg navbar-light bg-default myprojects--nav">
              <a class="navbar-brand nav--main--item" href="javascript::void(0)">Archived Projects</a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
            
            </nav>

            @if(empty($data))
            <div class="text-center" style="padding-top: 20px;">
              <h2 style="margin-top:50px;font-weight: 300; color: #C1C1C1;">
                No Archived Projects Found!
              </h2>
            </div>
            @else
              <div class="col-xs-12">
              @foreach($data as $val)
                <div class="projects-list-item">
                    <div class="projects-list-left">
                      <a href="/project/{{$val['project']->salt}}/plans" data-router="true" class="plans-block block status-colour-green plans-block-stack-small" style="background-color: {{$val['reason']->color}};opacity:0.5;">
                        <div class="projects-plans-count">1</div>
                        <div class="projects-plans-subtitle">plan</div>
                        <div class="projects-plans-complete hidden-xs hidden-sm">0 complete</div>
                      </a>
                    </div>
                    <div class="projects-list-center">
                      <div class="pull-right hidden-xs hidden-sm">
                        <div class="projects-status-label">status</div>
                          @if(!empty($val['reason']))
                            <div class="projects-status status-colour-green status-label" style="color:{{$val['reason']->color}};border-color:{{$val['reason']->color}};">
                              {{$val['reason']->reason}}
                            </div>
                          @else
                            <div class="projects-status status-colour-green status-label">
                            No Reason
                            </div>
                          @endif
                      </div>
                      <h2 class="projects-title"><a href="/project/{{$val['project']->salt}}/overview/details" data-router="true">{{$val['project']->name}}</a> </h2>
                      <div class="hidden-xs hidden-sm">
                        <div class="margin-bottom-sm">
                          <span class="projects-owner"> Owned by {{$val['username']}}</span> / <span class="projects-created-at">Created <?php echo date('d M Y', strtotime($val['project']->created_at)); ?> at <?php echo date('h:m A', strtotime($val['project']->created_at)); ?></span>
                        </div>
                        
                      </div>
                     {{--  <div class="visible-xs visible-sm">
                        Last Modified 25th December 2020 at 1:30 am
                      </div>
                      <div class="visible-sm">
                        <span class="projects-status-label">status</span>
                        <span class="status-colour-green status-label">
                          Open
                        </span>
                      </div> --}}
                      <div class="hidden-xs hidden-sm">
                        <h3 class="project-title-activity"><a href="/project/{{$val['project']->salt}}/overview/activity" data-router="true">Recent Activity</a></h3>
                        <div class="projects-activity-list">
                          @foreach($val['activities'] as $act)
                          <div>
                            <div class="pull-right">{{date('d M, Y h:m A', strtotime($act['created_at']))}}</div>
                            <div class="projects-activity-list-msg">{{$act['name']}} - {{$act['message']}}</div>
                          </div>
                          @endforeach
                        </div>
                      </div>
                    </div>
                    <div class="projects-list-right">
                      <div class="projects-list-menu-wrap">
                        <div class="dropdown">
                          <a href="#" class="dropdown-toggl js-toggle-project-menu" data-toggle="dropdown"><i class="far fa-play-circle fa-rotate-90"></i></a>
                          <ul class="dropdown-menu pull-right" role="menu">
                            <li class="disabled"><a href="#">Project Actions</a></li>
                            <li class="divider"></li>
                            <li>
                              <button class="btn btn-text" style="margin-left:6px;" onclick="unarchive_modal ('<?php echo $val['project']->id; ?>', '<?php echo $val['project']->name; ?>') ">
                                <i class="fa fa-archive"></i> Unarchive
                              </button>
                            </li>
                            <li>
                              <a href="/projects/{{$val['project']->id}}/delete" data-action="delete-project" data-projectid="pyCaPqYPdHJcyn5JW"><i class="fa fa-trash-alt"></i> Delete</a>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  <div class="clearfix"></div>
                </div>
              @endforeach
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Modal -->
<!-- Modal -->
<div class="modal fade" id="template-rename" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{route('template.update')}}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Update Project Template</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="">Template name</label>
            <input type="text" class="form-control" name="name" id="name" />
            <input type="hidden" value="" name="salt" id="salt" />
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </form>
  </div>
</div>

{{-- Archive Modal --}}
<div class="modal fade" id="archive_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form action="{{route('project.unarchive')}}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Archive Project</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <b>Project:</b>
          <p id="archive_project_name"></p>
          <b>Please choose a Status:</b>
          <input type="hidden" name="id" id="archive_project_id">
          <select name="status" class="form-control">
            @if($statuses->isEmpty())
              <option value="">Choose</option>
            @else
              @foreach($statuses as $status)
                <option value="{{$status->id}}" style="color:{{$status->color}};">{{$status->status}}</option>
              @endforeach
            @endif
          </select>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </form>
  </div>
</div>
{{-- Duplicate Modal --}}

<div class="modal fade" id="duplicate_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form action="{{ route('project.duplicateproject') }}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Duplicate Project</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="project_id" value="duplicate_project_id" id="duplicate_project_id">
          <b>Project:</b>
            <p id="duplicate_project_name"></p>
          <p>Are you sure to duplicate this project?</p>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Yes</button>
        </div>
      </div>
    </form>
  </div>
</div>

  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="fontawesome/js/all.min.js"></script>
  <script src="js/ajax.js"></script>
  <script>
    function renameTemplate(name, salt){
      
      $("#template-rename #name").val(name);
      $("#template-rename #salt").val(salt);
      $("#template-rename").modal('show');
    }
    function duplicate_modal(id, name){
      
      $("#duplicate_project_name").html(name);
      $("#duplicate_project_id").val(id);
      $("#duplicate_modal").modal('show');
    }
    function unarchive_modal(id, name)
    {
      $("#archive_project_name").html(name);
      $("#archive_project_id").val(id);
      $("#archive_modal").modal('show');
    }
  </script>  
</body>
</html>
