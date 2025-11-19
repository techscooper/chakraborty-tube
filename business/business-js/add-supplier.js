$(document).ready(function(){
$("#add_supplier_btn").click(function(e) {

  e.preventDefault();
  var filter = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

  var supplier_nm = $('#supplier_nm').val();
  var mobile_no = $('#mobile_no').val();

  if (supplier_nm=='')
  {
    toast('warning','Warning!','','Please Enter Supplier Name.');
    $('#supplier_nm').focus();
  }
  else if (mobile_no=='')
  {
    toast('warning','Warning!','','Please Enter Mobile Number.');
    $('#mobile_no').focus();
  }
  else
  {
    $('#add_supplier_btn').attr('disabled',true);
    $("#add_supplier_btn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");
    var formData = new FormData($('#add_supplier_frm')[0]);
    add_supplier_frm_submit(formData);
  }
  });
});

function add_supplier_frm_submit(data)
{
  $.ajax({
    type: 'POST',
    url: 'business-code/add-supplier-2.php',
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
          $('#add_supplier_btn').attr('disabled',false);
					toast('error','Error!','',data.msg);
          $("#add_supplier_btn").html("Confirm").fadeIn("fast");
        }, 100);
      }
      else if(data.success==true)
      {
        $("#add_supplier_btn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");

        setTimeout(function(){
					toast('success','Good job!','',data.msg);
          $("#add_supplier_btn").html("Confirm").fadeIn("fast");
        }, 1000);

        setTimeout(function(){
          document.location.href='manage-supplier.php';
        }, 2000);
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown){
      setTimeout(function(){
        $('#add_supplier_btn').attr('disabled',false);
				toast('error','Error!','','Server timeout.');
        $("#add_supplier_btn").html("Confirm").fadeIn("fast");
      }, 100);
    },
    complete: function(XMLHttpRequest, status){

    }
  });
};
