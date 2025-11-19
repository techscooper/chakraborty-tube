$(document).ready(function(){
  $("#create_role_btn").click(function(e) {
  e.preventDefault();
  var filter = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  var user_level_nm = $('#user_level_nm').val();
  var l_rank = $('#l_rank').val();
  if (user_level_nm==''){
    toast('warning','Warning!','','Please Enter Role / Level.');
    $('#user_level_nm').focus();
  }
  else if (l_rank==''){
		toast('warning','Warning!','','Please Enter Rank.');
		$('#l_rank').focus();
  }
  else{
    $('#create_level_btn').attr('disabled',true); /*Disabled Button*/
    $("#create_level_btn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");
    var formData = new FormData($('#role_create_frm')[0]);
    role_create_frm_submit(formData);
  }
  });
});

function role_create_frm_submit(data)
{
  $.ajax({
    type: 'POST',
    url: 'management-code/role-add-2.php',
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
          $('#create_role_btn').attr('disabled',false);
					toast('error','Error!','',data.msg);
          $("#create_role_btn").html("Submit").fadeIn("fast");
        }, 100);
      }
      else if(data.success==true)
      {
        $("#create_role_btn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");
        setTimeout(function(){
					toast('success','Good job!','',data.msg);
          $("#create_role_btn").html("Submit").fadeIn("fast");
        }, 1000);
        setTimeout(function(){
          document.location.href='create-role.php';
        }, 2000);
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown){
      setTimeout(function(){
        $('#create_role_btn').attr('disabled',false);
				toast('error','Error!','','Server timeout.');
        $("#create_role_btn").html("Submit").fadeIn("fast");
      }, 100);
    },
    complete: function(XMLHttpRequest, status){ }
  });
};