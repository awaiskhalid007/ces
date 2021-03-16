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
      <h5>{{$template_name}}</h5>
    </div>
    <section class="projects_tabs">
      <div class="container">
        {{-- @include('dashboard.partials.bottom-header') --}}
        <ul id="bottom_header">
          <li class="tab tab1 active"><a>Project</a></li>
          <li class="tab tab2" style="cursor: no-drop;"><a>Plans</a></li>
          <li class="tab tab3" style="cursor: no-drop;"><a>Worksheets</a></li>
          <li class="tab tab4" style="cursor: no-drop;"><a>Quantities</a></li>
        </ul>
      </div>
    </section>
    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="row">
          {{-- Sidebar Start--}}
          <div class="col-lg-2">
              @include('dashboard.partials.template-sidebar')
          </div>
          {{-- Sidebar End--}}

          <div class="col-lg-10 add-details-div">
           <div class="row">
               <div class="col-md-6">
                <h3>Who Has Access</h3>
                <hr>
                  <div class="container py-2" style="border: 1px solid #E5E5E5; border-radius: 5px;"> 
                      <strong>{{$user[0]->name}}</strong> <span class="badge badge-success">You</span>
                      <p class="mb-0">{{$user[0]->email}}</p>
                  </div>
                  @if(!empty($invitations))
                    @foreach($invitations as $invite)
                    <div class="container py-2" style="border: 1px solid #E5E5E5; border-radius: 5px;margin-top: 10px;"> 
                        <strong>{{$invite["user_name"]}}</strong>
                        <span class="badge badge-danger" style="color: white;">{{$invite['user_company']}}</span>
                        @if($invite['status'] == 0)
                          <span class="badge badge-muted" style="background:grey;color: white;">Pending</span>
                        @else
                          <span class="badge badge-success" style="color: white;">Active</span>
                        @endif
                        <p class="mb-0">{{$invite["user_email"]}}</p>
                    </div>
                    @endforeach
                  @endif
                </div>
            <div class="col-md-6">
                  <div class="container-fluid">
                    <h3>Invite People</h3>
                    @if($errors->any())
                      @if($errors->first() == 'invited')
                        <p style="color:green;font-size: 16px;">*User invited successfully.</p>
                      @endif
                    @endif
                  <hr>
                  <input type="email" class="form-control" id="emailInput" placeholder="Enter email address">    
                  <hr>
                  </div>
                  <div class="container-fluid" id="usersList">
                    
                  </div>
            </div>
           </div>
          </div>
          
        </div>
      </div>
    </div>
  </div>
  


  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="fontawesome/js/all.min.js"></script>
  <script src="js/ajax.js"></script>

  <script>
    $(document).ready(function(){

      $("#emailInput").keyup(function(){
        let value = $("#emailInput").val();
        let size = value.length;
        if(size > 5)
        {
          $.ajax({
            type: 'POST',
            url: '/template/sharing/search',
            data: {"_token": "{{ csrf_token() }}", "value": value},
            success: function(res)
            {
              console.log(res);
              let html = '';
              $.each(res, function(index, user){
                html += '<div><form method="POST" action="{{route('template.inviteuser')}}">@csrf<input type="hidden" name="id" id="user_id" value="'+user.id+'" /><input type="hidden" name="template_salt" id="template_salt" value="{{$template_salt}}" /><button class="no-bg"><p class="py-2 px-3 mb-0" style="border: 1px solid #E5E5E5; border-radius: 3px;"><span class="pr-2 small"><i class="fas fa-user"></i></span>'+ user.name +' ('+user.email+')</p></button></form></div>';
              });
              
              $("#usersList").html(html);
            }
          });
        }
      });
    });
  </script>
</body>
</html>
