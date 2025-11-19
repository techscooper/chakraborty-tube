$(document).ready(function(){
$("#menu_edt_btn").click(function(e) {

  e.preventDefault();
  var filter = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

  var m_sl_m = $('#m_sl_m').val();
  var menu_nm_edt = $('#menu_nm_edt').val();
  var parent_menu_edt = $('#parent_menu_edt').val();
  var menu_alias_edt = $('#menu_alias_edt').val();
  var menu_folder_edt = $('#menu_folder_edt').val();
  var menu_icon_edt = $('#menu_icon_edt').val();
  var menu_link_edt = $('#menu_link_edt').val();
  var menu_rank_edt = $('#menu_rank_edt').val();

  if (m_sl_m=='')
  {
    setTimeout(function(){
      swal("Error!", "Undefine error.");
    }, 100);
  }
  else if (menu_nm_edt=='')
  {
    setTimeout(function(){
      swal("Error!", "Please enter menu name.");
    }, 100);
  }
  else if (parent_menu_edt=='')
  {
    setTimeout(function(){
      swal("Error!", "Please select parrent menu.");
    }, 100);
  }
  else if (menu_alias_edt=='')
  {
    setTimeout(function(){
      swal("Error!", "Please enter menu alias.");
    }, 100);
  }
  else if (menu_folder_edt=='' && parent_menu_edt==0)
  {
    setTimeout(function(){
      swal("Error!", "Please enter menu folder name.");
    }, 100);
  }
  else if (menu_icon_edt=='' && parent_menu_edt==0)
  {
    setTimeout(function(){
      swal("Error!", "Please enter menu icon.");
    }, 100);
  }
  else if (menu_link_edt=='')
  {
    setTimeout(function(){
      swal("Error!", "Please enter menu link.");
    }, 100);
  }
  else if (menu_rank_edt=='')
  {
    setTimeout(function(){
      swal("Error!", "Please enter menu rank.");
    }, 100);
  }
  else
  {
    /* Button Loading */
    $('#menu_edt_btn').attr('disabled',true); /*Disabled Button*/
    $("#menu_edt_btn").html("<i class='fa fa-spin fa-spinner'></i> Saving...").fadeIn("fast");
    /* Submit FormData */
    var formData = new FormData($('#menu_update_frm')[0]);
    menu_update_frm_submit(formData);
  }
  });
});

function menu_update_frm_submit(data)
{
  $.ajax({
    type: 'POST',
    url: 'menu-setup-code/menu-edit-2.php',
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
          $('#menu_edt_btn').attr('disabled',false); /*Disabled Button*/
          swal("Error!", data.msg);
          $("#menu_edt_btn").html("Save Changes").fadeIn("fast");
        }, 100);
      }
      else if(data.success==true)
      {
        $("#menu_edt_btn").html("<i class='fa fa-spin fa-spinner'></i> Saving...").fadeIn("fast");

        setTimeout(function(){
          swal("Good job!", data.msg, "success");
          $("#menu_edt_btn").html("Save Changes").fadeIn("fast");
        }, 1000);

        setTimeout(function(){
          document.location.href='';
        }, 2000);
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown){
      setTimeout(function(){
        $('#menu_edt_btn').attr('disabled',false); /*Disabled Button*/
          swal("Error!", "Server timeout.");
          $("#menu_edt_btn").html("Save Changes").fadeIn("fast");
        }, 100);
    },
    complete: function(XMLHttpRequest, status){

    }
  });
};
