$(document).ready(function(){
$("#categoryAddBtn").click(function(e) {

  e.preventDefault();
  var filter = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

  var category_nm = $('#category_nm').val();
  if (category_nm=='')
  {
    toast('warning','Warning!','','Please Enter Category Name.');
    $('#category_nm').focus();
  }
  else
  {
    $('#categoryAddBtn').attr('disabled',true);
    $("#categoryAddBtn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");
    var formData = new FormData($('#categoryAddFrm')[0]);
    categoryAddFrm_submit(formData);
  }
  });
});

function categoryAddFrm_submit(data)
{
  $.ajax({
    type: 'POST',
    url: 'inventory-code/category-add-2.php',
    data: data,
    mimeType: "multipart/form-data",
    contentType: false,
    cache: false,
    processData: false,
    dataType: 'json',
    timeout: 0,
    success: function(data){
      if(data.error==true)
      {
        setTimeout(function(){
          $('#categoryAddBtn').attr('disabled',false);
					toast('error','Error!','',data.msg);
          $("#categoryAddBtn").html("Submit").fadeIn("fast");
        }, 100);
      }
      else if(data.success==true)
      {
        $("#categoryAddBtn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");

        setTimeout(function(){
					toast('success','Good job!','',data.msg);
          $("#categoryAddBtn").html("Submit").fadeIn("fast");
          document.location.href='';
        }, 1000);
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown){
      setTimeout(function(){
        $('#categoryAddBtn').attr('disabled',false);
				toast('error','Error!','','Server timeout.');
        $("#categoryAddBtn").html("Submit").fadeIn("fast");
      }, 100);
    },
    complete: function(XMLHttpRequest, status){ }
  });
};