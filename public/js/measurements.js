function openRenameMeasurementModel(id, name)
{
  $("#renamepartnameModel #id").val(id);
  $("#renamepartnameModel #name").val(name);
  $("#renamepartnameModel").modal('show');
}
function openCountModal(template_id){
  $("#create-stage-modal input#template_id").val(template_id);
  $("#create-stage-modal").modal('show');
}
function openAdjustCountModal(id, total){
  $("#adjustCountModal input#id").val(id);
  $("#adjustCountModal input#total").val(total);
  $("#adjustCountModal p#total").html(total+' EA');
  $("#adjustCountModal").modal('show');
}
function openchangeStyleModal(id, size, fill, stroke){
  $("#openchangeStyleModal input#id").val(id);
  $("#openchangeStyleModal input#size").val(size);
  $("#openchangeStyleModal input#fill").val(fill);
  $("#openchangeStyleModal input#stroke").val(stroke);
  $("#openchangeStyleModal").modal('show');
}
function openchangeStyleModalLen(id, size, stroke){
  $("#openchangeStyleModalLen input#id").val(id);
  $("#openchangeStyleModalLen input#size").val(size);
  $("#openchangeStyleModalLen input#fill").val(fill);
  $("#openchangeStyleModalLen input#stroke").val(stroke);
  $("#openchangeStyleModalLen").modal('show');
}
function openAreaEditModal(id, size, fill, stroke)
{
  $("#openAreaEditModal input#id").val(id);
  $("#openAreaEditModal input#size").val(size);
  $("#openAreaEditModal input#fill").val(fill);
  $("#openAreaEditModal input#stroke").val(stroke);
  $("#openAreaEditModal").modal('show');
}
function openPartEditModal(type, id, measurement_id, part_no, part_name, unit, unit_cost, markup, unit_price, formula, total){
  $("#edit-part-modal input#id").val(id);
  $("#edit-part-modal input#part_no").val(part_no);
  $("#edit-part-modal input#part_name").val(part_name);
  $("#edit-part-modal input#unit").val(unit);
  $("#edit-part-modal input#unit_cost").val(unit_cost);
  $("#edit-part-modal input#markup").val(markup);
  $("#edit-part-modal input#unitPrice").val(unit_price);
  $("#edit-part-modal input#measurement_id").val(measurement_id);
  $("#edit-part-modal input#formula").val(formula);
  total = parseInt(total).toFixed(2);
  $("#edit-part-modal span#total").html(total);
  if(type == 'count')
  {
    $(".supports #count").css('display','block');
  }
  if(type == 'length')
  {
    $(".supports #length").css('display','block');
  }
  if(type == 'area')
  {
    $(".supports #area").css('display','block');
  }
  $("#edit-part-modal").modal('show');
}
function openLabourEditModal(type, id, measurement_id, part_name, unit, unit_cost, markup, unit_price, formula, total){
  $("#edit-labour-modal input#id").val(id);
  $("#edit-labour-modal input#part_name").val(part_name);
  $("#edit-labour-modal input#unit").val(unit);
  $("#edit-labour-modal input#unit_cost").val(unit_cost);
  $("#edit-labour-modal input#markup").val(markup);
  $("#edit-labour-modal input#unitPrice").val(unit_price);
  $("#edit-labour-modal input#measurement_id").val(measurement_id);
  $("#edit-labour-modal input#formula").val(formula);
  total = parseInt(total).toFixed(2);
  $("#edit-labour-modal span#total").html(total);
  if(type == 'count')
  {
    $(".supports #count").css('display','block');
  }
  if(type == 'length')
  {
    $(".supports #length").css('display','block');
  }
  if(type == 'area')
  {
    $(".supports #area").css('display','block');
  }
  $("#edit-labour-modal").modal('show');
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
function openDeletePartModel(id, name)
{
  $("#deletePartModel span#name").html(name);
  $("#deletePartModel input#id").val(id);
  $("#deletePartModel").modal('show');
}
function openLengthModal(template_id){
  $("#create-length-modal input#template_id").val(template_id);
  $("#create-length-modal").modal('show');
}
function openAreaModal(template_id){
  $("#create-area-modal input#template_id").val(template_id);
  $("#create-area-modal").modal('show');
}
function openRenameTemplateModel(id, name)
{
  $("#renameTakeoffModel #id").val(id);
  $("#renameTakeoffModel #name").val(name);
  $("#renameTakeoffModel").modal('show');
}
function openAddLabourModel(id)
{
  $("#addlabourmodel #id").val(id);
  $("#addlabourmodel").modal('show');
}
function openAddPartModel(id)
{
  $("#addPartModal input#id").val(id);
  $("#addPartModal").modal('show');
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
function calculate_unit_price_edit_part()
{
  let unit_price = parseInt($("#edit-part-modal #unit_cost").val());
    let id = $('#edit-part-modal input[name="priceMode"]:checked').attr('id');
    if(id == 'priceMode1')
    {
      let markup = $("#edit-part-modal input#markup").val();
      markup = parseInt(markup);
      markup = markup/100;
      let a = unit_price*markup;
      let sum = a+unit_price;
      sum = sum.toFixed(2);
      $("#edit-part-modal input#unitPrice").val(sum);
    }else{
     let input = parseInt($("#edit-part-modal input#unitPrice").val());
     let a = (input - unit_price)/unit_price*100;
     let b = a*100;
     let c = b/100;
     c = c.toFixed(2);
     $("#edit-part-modal input#markup").val(c);
    }
}
function calculate_unit_price_add_part()
{
  let unit_price = parseInt($("#addPartModal #unit_cost").val());
    let id = $('#addPartModal input[name="priceMode"]:checked').attr('id');
    if(id == 'priceMode1')
    {
      let markup = $("#addPartModal input#markup").val();
      markup = parseInt(markup);
      markup = markup/100;
      let a = unit_price*markup;
      let sum = a+unit_price;
      sum = sum.toFixed(2);
      $("#addPartModal input#unitPrice").val(sum);
    }else{
     let input = parseInt($("#addPartModal input#unitPrice").val());
     let a = (input - unit_price)/unit_price*100;
     let b = a*100;
     let c = b/100;
     c = c.toFixed(2);
     $("#addPartModal input#markup").val(c);
    }
}
function calculate_unit_price_add_labour()
{
  let unit_price = parseInt($("#addlabourmodel #unit_cost").val());
    let id = $('#addlabourmodel input[name="priceMode"]:checked').attr('id');
    if(id == 'priceMode1')
    {
      let markup = $("#addlabourmodel input#markup").val();
      markup = parseInt(markup);
      markup = markup/100;
      let a = unit_price*markup;
      let sum = a+unit_price;
      sum = sum.toFixed(2);
      $("#addlabourmodel input#unitPrice").val(sum);
    }else{
     let input = parseInt($("#addlabourmodel input#unitPrice").val());
     let a = (input - unit_price)/unit_price*100;
     let b = a*100;
     let c = b/100;
     c = c.toFixed(2);
     $("#addlabourmodel input#markup").val(c);
    }
}
function calculate_unit_price_edit_labour()
{
  let unit_price = parseInt($("#edit-labour-modal #unit_cost").val());
    let id = $('#edit-labour-modal input[name="priceMode"]:checked').attr('id');
    if(id == 'priceMode1')
    {
      let markup = $("#edit-labour-modal input#markup").val();
      markup = parseInt(markup);
      markup = markup/100;
      let a = unit_price*markup;
      let sum = a+unit_price;
      sum = sum.toFixed(2);
      $("#edit-labour-modal input#unitPrice").val(sum);
    }else{
     let input = parseInt($("#edit-labour-modal input#unitPrice").val());
     let a = (input - unit_price)/unit_price*100;
     let b = a*100;
     let c = b/100;
     c = c.toFixed(2);
     $("#edit-labour-modal input#markup").val(c);
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

  // AREA MODEL
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
  // Edit Part MODEL
  $("#edit-part-modal #priceMode2").click(function(){
    $("#edit-part-modal #unitPrice").removeAttr("disabled");
    $("#edit-part-modal #markup").attr("disabled","disabled");
    calculate_unit_price_edit_part();
  });
  $("#edit-part-modal #priceMode1").click(function(){
    $("#edit-part-modal #markup").removeAttr("disabled");
    $("#edit-part-modal #unitPrice").attr("disabled","disabled");
    calculate_unit_price_edit_part();
  });
  $("#edit-part-modal #unit_cost").on('keyup', function(){
    calculate_unit_price_edit_part();
  });
  $("#edit-part-modal #markup").on('keyup', function(){
    calculate_unit_price_edit_part();
  });
  $("#edit-part-modal #unitPrice").on('keyup', function(){
    calculate_unit_price_edit_part();
  });
  // Add Part MODEL
  $("#addPartModal #priceMode2").click(function(){
    $("#addPartModal #unitPrice").removeAttr("disabled");
    $("#addPartModal #markup").attr("disabled","disabled");
    calculate_unit_price_add_part();
  });
  $("#addPartModal #priceMode1").click(function(){
    $("#addPartModal #markup").removeAttr("disabled");
    $("#addPartModal #unitPrice").attr("disabled","disabled");
    calculate_unit_price_add_part();
  });
  $("#addPartModal #unit_cost").on('keyup', function(){
    calculate_unit_price_add_part();
  });
  $("#addPartModal #markup").on('keyup', function(){
    calculate_unit_price_add_part();
  });
  $("#addPartModal #unitPrice").on('keyup', function(){
    calculate_unit_price_add_part();
  });
  // Add Labour MODEL
  $("#addlabourmodel #priceMode2").click(function(){
    $("#addlabourmodel #unitPrice").removeAttr("disabled");
    $("#addlabourmodel #markup").attr("disabled","disabled");
    calculate_unit_price_add_labour();
  });
  $("#addlabourmodel #priceMode1").click(function(){
    $("#addlabourmodel #markup").removeAttr("disabled");
    $("#addlabourmodel #unitPrice").attr("disabled","disabled");
    calculate_unit_price_add_labour();
  });
  $("#addlabourmodel #unit_cost").on('keyup', function(){
    calculate_unit_price_add_labour();
  });
  $("#addlabourmodel #markup").on('keyup', function(){
    calculate_unit_price_add_labour();
  });
  $("#addlabourmodel #unitPrice").on('keyup', function(){
    calculate_unit_price_add_labour();
  });
  // Edit Labour MODEL
  $("#edit-labour-modal #priceMode2").click(function(){
    $("#edit-labour-modal #unitPrice").removeAttr("disabled");
    $("#edit-labour-modal #markup").attr("disabled","disabled");
    calculate_unit_price_edit_labour();
  });
  $("#edit-labour-modal #priceMode1").click(function(){
    $("#edit-labour-modal #markup").removeAttr("disabled");
    $("#edit-labour-modal #unitPrice").attr("disabled","disabled");
    calculate_unit_price_edit_labour();
  });
  $("#edit-labour-modal #unit_cost").on('keyup', function(){
    calculate_unit_price_edit_labour();
  });
  $("#edit-labour-modal #markup").on('keyup', function(){
    calculate_unit_price_edit_labour();
  });
  $("#edit-labour-modal #unitPrice").on('keyup', function(){
    calculate_unit_price_edit_labour();
  });

  // AJAX REQUESTS
 // =======================

 $("#count_form").on('submit', function(e){
      e.preventDefault();
      var data = $('#count_form').serializeArray().reduce(function(obj, item) {
          obj[item.name] = item.value;
          return obj;
      }, {});
      let icon = $("button#symbol-style").html();
      let markup = $("#markup").val();
      let unit_price = $("#unitPrice").val();
      let csrf = $('meta[name="csrf"]').attr('content');
      $.ajax({
        type: 'POST',
        url: '/project/worksheet/count/add',
        data: {_token: csrf,data:data, icon:icon, markup: markup, unit_price: unit_price,additional:1},
        success: function(res)
        {
          console.log(res);
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
      let csrf = $('meta[name="csrf"]').attr('content');

      $.ajax({
        type: 'POST',
        url: '/project/worksheet/count/add',
        data: {_token: csrf,data:data, icon:icon, markup: markup, unit_price: unit_price,additional:1},
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
      var icon = $("#create-area-modal button#symbol-style").html();
      let markup = $("#create-area-modal #markup").val();
      let unit_price = $("#create-area-modal #unitPrice").val();
      let csrf = $('meta[name="csrf"]').attr('content');
     
      $.ajax({
        type: 'POST',
        url: '/project/worksheet/count/add',
        data: {_token: csrf, data: data, icon: icon, markup: markup, unit_price: unit_price, additional: 1},
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
 $("#updateStyleMeasementForm").on('submit', function(e){
      e.preventDefault();
      var data = $('#updateStyleMeasementForm').serializeArray().reduce(function(obj, item) {
          obj[item.name] = item.value;
          return obj;
      }, {});
      let icon = $("#openchangeStyleModal button#symbol-style").html();
      let csrf = $('meta[name="csrf"]').attr('content');
      $.ajax({
        type: 'POST',
        url: '/measurements/style/edit',
        data: {_token: csrf,data:data, icon:icon},
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
  $("#updateStyleMeasementFormLen").on('submit', function(e){
      e.preventDefault();
      var data = $('#updateStyleMeasementFormLen').serializeArray().reduce(function(obj, item) {
          obj[item.name] = item.value;
          return obj;
      }, {});
      let icon = $("#updateStyleMeasementFormLen button#symbol-style").html();
      let csrf = $('meta[name="csrf"]').attr('content');
      $.ajax({
        type: 'POST',
        url: '/measurements/style/edit/length',
        data: {_token: csrf,data:data, icon:icon},
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
  $("#updateAreaMeasementForm").on('submit', function(e){
      e.preventDefault();
      var data = $('#updateAreaMeasementForm').serializeArray().reduce(function(obj, item) {
          obj[item.name] = item.value;
          return obj;
      }, {});
      let icon = $("#updateAreaMeasementForm button#symbol-style").html();
      let csrf = $('meta[name="csrf"]').attr('content');
      $.ajax({
        type: 'POST',
        url: '/measurements/style/edit/area',
        data: {_token: csrf,data:data,icon:icon},
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
  $("#measurementsEditForm").on('submit', function(e){
      e.preventDefault();
      var data = $('#measurementsEditForm').serializeArray().reduce(function(obj, item) {
          obj[item.name] = item.value;
          return obj;
      }, {});
      let markup = $("#measurementsEditForm #markup").val();
      let unit_price = $("#measurementsEditForm #unitPrice").val();
      let csrf = $('meta[name="csrf"]').attr('content');
      $.ajax({
        type: 'POST',
        url: '/project/measurement/part/update',
        data: {_token: csrf,data:data, markup: markup, unit_price: unit_price},
        success: function(res)
        {
          console.log(res);
          if(res == 1)
          {
             location.reload();
          }else{
            $("#count_form_error").show();
          }
        }
      });
  });
  $("#addPartsForm").on('submit', function(e){
      e.preventDefault();
      var data = $('#addPartsForm').serializeArray().reduce(function(obj, item) {
          obj[item.name] = item.value;
          return obj;
      }, {});
      let markup = $("#addPartsForm #markup").val();
      let unit_price = $("#addPartsForm #unitPrice").val();
      let csrf = $('meta[name="csrf"]').attr('content');
      $.ajax({
        type: 'POST',
        url: '/project/measurement/part/add',
        data: {_token: csrf,data:data, markup: markup, unit_price: unit_price},
        success: function(res)
        {
          console.log(res);
          if(res == 1)
          {
             location.reload();
          }else{
            $("#count_form_error").show();
          }
        }
      });
  });
  $("#addLaboursForm").on('submit', function(e){
      e.preventDefault();
      var data = $('#addLaboursForm').serializeArray().reduce(function(obj, item) {
          obj[item.name] = item.value;
          return obj;
      }, {});
      let markup = $("#addLaboursForm #markup").val();
      let unit_price = $("#addLaboursForm #unitPrice").val();
      let csrf = $('meta[name="csrf"]').attr('content');
      $.ajax({
        type: 'POST',
        url: '/project/measurement/part/add',
        data: {_token: csrf,data:data, markup: markup, unit_price: unit_price},
        success: function(res)
        {
          console.log(res);
          if(res == 1)
          {
             location.reload();
          }else{
            $("#count_form_error").show();
          }
        }
      });
  });
  $("#editLaboursForm").on('submit', function(e){
      e.preventDefault();
      var data = $('#editLaboursForm').serializeArray().reduce(function(obj, item) {
          obj[item.name] = item.value;
          return obj;
      }, {});
      let markup = $("#editLaboursForm #markup").val();
      let unit_price = $("#editLaboursForm #unitPrice").val();
      let csrf = $('meta[name="csrf"]').attr('content');
      $.ajax({
        type: 'POST',
        url: '/project/measurement/part/edit',
        data: {_token: csrf,data:data, markup: markup, unit_price: unit_price},
        success: function(res)
        {
          console.log(res);
          if(res == 1)
          {
             location.reload();
          }else{
            $("#count_form_error").show();
          }
        }
      });
  });

  // Fill AND Strokes
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
  })
  $("#openchangeStyleModalLen .symbol-container ul li").click(function(){
    let html = $(this).html();
    $("#openchangeStyleModalLen #symbol-style").html(html);
  });
  $("#openchangeStyleModalLen #stroke").on('change', function(){
    let stroke = $(this).val();
    $("#openchangeStyleModalLen .symbol-container ul li svg line").css('stroke', stroke);
    $("#openchangeStyleModalLen #symbol-style svg line").css('stroke', stroke);
  });
  $("#openAreaEditModal #stroke").on('change', function(){
    let stroke = $(this).val();
    $("#openAreaEditModal #symbol-style svg path").attr('stroke', stroke);
  });
  $("#openAreaEditModal #fill").on('change', function(){
    let fill = $(this).val();
    $("#openAreaEditModal #symbol-style svg path").attr('fill', fill);
  });
});