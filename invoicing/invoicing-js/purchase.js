$(document).ready(function(){
  $("#purchaseAddBtn").click(function(e) {
    e.preventDefault();
    var filter = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    var supplier_id = $('#supplier_id').val();
    var purchase_date = $('#purchase_date').val();
    if (supplier_id==''){
      toast('warning','Warning!','','Please Select Supplier.');
      $('#supplier_id').focus();
    }
    else if (purchase_date==''){
      toast('warning','Warning!','','Please Select Date.');
      $('#invoice_date').focus();
    }
    else{
      $('#purchaseAddBtn').attr('disabled',true);
      $("#purchaseAddBtn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");
      var formData = new FormData($('#purchaseAddFrm')[0]);
      purchaseAddFrm_submit(formData);
    }
  });
});

function purchaseAddFrm_submit(data){
  $.ajax({
    type: 'POST',
    url: 'invoicing-code/purchase-2.php',
    data: data,
    mimeType: "multipart/form-data",
    contentType: false,
    cache: false,
    processData: false,
    dataType: 'json',
    timeout: 0,
    success: function(data){
      if(data.error==true){
        setTimeout(function(){
          toast('error','Error!','',data.msg);
          $('#purchaseAddBtn').attr('disabled',false);
          $("#purchaseAddBtn").html("Confirm").fadeIn("fast");
        }, 100);
      }
      else if(data.success==true){
        $("#purchaseAddBtn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");
        setTimeout(function(){
          toast('success','Good job!','',data.msg);
          $("#purchaseAddBtn").html("Confirm").fadeIn("fast");
          document.location.href='';
        }, 1000);
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown){
      setTimeout(function(){
        toast('error','Error!','','Server timeout.');
        $('#purchaseAddBtn').attr('disabled',false);
        $("#purchaseAddBtn").html("Confirm").fadeIn("fast");
      }, 100);
    },
    complete: function(XMLHttpRequest, status){ }
  });
};