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
                        <h3 class="mb-4">Template Todos</h3>
                        <div class="row">
                            @forelse($data as $data)
                           <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        {{ $data['name']}}
                                    </div>
                                    <div class="card-body p-0">
                                        <table class="table table-hover">
                                            <thead>
                                               
                                                <tr>
                                                    <th>#</th>
                                                    <th>Task Name</th>
                                                    <th>Assigned to</th>
                                                    <th>Action</th>
                                                </tr>
                                               
                                            </thead>
                                            <tbody>
                                                @php 
                                                    $i = 1
                                                @endphp
                                                 @forelse($data['tasks'] as $t)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td>{{ $t->name}}</td>
                                                    <td>
                                                        @if(!empty($t->assign_to))
                                                            {{ $t->assign_to}}
                                                        @else 
                                                            <p>Not Available</p>
                                                        @endif
                                                    </td>
                                                    <td>
                                                         <a href="{{ route('tempProjectTodo.del',$t->id)}}"><i class="far fa-trash-alt mx-3"></i></a>
                                                    </td>
                                                @empty
                                                    <td colspan="4" style="text-align: center;">
                                                    No Tasks Available</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                           </div>
                           @empty
                            <div class="col-lg-12 alert alert-danger mt-4">
                                <p class="mb-0">Todos not Available</p>
                            </div>

                           @endforelse
                        </div>

                    </div>
                </div>
            </div>
@include('admin.includes.footer')