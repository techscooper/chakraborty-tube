<?php
include '../../config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  if($ckadmin==1){
    $menu_nm=mysqli_real_escape_string($conn,$_POST['menu_nm']);
    $menu_alias=mysqli_real_escape_string($conn,$_POST['menu_alias']);
    $parent_menu=mysqli_real_escape_string($conn,$_POST['parent_menu']);
    $menu_icon=mysqli_real_escape_string($conn,$_POST['menu_icon']);
    $menu_link=mysqli_real_escape_string($conn,$_POST['menu_link']);
    $menu_rank=mysqli_real_escape_string($conn,$_POST['menu_rank']);
    $menu_folder=mysqli_real_escape_string($conn,$_POST['menu_folder']);

    $valid1=mysqli_query($conn,"SELECT * FROM `menu_tbl` WHERE `menu_alias`='$menu_alias' AND `stat`=1");
    $valid2=mysqli_query($conn,"SELECT * FROM `menu_tbl` WHERE `menu_folder`='$menu_folder' AND `parent_menu`=0 AND `stat`=1");

    if ($menu_nm==''){
      $return['error'] = true;
      $return['msg'] = "Please enter menu name.";
      echo json_encode($return);
    }
    elseif ($menu_alias==''){
      $return['error'] = true;
      $return['msg'] = "Please enter menu alias.";
      echo json_encode($return);
    }
    elseif ($parent_menu==''){
      $return['error'] = true;
      $return['msg'] = "Please select menu parent menu.";
      echo json_encode($return);
    }
    elseif ($menu_icon=='' && $parent_menu==0){
      $return['error'] = true;
      $return['msg'] = "Please enter menu icon.";
      echo json_encode($return);
    }
    elseif ($menu_link==''){
      $return['error'] = true;
      $return['msg'] = "Please enter menu link.";
      echo json_encode($return);
    }
    elseif ($menu_rank==''){
      $return['error'] = true;
      $return['msg'] = "Please enter menu rank.";
      echo json_encode($return);
    }
    elseif ($menu_folder=='' && $parent_menu==0){
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
      mysqli_query($conn,"INSERT INTO `menu_tbl` (`menu_nm`, `menu_alias`, `menu_link`, `parent_menu`, `menu_rank`, `menu_icon`, `menu_folder`, `edt`, `eby`, `menu_lvl`, `stat`) VALUES('$menu_nm', '$menu_alias', '$menu_link', '$parent_menu', '$menu_rank', '$menu_icon', '$menu_folder', '$currentDateTime', '$idadmin', '1', '1')");
      $return['success'] = true;
      $return['msg'] = "Menu created successfully.";
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