$(document).ready(function(){
$("#due_pay_btn").click(function(e) {
  e.preventDefault();
  var filter = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

  $('#due_pay_btn').attr('disabled',true);
  $("#due_pay_btn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");
  var formData = new FormData($('#due_pay_frm')[0]);
  due_pay_frm_submit1(formData);
  });
});

function due_pay_frm_submit1(data){
  $.ajax({
    type: 'POST',
    url: 'payment-code/due-payment-2.php',
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
          $('#due_pay_btn').attr('disabled',false);
          toast('error','Error!','',data.msg);
          $("#due_pay_btn").html("Confirm").fadeIn("fast");
        }, 100);
      }
      else if(data.success==true){
        $("#due_pay_btn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");
        setTimeout(function(){
          toast('success','Good job!','',data.msg);
          $("#due_pay_btn").html("Confirm").fadeIn("fast");
        }, 1000);

        setTimeout(function(){
          window.open("../invoicing/billing-invoice-print.php?customer_id="+data.customer_id+"&invoice_no="+data.invoice_no, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=50,left=300,width=800,height=1000");
          document.location.href='due-pay.php';
        }, 2000);
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown){
      setTimeout(function(){
        $('#due_pay_btn').attr('disabled',false);
        toast('error','Error!','','Server timeout.');
        $("#due_pay_btn").html("Confirm").fadeIn("fast");
      }, 100);
    },
    complete: function(XMLHttpRequest, status){ }
  });
};
