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
          <li class="tab"><a href="/projects/open">Projects</a></li>
          <li class="tab"><a href="/project-templates/open">Projects Templates</a></li>
          <li class="tab active"><a href="/takeoff-templates/open">Take Off Templates</a></li>
        </ul>
      </div>
    </section>
    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="row">
          {{-- Sidebar Start--}}
          @include('dashboard.partials.takeoff-templates-sidebar')
          {{-- Sidebar End--}}
          <div class="col-lg-9">
            <div class="main-title-header" style="border-bottom: 1px solid rgba(51,122,183,.2);">
              <h1 class="slim" style="margin-top:0;">Take-Off Templates</h1>
            </div>
            <br>
            <table class="table" id="takeofftemplateTable" style="margin-top:10px;">
              @if(!empty($templates))
                <thead>
                  <tr>
                    <th style="width: 45%;">Name</th>
                    <th>Labels</th>
                    <th></th>
                  </tr>
                </thead>
              @foreach($templates as $template)
                <tbody>
                  <tr>
                    <td style="width: 45%;">
                      <a href="/takeoff-templates/{{$template['salt']}}" id="takeofftemp_name">
                        {{$template['name']}}
                        <i class="far fa-edit"></i>
                      </a>
                    </td>
                    <td>
                      @if (!empty($template['labels']))
                        <div id="labelBtns">
                        @foreach($template['labels'] as $l)
                            <button type="button" id="rm-2" class="no-bg" style="color:{{$l['color']}}">
                              <svg class="svg-inline--fa fa-tag fa-w-16" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="tag" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                <path fill="currentColor" d="M0 252.118V48C0 21.49 21.49 0 48 0h204.118a48 48 0 0 1 33.941 14.059l211.882 211.882c18.745 18.745 18.745 49.137 0 67.882L293.823 497.941c-18.745 18.745-49.137 18.745-67.882 0L14.059 286.059A48 48 0 0 1 0 252.118zM112 64c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48z"></path>
                              </svg>
                              <span>{{$l['label']}}</span>
                            </button>
                        @endforeach
                        </div>
                      @endif
                    </td>
                    <td>
                      <div class="projects-list-right">
                        <div class="projects-listmenu-wrap">
                          <div class="dropdown">
                              <a href="#" class="dropdown-toggl js-toggle-project-menu text-dark" data-toggle="dropdown"><i class="far fa-play-circle fa-rotate-90"></i></a>
                              <ul class="dropdown-menu pull-right" role="menu">
                                <li class="disabled"><a href="javascript::void(0)">Template Actions</a></li>
                                <li class="divider"></li>
                                <li>
                                  <form action="{{route('takeoff-template.duplicate')}}" method="POST">
                                    @csrf
                                    <input type="hidden" value="{{$template['id']}}" name="id" />
                                    <button class="no-bg" style="margin-left: 15px;">
                                      <i class="far fa-copy"></i> Duplicate
                                    </button>
                                  </form>
                                </li>
                                <li>
                                  <button class="btn btn-muted" onclick="open_template_rename_modal('{{$template['id']}}','{{$template['name']}}')" style="margin-left:5px;"><i class="fa fa-pencil-alt"></i> Rename</button>
                                </li>
                                
                                <li class="divider"></li>
                                <li>
                                  <a class="btn btn-muted" href="takeoff-templates/open/{{$template['id']}}/delete"><i class="fa fa-trash-alt"></i> Delete</a>
                                </li>
                              </ul>
                          </div>
                        </div>
                      </div>
                    </td>
                  </tr>
                </tbody>
              @endforeach
              @else
                <div class="text-center" style="padding-top: 20px;">
                  <h2 style="font-weight: 300; color: #C1C1C1;">
                    You don't have any Take-Off Template.
                  </h2>
                  <button data-toggle="modal" data-target="#add_takeoff_template_modal" class="btn btn-primary btn-lg" style="margin-top: 20px; margin-bottom: 20px;">Create Take-Off Template</button><br>
                </div>
              @endif
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  
<!-- Modal -->
<div class="modal fade" id="template-rename" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{route('takeoff-template.update')}}" method="POST">
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
            <input type="hidden" value="" name="id" id="salt" />
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </form>
  </div>
</div>
<div class="modal fade" id="takeoff_template_model" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form action="{{ route('takeoff_temlates.addlabels') }}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="template_id" value="takeoff_template_id" id="takeoff_template_id">
          <select name="label_id" id="" class="form-control">
           {{--  @if ($takeoff_labels->isEmpty())
              <option selected disabled>No TakeOff Label Found</option>
            @else
              @foreach ($takeoff_labels as $takeoff_label)
                <option style="color: {{$takeoff_label->color}}" value="{{$takeoff_label->id}}">{{$takeoff_label->label}}</option>
              @endforeach
            @endif --}}
            
          </select>
        </div>
        <div class="modal-footer">
          {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
          <button type="submit" class="btn btn-primary">Save changes</button>
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
    function open_template_rename_modal(id, name)
    {
      $("#template-rename #name").val(name);
      $("#template-rename #salt").val(id);
      $("#template-rename").modal('show');
    }
    function label_model(id, name){
      
      $("#takeoff_template_name").html(name);
      $("#takeoff_template_id").val(id);
      $("#takeoff_template_model").modal('show');
    }
  </script>  
</body>
</html>
