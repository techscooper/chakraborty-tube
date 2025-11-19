$(document).ready(function(){
  $("#addExpenseBtn").click(function(e){
    e.preventDefault();
    var filter = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    var ledger_name = $('#ledger_name').val();
    var opening_balance = $('#opening_balance').val();

    if (ledger_name==''){
      toast('warning','Warning!','','Please Enter Ledger Name.');
      $('#ledger_name').focus();
    }
    else if (opening_balance=='') {
      toast('warning','Warning!','','Please Enter Opening Balance.');
      $('#opening_balance').focus();
    }
    else{
      $('#addExpenseBtn').attr('disabled',true);
      $("#addExpenseBtn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");
      var formData = new FormData($('#addExpenseFrm')[0]);
      addExpenseFrm_submit(formData);
    }
  });
});

function addExpenseFrm_submit(data){
  $.ajax({
    type: 'POST',
    url: 'business-code/expense-ledger-2.php',
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
          $('#addExpenseBtn').attr('disabled',false);
          toast('error','Error!','',data.msg);
          $("#addExpenseBtn").html("Confirm").fadeIn("fast");
        }, 100);
      }
      else if(data.success==true){
        $("#addExpenseBtn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");
        setTimeout(function(){
          toast('success','Good job!','',data.msg);
          $("#addExpenseBtn").html("Confirm").fadeIn("fast");
        }, 1000);

        setTimeout(function(){
          $('#ledger_name').val('');
          $('#opening_balance').val('');
          $('#ledger_name').focus();
          $('#addExpenseBtn').attr('disabled',false);
          ledgerList();
        }, 2000);
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown){
      setTimeout(function(){
        $('#addExpenseBtn').attr('disabled',false);
        toast('error','Error!','','Server timeout.');
        $("#addExpenseBtn").html("Confirm").fadeIn("fast");
      }, 100);
    },
    complete: function(XMLHttpRequest, status){ }
  });
};
