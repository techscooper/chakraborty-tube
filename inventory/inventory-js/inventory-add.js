$(document).ready(function(){
$("#addInventoryBtn").click(function(e) {
  e.preventDefault();
  var filter = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  var category_id=$('#category_id').val();
  var product_name=$('#product_name').val();
  var unit_id=$('#unit_id').val();
  var purchase_rate=$('#purchase_rate').val();
  var sale_rate=$('#sale_rate').val();
  if (category_id==''){
    toast('warning','Warning!','','Please select category');
    $('#category_id').focus();
  }
  else if (product_name==''){
    toast('warning','Warning!','','Please enter product name');
    $('#product_name').focus();
  }
  else if (unit_id==''){
    toast('warning','Warning!','','Please select product unit');
    $('#unit_id').focus();
  }
  else if (purchase_rate==''){
    toast('warning','Warning!','','Please enter purchase rate');
    $('#purchase_rate').focus();
  }
  else if (sale_rate==''){
    toast('warning','Warning!','','Please enter sale rate');
    $('#sale_rate').focus();
  }
  else{
    $('#addInventoryBtn').attr('disabled',true);
    $("#addInventoryBtn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");
    var formData = new FormData($('#addInventoryFrm')[0]);
    addInventoryFrm_submit(formData);
  }
  });
});

function addInventoryFrm_submit(data){
  $.ajax({
    type: 'POST',
    url: 'inventory-code/inventory-add-2.php',
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
          $('#addInventoryBtn').attr('disabled',false);
          $("#addInventoryBtn").html("Confirm").fadeIn("fast");
        }, 100);
      }
      else if(data.success==true){
        $("#addInventoryBtn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");
        setTimeout(function(){
					toast('success','Good job!','',data.msg);
          $("#addInventoryBtn").html("Confirm").fadeIn("fast");
        }, 1000);

        setTimeout(function(){
          document.location.href='inventory-list.php';
        }, 2000);
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown){
      setTimeout(function(){
        toast('error','Error!','','Server timeout.');
        $('#addInventoryBtn').attr('disabled',false);
        $("#addInventoryBtn").html("Confirm").fadeIn("fast");
      }, 100);
    },
    complete: function(XMLHttpRequest, status){ }
  });
};