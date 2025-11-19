$(document).ready(function(){
  $("#updateExpenseBtn").click(function(e){
    e.preventDefault();
    var filter = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    var ledger_name_update = $('#ledger_name_update').val();
    var opening_balance_update = $('#opening_balance_update').val();

    if (ledger_name_update==''){
      toast('warning','Warning!','','Please Enter Ledger Name.');
      $('#ledger_name_update').focus();
    }
    else if (opening_balance_update=='') {
      toast('warning','Warning!','','Please Enter Opening Balance.');
      $('#opening_balance_update').focus();
    }
    else{
      $('#updateExpenseBtn').attr('disabled',true);
      $("#updateExpenseBtn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");
      var formData = new FormData($('#updateExpenseFrm')[0]);
      updateExpenseFrm_submit(formData);
    }
  });
});

function updateExpenseFrm_submit(data){
  $.ajax({
    type: 'POST',
    url: 'business-code/expense-ledger-update-2.php',
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
          $('#updateExpenseBtn').attr('disabled',false);
          toast('error','Error!','',data.msg);
          $("#updateExpenseBtn").html("Update").fadeIn("fast");
        }, 100);
      }
      else if(data.success==true){
        $("#updateExpenseBtn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");
        setTimeout(function(){
          toast('success','Good job!','',data.msg);
          $("#updateExpenseBtn").html("Update").fadeIn("fast");
        }, 1000);

        setTimeout(function(){
          ledgerList();
          $('#modal-report').modal('hide');
        }, 2000);
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown){
      setTimeout(function(){
        $('#updateExpenseBtn').attr('disabled',false);
        toast('error','Error!','','Server timeout.');
        $("#updateExpenseBtn").html("Confirm").fadeIn("fast");
      }, 100);
    },
    complete: function(XMLHttpRequest, status){ }
  });
};
