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
                                    <h4 class="card-title">Take-off Templates</h4>
                                </div>
                                <div class="table-responsive">
                                    <table id="file_export" class="table bg-white table-bordered nowrap display">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Template Name</th>
                                                <th>Label</th>
                                                <th>Status</th>
                                                <th>Created at</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i = 1
                                            @endphp
                                            @forelse($data as $t)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $t['name']}}</td>
                                                <td>
                                                    @if(empty($t['label_name']))
                                                        <p>Not Added</p>
                                                    @else 
                                                    <i class="fas fa-tag" style="color:{{ 'label_color'}}"></i>
                                                    {{ $t['label_name']}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if( $t['status'] == 1)
                                                        <p class="badge badge-primary" style="font-size: 13px;">
                                                        ACTIVE</p>
                                                    @else
                                                        <p class="badge badge-danger" style="font-size: 13px;">TRASHED</p>
                                                    @endif
                                                </td>
                                                <td>{{ $t['created_at']->format('m-d-y')}}</td>
                                                <td>
                                                     <a href="{{ route('take0ffTemp.del',$t['id'])}}"><i class="far fa-trash-alt mx-3"></i></a>
                                                </td>
                                            @empty
                                                <td colspan="6" style="text-align: center;">   
                                                    No Take-Off Templates Available
                                                </td>
                                            </tr>
                                            @endforelse()
                                        </tbody>
                                        
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@include('admin.includes.footer')