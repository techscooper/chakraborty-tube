$(document).ready(function(){
$("#create_bill_btn").click(function(e) {
  e.preventDefault();
  var filter = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

  var n_amnt = $('#n_amnt').val();
  var customer_id = $('#customer_id').val();
  var invoice_date = $('#invoice_date').val();

  if (n_amnt<1){
    setTimeout(function(){
      toast('warning','Warning!','','Please Add Product.');
    }, 100);
    $('#customer_id').focus();
  }
  else if (customer_id==''){
    setTimeout(function(){
      toast('warning','Warning!','','Please Select Customer.');
    }, 100);
    $('#customer_id').focus();
  }
  else if (invoice_date==''){
    setTimeout(function(){
      toast('warning','Warning!','','Please Select Date.');
    }, 100);
    $('#invoice_date').focus();
  }
  else{
    $('#create_bill_btn').attr('disabled',true);
    $("#create_bill_btn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");
    var formData = new FormData($('#bill_generate_frm')[0]);
    bill_generate_frm_submit(formData);
  }
  });
});

function bill_generate_frm_submit(data){
  $.ajax({
    type: 'POST',
    url: 'invoicing-code/billing-2.php',
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
          $('#create_bill_btn').attr('disabled',false);
					toast('error','Error!','',data.msg);
          $("#create_bill_btn").html("Confirm").fadeIn("fast");
        }, 100);
      }
      else if(data.success==true)
      {
        $("#create_bill_btn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");
        setTimeout(function(){
					toast('success','Good job!','',data.msg);
          $("#create_bill_btn").html("Confirm").fadeIn("fast");
        }, 1000);

        setTimeout(function(){
          window.open("export/billing-invoice-print.php?invoice_no="+data.invoice_no, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=50,left=300,width=800,height=1000");
          document.location.href='billing.php';
        }, 2000);
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown){
      setTimeout(function(){
        $('#create_bill_btn').attr('disabled',false);
				toast('error','Error!','','Server timeout.');
        $("#create_bill_btn").html("Confirm").fadeIn("fast");
      }, 100);
    },
    complete: function(XMLHttpRequest, status){ }
  });
};
