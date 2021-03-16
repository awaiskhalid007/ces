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
  <link rel="preconnect" href="https://fonts.gstatic.com" />
  <link
    href="https://fonts.googleapis.com/css2?family=Lato&display=swap"
    rel="stylesheet"
  />
  <link rel="stylesheet" href="plans_assets/styles/main.css" />
  <link rel="stylesheet" href="plans_assets/styles/leftpan.css" />
  <link rel="stylesheet" href="plans_assets/styles/misc.css" />
  <link rel="stylesheet" href="plans_assets/fontawesome/css/all.css" />
</head>
<body class="projectPage">

  @include('dashboard.partials.header')
  <div class="container-fluid">
    <div class="nav-create--1">
      <label for="">PROJECT</label>
      <h5>Project</h5>
    </div>
    <section class="projects_tabs">
      <div class="container">
        @include('dashboard.partials.bottom-header')
      </div>
    </section>
    <div class="clearfix"></div>
    <div class="plans--edit">
      <div class="editor-container">
        <input type="hidden" id="plan_image_c" value="{{$host_url}}img/plans/{{$plan[0]->plan_image}}">
        <input type="hidden" id="plan_id" value="{{$plan[0]->id}}">
        <div class="right-panel">
          <div class="tabs">
            <ul cass="left-tab">
              <li id="stage" class="active">Stages</li>
              <li id="scale">Scale</li>
              <li id="detail">Details</li>
            </ul>
            <ul class="right-tab">
              <li id="check">
                <i class="fas fa-check-circle"></i>
              </li>
              <li id="savePdf">
                  <i class="fas fa-save"></i>
                  Save PDF
              </li>
            </ul>
          </div>
          <div class="tabs-content">
            <div class="stage-content active no-stage"></div>
            <div class="scale-content">
              <div class="document-collaboration">
                <h2>Document Collaboration</h2>
                <h3 class="scale-heading">Scale</h3>
                <div class="scale-forms">
                  <form id="setScale" class="active">
                    <select id="left-side-ratio">
                      <option value="1:10">1:10</option>
                      <option value="1:20">1:20</option>
                      <option value="1:25">1:25</option>
                      <option value="1:30">1:30</option>
                      <option value="1:50">1:50</option>
                      <option value="1:75">1:75</option>
                      <option value="1:100">1:100</option>
                      <option value="1:120">1:120</option>
                      <option value="1:150">1:150</option>
                      <option value="1:200">1:200</option>
                      <option value="1:250">1:250</option>
                      <option value="1:300">1:300</option>
                      <option value="1:500">1:500</option>
                    </select>
                    @
                    <select id="right-side-ratio">
                      <optgroup label="Auto">
                        <option value="Custom (189,267 pts)">
                          Custom (189,267 pts)
                        </option>
                      </optgroup>

                      <optgroup label="ISO">
                        <option value="4A0">4A0</option>

                        <option value="2A0">2A0</option>

                        <option value="A0">A0</option>

                        <option value="A1">A1</option>

                        <option value="A2">A2</option>

                        <option value="A3">A3</option>

                        <option value="A4">A4</option>

                        <option value="A5">A5</option>

                        <option value="B0">B0</option>

                        <option value="B1">B1</option>

                        <option value="B2">B2</option>

                        <option value="B3">B3</option>

                        <option value="B4">B4</option>

                        <option value="B5">B5</option>

                        <option value="C0">C0</option>

                        <option value="C1">C1</option>

                        <option value="C2">C2</option>

                        <option value="C3">C3</option>

                        <option value="C4">C4</option>

                        <option value="C5">C5</option>

                        <option value="D0">D0</option>
                      </optgroup>

                      <optgroup label="North America">
                        <option value="Government Letter">
                          Government Letter
                        </option>

                        <option value="Legal">Legal</option>

                        <option value="Junior Legal">Junior Legal</option>

                        <option value="Letter">Letter</option>

                        <option value="Ledger / Tabloid">Ledger / Tabloid</option>
                      </optgroup>

                      <optgroup label="ANSI">
                        <option value="ANSI A">ANSI A</option>

                        <option value="ANSI B">ANSI B</option>

                        <option value="ANSI C">ANSI C</option>

                        <option value="ANSI D">ANSI D</option>

                        <option value="ANSI E">ANSI E</option>
                      </optgroup>

                      <optgroup label="Architectural">
                        <option value="Arch A">Arch A</option>

                        <option value="Arch B">Arch B</option>

                        <option value="Arch C">Arch C</option>

                        <option value="Arch D">Arch D</option>

                        <option value="Arch E1">Arch E1</option>

                        <option value="Arch E">Arch E</option>
                      </optgroup>

                      <optgroup label="RA / SRA">
                        <option value="RA0">RA0</option>

                        <option value="RA1">RA1</option>

                        <option value="RA2">RA2</option>

                        <option value="RA3">RA3</option>

                        <option value="RA4">RA4</option>

                        <option value="SRA0">SRA0</option>

                        <option value="SRA1">SRA1</option>

                        <option value="SRA2">SRA2</option>

                        <option value="SRA3">SRA3</option>

                        <option value="SRA4">SRA4</option>
                      </optgroup>
                    </select>
                    <button class="setScale-btn" name="setScale">
                      Set Scale
                    </button>
                  </form>
                  <form id="resetScale">
                    <p>0 @ 0</p>
                    <button class="resetScale-btn">Reset</button>
                  </form>
                </div>
                <h3 class="txt-center">OR</h3>
                <button class="measureScale-btn">
                  <i class="fas fa-pen"></i> Measure Scale
                </button>
              </div>
              <div class="sections">
                <h2>Sections</h2>
                <table>
                  <thead>
                    <tr>
                      <th>Label</th>
                      <th>Scale</th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
                <p>There are no sections on this plan</p>
                <button class="addScale-btn">
                  <i class="fa fa-plus"></i> Scale
                </button>
              </div>
              <div class="grid">
                <h2>Grid</h2>
                <table>
                  <thead>
                    <tr>
                      <th>Width</th>
                      <th>Height</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><input type="number" value="0" disabled></td>
                      <td><input type="number" value="0" disabled></td>
                    </tr>
                  </tbody>
                </table>
                <button class="toggleGrid-btn">
                  <i class="fas fa-th"></i> Hide / Change Grid
                </button>
              </div>
            </div>
            <div class="detail-content">
              <div>
                <h2>Name</h2>
                <span class="link edit-name-btn">EDIT</span>
              </div>

              <input
                type="text"
                value="My House Map"
                disabled
                class="plan-name"
                name="plan-name"
              />

              <div>
                <h2>Status</h2>
                <span class="link" id="mark-complete">MARK COMPLETE</span>
              </div>
              <p id="project-status">Incomplete</p>

              <ul>
                <li><i class="fa fa-save"></i> Save as PDF</li>
                <li><i class="fa fa-cogs"></i> Setup Title Block</li>
                <li><i class="fa fa-crop"></i> Snip to new Plan</li>
                <li class="delete-button">
                  <form action="{{ route('delete.plan') }}" method="POST">
                    @csrf
                    <input type="hidden" value="{{$plan[0]->id}}" name="plan_id">
                    <input type="hidden" value="{{$project_salt}}" name="project_salt">
                    <input type="hidden" value="{{$project_id}}" name="project_id" id="project_id">

                    <button class="btn btn-block text-white"><i class="fas fa-trash"></i>&nbsp;&nbsp;Delete Plan</button>
                  </form>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="canvas-parent">
          <div class="status-bar"></div>
          <canvas id="c"></canvas>
        </div>
        <div class="controllers">
          <span title="Full Screen" id="fullscreen">
            <i class="fas fa-compress-alt"></i>
          </span>
          <span title="move" id="move" class="active">
            <i class="fas fa-arrows-alt"></i>
          </span>
          <span title="Zoom in" id="zoom-in">
            <i class="fas fa-search-plus"></i>
          </span>
          <span title="Zoom out" id="zoom-out">
            <i class="fas fa-search-minus"></i>
          </span>
          <span title="Rotate" id="rotate-left">
            <i class="fas fa-undo"></i>
          </span>
          <span title="Rotate" id="rotate-right">
            <i class="fas fa-undo fa-rotate-90"></i>
          </span>
          <span title="Add Text" id="add-text">
            <i class="fas fa-font"></i>
          </span>
          <span title="Pencil Tool" id="pencil-tool">
            <i class="fas fa-pen"></i>
          </span>
          <span title="Pen Tool" id="pen-tool">
            <i class="fas fa-pen-nib"></i>
          </span>
          <span title="Ruler" id="ruler">
            <i class="fas fa-ruler"></i>
          </span>
          <span title="Eraser" id="eraser">
            <i class="fas fa-eraser"></i>
          </span>
          <span title="Upload Image" id="upload-image" for="upload-image-control">
            <i class="fas fa-image"></i>
          </span>
        </div>

        <div class="modal" id="create-stage-modal">
          <div class="modal-body">
            <h2>Create Stage</h2>
            <form id="create-stage-form">
              <label for="stage-name">Name</label>
              <input type="text" id="stage-name" name="stage-name" required />
              <input type="hidden" id="plan-id" name="plan-id" value="{{$plan[0]->id}}">
              <input type="hidden" id="project-id" name="project-id" value="{{$plan[0]->project_id}}">
              <label for="stage-desc">Description</label>
              <input type="text" id="stage-desc" name="stage-desc" required />

              <label for="stage-quantity">Mutiply quantities</label>
              <input
                type="number"
                step="1"
                id="stage-quantity"
                name="stage-quantity"
                required
              />

              <div class="apply-template-con">
                <h3>Apply Template</h3>

                <div>
                  <input
                    type="radio"
                    id="blank-stage"
                    value="0"
                    name="apply-template"
                    checked
                  />
                  <label for="blank-stage"> Blank Stage </label>
                </div>
                <div>
                  <input
                    type="radio"
                    id="take-off-temp"
                    value="1"
                    name="apply-template"
                  />
                  <label for="take-off-temp"> Apply Take-Off Template </label>
                </div>
                <div>
                  <input
                    type="radio"
                    id="copy-from-stage"
                    value="2"
                    name="apply-template"
                  />
                  <label for="copy-from-stage"> Copy from stage </label>
                </div>

                <div id="takeofftemplate_model_div">
                  <p>
                    <strong>Take-Off Template</strong>
                  </p>
                  @if(!$takeoff->isEmpty())
                    @foreach($takeoff as $t)
                      <input type="radio" name="takeoff" id="takeoffInput-{{$t->id}}" value="{{$t->id}}">
                      <label for="takeoffInput-{{$t->id}}">{{$t->name}}</label>
                      <br>
                    @endforeach
                  @else
                    <p>No Take Off Template Found.</p>
                  @endif
                  <p id="errors" style="color: red;font-size:15px;"></p>
                </div>

                <div id="stages_model_div">
                  <p>
                    <strong>Stage</strong>
                  </p>
                  @if(!$stages->isEmpty())
                    @foreach($stages as $t)
                      <input type="radio" name="stage" id="stage-{{$t->id}}" value="{{$t->id}}">
                      <label for="stage-{{$t->id}}">{{$t->name}}</label>
                      <br>
                    @endforeach
                  @else
                    <p>No Stages Found.</p>
                  @endif
                  <p id="errors" style="color: red;font-size:15px;"></p>
                </div>

              </div>

              <div class="btn-group">
                <button type="submit">Create</button>
                <button id="close-stage-modal" type="reset">Close</button>
              </div>
            </form>
          </div>
        </div>

        <div class="modal" id="create-measurement-modal"></div>
      </div>
      <input
        type="file"
        id="upload-image-control"
        hidden="hidden"
        accept="image/png, image/jpeg"
      />
    </div>
  </div>
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/popper.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="fontawesome/js/all.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.20/lodash.min.js"></script>
  <script src="plans_assets/fontawesome/js/all.js"></script>
  <script src="plans_assets/scripts/fabric.min.js"></script>
  <script src="plans_assets/scripts/script.js"></script>
  <script src="plans_assets/scripts/extra.js"></script>
  <script src="js/ajax.js"></script>
  <script src="js/fonts/arrows.js"></script>
  <script src="js/fonts/generic.js"></script>
  <script>
    function editTodo(id, name)
    {
      $("#id").val(id);
      $("#todo_modal_name").val(name);
      $("#exampleModalCenter").modal('show');
    }
    $('#bottom_header .tab5').addClass('active');    
    $('#bottom_header .tab1').removeClass('active');
  </script>
</body>
</html>
 