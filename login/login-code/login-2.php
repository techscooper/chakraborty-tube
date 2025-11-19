<?php
include '../../config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  if ($ckadmin == 0) {
    if (isset($_POST['signin_username'],$_POST['signin_password']) && $_POST['signin_username']!='' && $_POST['signin_password']!='') {
      $username = mysqli_real_escape_string($conn,$_POST['signin_username']);
      $password = mysqli_real_escape_string($conn,$_POST['signin_password']);
      $signin_captcha = mysqli_real_escape_string($conn,$_POST['signin_captcha']);
      if ($password == '') {
        $return['error'] = true;
        $return['msg'] = "Please enter password.";
        echo json_encode($return);
      }
      elseif ($signin_captcha == '') {
        $return['error'] = true;
        $return['msg'] = "Please enter captcha.";
        echo json_encode($return);
      }
      else {
        $userCaptchaAuth = mysqli_query($conn,"SELECT * FROM `session_robot_checker` WHERE BINARY `captcha`='$signin_captcha' AND `session_id`='$sessionIDGet' AND `stat`=1");
        if ($rowuserCaptchaAuth = mysqli_fetch_array($userCaptchaAuth)) {
					$userAuth = mysqli_query($conn,"SELECT * FROM `login_tbl` WHERE BINARY `u_id` = '$username'");
          if ($rowUserAuth = mysqli_fetch_array($userAuth)){
            $accountActiveStat = $rowUserAuth['stat'];
            $userPasswordHash = $rowUserAuth['pass'];
            if ($accountActiveStat == 1) {
              if (password_verify($password,$userPasswordHash)) {
                $userLevel = $rowUserAuth['lvl'];
                $userID = $rowUserAuth['u_id'];
                $userFullName = $rowUserAuth['full_nm'];
                /*Update Last Login Time*/
                mysqli_query($conn,"UPDATE `login_tbl` SET `llg_in`='$currentDateTime' WHERE `u_id`='$userID'");
                /*API Token Generation*/
                aa:
                $unq_id_unique = date("Y").mt_rand();
                $check_uid = mysqli_query($conn,"SELECT * FROM `login_api_keys` WHERE `unq_id`='$unq_id_unique'");
                if ($row_check_uid = mysqli_fetch_array($check_uid)){
                  goto aa;
                }
                else{
                  session_regenerate_id();
                  $sessionIDGet = session_id();
                  $tokenAPIKey = openssl_random_pseudo_bytes(128);
                  $tokenAPIKey = bin2hex($tokenAPIKey);
                  $iptocheck = $_SERVER['REMOTE_ADDR'];
                  $iptocheck = mysqli_real_escape_string($conn,$iptocheck);
                  mysqli_query($conn,"INSERT INTO `login_api_keys`(`sl`, `unq_id`, `session_id`, `user_id`, `api_key`, `generation_dt_tm`, `user_ip_addr`, `user_agent`, `stat`) VALUES (NULL,'$unq_id_unique','$sessionIDGet','$userID','$tokenAPIKey','$currentDateTime','$iptocheck','$userAgentBrowser','1')");
                }
                if (isset($_POST['keep_me_login'])){
                  setcookie( "apiTokenKey", $tokenAPIKey, time() + (86400 * 30), "/", "crm.siparadigm.com", isset($_SERVER["HTTPS"]), true);
                }
                $_SESSION["apiKey"] = $tokenAPIKey;
                $_SESSION["LAST_ACTIVITY"] = time();

                mysqli_query($conn,"UPDATE `session_robot_checker` SET `stat`='0' WHERE `session_id`='$sessionIDGet'");

                $return['success'] = true;
                $return['msg'] = "Sign In Successfully.";
                echo json_encode($return);
              }
              else {
                $userID = $rowUserAuth['u_id'];
                $iptocheck = $_SERVER['REMOTE_ADDR'];
                mysqli_query($conn,"INSERT INTO `login_fail_tbl` (`sl`, `username`, `session_id`, `user_ip_addr`, `date_time`, `stat`) VALUES (NULL, '$userID', '$sessionIDGet', '$iptocheck', '$currentDateTime', '1')");
                $userFail = mysqli_query($conn,"SELECT * FROM `login_fail_tbl` WHERE `username` = '$userID' AND `stat` = 1");
                if(mysqli_num_rows($userFail)>=5){
                  mysqli_query($conn,"UPDATE `login_tbl` SET `stat`=0 WHERE `u_id`='$userID'");
                }

                $return['error'] = true;
                $return['msg'] = "Invalid Username or Password!";
                echo json_encode($return);
              }
            }
            else {
              $smgMore = "";
              $diffTimeInSeconds = 0;
              $userID = $rowUserAuth['u_id'];
              $userFailGet = mysqli_query($conn,"SELECT * FROM `login_fail_tbl` WHERE `username` = '$userID' AND `stat` = 1 ORDER BY sl DESC LIMIT 1");
              if($userFailRow = mysqli_fetch_array($userFailGet)){
                $userFailDateTime = $userFailRow['date_time'];
                $diffTimeInSeconds=abs(strtotime($currentDateTime) - strtotime($userFailDateTime));
                $deactivTime = getRemainingTime($userFailDateTime);
                $smgMore = " for $deactivTime";
              }

              if ($diffTimeInSeconds >= 14400) {
                mysqli_query($conn,"UPDATE `login_tbl` SET `stat`=1 WHERE `u_id`='$userID'");
                mysqli_query($conn,"UPDATE `login_fail_tbl` SET `stat`=0 WHERE `username`='$userID'");
              }

              $return['error'] = true;
              $return['msg'] = "Your Account Deactivated$smgMore!";
              echo json_encode($return);
            }
          }
          else {
            $return['error'] = true;
            $return['msg'] = "Invalid Username or Password!";
            echo json_encode($return);
          }
        }
        else {
          $return['error'] = true;
          $return['msg'] = "Captcha Is Invalid!";
          echo json_encode($return);
        }
      }
    }
    else {
      $return['error'] = true;
      $return['msg'] = "Please Enter Username.";
      echo json_encode($return);
    }
  }
}
else {
  header('location:../login');
  header("X-XSS-Protection: 0");
}
?>
