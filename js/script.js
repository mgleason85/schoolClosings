jQuery(document).ready(function($) {
//Closed
$('#closing_id').click(function () {
  var $this = $(this);
if ($this.is(':checked')) {
  $('.closed_title').show();
  $('#delayed_message_div').hide();
  $('#delayed_div').hide();
  $('.delayed_title').css('display','none');
} else {
  $('#delayed_div').show();
  $('.delayed_title').hide();
  $('#delayed_message_div').hide();
}
});//End Closed
//Delayed
$('#delayed_id').click(function () {
  var $this = $(this);
if ($this.is(':checked')) {
  $('#delayed_message_div').show();
  $('.delayed_title').css('display','block');
  $('.delayed_title').show();
} else {
  $('.closed_title').hide();
  $('#delayed_message_div').hide();
}
});//End Delayed
});// End Document Ready