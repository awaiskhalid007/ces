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
                        <h4 class="page-title">Trashed Project Details</h4>
                        <div class="d-flex align-items-center">
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
                       <div class="container">
                        @foreach($data as $data)
                        <div class="row">
                           <div class="col-md-6">
                               <strong style="font-size: 18px;">Project Name:</strong>
                               <p>{{ $data['project_name']}}</p>
                           </div>
                           <div class="col-md-6">
                               <strong style="font-size: 18px;">Discription:</strong>
                               <br>
                               @if(empty($data['description'])) 
                                    <p>Not Available</p>
                                @else
                                    <p>{{ $data['description']}}</p>
                                @endif
                           </div>
                        </div>
                         <div class="row">
                           <div class="col-md-6">
                               <strong style="font-size: 18px;">Client Name:</strong>
                               <br>
                                   @if(empty($data['client_name'])) 
                                        <p>Not Available</p>
                                    @else
                                         <p> {{ $data['client_name']}}</p>
                                   @endif
                           </div>
                           <div class="col-md-6">
                               <strong style="font-size: 18px;">Status:</strong><br>
                               <span class="label label-lg" style="background-color:{{$data['color']}}">{{$data['status']}}</span>
                           </div>
                        </div>
                         <div class="row">
                           <div class="col-md-6">
                               <strong style="font-size: 18px;">Label:</strong>
                              <br>
                               <span class="label" style="background-color:{{$data['label_color']}}">{{$data['label']}}</span>
                           </div>
                           <div class="col-md-6">
                               <strong style="font-size: 18px;">Owner:</strong>
                               <p>{{ $data['username']}} </p>
                           </div>
                        </div>
                         <div class="row">
                           <div class="col-md-6">
                               <strong style="font-size: 18px;">Created At:</strong>
                               <p>{{ $data['created_at']->format("m-d-Y") }}</p>
                           </div>
                        </div>
                       </div>
                       @endforeach
                    </div>
                </div>
                
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
@include('admin.includes.footer')