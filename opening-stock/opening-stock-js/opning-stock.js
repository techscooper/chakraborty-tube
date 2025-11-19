$(document).ready(function(){
  $("#openStockBtn").click(function(e){
    e.preventDefault();
    var filter = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    $('#openStockBtn').attr('disabled',true);
    $("#openStockBtn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");
    var formData = new FormData($('#openStockFrm')[0]);
    openStockFrm_submit(formData);
  });
});
function openStockFrm_submit(data){
  $.ajax({
    type: 'POST',
    url: 'opening-stock-code/opning-stock-2.php',
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
          $('#openStockBtn').attr('disabled',false);
          $("#openStockBtn").html("Confirm").fadeIn("fast");
        }, 100);
      }
      else if(data.success==true){
        $("#openStockBtn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");
        setTimeout(function(){
          toast('success','Good job!','',data.msg);
          $("#openStockBtn").html("Confirm").fadeIn("fast");
        }, 1000);
        setTimeout(function(){
          document.location.href='';
        }, 2000);
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown){
      setTimeout(function(){
        toast('error','Error!','','Server timeout.');
        $('#openStockBtn').attr('disabled',false);
        $("#openStockBtn").html("Confirm").fadeIn("fast");
      }, 100);
    },
    complete: function(XMLHttpRequest, status){ }
  });
};