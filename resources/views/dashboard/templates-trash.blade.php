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
          <li class="tab active"><a href="project-templates/open">Projects Templates</a></li>
          <li class="tab"><a href="takeoff-templates/open">Take Off Templates</a></li>
        </ul>
      </div>
    </section>
    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="row">
          {{-- Sidebar Start--}}
          @include('dashboard.partials.templates-sidebar')
          {{-- Sidebar End--}}
          <div class="col-lg-9">
            <nav class="navbar navbar-expand-lg navbar-light bg-default myprojects--nav">
              <a class="navbar-brand nav--main--item" href="javascript::void(0)">Projects Templates</a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
            </nav>
            <br>
            <b>Name</b>
            <table class="table" style="margin-top:10px;">
              @if(!$templates->isEmpty())
              @foreach($templates as $template)
                <tr>
                  <td class="td--trash--name">{{$template->name}} &nbsp;&nbsp;&nbsp;<span>REMOVED</span></td>
                  <td>
                    <div class="projects-list-right">
                      <div class="projects-listmenu-wrap">
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggl js-toggle-project-menu text-dark" data-toggle="dropdown"><i class="far fa-play-circle fa-rotate-90"></i></a>
                            <ul class="dropdown-menu pull-right" role="menu">
                              <li class="disabled"><a href="#">Template Actions</a></li>
                              <li class="divider"></li>
                              <li>
                                <button class="btn btn-muted" onclick="open_template_rename_modal('{{$template->id}}','{{$template->name}}')" style="margin-left:5px;"><i class="fa fa-pencil-alt"></i> Rename</button>
                              </li>
                              
                              <li class="divider"></li>
                              <li>
                                <a class="btn btn-muted" href="project-templates/open/{{$template->id}}/undo"><i class="fas fa-undo-alt"></i> Restore</a>
                                {{-- <form action="{{route('template.delete')}}" method="POST">
                                  @csrf
                                  <a class="btn btn-muted" value="{{$template->salt}}" name="salt"><i class="fa fa-trash-alt"></i> Delete</a>
                                </form> --}}
                              </li>
                            </ul>
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>
              @endforeach
              @else
                <div class="text-center" style="padding-top: 20px;">
                  <h2 style="font-weight: 300; color: #C1C1C1;">
                    Your trash is empty. 
                  </h2>
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
  </script>  
</body>
</html>
