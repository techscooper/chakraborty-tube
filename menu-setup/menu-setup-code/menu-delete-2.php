<?php
include '../../config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  if($ckadmin==1){
    $m_sl_m = "";
    if (isset($_POST['m_sl_m_d']) && $_POST['m_sl_m_d']!=''){
      $m_sl_m=mysqli_real_escape_string($conn,base64_decode($_POST['m_sl_m_d']));
    }
    if ($m_sl_m==''){
      $return['error'] = true;
      $return['msg'] = "Undefine error.";
      echo json_encode($return);
    }
    else{
      mysqli_query($conn,"UPDATE `menu_tbl` SET `stat`=0 WHERE `sl`='$m_sl_m'");
      $return['success'] = true;
      $return['msg'] = "Menu deleted successfully.";
      echo json_encode($return);
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