$(document).ready(function(){
$("#create_unit_btn").click(function(e) {

  e.preventDefault();
  var filter = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

  var unit_short_name = $('#unit_short_name').val();
  var unit_value = $('#unit_value').val();

  if (unit_short_name=='')
  {
    toast('warning','Warning!','','Please Enter Unit Name.');
    $('#unit_short_name').focus();
  }
  if (unit_value=='')
  {
    toast('warning','Warning!','','Please Enter Unit Name.');
    $('#unit_value').focus();
  }
  else
  {
    $('#create_level_btn').attr('disabled',true);
    $("#create_level_btn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");
    var formData = new FormData($('#unit_create_frm')[0]);
    unit_create_frm_submit(formData);
  }
  });
});

function unit_create_frm_submit(data)
{
  $.ajax({
    type: 'POST',
    url: 'inventory-code/create-unit-2.php',
    data: data,
    mimeType: "multipart/form-data",
    contentType: false,
    cache: false,
    processData: false,
    dataType: 'json',
    timeout: 0,
    success: function(data){
      if(data.error==true)
      {
        setTimeout(function(){
          $('#create_unit_btn').attr('disabled',false);
					toast('error','Error!','',data.msg);
          $("#create_unit_btn").html("Submit").fadeIn("fast");
        }, 100);
      }
      else if(data.success==true)
      {
        $("#create_unit_btn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");

        setTimeout(function(){
					toast('success','Good job!','',data.msg);
          $("#create_unit_btn").html("Submit").fadeIn("fast");
        }, 1000);

        setTimeout(function(){
          document.location.href='';
        }, 2000);
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown){
      setTimeout(function(){
        $('#create_unit_btn').attr('disabled',false);
				toast('error','Error!','','Server timeout.');
        $("#create_unit_btn").html("Submit").fadeIn("fast");
      }, 100);
    },
    complete: function(XMLHttpRequest, status){

    }
  });
};
