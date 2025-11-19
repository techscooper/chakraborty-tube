$(document).ready(function(){
$("#pay_method_btn").click(function(e) {
  e.preventDefault();
  var filter = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

  var net_amnt = $('#net_amnt').val();
  var pay_method = $('#pay_method').val();
  var ledger_id = $('#ledger_id').val();
  var pay_amnt = $('#pay_amnt').val();

  if (net_amnt<1){
    toast('warning','Warning!','','Please Add Product');
  }
  else if (pay_method==''){
    toast('warning','Warning!','','Please Select Payment Method');
    $('#pay_method').focus();
  }
  else if (ledger_id==''){
    toast('warning','Warning!','','Please Select Receved to');
    $('#ledger_id').focus();
  }
  else if (pay_amnt==''){
    toast('warning','Warning!','','Please Enter Amount');
    $('#pay_amnt').focus();
  }
  else{
    $('#pay_method_btn').attr('disabled',true);
    $("#pay_method_btn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");
    var formData = new FormData($('#due_pay_frm')[0]);
    due_pay_frm_submit(formData);
  }
  });
});

function due_pay_frm_submit(data)
{
  $.ajax({
    type: 'POST',
    url: 'payment-code/due-payment-temp-2.php',
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
          $('#pay_method_btn').attr('disabled',false);
					toast('error','Error!','',data.msg);
          $("#pay_method_btn").html("Payment").fadeIn("fast");
        }, 100);
      }
      else if(data.success==true){
        setTimeout(function(){
					toast('success','Good job!','',data.msg);
          $("#pay_method_btn").html("Payment").fadeIn("fast");
          $('#pay_method_btn').attr('disabled',false);
        }, 1000);

        setTimeout(function(){
          pay(data.invoice_no);
        }, 2000);
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown){
      setTimeout(function(){
        $('#pay_method_btn').attr('disabled',false);
				toast('error','Error!','','Server timeout.');
        $("#pay_method_btn").html("Payment").fadeIn("fast");
      }, 100);
    },
    complete: function(XMLHttpRequest, status){ }
  });
};
