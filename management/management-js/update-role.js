$(document).ready(function(){
$("#role_update_btn").click(function(e) {

  e.preventDefault();
  var filter = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

  var level_nm = $('#level_nm').val();
  var rank = $('#rank').val();

  if (level_nm=='')
  {
    toast('warning','Warning!','','Please Enter Role / Level.');
    $('#level_nm').focus();
  }
  else if (rank=='')
  {
		toast('warning','Warning!','','Please Enter Rank.');
		$('#rank').focus();
  }
  else
  {
    /* Button Loading */
    $('#role_update_btn').attr('disabled',true); /*Disabled Button*/
    $("#role_update_btn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");
    /* Submit FormData */
    var formData = new FormData($('#role_update_frm')[0]);
    role_update_frm_submit(formData);
  }
  });
});

function role_update_frm_submit(data)
{
  $.ajax({
    type: 'POST',
    url: 'user-management-code/update-role-2.php',
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
          $('#role_update_btn').attr('disabled',false);		/*Disabled Button*/
					toast('error','Error!','',data.msg);
          $("#role_update_btn").html("Save Changes").fadeIn("fast");
        }, 100);
      }
      else if(data.success==true)
      {
        $("#role_update_btn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");

        setTimeout(function(){
					toast('success','Good job!','',data.msg);
          $("#role_update_btn").html("Save Changes").fadeIn("fast");
        }, 1000);

        setTimeout(function(){
          document.location.href='';
        }, 2000);
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown){
      setTimeout(function(){
        $('#role_update_btn').attr('disabled',false);		/*Disabled Button*/
				toast('error','Error!','','Server timeout.');
        $("#role_update_btn").html("Save Changes").fadeIn("fast");
      }, 100);
    },
    complete: function(XMLHttpRequest, status){

    }
  });
};
