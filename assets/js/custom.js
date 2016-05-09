// JavaScript Document

$(document).ready(function(){


 $('input[type=file]').change(function () {
var val = $(this).val().toLowerCase();
//var regex = new RegExp("(.*?)\.(jpg|jpeg|png|docx|doc|pdf|xls|csv|gif|xlsx)$");
 var regex = new RegExp("(.*?)\.(csv)$");
if(!(regex.test(val))) {
$(this).val('');
alert('Unsupported file');
} }); 



$('#db_date').datepicker({
	
	
	dateFormat: "yyyy-mm-dd"  
	
	 });
$('#join_date').datepicker({
	
	
	dateFormat: "yyyy-mm-dd"  
	
	 });

$(".group_id").on('change',function()
	{
		get=$(".group_id option:selected").text();
		$("#team_profile_job_position_title").val(get);
});
	
/*	var ext = $('.form-control').val().split('.').pop().toLowerCase();
if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
    
}
$('INPUT[type="file"]').change(function () {
    var ext = this.value.match(/\.(.+)$/)[1];
    switch (ext) {
        case 'jpg':
        case 'jpeg':
        case 'png':
        case 'gif':
            $('#uploadButton').attr('disabled', false);
            break;
        default:
            alert('This is not an allowed file type.');
            this.value = '';
    }
});*/

});



  