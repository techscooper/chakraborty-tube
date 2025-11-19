$(document).ready(function(){
$("#signin_btn").click(function(e){
  e.preventDefault();
  var filter = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

  var signin_username = $('#signin_username').val();
  var signin_password = $('#signin_password').val();
  var signin_captcha = $('#signin_captcha').val();

  if (signin_username==''){
    toast('warning','Warning!','','Please enter your username.');
	  $('#signin_username').focus();
  }
  else if (signin_password==''){
    toast('warning','Warning!','','Please enter your password.');
		$('#signin_password').focus();
  }
  else if (signin_captcha==''){
    toast('warning','Warning!','','Please enter captcha.');
		$('#signin_captcha').focus();
  }
  else{
    $('#signin_btn').attr('disabled',true);
    $("#signin_btn").html("<i class='fa fa-spin fa-spinner'></i> Please Wait...").fadeIn("fast");
    var formData = new FormData($('#login_frm')[0]);
    login_frm_submit(formData);
  }
  });
});

function login_frm_submit(data)
{
  $.ajax({
    type: 'POST',
    url: 'login-code/login-2.php',
    data: data,
    mimeType: "multipart/form-data",
    contentType: false,
    cache: false,
    processData: false,
    dataType: 'json',
    timeout: 0,
    success: function(data){
      if(data.error==true){
        toast('error','Error!','',data.msg);
        $('#signin_btn').attr('disabled',false);
        $("#signin_btn").html("Sign In").fadeIn("fast");
        $('#signin_password').focus();
      }
      else if(data.success==true){
        $("#signin_btn").html("<i class='fa fa-spin fa-spinner'></i> Please Wait...").fadeIn("fast");
        setTimeout(function(){document.location.href='';}, 2000);
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown){
      setTimeout(function(){
					toast('error','Error!','','Server timeout.');
          $('#signin_btn').attr('disabled',false);
          $("#signin_btn").html("Sign In").fadeIn("fast");
        }, 100);
    },
    complete: function(XMLHttpRequest, status){
    }
  });
};
