$(document).ready(function(){
$("#create_menu_btn").click(function(e) {

  e.preventDefault();
  var filter = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

  var menu_nm = $('#menu_nm').val();
  var parent_menu = $('#parent_menu').val();
  var menu_alias = $('#menu_alias').val();
  var menu_folder = $('#menu_folder').val();
  var menu_icon = $('#menu_icon').val();
  var menu_link = $('#menu_link').val();
  var menu_rank = $('#menu_rank').val();

  if (menu_nm=='')
  {
    setTimeout(function(){
      toast('warning','Warning!','','Please enter menu name.');
    }, 100);
    $('#menu_nm').focus();
  }
  else if (parent_menu=='')
  {
    setTimeout(function(){
      toast('warning','Warning!','','Please select parrent menu.');
    }, 100);
  }
  else if (menu_alias=='')
  {
    setTimeout(function(){
      toast('warning','Warning!','','Please enter menu alias.');
    }, 100);
  }
  else if (menu_folder=='' && parent_menu==0)
  {
    setTimeout(function(){
      toast('warning','Warning!','','Please enter menu folder name.');
    }, 100);
  }
  else if (menu_icon=='' && parent_menu==0)
  {
    setTimeout(function(){
      toast('warning','Warning!','','Please enter menu icon.');
    }, 100);
  }
  else if (menu_link=='')
  {
    setTimeout(function(){
      toast('warning','Warning!','','Please enter menu link.');
    }, 100);
  }
  else if (menu_rank=='')
  {
    setTimeout(function(){
      toast('warning','Warning!','','Please enter menu rank.');
    }, 100);
  }
  else
  {
    /* Button Loading */
    $('#create_menu_btn').attr('disabled',true); /*Disabled Button*/
    $("#create_menu_btn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");
    /* Submit FormData */
    var formData = new FormData($('#menu_create_frm')[0]);
    menu_create_frm_submit(formData);
  }
  });
});

function menu_create_frm_submit(data)
{
  $.ajax({
    type: 'POST',
    url: 'menu-setup-code/create-menu-2.php',
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
          $('#create_role_btn').attr('disabled',false);		/*Disabled Button*/
					toast('error','Error!','',data.msg);
          $("#create_role_btn").html("Confirm").fadeIn("fast");
        }, 100);
      }
      else if(data.success==true)
      {
        $("#create_role_btn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");

        setTimeout(function(){
					toast('success','Good job!','',data.msg);
          $("#create_role_btn").html("Confirm").fadeIn("fast");
        }, 1000);

        setTimeout(function(){
          document.location.href='';
        }, 2000);
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown){
      setTimeout(function(){
        $('#create_role_btn').attr('disabled',false);		/*Disabled Button*/
				toast('error','Error!','','Server timeout.');
        $("#create_role_btn").html("Confirm").fadeIn("fast");
      }, 100);
    },
    complete: function(XMLHttpRequest, status){

    }
  });
};
