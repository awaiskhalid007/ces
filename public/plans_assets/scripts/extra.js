$("#take-off-temp").click(function(){
	$("#takeofftemplate_model_div").show();
});
$(".apply-template-con input[type='radio']").click(function() {
   if($('#take-off-temp').is(':checked'))
   {
   	$("#takeofftemplate_model_div").show();
   }else{
   	$("#takeofftemplate_model_div").hide();
   }
});

$("#copy-from-stage").click(function(){
	$("#stages_model_div").show();
});
$(".apply-template-con input[type='radio']").click(function() {
   if($('#copy-from-stage').is(':checked'))
   {
   	$("#stages_model_div").show();
   }else{
   	$("#stages_model_div").hide();
   }
});