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
                        <h4 class="page-title">Change Password</h4>
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
                                @if($errors->any())
                                    @if($errors->first() == 'Success')
                                        <div class="alert alert-success">Password Updated Succeffuly</div>
                                    @endif
                                @endif
                                <!-- <h4 class="card-title">General Form</h4> -->
                                <!-- <h6 class="card-subtitle"> All with bootstrap element classies </h6> -->
                                <form action="{{ route('changed.password')}}" method="POST" class="m-t-30">
                                    @csrf
                                    <div class="form-group">
                                        <label for="exampleInputoldpass">Old Password</label>
                                        <input type="password" class="form-control" id="exampleInputoldpass" name="oldPassword" aria-describedby="emailHelp" placeholder="Old Password">
                                         @error('oldPassword')
                                        <p class="ml-4 text-danger" >{{$message}}*</p>
                                        @enderror
                                        @if($errors->any())
                                            @if($errors->first() == 'WrongPass')
                                                <p class="text-danger ml-2" >Enter Correct Password*</p>
                                            @endif
                                        @endif
                                    </div>
                                     <div class="form-group">
                                        <label for="exampleInputnewPassword">New Password</label>
                                        <input type="password" class="form-control" id="exampleInputnewPassword" name="newPassword" aria-describedby="emailHelp" placeholder="New Password">
                                        @error('newPassword')
                                        <p class="ml-4 text-danger" >{{$message}}*</p>
                                        @enderror                                    
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputconfermPassword">Conferm Password</label>
                                        <input type="password" class="form-control" id="exampleInputconfermPassword" name="confermPassword" placeholder="Conferm Password">
                                        @error('confermPassword')
                                        <p class="ml-4 text-danger" >{{$message}}*</p>
                                        @enderror
                                        @if($errors->any())
                                            @if($errors->first() == 'passNotMatched')
                                                <p class="text-danger ml-2" >Password Not Matched*</p>
                                            @endif
                                        @endif
                                    </div>
                                    <button type="submit" class="btn btn-primary">Change</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
@include('admin.includes.footer')