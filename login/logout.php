<?php

    //resume session
    session_start();

    $type = $_SESSION['user_type'];
    //destroy session
    session_destroy();

    header('location: ../index.php');
    
?>