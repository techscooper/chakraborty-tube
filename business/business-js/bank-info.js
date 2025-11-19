$(document).ready(function(){
  $("#bank_info_btn").click(function(e) {
    e.preventDefault();
    var filter = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    var bank_h_nm = $('#bank_h_nm').val();
    var bank_nm = $('#bank_nm').val();
    var bank_ac_no = $('#bank_ac_no').val();
    var branch_nm = $('#branch_nm').val();
    var ifsc_code = $('#ifsc_code').val();
    if (bank_h_nm==''){
      toast('warning','Warning!','','Please Enter Bank Holder Name.');
      $('#bank_h_nm').focus();
    }
    else if (bank_nm==''){
      toast('warning','Warning!','','Please Enter Bank Name.');
      $('#bank_nm').focus();
    }
    else if (bank_ac_no==''){
      toast('warning','Warning!','','Please Enter Bank A/C Number.');
      $('#bank_ac_no').focus();
    }
    else if (branch_nm==''){
      toast('warning','Warning!','','Please Enter Branch Name.');
      $('#branch_nm').focus();
    }
    else if (ifsc_code==''){
      toast('warning','Warning!','','Please Enter IFSC Code.');
      $('#ifsc_code').focus();
    }
    else{
      $('#bank_info_btn').attr('disabled',true);
      $("#bank_info_btn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");
      var formData = new FormData($('#bank_info_frm')[0]);
      bank_info_frm_submit(formData);
    }
  });
});

function bank_info_frm_submit(data) {
  $.ajax({
    type: 'POST',
    url: 'business-code/bank-info-2.php',
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
          $('#bank_info_btn').attr('disabled',false);
					toast('error','Error!','',data.msg);
          $("#bank_info_btn").html("Confirm").fadeIn("fast");
        }, 100);
      }
      else if(data.success==true){
        $("#bank_info_btn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").fadeIn("fast");
        setTimeout(function(){
					toast('success','Good job!','',data.msg);
          $("#bank_info_btn").html("Confirm").fadeIn("fast");
          document.location.href='';
        }, 1000);
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown){
      setTimeout(function(){
        $('#bank_info_btn').attr('disabled',false);
				toast('error','Error!','','Server timeout.');
        $("#bank_info_btn").html("Confirm").fadeIn("fast");
      }, 100);
    },
    complete: function(XMLHttpRequest, status){ }
  });
};