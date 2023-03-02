<?php
session_start();
require_once '../homeIncludes/dbconfig.php';

$query = "SELECT * FROM invoice
JOIN rprq ON invoice.invoice_id = rprq.invoice_id
JOIN customer ON rprq.cust_id = customer.cust_id
WHERE invoice.invoice_id = '{$_GET['invoice_id']}'";

$res=$conn->query($query);
if ($res->num_rows > 0){
  $row=$res->fetch_assoc();
  $info=[
    "customer"=>$row["fname"]." ".$row["lname"],
    "address"=>$row["address"],
    "phone"=>$row["phone"],
    "invoice_no"=>$row["invoice_no"],
    "invoice_date"=>$row["invoice_date"],
    "total_amt"=>$row["grand_total"],
  ];
}
echo $row["fname"]." ".$row["lname"];
echo $row["address"];
echo $row["phone"];
echo $row["invoice_no"];
echo $row["invoice_date"];
echo $row["grand_total"];