$(document).ready(function(){
$("#menu_del_btn").click(function(e) {

  e.preventDefault();
  var filter = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

  var m_sl_m_d = $('#m_sl_m_d').val();

  if (m_sl_m_d=='')
  {
    setTimeout(function(){
      swal("Error!", "Undefine error.");
    }, 100);
  }
  else
  {
    /* Button Loading */
    $('#menu_del_btn').attr('disabled',true); /*Disabled Button*/
    $("#menu_del_btn").html("<i class='fa fa-spin fa-spinner'></i> confirming...").fadeIn("fast");
    /* Submit FormData */
    var formData = new FormData($('#menu_delete_frm')[0]);
    menu_delete_frm_submit(formData);
  }
  });
});

function menu_delete_frm_submit(data)
{
  $.ajax({
    type: 'POST',
    url: 'menu-setup-code/menu-delete-2.php',
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
          $('#menu_del_btn').attr('disabled',false); /*Disabled Button*/
          swal("Error!", data.msg);
          $("#menu_del_btn").html("Confirm").fadeIn("fast");
        }, 100);
      }
      else if(data.success==true)
      {
        $("#menu_del_btn").html("<i class='fa fa-spin fa-spinner'></i> confirming...").fadeIn("fast");

        setTimeout(function(){
          swal("Good job!", data.msg, "success");
          $("#menu_del_btn").html("Confirm").fadeIn("fast");
        }, 1000);

        setTimeout(function(){
          document.location.href='';
        }, 2000);
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown){
      setTimeout(function(){
        $('#menu_del_btn').attr('disabled',false); /*Disabled Button*/
        swal("Error!", "Server timeout.");
        $("#menu_del_btn").html("Confirm").fadeIn("fast");
        }, 100);
    },
    complete: function(XMLHttpRequest, status){

    }
  });
};
