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
                <h3>Stages</h3>
              </div>
              <div class="ml-auto">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
                  <i class="fas fa-plus"></i>&nbsp; Add Stage
                </button>
              </div>
            </div>
            <div>
              <table class="table table-sm">
                  @if($stages->isEmpty())
                    <tr><td colspan="3" class="text-center" style="padding:20px 0px;">No record found.</td></tr>
                  @else
                    @foreach($stages as $stage)
                      <tr>
                        <td>{{$stage->name}}</td>
                        <td>
                          @if($stage->description == '')
                            <span style="color:silver;">no desciption</span>
                          @else
                            {{$stage->description}}
                          @endif
                        </td>
                        <td>
                          <div class="dropdown">
                            <button class="todo-edit--button" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="outline: none;box-shadow: none;">
                              <i class="fa fa-caret-down"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"> 
                              <a class="dropdown-item" >
                                <button type="button" class="todo-edit--button" onclick="editStage('<?php echo $stage->id; ?>', '<?php echo $stage->name; ?>','<?php echo $stage->description; ?>', '<?php echo $project_id; ?>')">
                                  <i class="fas fa-edit"></i>&nbsp; Edit
                                </button>
                              </a>
                              <form action="{{route('stage.delete')}}" method="POST">
                                @csrf
                                <div style="padding-left: 23px;">
                                  <input type="hidden" name="id" value="{{$stage->id}}">
                                  <input type="hidden" name="project_id" value="{{$project_id}}">
                                  <button class="no-bg"><i class="fas fa-trash"></i>&nbsp; Delete</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </td>
                      </tr>
                    @endforeach
                  @endif
              </table>
            </div>
          </div>
        </div>
    </div>
    
{{-- ========ADD TODO MODAL======== --}}
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModal" aria-hidden="true">
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
            <input type="hidden" name="id" value="{{$project_id}}">
          </div>
          <button type="submit" class="btn btn-primary">Add</button>
        </form>
      </div>
    </div>
  </div>
</div> 

{{-- ========EDIT TODO MODAL======== --}}
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Stage</h5>
      </div>
      <div class="modal-body">
        <form action="{{route('stage.update')}}" method="POST">
          @csrf
          <div class="form-group">
            <label for="">Name</label>
            <input type="text" class="form-control" placeholder="Enetr Name" required name="name" id="todo_modal_name">
            @error('name')
              <span>
                  <p style="font-size:13px!important; color: #fd0710!important;">{{ $message }}*</p>
              </span>
            @enderror
            <input type="hidden" name="id" id="id" />
            <input type="hidden" name="project_id" id="stageprojectId" />
          </div>
          <div class="form-group">
            <label>Description</label>
            <textarea name="description" id="stageDescription" class="form-control"></textarea>
          </div>
          <div class="text-right">
            <button type="submit" class="btn btn-primary">Save</button>
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
    
    function editStage(id, name, description, project_id)
    {
      $("#id").val(id);
      $("#todo_modal_name").val(name);
      $("#stageDescription").val(description);
      $("#stageprojectId").val(project_id);
      $("#exampleModalCenter").modal('show');
    }
  
  </script>
</body>
</html>
 