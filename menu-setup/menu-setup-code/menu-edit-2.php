<?php
include '../../config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  if($ckadmin==1){
    $m_sl_m = "";
    if(isset($_POST['m_sl_m']) && $_POST['m_sl_m']!=''){
      $m_sl_m = mysqli_real_escape_string($conn,base64_decode($_POST['m_sl_m']));
    }
    $menu_nm_edt=mysqli_real_escape_string($conn,$_POST['menu_nm_edt']);
    $menu_alias_edt=mysqli_real_escape_string($conn,$_POST['menu_alias_edt']);
    $parent_menu_edt=mysqli_real_escape_string($conn,$_POST['parent_menu_edt']);
    $menu_icon_edt=mysqli_real_escape_string($conn,$_POST['menu_icon_edt']);
    $menu_link_edt=mysqli_real_escape_string($conn,$_POST['menu_link_edt']);
    $menu_rank_edt=mysqli_real_escape_string($conn,$_POST['menu_rank_edt']);
    $menu_folder_edt=mysqli_real_escape_string($conn,$_POST['menu_folder_edt']);

    $valid1=mysqli_query($conn,"SELECT * FROM menu_tbl WHERE menu_alias='$menu_alias_edt' AND stat=1 AND sl!='$m_sl_m'");
    $valid2=mysqli_query($conn,"SELECT * FROM menu_tbl WHERE menu_folder='$menu_folder_edt' AND parent_menu=0 AND stat=1 AND sl!='$m_sl_m'");

    if ($m_sl_m==''){
      $return['error'] = true;
      $return['msg'] = "Undefine error.";
      echo json_encode($return);
    }
    elseif ($menu_nm_edt==''){
      $return['error'] = true;
      $return['msg'] = "Please enter menu name.";
      echo json_encode($return);
    }
    elseif ($menu_alias_edt==''){
      $return['error'] = true;
      $return['msg'] = "Please enter menu alias.";
      echo json_encode($return);
    }
    elseif ($parent_menu_edt==''){
      $return['error'] = true;
      $return['msg'] = "Please select menu parent menu.";
      echo json_encode($return);
    }
    elseif ($menu_icon_edt=='' && $parent_menu_edt==0){
      $return['error'] = true;
      $return['msg'] = "Please enter menu icon.";
      echo json_encode($return);
    }
    elseif ($menu_link_edt==''){
      $return['error'] = true;
      $return['msg'] = "Please enter menu link.";
      echo json_encode($return);
    }
    elseif ($menu_rank_edt==''){
      $return['error'] = true;
      $return['msg'] = "Please enter menu rank.";
      echo json_encode($return);
    }
    elseif ($menu_folder_edt=='' && $parent_menu_edt==0){
      $return['error'] = true;
      $return['msg'] = "Please enter menu folder.";
      echo json_encode($return);
    }
    elseif ($row_valid1=mysqli_fetch_array($valid1)){
      $return['error'] = true;
      $return['msg'] = "Menu alias already exists.";
      echo json_encode($return);
    }
    elseif ($row_valid2=mysqli_fetch_array($valid2)){
      $return['error'] = true;
      $return['msg'] = "Folder already is a parent folder.";
      echo json_encode($return);
    }
    else{
      mysqli_query($conn,"UPDATE `menu_tbl` SET `menu_nm`='$menu_nm_edt', `menu_alias`='$menu_alias_edt', `menu_link`='$menu_link_edt', `parent_menu`='$parent_menu_edt', `menu_rank`='$menu_rank_edt', `menu_icon`='$menu_icon_edt', `menu_folder`='$menu_folder_edt' WHERE `sl`='$m_sl_m'");
      $return['success'] = true;
      $return['msg'] = "Menu updated successfully.";
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