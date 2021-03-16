<!DOCTYPE html>
<html lang="en">
<head>
  <base href="/">
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{csrf_token()}}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Projects</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel='stylesheet' href='css/style.css' type='text/css' />
  <link rel='stylesheet' href='fontawesome/css/all.min.css' type='text/css' />
  <script type="text/javascript" src="js/jquery.min.js"></script>

</head>
<body class="projectPage worksheetPage">

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
        <h3 class="heading">Worksheet</h3>      
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
                <div class="row">
                  <div class="col-md-6">
                    <h3 class="panel-title">{{$obj['stage']->name}}</h3>
                  </div>
                  <div class="col-md-6 text-right actionsDiv">
                    <button class="no-bg" onclick="openEditStageModal('{{$obj['stage']->id}}','{{$obj['stage']->name}}','{{$obj['stage']->description}}','{{$obj['stage']->multiplier}}')">
                      <i>X</i>
                      @if($obj['stage']->multiplier == '')
                        1
                      @else
                        {{$obj['stage']->multiplier}}
                      @endif
                    </button>
                    <button class="no-bg">
                      Actions
                    </button>
                    <button class="no-bg angle" data-toggle="dropdown">
                      <i class="fa fa-play-circle"></i>
                    </button>
                    <ul class="dropdown-menu">
                      <li class="disabled">
                        <a>Stage Actions</a>
                      </li>
                      <li class="divider"></li>
                      <li>
                        <a style="cursor: pointer;" onclick="openEditStageModal('{{$obj['stage']->id}}','{{$obj['stage']->name}}','{{$obj['stage']->description}}','{{$obj['stage']->multiplier}}')">
                          <i class="far fa-edit"></i>
                          Edit
                        </a>
                      </li>
                      <li>
                        <a style="cursor: pointer;" onclick="openEditStageModal('{{$obj['stage']->id}}','{{$obj['stage']->name}}','{{$obj['stage']->description}}','{{$obj['stage']->multiplier}}')">
                          <i class="fa fa-times"></i>
                          Multiply quantities
                        </a>
                      </li>
                      <li>
                        <a style="cursor: pointer;" onclick="openApplyTemplateModal('{{$obj['stage']->id}}','{{$obj['stage']->name}}')">
                          <i class="fa fa-file-alt"></i>
                          Apply Template
                        </a>
                      </li>
                      <li>
                        <a style="cursor: pointer;" onclick="openCopyTemplateModal('{{$obj['stage']->id}}','{{$obj['stage']->name}}')">
                          <i class="far fa-copy"></i>
                          Copy to new Template
                        </a>
                      </li>
                      <li class="divider"></li>
                      <li>
                        <a style="cursor: pointer;" onclick="openDeleteStageModal('{{$obj['stage']->id}}','{{$obj['stage']->name}}')">
                          <i class="fa fa-trash-alt"></i>
                          Delete
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="panel-body">  
                <table class="table">
                  
                  @if(!$obj['measurements']->isEmpty())
                  <thead>
                    <tr>
                    <th class="titleTH">
                      <p class="mea">Measurements</p>
                    </th>
                  </tr>
                    <tr>
                      <th style="width: 85%">Description</th>
                      <th style="width: 25%;text-align:right;">Total</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody class="vertical-align-middle js-sortable-item" data-id="4YKtJrEGyE623wvh4" draggable="false">
                    <?php $i = 1; ?>
                    <script>
                      
                    </script>
                    @foreach($obj['measurements'] as $m)
                    <tr class="tr-measurement" style="width: 100%;">
                      <td style="width: 85%">
                        <a class="link-with-hover-icon" href="/project/{{$project_salt}}/measurements/{{$m->id}}/edit/worksheet">
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
                            <li class="disabled"><a draggable="false">Measurement Actions</a></li>
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
                      <td colspan="4">
                        There are no measurements or additional items on this stage
                      </td>
                    </tr>
                  @endif
                </table>
                <table class="table additonalsTable">
                  
                  @if(!empty($obj['additionals']))
                  <thead>
                    <tr>
                    <th class="titleTH">
                      <p class="mea">Additional Items</p>
                    </th>
                    </tr>
                      <tr>
                        <th style="width: 20%;">Part #</th>
                        <th style="width: 50%;">Description</th>
                        <th style="width: 20%;text-align: right;">Quantity</th>
                        <th style="width: 10%;"></th>
                      </tr>
                  </thead>
                  <tbody class="vertical-align-middle js-sortable-item" data-id="4YKtJrEGyE623wvh4" draggable="false">
                    <?php $i = 1; ?>
                    <script>
                      
                    </script>
                    @foreach($obj['additionals'] as $m)
                    <tr class="tr-measurement" style="width: 100%;">
                      <td style="width: 30%">
                          {{$m->part_no}}
                      </td>
                      <td style="width: 50%">
                          {{$m->description}}
                      </td>
                      <td style="width: 20%;text-align: right;">
                        <a class="link-with-hover-icon" href="#" data-toggle="modal" onclick="openAdjustCountModal('{{$m->id}}','{{$m->total}}')" draggable="false">
                          <i class="fa fa-sort"></i> 
                          {{$m->total}} {{$m->unit}}
                          @if($m->total > 0)
                            <span style="font-size: 17px;"> *</span>
                          @endif
                        </a>
                      </td>
                      <td class="js-sortable-skip hidden-print">
                        <div class="table-action-menu">
                          <a href="#" class="dropdown-togle" data-toggle="dropdown" draggable="false"><i class="far fa-play-circle fa-rotate-90"></i></a>
                          <!-- drop down -->
                          <?php if($m->part_no == ''){
                              $m->part_no = 'undefined';
                          } ?>
                          <ul class="dropdown-menu pull-right" role="menu">
                            <li class="disabled"><a draggable="false">'Additional Item' Actions</a></li>
                            <li class="divider"></li>
                            <li>
                              <a style="cursor: pointer;" onclick="openAdditionalsEditModal('{{$m->id}}','{{$m->description}}','{{$m->part_no}}','{{$m->unit}}','{{$m->unit_cost}}','{{$m->markup}}','{{$m->unit_price}}','{{$m->total}}')" draggable="false"><i class="far fa-edit"></i> Edit Quantity</a>
                            </li>
                            <li>
                              <a onclick="openAdditionalDeleteModal('{{$m->id}}','{{$m->description}}')" style="cursor: pointer;" draggable="false"><i class="fa fa-times"></i> Delete</a>
                            </li>
                          </ul>
                        </div>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
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
                      <a onclick="openCountModal('{{$obj['stage']->id}}', '{{$obj['stage']->project_id}}')" data-toggle="dropdown" data-action="create-stage-modal" data-stage="{{$obj['stage']->id}}" style="cursor: pointer;" data-type="count">Count</a>
                    </li>
                    <li>
                      <a onclick="openLengthModal('{{$obj['stage']->id}}', '{{$obj['stage']->project_id}}')" data-toggle="dropdown" data-action="create-stage-modal" data-stage="{{$obj['stage']->id}}" style="cursor: pointer;" data-type="length">Length</a>
                    </li>
                    <li>
                      <a onclick="openAreaModal('{{$obj['stage']->id}}', '{{$obj['stage']->project_id}}')" style="cursor: pointer;" data-stage="{{$obj['stage']->id}}" data-type="area">Area</a>
                    </li>
                  </ul>
                </div>
                <div class="btn-group btn-group-dropup dropup" data-menu="100">
                  <a href="#" class="btn btn-success-aqua dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-plus"></i> Additional Item <span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu">
                    <li>
                      <a style="cursor: pointer;" onclick="openAdditionalModal('{{$obj['stage']->id}}', '{{$obj['stage']->project_id}}')" data-type="once-off">
                        <p class="title" style="margin-bottom: 0!important;">Groundplan</p>
                        <p class="item" style="margin-bottom: 0!important;">Once-Off Item</p>
                      </a>
                    </li>
                  </ul>
                </div>
                <a style="cursor: pointer;" onclick="openLabourModal('{{$obj['stage']->id}}', '{{$obj['stage']->project_id}}')" class="btn btn-success-aqua" data-type="labour">
                  <i class="fa fa-plus"></i> Additional Labour
                </a>
              </div>
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
          <input type="hidden" name="stage_id" id="stage_id" />
          <input type="hidden" name="project_id" id="project_id" value="" />
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
{{-- Edit Stage Modal --}}
<div class="modal fade" id="editStageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Stage</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('worksheet.stage.update')}}">
      @csrf
      <div class="modal-body">
          <input type="hidden" id="id" value="" name="id" />
          <div class="form-group">
            <label>Stage name</label>
            <input type="text" class="form-control" id="name" name="name" id="name" required="required" />
          </div>
          <div class="form-group">
            <label>Description</label>
            <textarea name="description" id="description" style="height: 40px;" class="form-control"></textarea>
          </div>
          <div class="form-group">
            <label>Multiply Quantities</label>
            <input type="text" class="form-control" id="multiply" name="multiply" />
          </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" type="submit">Update</button>
      </div>
      </form>
    </div>
  </div>
</div>
{{-- Edit Stage Modal --}}
<div class="modal fade" id="applyTemplateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Apply Template to Stage</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <input type="hidden" id="id" value="" name="id" />
          <div class="form-group">
            <label>Stage name</label>
            <p id="name"></p>
          </div>
          <div class="form-group">
            <label>Apply Template</label><br>
            <input type="radio" id="takeoff" name="template" value="takeoff">
            <label for="takeoff" style="font-weight: 400!important;">Apply Take-Off Template</label>
            <br>
            <input type="radio" id="stage" name="template" value="stage">
            <label for="stage" style="font-weight: 400!important;">Copy from Stage</label>
          </div>
          <div class="form-group" id="TemplatesDiv" style="display: none;">
            <label>Take-Off Template</label>
            @if(!$takeoffs->isEmpty())
              @foreach($takeoffs as $take)
                <br>
                <input type="radio" name="takeoff_id" value="{{$take->id}}" id="takeoff" />
                <label for="takeoff" style="font-weight: 400!important;">{{$take->name}}</label>
              @endforeach
            @endif
          </div>
          <div class="form-group" id="StagesDiv" style="display: none;">
            <label>Stage</label>
            @if(!$stages->isEmpty())
              @foreach($stages as $stage)
                <br>
                {{-- @if($stage->id == ) --}}
                <input type="radio" name="stage_id" value="{{$stage->id}}" id="stage_id" />
                <label for="stage_id" style="font-weight: 400!important;">{{$stage->name}}</label>
              @endforeach
            @endif
          </div>
          <p id="error" style="color: red; font-size:16px;"></p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" type="submit" id="submit">Update</button>
      </div>
    </div>
  </div>
</div>
{{-- Apply To New Template Modal --}}
<div class="modal fade" id="duplicateTemplateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Copy to new Take-Off Template</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('worksheet.stage.applytemplate')}}">
      @csrf
      <div class="modal-body">
          <input type="hidden" id="id" value="" name="id" />
          <div class="form-group">
            <label>Stage to Copy</label>
            <p id="name"></p>
          </div>
          <div class="form-group">
            <label>New template name</label>
            <input type="text" class="form-control" id="template_name" name="name" />
          </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" type="submit">Update</button>
      </div>
      </form>
    </div>
  </div>
</div>
{{-- Delete Stage Modal --}}
<div class="modal fade" id="deleteStageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Delete Stage</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('worksheet.stage.delete')}}">
      @csrf
      <div class="modal-body">
          <input type="hidden" id="id" value="" name="id" />
          <div class="form-group">
            Delete the Stage <b id="name"></b>?
          </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-danger" type="submit" style="font-size: 15px;"><i class="fa fa-trash-alt" style="font-size: 14px;"></i> Delete</button>
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
  <script src="js/fonts/generic.js"></script>
  <script src="js/fonts/arrows.js"></script>

  <script>
    $('#bottom_header .tab3').addClass('active');    
    $('#bottom_header .tab1').removeClass('active');
    $("#scroller select").on('change', function() {
      let a = $(this).val();
      let id = '#' + a;
      $('html, body').animate({
              scrollTop: $(id).offset().top
          }, 1000);
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
 {{-- 475 --}}