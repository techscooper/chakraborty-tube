$(document).ready(function(){
  $("#returnInvoiceBtn").click(function(e) {
    e.preventDefault();
    var filter = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    var n_amnt = $('#n_amnt').val();
    var customer_id = $('#customer_id').val();
    var invoice_date = $('#invoice_date').val();
    if (n_amnt<1){
      toast('warning','Warning!','','Please Add Product.');
      $('#customer_id').focus();
    }
    else if (customer_id==''){
      toast('warning','Warning!','','Please Select Customer.');
      $('#customer_id').focus();
    }
    else if (invoice_date==''){
      toast('warning','Warning!','','Please Select Date.');
      $('#invoice_date').focus();
    }
    else{
      $('#returnInvoiceBtn').attr('disabled',true);
      $("#returnInvoiceBtn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");
      var formData = new FormData($('#returnInvoiceFrm')[0]);
      returnInvoiceFrm_submit(formData);
    }
  });
});

function returnInvoiceFrm_submit(data){
  $.ajax({
    type: 'POST',
    url: 'statement-code/billing-return-2.php',
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
          $('#returnInvoiceBtn').attr('disabled',false);
          $("#returnInvoiceBtn").html("Confirm").fadeIn("fast");
        }, 100);
      }
      else if(data.success==true){
        $("#returnInvoiceBtn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");
        setTimeout(function(){
          toast('success','Good job!','',data.msg);
          $("#returnInvoiceBtn").html("Confirm").fadeIn("fast");
          //window.open("../invoicing/billing-invoice-print.php?customer_id="+data.customer_id+"&invoice_no="+data.invoice_no, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=50,left=300,width=800,height=1000");
          document.location.href='billing-list.php';
        }, 1000);
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown){
      setTimeout(function(){
        toast('error','Error!','','Server timeout.');
        $('#returnInvoiceBtn').attr('disabled',false);
        $("#returnInvoiceBtn").html("Confirm").fadeIn("fast");
      }, 100);
    },
    complete: function(XMLHttpRequest, status){ }
  });
};