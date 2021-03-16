@include('admin.includes.header')
<style>
    svg{
        width: 4vw;
        height: 4vh;
    }
    .card-header{
        background-color: #5294E2;
        color: #ffffff;
    }
    .card{
        border: 1px solid #5294E2; 
    }
</style>
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
                        <h3 class="mb-4">Active Project Worksheet</h3>
                        <div class="row">
                            @forelse($data as $data)
                           <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                       <strong> {{ $data['stage_name']}}</strong>
                                    </div>
                                    <div class="card-body p-0">
                                        <h4 class="m-3">Measurments</h4>
                                         <table class="table table-hover table-responsive-lg">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Sybmol</th>
                                                    <th>Description</th>
                                                    <th>Part No</th>
                                                    <th>Markup</th>
                                                    <th>Unit Cost</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php 
                                                    $i = 1
                                                @endphp
                                                @forelse($data['measurement'] as $m)
                                                <tr>
                                                    <td>{{ $i++}}</td>
                                                    <td>
                                                     @php 
                                                        echo $m->symbol;       
                                                     @endphp
                                                    </td>
                                                    <td>
                                                        @if(empty($m->description))
                                                            <p class="mb-0">Not Available</p>
                                                        @else
                                                            {{$m->description}}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(empty($m->part_no))
                                                            <p class="mb-0">Not Available</p>
                                                        @else
                                                             {{ $m->part_no}}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(empty($m->markup))
                                                            <p class="mb-0">Not Available</p>
                                                        @else
                                                              {{ $m->markup}}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(empty($m->unit_cost))
                                                            <p class="mb-0">Not Available</p>
                                                        @else
                                                                {{ $m->unit_cost}}
                                                        @endif
                                                    </td>
                                                    <td>{{ $m->total}} {{ $m->unit}} </td>
                                                @empty
                                                     <td colspan="7">
                                                        <p class="mb-0" style="text-align: center;">No Measurments Available</p>
                                                    </td>
                                                @endforelse
                                                </tr>
                                            </tbody>
                                        </table>
                                        <h4 class="m-3">Additional Items</h4>
                                        <table class="table table-hover table-responsive-lg">
                                            <thead>

                                                <tr>
                                                    <th>#</th>
                                                    <th>Part No</th>
                                                    <th>Description</th>
                                                    <th>Markup</th>
                                                    <th>Unit Cost</th>
                                                    <th>Unit Price</th>
                                                    <th>Total</th>
                                                </tr>
                                               
                                            </thead>
                                            <tbody>
                                                @php 
                                                    $i = 1
                                                @endphp
                                                 @forelse($data['additional_items'] as $t)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td>
                                                        @if(!empty( $t->part_no))
                                                            {{ $t->part_no}}
                                                        @else 
                                                            <p class="mb-0">Not Available</p>
                                                        @endif
                                                       
                                                    </td>
                                                    <td>
                                                        @if(!empty($t->assign_to))
                                                            {{ $t->description}}
                                                        @else 
                                                            <p class="mb-0">Not Available</p>
                                                        @endif
                                                    </td>
                                                    <td>{{ $t->markup }}</td>
                                                    <td>
                                                        @if(!empty($t->unit_cost))
                                                            {{ $t->unit_cost}}
                                                        @else 
                                                            <p class="mb-0">Not Available</p>
                                                        @endif
                                                       
                                                    </td>
                                                    <td>
                                                        @if(!empty($t->unit_price))
                                                            {{ $t->unit_price}}
                                                        @else 
                                                            <p class="mb-0">Not Available</p>
                                                        @endif
                                                        
                                                    </td>
                                                    <td> @if(!empty($t->total))
                                                           {{ $t->total}} {{$t->unit}}
                                                        @else 
                                                            <p class="mb-0">Not Available</p>
                                                        @endif
                                                        
                                                        </td>
                                                @empty
                                                    <td colspan="8" style="text-align: center;">
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
                                <p class="mb-0">Stages are not Available</p>
                            </div>

                           @endforelse
                        </div>

                    </div>
                </div>
            </div>
@include('admin.includes.footer')