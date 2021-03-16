<!DOCTYPE html>
<html lang="en">
<head>
    <base href="/">
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Liceces</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel='stylesheet' href='css/style.css' type='text/css' />
    <link rel='stylesheet' href='fontawesome/css/all.min.css' type='text/css' />
</head>
<body>

 @include('dashboard.partials.header')


  <section id="wrapper">
        <div class="col-md-12">
            <div class="row">
                @include('dashboard.partials.setting-sidebar')
                <div class="col-lg-9 col-md-12 col-sm-12 rightpanel ">
                    <div class="container-fluid mb-4 p-4 card">
                        <div class="row">
                            <div class="col-md-7 col-sm-7 col-xs-7">
                                <h3>User Lincences <small class="muted xs">(simultaneous)</small></h3>
                                <p class="mb-0">How many users need access to groundplan at the same time?</p>
                            </div>
                            <div class="col-md-5 col-sm-5 col-xs-5">
                                <div class="row topsection">
                                    <div class="col-md-5 col-xs-5 pr-0 firstbtns">
                                        <h1 class="badge badge-primary value p-2" id="licences_quantity" 
                                            style="font-size: 50px; border-radius: 10px;background:#337AB7!important;">
                                            {{$user[0]->licences}}
                                        </h1>
                                        <div class="btn-group-vertical btns">
                                            <button class="btn btn-default btn-sm btnplus increase"><span><i
                                                        class="fa fa-plus"></i></span></button>
                                            <button class="btn btn-default btn-sm btnplus decrease"><span><i
                                                        class="fa fa-minus"></i></span></button>
                                        </div>
                                    </div>
                                    <div class="col-md-7 col-xs-7 mt-3 pl-0 firstbtns">
                                        <button class="btn btn-primary btnblue" id="updateLicences"><span><i
                                                    class="far fa-save"></i></span> Update</button>
                                        <!-- + add more Lincences btn  -->
                                        <button class="btn btn-primary btn-sm btngreen" id="updateLicences2" style="display: none;"><span><i
                                                    class="fa fa-plus"></i></span></button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    @if($errors->any())
                        @if($errors->first() == 'user_invited')
                            <div class="alert alert-success">User invited successfully and an email is sent.</div>
                        @elseif($errors->first() == 'active_user')
                            <div class="alert alert-warning">Can not create a user with this email. This email is already in use by another Groundplan account.</div>
                        @endif
                    @endif
                    <div class="card profile" style="width: 100%">
                        <div class="card-header wordstrong">
                            <div style="float: right;">
                                <div class="dropdown custom">
                                  <button type="button" class="btn btn-muted no-bg dropdown-toggle text-primary" data-toggle="dropdown" id="dropdownMenuButton">
                                    Options <span class="caret"></span>
                                  </button>
                                  <ul class="dropdown-menu pull-right" aria-labelledby="dropdownMenuButton">
                                    <li class="disabled">
                                      <a>Display Options</a>
                                    </li>
                                    <li class="divider"></li>

                                    <li class="">
                                      <a>
                                        <input type="checkbox" name="type" value="0" onclick="filter()">
                                       Invitations</a>
                                    </li>
                                    <li>
                                      <a><input type="checkbox" name="type" value="1" onclick="filter()"> Active Users</a>
                                    </li>
                                    <li class="">
                                      <a><input type="checkbox" name="type" value="2" onclick="filter()"> Deactivated Users</a>
                                    </li>

                                  </ul>
                                </div>
                            </div>

                            <p class="mb-0" style="font-weight: 600;">Users</p>
                        </div>
                        <div class="container-fluid p-0">

                            <table class="table" id="UserTable">
                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email(Username)</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Status</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td>{{$user[0]->name}} <span class="badge badge-success">You</span></td>
                                        <td>{{$user[0]->email}}</td>
                                        <td>Administrator</td>
                                        <td><span class="badge badge-success">Active</span></td>
                                        <td>
                                        <th scope="col">
                                            <div class="dropdown">
                                                <button class="btn py-0" type="button" id="dropdownMenuButton"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="far fa-play-circle fa-rotate-90"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <li class="dropdown-item disabled">User Actions</li>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="setup/profile"><span><i class="fa fa-cog"></i></span>&nbsp;&nbsp;My Profile</a>
                                                </div>
                                            </div>
                                        </th>
                                        </td>
                                    </tr>
                                    @if(!$invitations->isEmpty())
                                        @foreach($invitations as $user)
                                        <tr>
                                            <td>{{$user->name}}</td>
                                            <td>{{$user->email}}</td>
                                            <td>
                                                @if($user->type == 0)
                                                    User
                                                @else
                                                    Administrator
                                                @endif
                                            </td>
                                            <td>
                                                @if($user->status == 0)
                                                    <span class="badge badge-warning">Pending</span>
                                                @elseif($user->status == 1)
                                                    <span class="badge badge-success">Active</span>
                                                @elseif($user->status == 2)
                                                    <span class="badge badge-dark">Deactivated</span>
                                                @endif
                                            </td>
                                            <td>
                                            <th scope="col">
                                                <div class="dropdown">
                                                    <button class="btn py-0" type="button" id="dropdownMenuButton"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="far fa-play-circle fa-rotate-90"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <li class="dropdown-item disabled">User Actions</li>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item" href="profile.html">
                                                            <span>
                                                                <i class="fa fa-cog"></i> Profile
                                                            </span>
                                                        </a>
                                                        <div class="dropdown-divider"></div>
                                                        @if($user->status == 1)
                                                        <form action="{{route('user.deactivate')}}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$user->id}}">
                                                        <button class="dropdown-item no-bg" href="profile.html">
                                                            <span>
                                                                <i class="fa fa-ban"></i> Deactivate
                                                            </span>
                                                        </button>
                                                        </form>
                                                        @elseif($user->status == 2)
                                                        <form action="{{route('user.activate')}}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$user->id}}">
                                                        <button class="dropdown-item no-bg">
                                                            <span>
                                                                <i class="fa fa-check"></i> Reactivate
                                                            </span>
                                                        </button>
                                                        </form>
                                                        @endif
                                                    </div>
                                                </div>
                                                <!-- <div class="btn-group">
                                                    <button type="button" class="btn dropdown-toggle "
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="true"></button>

                                                    <div class="dropdown-menu">
                                                        <li class="dropdown-item disabled">Display Options</li>
                                                        <div class="dropdown-divider"></div>
                                                        <li class="dropdown-item"><input type="checkbox" name="" id="">
                                                            Invitations</li>
                                                    </div>
                                                </div> -->
                                            </th>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="container-fluid p-0">
                            <div class="card-header card-bottom">
                                <!-- model for user btn  -->
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#myModal"><span><i class="fa fa-plus"></i> </span>
                                    User</button>
                                <!-- Modal -->
                                <div class="modal fade" id="myModal" role="dialog">
                                    <div class="modal-dialog">

                                        <!-- Modal content-->
                                      <form action="{{route('invite.user')}}" method="POST">
                                      @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Invite User</h4>
                                                <button type="button" class="close"
                                                    data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="name">Name</label>
                                                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter name">
                                                </div>
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter email address">
                                                </div>
                                                {{-- <input type="checkbox" value="1" id="check" name="type">
                                                <label for="check">Administrator</label>
                                                <p>Can manage users and billing information.</p> --}}
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-primary">Submit</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                      </form>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="container-fluid mt-2">
                        <a style="float: right;color: #337AB7;" href="/setup/user/activity"> <span><i
                                    class="fa fa-chevron-right"></i></span> Account Activity</a>
                    </div>
                </div>
            </div>

        </div>
  </section>

<!-- POPUPS -->
<div class="modal fade" id="licenceUpdate" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
               <p class="text">
                   <i class="fa fa-check"></i>
                   <span>Record updated successfully.</span>
               </p>
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
        function filter()
        {
          var input, filter, table, tr, td, i, txtValue;

          $('input[name="type"]:checked').each(function() {
            input = this.value;
            if(input == 0)
            {
                filter = 'PENDING';
            }else if(input == 1)
            {
                filter = 'ACTIVE';
            }else if(input == 2)
            {
                filter = 'DEACTIVATED';
            }

            table = document.getElementById("UserTable");
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[3];
                if (td) {
                  txtValue = td.textContent || td.innerText;
                  if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                  } else {
                    tr[i].style.display = "none";
                  }
                }
            }
          });
        }
        var path = window.location.href; // because the 'href' property of the DOM element is the absolute path
         $('ul#navlinks a').each(function() {
          if (this.href === path) {
           $(this).addClass('active');
          }
         });

        let count = $("#licences_quantity").html();
        let add = 0;
        let value = document.querySelector('.value');
        let btns = document.querySelectorAll('.btnplus');
        let blue = document.querySelector('.btnblue');
        let green = document.querySelector('.btngreen');

        btns.forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                const stylebtn = e.currentTarget.classList;
                if (stylebtn.contains("decrease")) {
                    count--;
                    add--;
                    green.innerHTML = '<span><i class="fa fa-minus"></i></span> Remove licences';
                    if (count < 1) {
                        count = 1;
                    }

                } else if (stylebtn.contains("increase")) {
                    count++;
                    add++;
                } else {
                    count = 1;
                }

                if (count > 1) {
                    green.style.display = "block";
                    blue.style.display = "none";
                    let countnew = count -1;
                    green.innerHTML = '<span><i class="fa fa-plus"></i></span> Add '+add+' licences';
                } else {
                    blue.style.display = "block";
                    green.style.display = "none";
                }

                value.textContent = count;
            });
        });
       
        var CSRF_TOKEN = $("meta[name='csrf-token']").attr('content');

        $("#updateLicences").click(function(){
            var value = $("#licences_quantity").html();
            $.ajax({
                url: '/setup/users/licences/update',
                type: 'POST',
                data:{_token: CSRF_TOKEN, value:value},
                success: function(res)
                {
                    $("#licenceUpdate").modal('show');
                    setTimeout(function(){
                        $("#licenceUpdate").modal('hide');
                    }, 2000);
                }
            });
        })
        $("#updateLicences2").click(function(){
            var value = $("#licences_quantity").html();
            $.ajax({
                url: '/setup/users/licences/update',
                type: 'POST',
                data:{_token: CSRF_TOKEN, value:value},
                success: function(res)
                {
                    $("#licenceUpdate").modal('show');
                    setTimeout(function(){
                        $("#licenceUpdate").modal('hide');
                    }, 2000);
                }
            });
        });
    </script>
</body>
</html>
