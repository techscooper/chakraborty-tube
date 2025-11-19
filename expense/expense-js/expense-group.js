$(document).ready(function(){
  $("#addGroupBtn").click(function(e){
    e.preventDefault();
    var filter = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    var group_name = $('#group_name').val();

    if (group_name==''){
      toast('warning','Warning!','','Please Enter Group Name.');
      $('#group_name').focus();
    }
    else{
      $('#addGroupBtn').attr('disabled',true);
      $("#addGroupBtn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");
      var formData = new FormData($('#addGroupFrm')[0]);
      addGroupFrm_submit(formData);
    }
  });
});

function addGroupFrm_submit(data){
  $.ajax({
    type: 'POST',
    url: 'expense-code/expense-group-2.php',
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
          $('#addGroupBtn').attr('disabled',false);
          toast('error','Error!','',data.msg);
          $("#addGroupBtn").html("Confirm").fadeIn("fast");
        }, 100);
      }
      else if(data.success==true){
        $("#addGroupBtn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");
        setTimeout(function(){
          toast('success','Good job!','',data.msg);
          $("#addGroupBtn").html("Confirm").fadeIn("fast");
        }, 1000);

        setTimeout(function(){
          $('#group_name').val('');
          $('#addGroupBtn').attr('disabled',false);
          ledgerList();
        }, 2000);
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown){
      setTimeout(function(){
        $('#addGroupBtn').attr('disabled',false);
        toast('error','Error!','','Server timeout.');
        $("#addGroupBtn").html("Confirm").fadeIn("fast");
      }, 100);
    },
    complete: function(XMLHttpRequest, status){ }
  });
};
