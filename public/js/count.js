$('input[name="subject"]').on('keydown keyup change', function() {
  var count = $(this).val().length;
  $("#s_count").text(count);
  if(count > 50) {
    $("#s_count").css({color: 'red', fontWeight: 'bold'});
  }else{
    $("#s_count").css({color: '#757575', fontWeight: 'normal'});
  }
});

$('textarea').on('keydown keyup change', function() {
  var count = $(this).val().length;
  $("#b_count").text(count);
  if(count > 1000) {
    $("#b_count").css({color: 'red', fontWeight: 'bold'});
  }else{
    $("#b_count").css({color: '#757575', fontWeight: 'normal'});
  }
});