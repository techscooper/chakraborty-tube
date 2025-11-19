$(document).ready(function(){
$("#sbmt_btn").click(function(e) {

	e.preventDefault();
	var filter = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

	/* Button Loading */
	$('#sbmt_btn').attr('disabled',true); /*Disabled Button*/
	$("#sbmt_btn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");
	/* Submit FormData */
	var formData = new FormData($('#sbmt_frm')[0]);
	sbmt_frm_submit(formData);
  });
});

function sbmt_frm_submit(data)
{
  $.ajax({
    type: 'POST',
    url: 'user-management-code/update-role-management.php',
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
          $('#sbmt_btn').attr('disabled',false); /*Disabled Button*/
          toast('error','Error!','',data.msg);
          $("#sbmt_btn").html("Assign").fadeIn("fast");
        }, 100);
      }
      else if(data.success==true)
      {
        $("#sbmt_btn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");

        	setTimeout(function(){
					$('#sbmt_btn').attr('disabled',false); /*Disabled Button*/
          toast('success','Good job!','',data.msg);
          $("#sbmt_btn").html("Assign").fadeIn("fast");
        }, 1000);
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown){
      setTimeout(function(){
        $('#sbmt_btn').attr('disabled',false); /*Disabled Button*/
        toast('error','Error!','','Server timeout.');
        $("#sbmt_btn").html("Assign").fadeIn("fast");
      }, 100);
    },
    complete: function(XMLHttpRequest, status){

    }
  });
};
