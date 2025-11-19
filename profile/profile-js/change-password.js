$(document).ready(function(){
$("#cng_pass_btn").click(function(e) {

  e.preventDefault();
  var filter = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    /* Button Loading */
    $('#cng_pass_btn').attr('disabled',true); /*Disabled Button*/
    $("#cng_pass_btn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");
    /* Submit FormData */
    var formData = new FormData($('#change_pass_frm')[0]);
    change_pass_frm_submit(formData);
  });
});

function change_pass_frm_submit(data)
{
  $.ajax({
    type: 'POST',
    url: 'profile-code/change-password-2.php',
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
          $('#cng_pass_btn').attr('disabled',false);		/*Disabled Button*/
					toast('error','Error!','',data.msg);
          $("#cng_pass_btn").html("Confirm").fadeIn("fast");
        }, 100);
      }
      else if(data.success==true)
      {
        $("#cng_pass_btn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");

        setTimeout(function(){
					toast('success','Good job!','',data.msg);
          $("#cng_pass_btn").html("Confirm").fadeIn("fast");
        }, 1000);

        setTimeout(function(){
          document.location.href='';
        }, 2000);
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown){
      setTimeout(function(){
        $('#cng_pass_btn').attr('disabled',false);		/*Disabled Button*/
				toast('error','Error!','','Server timeout.');
        $("#cng_pass_btn").html("Confirm").fadeIn("fast");
      }, 100);
    },
    complete: function(XMLHttpRequest, status){

    }
  });
};
