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
  <link rel='stylesheet' href='css/dropzone.css' type='text/css' />
  <link rel='stylesheet' href='css/basic.css' type='text/css' />
  <link rel='stylesheet' href='fontawesome/css/all.min.css' type='text/css' />
</head>
<body class="projectPage planPage">

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
      <div class="jumbotron">
        <div class="row">
          <div class="col-md-6">
            <button class="btn btn-muted btn1">
              <i class="fa fa-download"></i>
              Download Plans
            </button>
            <button class="btn btn-muted" id="openFile" onclick="openUploadPlanModal()">
              <i class="fa fa-upload"></i>
              Upload Plans
            </button>
            <button class="btn btn-muted" data-toggle="modal" data-target="#addGroup">
              <i class="fa fa-folder"></i>
              Add a group
            </button>
          </div>
          <div class="col-md-6">
            <form class="form-inline my-2 my-lg-0" style="float: right;">
              @csrf
              <label class="sr-only" for="inlineFormInputGroupUsername">Search Plans</label>
              <div class="input-group">
                <input type="text" class="form-control" id="searchInput" onkeyup="searchPlans()" id="inlineFormInputGroupUsername" placeholder="Find plans by name" name="search" required>
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <button type="submit" class="project_search_button"><i class="fas fa-search"></i></button></div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      @if($errors->any())
        @if($errors->first() == 'sizeError')
          <div class="alert alert-warning">
            <i class="fa fa-info" style="font-size: 14px;"></i>
            <p style="font-size: 14px;">
              File size should be less then 25MB.
            </p>
          </div>
        @endif
      @endif
      <br>
      @if(!empty($data))
      @foreach($data as $d)
      <div class="plan-list-header">
        <h3 class="heading" style="font-size: 24px;">
          {{$d['name']}}({{$d['count']}})
          <button class="no-bg" data-toggle="dropdown">
            <i class="far fa-play-circle" style="transform: rotate(90deg);font-size: 15px;"></i>
          </button>
          <ul class="dropdown-menu" id="plansGroupUL" role="menu">
            <li class="disabled dropdown-item"><a draggable="false">Group Actions</a></li>
            <li class="divider"></li>
            <li class="dropdown-item">
              <a style="cursor: pointer;" onclick="openGroupRenameModal('{{$d['name']}}','{{$d['id']}}')" draggable="false"><i class="fa fa-italic"></i> Rename</a>
            </li>
            <li class="divider"></li>
            <li class="dropdown-item">
              <a style="cursor: pointer;" onclick="openDeletePlansModal('{{$d['name']}}','{{$d['id']}}')" draggable="false"><i class="fa fa-times"></i> Delete Plans</a>
            </li>
            <li class="dropdown-item">
              <a style="cursor: pointer;" onclick="openDeleteGroupModal('{{$d['name']}}','{{$d['id']}}')" draggable="false"><i class="fa fa-trash-alt"></i> Delete Group</a>
            </li>
          </ul>
        </h3>
      </div>
      @if($errors->any())
        @if($errors->first() == 'constructionError')
          <div class="alert alert-warning">
            We are still working on Plans...!
          </div>
        @endif
      @endif
      <table class="table table-hover">
        <thead>
          <tr>
            <th></th>
            <th></th>
            <th>Plan Name</th>
            <th>Last Modified</th>
            <th>Linked Stages</th>
          </tr>
        </thead>
        @if(!$d['plan']->isEmpty())
        <tbody id="attachs">
            @foreach($d['plan'] as $p)
              <tr>
                <td></td>
                <td><img src="img/plans/{{$p->plan_image}}" style="width: 70px" class="img-fluid" /></td>
                <td>
                  <a href="/project/{{$project_salt}}/plans/{{$p->salt}}/editor">
                    {{$p->name}}
                  </a>
                </td>
                <td><?php echo date('d M, Y h:i A', strtotime($p['updated_at'])); ?></td>
                <td>
                  @if($p['total_stages'] == 0)
                    <small>
                      <i>No Stages</i>
                    </small>
                  @else
                     <span class="badge badge-success">
                       {{$p['total_stages']}}
                     </span>
                     @foreach($p['stages'] as $stage)
                      <i class="fa fa-tag" style="font-size: 12px;color: #F89C0E;"></i>
                      <span style="font-size: 14px;color: #F89C0E;font-weight: 600;">{{$stage->name}}</span>
                     @endforeach
                  @endif
                </td>
              </tr>
            @endforeach
        </tbody>
        @else
          <tr>
            <td colspan="5">
              <div class="no-plans">
            <i class="fa fa-file-import"></i>
            <p><button class="no-bg" id="openFallBack" onclick="openUploadPlanModal()" style="cursor: pointer;">Click Here To Upload Plans</button></p>
            <input name="id" type="hidden" value="{{$project_id}}" />
              <div class="fallback">
                <input name="file" type="file" id="dropzoneInput" multiple style="display: none!important;" />
              </div>
              <p id="file_error" style="color: red;"></p>
          </div>
            </td>
          </tr>
        @endif
      </table>
      @endforeach
      @else
        <div class="text-center" style="padding-top: 20px;">
          <h2 style="font-weight: 300; color: #C1C1C1;">
            There are no plans or groups on this project.
          </h2>
          <br>
          <button class="btn btn-primary btn-lg" id="openUploadPlanModal">
            <i class="far fa-folder"></i>
            Add a Group
          </button>
        </div>
      @endif
    </div>
    
{{-- ========ADD GROUP MODAL======== --}}
<div class="modal fade" id="addGroup" tabindex="-1" role="dialog" aria-labelledby="addModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Create a new group</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('group.add') }}" method="POST">
          @csrf
          <div class="form-group">
            <label for=""><b>Name:</b></label>
            <input type="text" class="form-control" name="name" placeholder="Enter group name.." required>
            @error('name')
              <span>
                  <p style="font-size:13px!important; color: #fd0710!important;">{{ $message }}*</p>
              </span>
            @enderror
            <input type="hidden" name="project_id" value="{{$project_id}}">
          </div>
          <button type="submit" class="btn btn-primary">Add Group</button>
        </form>
      </div>
    </div>
  </div>
</div> 
{{-- ========RENAME GROUP MODAL======== --}}
<div class="modal fade" id="groupRenameModal" tabindex="-1" role="dialog" aria-labelledby="addModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Rename group</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('group.rename') }}" method="POST">
          @csrf
          <div class="form-group">
            <label for=""><b>Name:</b></label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Enter group name.." required>
            @error('name')
              <span>
                  <p style="font-size:13px!important; color: #fd0710!important;">{{ $message }}*</p>
              </span>
            @enderror
            <input type="hidden" id="id" name="id" value="">
          </div>
          <button type="submit" class="btn btn-primary">Add Group</button>
        </form>
      </div>
    </div>
  </div>
</div>
{{-- ========DELETE PLANS MODAL======== --}}
<div class="modal fade" id="deletePlansModal" tabindex="-1" role="dialog" aria-labelledby="addModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Delete All Plans in Group</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('group.deleteplans') }}" method="POST">
      @csrf
        <div class="modal-body">
          <div class="form-group">
            <p>
              Permanently delete all plans in the Group <b id="name">"asdasd"</b>?
            </p>
            <p>
              <strong>This cannot be undone.</strong>
            </p>
            <input type="hidden" id="id" name="id" value="">
          </div>
        </div>
        <div class="modal-footer">
          <div class="text-right">
            <button type="submit" class="btn btn-danger">Delete All Plans</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div> 
{{-- ========DELETE PLANS MODAL======== --}}
<div class="modal fade" id="deleteGroupModal" tabindex="-1" role="dialog" aria-labelledby="addModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Delete Group</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('group.deletegroup') }}" method="POST">
      @csrf
        <div class="modal-body">
          <div class="form-group">
            <p>
              Permanently <b>delete</b> the Group <b id="name"></b> and all its Plans?
            </p>
            <strong>This cannot be undone.</strong>
            <input type="hidden" id="id" name="id" value="">
          </div>
        </div>
        <div class="modal-footer">
          <div class="text-right">
            <button type="submit" class="btn btn-danger">Delete All Plans</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div> 
{{-- ======== UPLOAD PLANS MODAL======== --}}
<div class="modal fade" id="uploadPlansModal" tabindex="-1" role="dialog" aria-labelledby="addModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Upload Plans</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('upload.plan') }}" method="POST" enctype="multipart/form-data">
      @csrf
        <div class="modal-body">
          <div class="form-group">
            <label style="font-size: 16px;font-weight: 600;">To Group</label>
            <select name="group_id" class="form-control">
              @foreach($groups as $group)
                <option value="{{$group->id}}">{{$group->name}}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <input type="radio" name="type" value="plan" required checked /> <span>Import Plan</span><br>
            <input type="radio" name="type" value="attachment" required/> <span>Save as attachment</span>
          </div>
          <div class="form-group">
            <input type="file" name="file[]" id="planFile" style="display: none;" multiple>
            <input type="hidden" name="project_id" value="{{$project_id}}">
            <br>
            <span id="choosePlanFile" style="border:1px dashed #777;padding: 10px;cursor: pointer;">
              <i class="fa fa-upload"></i>
              Choose a File
            </span>
          </div>
        </div>
        <div class="modal-footer">
          <div class="text-right">
            <button type="submit" class="btn btn-primary">Upload</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/popper.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="fontawesome/js/all.min.js"></script>
  <script type="text/javascript" src="js/dropzone.js"></script>
  <script src="js/ajax.js"></script>
  <script>
    $('#bottom_header .tab2').addClass('active');    
    $('#bottom_header .tab1').removeClass('active');
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    });

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var project_id = $('#dropzone input[name="id"]').val();
    function fetchAttachments()
    {
      // $('#attachs').html("");
      $.ajax({
        type: 'POST',
        url: '/projects/plans/fetch',
        data: {_token: CSRF_TOKEN, project_id: project_id},
        success: function(res)
        {
          res.forEach( function(item){
             let tr = '<tr><td></td><td><img src="img/plans/'+item.image+'" class="img-fluid" style="width:40px;"/></td><td><a href="/project/'+item.project_salt+'/plans/'+ item.plan_salt+'/editor">'+item.name+'</a></td><td>'+item.date+'</td><td></td></tr>';
             // $('#attachs:last-child').append(tr);
          })
          if(res.length > 0){
            // $("#attachs").html(res);
          }
        }
      });
    }
    function searchPlans(){
      // Declare variables
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("searchInput");
      filter = input.value.toUpperCase();
      table = document.getElementById("attachs");
      tr = table.getElementsByTagName("tr");
    
      // Loop through all table rows, and hide those who don't match the search query
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[2];
        if (td) {
          txtValue = td.textContent || td.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }
      }
    }
    function openGroupRenameModal(name, group_id)
    {
      $("#groupRenameModal #id").val(group_id);
      $("#groupRenameModal #name").val(name);
      $("#groupRenameModal").modal('show');
    }
    function openDeletePlansModal(name, id)
    {
      $("#deletePlansModal #name").html(name);
      $("#deletePlansModal #id").val(id);
      $("#deletePlansModal").modal('show');
    }
    function openDeleteGroupModal(name, id)
    {
      $("#deleteGroupModal #name").html(name);
      $("#deleteGroupModal #id").val(id);
      $("#deleteGroupModal").modal('show');
    }
    $(document).ready(function(){
      fetchAttachments();
      $("#openFile").click(function(){
        $("#dropzone").click();
      });
    });

    Dropzone.options.dropzone =
      {
        maxFilesize: 25,
        acceptedFiles: ".jpeg,.jpg,.png,.gif,.pdf,.csv",
        addRemoveLinks: true,
        timeout: 25000,
        success: function(file, response) 
        {
          fetchAttachments();
        },
        error: function(file, response)
        {
           $("#file_error").html(response);
        }
      };

    $("#openFallBack").on('click',function(){
      $("#uploadPlansModal").modal('show');
    });
    $("#choosePlanFile").on('click', function(){
      $("#planFile").click();
    })
    function openUploadPlanModal()
    {
      $("#uploadPlansModal").modal('show');
    }
  </script>
</body>
</html>
 