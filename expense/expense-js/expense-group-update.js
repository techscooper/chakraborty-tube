$(document).ready(function(){
  $("#updateGroupBtn").click(function(e){
    e.preventDefault();
    var filter = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    var group_name_update = $('#group_name_update').val();

    if (group_name_update==''){
      toast('warning','Warning!','','Please Enter Group Name.');
      $('#group_name_update').focus();
    }
    else{
      $('#updateGroupBtn').attr('disabled',true);
      $("#updateGroupBtn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");
      var formData = new FormData($('#updateGroupFrm')[0]);
      updateGroupFrm_submit(formData);
    }
  });
});

function updateGroupFrm_submit(data){
  $.ajax({
    type: 'POST',
    url: 'expense-code/expense-group-update-2.php',
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
          $('#updateGroupBtn').attr('disabled',false);
          toast('error','Error!','',data.msg);
          $("#updateGroupBtn").html("Update").fadeIn("fast");
        }, 100);
      }
      else if(data.success==true){
        $("#updateGroupBtn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");
        setTimeout(function(){
          toast('success','Good job!','',data.msg);
          $("#updateGroupBtn").html("Update").fadeIn("fast");
        }, 1000);

        setTimeout(function(){
          ledgerList();
          $('#modal-report').modal('hide');
        }, 2000);
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown){
      setTimeout(function(){
        $('#updateGroupBtn').attr('disabled',false);
        toast('error','Error!','','Server timeout.');
        $("#updateGroupBtn").html("Confirm").fadeIn("fast");
      }, 100);
    },
    complete: function(XMLHttpRequest, status){ }
  });
};
