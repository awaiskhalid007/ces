var flipX = $("#filt-monthly");
var flipY = $("#filt-yearly");
var monthly = $("#monthly");
var yearly = $("#yearly");
var switcher = $("#switcher");

flipY.on('click', function(){
  switcher.prop('checked', true);
  flipX.removeClass('toggler--is-active');
  flipY.addClass('toggler--is-active');
  yearly.removeClass('hide');
  monthly.addClass('hide');
  $("#subscription").val('1');
})
flipX.on('click', function(){
  switcher.prop('checked', false);
  flipY.removeClass('toggler--is-active');
  flipX.addClass('toggler--is-active');
  monthly.removeClass('hide');
  yearly.addClass('hide');
  $("#subscription").val('0');
})
switcher.on('click', function(){
  flipX.toggleClass('toggler--is-active');
  flipY.toggleClass('toggler--is-active');
  monthly.toggleClass('hide');
  yearly.toggleClass('hide');

  var val = $("#subscription").val();
  if(val == 0)
  {
    $("#subscription").val('1');
  }else{
    $("#subscription").val('0');
  }
});
