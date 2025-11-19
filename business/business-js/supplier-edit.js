$(document).ready(function(){
$("#s_edt_btn").click(function(e) {

  e.preventDefault();
  var filter = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

  var supplier_nm = $('#supplier_nm').val();
  var email_id = $('#email_id').val();
  var mobile_no = $('#mobile_no').val();
  var supplier_state = $('#supplier_state').val();
  var address_1 = $('#address_1').val();
  var address_2 = $('#address_2').val();
  var zip_code = $('#zip_code').val();

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
    $('#s_edt_btn').attr('disabled',true);
    $("#s_edt_btn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");
    var formData = new FormData($('#supplier_edt_frm')[0]);
    supplier_edt_frm_submit(formData);
  }
  });
});

function supplier_edt_frm_submit(data)
{
  $.ajax({
    type: 'POST',
    url: 'business-code/supplier-edit-2.php',
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
          $('#s_edt_btn').attr('disabled',false);
					toast('error','Error!','',data.msg);
          $("#s_edt_btn").html("Confirm").fadeIn("fast");
        }, 100);
      }
      else if(data.success==true)
      {
        $("#s_edt_btn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");

        setTimeout(function(){
					toast('success','Good job!','',data.msg);
          $("#s_edt_btn").html("Confirm").fadeIn("fast");
        }, 1000);

        setTimeout(function(){
          document.location.href='manage-supplier.php';
        }, 2000);
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown){
      setTimeout(function(){
        $('#s_edt_btn').attr('disabled',false);
				toast('error','Error!','','Server timeout.');
        $("#s_edt_btn").html("Confirm").fadeIn("fast");
      }, 100);
    },
    complete: function(XMLHttpRequest, status){

    }
  });
};
