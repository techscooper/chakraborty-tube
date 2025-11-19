$(document).ready(function(){
  $("#addExpenseBtn").click(function(e){
    e.preventDefault();
    var filter = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    var ledger_id = $('#ledger_id').val();
    var expense_group_id = $('#expense_group_id').val();
    var bill_date = $('#bill_date').val();
    var net_amount = $('#net_amount').val();

    if (ledger_id==''){
      toast('warning','Warning!','','Please Select Ledger.');
      $('#ledger_id').focus();
    }
    else if (expense_group_id=='') {
      toast('warning','Warning!','','Please Select Group.');
      $('#expense_group_id').focus();
    }
    else if (bill_date=='') {
      toast('warning','Warning!','','Please Select Date.');
      $('#bill_date').focus();
    }
    else if (net_amount=='') {
      toast('warning','Warning!','','Please Enter Amount.');
      $('#net_amount').focus();
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
    url: 'expense-code/expense-entry-2.php',
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
          document.location.href='';
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
