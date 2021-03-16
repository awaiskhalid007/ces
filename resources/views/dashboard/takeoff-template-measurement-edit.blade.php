<!DOCTYPE html>
<html lang="en">
<head>
	<base href="/">
	<meta charset="UTF-8">
  <meta name="csrf" content="{{csrf_token()}}">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Projects</title>
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
              <a href="/takeoff-templates/{{$data[0]->salt}}" data-router="true" class="nav-link">Template</a>
              
            </li>
            <li>
              <a href="/takeoff-templates/{{$data[0]->salt}}" data-router="true" class="nav-link active">Edit Measurement</a>
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
            <h3 class="slim pull-left">Description</h3>
            <div class="clearfix"></div>
          </div>
          <div class="field-body">
            <a onclick="openRenamePartModel('{{$measurements[0]->id}}', '{{$measurements[0]->description}}')" class="link-with-hover-icon" style="cursor: pointer;"><div class="form-control-static">{{$measurements[0]->description}}<i class="far fa-edit margin-left-sm"></i></div></a>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 right">
          <div class="field-header">
            <h3 class="slim pull-left">Style</h3>
            @if($measurements[0]->type == 'count')
              <a href="#" data-toggle="modal" onclick="openchangeStyleModal('{{$measurements[0]->id}}','{{$measurements[0]->size}}','{{$measurements[0]->fill}}', '{{$measurements[0]->stroke}}')" draggable="false" class="slim pull-right">Edit</a>
            @elseif($measurements[0]->type == 'length')
              <a href="#" data-toggle="modal" onclick="openchangeStyleModalLen('{{$measurements[0]->id}}','{{$measurements[0]->size}}', '{{$measurements[0]->stroke}}')" draggable="false" class="slim pull-right">Edit</a>
            @else
              <a href="#" data-toggle="modal" onclick="openAreaEditModal('{{$measurements[0]->id}}','{{$measurements[0]->size}}','{{$measurements[0]->fill}}', '{{$measurements[0]->stroke}}')" draggable="false" class="slim pull-right">Edit</a>
            @endif

            <div class="clearfix"></div>
          </div>
          <div class="field-body row">
            <table class="table borderless">
              <tbody>
                <tr>
                  <th style=" text-align: center;">Symbol</th>
                  @if($measurements[0]->type != 'length')
                    <th style="">Fill Color</th>
                  @endif
                  <th style="">Stroke Color</th>
                  <th style="">Size</th>
                </tr>
                <tr>
                  <td style="padding: 0px; text-align: center;">
                    <p style="
                      margin-top: -5px;
                      color: {{$measurements[0]->fill}};
                      font-size: 16px;
                    ">
                      <?php echo $measurements[0]->symbol; ?>    
                    </p>
                  </td>
                  @if($measurements[0]->type != 'length')
                  <td style="text-align: center;">
                    <div style="
                      width: 70px; 
                      border: 1px solid #000000; 
                      height: 12px;
                      margin-top: -10px; 
                      background: {{$measurements[0]->fill}}; 
                    ">

                    </div>
                  </td>
                  @endif
                  <td>
                    <div style="
                      width: 70px; 
                      border: 1px solid #000000; 
                      height: 12px;
                      margin-top: -10px; 
                      background-color: {{$measurements[0]->stroke}}; 
                    ">
                    </div>
                  </td>
                  <td>
                    <p style="
                      margin-top: -17px!important; 

                    ">{{$measurements[0]->size}}</p>
                    
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="container" id="measurements">
    <div class="panel panel-primary" >
      <div class="panel-heading">
        <h3 class="panel-title">Parts</h3>
      </div>
      <div class="panel-body">  
        @if(!empty($parts) || !empty($labours))
        <table class="table">
          <thead>
            <tr>
              <th style="width: 30%">Parts #</th>
              <th style="width: 30%">Part Name</th>
              <th>Unit Cost</th>
              <th>Unit Price</th>
              <th class="text-right">Formula</th>
            </tr>
          </thead>
          <tbody class="vertical-align-middle js-sortable-item" data-id="4YKtJrEGyE623wvh4" draggable="false">
            <?php $i = 1; ?>
            <script>
              
            </script>
            @foreach($parts as $m)
            <tr class="tr-measurement" style="width: 100%;">
              <td style="width: 30%">
                {{$m->part_no}}
              </td>
              <td style="width: 30%">{{$m->description}}</td>
              <td>{{$m->unit_cost}}</td>
              <td>{{$m->unit_price}}</td>
              <td style="text-align:right;">
                <a class="link-with-hover-icon" href="#" data-toggle="modal" onclick="openPartEditModal('{{$measurements[0]->type}}','{{$m->id}}','{{$m->measurement_id}}','{{$m->part_no}}','{{$m->description}}','{{$m->unit}}','{{$m->unit_cost}}','{{$m->markup}}','{{$m->unit_price}}','{{$m->formula}}','{{$m->total}}')">
                  .{{$m->formula}} 
                </a>
              </td>
              <td class="js-sortable-skip hidden-print">
                <div class="table-action-menu">
                  <a href="#" class="dropdown-togle" data-toggle="dropdown" draggable="false"><i class="far fa-play-circle fa-rotate-90"></i></a>
                  <!-- drop down -->
                  <ul class="dropdown-menu pull-right" role="menu">
                    <li class="disabled"><a href="#" draggable="false">Part Actions</a></li>
                    <li class="divider"></li>
                    <li>
                      <a onclick="openPartEditModal('{{$measurements[0]->type}}','{{$m->id}}','{{$m->measurement_id}}','{{$m->part_no}}','{{$m->description}}','{{$m->unit}}','{{$m->unit_cost}}','{{$m->markup}}','{{$m->unit_price}}','{{$m->formula}}','{{$m->total}}')" data-stage="{{$m->id}}" style="cursor: pointer;" data-type="count"><i class="far fa-edit"></i>Edit</a>
                    </li>
                    <li class="last">
                      <a onclick="openDeletePartModel('{{$m->id}}','{{$m->description}}')" style="cursor: pointer;" draggable="false"><i class="fa fa-times"></i> Delete</a>
                    </li>
                  </ul>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        @if(!empty($labours))
        <br>
        <h4 class="slim" style="font-size: 18px;margin-left: 10px;color: #888;">Labours</h4>
        <table class="table">
          <thead>
            <tr>
              <th style="width: 55%">Description</th>
              <th>Unit Cost</th>
              <th>Unit Price</th>
              <th class="text-right">Formula</th>
              <th></th>
            </tr>
          </thead>
          <tbody class="vertical-align-middle js-sortable-item" data-id="4YKtJrEGyE623wvh4" draggable="false">
            <?php $i = 1; ?>
            <script>
              
            </script>
            @foreach($labours as $m)
            <tr class="tr-measurement" style="width: 100%;">
              <td style="width: 55%">{{$m->description}}</td>
              <td>{{$m->unit_cost}}</td>
              <td>{{$m->unit_price}}</td>
              <td style="text-align:right;">
                <a class="link-with-hover-icon" href="#" data-toggle="modal" onclick="openLabourEditModal('{{$measurements[0]->type}}','{{$m->id}}','{{$m->measurement_id}}','{{$m->description}}','{{$m->unit}}','{{$m->unit_cost}}','{{$m->markup}}','{{$m->unit_price}}','{{$m->formula}}','{{$m->total}}')">
                  .{{$m->formula}} 
                </a>
              </td>
              <td style="text-align:center;" class="js-sortable-skip hidden-print">
                <div class="table-action-menu">
                  <a href="#" class="dropdown-togle" data-toggle="dropdown" draggable="false"><i class="far fa-play-circle fa-rotate-90"></i></a>
                  <!-- drop down -->
                  <ul class="dropdown-menu pull-right" role="menu">
                    <li class="disabled"><a href="#" draggable="false">Part Actions</a></li>
                    <li class="divider"></li>
                    <li>
                      <a onclick="openLabourEditModal('{{$measurements[0]->type}}','{{$m->id}}','{{$m->measurement_id}}','{{$m->description}}','{{$m->unit}}','{{$m->unit_cost}}','{{$m->markup}}','{{$m->unit_price}}','{{$m->formula}}','{{$m->total}}')" data-stage="{{$m->id}}" style="cursor: pointer;" data-type="count"><i class="far fa-edit"></i>Edit</a>
                    </li>
                    <li class="last">
                      <a onclick="openDeletePartModel('{{$m->id}}','{{$m->description}}')" style="cursor: pointer;" draggable="false"><i class="fa fa-times"></i> Delete</a>
                    </li>
                  </ul>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        @endif
        @else
          <tr>
            <td colspan="2">
              There are no part or labours in this measurement.
            </td>
          </tr>
        @endif
      </div>
      <div class="panel-footer panel-footer-compact">
        <div class="btn-group btn-group-dropup dropup open" data-menu="100">
          <a class="btn btn-primary dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="true">
            <i class="fa fa-plus hover-icon"></i> Add Parts <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li>
              <a onclick="openAddPartModel('{{$measurements[0]->id}}')" data-toggle="dropdown" data-action="create-stage-modal" data-stage="{{$data[0]->id}}" style="cursor: pointer;" data-type="count">
                <p class="title" style="font-size: 13px;margin:0!important;">Groundplan</p>
                <p class="item" style="font-size: 16px;margin:0!important;">Once-Off Item</p>
              </a>
            </li>
          </ul>
        </div>
        <button class="btn btn-primary" onclick="openAddLabourModel('{{$measurements[0]->id}}')"><i class="fas fa-plus"></i> Labour</button>
      </div>
    </div>
  </section>

{{-- Change Style Model --}}
<div class="modal fade" id="openchangeStyleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 700px!important;min-width: 700px!important;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Adjust Count</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('updatestyle.measurement')}}" id="updateStyleMeasementForm">
      @csrf
      <div class="modal-body">
          <input type="hidden" id="id" value="" name="id" />
          <div class="form-group">
            <label>Size</label>
            <input type="number" class="form-control" name="size" id="size" required="required" />
          </div>
          <div class="help-block">
            <p>Enter fixed value - eg <code>30</code></p>
          </div>
          <div class="row">
            <div class="col-md-6 col-sm-6">
              <div class="form-group">
                <label>Fill Color</label>
                <input type="color" class="form-control" name="fill" id="fill" required="required" />
              </div>
            </div>
            <div class="col-md-6 col-sm-6">
              <div class="form-group">
                <label>Stroke</label>
                <input type="color" class="form-control" name="stroke" id="stroke" required="required" />
              </div>
            </div>
          </div>
          <div class="symbol-style-con col-md-3">
            <label for="symbol-style">Symbol</label>
            <br>
            <button id="symbol-style" name="symbol-style" type="button" value="symbol-bell" class="count-symbol-button">
              <svg class="svg-inline--fa fa-bell fa-w-14" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="bell" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M224 512c35.32 0 63.97-28.65 63.97-64H160.03c0 35.35 28.65 64 63.97 64zm215.39-149.71c-19.32-20.76-55.47-51.99-55.47-154.29 0-77.7-54.48-139.9-127.94-155.16V32c0-17.67-14.32-32-31.98-32s-31.98 14.33-31.98 32v20.84C118.56 68.1 64.08 130.3 64.08 208c0 102.3-36.15 133.53-55.47 154.29-6 6.45-8.66 14.16-8.61 21.71.11 16.4 12.98 32 32.1 32h383.8c19.12 0 32-15.6 32.1-32 .05-7.55-2.61-15.27-8.61-21.71z"></path></svg>
            </button>
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
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" type="submit">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>
{{-- Edit Length Model --}}
<div class="modal fade" id="openchangeStyleModalLen" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Adjust Measurement/ Length</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('updatelengthstyle.measurement')}}" id="updateStyleMeasementFormLen">
      @csrf
      <div class="modal-body">
          <input type="hidden" id="id" value="" name="id" />
          <div class="symbol-style-con col-md-3">
            <label for="symbol-style">Line</label>
            <br>
            <button id="symbol-style" name="symbol-style" type="button" value="symbol-bell" class="count-symbol-button" style="width: 200px;">
              <svg width="100px" height="16px" viewBox="0 0 100 16">
                <line x1="0" y1="8" x2="100" y2="8" style="stroke: rgb(0, 128, 0); stroke-width: 4;"></line>
              </svg>
            </button>
            <div class="symbol-container count_symbols_container">
              <ul class="dropdown-menu" style="min-width: 142px; display: block;">
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
          <div class="form-group">
            <label>Stroke</label>
            <input type="color" class="form-control" name="stroke" id="stroke" required="required" />
          </div>
          <div class="form-group">
            <label>Size</label>
            <input type="number" class="form-control" name="size" id="size" required="required" />
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
{{-- Change Area Model --}}
<div class="modal fade" id="openAreaEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Adjust Count</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('updatearastyle.measurement')}}" id="updateAreaMeasementForm">
      @csrf
      <div class="modal-body">
          <input type="hidden" id="id" value="" name="id" />
          <button id="symbol-style" name="symbol-style" type="button" value="symbol-bell" class="no-bg text-left" style="width: 200px;">
              <svg width="20px" height="20px" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" version="1.1" style="vertical-align: bottom;">
                   <path d="M 2 4 L 18 4 18 16 2 16 Z" fill="#c58d26" stroke="#FFA500" stroke-width="2"></path>
                </svg>
            </button>
          <div class="form-group">
            <label>Fill Color</label>
            <input type="color" class="form-control" name="fill" id="fill" required="required" />
          </div>
          <div class="form-group">
            <label>Stroke</label>
            <input type="color" class="form-control" name="stroke" id="stroke" required="required" />
          </div>
          <div class="form-group">
            <label>Size</label>
            <input type="number" class="form-control" name="size" id="size" required="required" />
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
{{-- Change Name Model --}}
<div class="modal fade" id="renamepartnameModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Measurement Description</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('measurements_name.update')}}">
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
{{-- Edit Part Modal --}}
<div class="modal fade measurementsModals" id="edit-part-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Part</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="measurementsEditForm" class="measurementsForm" method="POST" action="{{route('measurement.editparts')}}">
      @csrf
      <div class="modal-body">
          <input type="hidden" name="measurement_id" id="measurement_id" />
          <input type="hidden" name="id" id="id" />
          <input type="hidden" name="type" id="type" value="count" />
          <p style="color: red;display: none;font-size:15px;" id="count_form_error">
            *Something went wrong. Please check your internet connection.
          </p>
          <div class="form-group">
            <label>Part No</label>
            <input type="text" class="form-control" name="part_no" id="part_no">
          </div>
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label>Description</label>
                <input type="text" class="form-control" name="description" id="part_name">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Unit of Measure</label>
                <input type="text" class="form-control" name="unit" id="unit">
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
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="">Formula</label>
                <input type="text" placeholder="Formula" class="form-control" id="formula" name="formula">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Total </label>
                <span id="total">0.00</span> ea
              </div>
            </div>
          </div>
          <div class="supports" style="display: flex;">
            <span>Supported References:</span>&nbsp;&nbsp; 
            <div id="count" style="display: none;">
              <div class="badge badge-info">count</div>
            </div>
            <div id="length" style="display: none;">
              <div class="badge badge-info">count</div>
              <div class="badge badge-info">len</div>
              <div class="badge badge-info">segments</div>
            </div>
            <div id="area" style="display: none;">
              <div class="badge badge-info">count</div>
              <div class="badge badge-info">len</div>
              <div class="badge badge-info">area</div>
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
{{-- Edit Labour Modal --}}
{{-- Add Labour --}}
<div class="modal fade measurementsModals" id="edit-labour-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Labour</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="editLaboursForm" class="measurementsForm" method="POST" action="{{route('measurements.editlabour')}}">
      @csrf
      <div class="modal-body">
          <input type="hidden" name="id" id="id" value="" />
          <input type="hidden" name="type" id="type" value="count" />
          <p style="color: red;display: none;font-size:15px;" id="count_form_error">
            *Something went wrong. Please check your internet connection.
          </p>
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label>Description</label>
                <input type="text" class="form-control" name="description" id="part_name">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Unit of Measure</label>
                <select name="unit" class="form-control" id="">
                  <option value="mins">Minutes</option>
                  <option selected value="hrs">Hours</option>
                  <option value="days">Days</option>
                  <option value="weeks">Weekly</option>
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
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="">Formula</label>
                <input type="text" placeholder="Formula" class="form-control" name="formula">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Total </label>
                <span> 0.00 ea</span>
              </div>
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
{{-- DeletePartModel --}}
<div class="modal fade" id="deletePartModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="modal-title" id="exampleModalLongTitle">
          Remove part <span id="name" style="font-weight: 600;"></span> from the Measurements?
        </p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('delete.part')}}">
      @csrf
      <div class="">
          <input type="hidden" id="id" value="" name="id" />
      </div>
      <div class="modal-footer" style="border-top: none!important;">
        <button class="btn btn-danger" type="submit">Delete Part</button>
      </div>
      </form>
    </div>
  </div>
</div>
{{-- Add Labour --}}
<div class="modal fade measurementsModals" id="addlabourmodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add Labour</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="addLaboursForm" class="measurementsForm" method="POST" action="{{route('measurements.addpart')}}">
      @csrf
      <div class="modal-body">
          <input type="hidden" name="id" id="id" value="" />
          <input type="hidden" name="type" id="type" value="count" />
          <p style="color: red;display: none;font-size:15px;" id="count_form_error">
            *Something went wrong. Please check your internet connection.
          </p>
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label>Description</label>
                <input type="text" class="form-control" name="description" id="part_name">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Unit of Measure</label>
                <select name="unit" class="form-control" id="">
                  <option value="mins">Minutes</option>
                  <option selected value="hrs">Hours</option>
                  <option value="days">Days</option>
                  <option value="weeks">Weekly</option>
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
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="">Formula</label>
                <input type="text" placeholder="Formula" class="form-control" name="formula">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Total </label>
                <span> 0.00 ea</span>
              </div>
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
{{-- Add Part Modal --}}
<div class="modal fade measurementsModals" id="addPartModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add Part</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="addPartsForm" class="measurementsForm" method="POST" action="{{route('measurements.addpart')}}">
      @csrf
      <div class="modal-body">
          <input type="hidden" name="id" id="id" value="" />
          <input type="hidden" name="type" id="type" value="count" />
          <p style="color: red;display: none;font-size:15px;" id="count_form_error">
            *Something went wrong. Please check your internet connection.
          </p>
          <div class="form-group">
            <label>Part No</label>
            <input type="text" class="form-control" name="part_no" id="part_no">
          </div>
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label>Description</label>
                <input type="text" class="form-control" name="description" id="part_name">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Unit of Measure</label>
                <input type="text" class="form-control" name="unit" id="unit">
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
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="">Formula</label>
                <input type="text" placeholder="Formula" class="form-control" name="formula">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Total </label>
                <span> 0.00</span>
              </div>
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
    $("#openchangeStyleModal .symbol-style-con .symbol-container ul li").click(function(){
      let html = $(this).html();
      $("#openchangeStyleModal button#symbol-style").html(html);
    });
    $("#fill").on('change', function(){
      let color = jQuery(this).val();
      $("#openchangeStyleModal ul li svg path").attr('fill',color);
      $(".count-symbol-button svg path").attr('fill',color);
    });
    $("#stroke").on('change', function(){
      let color = jQuery(this).val();
      $("#openchangeStyleModal ul li svg path").attr('stroke',color);
      $(".count-symbol-button svg path").attr('stroke',color);
    });


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
      console.log('11');
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
