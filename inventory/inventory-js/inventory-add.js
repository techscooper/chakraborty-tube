$(document).ready(function(){
  $("#addInventoryBtn").on("click", function(e) {
    e.preventDefault();

    var category_id = $('#category_id').val();
    var product_name = $('#product_name').val(); // keep in outer scope for success handler
    var unit_id = $('#unit_id').val();
    var purchase_rate = $('#purchase_rate').val();
    var sale_rate = $('#sale_rate').val();

    if (category_id === ''){
      toast('warning','Warning!','','Please select category');
      $('#category_id').focus();
      return;
    }
    if (product_name === ''){
      toast('warning','Warning!','','Please enter product name');
      $('#product_name').focus();
      return;
    }
    if (unit_id === ''){
      toast('warning','Warning!','','Please select product unit');
      $('#unit_id').focus();
      return;
    }
    if (purchase_rate === ''){
      toast('warning','Warning!','','Please enter purchase rate');
      $('#purchase_rate').focus();
      return;
    }
    if (sale_rate === ''){
      toast('warning','Warning!','','Please enter sale rate');
      $('#sale_rate').focus();
      return;
    }

    $('#addInventoryBtn').attr('disabled', true).html("<i class='fa fa-spin fa-spinner'></i> Please wait...");

    var formData = new FormData($('#addInventoryFrm')[0]);
    addInventoryFrm_submit(formData, product_name);
  });
});

function addInventoryFrm_submit(formData, product_name){
  $.ajax({
    type: 'POST',
    url: '../inventory/inventory-code/inventory-add-2.php',
    data: formData,
    mimeType: "multipart/form-data",
    contentType: false,
    cache: false,
    processData: false,
    dataType: 'json',
    timeout: 0,
    success: function(resp){
      if (resp && resp.error === true){
        setTimeout(function(){
          toast('error','Error!','', resp.msg || 'Unknown error');
          $('#addInventoryBtn').attr('disabled', false).html("Confirm");
        }, 100);
        return;
      }

      if (resp && resp.success === true){
        $("#addInventoryBtn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...");
        setTimeout(function(){
          toast('success','Good job!','', resp.msg || 'Saved');
          $("#addInventoryBtn").html("Confirm");
        }, 1000);

        // Prefer product_name from response if provided
        var newProductName = (resp.product_name && resp.product_name.trim()) ? resp.product_name : product_name;

        // Detect opener safely and ensure same-origin
        var hasOpener = !!window.opener && !window.opener.closed;
        var canAccessOpener = false;
        try {
          // Accessing location.href will throw if cross-origin
          if (hasOpener) { void window.opener.location.href; canAccessOpener = true; }
        } catch (e) {
          canAccessOpener = false;
        }

        setTimeout(function(){
          if (hasOpener && canAccessOpener) {
            var divProductList = window.opener.document.getElementById("divProductList");

            if (divProductList) {
              // If the parent window exposes a refresh function, call it there
              if (typeof window.opener.getProduct === 'function') {
                window.opener.getProduct(); // refresh product list in parent
              }

              // Close modal in current window if present
              if ($('#modal-report').length) {
                $('#modal-report').modal('hide');
              }

              setTimeout(function(){
                // Focus and set product in parent if element exists
                var productSrcInput = window.opener.document.getElementById("product_src");
                if (productSrcInput) {
                  productSrcInput.value = newProductName || '';
                  productSrcInput.focus();
                  window.opener.getProduct();
                }
              }, 1500);
            } else {
              // Element not found in parent; fallback to redirect
              document.location.href = 'inventory-list.php';
            }
          }
          else {
            // Not opened as popup or cross-origin; handle in current window
            var divProductListCurrent = document.getElementById("divProductList");
            if (divProductListCurrent && typeof window.getProduct === 'function') {
              window.getProduct(); // refresh in current window
              if ($('#modal-report').length) {
                $('#modal-report').modal('hide');
              }
              setTimeout(function(){
                var productSrcCurrent = document.getElementById("product_src");
                if (productSrcCurrent) {
                  productSrcCurrent.value = newProductName || '';
                  productSrcCurrent.focus();
                  window.getProduct();
                }
              }, 1500);
            } else {
              // As a last resort, go to inventory list
              document.location.href = 'inventory-list.php';
            }
          }
        }, 1000);
      }
    },
    error: function(){
      setTimeout(function(){
        toast('error','Error!','','Server timeout.');
        $('#addInventoryBtn').attr('disabled', false).html("Confirm");
      }, 100);
    }
  });
}