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
  <link rel='stylesheet' href='fontawesome/css/all.min.css' type='text/css' />
</head>
<body class="projectPage">

  @include('dashboard.partials.header')
  <div class="container-fluid">
    <div class="nav-create--1">
      <label for="">PROJECT</label>
      <h5>{{$template_name}}</h5>
    </div>
    <section class="projects_tabs">
      <div class="container">
        <ul id="bottom_header">
          <li class="tab tab1 active"><a>Project</a></li>
          <li class="tab tab2" style="cursor: no-drop;"><a style="color: #a3a3a3!important;">Plans</a></li>
          <li class="tab tab3" style="cursor: no-drop;"><a style="color: #a3a3a3!important;">Worksheets</a></li>
          <li class="tab tab4" style="cursor: no-drop;"><a style="color: #a3a3a3!important;">Quantities</a></li>
        </ul>
      </div>
    </section>
    <div class="container">
      <div class="row">
          <div class="col-lg-2">
            @include('dashboard.partials.template-sidebar')
          </div>
          <div class="col-lg-10 add-details-div">
            <div class="row add-detail-heading--row">
              <div class="add-detail-heading mr-auto">
                <h1 class="slim">Stages</h1>
              </div>
              <div class="ml-auto">
                <button type="button" class="btn btn-primary" onclick="openAddStageModal('{{$template_id}}')">
                  <i class="fas fa-plus"></i>&nbsp; Add Stage
                </button>
              </div>
            </div>
            <div>
              <table class="table table-sm">
                <tbody>
                  @if(!$stages->isEmpty())
                  @foreach($stages as $stage)
                  <tr>
                    <td><a onclick="openStageEditModel('{{$stage->id}}','{{$stage->name}}','{{$stage->description}}')" style="cursor: pointer;" id="TemplateStageName">{{$stage->name}} <i class="far fa-edit" style="font-size: 12px;"></i></a></td>
                    <td class="text-right">
                      @if($stage->description == '' || $stage->description == null)
                        <i style="font-size: 14px;color: #999;">no description</i>
                      @else
                        <p style="font-size: 15px;">
                          {{$stage->description}}
                        </p>
                      @endif
                    </td>
                    <td class="text-right">
                      <div class="dropdown">
                        <button class="todo-edit--button" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="outline: none;box-shadow: none;">
                          <i class="far fa-play-circle fa-rotate-90"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <li>
                            <a class="dropdown-item disabled">Stage Actions</a>
                          </li>
                          <li class="divider"></li>
                          <li>
                            <a onclick="openStageEditModel('{{$stage->id}}','{{$stage->name}}','{{$stage->description}}')" class="dropdown-item" style="cursor: pointer;">
                              <i class="far fa-edit"></i> 
                              Edit
                            </a>
                          </li>
                          <li>
                            <a onclick="delete_stage('{{$stage->id}}')" class="dropdown-item" style="cursor: pointer;">
                              <i class="fa fa-times"></i> 
                              Delete
                            </a>
                          </li>
                        </ul>
                      </div>
                    </td>
                  </tr>
                  @endforeach
                  @else
                    <tr>
                      <td>
                        <p style="margin-top: 20px;font-size: 15px;">
                          There are no Stages in this project template
                        </p>
                      </td>
                    </tr>
                  @endif
                </tbody>
              </table>
            </div>
          </div>
        </div>
    </div>
    
{{-- ========ADD TODO MODAL======== --}}
<div class="modal fade" id="addStageModal" tabindex="-1" role="dialog" aria-labelledby="addModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add Stage</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('stage.add') }}" method="POST">
          @csrf
          <div class="form-group">
            <label for=""><b>Name:</b></label>
            <input type="text" class="form-control" name="name" placeholder="Enter Stage Name" required>
            @error('name')
              <span>
                  <p style="font-size:13px!important; color: #fd0710!important;">{{ $message }}*</p>
              </span>
            @enderror
            <input type="hidden" name="template_id" id="template_id">
          </div>
          <button type="submit" class="btn btn-primary">Add</button>
        </form>
      </div>
    </div>
  </div>
</div> 

{{-- ========EDIT TODO MODAL======== --}}
<div class="modal fade" id="editStageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Stage</h5>
      </div>
      <div class="modal-body">
        <form action="{{route('stage.update')}}" method="POST">
          @csrf
          <div class="form-group">
            <label for=""><b>Name</b></label>
            <input type="text" class="form-control" placeholder="Enetr Name" required name="name" id="todo_modal_name">
            @error('name')
              <span>
                  <p style="font-size:13px!important; color: #fd0710!important;">{{ $message }}*</p>
              </span>
            @enderror
            <input type="hidden" name="id" id="id" />
            <input type="hidden" name="template_id" id="template_id" value="{{$template_id}}" />
          </div>
          <div class="form-group">
            <label><b>Description</b></label>
            <textarea name="description" id="stageDescription" class="form-control"></textarea>
          </div>
          <div class="form-group">
            <label>
              <b>Take-Off Template</b>
            </label>
            <select name="takeOffTemplate" class="form-control">
              <option value="0">-- Blank Stage --</option>
              @foreach($takeoff_templates as $temp)
                <option value="{{$temp->id}}">{{$temp->name}}</option>
              @endforeach
            </select>
          </div>
          <p style="font-size: 14px;color: #555;">The selected take-off template will be applied when a project is created.</p>
          <div class="text-right">
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/popper.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="fontawesome/js/all.min.js"></script>
  <script src="js/ajax.js"></script>
  <script>
    function openAddStageModal(template_id)
    {
      $("#addStageModal #template_id").val(template_id);
      $("#addStageModal").modal('show');
    }
    function openStageEditModel(id, name, description)
    {
      $("#editStageModal #id").val(id);
      $("#editStageModal #todo_modal_name").val(name);
      $("#editStageModal #stageDescription").val(description);
      $("#editStageModal").modal('show');
    }
    function delete_stage(id)
    {
      let csrf = $("meta[name='csrf-token']").attr('content');
      $.ajax({
        type: 'POST',
        url: '/projects/stages/delete',
        data: {_token:csrf, id:id,ajax:1},
        success: function(res)
        {
          if(res == 1)
          {
            location.reload();
          }
        }
      });
    }
  </script>
</body>
</html>
 