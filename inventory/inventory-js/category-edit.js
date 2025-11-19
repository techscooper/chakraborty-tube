$(document).ready(function(){
$("#category_edt_btn").click(function(e) {

  e.preventDefault();
  var filter = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

  var category_edt = $('#category_edt').val();

  if (category_edt=='')
  {
    setTimeout(function(){
      toast('warning','Warning!','','Please Enter Category Name.');
    }, 100);
    $('#category_edt').focus();
  }
  else
  {
    /* Button Loading */
    $('#category_edt_btn').attr('disabled',true); /*Disabled Button*/
    $("#category_edt_btn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");
    /* Submit FormData */
    var formData = new FormData($('#category_edt_frm')[0]);
    category_edt_frm_submit(formData);
  }
  });
});

function category_edt_frm_submit(data)
{
  $.ajax({
    type: 'POST',
    url: 'inventory-setup-code/category-edit-2.php',
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
          $('#category_edt_btn').attr('disabled',false);		/*Disabled Button*/
					toast('error','Error!','',data.msg);
          $("#category_edt_btn").html("Confirm").fadeIn("fast");
        }, 100);
      }
      else if(data.success==true)
      {
        $("#category_edt_btn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");

        setTimeout(function(){
					toast('success','Good job!','',data.msg);
          $("#category_edt_btn").html("Confirm").fadeIn("fast");
        }, 1000);

        setTimeout(function(){
          document.location.href='';
        }, 2000);
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown){
      setTimeout(function(){
        $('#category_edt_btn').attr('disabled',false);		/*Disabled Button*/
				toast('error','Error!','','Server timeout.');
        $("#category_edt_btn").html("Confirm").fadeIn("fast");
      }, 100);
    },
    complete: function(XMLHttpRequest, status){

    }
  });
};
