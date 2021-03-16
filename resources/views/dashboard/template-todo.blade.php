<!DOCTYPE html>
<html lang="en">
<head>
	<base href="/">
  <meta name="csrf-token" content="{{csrf_token()}}">
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
            <div class="row add-detail-heading--row" style="border-bottom: 1px solid #c7c7c7;">
              <div class="add-detail-heading mr-auto">
                <h1 class="slim">To-do Lists</h1>
              </div>
              <div class="ml-auto">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong">
                  <i class="fas fa-plus"></i>&nbsp; Todo List
                </button>
              </div>
            </div>
            @if (!empty($data))
              @foreach ($data as $project_todo)
                <div class="todo-task-header">
                  <div class="row" style="margin-top: 15px;">
                    <h2>{{$project_todo['name']}}</h2>
                    <button class="todo-edit--button caret" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="far fa-play-circle"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <li>
                        <a class="dropdown-item disabled">List Actions</a>
                      </li>
                      <li class="divider"></li>
                      <li>
                        <a onclick="clear_all_tasks('{{$project_todo['id']}}')" class="dropdown-item" style="cursor: pointer;">
                          <i class="fa fa-eraser"></i> 
                          Clear Tasks
                        </a>
                      </li>
                      <li>
                        <a onclick="delete_todo('{{$project_todo['id']}}')" class="dropdown-item" style="cursor: pointer;">
                          <i class="fa fa-times"></i> 
                          Delete
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="template_todo_tasks">
                  @if(!empty($project_todo['tasks']))
                  <table class="table">
                    @foreach($project_todo['tasks'] as $task)
                    <tr>
                      <td class="name">
                        <a onclick="open_rename_todo_task_model('{{$task->id}}','{{$task->name}}')" style="cursor: pointer;">
                          {{$task->name}} <i class="far fa-edit"></i>
                        </a>
                      </td>
                      <td class="assign dim text-right">
                        <a href="#">
                          Assign Task &nbsp;<i class="far fa-edit"></i>
                        </a>
                      </td>
                      <td class="text-right">
                        <button class="todo-edit--button caret" type="button" id="tasks_dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="far fa-play-circle"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="tasks_dropdown">
                          <li><a class="dropdown-item disabled">Task Actions</a></li>
                          <li class="divider"></li>
                          <li>
                            <a style="cursor: pointer;" onclick="open_rename_todo_task_model('{{$task->id}}','{{$task->name}}')" class="dropdown-item">
                              <i class="far fa-edit"></i>&nbsp; Edit
                            </a>
                          </li>
                          <li class="divider"></li>
                          <li>
                            <a onclick="delete_todo_taks('{{$task->id}}')" class="dropdown-item" style="cursor: pointer;">
                              <i class="fa fa-times"></i>&nbsp; Delete
                            </a>
                          </li>
                        </ul>
                      </td>
                    </tr>
                    @endforeach
                  </table>
                  <a onclick="openAddNewTaskModel('{{$project_todo["id"]}}')" style="cursor: pointer;font-size: 14px;color: blue;"><i class="fa fa-chevron-right fa-sm" style="font-size: 11px;"></i> Add new task</a>
                  @else
                  <div class="add_new_tasks">
                    <a onclick="openAddNewTaskModel('{{$project_todo["id"]}}')" class="add_new_todo_task" id="add_new_todo_task">
                      <i class="fa fa-tasks"></i>
                      <p>Add a new task</p>
                    </a>
                  </div>
                  @endif
                </div>
              @endforeach
            @endif
            <div>
              {{-- <table class="table table-sm">
                <tbody>
                  @if (!$todo_list->isEmpty())
                    @foreach ($todo_list as $project_todo)
                      <tr>
                        <td><i class="fas fa-ellipsis-v"></i>&nbsp;&nbsp;</td>
                        <td><a >{{$project_todo->name}}</a></td>
                        @if ($project_todo->assign_to == 0)
                          <td>Assign Task</td>
                        @else
                          <td>Ammar Malik</td>
                        @endif
                        <td class="text-right">
                          <div class="dropdown">
                            <button class="todo-edit--button" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="outline: none;box-shadow: none;">
                              <i class="fa fa-caret-down"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                              <a class="dropdown-item" href="/projects/template/todo/delete/{{$project_todo->id}}"> &nbsp;<i class="fas fa-trash"></i>&nbsp; Delete</a>
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
              </table> --}}
            </div>
          </div>
        </div>
    </div>
    
{{-- ========ADD TODO MODAL======== --}}
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add To-do List</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('template_todo.add') }}" method="POST">
          @csrf
          <div class="form-group">
            <label for=""><b>Name:</b></label>
            <input type="text" class="form-control" name="name" placeholder="Enter Name" required>
            @error('name')
              <span>
                  <p style="font-size:13px!important; color: #fd0710!important;">{{ $message }}*</p>
              </span>
            @enderror
            <input type="hidden" name="id" value="{{$template_id}}">
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
        <form action="{{route('todo_template.update')}}" method="POST">
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
          </div>
          <div class="text-right">
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
{{-- ========Add TODO Task MODAL======== --}}
<div class="modal fade" id="add_task_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add New Task</h5>
      </div>
      <div class="modal-body">
        <form action="{{route('todo_template_task.add')}}" method="POST">
          @csrf
          <div class="form-group">
            <label for="">Task</label>
            <input type="text" class="form-control" placeholder="Enter Task" required name="name">
            @error('name')
              <span>
                  <p style="font-size:13px!important; color: #fd0710!important;">{{ $message }}*</p>
              </span>
            @enderror
            <input type="hidden" name="todo_id" id="todo_id" />
          </div>
          <div class="text-right">
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
{{-- ========Add TODO Task MODAL======== --}}
<div class="modal fade" id="edit_task_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Rename Task</h5>
      </div>
      <div class="modal-body">
        <form action="{{route('todo_template_task.update')}}" method="POST">
          @csrf
          <div class="form-group">
            <label for="">Task</label>
            <input type="text" class="form-control" placeholder="Enter Task" required name="name" id="name">
            @error('name')
              <span>
                  <p style="font-size:13px!important; color: #fd0710!important;">{{ $message }}*</p>
              </span>
            @enderror
            <input type="hidden" name="id" id="id" />
          </div>
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
    function openAddNewTaskModel(id)
    {
      $("#add_task_model #todo_id").val(id);
      $("#add_task_model").modal('show');
    }
    function open_rename_todo_task_model(id, name)
    {
      $("#edit_task_model #id").val(id);
      $("#edit_task_model #name").val(name);
      $("#edit_task_model").modal('show');
    }
    function delete_todo_taks(id)
    {
      csrf = $("meta[name='csrf-token']").attr('content');
      $.ajax({
        type: 'POST',
        url: '/projects/template/todo/task/delete',
        data: {_token:csrf, id:id},
        success: function(res)
        {
          if(res == 1)
          {
            location.reload();
          }
        }
      });
    }
    function clear_all_tasks(id)
    {
      csrf = $("meta[name='csrf-token']").attr('content');
      $.ajax({
        type: 'POST',
        url: '/projects/template/todo/clear/tasks',
        data: {_token:csrf, id:id},
        success: function(res)
        {
          if(res == 1)
          {
            location.reload();
          }
        }
      });
    }
    function delete_todo(id)
    {
      csrf = $("meta[name='csrf-token']").attr('content');
      $.ajax({
        type: 'POST',
        url: '/projects/template/todo/delete',
        data: {_token:csrf, id:id},
        success: function(res)
        {
          console.log(res);
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
 