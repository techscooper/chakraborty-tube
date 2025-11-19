<?php
include '../../config.php';
if($_SERVER['REQUEST_METHOD'] == "POST"){
  if($ckadmin==1){
    $Invoice_Series=mysqli_real_escape_string($conn,$_POST['invoice_series']);
    $Refund_Serice=mysqli_real_escape_string($conn,$_POST['refund_series']);
    if ($Invoice_Series == ''){
      $return['error'] = true;
      $return['msg'] = "Please Enter invoice Name.";
      echo json_encode($return);
    }
    elseif ($Refund_Serice == ''){
      $return['error'] = true;
      $return['msg'] = "Please Enter Refund Series.";
      echo json_encode($return);
    }
    else{
      $get_serice_dtls=mysqli_query($conn, "SELECT * FROM billing_serise_tbl WHERE sl=1 and stat=1");
      if($row_serice_dtls=mysqli_fetch_array($get_serice_dtls)){
        mysqli_query($conn,"UPDATE billing_serise_tbl SET invoice_series='$Invoice_Series',refund_series='$Refund_Serice' WHERE sl=1 AND stat=1");
        $return['success'] = true;
        $return['msg'] = "Billing Series Updated  Successfully.";
        echo json_encode($return);
      }
      else{
        mysqli_query($conn,"INSERT INTO `billing_serise_tbl`(`invoice_series`, `refund_series`, `edt`, `eby`, `stat`) VALUES ('$Invoice_Series', '$Refund_Serice', '$currentDateTime', '$idadmin', '1')");
        $return['success'] = true;
        $return['msg'] = "Billing Series Submitted Successfully.";
        echo json_encode($return);
      }
    }
  }
  else{
    $return['error'] = true;
    $return['msg'] = "Server timeout, login session expired.";
    echo json_encode($return);
  }
}
else{
  header('location:../../');
  header("X-XSS-Protection: 0");
}
?>