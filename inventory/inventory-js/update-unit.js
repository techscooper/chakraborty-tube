$(document).ready(function(){
$("#unit_update_btn").click(function(e) {

  e.preventDefault();
  var filter = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

  var edit_unit_short_name = $('#edit_unit_short_name').val();
  var edit_unit_value = $('#edit_unit_value').val();

  if (edit_unit_short_name=='')
  {
    toast('warning','Warning!','','Please Enter Unit Name.');
    $('#edit_unit_short_name').focus();
  }
  else if (edit_unit_value=='')
  {
    toast('warning','Warning!','','Please Enter Unit Value.');
    $('#edit_unit_short_name').focus();
  }
  else
  {
    /* Button Loading */
    $('#unit_update_btn').attr('disabled',true); /*Disabled Button*/
    $("#unit_update_btn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");
    /* Submit FormData */
    var formData = new FormData($('#unit_update_frm')[0]);
    unit_update_frm_submit(formData);
  }
  });
});

function unit_update_frm_submit(data)
{
  $.ajax({
    type: 'POST',
    url: 'inventory-setup-code/update-unit-2.php',
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
          $('#unit_update_btn').attr('disabled',false);		/*Disabled Button*/
					toast('error','Error!','',data.msg);
          $("#unit_update_btn").html("Save Changes").fadeIn("fast");
        }, 100);
      }
      else if(data.success==true)
      {
        $("#unit_update_btn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");

        setTimeout(function(){
					toast('success','Good job!','',data.msg);
          $("#unit_update_btn").html("Save Changes").fadeIn("fast");
        }, 1000);

        setTimeout(function(){
          document.location.href='';
        }, 2000);
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown){
      setTimeout(function(){
        $('#unit_update_btn').attr('disabled',false);		/*Disabled Button*/
				toast('error','Error!','','Server timeout.');
        $("#unit_update_btn").html("Save Changes").fadeIn("fast");
      }, 100);
    },
    complete: function(XMLHttpRequest, status){

    }
  });
};
