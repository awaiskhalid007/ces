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
                <!-- ============================================================== -->
                <!-- Sales Summery -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card bg-light">
                            <div class="card-body">
                                <div class="d-flex no-block align-items-center m-b-10">
                                    <h4 class="card-title">User Details</h4>
                                </div>
                                <div class="table-responsive">
                                    <table id="file_export" class="table bg-white table-bordered nowrap display">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Company Name</th>
                                                <th>Email</th>
                                                <th>Phone No</th>
                                                <th>Package</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($users as $users)
                                            <tr>
                                                <td>{{ $i++}}</td>
                                                <td>{{ $users->name}}</td>
                                                <td>
                                                    @if($users->company == '')
                                                        <p class="mb-0 text-info">Not Available</p>
                                                        @else 
                                                        {{ $users->company}}
                                                    @endif
                                                </td>
                                                <td>{{ $users->email}}</td>
                                                <td>
                                                    @if($users->phone == '')
                                                        <p class="mb-0 text-info">Not Available</p>
                                                        @else 
                                                        {{ $users->phone}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($users->licences == 0)
                                                        <span class="label label-danger">Monthly</span>
                                                        @else($users->licences == 1)
                                                        <span class="label label-success">Yearly</span>
                                                    @endif
                                                </td>
                                               
                                                <td>
                                                <div class="dropdown">
                                                    {{-- trashed icon --}}
                                                    <a href="{{ route('user.delete',$users->id)}}"><i class="far fa-trash-alt mx-3"></i></a>
                                                    {{-- Edit User --}}
                                                     <a href=" {{ route('update.user', $users->id)}}"><i class="far fa-edit"></i></a>
                                                    {{-- Eyes/Details --}}
                                                    <a class="btn dropdown-toggle" href="javascript::void(0)" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-eye "></i>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                        <a class="dropdown-item" href="{{ route('user.billing', $users->id)}}">Billing Details</a>
                                                        <a class="dropdown-item" href="{{ route('user.project_statuses', $users->id)}}">Project Statuses</a>
                                                        <a class="dropdown-item" href="{{ route('user.archieve_reason', $users->id)}}">Archeive Reasons</a>
                                                        <a class="dropdown-item" href="{{ route('user.project_labels', $users->id)}}">Project Labels</a>
                                                        <a class="dropdown-item" href="{{ route('user.take_off_label', $users->id)}}">Take Off Labels</a>
                                                        <a class="dropdown-item" href="{{ route('takeoffTemplate.user', $users->id)}}">Take-off Templates</a>
                                                        <a class="dropdown-item" href="{{ route('projectTemplate.user', $users->id)}}">Project Templates</a>
                                                    </div>
                                                </div>
                                                </td>
                                            </tr>
                                            @empty
                                                <td colspan="7" style="text-allign: center;">No Users</td>
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