$(document).ready(function(){
    $("#bank_info_edt_btn").click(function(e) {

      e.preventDefault();
      var filter = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

      var bank_h_nm_e = $('#bank_h_nm_e').val();
      var bank_nm_e = $('#bank_nm_e').val();
      var bank_ac_no_e = $('#bank_ac_no_e').val();
      var branch_nm_e = $('#branch_nm_e').val();
      var ifsc_code_e = $('#ifsc_code_e').val();
      var bank_info_unq_id = $('#bank_info_unq_id').val();


      if (bank_h_nm_e=='')
      {
        setTimeout(function(){
          toast('warning','Warning!','','Please Enter Bank Holder Name.');
        }, 100);
        $('#customer_nm').focus();
      }
      else if (bank_nm_e=='')
      {
        setTimeout(function(){
          toast('warning','Warning!','','Please Enter Bank Name.');
        }, 100);
      }
      else if (bank_ac_no_e=='')
      {
        setTimeout(function(){
          toast('warning','Warning!','','Please Enter Banck Acount Number.');
        }, 100);
      }
      else if (branch_nm_e=='')
      {
        setTimeout(function(){
          toast('warning','Warning!','','Please Enter Branch Name.');
        }, 100);
      }
      else if (ifsc_code_e=='')
      {
        setTimeout(function(){
          toast('warning','Warning!','','Please Enter Ifsc Code.');
        }, 100);
      }
      else if (bank_info_unq_id=='')
      {
        setTimeout(function(){
          toast('warning','Warning!','','');
        }, 100);
      }
      else
      {
        /* Button Loading */
        $('#bank_info_edt_btn').attr('disabled',true); /*Disabled Button*/
        $("#bank_info_edt_btn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");
        /* Submit FormData */
        var formData = new FormData($('#bank_info_edt_frm')[0]);
        bank_info_edt_frm_submit(formData);
      }
      });
    });

    function bank_info_edt_frm_submit(data)
    {
      $.ajax({
        type: 'POST',
        url: 'business-code/bank-info-edit-2.php',
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
              $('#bank_info_edt_btn').attr('disabled',false);		/*Disabled Button*/
                        toast('error','Error!','',data.msg);
              $("#bank_info_edt_btn").html("Confirm").fadeIn("fast");
            }, 100);
          }
          else if(data.success==true)
          {
            $("#bank_info_edt_btn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");

            setTimeout(function(){
                toast('success','Good job!','',data.msg);
              $("#bank_info_edt_btn").html("Confirm").fadeIn("fast");
            }, 1000);

            setTimeout(function(){
              document.location.href='';
            }, 2000);
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown){
          setTimeout(function(){
            $('#bank_info_edt_btn').attr('disabled',false);		/*Disabled Button*/
                    toast('error','Error!','','Server timeout.');
            $("#bank_info_edt_btn").html("Confirm").fadeIn("fast");
          }, 100);
        },
        complete: function(XMLHttpRequest, status){

        }
      });
    };
