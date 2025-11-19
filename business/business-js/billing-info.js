$(document).ready(function(){
    $("#billing_info_btn").click(function(e) {

      e.preventDefault();
      var filter = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

      var invoice_series = $('#invoice_series').val();
      var refund_series = $('#refund_series').val();

      if (invoice_series=='')
      {
        setTimeout(function(){
          toast('warning','Warning!','','Please Enter Invoice Series.');
        }, 100);
        $('#bank_h_nm').focus();
      }
      else if (refund_series=='')
      {
        setTimeout(function(){
          toast('warning','Warning!','','Please Enter Refund Series.');
        }, 100);
      }
      else
      {
        $('#billing_info_btn').attr('disabled',true);
        $("#billing_info_btn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");
        var formData = new FormData($('#billing_info_frm')[0]);
        billing_info_frm_submit(formData);
      }
      });
    });

    function billing_info_frm_submit(data)
    {
      $.ajax({
        type: 'POST',
        url: 'business-code/billing-series2.php',
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
              $('#billing_info_btn').attr('disabled',false);
                        toast('error','Error!','',data.msg);
              $("#billing_info_btn").html("Confirm").fadeIn("fast");
            }, 100);
          }
          else if(data.success==true)
          {
            $("#billing_info_btn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");

            setTimeout(function(){
                        toast('success','Good job!','',data.msg);
              $("#billing_info_btn").html("Confirm").fadeIn("fast");
            }, 1000);

            setTimeout(function(){
              document.location.href='';
            }, 2000);
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown){
          setTimeout(function(){
            $('#billing_info_btn').attr('disabled',false);		/*Disabled Button*/
                    toast('error','Error!','','Server timeout.');
            $("#billing_info_btn").html("Confirm").fadeIn("fast");
          }, 100);
        },
        complete: function(XMLHttpRequest, status){

        }
      });
    };
