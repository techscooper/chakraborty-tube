$(document).ready(function(){
  $("#updatePriceBtn").click(function(e) {
    e.preventDefault();
    var filter = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    var sl = $('#sl').val();
    var price_amount = $('#price_amount').val();

    if (sl==''){
      toast('warning','Warning!','','Undefine');
      $('#sl').focus();
    }
    else if (price_amount==''){
      toast('warning','Warning!','','Please enter Price.');
      $('#price_amount').focus();
    }
    else{
      $('#updatePriceBtn').attr('disabled',true);
      $("#updatePriceBtn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");
      var formData = new FormData($('#updatePriceFrm')[0]);
      updatePriceFrm_submit(formData);
    }
  });
});

function updatePriceFrm_submit(data){
  $.ajax({
    type: 'POST',
    url: 'invoicing-code/billing-product-temp-price-update-2.php',
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
          $('#updatePriceBtn').attr('disabled',false);
					toast('error','Error!','',data.msg);
          $("#updatePriceBtn").html("Save Changes").fadeIn("fast");
        }, 100);
      }
      else if(data.success==true)
      {
        $("#updatePriceBtn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");
        setTimeout(function(){
					toast('success','Good job!','',data.msg);
          $("#updatePriceBtn").html("Save Changes").fadeIn("fast");
        }, 1000);

        setTimeout(function(){
          getTempProduct();
          $('#modal-report').modal('hide');
        }, 2000);
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown){
      setTimeout(function(){
        $('#updatePriceBtn').attr('disabled',false);
				toast('error','Error!','','Server timeout.');
        $("#updatePriceBtn").html("Save Changes").fadeIn("fast");
      }, 100);
    },
    complete: function(XMLHttpRequest, status){ }
  });
};
