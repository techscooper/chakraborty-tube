$(document).ready(function(){
  $("#updateBtn").click(function(e) {
    e.preventDefault();
    var filter = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    var sl = $('#sl').val();
    var quantity_no = $('#quantity_no').val();

    if (sl==''){
      toast('warning','Warning!','','Undefine');
      $('#sl').focus();
    }
    else if (quantity_no==''){
      toast('warning','Warning!','','Please enter quantity.');
      $('#quantity_no').focus();
    }
    else{
      $('#updateBtn').attr('disabled',true);
      $("#updateBtn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");
      var formData = new FormData($('#updateFrm')[0]);
      updateFrm_submit(formData);
    }
  });
});

function updateFrm_submit(data){
  $.ajax({
    type: 'POST',
    url: 'invoicing-code/purchase-product-temp-update-2.php',
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
          $('#updateBtn').attr('disabled',false);
					toast('error','Error!','',data.msg);
          $("#updateBtn").html("Save Changes").fadeIn("fast");
        }, 100);
      }
      else if(data.success==true)
      {
        $("#updateBtn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");
        setTimeout(function(){
					toast('success','Good job!','',data.msg);
          $("#updateBtn").html("Save Changes").fadeIn("fast");
        }, 1000);

        setTimeout(function(){
          getTempProduct();
          $('#modal-report').modal('hide');
        }, 2000);
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown){
      setTimeout(function(){
        $('#updateBtn').attr('disabled',false);
				toast('error','Error!','','Server timeout.');
        $("#updateBtn").html("Save Changes").fadeIn("fast");
      }, 100);
    },
    complete: function(XMLHttpRequest, status){ }
  });
};
