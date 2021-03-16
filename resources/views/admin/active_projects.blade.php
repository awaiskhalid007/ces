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
                                    <h4 class="card-title">Active Projects</h4>
                                </div>
                                <div class="table-responsive">
                                    <table id="file_export" class="table bg-white table-bordered nowrap display">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Project Name</th>
                                                <th>Discription</th>
                                                <th>Created By</th>
                                                <th>Client Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @forelse( $active_projects as $active_projects)
                                            <tr>
                                                <td>{{ $i++}}</td>
                                                <td>{{$active_projects['name']}} </td>
                                                <td>
                                                    @if(empty($active_projects['description'])) 
                                                        <p class="text-info">Not Available</p>
                                                    @else
                                                        <p> {{ substr($active_projects['description'], 0, 30)}}</p>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(empty( $active_projects['user_name'] )) 
                                                        <p class="text-info">User Deleted</p>
                                                    @else
                                                        <p>  {{ $active_projects['user_name'] }}</p>
                                                    @endif
                                                   
                                                </td>
                                                <td>
                                                    @if(empty($active_projects['client'])) 
                                                        <p class="text-info">Not Available</p>
                                                    @else
                                                        <p> {{ $active_projects['client']}}</p>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                    {{-- trashed icon --}}
                                                    <a href="{{ route('activeProject.delete',$active_projects['id'])}}"><i class="far fa-trash-alt mx-3"></i></a>
                                                    {{-- Eyes/Details --}}
                                                    <a class="btn dropdown-toggle" href="javascript::void(0)" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-eye "></i>
                                                    </a>

                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                    <a class="dropdown-item" href="{{ route('activeProject.details',$active_projects['id'])}}">Project Deatails</a>
                                                    <a class="dropdown-item" href="{{ route('activeProject.todos',$active_projects['id'])}}">Project Todos</a>
                                                    <a class="dropdown-item" href="{{ route('activeProject.stages',$active_projects['id'])}}">Project Stages</a>
                                                    <a class="dropdown-item" href="{{ route('activeProject.attachments',$active_projects['id'])}}">Project Attachments</a>
                                                    <a class="dropdown-item" href="{{ route('activeProject.plans',$active_projects['id'])}}">Project Plans</a>
                                                    <a class="dropdown-item" href="{{ route('activeProject.worksheet',$active_projects['id'])}}">Project Worksheet</a>
                                                    </div>
                                                    </div>
                                                </td>
                                                @empty
                                                    <td colspan="6" style="text-align: center;">No Active Projects</td>
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