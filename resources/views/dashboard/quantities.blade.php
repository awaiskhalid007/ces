<!DOCTYPE html>
<html lang="en">
<head>
  <base href="/">
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{csrf_token()}}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Project Quantities</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel='stylesheet' href='css/style.css' type='text/css' />
  <link rel='stylesheet' href='fontawesome/css/all.min.css' type='text/css' />
  <script type="text/javascript" src="js/jquery.min.js"></script>

</head>
<body class="projectPage worksheetPage quantitiesPage">

  @include('dashboard.partials.header')
  <div class="container-fluid">
    <div class="nav-create--1">
      <label for="">PROJECT</label>
      <h5>{{$project_name}}</h5>
    </div>
    <section class="projects_tabs">
      <div class="container">
        @include('dashboard.partials.bottom-header')
      </div>
    </section>
    <div class="container">
      <div class="plan-list-header">
        <h3 class="heading">Quantities</h3>      
      </div>
      
      @if(empty($data))
        <div class="no-records text-center">
          <p>There are no Stages in this project</p>
          <div>
            <a class="btn btn-lg btn-primary" href="/projects/{{$project_salt}}/stages" data-router="true">Setup Stages</a>
          </div>
        </div>
      @else
        
        <section id="scroller">
          <select class="form-control">
            <option disabled selected>Go to stage</option>
            @foreach($data as $obj)
              <option value="stage-{{$obj['stage']->id}}">{{$obj['stage']->name}}</option>
            @endforeach 
          </select>
        </section>

        <section id="pagination">
          <?php
              $prev_fade = 1;
              $next_fade = 1;
              if(isset($_GET['page']))
              {
                if($_GET['page'] < 2)
                {
                  $prev_fade = 1;
                }else{
                  $prev_fade = 0;
                }
                if($_GET['page'] == '')
                {
                  $prev_fade = 1;
                }

                if($_GET['page'] == $paginate['total_pages'])
                {
                  $next_fade = 1;
                }else{
                  $next_fade = 0;
                }
                if($_GET['page'] == '')
                {
                  $next_fade = 0;
                }
                
              }else{
                $prev_fade = 1;
                $next_fade = 0;
                
                if($paginate['current_page'] == 1 && $paginate['last_page'] == 1)
                {
                 $next_fade = 1; 
                }
              }

            ?>
            <div class="row">
              <div class="col-md-6 col-sm-6">
                <div class="pull-left">
                  @if($prev_fade == 0)
                   <a class="btn btn-white" href="/project/{{$project_salt}}/worksheet"><i class="fa fa-angle-double-left"></i></a>
                   <a class="btn btn-white" href="{{$paginate['prev_page_url']}}"><i class="fa fa-angle-left"></i> Prev</a>
                  @else
                   <button class="btn btn-white disabled" disabled=""><i class="fa fa-angle-double-left"></i></button>
                   <button class="btn btn-white disabled" disabled=""><i class="fa fa-angle-left"></i> Prev</button>
                  @endif
                </div>
              </div>
              <div class="col-md-6 col-sm-6">
                <div class="pull-right">
                   @if($next_fade == 0)
                   <a class="btn btn-white" href="{{$paginate['next_page_url']}}">Next <i class="fa fa-angle-right"></i></a>
                   <a class="btn btn-white" href="{{$paginate['last_page_url']}}"><i class="fa fa-angle-double-right"></i></a>
                   @else
                    <button class="btn btn-white disabled" disabled="">Next <i class="fa fa-angle-right"></i></button>
                    <button class="btn btn-white disabled" disabled=""><i class="fa fa-angle-double-right"></i></button>
                   @endif
                </div>
              </div>
            </div>
        </section>

        <section class="stages">
          @foreach($data as $obj)
            <div class="panel panel-primary" id="stage-{{$obj['stage']->id}}">
              <div class="panel-heading">
                <h3 class="panel-title">{{$obj['stage']->name}}</h3>
              </div>
              @if(!$obj['measurements']->isEmpty() || !empty($obj['labours']))
              <div class="panel-body">  
                <table class="table">
                  
                  @if(!$obj['measurements']->isEmpty())
                  <thead>
                  <tr>
                    <th class="titleTH">
                      <p class="mea">Parts</p>
                    </th>
                  </tr>
                    <tr>
                      {{-- <th style="width:10px;"></th> --}}
                      <th style="width:7%;"></th>
                      <th style="width:60%;"></th>
                      <th></th>
                      <th style="width: 70px;background:#F5F5F5;" class="text-right">Unit</th>
                      <th style="width:90px;background:#E9E9E9;" class="text-right">Total</th>
                    </tr>
                    <tr>
                      {{-- <th style="width:10px;"></th> --}}
                      <th style="width: 7%;">Part #</th>
                      <th style="width: 60%;">Description</th>
                      <th style="width:90px;text-align:right;">Quantity</th>
                      <th style="width:70px;background:#F5F5F5;" class="text-right">Cost</th>
                      <th style="width:90px;background:#E9E9E9;" class="text-right">Cost</th>
                    </tr>
                  </thead>
                  <tbody class="vertical-align-middle js-sortable-item" data-id="4YKtJrEGyE623wvh4" draggable="false">
                    <?php $i = 1; ?>
                    <script>
                      
                    </script>
                    @foreach($obj['measurements'] as $m)
                    <tr class="tr-measurement" style="width: 100%;">
                     {{--  <td style="width:10px;">
                        <a style="cursor: pointer;" onclick="">
                          <i class="far fa-edit"></i>
                        </a>
                      </td> --}}
                      <td style="width:7%;">
                        {{$m->part_no}}
                      </td>
                      <td style="width: 60%;">
                        {{$m->description}}
                      </td>
                      <td style="text-align:right;width: 90px;">
                          {{number_format((float)$m->total, 2, '.', '')}} 
                          {{$m->unit}}
                      </td>
                      <td class="text-right" style="width: 70px;background:#F5F5F5;">
                        {{number_format((float)$m->unit_cost, 2, '.', '')}}
                      </td>
                      <td class="text-right" style="width: 90px;background:#E9E9E9;">
                        <?php
                           $num = $m->unit_cost * $m->total;
                           echo number_format((float)$num, 2, '.', '');
                        ?>
                      </td>
                    </tr>
                    @endforeach
                    @foreach($obj['additionals'] as $m)
                      <tr class="tr-measurement" style="width: 100%;">
                       {{--  <td style="width:10px;">
                          <a style="cursor: pointer;" onclick="">
                            <i class="far fa-edit"></i>
                          </a>
                        </td> --}}
                        <td style="width:7%;">
                          {{$m->part_no}}
                        </td>
                        <td style="width: 60%;">
                          {{$m->description}}
                        </td>
                        <td style="text-align:right;width: 90px;">
                            {{number_format((float)$m->total, 2, '.', '')}} 
                            {{$m->unit}}
                        </td>
                        <td class="text-right" style="width: 70px;background:#F5F5F5;">
                          {{number_format((float)$m->unit_cost, 2, '.', '')}} 
                        </td>
                        <td class="text-right" style="width: 90px;background:#E9E9E9;">
                          <?php
                           $num = $m->unit_cost * $m->total;
                           echo number_format((float)$num, 2, '.', '');
                          ?>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                  @endif
                </table>
                <table class="table additonalsTable">
                  
                  @if(!empty($obj['labours']))
                  <thead>
                    <tr>
                    <th class="titleTH">
                      <p class="mea">Labour</p>
                    </th>
                    </tr>
                    <tr>
                      <th style="width:10px;"></th>
                      <th style="width:60%;"></th>
                      <th></th>
                      <th style="width: 70px;background:#F5F5F5;" class="text-right">Unit</th>
                      <th style="width:90px;background:#E9E9E9;" class="text-right">Total</th>
                    </tr>
                    <tr>
                      <th style="width:10px;"></th>
                      <th style="width: 60%;">Description</th>
                      <th style="width:90px;text-align:right;">Quantity</th>
                      <th style="width:70px;background:#F5F5F5;" class="text-right">Cost</th>
                      <th style="width:90px;background:#E9E9E9;" class="text-right">Cost</th>
                    </tr>
                  </thead>
                  <tbody class="vertical-align-middle js-sortable-item">
                    <?php $i = 1; ?>
                    <script>
                      
                    </script>
                    @foreach($obj['labours'] as $m)
                    <tr class="tr-measurement" style="width: 100%;">
                      {{-- <td style="width:10px;">
                        <a style="cursor: pointer;" onclick="">
                          <i class="far fa-edit"></i>
                        </a>
                      </td> --}}
                      <td style="width: 60%">
                          {{$m->description}}
                      </td>
                      <td style="text-align:right;width: 90px;">
                          {{number_format((float)$m->total, 2, '.', '')}} 
                          {{$m->unit}}
                      </td>
                      <td class="text-right" style="width: 70px;background:#F5F5F5;">
                        {{number_format((float)$m->unit_cost, 2, '.', '')}} 
                      </td>
                      <td class="text-right" style="width: 90px;background:#E9E9E9;">
                        <?php
                         $num = $m->unit_cost * $m->total;
                         echo number_format((float)$num, 2, '.', '');
                        ?>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                  @endif
                </table>
                <div id="totals_table">
                  <table class="additonalsTable totals_table">
                    <tr>
                      <th style="width:10px;"></th>
                      <th style="width:67%;"></th>
                      <th style="width: 70px;" class="text-right">Cost</th>
                      <th style="width: 70px;" class="text-right">Margin</th>
                      <th style="width:90px;" class="text-right">Price</th>
                    </tr>
                    <tr>
                      <td></td>
                      <th class="text-right">Material</th>
                      <td class="text-right" style="width: 70px;">0.00</td>
                      <td class="text-right">0.00</td>
                      <td class="text-right">0.00</td>
                    </tr>
                    <tr>
                      <td></td>
                      <th class="text-right">Labour</th>
                      <td class="text-right">0.00</td>
                      <td class="text-right">0.00</td>
                      <td class="text-right">0.00</td>
                    </tr>
                    <tr>
                      <td></td>
                      <th class="text-right">Total</th>
                      <td class="text-right">0.00</td>
                      <td class="text-right">0.00</td>
                      <td class="text-right">0.00</td>
                    </tr>
                  </table>
                </div>
              </div>
              @else
                <div class="panel-body">
                  <p style="padding-left: 30px;padding-top:15px;">
                    There are no parts or labour on this stage.
                  </p>
                </div>
              @endif
            </div>
          @endforeach
        </section>  

        <section class="bottom_pagination fixed-bottom" id="pagination">
            <div class="row">
              <div class="col-md-6 col-sm-6">
                <div class="pull-left">
                  @if($prev_fade == 0)
                   <a class="btn btn-white" href="/project/{{$project_salt}}/worksheet"><i class="fa fa-angle-double-left"></i></a>
                   <a class="btn btn-white" href="{{$paginate['prev_page_url']}}"><i class="fa fa-angle-left"></i> Prev</a>
                  @else
                   <button class="btn btn-white disabled" disabled=""><i class="fa fa-angle-double-left"></i></button>
                   <button class="btn btn-white disabled" disabled=""><i class="fa fa-angle-left"></i> Prev</button>
                  @endif
                </div>
              </div>
              <div class="col-md-6 col-sm-6">
                <div class="pull-right">
                   @if($next_fade == 0)
                   <a class="btn btn-white" href="{{$paginate['next_page_url']}}">Next <i class="fa fa-angle-right"></i></a>
                   <a class="btn btn-white" href="{{$paginate['last_page_url']}}"><i class="fa fa-angle-double-right"></i></a>
                   @else
                    <button class="btn btn-white disabled" disabled="">Next <i class="fa fa-angle-right"></i></button>
                    <button class="btn btn-white disabled" disabled=""><i class="fa fa-angle-double-right"></i></button>
                   @endif
                </div>
              </div>
            </div>
        </section>
      @endif
    </div>
{{-- Create Count Modal --}}
<div class="modal fade measurementsModals" id="create-stage-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">New Measurement / Count</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="count_form" class="measurementsForm" method="POST" action="{{route('add.count')}}">
      @csrf
      <div class="modal-body">
          <input type="hidden" name="stage_id" id="stage_id" value="" />
          <input type="hidden" name="project_id" id="project_id" value="" />
          <input type="hidden" name="type" id="type" value="count" />
          <p style="color: red;display: none;font-size:15px;" id="count_form_error">
            *Something went wrong. Please check your internet connection.
          </p>
          <div class="form-group">
            <label>Part No</label>
            <input type="text" class="form-control" name="part_no">
          </div>
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label>Description</label>
                <input type="text" class="form-control" name="description">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Unit of Measure</label>
                <input type="text" class="form-control" name="unit" value="ea">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Unit Cost</label>
              <input type="text" name="unit_cost" id="unit_cost" class="form-control" />
            </div>
            <div class="col-md-4">
              <label>Markup %</label>
              <div class="input-group markup">
                <div class="input-group-addon" style="border-top-right-radius: 0px!important;border-bottom-right-radius: 0px!important;">
                  <input type="radio" name="priceMode" id="priceMode1" value="markup" checked="">
                </div>
                <input class="form-control" type="text" name="markup" id="markup" value="10" style="border-top-left-radius: 0px!important;border-bottom-left-radius: 0px!important;">
              </div>
            </div>
            <div class="col-md-4">
              <label>Unit Price</label>
              <div class="input-group unit">
                <div class="input-group-addon" style="border-top-right-radius: 0px!important;border-bottom-right-radius: 0px!important;">
                  <input type="radio" name="priceMode" id="priceMode2" value="fixed">
                </div>
                <input class="form-control" type="text" name="unitPrice" id="unitPrice" value="" disabled="" style="border-top-left-radius: 0px!important;border-bottom-left-radius: 0px!important;">
              </div>
            </div>
          </div>
          <h4 class="subtitle">Style</h4>
          <hr style="margin: 10px 0px;">
          <div class="multi-field-con small-inputs evenly row">
            <div class="symbol-style-con col-md-3">
              <label for="symbol-style">Symbol</label>
              <br>
              <button id="symbol-style" name="symbol-style" type="button" value="symbol-bell" class="count-symbol-button">
                <svg class="svg-inline--fa fa-bell fa-w-14" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="bell" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M224 512c35.32 0 63.97-28.65 63.97-64H160.03c0 35.35 28.65 64 63.97 64zm215.39-149.71c-19.32-20.76-55.47-51.99-55.47-154.29 0-77.7-54.48-139.9-127.94-155.16V32c0-17.67-14.32-32-31.98-32s-31.98 14.33-31.98 32v20.84C118.56 68.1 64.08 130.3 64.08 208c0 102.3-36.15 133.53-55.47 154.29-6 6.45-8.66 14.16-8.61 21.71.11 16.4 12.98 32 32.1 32h383.8c19.12 0 32-15.6 32.1-32 .05-7.55-2.61-15.27-8.61-21.71z"></path></svg>
              </button>
              {{-- <div class="arrow-down">
                <i class="fa fa-chevron-down"></i>
              </div> --}}
              <div class="symbol-container count_symbols_container">
                <ul class="dropdown-menu" style="min-width: 142px;">
                  <li>
                    <svg width="15px" height="15px" viewBox="-21 -15 554 542" xmlns="http://www.w3.org/2000/svg" version="1.1" style="vertical-align: bottom;">
                      <path d="M511.5,357.904l-54.123,80.455l-156.03-106.297l5.361,173.1H202.852l3.901-168.712L53.648,438.846   L0.5,357.904L173.597,256L0.987,153.118l52.662-81.433l152.618,103.859L202.852,6.838h103.37l-3.899,169.193L456.891,73.149   l54.122,80.941l-174.56,101.418L511.5,357.904z" fill="#000" stroke="#000" stroke-width="21"></path>
                    </svg>
                  </li>
                  <li>
                    <svg width="15px" height="15px" viewBox="-21 -9 554 530" xmlns="http://www.w3.org/2000/svg" version="1.1" style="vertical-align: bottom;">
                      <path d="M0.5,407.331v-21.833c0,0,43.969-19.452,68.869-47.394   c20.792-23.334,23.258-55.983,23.258-55.983s1.057-13.585,1.265-32.673c0.333-30.498,2.666-76.708,26.478-116.53   c33.14-55.416,90.635-60.231,90.635-60.231l0.537-60.527H256h44.459l0.535,60.527c0,0,57.497,4.815,90.636,60.231   c23.812,39.822,26.146,86.032,26.478,116.53c0.209,19.088,1.265,32.673,1.265,32.673s2.466,32.649,23.258,55.983   c24.902,27.941,68.87,47.394,68.87,47.394v21.833H0.5z M170.833,437.992v0.004c0,34.153,38.13,61.845,85.167,61.845   c47.037,0,85.166-27.691,85.166-61.845v-0.004H170.833z" fill="#000" stroke="#000" stroke-width="21"></path>
                    </svg>
                  </li>
                  <li>
                    <svg width="15px" height="15px" viewBox="-21 -21 554 554" xmlns="http://www.w3.org/2000/svg" version="1.1" style="vertical-align: bottom;">
                      <path d="M256,47.545L463.311,244.98L256,462.163L48.691,244.98L256,47.545 M256,0.5L0.5,243.832L256,511.5   l255.5-267.668L256,0.5L256,0.5z M256,391.02l135.02-141.448L256,120.981l-135.021,128.59L256,391.02z" fill="#000" stroke="#000" stroke-width="21"></path>
                    </svg>
                  </li>
                  <li>
                    <svg width="15px" height="15px" viewBox="58 -21 396 554" xmlns="http://www.w3.org/2000/svg" version="1.1" style="vertical-align: bottom;">
                      <path d="M256,49.005L397.953,247.74L256,460.676L114.047,247.74L256,49.005 M256,0.5L79.793,247.189L256,511.5   l176.207-264.311L256,0.5L256,0.5z M256,387.336l90.578-135.865L256,124.664l-90.578,126.807L256,387.336z" fill="#000" stroke="#000" stroke-width="21"></path>
                    </svg>
                  </li>
                  <li>
                    <svg width="15px" height="15px" viewBox="-21 -21 554 554" xmlns="http://www.w3.org/2000/svg" version="1.1" style="vertical-align: bottom;">
                      <path d="M298.583,256c0,23.513-19.066,42.583-42.583,42.583s-42.583-19.07-42.583-42.583   c0-23.521,19.067-42.583,42.583-42.583S298.583,232.479,298.583,256z M511.5,256c0,141.107-114.389,255.5-255.5,255.5   S0.5,397.107,0.5,256S114.889,0.5,256,0.5S511.5,114.893,511.5,256z M477.434,256c0-122.099-99.335-221.434-221.434-221.434   S34.567,133.901,34.567,256S133.901,477.434,256,477.434S477.434,378.099,477.434,256z" fill="#000" stroke="#000" stroke-width="21"></path>
                    </svg>
                  </li>
                  <li>
                    <svg width="15px" height="15px" viewBox="-21 -21 554 554" xmlns="http://www.w3.org/2000/svg" version="1.1" style="vertical-align: bottom;">
                      <path d="M256,0.5C114.893,0.5,0.5,114.893,0.5,256c0,141.107,114.393,255.5,255.5,255.5S511.5,397.107,511.5,256   C511.5,114.893,397.107,0.5,256,0.5z M256,409.3c-84.53,0-153.3-68.77-153.3-153.3S171.47,102.7,256,102.7S409.3,171.47,409.3,256   S340.53,409.3,256,409.3z" fill="#000" stroke="#000" stroke-width="21"></path>
                    </svg>
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-md-3">
              <label for="fill-color">Fill Color</label>
              <input type="color" id="fill-color" class="form-control" name="fill" value="#b35107">
            </div>
            <div class="col-md-3">
              <label for="stroke-color">Stroke Colour</label>
              <input type="color" id="stroke-color" class="form-control" name="stroke" value="#b35107">
            </div>
            <div class="col-md-3">
              <label for="count-size">Size</label>
              <input type="number" id="count-size" class="form-control" name="size" value="30">
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>

{{-- Create Length Modal --}}
<div class="modal fade measurementsModals" id="create-length-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">New Measurement / Length</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="length_form" method="POST" action="{{route('add.count')}}">
      @csrf
      <div class="modal-body">
          <input type="hidden" name="stage_id" id="stage_id" value="" />
          <input type="hidden" name="project_id" id="project_id" value="" />
          <input type="hidden" name="type" id="type" value="length" />
          <p style="color: red;display: none;font-size:15px;" id="count_form_error">
            *Something went wrong. Please check your internet connection.
          </p>
          <div class="form-group">
            <label>Part No</label>
            <input type="text" class="form-control" name="part_no">
          </div>
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label>Description</label>
                <input type="text" class="form-control" name="description">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Unit of Measure</label>
                <input type="text" class="form-control" name="unit" value="m">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Unit Cost</label>
              <input type="text" name="unit_cost" id="unit_cost" class="form-control" />
            </div>
            <div class="col-md-4">
              <label>Markup %</label>
              <div class="input-group markup">
                <div class="input-group-addon" style="border-top-right-radius: 0px!important;border-bottom-right-radius: 0px!important;">
                  <input type="radio" name="priceMode" id="priceMode1" value="markup" checked="">
                </div>
                <input class="form-control" type="text" name="markup" id="markup" value="10" style="border-top-left-radius: 0px!important;border-bottom-left-radius: 0px!important;">
              </div>
            </div>
            <div class="col-md-4">
              <label>Unit Price</label>
              <div class="input-group unit">
                <div class="input-group-addon" style="border-top-right-radius: 0px!important;border-bottom-right-radius: 0px!important;">
                  <input type="radio" name="priceMode" id="priceMode2" value="fixed">
                </div>
                <input class="form-control" type="text" name="unitPrice" id="unitPrice" value="" disabled="" style="border-top-left-radius: 0px!important;border-bottom-left-radius: 0px!important;">
              </div>
            </div>
          </div>
          <h4 class="subtitle">Style</h4>
          <hr style="margin: 10px 0px;">
          <div class="multi-field-con small-inputs evenly row">
            <div class="symbol-style-con col-md-4">
              <label for="symbol-style">Line Style</label>
              <br>
              <button id="symbol-style" class="line-button" name="symbol-style" type="button" value="symbol">
                <svg width="100px" height="16px" viewBox="0 0 100 16">
                    <line x1="0" y1="8" x2="100" y2="8" style="stroke: rgb(0, 128, 0); stroke-width: 4;"></line>
                </svg>
              </button>
              <div class="arrow-down">
                <i class="fa fa-chevron-down"></i>
              </div>
              <div class="symbol-container line_symbols_container">
                <ul class="dropdown-menu" style="min-width: 142px;">
                   <li>
                     <svg width="100px" height="16px" viewBox="0 0 100 16">
                        <line x1="0" y1="8" x2="100" y2="8" style="stroke: rgb(0, 128, 0); stroke-width: 4;"></line>
                     </svg>
                   </li>
                   <li>
                     <svg width="100px" height="16px" viewBox="0 0 100 16">
                        <line x1="0" y1="8" x2="100" y2="8" style="stroke: rgb(0, 128, 0); stroke-width: 4; stroke-dasharray: 12, 4;"></line>
                     </svg>
                   </li>
                   <li>
                     <svg width="100px" height="16px" viewBox="0 0 100 16">
                        <line x1="0" y1="8" x2="100" y2="8" style="stroke: rgb(0, 128, 0); stroke-width: 4; stroke-dasharray: 4, 4;"></line>
                     </svg>
                   </li>
                   <li>
                     <svg width="100px" height="16px" viewBox="0 0 100 16">
                        <line x1="0" y1="8" x2="100" y2="8" style="stroke: rgb(0, 128, 0); stroke-width: 4; stroke-dasharray: 12, 4, 4, 4;"></line>
                     </svg>
                   </li>
                   <li>
                     <svg width="100px" height="16px" viewBox="0 0 100 16">
                        <line x1="0" y1="8" x2="100" y2="8" style="stroke: rgb(0, 128, 0); stroke-width: 4; stroke-dasharray: 12, 4, 4, 4, 4, 4;"></line>
                     </svg>
                   </li>
                   <li>
                     <svg width="100px" height="16px" viewBox="0 0 100 16">
                        <line x1="0" y1="8" x2="100" y2="8" style="stroke: rgb(0, 128, 0); stroke-width: 4; stroke-dasharray: 4, 12;"></line>
                     </svg>
                   </li>
                   <li>
                     <svg width="100px" height="16px" viewBox="0 0 100 16">
                        <line x1="0" y1="8" x2="100" y2="8" style="stroke: rgb(0, 128, 0); stroke-width: 4; stroke-dasharray: 16, 12;"></line>
                     </svg>
                   </li>
                   <li>
                     <svg width="100px" height="16px" viewBox="0 0 100 16">
                        <line x1="0" y1="8" x2="100" y2="8" style="stroke: rgb(0, 128, 0); stroke-width: 4; stroke-dasharray: 32, 12;"></line>
                     </svg>
                   </li>
                   <li>
                     <svg width="100px" height="16px" viewBox="0 0 100 16">
                        <line x1="0" y1="8" x2="100" y2="8" style="stroke: rgb(0, 128, 0); stroke-width: 4; stroke-dasharray: 32, 12, 4, 12;"></line>
                     </svg>
                   </li>
                   <li>
                     <svg width="100px" height="16px" viewBox="0 0 100 16">
                        <line x1="0" y1="8" x2="100" y2="8" style="stroke: rgb(0, 128, 0); stroke-width: 4; stroke-dasharray: 32, 12, 4, 12, 4, 12;"></line>
                     </svg>
                   </li>
                </ul>
              </div>
            </div>
            <div class="col-md-4">
              <label for="stroke-color">Stroke Colour</label>
              <input type="color" id="line-stroke-color" class="form-control" name="stroke" value="#008000">
            </div>
            <div class="col-md-4">
              <label for="count-size">Size</label>
              <input type="number" id="count-size" class="form-control" name="size" value="30">
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>
{{-- Create Area Modal --}}
<div class="modal fade measurementsModals" id="create-area-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">New Measurement / Area</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="area_form" method="POST" action="{{route('add.count')}}">
      @csrf
      <div class="modal-body">
          <input type="hidden" name="stage_id" id="stage_id" value="" />
          <input type="hidden" name="project_id" id="project_id" value="" />
          <input type="hidden" name="type" id="type" value="length" />
          <p style="color: red;display: none;font-size:15px;" id="count_form_error">
            *Something went wrong. Please check your internet connection.
          </p>
          <div class="form-group">
            <label>Part No</label>
            <input type="text" class="form-control" name="part_no">
          </div>
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label>Description</label>
                <input type="text" class="form-control" name="description">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Unit of Measure</label>
                <input type="text" class="form-control" name="unit" value="m2">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Unit Cost</label>
              <input type="text" name="unit_cost" id="unit_cost" class="form-control" />
            </div>
            <div class="col-md-4">
              <label>Markup %</label>
              <div class="input-group markup">
                <div class="input-group-addon" style="border-top-right-radius: 0px!important;border-bottom-right-radius: 0px!important;">
                  <input type="radio" name="priceMode" id="priceMode1" value="markup" checked="">
                </div>
                <input class="form-control" type="text" name="markup" id="markup" value="10" style="border-top-left-radius: 0px!important;border-bottom-left-radius: 0px!important;">
              </div>
            </div>
            <div class="col-md-4">
              <label>Unit Price</label>
              <div class="input-group unit">
                <div class="input-group-addon" style="border-top-right-radius: 0px!important;border-bottom-right-radius: 0px!important;">
                  <input type="radio" name="priceMode" id="priceMode2" value="fixed">
                </div>
                <input class="form-control" type="text" name="unitPrice" id="unitPrice" value="" disabled="" style="border-top-left-radius: 0px!important;border-bottom-left-radius: 0px!important;">
              </div>
            </div>
          </div>
          <h4 class="subtitle">Style</h4>
          <hr style="margin: 10px 0px;">
          <div class="multi-field-con small-inputs evenly row">
            <div class="symbol-style-con col-md-3">
              <label for="symbol-style">Symbol</label>
              <br>
              <button id="symbol-style" class="text-left area-button no-bg" name="symbol-style" type="button" value="symbol">
                <svg width="20px" height="20px" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" version="1.1" style="vertical-align: bottom;">
                   <path d="M 2 4 L 18 4 18 16 2 16 Z" fill="#FFA500" stroke="#FFA500" stroke-width="2"></path>
                </svg>
              </button>
            </div>
            <div class="col-md-3">
              <label for="stroke-color">Fill Colour</label>
              <input type="color" id="area-fill-color" class="form-control" name="fill" value="#FFA500">
            </div>
            <div class="col-md-3">
              <label for="stroke-color">Stroke Colour</label>
              <input type="color" id="area-stroke-color" class="form-control" name="stroke" value="#FFA500">
            </div>
            <div class="col-md-3">
              <label for="count-size">Size</label>
              <input type="number" id="count-size" class="form-control" name="size" value="30">
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>
{{-- Create Additional Modal --}}
<div class="modal fade measurementsModals" id="create-additional-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">
          Additional Once-Off Item
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="additional_form" method="POST" action="{{route('add.count')}}">
      @csrf
      <div class="modal-body">
          <input type="hidden" name="stage_id" id="stage_id" value="" />
          <input type="hidden" name="project_id" id="project_id" value="" />
          <input type="hidden" name="type" id="type" value="length" />
          <p style="color: red;display: none;font-size:15px;" id="count_form_error">
            *Something went wrong. Please check your internet connection.
          </p>
          <div class="form-group">
            <label>Part No</label>
            <input type="text" class="form-control" name="part_no">
          </div>
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label>Description</label>
                <input type="text" class="form-control" name="description">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Unit of Measure</label>
                <input type="text" class="form-control" name="unit">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Unit Cost</label>
              <input type="text" name="unit_cost" id="unit_cost" class="form-control" />
            </div>
            <div class="col-md-4">
              <label>Markup %</label>
              <div class="input-group markup">
                <div class="input-group-addon" style="border-top-right-radius: 0px!important;border-bottom-right-radius: 0px!important;">
                  <input type="radio" name="priceMode" id="priceMode1" value="markup" checked="">
                </div>
                <input class="form-control" type="text" name="markup" id="markup" value="10" style="border-top-left-radius: 0px!important;border-bottom-left-radius: 0px!important;">
              </div>
            </div>
            <div class="col-md-4">
              <label>Unit Price</label>
              <div class="input-group unit">
                <div class="input-group-addon" style="border-top-right-radius: 0px!important;border-bottom-right-radius: 0px!important;">
                  <input type="radio" name="priceMode" id="priceMode2" value="fixed">
                </div>
                <input class="form-control" type="text" name="unitPrice" id="unitPrice" value="" disabled="" style="border-top-left-radius: 0px!important;border-bottom-left-radius: 0px!important;">
              </div>
            </div>
          </div><br>
          <div class="form-group">
            <label>Quantity</label>
            <input type="number" class="form-control" name="total" />
          </div>
          <div class="help-block">
            <p>Enter fixed value - eg <code>30</code></p>
          </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary">Create</button>
      </div>
      </form>
    </div>
  </div>
</div>
{{-- Create Labour Model --}}
<div class="modal fade measurementsModals" id="create-labour-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">
          Additional Labour
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="labour_form" method="POST" action="{{route('add.count')}}">
      @csrf
      <div class="modal-body">
          <input type="hidden" name="stage_id" id="stage_id" value="" />
          <input type="hidden" name="project_id" id="project_id" value="" />
          <input type="hidden" name="type" id="type" value="length" />
          <p style="color: red;display: none;font-size:15px;" id="count_form_error">
            *Something went wrong. Please check your internet connection.
          </p>
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label>Description</label>
                <input type="text" class="form-control" name="description">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Unit of Measure</label>
                <select class="form-control" name="unit">
                  <option value="mins">Minutes</option>
                  <option value="hrs">Hours</option>
                  <option value="days">Days</option>
                  <option value="weeks">Weeks</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Unit Cost</label>
              <input type="text" name="unit_cost" id="unit_cost" class="form-control" />
            </div>
            <div class="col-md-4">
              <label>Markup %</label>
              <div class="input-group markup">
                <div class="input-group-addon" style="border-top-right-radius: 0px!important;border-bottom-right-radius: 0px!important;">
                  <input type="radio" name="priceMode" id="priceMode1" value="markup" checked="">
                </div>
                <input class="form-control" type="text" name="markup" id="markup" value="10" style="border-top-left-radius: 0px!important;border-bottom-left-radius: 0px!important;">
              </div>
            </div>
            <div class="col-md-4">
              <label>Unit Price</label>
              <div class="input-group unit">
                <div class="input-group-addon" style="border-top-right-radius: 0px!important;border-bottom-right-radius: 0px!important;">
                  <input type="radio" name="priceMode" id="priceMode2" value="fixed">
                </div>
                <input class="form-control" type="text" name="unitPrice" id="unitPrice" value="" disabled="" style="border-top-left-radius: 0px!important;border-bottom-left-radius: 0px!important;">
              </div>
            </div>
          </div><br>
          <div class="form-group">
            <label>Quantity</label>
            <input type="number" class="form-control" name="total" />
          </div>
          <div class="help-block">
            <p>Enter fixed value - eg <code>30</code></p>
          </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary">Create</button>
      </div>
      </form>
    </div>
  </div>
</div>
{{-- Edit Additional Model --}}
<div class="modal fade measurementsModals" id="editAdditionalsModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">
          Edit Part
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="additional_edit_form" method="POST" action="{{route('additional.update')}}">
      @csrf
      <div class="modal-body">
          <input type="hidden" name="id" id="id" value="" />
          <input type="hidden" name="type" id="type" value="length" />
          <p style="color: red;display: none;font-size:15px;" id="count_form_error">
            *Something went wrong. Please check your internet connection.
          </p>
          <div class="form-group" id="part_no">
            <label>Part No</label>
            <input type="text" class="form-control" name="part_no" id="part_no">
          </div>
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label>Description</label>
                <input type="text" class="form-control" name="description" id="description">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group" id="additionalsUnits">
                <label>Unit of Measure</label>
                <input type="text" class="form-control" name="unit" id="unit">
                <select name="unit" class="form-control" style="display: none;" required>
                  <option disabled selected>Choose Unit</option>
                  <option value="mins">Minutes</option>
                  <option value="hrs">Hours</option>
                  <option value="days">Days</option>
                  <option value="weeks">Weeks</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Unit Cost</label>
              <input type="text" name="unit_cost" id="unit_cost" class="form-control" id="unit_cost" />
            </div>
            <div class="col-md-4">
              <label>Markup %</label>
              <div class="input-group markup">
                <div class="input-group-addon" style="border-top-right-radius: 0px!important;border-bottom-right-radius: 0px!important;">
                  <input type="radio" name="priceMode" id="priceMode1" value="markup" checked="">
                </div>
                <input class="form-control" type="text" name="markup" id="markup" value="10" style="border-top-left-radius: 0px!important;border-bottom-left-radius: 0px!important;">
              </div>
            </div>
            <div class="col-md-4">
              <label>Unit Price</label>
              <div class="input-group unit">
                <div class="input-group-addon" style="border-top-right-radius: 0px!important;border-bottom-right-radius: 0px!important;">
                  <input type="radio" name="priceMode" id="priceMode2" value="fixed">
                </div>
                <input class="form-control" type="text" name="unitPrice" id="unitPrice" value="" disabled="" style="border-top-left-radius: 0px!important;border-bottom-left-radius: 0px!important;">
              </div>
            </div>
          </div><br>
          <div class="form-group">
            <label>Quantity</label>
            <input type="number" class="form-control" name="total" id="total" />
          </div>
          <div class="help-block">
            <p>Enter fixed value - eg <code>30</code></p>
          </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary">Update</button>
      </div>
      </form>
    </div>
  </div>
</div>
{{-- adjustCountModal Modal --}}
<div class="modal fade" id="adjustCountModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Adjust Count</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('adjust.count')}}">
      @csrf
      <div class="modal-body">
          <input type="hidden" id="id" value="" name="id" />
          <div class="form-group">
            <label>Calculated Value</label>
            <p id="total"></p>
          </div>
          <div class="form-group">
            <label>Adjusted Value</label>
            <input type="text" class="form-control" name="total" id="total" required="required" />
          </div>
          <div class="help-block">
            <p>Enter fixed value - eg <code>30</code></p>
          </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" type="submit">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>
{{-- RenameCountModel --}}
<div class="modal fade" id="renameMeasurementModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Rename Measurement</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('rename.measurement')}}">
      @csrf
      <div class="modal-body">
          <input type="hidden" id="id" value="" name="id" />
          <div class="form-group">
            <label>Description</label>
            <input type="text" class="form-control" name="name" id="name" required="required" />
          </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" type="submit">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>
{{-- DeleteMeasurementModel --}}
<div class="modal fade" id="deleteMeasurementModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="modal-title" id="exampleModalLongTitle">
          Remove measurement <span id="name" style="font-weight: 600;"></span> from the Project?
        </p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('delete.measurement')}}">
      @csrf
      <div class="">
          <input type="hidden" id="id" value="" name="id" />
      </div>
      <div class="modal-footer" style="border-top: none!important;">
        <button class="btn btn-danger" type="submit">Delete Measurement</button>
      </div>
      </form>
    </div>
  </div>
</div>
{{-- DeleteAdditionalsModel --}}
<div class="modal fade" id="deleteAdditionalsModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="modal-title" id="exampleModalLongTitle">
          Remove additional item <span id="name" style="font-weight: 600;"></span> from the Project?
        </p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('additional.delete')}}">
      @csrf
      <div class="">
          <input type="hidden" id="id" value="" name="id" />
      </div>
      <div class="modal-footer" style="border-top: none!important;">
        <button class="btn btn-danger" type="submit">Delete Item</button>
      </div>
      </form>
    </div>
  </div>
</div>
  <script type="text/javascript" src="js/popper.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="fontawesome/js/all.min.js"></script>
  <script type="text/javascript" src="js/worksheet.js"></script>
  <script src="js/ajax.js"></script>

  <script>
    $('#bottom_header .tab4').addClass('active');    
    $('#bottom_header .tab1').removeClass('active');
    $("#scroller select").on('change', function() {
      let a = $(this).val();
      let id = '#' + a;
      $('html, body').animate({
              scrollTop: $(id).offset().top
          }, 1000);
    });
  </script>
</body>
</html>
 