@include('admin.includes.header')
@include('admin.includes.sidebar')
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-5 align-self-center">
                        <h4 class="page-title">Edit User</h4>
                        <div class="d-flex align-items-center">
                        </div>
                    </div>
                    <div class="col-7 align-self-center">
                        <div class="d-flex no-block justify-content-end align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="#">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Library</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- row -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <!-- <h4 class="card-title">General Form</h4> -->
                                <!-- <h6 class="card-subtitle"> All with bootstrap element classies </h6> -->
                                @foreach($user_details as $user_details )
                                <form action="{{ route('user.updated', $user_details->id)}}" method="POST" class="m-t-30">
                                    @csrf
                                    <div class="form-group">
                                        <label for="exampleInputName">Name</label>
                                        <input type="text" name="name" class="form-control" id="exampleInputName" value="{{ $user_details->name }}"  aria-describedby="emailHelp" placeholder="Enter Name">
                                        @error('name')
                                            <p class="ml-4 text-danger" >{{$message}}</p>
                                        @enderror
                                    </div>
                                     <div class="form-group">
                                        <label for="exampleInputCompany">Company</label>
                                        <input type="text" name="company" class="form-control" id="exampleInputCompany" value="{{ $user_details->company }}" aria-describedby="emailHelp" placeholder="Company Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPhone">Phone No</label>
                                        <input type="number" name="phone" class="form-control" id="exampleInputPhone" value="{{ $user_details->phone }}" placeholder="Phone No">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email address</label>
                                        <input type="email" name="email" class="form-control" id="exampleInputEmail1" value="{{ $user_details->email }}" aria-describedby="emailHelp" placeholder="Enter Email">
                                        @error('email')
                                            <p class="ml-4 text-danger" >{{$message}}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputcheck">Payment Package</label>
                                        <p class="mb-0"><input type="radio" name="licences" value="0"> Monthly</p>
                                        <p><input type="radio" name="licences" value="1"> Yearly</p>
                                    </div>
                                     @error('licences')
                                        <p class="ml-4 text-danger" >{{$message}}</p>
                                    @enderror
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </form>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
@include('admin.includes.footer')