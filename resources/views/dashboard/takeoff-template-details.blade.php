<!DOCTYPE html>
<html lang="en">
<head>
  <base href="/">
  <meta charset="UTF-8">
  <meta name="csrf" content="{{csrf_token()}}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Take Off Template</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel='stylesheet' href='css/style.css' type='text/css' />
    <link rel='stylesheet' href='fontawesome/css/all.min.css' type='text/css' />
    
</head>
<body class="takeoffDetailsPage worksheetPage">
  @include('dashboard.partials.header')
  <section class="bottom-header">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <span class="subtitle">take-off template</span>
          <h3>{{$data[0]->name}}</h3>
          <input type="hidden" id="template_id" value="{{$data[0]->id}}">
        </div>
      </div>
    </div>
  </section>
  <section class="tab">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <ul class="nav nav-pills nav-stacked-xs">
            <li>
              <a href="/takeoff-templates/open" class="nav-link" data-router="true">
                <i class="fa fa-chevron-left"></i>
              </a>
            </li>
            <li>
              <a href="/takeoff-templates/{{$data[0]->salt}}" data-router="true" class="nav-link active">Template</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>
  <section class="third">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 col-md-6 left">
          <div class="field-header">
            <h3 class="slim pull-left">Name</h3>
            <div class="clearfix"></div>
          </div>
          <div class="field-body">
            <a onclick="openRenameTemplateModel('{{$data[0]->id}}', '{{$data[0]->name}}')" class="link-with-hover-icon" style="cursor: pointer;"><div class="form-control-static">{{$data[0]->name}}<i class="far fa-edit margin-left-sm"></i></div></a>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 right">
          <div class="field-header">
            <h3 class="slim pull-left">Labels</h3>
            <div class="clearfix"></div>
          </div>
          <div class="field-body row">
            <div id="labelBtns">
              
            </div>
            <select id="labelsSelect">
              <option selected disabled>Choose label...</option>
              @foreach($labels as $label)
                <option style="color: {{$label->color}};font-weight: 500;" value="{{$label->id}}">{{$label->label}}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="container" id="measurements">
    <div class="panel panel-primary" >
      <div class="panel-heading">
        <h3 class="panel-title">Measurements</h3>
      </div>
      <div class="panel-body">  
        <table class="table">
          
          @if(!$measurements->isEmpty())
          <thead>
            <tr>
              <th style="width: 80%">Description</th>
              <th></th>
            </tr>
          </thead>
          <tbody class="vertical-align-middle js-sortable-item" data-id="4YKtJrEGyE623wvh4" draggable="false">
            <?php $i = 1; ?>
            <script>
              
            </script>
            @foreach($measurements as $m)
            <tr class="tr-measurement" style="width: 100%;">
              <td style="width: 85%">
                <a class="link-with-hover-icon" href="/takeoff-templates/{{$salt}}/{{$m->id}}/measurements/edit" data-router="true" draggable="false">
                  <span class="measurement-legend">
                    <?php echo $m->symbol; ?>
                    <b id="bold-{{$i}}"></b>
                    <?php 
                      if($m->type == 'count'){
                        echo "
                          <script>
                            if (typeof svg == 'undefined') {
                              let svg = 1;
                            }
                            if (typeof classes == 'undefined') {
                              let classes = '1';
                            }
                            if (typeof s == 'undefined') {
                              let s = '1';
                            }
                             classes = $('#bold-$i').prev('svg').attr('class');
                             s = classes.split(' ');
                             classes = '.'+s[1];
                             svg = $(classes).find('path').attr('fill','$m->fill');
                          </script>"; 
                      }
                      $i++;
                    ?>
                    
                  </span> {{$m->description}} <i class="fa fa-cogs" id="mea-icon"></i>
                </a>
              </td>
              <td style="text-align:right;">
                <a class="link-with-hover-icon" href="#" data-toggle="modal" onclick="openAdjustCountModal('{{$m->id}}','{{$m->total}}')" draggable="false">
                  <i class="fa fa-sort"></i> 
                  {{$m->total}} 
                  @if($m->type == 'count')
                    <?php echo strtoupper($m->unit); ?>
                  @else
                    {{$m->unit}}
                  @endif
                  @if($m->total > 0)
                    <span style="font-size: 17px;"> *</span>
                  @endif
                </a>
              </td>
              <td class="js-sortable-skip hidden-print">
                <div class="table-action-menu">
                  <a href="#" class="dropdown-togle" data-toggle="dropdown" draggable="false"><i class="far fa-play-circle fa-rotate-90"></i></a>
                  <!-- drop down -->
                  <ul class="dropdown-menu pull-right" role="menu">
                    <li class="disabled"><a href="javascript::void(0)" draggable="false">Measurement Actions</a></li>
                    <li class="divider"></li>
                    <li>
                      <a style="cursor: pointer;" onclick="openMeasurementRenameModal('{{$m->id}}','{{$m->description}}')" draggable="false"><i class="far fa-edit"></i> Rename</a>
                    </li>
                    <li>
                      <a onclick="openAdjustCountModal('{{$m->id}}','{{$m->total}}')" style="cursor: pointer;" draggable="false"><i class="fa fa-sort"></i> Adjust</a>
                    </li>
                    <li>
                      <a  draggable="false" style="cursor: pointer;"><i class="fa fa-cogs"></i> Parts</a>
                    </li>
                    <li class="divider"></li>
                    <li class="last">
                      <a onclick="openDeleteMeasurementModel('{{$m->id}}','{{$m->description}}')" style="cursor: pointer;" draggable="false"><i class="fa fa-times"></i> Delete</a>
                    </li>
                  </ul>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
          @else
            <tr>
              <td colspan="2">
                There are no measurements on this take-off
              </td>
            </tr>
          @endif
        </table>
      </div>
      <div class="panel-footer panel-footer-compact">
        <div class="btn-group btn-group-dropup dropup open" data-menu="100">
          <a class="btn btn-primary dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="true">
            <i class="fa fa-plus hover-icon"></i> Measurement <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li>
              <a onclick="openCountModal('{{$data[0]->id}}')" data-toggle="dropdown" data-action="create-stage-modal" data-stage="{{$data[0]->id}}" style="cursor: pointer;" data-type="count">Count</a>
            </li>
            <li>
              <a onclick="openLengthModal('{{$data[0]->id}}')" data-toggle="dropdown" data-action="create-stage-modal" data-stage="{{$data[0]->id}}" style="cursor: pointer;" data-type="length">Length</a>
            </li>
            <li>
              <a onclick="openAreaModal('{{$data[0]->id}}')" style="cursor: pointer;" data-stage="{{$data[0]->id}}" data-type="area">Area</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>

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
          <input type="hidden" name="template_id" id="template_id" value="" />
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
             
              {{-- <div class="symbol-container count_symbols_container">
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
              </div> --}}
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
      <div class="scCustom">
        <div class="row">
          <div class="col-md-6">
            <select id="packSelect" class="form-control">
              <option value="generic">Generic</option>
              <option value="arrows">Arrows</option>
            </select>
          </div>
          <div class="col-md-6">
            <div class="input-group mb-3">
              <input type="text" class="form-control" placeholder="Filter symbols by name" id="symbolSearchBox">
              <div class="input-group-append">
                <span class="input-group-text">
                  <i class="fas fa-search"></i>
                </span>
              </div>
            </div>
          </div>
        </div>
        <div class="flex" id="flex">
          
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary">Save</button>
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
          <input type="hidden" name="template_id" id="template_id" />
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
          <input type="hidden" name="template_id" id="template_id" value="" />
          <input type="hidden" name="type" id="type" value="area" />
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
                <svg width="20px" height="20px" viewBox="0 0 20 20" style="vertical-align: bottom;">
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
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>

{{-- Rename TakeOff Model --}}
<div class="modal fade" id="renameTakeoffModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Rename Take-Off Template</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('takeoff-template.update')}}">
      @csrf
      <div class="modal-body">
          <input type="hidden" id="id" value="" name="id" />
          <div class="form-group">
            <label>Name</label>
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

  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="fontawesome/js/all.min.js"></script>
  <script src="js/ajax.js"></script>
  <script src="js/takeOffTemplates.js"></script>
  <script src="js/fonts/generic.js"></script>
  <script src="js/fonts/arrows.js"></script>
  <script>
    function fetchLabels()
    {
      let template_id = $("#template_id").val();
      let csrf = $("meta[name='csrf']").attr('content');
      $.ajax({
        url: '/takeoff/template/fetch/labels',
        type: 'POST',
        data: {_token:csrf, template:template_id},
        success: function(res)
        {
          console.log(res);
          $("#labelBtns").html(res);
        }
      });
    }
    fetchLabels();
    $("#labelsSelect").on('change', function(){
      let a = $(this).val();
      console.log(a);
      let template_id = $("#template_id").val();
      let csrf = $("meta[name='csrf']").attr('content');
      $.ajax({
        type: 'POST',
        url: '/takeoff/template/add-label',
        data: {_token:csrf, label:a, template:template_id},
        success: function(res)
        {
          console.log(res);
          if(res == 1){
            fetchLabels();
            $('#labelsSelect option:first').prop('selected',true);
          }
        }
      });
    });
    function cancel(id)
    {
      let template_id = $("#template_id").val();
      let csrf = $("meta[name='csrf']").attr('content');
      $.ajax({
        type: 'POST',
        url: '/takeoff/template/labels/remove',
        data: {_token:csrf, label:id, template:template_id},
        success: function(res)
        {
          if(res == 'done'){
            fetchLabels();
          }
        }
      });
    }

    // Symbols Script
    function load_symbols()
    {
      let pack = $("#packSelect").val();

      if(pack == 'generic'){
        let html = '';
        let len = GENERIC.length;
        if(len > 35)
        {
          len = 35;
        }
        for(var i=0; i<len;i++){
        html += '<span><i class="fa '+GENERIC[i].c+'"></i></span>'
        }
        $('#flex').html(html);
        pusher();
      }else if(pack == 'arrows'){
        let len = ARROWS.length;
        let html = '';
        if(len > 35)
        {
          len = 35;
        }
        for(var i=0; i<len;i++){
        html += '<span><i class="fa '+ARROWS[i].c+'"></i></span>'
        }
        $('#flex').html(html);
        pusher();
      }
    }
    $("#packSelect").on('change', function(){
       load_symbols();
    });
    load_symbols();

    $("#symbol-style").click(function(){
      $(".scCustom").toggle();
    });
    // Search
    $("#symbolSearchBox").keyup(function(event){
      let key = $("#symbolSearchBox").val();
      let html = '';
      let arr = [];
      GENERIC.forEach((elem) => {
        let str = elem.c;
        if(~str.indexOf(key))
        {
          arr.push(str);
        }
      });
      ARROWS.forEach((elem) => {
        let str2 = elem.c;
        if(~str2.indexOf(key))
        {
          arr.push(str2);
        }
      });
      let len = arr.length;
      if(len > 35)
      {
        len = 35;
      }
      for(var i=0;i<len;i++)
      {
        html += '<span><i class="fa '+arr[i]+'"></i></span>'
      }
      $(".scCustom #flex").html(html);
      pusher();
      $(".scCustom #flex span").click(function(){
        
        let svg = $(this).html();

      });

      event.preventDefault();
    });
    
    function pusher()
    {
      $(".scCustom #flex span").click(function(){
        let svg = $(this).html();
        $("#symbol-style").html(svg);
      });
      
    }

  </script>  
</body>
</html>
