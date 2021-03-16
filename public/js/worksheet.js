var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
   
function openCountModal(stage_id, project_id){
  $("#create-stage-modal input#stage_id").val(stage_id);
  $("#create-stage-modal input#project_id").val(project_id);
  $("#create-stage-modal").modal('show');
}
function openLengthModal(stage_id, project_id){
  $("#create-length-modal input#stage_id").val(stage_id);
  $("#create-length-modal input#project_id").val(project_id);
  $("#create-length-modal").modal('show');
}
function openAreaModal(stage_id, project_id){
  $("#create-area-modal input#stage_id").val(stage_id);
  $("#create-area-modal input#project_id").val(project_id);
  $("#create-area-modal").modal('show');
}
function openAdditionalModal(stage_id, project_id){
  $("#create-additional-modal input#stage_id").val(stage_id);
  $("#create-additional-modal input#project_id").val(project_id);
  $("#create-additional-modal").modal('show');
}
function openLabourModal(stage_id, project_id)
{
  $("#create-labour-modal input#stage_id").val(stage_id);
  $("#create-labour-modal input#project_id").val(project_id);
  $("#create-labour-modal").modal('show');
}
function openAdjustCountModal(id, total){
  $("#adjustCountModal input#id").val(id);
  $("#adjustCountModal input#total").val(total);
  $("#adjustCountModal p#total").html(total+' EA');
  $("#adjustCountModal").modal('show');
}
function openMeasurementRenameModal(id, name)
{
  $("#renameMeasurementModel input#id").val(id);
  $("#renameMeasurementModel input#name").val(name);
  $("#renameMeasurementModel").modal('show');
}
function openDeleteMeasurementModel(id, name)
{
  $("#deleteMeasurementModel span#name").html(name);
  $("#deleteMeasurementModel input#id").val(id);
  $("#deleteMeasurementModel").modal('show');
}
function openAdditionalsEditModal(id, description, part_no, unit, unit_cost, markup, unit_price, total)
{

  if(part_no == 'undefined')
  {
    $("#editAdditionalsModel div#part_no").hide();
    $("#additionalsUnits input").hide();
    $("#additionalsUnits select").show();
  }else{
    $("#editAdditionalsModel div#part_no").show();
    $("#editAdditionalsModel input#part_no").val(part_no);
    $("#additionalsUnits input").show();
    $("#additionalsUnits select").hide();
  }
  $("#editAdditionalsModel input#id").val(id);
  $("#editAdditionalsModel input#description").val(description);
  $("#editAdditionalsModel input#unit").val(unit);
  $("#editAdditionalsModel input#unit_cost").val(unit_cost);
  $("#editAdditionalsModel input#markup").val(markup);
  $("#editAdditionalsModel input#unitPrice").val(unit_price);
  $("#editAdditionalsModel input#total").val(total);
  $("#editAdditionalsModel").modal('show');
}
function openAdditionalDeleteModal(id, name)
{
  $("#deleteAdditionalsModel span#name").html(name);
  $("#deleteAdditionalsModel input#id").val(id);
  $("#deleteAdditionalsModel").modal('show');
}
function openEditStageModal(id, name, description, multiply)
{
  $("#editStageModal #id").val(id);
  $("#editStageModal #name").val(name);
  $("#editStageModal #description").val(description);
  $("#editStageModal #multiply").val(multiply);
  $("#editStageModal").modal('show');
}
function openApplyTemplateModal(id, name)
{
  $("#applyTemplateModal #id").val(id);
  $("#applyTemplateModal #name").html(name);
  $("#applyTemplateModal").modal('show');
}
function openCopyTemplateModal(id, name)
{
  $("#duplicateTemplateModal #id").val(id);
  $("#duplicateTemplateModal #name").html(name);
  $("#duplicateTemplateModal #template_name").val(name+" Template");
  $("#duplicateTemplateModal").modal('show');
}
function openDeleteStageModal(id, name)
{
  $("#deleteStageModal #id").val(id);
  $("#deleteStageModal #name").html('"'+name+'"');
  $("#deleteStageModal").modal('show');
}
function calculate_unit_price()
{
  let unit_price = parseInt($("#create-length-modal #unit_cost").val());
    let id = $('#create-length-modal input[name="priceMode"]:checked').attr('id');
    if(id == 'priceMode1')
    {
      let markup = $("#create-length-modal input#markup").val();
      markup = parseInt(markup);
      markup = markup/100;
      let a = unit_price*markup;
      let sum = a+unit_price;
      sum = sum.toFixed(2);
      $("#create-length-modal input#unitPrice").val(sum);
    }else{
     let input = parseInt($("#create-length-modal input#unitPrice").val());
     let a = (input - unit_price)/unit_price*100;
     let b = a*100;
     let c = b/100;
     c = c.toFixed(2);
     $("#create-length-modal input#markup").val(c);
    }
}
function calculate_unit_price_count()
{
  let unit_price = parseInt($("#create-stage-modal #unit_cost").val());
    let id = $('#create-stage-modal input[name="priceMode"]:checked').attr('id');
    if(id == 'priceMode1')
    {
      let markup = $("#create-stage-modal input#markup").val();
      markup = parseInt(markup);
      markup = markup/100;
      let a = unit_price*markup;
      let sum = a+unit_price;
      sum = sum.toFixed(2);
      $("#create-stage-modal input#unitPrice").val(sum);
    }else{
     let input = parseInt($("#create-stage-modal input#unitPrice").val());
     let a = (input - unit_price)/unit_price*100;
     let b = a*100;
     let c = b/100;
     c = c.toFixed(2);
     $("#create-stage-modal input#markup").val(c);
    }
}
function calculate_unit_price_area()
{
  let unit_price = parseInt($("#create-area-modal #unit_cost").val());
    let id = $('#create-area-modal input[name="priceMode"]:checked').attr('id');
    if(id == 'priceMode1')
    {
      let markup = $("#create-area-modal input#markup").val();
      markup = parseInt(markup);
      markup = markup/100;
      let a = unit_price*markup;
      let sum = a+unit_price;
      sum = sum.toFixed(2);
      $("#create-area-modal input#unitPrice").val(sum);
    }else{
     let input = parseInt($("#create-area-modal input#unitPrice").val());
     let a = (input - unit_price)/unit_price*100;
     let b = a*100;
     let c = b/100;
     c = c.toFixed(2);
     $("#create-area-modal input#markup").val(c);
    }
}
function calculate_unit_price_additional()
{
  let unit_price = parseInt($("#create-additional-modal #unit_cost").val());
    let id = $('#create-additional-modal input[name="priceMode"]:checked').attr('id');
    if(id == 'priceMode1')
    {
      let markup = $("#create-additional-modal input#markup").val();
      markup = parseInt(markup);
      markup = markup/100;
      let a = unit_price*markup;
      let sum = a+unit_price;
      sum = sum.toFixed(2);
      $("#create-additional-modal input#unitPrice").val(sum);
    }else{
     let input = parseInt($("#create-additional-modal input#unitPrice").val());
     let a = (input - unit_price)/unit_price*100;
     let b = a*100;
     let c = b/100;
     c = c.toFixed(2);
     $("#create-additional-modal input#markup").val(c);
    }
}
function calculate_unit_price_additional_edit()
{
  let unit_price = parseInt($("#editAdditionalsModel #unit_cost").val());
    let id = $('#editAdditionalsModel input[name="priceMode"]:checked').attr('id');
    if(id == 'priceMode1')
    {
      let markup = $("#editAdditionalsModel input#markup").val();
      markup = parseInt(markup);
      markup = markup/100;
      let a = unit_price*markup;
      let sum = a+unit_price;
      sum = sum.toFixed(2);
      $("#editAdditionalsModel input#unitPrice").val(sum);
    }else{
     let input = parseInt($("#editAdditionalsModel input#unitPrice").val());
     let a = (input - unit_price)/unit_price*100;
     let b = a*100;
     let c = b/100;
     c = c.toFixed(2);
     $("#editAdditionalsModel input#markup").val(c);
    }
}
function calculate_unit_price_labour()
{
  let unit_price = parseInt($("#create-labour-modal #unit_cost").val());
    let id = $('#create-labour-modal input[name="priceMode"]:checked').attr('id');
    if(id == 'priceMode1')
    {
      let markup = $("#create-labour-modal input#markup").val();
      markup = parseInt(markup);
      markup = markup/100;
      let a = unit_price*markup;
      let sum = a+unit_price;
      sum = sum.toFixed(2);
      $("#create-labour-modal input#unitPrice").val(sum);
    }else{
     let input = parseInt($("#create-labour-modal input#unitPrice").val());
     let a = (input - unit_price)/unit_price*100;
     let b = a*100;
     let c = b/100;
     c = c.toFixed(2);
     $("#create-labour-modal input#markup").val(c);
    }
}

$(document).ready(function(){
  // Count Modal
  $("#create-stage-modal #priceMode2").click(function(){
    $("#create-stage-modal #unitPrice").removeAttr("disabled");
    $("#create-stage-modal #markup").attr("disabled","disabled");
    calculate_unit_price_count();
  });
  $("#create-stage-modal #priceMode1").click(function(){
    $("#create-stage-modal #markup").removeAttr("disabled");
    $("#create-stage-modal #unitPrice").attr("disabled","disabled");
    calculate_unit_price_count();
  });
  $("#create-stage-modal #unit_cost").on('keyup', function(){
    calculate_unit_price_count();
  });
  $("#create-stage-modal #markup").on('keyup', function(){
    calculate_unit_price_count();
  });
  $("#create-stage-modal #unitPrice").on('keyup', function(){
    calculate_unit_price_count();
  });
  $("#create-stage-modal .symbol-style-con .symbol-container ul li").click(function(){
    let html = $(this).html();
    $("#create-stage-modal button#symbol-style").html(html);
  });
  $(".count-symbol-button").click(function(){
    $(".count_symbols_container").toggle();
  });
  // Length Modal
  $("#create-length-modal #priceMode2").click(function(){
    $("#create-length-modal #unitPrice").removeAttr("disabled");
    $("#create-length-modal #markup").attr("disabled","disabled");
    calculate_unit_price();
  });
  $("#create-length-modal #priceMode1").click(function(){
    $("#create-length-modal #markup").removeAttr("disabled");
    $("#create-length-modal #unitPrice").attr("disabled","disabled");
    calculate_unit_price();
  });
  $("#create-length-modal #unit_cost").on('keyup', function(){
    calculate_unit_price();
  });
  $("#create-length-modal #markup").on('keyup', function(){
    calculate_unit_price();
  });
  $("#create-length-modal #unitPrice").on('keyup', function(){
    calculate_unit_price();
  });
  $("#create-length-modal .symbol-style-con .symbol-container ul li").click(function(){
    let html = $(this).html();
    $("#create-length-modal button#symbol-style").html(html);
  });
  // Area Modal
  $("#create-area-modal #priceMode2").click(function(){
    $("#create-area-modal #unitPrice").removeAttr("disabled");
    $("#create-area-modal #markup").attr("disabled","disabled");
    calculate_unit_price_area();
  });
  $("#create-area-modal #priceMode1").click(function(){
    $("#create-area-modal #markup").removeAttr("disabled");
    $("#create-area-modal #unitPrice").attr("disabled","disabled");
    calculate_unit_price_area();
  });
  $("#create-area-modal #unit_cost").on('keyup', function(){
    calculate_unit_price_area();
  });
  $("#create-area-modal #markup").on('keyup', function(){
    calculate_unit_price_area();
  });
  $("#create-area-modal #unitPrice").on('keyup', function(){
    calculate_unit_price_area();
  });
  // Additional Modal
  $("#create-additional-modal #priceMode2").click(function(){
    $("#create-additional-modal #unitPrice").removeAttr("disabled");
    $("#create-additional-modal #markup").attr("disabled","disabled");
    calculate_unit_price_additional();
  });
  $("#create-additional-modal #priceMode1").click(function(){
    $("#create-additional-modal #markup").removeAttr("disabled");
    $("#create-additional-modal #unitPrice").attr("disabled","disabled");
    calculate_unit_price_additional();
  });
  $("#create-additional-modal #unit_cost").on('keyup', function(){
    calculate_unit_price_additional();
  });
  $("#create-additional-modal #markup").on('keyup', function(){
    calculate_unit_price_additional();
  });
  $("#create-additional-modal #unitPrice").on('keyup', function(){
    calculate_unit_price_additional();
  });
  // Additional Edit Modal
  $("#editAdditionalsModel #priceMode2").click(function(){
    $("#editAdditionalsModel #unitPrice").removeAttr("disabled");
    $("#editAdditionalsModel #markup").attr("disabled","disabled");
    calculate_unit_price_additional_edit();
  });
  $("#editAdditionalsModel #priceMode1").click(function(){
    $("#editAdditionalsModel #markup").removeAttr("disabled");
    $("#editAdditionalsModel #unitPrice").attr("disabled","disabled");
    calculate_unit_price_additional_edit();
  });
  $("#editAdditionalsModel #unit_cost").on('keyup', function(){
    calculate_unit_price_additional_edit();
  });
  $("#editAdditionalsModel #markup").on('keyup', function(){
    calculate_unit_price_additional_edit();
  });
  $("#editAdditionalsModel #unitPrice").on('keyup', function(){
    calculate_unit_price_additional_edit();
  });
  // Labour Modal
  $("#create-labour-modal #priceMode2").click(function(){
    $("#create-labour-modal #unitPrice").removeAttr("disabled");
    $("#create-labour-modal #markup").attr("disabled","disabled");
    calculate_unit_price_labour();
  });
  $("#create-labour-modal #priceMode1").click(function(){
    $("#create-labour-modal #markup").removeAttr("disabled");
    $("#create-labour-modal #unitPrice").attr("disabled","disabled");
    calculate_unit_price_labour();
  });
  $("#create-labour-modal #unit_cost").on('keyup', function(){
    calculate_unit_price_labour();
  });
  $("#create-labour-modal #markup").on('keyup', function(){
    calculate_unit_price_labour();
  });
  $("#create-labour-modal #unitPrice").on('keyup', function(){
    calculate_unit_price_labour();
  });

  $("#count_form").on('submit', function(e){
    e.preventDefault();
    var data = $('#count_form').serializeArray().reduce(function(obj, item) {
        obj[item.name] = item.value;
        return obj;
    }, {});
    let icon = $("button#symbol-style").html();
    let markup = $("#markup").val();
    let unit_price = $("#unitPrice").val();
    let csrf = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
      type: 'POST',
      url: '/project/worksheet/count/add',
      data: {_token: csrf,data:data, icon:icon, markup: markup, unit_price: unit_price},
      success: function(res)
      {
        if(res == 1)
        {
           location.reload();
        }else{
          $("#count_form_error").show();
        }
      }
    });
  });
  $("#length_form").on('submit', function(e){
    e.preventDefault();
    var data = $('#length_form').serializeArray().reduce(function(obj, item) {
        obj[item.name] = item.value;
        return obj;
    }, {});
    let icon = $("#create-length-modal button#symbol-style").html();
    let markup = $("#create-length-modal #markup").val();
    let unit_price = $("#create-length-modal #unitPrice").val();
    let csrf = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
      type: 'POST',
      url: '/project/worksheet/count/add',
      data: {_token: csrf,data:data, icon:icon, markup: markup, unit_price: unit_price},
      success: function(res)
      {
        console.log(res);
        if(res == 1)
        {
           location.reload();
        }else{
          $(".measurementsForm #count_form_error").show();
        }
      }
    });
  });
  $("#area_form").on('submit', function(e){
    e.preventDefault();
    var data = $('#area_form').serializeArray().reduce(function(obj, item) {
        obj[item.name] = item.value;
        return obj;
    }, {});
    let icon = $("#create-area-modal button#symbol-style").html();
    let markup = $("#create-area-modal #markup").val();
    let unit_price = $("#create-area-modal #unitPrice").val();
    let csrf = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
      type: 'POST',
      url: '/project/worksheet/count/add',
      data: {_token: csrf,data:data, icon:icon, markup: markup, unit_price: unit_price},
      success: function(res)
      {
        if(res == 1)
        {
           location.reload();
        }else{
          $(".measurementsForm #count_form_error").show();
        }
      }
    });
  });
  $("#additional_form").on('submit', function(e){
    e.preventDefault();
    var data = $('#additional_form').serializeArray().reduce(function(obj, item) {
        obj[item.name] = item.value;
        return obj;
    }, {});
    let markup = $("#create-additional-modal #markup").val();
    let unit_price = $("#create-additional-modal #unitPrice").val();
    let csrf = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
      type: 'POST',
      url: '/project/worksheet/additonal/add',
      data: {_token: csrf,data:data, markup: markup, unit_price: unit_price},
      success: function(res)
      {
        if(res == 1)
        {
           location.reload();
        }else{
          $(".measurementsForm #count_form_error").show();
        }
      }
    });
  });
  $("#additional_edit_form").on('submit', function(e){
    e.preventDefault();
    var data = $('#additional_edit_form').serializeArray().reduce(function(obj, item) {
        obj[item.name] = item.value;
        return obj;
    }, {});
    let markup = $("#editAdditionalsModel #markup").val();
    let unit_price = $("#editAdditionalsModel #unitPrice").val();
    let csrf = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
      type: 'POST',
      url: '/project/worksheet/additonal/update',
      data: {_token: csrf,data:data, markup: markup, unit_price: unit_price},
      success: function(res)
      {
        if(res == 1)
        {
           location.reload();
        }else{
          $(".measurementsForm #count_form_error").show();
        }
      }
    });
  });
  $("#labour_form").on('submit', function(e){
    e.preventDefault();
    var data = $('#labour_form').serializeArray().reduce(function(obj, item) {
        obj[item.name] = item.value;
        return obj;
    }, {});
    let markup = $("#create-labour-modal #markup").val();
    let unit_price = $("#create-labour-modal #unitPrice").val();
    let csrf = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
      type: 'POST',
      url: '/project/worksheet/additonal/add',
      data: {_token: csrf,data:data, markup: markup, unit_price: unit_price},
      success: function(res)
      {
        console.log(res);
        if(res == 1)
        {
           location.reload();
        }else{
          $(".measurementsForm #count_form_error").show();
        }
      }
    });
  });

  $("#fill-color").on('change', function(){
    let color = jQuery(this).val();
    $(".count_symbols_container ul li svg path").attr('fill',color);
    $(".count-symbol-button svg path").attr('fill',color);
  });
  $("#stroke-color").on('change', function(){
    let color = jQuery(this).val();
    $(".count_symbols_container ul li svg path").attr('stroke',color);
    $(".count-symbol-button svg path").attr('stroke',color);
  });
  $("#line-stroke-color").on('change', function(){
    let color = jQuery(this).val();
    $(".line_symbols_container ul li svg line").css('stroke',color);
    $(".line-button svg.svg-inline--fa").css('color',color);
    $(".line-button svg line").css('stroke',color);
  });
  $("#area-fill-color").on('change', function(){
    let color = jQuery(this).val();
    $(".area-button svg path").attr('fill',color);
  });
  $("#area-stroke-color").on('change', function(){
    let color = jQuery(this).val();
    $(".area-button svg path").attr('stroke',color);
  });
  $(".line-button").click(function(){
    $(".line_symbols_container").toggle();
  });
  $(".worksheetPage .symbol-container ul li").click(function(){
    $(".worksheetPage .symbol-container").css('display','none');
  });
  $("#applyTemplateModal input[name='template']").click(function(){
    if($("#applyTemplateModal input[name='template']").is(':checked')) {
      let flag = this.value;
      if(flag == 'takeoff')
      {
        $("#TemplatesDiv").show();
        $("#StagesDiv").hide();
      }else if(flag == 'stage')
      {
        $("#StagesDiv").show();
        $("#TemplatesDiv").hide();
      }
    }
  });
  $("#applyTemplateModal #submit").click(function(){
    
    $("#applyTemplateModal #error").hide();
    let id = $("#applyTemplateModal #id").val();
    let takeoff_id = null;
    let stage_id = null;
    var flag = 1;
    if($("#applyTemplateModal input[name='template']").is(':checked')) {
      let template = $("#applyTemplateModal input[name='template']:checked").val();
      if(template == 'takeoff')
      {
        if($("#applyTemplateModal #TemplatesDiv input[name='takeoff_id']").is(':checked')) {
          takeoff_id = $("#applyTemplateModal #TemplatesDiv input[name='takeoff_id']:checked").val();
        }else{
          flag = 0;
          $("#applyTemplateModal #error").html("*Please select a Take-Off template");
        }
      }else {
        if($("#applyTemplateModal #StagesDiv input[name='stage_id']").is(':checked')) {
          stage_id = $("#applyTemplateModal #StagesDiv input[name='stage_id']:checked").val();
        }else{
          flag = 0;
          $("#applyTemplateModal #error").html("*Please select a stage");
        }
      }
    }else{
      flag = 0;
      $("#applyTemplateModal #error").html("*Please select a template or stage");
    }

    if(flag == 1)
    {
      $.ajax({
        url: '/worksheet/stage/update/measurements',
        type: 'POST',
        data: {_token: CSRF_TOKEN, stage_id:id, takeoff_id:takeoff_id, copy_stage:stage_id},
        success: function(res)
        {
          console.log(res);
          if(res == 1)
          {
            location.reload();
          }
          if(res == 0)
          {
            $("p#error").html("*No measurements found!");
            $("#applyTemplateModal #error").show();
          }
        }
      });
    }
  });

});