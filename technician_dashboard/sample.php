<?php

session_start();

$logged_id = $_SESSION['logged_id'];

echo $logged_id;