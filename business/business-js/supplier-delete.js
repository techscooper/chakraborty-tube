$(document).ready(function(){
$("#supplier_del_btn").click(function(e) {

  e.preventDefault();
  var filter = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

  var supplier_del_id = $('#supplier_del_id').val();

  if (supplier_del_id=='')
  {
    setTimeout(function(){
      toast('warning','Warning!','','Unkonwn Error.');
    }, 100);
  }
  else
  {
    /* Button Loading */
    $('#supplier_del_btn').attr('disabled',true); /*Disabled Button*/
    $("#supplier_del_btn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");
    /* Submit FormData */
    var formData = new FormData($('#supplier_delete_frm')[0]);
    supplier_delete_frm_submit(formData);
  }
  });
});

function supplier_delete_frm_submit(data)
{
  $.ajax({
    type: 'POST',
    url: 'business-code/supplier-delete-2.php',
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
          $('#supplier_del_btn').attr('disabled',false);		/*Disabled Button*/
					toast('error','Error!','',data.msg);
          $("#supplier_del_btn").html("Confirm").fadeIn("fast");
        }, 100);
      }
      else if(data.success==true)
      {
        $("#supplier_del_btn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");

        setTimeout(function(){
					toast('success','Good job!','',data.msg);
          $("#supplier_del_btn").html("Confirm").fadeIn("fast");
        }, 1000);

        setTimeout(function(){
          document.location.href='';
        }, 2000);
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown){
      setTimeout(function(){
        $('#supplier_del_btn').attr('disabled',false);		/*Disabled Button*/
				toast('error','Error!','','Server timeout.');
        $("#supplier_del_btn").html("Confirm").fadeIn("fast");
      }, 100);
    },
    complete: function(XMLHttpRequest, status){

    }
  });
};
