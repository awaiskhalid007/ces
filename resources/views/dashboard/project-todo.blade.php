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
                <h3>Todo List</h3>
              </div>
              <div class="ml-auto">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong">
                  <i class="fas fa-plus"></i>&nbsp; Todo List
                </button>
              </div>
            </div>
            <div>
              <table class="table table-sm">
                <tbody>
                  @if (!$todo_list->isEmpty())
                  @foreach ($todo_list as $project_todo)
                    <tr>
                      <td><input type="checkbox"></td>
                      @if ($project_todo->status == 1)
                        <td style="text-decoration: line-through;">{{$project_todo->name}}</td>
                      @else
                        <td>{{$project_todo->name}}</td>
                      @endif
                      @if ($project_todo->start_date == "")
                        <td>
                          <button class="todo_date_btn" onclick="updateStartDate('{{$project_todo->id}}')"><i class="fa fa-edit"></i> Add Start Date</button>
                        </td>
                      @else
                        <td title="Project Start Date"><?php echo date('d M, Y', strtotime($project_todo->start_date)) ?></td>
                      @endif
                      @if ($project_todo->end_date == "")
                        <td><button class="todo_date_btn" onclick="updateEndDate('{{$project_todo->id}}')"><i class="fa fa-edit"></i> Add End Date</button></td>
                      @else
                        <td title="Project End Date"><?php echo date('d M, Y', strtotime($project_todo->end_date)) ?></td>
                      @endif
                      <td>
                        <button class="no-bg" id="AssignTaskTodoBtn" data-toggle="modal" data-target="#assignModal">Assign Task <i class="far fa-edit"></i></button>
                      </td>
                      <td>
                        <div class="dropdown">
                          <button class="todo-edit--button" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="outline: none;box-shadow: none;">
                            <i class="fa fa-caret-down"></i>
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            @if($project_todo->status == 1)
                              <a class="dropdown-item" href="/projects/open/todo/mark-uncompleted/{{$project_todo->id}}/{{$project_id}}"> &nbsp;<i class="fas fa-times"></i>&nbsp; Mark Uncomplete</a>
                            @else
                              <a class="dropdown-item" href="/projects/open/todo/mark-completed/{{$project_todo->id}}/{{$project_id}}"> &nbsp;<i class="fas fa-check"></i>&nbsp; Mark Complete</a>
                            @endif
                            <a class="dropdown-item" href="/projects/open/todo/delete/{{$project_todo->id}}/{{$project_id}}"> &nbsp;<i class="fas fa-trash"></i>&nbsp; Delete</a>
                            <a class="dropdown-item" >
                              <button type="button" class="todo-edit--button" onclick="editTodo('<?php echo $project_todo->id; ?>', '<?php echo $project_todo->name; ?>')">
                              <i class="fas fa-edit"></i>&nbsp; Edit
                            </button>
                            </a>
                          </div>
                        </div>
                      </td>
                    </tr>
                  @endforeach
                  @else
                  <tr>
                    <td class="text-center" style="font-weight: 400; font-size: 30px; color: #d6d6d6; padding: 50px;"><p>Todo List is Empty</p></td>
                  </tr>
                  @endif
                </tbody>
              </table>
            </div>
          </div>
        </div>
    </div>
    
{{-- ========ADD TODO MODAL======== --}}
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Todo List</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('project_todo.add') }}" method="POST">
          @csrf
          <div class="form-group">
            <label for=""><b>Name:</b></label>
            <input type="text" class="form-control" name="name" placeholder="Enter Name" required>
            @error('name')
              <span>
                  <p style="font-size:13px!important; color: #fd0710!important;">{{ $message }}*</p>
              </span>
            @enderror
            <input type="hidden" name="id" value="{{$project_id}}">
          </div>
          <button type="submit" class="btn btn-primary">Save</button>
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
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Todo</h5>
      </div>
      <div class="modal-body">
        <form action="{{route('todo.update')}}" method="POST">
          @csrf
          <div class="form-group">
            <label for="">Edit</label>
            <input type="text" class="form-control" placeholder="Enetr Name" required name="name" id="todo_modal_name">
            @error('name')
              <span>
                  <p style="font-size:13px!important; color: #fd0710!important;">{{ $message }}*</p>
              </span>
            @enderror
            <input type="hidden" name="id" id="id" />
            <input type="hidden" name="project_id" value={{$project_id}} />
          </div>
          <div class="text-right">
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
{{-- Date Modals --}}
<div class="modal fade" id="start_date_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add Start Date</h5>
      </div>
      <div class="modal-body">
        <form action="{{route('todo.update_start_date')}}" method="POST">
          @csrf
          <div class="form-group">
            <label for="">Choose Start Date</label>
            <input type="date" class="form-control" name="date" id="date">
            <input type="hidden" name="id" id="id" />
          </div>
          <div class="text-right">
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="end_date_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add End Date</h5>
      </div>
      <div class="modal-body">
        <form action="{{route('todo.update_end_date')}}" method="POST">
          @csrf
          <div class="form-group">
            <label for="">Choose End Date</label>
            <input type="date" class="form-control" name="date" id="date">
            <input type="hidden" name="id" id="id" />
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
    $(function(){
        var dtToday = new Date();
        
        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();
        if(month < 10)
            month = '0' + month.toString();
        if(day < 10)
            day = '0' + day.toString();
        
        var maxDate = year + '-' + month + '-' + day;
        $('input[type="date"]').attr('min', maxDate);
    });
    function editTodo(id, name)
    {
      $("#id").val(id);
      $("#todo_modal_name").val(name);
      $("#exampleModalCenter").modal('show');
    }
    function updateStartDate(id)
    {
      $("#start_date_modal #id").val(id);
      $("#start_date_modal").modal('show');
    }
    function updateEndDate(id)
    {
      $("#end_date_modal #id").val(id);
      $("#end_date_modal").modal('show');
    }
  </script>
</body>
</html>
 