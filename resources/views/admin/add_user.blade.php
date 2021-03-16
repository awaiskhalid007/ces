@include('admin.includes.header')
@include('admin.includes.sidebar')
       
        <div class="page-wrapper">
           
            <div class="container-fluid">
              
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Add Admin</h4>
                               
                                <form accept="{{ route('admin.add')}}" method="POST" class="m-t-30">
                                    @csrf
                                    <div class="form-group">
                                        <label for="exampleInputName">Name</label>
                                        <input type="text" class="form-control" id="exampleInputName" name="name" value="{{ old('name')}}" aria-describedby="emailHelp" placeholder="Enter Name">
                                    
                                     @error('name')
                                        <p class="mb-0 ml-4 text-danger" >{{$message}}</p>
                                    @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email address</label>
                                        <input type="email" class="form-control" id="exampleInputEmail1" name="email" value="{{ old('email')}}" aria-describedby="emailHelp" placeholder="Enter Email">
                                         @error('email')
                                        <p class="mb-0 ml-4 text-danger" >{{$message}}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Password</label>
                                        <input type="password" class="form-control" id="exampleInputPassword1" name="password"   placeholder="Password">
                                   
                                     @error('password')
                                        <p class="mb-0 ml-4 text-danger" >{{$message}}</p>
                                    @enderror
                                     </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
@include('admin.includes.footer')