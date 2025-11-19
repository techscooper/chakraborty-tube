$(document).ready(function(){
  $("#inventoryUpdateBtn").click(function(e) {
    e.preventDefault();
    var filter = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    var inventoryUnqID=$('#inventoryUnqID').val();
    var category_id=$('#category_id_update').val();
    var product_name=$('#product_name_update').val();
    var unit_id=$('#unit_id_update').val();
    var purchase_rate=$('#purchase_rate_update').val();
    var sale_rate=$('#sale_rate_update').val();
    if (inventoryUnqID==''){
      toast('warning','Warning!','','Undefined error');
    }
    else if (category_id==''){
      toast('warning','Warning!','','Please select category');
      $('#category_id_update').focus();
    }
    else if (product_name==''){
      toast('warning','Warning!','','Please enter product name');
      $('#product_name_update').focus();
    }
    else if (unit_id==''){
      toast('warning','Warning!','','Please select product unit');
      $('#unit_id_update').focus();
    }
    else if (purchase_rate==''){
      toast('warning','Warning!','','Please enter purchase rate');
      $('#purchase_rate_update').focus();
    }
    else if (sale_rate==''){
      toast('warning','Warning!','','Please enter sale rate');
      $('#sale_rate_update').focus();
    }
    else{
      $('#inventoryUpdateBtn').attr('disabled',true);
      $("#inventoryUpdateBtn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");
      var formData = new FormData($('#inventoryUpdateFrm')[0]);
      inventoryUpdateFrm_submit(formData);
    }
    });
  });
  
  function inventoryUpdateFrm_submit(data){
    $.ajax({
      type: 'POST',
      url: 'inventory-code/inventory-update-2.php',
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
            $('#inventoryUpdateBtn').attr('disabled',false);
            $("#inventoryUpdateBtn").html("Save Changes").fadeIn("fast");
          }, 100);
        }
        else if(data.success==true){
          $("#inventoryUpdateBtn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");
          setTimeout(function(){
            toast('success','Good job!','',data.msg);
            $("#inventoryUpdateBtn").html("Save Changes").fadeIn("fast");
            $('#inventoryUpdateFrm')[0].reset();
            $('#modal-report').modal('hide');
            show_list_div();
          }, 1000);
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown){
        setTimeout(function(){
          toast('error','Error!','','Server timeout.');
          $('#addInventoryBtn').attr('disabled',false);
          $("#addInventoryBtn").html("Save Changes").fadeIn("fast");
        }, 100);
      },
      complete: function(XMLHttpRequest, status){ }
    });
  };