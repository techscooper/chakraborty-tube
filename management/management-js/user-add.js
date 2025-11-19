$(document).ready(function(){
$("#create_user_btn").click(function(e) {

  e.preventDefault();
  var filter = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

  var nm = $('#nm').val();
  var user_mobile = $('#user_mobile').val();
  var user_role = $('#user_role').val();
  var username = $('#username').val();
  var npassword = $('#npassword').val();
  var cpassword = $('#cpassword').val();

  if (nm=='')
  {
    toast('warning','Warning!','','Please Enter Name.');
    $('#nm').focus();
  }
  else if (user_mobile=='')
  {
		toast('warning','Warning!','','Please Enter Mobile Name.');
		$('#user_mobile').focus();
  }
  else if (user_role=='')
  {
		toast('warning','Warning!','','Please Select User Role.');
		$('#user_role').focus();
  }
  else if (username=='')
  {
		toast('warning','Warning!','','Please Enter Username.');
		$('#username').focus();
  }
  else if (npassword=='')
  {
		toast('warning','Warning!','','Please Enter New Password.');
		$('#npassword').focus();
  }
  else if (cpassword=='')
  {
		toast('warning','Warning!','','Please Enter Confirm Password.');
		$('#cpassword').focus();
  }
  else
  {
    $('#create_user_btn').attr('disabled',true); /*Disabled Button*/
    $("#create_user_btn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");
    /* Submit FormData */
    var formData = new FormData($('#user_create_frm')[0]);
    user_create_frm_submit(formData);
  }
  });
});

function user_create_frm_submit(data)
{
  $.ajax({
    type: 'POST',
    url: 'management-code/user-add-2.php',
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
          $('#create_user_btn').attr('disabled',false);		/*Disabled Button*/
					toast('error','Error!','',data.msg);
          $("#create_user_btn").html("Submit").fadeIn("fast");
        }, 100);
      }
      else if(data.success==true)
      {
        $("#create_user_btn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");

        setTimeout(function(){
					toast('success','Good job!','',data.msg);
          $("#create_user_btn").html("Submit").fadeIn("fast");
        }, 1000);

        setTimeout(function(){
          document.location.href='';
        }, 2000);
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown){
      setTimeout(function(){
        $('#create_user_btn').attr('disabled',false);		/*Disabled Button*/
				toast('error','Error!','','Server timeout.');
        $("#create_user_btn").html("Submit").fadeIn("fast");
      }, 100);
    },
    complete: function(XMLHttpRequest, status){

    }
  });
};
