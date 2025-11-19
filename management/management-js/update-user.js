$(document).ready(function(){
$("#user_update_btn").click(function(e) {

  e.preventDefault();
  var filter = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

  var user_role = $('#e_user_role').val();
  var nm = $('#e_nm').val();
  var user_mobile = $('#e_user_mobile').val();

  if (user_role=='')
  {
    toast('warning','Warning!','','Please Select Role / Level.');
    $('#e_user_role').focus();
  }
  else if (nm=='')
  {
		toast('warning','Warning!','','Please Enter Name.');
		$('#e_rank').focus();
  }
  else if (user_mobile=='')
  {
		toast('warning','Warning!','','Please Enter Mobile.');
		$('#e_user_mobile').focus();
  }
  else
  {
    /* Button Loading */
    $('#user_update_btn').attr('disabled',true); /*Disabled Button*/
    $("#user_update_btn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");
    /* Submit FormData */
    var formData = new FormData($('#user_update_frm')[0]);
    user_update_frm_submit(formData);
  }
  });
});

function user_update_frm_submit(data)
{
  $.ajax({
    type: 'POST',
    url: 'user-management-code/update-user-2.php',
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
          $('#user_update_btn').attr('disabled',false);		/*Disabled Button*/
					toast('error','Error!','',data.msg);
          $("#user_update_btn").html("Save Changes").fadeIn("fast");
        }, 100);
      }
      else if(data.success==true)
      {
        $("#user_update_btn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");

        setTimeout(function(){
					toast('success','Good job!','',data.msg);
          $("#user_update_btn").html("Save Changes").fadeIn("fast");
        }, 1000);

        setTimeout(function(){
          document.location.href='';
        }, 2000);
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown){
      setTimeout(function(){
        $('#user_update_btn').attr('disabled',false);		/*Disabled Button*/
				toast('error','Error!','','Server timeout.');
        $("#user_update_btn").html("Save Changes").fadeIn("fast");
      }, 100);
    },
    complete: function(XMLHttpRequest, status){

    }
  });
};
