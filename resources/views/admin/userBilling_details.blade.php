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
                        <h4 class="page-title">Billing Details</h4>
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
                               <strong style="font-size: 18px;">User Name:</strong>
                               <p>{{ $data->name}}</p>
                           </div>
                           <div class="col-md-6">
                               <strong style="font-size: 18px;">Card No:</strong>
                               
                               @if($data->number == '')
                                    <p>Not Available</p>
                                  @else
                                    <p>{{ $data->number}}</p>
                                @endif
                           </div>
                        </div>
                           <div class="row">
                             <div class="col-md-6">
                                 <strong style="font-size: 18px;">CVV:</strong>
                                 <br>
                                   @if($data->number == '')
                                    <p>Not Available</p>
                                  @else
                                    <p>{{ $data->cvv}}</p>
                                @endif
                             </div>
                             <div class="col-md-6">
                                 <strong style="font-size: 18px;">Expiry Date:</strong><br>
                                @if($data->number == '')
                                    <p>Not Available</p>
                                  @else
                                    <p>{{ $data->expiry}}</p>
                                @endif
                             </div>
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