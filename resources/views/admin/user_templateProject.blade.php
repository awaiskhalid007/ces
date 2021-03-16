@include('admin.includes.header')
@include('admin.includes.sidebar')
        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12 col-lg-4" style="display: none;">
                        <div class="card bg-light-warning no-card-border">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="m-r-10">
                                        <span>Wallet Balance</span>
                                        <h4>$3,567.53</h4>
                                    </div>
                                    <div class="ml-auto">
                                        <div style="max-width:130px; height:15px;" class="m-b-40">
                                            <canvas id="balance"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- column -->
                    <div class="col-sm-12 col-lg-4" style="display: none;">
                        <div class="card bg-light-success no-card-border">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="m-r-10">
                                        <span>Estimated Sales</span>
                                        <h4>5769</h4>
                                    </div>
                                    <div class="ml-auto">
                                        <div class="gaugejs-box">
                                            <canvas id="foo" class="gaugejs" height="50" width="100">guage</canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card bg-light">
                            <div class="card-body">
                                <div class="d-flex no-block align-items-center m-b-10">
                                    <h4 class="card-title">Project Templates</h4>
                                </div>
                                <div class="table-responsive">
                                    <table id="file_export" class="table bg-white table-bordered nowrap display">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Template Name</th>
                                                <th>Status</th>
                                                <th>Created at</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                             @php
                                             $i = 1
                                            @endphp
                                            
                                            @forelse($data as $data)
                                           <tr>
                                            <td>{{ $i++}}</td>
                                            <td>{{ $data['temp_name']}}</td>
                                             <td>
                                                @if( $data['status'] == 1)
                                                        <p class="badge badge-primary" style="font-size: 13px;">
                                                        ACTIVE</p>
                                                    @else
                                                        <p class="badge badge-danger" style="font-size: 13px;">TRASHED</p>
                                                    @endif
                                            </td>
                                              <td>{{ $data['created_at']->format('d-m-y')}}
                                              </td>
                                              <td>
                                              <div class="dropdown">
                                                    {{-- trashed icon --}}
                                                    <a href="{{ route('tempProject.del',$data['temp_id'])}}"><i class="far fa-trash-alt mx-3"></i></a>
                                                    {{-- Eyes/Details --}}
                                                    <a class="btn dropdown-toggle" href="javascript::void(0)" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-eye "></i>
                                                    </a>

                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                    <a class="dropdown-item" href="{{ route('tempProject.stage', $data['temp_id'])}}">Template Stage</a>
                                                    <a class="dropdown-item" href="{{ route('tempProject.todos', $data['temp_id'])}}">Template Todos</a>
                                                    </div>
                                                    </div>
                                                </td>
                                             @empty
                                             <td colspan="5" >
                                                 <p style="text-align: center;">
                                                 No Active Templates</p>
                                             </td>   
                                           </tr>
                                           @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@include('admin.includes.footer')