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
              <a class="navbar-brand nav--main--item">My Projects</a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                  <li class="nav-item active">
                  </li>
                </ul>
                <form class="form-inline my-2 my-lg-0" action="{{ route('projects.search') }}" method="POST">
                  @csrf
                  <label class="sr-only" for="inlineFormInputGroupUsername">Search Project</label>
                  <div class="input-group">
                    <input type="text" class="form-control" id="inlineFormInputGroupUsername" placeholder="Find projects by name" name="search" required>
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <button type="submit" class="project_search_button"><i class="fas fa-search"></i></button></div>
                    </div>
                  </div>
                </form>
              </div>
            </nav>
            <div class="filter--row row">
              <div class="mr-auto row">
                <div class="dropdown">
                  <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                    @if($project_view == "details")
                      <i class="fas fa-list"></i> Large List
                    @elseif($project_view == "compact_list")
                      <i class="fas fa-list"></i> Compact List
                    @elseif($project_view == "table_view")
                      <i class="fas fa-list"></i> Table
                    @endif
                  
                  </button>
                  <div class="dropdown-menu">
                    <h5 class="dropdown-header">View Options</h5>
                    <a class="dropdown-item" href="/projects/open/detail_list"><i class="fas fa-list"></i> Large List</a>
                    <a class="dropdown-item" href="/projects/open/compact_list"><i class="fas fa-list"></i> Compact List</a>
                    <a class="dropdown-item" href="/projects/open/table"><i class="fas fa-table"></i> Table</a>
                  </div>
                </div>
                <div class="dropdown">
                  <button type="button" class="btn dropdown-toggle" data-toggle="dropdown"><i class="fas fa-filter"></i> Filter</button>
                  <div class="dropdown-menu filter-status-dropdown" style="padding-left: 20px; min-width: 15rem!important;">
                    <div class="row">
                        <div class="col-md-6"><a class="dropdown-item" style="padding-left: 0px;">Filter By Status</a></div>
                        <div class="col-md-6"><a class="dropdown-item" href="/projects/open"style="padding-left: 0px;">Clear Filter</a></div>
                    </div>
                    @foreach ($project_status as $mystatus)
                      <a href="/projects/open/filterby:{{$mystatus->id}}" class="btn btn-sm" style="border-color: {{$mystatus->color}}; color:{{$mystatus->color}}; margin-bottom: 10px;">{{$mystatus->status}}</a><br>
                    @endforeach
                  </div>
                </div>
              </div>
              <div class="ml-auto">
                <div class="dropdown" id="ProjectsPageSortSection">
                  <button type="button" class="btn dropdown-toggle projects-sorting-dropdown" data-toggle="dropdown">
                    Sorted by: 
                    <a>
                      @if(isset($_GET['sort']))
                        @if($_GET['sort'] == 'name' && $_GET['dir'] == 'asc')
                          Name: A-Z
                        @endif
                        @if($_GET['sort'] == 'name' && $_GET['dir'] == 'desc')
                          Name: Z-A
                        @endif
                        @if($_GET['sort'] == 'modifiedDate' && $_GET['dir'] == 'desc')
                          Last Modified: Recent First
                        @endif
                        @if($_GET['sort'] == 'modifiedDate' && $_GET['dir'] == 'asc')
                          Last Modified: Recent Last
                        @endif
                        @if($_GET['sort'] == 'creationDate' && $_GET['dir'] == 'desc')
                          Creation Date: Recent First
                        @endif
                        @if($_GET['sort'] == 'creationDate' && $_GET['dir'] == 'asc')
                          Creation Date: Recent Last
                        @endif
                      @else
                        Creation Date, Recent First
                      @endif
                    </a>
                  </button>
                  <div class="dropdown-menu" style="width: 250px!important;">
                    <a class="dropdown-item" href="/projects/open/?sort=name&dir=asc">
                      <div class="row">
                        <div class="col-6">
                          Name
                        </div>
                        <div class="col-6 text-right">
                          A-Z
                        </div>
                      </div>
                    </a>
                    <a class="dropdown-item" href="/projects/open/?sort=name&dir=desc">
                      <div class="row">
                        <div class="col-6">
                          Name
                        </div>
                        <div class="col-6 text-right">
                          Z-A
                        </div>
                      </div>
                    </a>
                    <a class="dropdown-item" href="/projects/open/?sort=modifiedDate&dir=desc">
                      <div class="row">
                        <div class="col-6">
                          Last Modified
                        </div>
                        <div class="col-6 text-right">
                          Recent First
                        </div>
                      </div>
                    </a>
                    <a class="dropdown-item" href="/projects/open/?sort=modifiedDate&dir=asc">
                      <div class="row">
                        <div class="col-6">
                          Last Modified
                        </div>
                        <div class="col-6 text-right">
                          Recent Last
                        </div>
                      </div>
                    </a>
                    <a class="dropdown-item" href="/projects/open/?sort=creationDate&dir=desc">
                      <div class="row">
                        <div class="col-6">
                          Creation Date
                        </div>
                        <div class="col-6 text-right">
                          Recent First
                        </div>
                      </div>
                    </a>
                    <a class="dropdown-item" href="/projects/open/?sort=creationDate&dir=asc">
                      <div class="row">
                        <div class="col-6">
                          Creation Date
                        </div>
                        <div class="col-6 text-right">
                          Recent Last
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
              </div>
            </div>
            @if(empty($data))
            <div class="text-center" style="padding-top: 20px;">
              <h2 style="font-weight: 300; color: #C1C1C1;">
                You don't have any open projects.
              </h2>
              <a href="/projects/create" class="btn btn-primary btn-lg" style="margin-top: 20px; margin-bottom: 20px;">Create a Project</a><br>
              <a href="javascript::void(0)">Getting Started: Creating a Project</a>
            </div>
            @else
              @if ($project_view == "details")
                <div class="col-xs-12">
                  @foreach($data as $val)
                    <div class="projects-list-item">
                        @if($val['status'] != "")
                          <div class="projects-list-left">
                            <a href="/project/{{$val['project']->salt}}/plans" data-router="true" class="plans-block block status-colour-green plans-block-stack-small" style="background-color: {{$val['status']->color}};opacity:0.5;">
                              <div class="projects-plans-count">{{$val['plans']}}</div>
                              <div class="projects-plans-subtitle">plan</div>
                              <div class="projects-plans-complete hidden-xs hidden-sm">0 complete</div>
                            </a>
                          </div>
                        @elseif($val['status'] == '')
                          <div class="projects-list-left">
                            <a href="/project/{{$val['project']->salt}}/plans" data-router="true" class="plans-block block status-colour-green plans-block-stack-small" style="background-color: #333;opacity:0.5;">
                              <div class="projects-plans-count">0</div>
                              <div class="projects-plans-subtitle">plan</div>
                              <div class="projects-plans-complete hidden-xs hidden-sm">0 complete</div>
                            </a>
                          </div>
                        @endif

                        <div class="projects-list-center">
                          @if($val['status'] != "")
                            <div class="pull-right hidden-xs hidden-sm">
                              <div class="projects-status-label">status</div>
                              <div class="projects-status status-colour-green status-label" style="border-color: {{$val['status']->color}}; color: {{$val['status']->color}};">
                                {{$val['status']->status}}
                              </div>
                            </div>
                            
                          @elseif($val['status'] == "")
                          <div class="pull-right hidden-xs hidden-sm">
                            <div class="projects-status-label">status</div>
                            <div class="projects-status status-colour-green status-label" style="border-color: #333}}; color: #333}};">
                              open
                            </div>
                          </div>
                          @endif
                          <h2 class="projects-title"><a href="/project/{{$val['project']->salt}}/overview/details" data-router="true">{{$val['project']->name}}</a> </h2>
                          <div class="hidden-xs hidden-sm">
                            <div class="margin-bottom-sm">
                              @if($val['icon'] == 1)
                                <i class="far fa-share-square" style="font-size: 13px;"></i>
                              @endif
                              <span class="projects-owner"> Owned by {{$val['username']}}</span> / <span class="projects-created-at">Created <?php echo date('d M Y', strtotime($val['project']->created_at)); ?> at <?php echo date('h:m A', strtotime($val['project']->created_at)); ?></span>
                            </div>
                            
                          </div>
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
                                <li class="disabled"><a style="font-weight: 500;">Project Actions</a></li>
                                <li class="divider"></li>
                                <li>
                                  <a href="/project/{{$val['project']->salt}}/overview/details" data-router="true"><i class="far fa-folder-open"></i> Open</a>
                                </li>
                                <li>
                                  <button class="btn btn-text" style="margin-left:6px;" onclick="duplicate_modal ('<?php echo $val['project']->id; ?>', '<?php echo $val['project']->name; ?>') ">
                                    <i class="fas fa-copy"></i> Duplicate
                                  </button>
                                </li>
                                <li>
                                  <button class="btn btn-text" style="margin-left:6px;" onclick="status_modal ('<?php echo $val['project']->id; ?>', '<?php echo $val['project']->name; ?>') ">
                                    <i class="fa fa-exchange-alt"></i> Change Status
                                  </button>
                                  
                                </li>
                                <li class="divider"></li>
                                <li>
                                  <button class="btn btn-text" style="margin-left:6px;" onclick="archive_modal ('<?php echo $val['project']->id; ?>', '<?php echo $val['project']->name; ?>') ">
                                    <i class="fa fa-archive"></i> Archive
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
              @elseif($project_view == "compact_list")
                <div class="col-xs-12">
                  @foreach($data as $val)
                    <div class="projects-list-item">
                        @if($val['status'] != "")
                          <div class="projects-list-left projects-list-left-compact-list">
                            <a href="/project/{{$val['project']->salt}}/plans" data-router="true" class="plans-block plans-block-compact block status-colour-green plans-block-stack-small" style="background-color: {{$val['status']->color}};opacity:0.5;">
                              <div class="projects-plans-count plans-block-compact-count">{{$val['plans']}}</div>
                              <div class="projects-plans-subtitle">plan</div>
                            </a>
                          </div>
                        @elseif($val['status'] == '')
                          <div class="projects-list-left">
                            <a href="/project/{{$val['project']->salt}}/plans" data-router="true" class="plans-block block status-colour-green plans-block-stack-small" style="background-color: #333;opacity:0.5;">
                              <div class="projects-plans-count">0</div>
                              <div class="projects-plans-subtitle">plan</div>
                            </a>
                          </div>
                        @endif

                        <div class="projects-list-center">
                          @if($val['status'] != "")
                            <div class="pull-right hidden-xs hidden-sm">
                              <div class="projects-status-label">status</div>
                              <div class="projects-status status-colour-green status-label" style="border-color: {{$val['status']->color}}; color: {{$val['status']->color}};">
                                {{$val['status']->status}}
                              </div>
                            </div>
                            
                          @elseif($val['status'] == "")
                          <div class="pull-right hidden-xs hidden-sm">
                            <div class="projects-status-label">status</div>
                            <div class="projects-status status-colour-green status-label" style="border-color: #333}}; color: #333}};">
                              open
                            </div>
                          </div>
                          @endif
                          <h2 class="projects-title"><a href="/project/{{$val['project']->salt}}/overview/details" data-router="true">{{$val['project']->name}}</a> </h2>
                          <div class="hidden-xs hidden-sm">
                            <div class="margin-bottom-sm">
                              <span class="projects-owner"> Owned by {{$val['username']}}</span> / <span class="projects-created-at">Created <?php echo date('d M Y', strtotime($val['project']->created_at)); ?> at <?php echo date('h:m A', strtotime($val['project']->created_at)); ?></span>
                            </div>
                            
                          </div>
                        </div>
                        <div class="projects-list-right projects-list-right-compact">
                          <div class="projects-list-menu-wrap">
                            <div class="dropdown">
                              <a href="#" class="dropdown-toggl js-toggle-project-menu" data-toggle="dropdown"><i class="far fa-play-circle fa-rotate-90"></i></a>
                              <ul class="dropdown-menu pull-right" role="menu">
                                <li class="disabled"><a style="font-weight: 500;">Project Actions</a></li>
                                <li class="divider"></li>
                                <li>
                                  <a href="/project/{{$val['project']->salt}}/overview/details" data-router="true"><i class="far fa-folder-open"></i> Open</a>
                                </li>
                                <li>
                                  <button class="btn btn-text" style="margin-left:6px;" onclick="duplicate_modal ('<?php echo $val['project']->id; ?>', '<?php echo $val['project']->name; ?>') ">
                                    <i class="fas fa-copy"></i> Duplicate
                                  </button>
                                </li>
                                <li>
                                  <button class="btn btn-text" style="margin-left:6px;" onclick="status_modal ('<?php echo $val['project']->id; ?>', '<?php echo $val['project']->name; ?>') ">
                                    <i class="fa fa-exchange-alt"></i> Change Status
                                  </button>
                                  
                                </li>
                                <li class="divider"></li>
                                <li>
                                  <button class="btn btn-text" style="margin-left:6px;" onclick="archive_modal ('<?php echo $val['project']->id; ?>', '<?php echo $val['project']->name; ?>') ">
                                    <i class="fa fa-archive"></i> Archive
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
              @elseif($project_view == "table_view")
                <table class="table table-hover borderless">
                  <thead>
                    <tr>
                      <th>Project</th>
                      <th>Status</th>
                      <th>Labels</th>
                      <th>Owner</th>
                      <th>Last Modified</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($data as $val)
                    <tr>
                      <td>
                        <a href="/project/{{$val['project']->salt}}/overview/details" data-router="true">{{$val['project']->name}}</a>
                      </td>
                      <td>
                        @if($val['status'] != "")
                            <div class=" hidden-xs hidden-sm">
                              {{-- <div class="projects-status-label">status</div> --}}
                              <div class="projects-status status-colour-green status-label" style="border-color: {{$val['status']->color}}; color: {{$val['status']->color}};">
                                {{$val['status']->status}}
                              </div>
                            </div>
                            
                          @elseif($val['status'] == "")
                          <div class=" hidden-xs hidden-sm">
                            {{-- <div class="projects-status-label">status</div> --}}
                            <div class="projects-status status-colour-green status-label" style="border-color: #333}}; color: #333}};">
                              open
                            </div>
                          </div>
                          @endif
                      </td>
                      <td></td>
                      <td>
                        {{$val['username']}}
                      </td>
                      <td>
                        <?php echo date('d M Y', strtotime($val['project']->created_at)); ?> at <?php echo date('h:m A', strtotime($val['project']->created_at)); ?>
                      </td>
                      <td>
                        <div class="projects-list-menu-wrap">
                            <div class="dropdown">
                              <a href="#" class="dropdown-toggl js-toggle-project-menu" data-toggle="dropdown"><i class="far fa-play-circle fa-rotate-90"></i></a>
                              <ul class="dropdown-menu pull-right" role="menu">
                                <li class="disabled"><a style="font-weight: 500;">Project Actions</a></li>
                                <li class="divider"></li>
                                <li>
                                  <a href="/project/{{$val['project']->salt}}/overview/details" data-router="true" style="color: #000000; margin-left: 20px!important;"><i class="far fa-folder-open"></i> Open</a>
                                </li>
                                <li>
                                  <button class="btn btn-text" style="margin-left:6px;" onclick="duplicate_modal ('<?php echo $val['project']->id; ?>', '<?php echo $val['project']->name; ?>') ">
                                    <i class="fas fa-copy"></i> Duplicate
                                  </button>
                                </li>
                                <li>
                                  <button class="btn btn-text" style="margin-left:6px;" onclick="status_modal ('<?php echo $val['project']->id; ?>', '<?php echo $val['project']->name; ?>') ">
                                    <i class="fa fa-exchange-alt"></i> Change Status
                                  </button>
                                  
                                </li>
                                <li class="divider"></li>
                                <li>
                                  <button class="btn btn-text" style="margin-left:6px;" onclick="archive_modal ('<?php echo $val['project']->id; ?>', '<?php echo $val['project']->name; ?>') ">
                                    <i class="fa fa-archive"></i> Archive
                                  </button>
                                </li>
                                <li>
                                  <a href="/projects/{{$val['project']->id}}/delete" data-action="delete-project" data-projectid="pyCaPqYPdHJcyn5JW" style="margin-left: 20px!important; color: #000000;"><i class="fa fa-trash-alt"></i> Delete</a>
                                </li>
                              </ul>
                            </div>
                          </div>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              @endif
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
    <form action="{{route('project.addtoarchive')}}" method="POST">
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
          <b>Please choose a Reason:</b>
          <input type="hidden" name="id" id="archive_project_id">
          <select name="reason" class="form-control">
            @if($reasons->isEmpty())
              <option value="">Choose</option>
            @else
              @foreach($reasons as $reason)
                <option value="{{$reason->id}}" style="color:{{$reason->color}};">{{$reason->reason}}</option>
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

{{-- Change Status Modal --}}
<div class="modal fade" id="change_status_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form action="{{route('project.changestatus')}}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Project Status</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <b>Project:</b>
          <p id="change_status_project_name"></p>
          <b>Please choose a Status:</b>
          <input type="hidden" name="project_id" value="change_status_project_id" id="change_status_project_id">
          <div class="form-group">
            <select name="status" class="form-control">
              @if($project_status->isEmpty())
                <option value="">Choose</option>
              @else
                @foreach ($project_status as $project_status)
                  <option value="{{$project_status->id}}" style="color: {{$project_status->color}}">{{$project_status->status}}</option>
                @endforeach
              @endif
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Change Status</button>
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
          <button type="submit" class="btn btn-primary">Yes</button>
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
    function archive_modal(id, name){
      
      $("#archive_project_name").html(name);
      $("#archive_project_id").val(id);
      $("#archive_modal").modal('show');
    }
    function status_modal(id, name){
      
      $("#change_status_project_name").html(name);
      $("#change_status_project_id").val(id);
      $("#change_status_modal").modal('show');
    }
    function duplicate_modal(id, name){
      
      $("#duplicate_project_name").html(name);
      $("#duplicate_project_id").val(id);
      $("#duplicate_modal").modal('show');
    }
  </script>  
</body>
</html>
