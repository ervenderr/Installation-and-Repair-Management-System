<?php
session_start();

$id1 = $_SESSION['account_id'];
$id3 = $_SESSION['rowid'];
$id2 = $_SESSION['transaction_code'] ;

echo "id=" . $id1;
echo "id=" . $id2;
echo "id=" . $id3;
?>