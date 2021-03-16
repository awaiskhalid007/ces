//  1173
let activeMode = "move";
let plan_image_c = $("#plan_image_c").val();
let plan_id = $("#plan_id").val();
let project_id = $("#project_id").val();
let CSRF_TOKEN = $("meta[name='csrf-token']").attr('content');


async function App(url) {
  let mapImage;
  const basicStyle = {
    borderColor: "cyan",
    cornerColor: "blue",
    cornerSize: 8,
    cornerStyle: "circle",
  };


  const parentCanvas = document.querySelector(".canvas-parent");
  const { clientWidth, clientHeight } = parentCanvas;

  let canvas = new fabric.Canvas("c", {
    width: clientWidth,
    height: clientHeight,
    backgroundColor: "#ddd",
  });

  await addBgImage();
  let state;
  let prevState = JSON.parse(localStorage.getItem("state")); 
  if(prevState && prevState.planId == plan_id) 
    state = prevState;
  else{
    localStorage.removeItem("state");
    state = {
      index: 0,
      stages: [JSON.stringify([])],
      canvas: [JSON.stringify(canvas.toJSON(["id", "groupId"]))],
      planId: plan_id,
    }
  };

// Debugging
  window.state = state;
  window.canvas = canvas;

  if (
    state.canvas[state.index] !==
    JSON.stringify(canvas.toJSON(["id", "groupId"]))
  ) {
    const canvasData = state.canvas[state.index];
    if (canvasData)
      canvas.loadFromJSON(canvasData, canvas.renderAll.bind(canvas));
  }
  // let stages = JSON.parse(state.stages[state.index]);

let stages;
let stagesLength = [];

 function fetchStages()
 {
   stages;
    $.ajax({
      'async': false,
      'global': false,
      url: 'editor/fetch/stages',
      type: 'POST', 
      data: {_token: CSRF_TOKEN, plan_id: plan_id},
      success: function(res)  
      {
        stages = res;
      }
    });
 }
fetchStages();
     
  activeMode;
  let countValue = {
    value: "",
    stroke: "",
    fill: "",
    size: 30,
    instances: 0,
    stageId: "",
    id: "",
  };

  const modes = {
    "pen-tool": "pen-tool",
    "pencil-tool": "pencil-tool",
    move: "move",
    erase: "erase",
    ruler: "ruler",
    count: "count",
    length: "length",
    area: "area",
  };

  const updateMode = (value) => {
    activeMode = value;

    const el = document.getElementById("measurement-" + countValue.id);

    if (
      value === modes.count ||
      value === modes.length ||
      value === modes.area
    ) {
      const prevEl = document.querySelector(".selected");
      if (prevEl) prevEl.classList.remove("selected");

      el.classList.add("selected");
    } else {
      if (el) el.classList.remove("selected");
    }

    if (value === "") {
      resetPreferences();
    }

    renderStatusBar();
  };

  function photoEditor() {
    fabric.Object.prototype.hide = function () {
      this.set({
        opacity: 0,
        selectable: false,
      });
    };

    fabric.Object.prototype.show = function () {
      this.set({
        opacity: 1,
        selectable: true,
      });
    };

    fabric.Canvas.prototype.getById = function (id) {
      const objs = this.getObjects();

      for (let i = 0; i < objs.length; i++) {
        if (id === objs[i].id) {
          return objs[i];
        }
      }
    };

    fabric.Canvas.prototype.getByGroupId = function (id) {
      const result = [];
      const objs = this.getObjects();

      for (let i = 0; i < objs.length; i++) {
        if (id === objs[i].groupId) {
          result.push(objs[i]);
        }
      }
      return result;
    };

    let fullScreen = false;
    

    const controllers = document.querySelector(".controllers");

    controllers.addEventListener("click", (e) => {
      const el = e.path.filter((elm) => elm.id);
      let action = el && el[0].id;

      actionHandler(action);
    });

    window.addEventListener("resize", resizeCanvas);

    function resizeCanvas() {
      let width, height;
      const el = document.querySelector(".canvas-parent");
      height = el.clientHeight;
      width = el.clientWidth;

      canvas.setWidth(width);
      canvas.setHeight(height);

      addBgImage(
        plan_image_c
      );
      updateCanvas();
    }

    const actionHandler = (action) => {
      resetPreferences();

      switch (action) {
        case "fullscreen":
          toggleFullscreen();
          break;
        case "move":
          toggleMove();
          setActive();
          break;
        case "zoom-in":
          zoom("in");
          break;
        case "zoom-out":
          zoom("out");
          break;
        case "rotate-left":
          rotate("left");
          break;
        case "rotate-right":
          rotate("right");
          break;
        case "add-text":
          addText();
          setActive();
          break;
        case "pencil-tool":
          pencilTool();
          setActive();
          break;
        case "pen-tool":
          penTool();
          setActive();
          break;
        case "upload-image":
          uploadImage();
          setActive();
          break;
        case "eraser":
          eraseTool();
          setActive();
          break;
        case "ruler":
          rulerTool();
          setActive();
          break;

        default:
          console.log("Nothing appropirate");
      }

      function setActive() {
        const active = document.getElementById(action);
        active.classList.add("active");
      }
    };

    const eventHanlder = (() => {
      let mousePressed = false;
      let oneSideDrawn = false;
      let isObjMoving = false;

      // Length && area && PEN TOOL
      let polyLine;
      let points = [];
      let shapeId;

      canvas.on("mouse:move", (event) => {
        const mouse = canvas.getPointer(event.e);
        const { x, y } = mouse;

        if (mousePressed && activeMode === modes.move) moveMove();
        else if (mousePressed && activeMode === modes.erase) eraserMove();
        else if (oneSideDrawn && activeMode === modes.ruler) rulerMove();
        else if (polyLine && activeMode === modes["pen-tool"]) 
          lengthNareaTool("Polyline");
        else if (polyLine && activeMode === modes.length)
          lengthNareaTool("Polyline");
        else if (polyLine && activeMode === modes.area)
          lengthNareaTool("Polygon");

        function lengthNareaTool(type) {
          canvas.isDrawingMode = false;
          canvas.selection = false;
          drawPoly(x + 2.5, y + 2.5, type);
        }

        function rulerMove() {
          const line = canvas.getActiveObject();
          const lineTxt = canvas.getById("myId");

          const mouse = canvas.getPointer(event.e);
          const { x } = mouse;

          const width = Math.abs(x - line.left);

          if (!width) {
            return false;
          }

          line.set({ width });
          lineTxt.set({
            text: parseFloat(width/5).toFixed(2) + " m",
            left: line.left + width / 2 - 15,
          });

          window.lineTxt = lineTxt;
          updateCanvas();
        }

        function eraserMove() {
          canvas.selection = false;
          const square = canvas.getActiveObject();
          const mouse = canvas.getPointer(event.e);

          const w = Math.abs(mouse.x - square.left);
          const h = Math.abs(mouse.y - square.top);

          if (!w || !h) {
            return false;
          }

          square.set({ width: w, height: h });
          updateCanvas();
        }

        function moveMove() {
          canvas.setCursor(canvas.moveCursor);
          canvas.renderAll();
          const mEvent = event.e;
          const delta = new fabric.Point(mEvent.movementX, mEvent.movementY);
          canvas.relativePan(delta);
        }
      });
      // keep track of mouse down/up
      canvas.on("mouse:down", (event) => {
        mousePressed = true;

        const mouse = canvas.getPointer(event.e);
        const { x, y } = mouse;

        if (activeMode === modes.move) moveDown();
        else if (activeMode === modes.erase) eraserDown();
        else if (activeMode === modes.ruler) rulerDown();
        else if (activeMode === modes["pen-tool"]) {
          countValue = {
            lineStyle: "style-1-0",
            fillColor: "",
            strokeColor: "black",
            stroke: 'black',
            lineWidth: "5",
          };
          lengthNareaTool("Polyline");
        }
        else if (activeMode === modes.count) countTool();
        else if (activeMode === modes.length) lengthNareaTool("Polyline");
        else if (activeMode === modes.area) lengthNareaTool("Polygon");

        function lengthNareaTool(type) {
          points.push({ x: x + 2.5, y: y + 2.5 });

          const rect = new fabric.Rect({
            width: 5,
            height: 5,
            top: y,
            left: x,
            fill: "rgb(4 176 176)",
            stroke: "rgb(4 185 185)",
            strokeWidth: 2,
            id: polyLine ? "temp-rect" : "first-rect",
            selectable: false,
          });

          canvas.add(rect).requestRenderAll();

          if (!polyLine) {
            canvas.isDrawingMode = false;
            points = [];
            points.push({ x: x + 2.5, y: y + 2.5 });
            points.push({ x: x + 2.5, y: y + 2.5 });

            drawPoly(x + 2.5, y + 2.5, type);
          } else {
            const objs = canvas.getObjects();
            let shouldDel = false;

            objs.forEach((obj) => {
              if (obj.id === "first-rect") {
                const { top, height, width, left } = obj;
                if (
                  y >= top &&
                  y <= top + height &&
                  x >= left &&
                  x <= left + width
                ) {
                  shouldDel = true;
                  canvas.remove(obj);
                  canvas.remove(rect);
                  finishShape();
                }
              }
              if (shouldDel && obj.id === "temp-rect") {
                canvas.remove(obj);
                updateCanvas();
                updateStagesUI();
              }
            });
          }
        }

        function finishShape() {
          polyLine.selectable = true;
          polyLine.evented = true;
          canvas.selection = true;

          for (const stage of stages) {
            if (stage.id === countValue.stageId) {
              for (const measure of stage.measurements) {
                if (measure.id === countValue.id) {
                  measure.child.push(shapeId);
                  shapeId = undefined;
                  break;
                }
              }
            }
          }

          polyLine = undefined;
          points = [];
        }

        function countTool() {
          const { value, strokeColor, size, fillColor, instances } = countValue;

          if (!checkIfObjExist(x, y, instances)) {
            const id = new Date().getTime().toString();
            fabric.loadSVGFromString(value, function (objects, options) {
              const obj = fabric.util.groupSVGElements(objects, options);
              obj
                .scaleToHeight(size)
                .set({ left: x, top: y })
                .set({ fill: fillColor, stroke: strokeColor })
                .set({
                  id,
                  groupId: countValue.id,
                })
                .setCoords();

              canvas.add(obj).requestRenderAll();
            });
            countValue.instances++;
            updateStageInstances(countValue.stageId, countValue.id, id);
          }
        }

        // function rulerDown() {
        //   const mouse = canvas.getPointer(event.e);
        //   const { x, y } = mouse;

        //   const side = new fabric.Rect({
        //     width: 3,
        //     height: 16,
        //     left: x,
        //     top: y,
        //     fill: "#222",
        //   });

        //   canvas.add(side);
        //   updateCanvas();

        //   if (oneSideDrawn) {
        //     oneSideDrawn = false;

        //     const objs = canvas.getObjects();
        //     const length = objs.length;

        //     const line = objs[length - 2];
        //     const side2 = objs[length - 3];
        //     side.set({ top: side2.top });

        //     const txt = new fabric.Text("ruler string", {
        //       fontSize: 10,
        //       left: line.left + line.width / 2,
        //       top: side.top - 5,
        //     });
        //     canvas.add(txt);

        //     txt.set({ left: txt.left - txt.width / 2 });

        //     const rulerGroup = new fabric.Group(
        //       [side2, line, side, txt],
        //       basicStyle
        //     );
        //     canvas.add(rulerGroup);
        //     canvas.remove(side2);
        //     canvas.remove(line);
        //     canvas.remove(side);
        //     canvas.remove(txt);
        //     canvas.setActiveObject(rulerGroup);
        //     updateCanvas();
        //     updateMode("");
        //   } else {
        //     const line = new fabric.Rect({
        //       width: 0,
        //       height: 3,
        //       left: x,
        //       top: y + 6,
        //       fill: "#222",
        //     });

        //     canvas.add(line);
        //     updateCanvas();
        //     canvas.setActiveObject(line);

        //     oneSideDrawn = true;
        //   }
        // }
        function rulerDown() {
          const mouse = canvas.getPointer(event.e);
          const { x, y } = mouse;

          const side = new fabric.Rect({
            width: 3,
            height: 16,
            left: x,
            top: y,
            fill: "#222",
          });

          canvas.add(side);
          updateCanvas();

          if (oneSideDrawn) {
            oneSideDrawn = false;

            const objs = canvas.getObjects();
            const length = objs.length;

            const line = objs[length - 3];
            const side2 = objs[length - 4];
            side.set({ top: side2.top });

            const txt = canvas.getById("myId");

            const rulerGroup = new fabric.Group([side2, line, side, txt], {
              basicStyle,
              lockScalingX: true,
              lockScalingY: true,
            });
            canvas.add(rulerGroup);

            canvas.remove(side2);
            canvas.remove(line);
            canvas.remove(side);
            canvas.remove(txt);

            canvas.setActiveObject(rulerGroup);
            updateCanvas();
            updateMode("");
          } else {
            const line = new fabric.Rect({
              width: 0,
              height: 3,
              left: x,
              top: y + 6,
              fill: "#222",
            });

            const txt = new fabric.Text("0 m", {
              fontSize: 10,
              left: line.left + line.width / 2,
              top: side.top - 5,
              id: "myId",
            });

            txt.set({ left: txt.left - txt.width / 2 });

            canvas.add(line);
            canvas.add(txt);
            updateCanvas();
            canvas.setActiveObject(line);
            oneSideDrawn = true;
          }
        }

        function eraserDown() {
          const mouse = canvas.getPointer(event.e);
          const { x, y } = mouse;

          const square = new fabric.Rect({
            width: 0,
            height: 0,
            left: x,
            top: y,
            fill: "#fff",
          });

          canvas.add(square);
          canvas.sendToBack(square);
          canvas.setActiveObject(square);
          updateCanvas();
        }

        function moveDown() {
          canvas.setCursor(canvas.rotationCursor);
          canvas.renderAll();
        }
      });

      canvas.on("mouse:up", (event) => {
        mousePressed = false;
        canvas.setCursor("default");
        if (activeMode === modes.erase) {
          updateMode("");
          updateCanvas();
        } else if (activeMode === modes["pencil-tool"]) {
          updateCanvas();
          renderStatusBar();
        }

        if (isObjMoving) {
          updateState();
          isObjMoving = false;
        }
      });

      canvas.on("selection:created", function () {
        renderStatusBar();
      });
      canvas.on("selection:cleared", function () {
        renderStatusBar();
      });

      canvas.on("object:moving", () => {
        isObjMoving = true;
      });

      function checkIfObjExist(x, y, start) {
        const objs = canvas.getObjects();

        for (let i = objs.length - start; i < objs.length; i++) {
          const { top, left, width, height, scaleX, scaleY } = objs[i];
          if (
            y >= top &&
            y <= top + height * scaleY &&
            x >= left &&
            x <= left + width * scaleX
          ) {
            return true;
          }
        }
        return false;
      }

      function drawPoly(x, y, type) {
        const { strokeColor, lineWidth, lineStyle, fillColor } = countValue;

        if (polyLine) canvas.remove(polyLine);
        points[points.length - 1] = { x, y };

        shapeId = new Date().getTime().toString();

        polyLine = new fabric[type](points, {
          ...basicStyle,
          stroke: strokeColor,
          fill: fillColor,
          strokeWidth: Number(lineWidth) || 5,
          selectable: false,
          evented: false,
          id: shapeId,
          groupId: countValue.id,
        });

        if (type === "Polyline" && lineStyle)
          polyLine.set({
            strokeDashArray: lineStyle
              .split("-")
              .filter((s, i) => i !== 0 && s)
              .map((s) => Number(s)),
          });

        canvas.add(polyLine);
        canvas.sendToBack(polyLine);
        canvas.requestRenderAll();
      }
    })();

    async function toggleFullscreen() {
      const editorContainer = document.querySelector(".editor-container");
      editorContainer.classList.toggle("fullscreen");
      try {
        if (fullScreen) {
          await document.exitFullscreen();
          fullScreen = false;
          resizeCanvas();
        } else {
          await editorContainer.requestFullscreen();
          fullScreen = true;
          resizeCanvas();
        }
      } catch (err) {
        console.log(err);
      }
    }

    function eraseTool() {
      updateMode(modes.erase);
    }

    function rulerTool() {
      updateMode(modes.ruler);
    }

    function toggleMove() {
      canvas.selection = false;
      updateMode(modes.move);
    }

    function zoom(inout) {
      let zoom = canvas.getZoom();

      if (inout === "in") zoom += 0.5;
      else if (inout === "out"){
        if(zoom <= 0.5 )
        {
          zoom = 0.25;
        }else{
          zoom -= 0.5;
        }
      }

      const center = canvas.getCenter();

      canvas.setZoom(1); // reset zoom so pan actions work as expected
      vpw = canvas.width / zoom;
      vph = canvas.height / zoom;

      x = center.left - vpw / 2;
      y = center.top - vph / 2;

      canvas.absolutePan({ x, y });
      canvas.setZoom(zoom);

      updateCanvas();
    }

    function rotate(dir) {
      let { angle } = mapImage;
      if (dir === "left") angle += 90 % 360;
      else if (dir === "right") angle -= 90 % 360;
      
      console.log(mapImage.angle);

      // canvas.item(0).angle = angle;

      mapImage.rotate(angle);
      console.log(mapImage.angle);
      updateCanvas();
      
    }

    function addText() {
      const txtStyle = {
        ...basicStyle,
        fontSize: 20,
        padding: 6,
        borderOpacityWhenMoving: 1,
        editingBorderColor: "Cyan",
      };
      const txt = new fabric.IText("Enter your text here", txtStyle);
      canvas.add(txt);

      canvas.setActiveObject(txt);

      txt.selectionStart = 0;
      txt.selectionEnd = 20;
      txt.selectAll();

      canvas.centerObject(txt);
      txt.enterEditing();
      updateCanvas();
    }

    function pencilTool() {
      updateMode(modes["pencil-tool"]);
      canvas.isDrawingMode = true;
      canvas.freeDrawingBrush.width = 3;
    }

    function penTool() {
      updateMode(modes["pen-tool"]);
    }

    function uploadImage() {
      const inputEl = document.querySelector("input[hidden=hidden]");
      inputEl.click();

      inputEl.addEventListener("change", () => {
        const file = inputEl.files[0];
        if (file) {
          const reader = new FileReader();

          reader.onload = function (e) {
            const { result } = e.target;

            fabric.Image.fromURL(result, function (myImg) {
              myImg.set({...basicStyle, crossOrigin });
              myImg.scaleX = 0.5;
              myImg.scaleY = 0.5;
              canvas.add(myImg);
              updateState();
            });
          };

          reader.readAsDataURL(file);
          inputEl.value = "";
        }
      });
    }
  }

  photoEditor();

  function rightPan() {
    let checked = false;
    let closeStageModalBtn;

    const tabs = document.querySelector(".tabs");
    const markComplete = document.getElementById("mark-complete");
    const projectStatus = document.getElementById("project-status");
    const setScale = document.getElementById("setScale");
    const resetScale = document.getElementById("resetScale");
    const toggleGrid = document.querySelector(".toggleGrid-btn");
    const stageContent = document.querySelector(".stage-content");
    const addStageForm = document.getElementById("create-stage-form");
    const stageModal = document.getElementById("create-stage-modal");
    const editNameBtn = document.querySelector(".edit-name-btn");

    stageContent.addEventListener("click", handleStageEvents);
    stageModal.addEventListener("click", handleCloseModal, true);
    tabs.addEventListener("click", handleSwitchTabs);
    markComplete.addEventListener("click", toggleStatus);
    setScale.addEventListener("submit", handleSetScale);
    resetScale.addEventListener("submit", handleResetScale);
    toggleGrid.addEventListener("click", handleToggleGrid);
    addStageForm.addEventListener("submit", handleAddStageForm);
    editNameBtn.addEventListener("click", handleEditName);

    updateStagesUI(true);

    function handleEditName() {
      const editName = document.querySelector(".plan-name");

      if (editName.disabled) {
        editName.removeAttribute("disabled");
        editName.focus();
        editNameBtn.textContent = "UPDATE";
      } else {
        editName.disabled = "disabled";
        editNameBtn.textContent = "EDIT";
      }
    }

    function handleStageEvents(e) {
      e.preventDefault();
      const element = e.path.filter((el) => el.id);
      const id = element && element[0] && element[0].id;
      if (id) {
        switch (id) {
          case "addStage":
            handleAddStage();
            break;
          case "addLength":
            handleAddMeasurement("Length", getLengthMarkup, element[1].id);
            break;
          case "addCount":
            handleAddMeasurement("Count", getCountMarkup, element[1].id);
            load_symbols();
            break;
          case "addArea":
            handleAddMeasurement("Area", getAreaMarkup, element[1].id);
            break;
          case "toggle-all":
            toggleAllStages();
            break;
          case id.match(/toggle-measurement-.*/g) &&
            id.match(/toggle-measurement-.*/g)[0]:
          case id.match(/hide-measurement-.*/g) &&
            id.match(/hide-measurement-.*/g)[0]:
            toggleMeasurement();
            break;
          case id.match(/select-.*/g) && id.match(/select-.*/g)[0]:
            selectMeasurement();
            break;
          case id.match(/toggle-.*/g) && id.match(/toggle-.*/g)[0]:
            toggleStage(e);
            break;
          case id.match(/delete-measurement-.*/g) &&
            id.match(/delete-measurement-.*/g)[0]:
            deleteMeasurement();
            break;
          case id.match(/delete-.*/g) && id.match(/delete-.*/g)[0]:
            deleteStage();
            break;
        }
      }

      function selectMeasurement() {
        const [_, type, typeId] = id.split("-");

        stages.forEach((stage) => {
          stage.measurements.forEach((measure) => {
            if (measure.id === typeId) {
              countValue = { ...measure, stageId: stage.id };

              if (type === "count")
                countValue.value = measure.type.match(/<svg.*<\/svg>/)[0];
            }
          });
        });

        toggleMeasurement(true);
        resetPreferences();
        updateMode(modes[type]);
      }

      function toggleMeasurement(onlyShow = false) {
        const aId = id.split("-")[2];
        const objs = canvas.getObjects();
        objs.forEach((obj) => {
          if (obj.groupId === aId) {
            let isHidden = false;

            if (onlyShow || obj.opacity === 0) {
              obj.show();
            } else if (obj.opacity === 1) {
              obj.hide();
              isHidden = true;
              updateMode("");
            }

            stages.forEach((stage) => {
              stage.measurements.forEach((measure) => {
                if (measure.id === aId) measure.isHidden = isHidden;
              });
            });
          }
        });
        updateCanvas();
        updateStagesUI();
      }

      function toggleStage() {
        const contentId = id.split("-")[1];
        document.getElementById(contentId).classList.toggle("hide");
      }

      function deleteMeasurement() {
        const measureId = id.substr(id.indexOf("measurement"));
        let ex = measureId.split('-');
        let index = ex[1];
        $.ajax({
          url: '/editor/measurement/delete',
          type: 'POST',
          data: {_token: CSRF_TOKEN, id:index},
          success: function(res)
          {}
        });
        stages.forEach((stage) => {
          stage.measurements.forEach((m ,i) => {
            if(m.id == index)
            {
              stage.measurements.splice(i, 1);
            }
          });
        });
        

        updateStagesUI();
        updateCanvas();
      }

      function deleteStage() {
        const stageId = id.split("-")[1];
        const index = stages.findIndex((stage) => stage.id == stageId);

        stages[index].measurements.forEach((m) => {
          const objs = canvas.getByGroupId(m.id);

          objs.forEach((o) => {
            canvas.remove(o);
          });
        });

        console.log(index);
        $.ajax({
          url: '/editor/plan/stage/delete',
          type: 'POST',
          data:{_token:CSRF_TOKEN, id:stageId},
          success: function(res)
          {
            if(res == 1){
              console.log('Stage Deleted');
              stages.splice(index, 1);
              updateStagesUI();
              updateCanvas();
            }
          }
        });

        
      }

      function toggleAllStages() {
        const stageEls = document.querySelectorAll(".stage-measurements");
        const stageElArr = Array.from(stageEls);
        stageElArr.forEach((el) => el.classList.toggle("hide"));
      }

      function getLengthMarkup() {
        return `<div class="multi-field-con small-inputs evenly">
                <div>
                  <label for="stroke-color">Stroke Colour</label>
                  <input type="color" id="stroke-color" name="stroke-color" required value="#d100a4" />
                </div>
                <div class="line-style-con">
                  <label for="line-style">Line Style</label>
                  <button type="button" id="line-style" name="line-style" value="style-1-0">
                    <svg width="100px" height="16px" viewBox="0 0 100 16">
                      <line x1="0" y1="8" x2="100" y2="8" style="stroke: rgb(128, 0, 128); stroke-width: 4;"></line>
                    </svg>
                    <svg width="20px" height="20px" viewBox="0 0 7 7">
                        <path d="M0,3.5 L7,3.5" stroke="#800080"></path>
                    </svg>
                  </button>
                  <div id="line-styles-con">
                    <ul>
                      <li id="style-1">
                         <svg width="100px" height="16px" viewBox="0 0 100 16">
                            <line x1="0" y1="8" x2="100" y2="8" style="stroke: rgb(128, 0, 128); stroke-width: 4;"></line>
                          </svg>
                          <svg width="20px" height="20px" viewBox="0 0 7 7">
                          <path d="M0,3.5 L7,3.5" stroke="#800080"></path>
                          </svg>
                      </li>
                      <li id="style-3-3">
                        <svg width="100px" height="16px" viewBox="0 0 100 16">
                          <line x1="0" y1="8" x2="100" y2="8" style="stroke: rgb(128, 0, 128); stroke-width: 4; stroke-dasharray: 12, 4;"></line>
                        </svg>
                        <svg width="20px" height="20px" viewBox="0 0 11 11">
                          <path d="M0,5.5 L11,5.5" stroke="#800080" style="stroke-dasharray: 3, 1;"></path>
                        </svg>
                      </li>
                      <li id="style-1-3">
                        <svg width="100px" height="16px" viewBox="0 0 100 16">
                          <line x1="0" y1="8" x2="100" y2="8" style="stroke: rgb(128, 0, 128); stroke-width: 4; stroke-dasharray: 4, 4;"></line>
                        </svg>
                        <svg width="20px" height="20px" viewBox="0 0 9 9">
                          <path d="M0,4.5 L9,4.5" stroke="#800080" style="stroke-dasharray: 1, 1;"></path>
                        </svg>
                      </li>
                    </ul>
                  </div>
                </div>
                <div>
                  <label for="line-width">Line Width</label>
                  <input type="number" id="line-width" name="line-width" value="5"/>
                </div>
              </div>`;
      }

      function getCountMarkup() {
        return `<div class="multi-field-con small-inputs evenly" id="iconsBox">
              <div class="symbol-style-con">
                <label for="symbol-style">Symbol</label>
                <button id="symbol-style" name="symbol-style" type="button" onclick="toggleSymbolBox()">
                  <svg class="svg-inline--fa fa-bell fa-w-14" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="bell" role="img" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M224 512c35.32 0 63.97-28.65 63.97-64H160.03c0 35.35 28.65 64 63.97 64zm215.39-149.71c-19.32-20.76-55.47-51.99-55.47-154.29 0-77.7-54.48-139.9-127.94-155.16V32c0-17.67-14.32-32-31.98-32s-31.98 14.33-31.98 32v20.84C118.56 68.1 64.08 130.3 64.08 208c0 102.3-36.15 133.53-55.47 154.29-6 6.45-8.66 14.16-8.61 21.71.11 16.4 12.98 32 32.1 32h383.8c19.12 0 32-15.6 32.1-32 .05-7.55-2.61-15.27-8.61-21.71z"></path></svg>
                </button>
     
              </div>
              <div>
                <label for="fill-color">Fill Color</label>
                <input type="color" id="fill-color" name="fill-color" value="#B35107" />
              </div>
              <div>
                <label for="stroke-color">Stroke Colour</label>
                <input type="color" id="stroke-color" name="stroke-color" value="#B35107" />
              </div>
              <div>
                <label for="count-size">Size</label>
                <input type="number" id="count-size" name="count-size" value="30"/>
              </div>
            </div>

            <div class="scCustom">
              <div class="row">
                <div class="col-md-6">
                  <select id="packSelect" class="form-control" onchange="change_pack()">
                    <option value="generic">Generic</option>
                    <option value="arrows">Arrows</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <div class="input-group mb-3" style="display:flex;">
                    <div>
                      <input type="text" class="form-control" placeholder="Filter symbols by name" id="symbolSearchBox" onkeyup="searchIcon()">
                    </div>
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

            `;
      }

      function getAreaMarkup() {
        return `<div class="multi-field-con small-inputs evenly" style="justify-content: flex-start">
                <div class="col-md-4">
                  <label for="fill-color">Fill Style</label>
                  <input type="color" id="fill-color" name="fill-color" value="#ff0000"/>
                </div>
                <div class="col-md-4">
                  <label for="stroke-color">Stroke Colour</label>
                  <input type="color" id="stroke-color" name="stroke-color" value="#aa0000"/>
                </div>
                <div class="col-md-4">
                  <label for="size">Size</label>
                  <input type="text" id="size" name="size" value="30"/>
                </div>
              </div>`;
      }
    }

    function handleAddMeasurement(name, getStyle, parentId) {
      const measureModal = document.getElementById("create-measurement-modal");
      measureModal.classList.add("active");
      measureModal.addEventListener("click", removeMeasureModal);

      const html = getMarkup();
      measureModal.innerHTML = html;
      calculate_prices();
      if (name === "Length") {
        const lineStylesCon = document.querySelector("#line-styles-con ul");
        lineStylesCon.addEventListener("click", handleLineStyle);
      } else if (name === "Count") {
        // const symbolStyleCon = document.querySelector(".symbol-container ul");
        // symbolStyleCon.addEventListener("click", handleSymbolStyle);
      }

      const idName = `create-${name.toLowerCase()}-form`;
      const measurementForm = document.getElementById(idName);
      const closeForm = document.getElementById("close-measurement-modal");

      measurementForm.addEventListener("submit", handleMeasurementForm);
      closeForm.addEventListener("click", () =>{
        measureModal.click();
      });

      function getMarkup() {
        return `<div class="modal-body" id="measurementModelJS">
                <h2>New Measurement / ${name}</h2>
                <form id="create-${name.toLowerCase()}-form">
                  <label for="part-no">Part No</label>
                  <input type="text" id="part-no" name="part-no" required />
  
                  <div class="multi-field-con">
                    <div class="desc-con">
                      <label for="part-desc">Description</label>
                      <input type="text" id="part-desc" name="part-desc" required />
                    </div>
                    <div>
                      <label for="part-unit">Unit of Measurement</label>
                      <input type="text" id="part-unit" name="part-unit" value="m" required />
                    </div>
                  </div>
                  <input type="hidden" name="stageId" value="${parentId}" />
                  <input type="hidden" name="planId" value="${plan_id}" />
                  <input type="hidden" name="projectId" value="${project_id}" />
                  <div class="multi-field-con small-inputs">
                    <div>
                      <label for="unit-cost">Unit Cost</label>
                      <input type="number" onkeyup="calculate_prices()" id="unit-cost" name="unit-cost" value="10" required />
                    </div>
                    <div class="changeAble">
                      <label for="markup-per-radio">Markup %</label>
                      <div class="radio-con">
                        <input type="radio" name="unit-price-type" id="markup-per-radio" checked onclick="disable_unit_price()"/>
                        <input
                          type="number"
                          id="markup-per"
                          name="markup-per"
                          value="10" 
                          onkeyup="calculate_prices()" 
                          required
                        />
                      </div>
                    </div>
                    <div class="changeAble">
                      <label for="unit-price-radio">Unit Price</label>
                      <div class="radio-con">
                        <input type="radio" id="unit-price-radio" name="unit-price-type" onclick="disable_markup()"/>
                        <input
                          type="number"
                          id="unit-price"
                          name="unit-price"
                          onkeyup="calculate_prices()" 
                          required
                          disabled
                        />
                      </div>
                    </div>
                  </div>
  
                  <div class="styles-header">
                    <h3>Style</h3>
                  </div>
                  ${getStyle()}
                  <div class="btn-group">
                    <button type="submit" id="create-measurement">Create</button>
                    <button
                      type="submit"
                      id="create-n-add-more-measurement"
                      class="bg-cyan"
                    >
                      Create & Add More Parts
                    </button>
                    <button id="close-measurement-modal" type="reset">Close</button>
                  </div>
                </form>
              </div>
            </div>`;
      }

      function removeMeasureModal(e) {
        if (e.target.id === "create-measurement-modal") {
          measureModal.innerHTML = "";
          measureModal.classList.remove("active");
          measureModal.removeEventListener("click", removeMeasureModal);
        }
      }

      function handleMeasurementForm(e) {
        e.preventDefault();
        const formData = new FormData(e.target);
        const unitCost = formData.get("unit-cost");
        const partNo = formData.get("part-no");
        const desc = formData.get("part-desc");
        const strokeColor = formData.get("stroke-color");
        const fillColor = formData.get("fill-color");
        const unit = formData.get("part-unit");
        // const markup = formData.get('markup-per');
        const stageId = formData.get('stageId');
        const size = formData.get('size');
        const planId = formData.get('planId');
        const projectId = formData.get('projectId');
        const unitPrice = $("#measurementModelJS input[name='unit-price']").val();
        const markup = $("#measurementModelJS input[name='markup-per']").val();

        console.log(unitPrice);

        const measurementData = {
          child: [],
          unitCost,
          partNo,
          instances: 0,
          desc,
          strokeColor,
          fillColor,
          unit,
          markup,
          unitPrice,
          stageId,
          projectId,
          planId,
          size,
          id: new Date().getTime().toString(),
        };

        const measurementData2 = {
          child: [],
          unit_cost: unitCost,
          part_no: partNo,
          instances: 0,
          description: desc,
          stroke: strokeColor,
          fill: fillColor,
          unit: unit,
          markup: markup,
          unit_price: unitPrice,
          stage_id: stageId,
          size: size,
          id: new Date().getTime().toString(),
        };

        const iconStyle = `style="
              color: ${strokeColor}; 
              stroke: ${strokeColor}; 
              fill: ${fillColor}; 
              background: ${fillColor}6f"
      `;

        if (name === "Length") {
          const type = document.getElementById("line-style");
          measurementData.type = `<i class="whenNotHover" ${iconStyle}>${type.children[1].outerHTML}</i>`;
          measurementData.measureType = "length";
          measurementData.size = formData.get("line-width");
          measurementData.lineStyle = type.value;
        } else if (name === "Area") {
          measurementData.type = `<svg width="20px" height="20px" viewBox="0 0 20 20" style="vertical-align: bottom;">
                   <path d="M 2 4 L 18 4 18 16 2 16 Z" stroke-width="2"></path>
                </svg>`;
          measurementData.measureType = "area";
        } else if (name === "Count") {
          measurementData.measureType = "count";
          const type = document.getElementById("symbol-style");
          measurementData.type = `
          <i class="whenNotHover" style="stroke: ${strokeColor}; fill: ${fillColor};" >
            ${type.innerHTML}
          </i>`;
          measurementData.size = formData.get("count-size");
        }

        let data = {
          'part_no': measurementData.partNo,
          'description': measurementData.desc,
          'unit_cost': measurementData.unitCost,
          'fill': measurementData.fillColor,
          'stroke': measurementData.strokeColor,
          'size': measurementData.size,
          'type': measurementData.measureType,
          'icon': measurementData.type,
          'unit': measurementData.unit,
          'markup': measurementData.markup,
          'unit_price': measurementData.unitPrice,
          'stage_id': measurementData.stageId,
          'plan_id': measurementData.planId,
          'project_id': measurementData.projectId
        }
        $.ajax({
          url: '/editor/stage/add-count',
          type: 'POST',
          data: {_token:CSRF_TOKEN, data:data},
          success: function(res)
          {
            console.log(res);
            if(res)
            {
              // stages.forEach((stage) => {
              //   if (stage.id == parentId) {
              //     stage.measurements.push(res);
              //   }
              // });
              fetchStages();
              updateStagesUI();
            }
          }
        });

        
        if (e.submitter.id === "create-measurement") {
          measureModal.click();
        } else if (e.submitter.id === `create-n-add-more-measurement`) {
          measurementForm.reset();
        }
      }

      function handleLineStyle(e) {
        const element = e.path.filter((el) => el.id);
        const id = element && element[0] && element[0].id;
        if (id) {
          const lineStyleBtn = document.getElementById("line-style");

          lineStyleBtn.innerHTML = element[0].innerHTML;
          lineStyleBtn.value = id;
        }
      }

      function handleSymbolStyle(e) {
        const element = e.path.filter((el) => el.id);
        const id = element && element[0] && element[0].id;
        if (id) {
          const symbolStyleBtn = document.getElementById("symbol-style");

          symbolStyleBtn.innerHTML = element[0].innerHTML;
          symbolStyleBtn.value = id;
        }
      }
    }

    function handleAddStage() {
      closeStageModalBtn = document.getElementById("close-stage-modal");
      closeStageModalBtn.addEventListener("click", closeModal);

      stageModal.classList.add("active");
    }
    function addBgImage() {
      return new Promise((resolve) => {
        fabric.Image.fromURL(
          url,
          (oImg) => {
            mapImage = oImg;
            oImg.scaleToWidth(clientWidth);
            oImg.scaleToHeight(clientHeight);
            canvas.backgroundImage = oImg;
            canvas.requestRenderAll(canvas).centerObject(canvas.backgroundImage);
            resolve();
          },
          { ...basicStyle, crossOrigin: "anonymous" }
        );
      });
    }
    function handleAddStageForm(e) {
      e.preventDefault();
      const formData = new FormData(e.target);
      let init = 1;
      const stageName = formData.get("stage-name");
      const stageDesc = formData.get("stage-desc");
      const stageQuantity = formData.get("stage-quantity");
      const stageTemplate = formData.get("apply-template");
      const planId = formData.get("plan-id");
      const projectId = formData.get("project-id");
      let takeoff = '';
      let copy_stage_id = '';
      if(stageTemplate == 1)
      {
        takeoff = formData.get("takeoff");
        if(takeoff == null || takeoff == 'null' || takeoff == 'undefined')
        {
          init = 0;
          $("#takeofftemplate_model_div p#errors").html('*Please select a takeoff template.')
        }else{
          $("#takeofftemplate_model_div p#errors").html("");
          init = 1;
        }
      }
      if(stageTemplate == 2)
      {
        copy_stage_id = formData.get("stage");
        if(copy_stage_id == null || copy_stage_id == 'null' || copy_stage_id == 'undefined')
        {
          init = 0;
          $("#stages_model_div p#errors").html('*Please select a stage.')
        }else{
          $("#stages_model_div p#errors").html("");
          init = 1;
        }
      }

      if(init == 1){
        let data = {
          'name': stageName,
          'desc': stageDesc,
          'quantity': stageQuantity,
          'template': stageTemplate,
          'takeoff': takeoff,
          'plan_id': planId,
          'project_id': projectId,
          'copy_stage_id': copy_stage_id
        }

        $.ajax({
          url: '/projects/stages/add-with-plan',
          type: 'POST',
          data: {_token: CSRF_TOKEN, data: data},
          success: function(res)
          {
            console.log(res);
              // stages.push({
              //   stageName,
              //   stageDesc,
              //   stageQuantity,
              //   stageTemplate,
              //   planId,
              //   measurements: [],
              //   id: res,
              // });
              fetchStages();
              updateStagesUI();
          }
        });

        closeModal();
      }
      
    }

    function handleCloseModal(e) {
      if (e.target.classList.contains("modal")) {
        closeModal();
      }
    }

    function closeModal() {
      addStageForm.reset();
      stageModal.classList.remove("active");
      closeStageModalBtn.removeEventListener("click", closeModal);
    }

    function handleSwitchTabs(e) {
      const activeTab = document.querySelector(".tabs .active");
      const activeTabContent = document.querySelector(
        ".tabs-content > .active"
      );

      const clickEl = e.path.filter((el) => el.id)[0];

      if (clickEl.id == "check") {
        toggleStatus();
      } else if (clickEl.id === "savePdf") {
      } else {

        activeTab.classList.remove("active");
        clickEl.classList.add("active");

        activeTabContent.classList.remove("active");
        document
          .querySelector(`.tabs-content .${clickEl.id}-content`)
          .classList.add("active");
      }
    }

    function toggleStatus() {
      const markIconEl = document.getElementById("check");
      if (checked) {
        checked = false;
        projectStatus.textContent = "Incomplete";
        markComplete.textContent = "MARK COMPLETE";
      } else {
        checked = true;
        projectStatus.textContent = "Complete";
        markComplete.textContent = "MARK INCOMPLETE";
      }
      markIconEl.classList.toggle("checked");
    }

    function handleSetScale(e) {
      e.preventDefault();

      const ratio = document.querySelectorAll("#setScale > select");

      setScale.classList.remove("active");
      resetScale.classList.add("active");

      resetScale.children[0].textContent = `${ratio[0].value} @ ${ratio[1].value}`;
    }

    function handleResetScale(e) {
      e.preventDefault();
      setScale.reset();

      setScale.classList.add("active");
      resetScale.classList.remove("active");
    }

    function handleToggleGrid(e) {
      const input = document.querySelectorAll(".grid input");
      const isActive = e.target.classList.contains("active");

      const [left, right] = input;
      left.addEventListener("input", handleInputChange);
      left.addEventListener("input", handleInputChange);

      if (isActive) {
        left.disabled = "disabled";
        right.disabled = "disabled";
      } else {
        left.removeAttribute("disabled");
        right.removeAttribute("disabled");
      }

      e.target.classList.toggle("active");

      function handleInputChange(e) {
        const { value } = e.target;
        input[0].value = value;
        input[1].value = value;
      }
    }
  }
  rightPan();

  function addBgImage() {
    return new Promise((resolve) => {
      fabric.Image.fromURL(
        url,
        (oImg) => {
          mapImage = oImg;
          oImg.scaleToWidth(clientWidth);
          oImg.scaleToHeight(clientHeight);
          canvas.backgroundImage = oImg;
          canvas.requestRenderAll(canvas).centerObject(canvas.backgroundImage);
          resolve();
        },
        basicStyle
      );
    });
  }

  function updateStageInstances(stageId, measureId, id) {
    for (const stage of stages) {
      if (stage.id === stageId) {
        for (const measure of stage.measurements) {
          if (measure.id === measureId) {
            measure.instances++;
            measure.child.push(id);
          }
        }
      }
    }

    updateStagesUI();
  }

  function updateStagesUI(firstTime = false) {
    const stageContent = document.querySelector(".stage-content");
    const stagesList = stages
      .map(
        ({ id, stageName }) =>
          `<li id="toggle-${id}"><i class="fas fa-eye-slash"></i> ${stageName}</li>`
      )
      .join("");

    
    let html = `
        <div class="btn-group flex-start">
          <button id="addStage">
            <i class="fa fa-plus"></i> Add Stage
          </button>
          <button id="hide-n-show-btn">Show & Hide</button>
          <div class="stage-action">
            <h4>Stages</h4>
            <ul>
              ${stagesList}
              <li id="toggle-all"><i class="fas fa-eye-slash"></i> Toggle all</li>
            </ul>
          </div>
        </div>`;

    if (stages.length === 0) {
      html = `
      <div class="stage-measurements">
        <header>
          <h3>Stage Names</h3>
          <h4>Actions</h4>
        </header>
        <ul>
          <li id="addCount"><i class="fa fa-plus"></i> Count</li>
          <li id="addLength"><i class="fa fa-plus"></i> Length</li>
          <li id="addArea"><i class="fa fa-plus"></i> Area</li>
        </ul>
        <div class="up-arrow-con">
          <i class="fas fa-arrow-circle-up"></i>
        </div>
        <div>
          <p>To start measuring add a count, length or area.</p>
          <p>
            or,
            <span class="link">
              <i class="fas fa-arrow-circle-up"></i>
              Apply a Take-off template
            </span>
          </p>
        </div>
      </div>
      <div class="add-stage-container">
        <div class="bg-blur"></div>
        <button id="addStage">
          <i class="fa fa-plus"></i>
          Add Stage
        </button>
        <p>
          or
          <span class="link">
            <i class="fa fa-link"></i>
            Link from the Worksheet</span
          >
        </p>
      </div>`;
      stageContent.classList.add("no-stage");
    } else {
      stageContent.classList.remove("no-stage");

      stages.forEach((stage) => {
        let stageCon = `
            <div class="stage-measurements" id="${stage.id}">
              <header>
                <h3>${stage.stageName}</h3>
                <button>Actions <i class="fas fa-caret-square-down"></i></button>
                <div class="stage-action">
                   <h4>Stage Actions</h4>
                   <ul>
                      <li id="toggle-measurements"><i class="fas fa-eye-slash"></i> Toggle Measurements</li>
                      <li id="toggle-${stage.id}"><i class="fas fa-eye-slash"></i> Toggle Stage</li>
                      <li id="delete-${stage.id}"><i class="fas fa-trash"></i> Delete From Project</li>
                    </ul>
                </div>
              </header>
              <div class="empty-measurements">
                <ul>
                  <li id="addCount" data-stageid="${stage.id}"><i class="fa fa-plus"></i> Count</li>
                  <li id="addLength"><i class="fa fa-plus"></i> Length</li>
                  <li id="addArea"><i class="fa fa-plus"></i> Area</li>
                </ul>`;
        if (stage.measurements.length == 0) {
          stageCon += `
            <div class="up-arrow-con">
              <i class="fas fa-arrow-circle-up"></i>
            </div>
            <div>
              <p>To start measuring add a count, length or area.</p>
              <p>or, <span class="link"><i class="fas fa-arrow-circle-up"></i>Apply a Take-off template</span></p>
            </div>
          </div>`;
        } else {
          stageCon += `
              <table>
                <tbody>
                  <tr>
                    <th>Measurement</th>
                    <th>TOTAL (PLAN)/TOTAL (PROJECT)</th>
                  </tr>`;

            
          stage.measurements.forEach(
            // ({ desc, type, id, measureType, child, isHidden }) => {
            (elem) => {
              let className;
              let isHidden = false;
              if (
                ["count", "length", "area"].indexOf(activeMode) !== -1 &&
                countValue.id === elem.id
              )
                className = "selected";

              if (isHidden) className += " hide-measurement";
              stageCon += `<tr id="measurement-${elem.id}" 
                          class="${className}">
                          <td>
                            <i class="fas fa-eye-slash onlyWhenHover" id="toggle-measurement-${elem.id}"></i>
                            ${elem.symbol} <span id="select-${elem.type}-${elem.id}" class="underline-hover">${elem.description}</span>
                          </td>
                          <td class="measurement-value-cell">
                            <button ${isHidden && "disabled='disabled'"}>
                            1/1
                               <i class="fas fa-caret-square-down"></i>
                            </button>
                            <div class="stage-action">
                                <h4>Measurement Actions</h4>
                                <ul>
                                  <li id="hide-measurement-${elem.id}"><i class="fas fa-eye-slash"></i> Hide</li>
                                  <li id="delete-measurement-${elem.id}"><i class="fas fa-trash"></i> Delete</li>
                                </ul>
                            </div>
                          </td>
                       </tr>`;
              // child.forEach((c, i) => {
              //   const cN = `${className} measurement-child ${
              //     isHidden && "hidden"
              //   }`;
              //   stageCon += `
              //       <tr 
              //         id="measurement-child-${c}" 
              //         class="${cN}"
              //       >
              //         <td colspan="2">${elem.type} ${i + 1}</td>
              //       </tr>`;
              // });
            }
          );

          stageCon += `
            </tbody>
          </table>
          </div>`;
        }

        stageCon += `</div>`;
        html += stageCon;
      });
    }
    stageContent.innerHTML = html;
    if (!firstTime) updateState();
  }

  function resetPreferences() {
    const activeEl = document.querySelector("span.active");
    if (activeEl) {
      activeEl.classList.remove("active");
    }
    canvas.isDrawingMode = false;
    canvas.selection = true;
  }

  function updateCanvas() {
    canvas.requestRenderAll();
  }

  function updateState() {
    // If making a change after redoing then delete all other changes
    if (state.index < state.canvas.length - 1) {
      state.canvas.splice(state.index + 1);
      state.stages.splice(state.index + 1);
    }

    updateCanvas();
    state.canvas.push(JSON.stringify(canvas.toJSON(["id", "groupId"])));
    state.stages.push(JSON.stringify(stages));

    // If versioning excced more then 15 then keep deleting 1st item
    if (state.index >= 15) {
      state.canvas.splice(0, 1);
      state.stages.splice(0, 1);
    } else {
      state.index++;
    }

    renderStatusBar();
    localStorage.setItem("state", JSON.stringify(state));
  }

  function statusBar() {
    const status = document.querySelector(".status-bar");
    status.addEventListener("click", clickHanlder);

    function clickHanlder(e) {
      e.preventDefault();
      const element = e.path.filter((el) => el.id);
      const id = element && element[0] && element[0].id;

      switch (id) {
        case "undo":
          switchVersion("undo");
          break;
        case "redo":
          switchVersion("redo");
          break;
        case "delete":
          deleteObj();
          break;
        case "okBtn":
          okBtn();
          break;
        case "cancel":
          cancel();
          break;
      }
    }

    function switchVersion(type) {
      if (type === "undo" && state.index > 0) state.index--;
      else if (type === "redo" && state.index < state.canvas.length - 1)
        state.index++;

      canvas = canvas.loadFromJSON(state.canvas[state.index]);
      stages = JSON.parse(state.stages[state.index]);
      updateCanvas();
      updateStagesUI(true);
      renderStatusBar();

      localStorage.setItem("state", JSON.stringify(state));
    }

    function deleteObj() {
      const obj = canvas.getActiveObject();
      canvas.remove(obj);

      for (const stage of stages) {
        for (const measure of stage.measurements) {
          const index = measure.child.indexOf(obj.id);
          if (index !== -1) {
            measure.child.splice(index, 1);
            updateStagesUI();
            return;
          }
        }
      }

      updateState();
    }

    function okBtn() {
      updateState();
    }

    function cancel() {
      updateMode("");
      canvas.loadFromJSON(state.canvas[state.index]);
    }
  }

  function renderStatusBar() {
    const statusBar = document.querySelector(".status-bar");

    const renderBtn = {
      redo: () => {
        if (state.index < state.canvas.length - 1)
          return `<li  id="redo">
                    <button><i class="fas fa-redo"></i> <span>Redo</span></button>
                </li>`;
        else return "";
      },
      undo: () => {
        if (state.index > 0)
          return `<li id="undo">
                <button><i class="fas fa-undo"></i> <span>Undo</span></button>
              </li>`;
        else return "";
      },
      ok: () => {
        if (
          state.canvas[state.index] !==
          JSON.stringify(canvas.toJSON(["id", "groupId"]))
        )
          return `<li id="okBtn"><button>Save</button></li>`;
        else return "";
      },
      cancel: () => {
        if (
          activeMode ||
          state.canvas[state.index] !==
            JSON.stringify(canvas.toJSON(["id", "groupId"]))
        )
          return `<li id="cancel"><button>Cancel</button></li>`;
        else return "";
      },
      del: () => {
        const obj = canvas.getActiveObject();
        if (obj)
          return `<li id="delete"><button><i class="fas fa-trash"></i>  Delete</button></li>`;
        else return "";
      },

      badge: () => {
        if (activeMode)
          return `<li><span class="badge"> ${activeMode} </span></li>`;
        else return "";
      },
    };

    const html = `
        <ul>
        ${renderBtn.undo()}
        ${renderBtn.redo()}
        ${renderBtn.badge()}
         
        </ul>
        <ul>
          ${renderBtn.del()}
          ${renderBtn.cancel()}
          ${renderBtn.ok()}
        </ul>`;

    statusBar.innerHTML = html;
  }
  function saveImage (){
    canvas.setZoom(1);
    const center = canvas.getCenter();
    vpw = canvas.width;
    vph = canvas.height;

    x = center.left - vpw / 2;
    y = center.top - vph / 2;
    canvas.absolutePan({x,y});

    // var link = document.createElement("a");
    // link.download = "plan.jpg";

    // link.href = canvas.toDataURL("image/jpg");
    let base64 = canvas.toDataURL("image/jpg");
    // link.click();

  }


  renderStatusBar();
  statusBar();

}

App(
  plan_image_c
);

function calculate_unit_price_count()
{
  let unit_price = parseInt($("#measurementModelJS #unit-cost").val());
    let id = $('#measurementModelJS input[name="priceMode"]:checked').attr('id');
    if(id == 'priceMode1')
    {
      let markup = $("#measurementModelJS input#markup").val();
      markup = parseInt(markup);
      markup = markup/100;
      let a = unit_price*markup;
      let sum = a+unit_price;
      sum = sum.toFixed(2);
      $("#measurementModelJS input#unitPrice").val(sum);
    }else{
     let input = parseInt($("#measurementModelJS input#unit-price-type").val());
     let a = (input - unit_price)/unit_price*100;
     let b = a*100;
     let c = b/100;
     c = c.toFixed(2);
     $("#measurementModelJS input#markup").val(c);
    }
}
$("#measurementModelJS #unit-price-radio").click(function(){
  $("#measurementModelJS #unit-price").removeAttr("disabled");
  $("#measurementModelJS #markup-per").attr("disabled","disabled");
  calculate_unit_price_count();
});
$("#measurementModelJS #priceMode1").click(function(){
  $("#measurementModelJS #markup").removeAttr("disabled");
  $("#measurementModelJS #unitPrice").attr("disabled","disabled");
  calculate_unit_price_count();
});
$("#measurementModelJS #unit-cost").on('keyup', function(){
  calculate_unit_price_count();
});
$("#measurementModelJS #markup").on('keyup', function(){
  calculate_unit_price_count();
});
$("#measurementModelJS #unitPrice").on('keyup', function(){
  calculate_unit_price_count();
});

function disable_unit_price()
{
  $("#measurementModelJS #unit-price").attr('disabled', 'disabled');
  $("#measurementModelJS #unit-price").css('background', '#eee!important');
  $("#measurementModelJS #markup-per").removeAttr('disabled');
}
function disable_markup()
{
  $("#measurementModelJS #markup-per").attr('disabled', 'disabled');
  $("#measurementModelJS #markup-per").css('background', '#eeeeee!important');
  $("#measurementModelJS #unit-price").removeAttr('disabled');
}
function calculate_prices()
{
  let unit_cost = parseInt($("#unit-cost").val());
  let markup = parseInt($("#markup-per").val());
  let unit_price = parseInt($("#unit-price").val());

  let markup_radio = $("#markup-per-radio"); 
  let unit_price_radio = $("#unit-price-radio"); 
  if(markup_radio.is(":checked"))
  {
    markup = markup/100;
    let a = unit_cost*markup;
    let sum = a+unit_cost;
    sum = sum.toFixed(2);
    $("#unit-price").val(sum);
  }
  if(unit_price_radio.is(":checked"))
  {
    let a = (unit_price - unit_cost)/unit_cost*100;
    let b = a*100;
    let c = b/100;
    c = c.toFixed(2);
    $("#markup-per").val(c);
  }
}
// Symbols Script
function load_symbols()
{
  let pack = $("#packSelect").val();
  console.log(pack);
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
function change_pack()
{
  load_symbols();
}
// Search
function searchIcon(){
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
}
function pusher()
{
  $(".scCustom #flex span").click(function(){
    let svg = $(this).html();
    $("#symbol-style").html(svg);
  });
}
function toggleSymbolBox()
{
  $(".scCustom").toggle();
  load_symbols();
}