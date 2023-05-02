<?php
session_start();
require_once '../homeIncludes/dbconfig.php';

if(isset($_GET['verify_email'])){
    $token = $_GET['verify_email'];
    $verify_query = "SELECT verify_token,verify_status  FROM accounts WHERE verify_token='$token' LIMIT 1";
    $verify_query_run = mysqli_query($conn, $verify_query);

    if(mysqli_num_rows($verify_query_run) > 0){
        $row = mysqli_fetch_array($verify_query_run);
        if($row['verify_status'] == "0"){ 
            $clicked_token = $row['verify_token'];
            $update_query = "UPDATE accounts SET verify_status='1' WHERE verify_token='$clicked_token' LIMIT 1";
            $update_query_run = mysqli_query($conn, $update_query);

            if($update_query_run){
                $_SESSION['msg'] = "Your account has been verified successfully.";
                header("Location: login.php");
                exit(0);

            }else{
                $_SESSION['msg'] = "Verification failed";
                header("Location: login.php");
                exit(0);
            }

        }else{
            $_SESSION['msg'] = "Email is already verified";
            header("Location: login.php");
            exit(0);
        }

    }else{
        $_SESSION['msg'] = "Token not found";
        header("Location: login.php");
    }

}else{
    $_SESSION['msg'] = "Not verified";
    header("Location: login.php");
}

?>