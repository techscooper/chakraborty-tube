$(document).ready(function(){
$("#inv_edt_btn").click(function(e) {

  e.preventDefault();
  var filter = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

  var category = $('#category_edit').val();
  var product_nm = $('#product_nm_edit').val();
  var product_code_edit = $('#product_code_edit').val();
  var sale_rate = $('#sale_rate_edit').val();
  var product_unit = $('#product_unit_edit').val();

  if (category=='')
  {
    toast('warning','Warning!','','Please Select Category.');
    $('#category').focus();
  }
  else if (product_nm=='')
  {
    toast('warning','Warning!','','Please Enter Name.');
    $('#product_nm').focus();
  }
  else if (product_code_edit=='')
  {
    toast('warning','Warning!','','Please Enter Prodect Code.');
    $('#product_code_edit').focus();
  }
  else if (sale_rate=='')
  {
    toast('warning','Warning!','','Please Enter Sales Rate.');
    $('#sale_rate').focus();
  }
  else if (product_unit=='')
  {
    toast('warning','Warning!','','Please Enter Unit.');
    $('#product_unit').focus();
  }
  else
  {
    $('#inv_edt_btn').attr('disabled',true);
    $("#inv_edt_btn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");
    var formData = new FormData($('#inv_edt_frm')[0]);
    inv_edt_frm_submit(formData);
  }
  });
});

function inv_edt_frm_submit(data)
{
  $.ajax({
    type: 'POST',
    url: 'inventory-setup-code/inventory-edit-2.php',
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
          $('#inv_edt_btn').attr('disabled',false);
					toast('error','Error!','',data.msg);
          $("#inv_edt_btn").html("Confirm").fadeIn("fast");
        }, 100);
      }
      else if(data.success==true)
      {
        $("#inv_edt_btn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");

        setTimeout(function(){
					toast('success','Good job!','',data.msg);
          $("#inv_edt_btn").html("Confirm").fadeIn("fast");
        }, 1000);

        setTimeout(function(){
          document.location.href='';
        }, 2000);
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown){
      setTimeout(function(){
        $('#inv_edt_btn').attr('disabled',false);
				toast('error','Error!','','Server timeout.');
        $("#inv_edt_btn").html("Confirm").fadeIn("fast");
      }, 100);
    },
    complete: function(XMLHttpRequest, status){

    }
  });
};
