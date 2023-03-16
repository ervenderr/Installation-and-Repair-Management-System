<?php
header('Content-Type: application/json');
session_start();

require_once '../homeIncludes/dbconfig.php';

$sql_repair = "SELECT MONTH(date_completed) as month, SUM(payment) as total_payment FROM rprq WHERE YEAR(date_completed) = YEAR(CURDATE()) GROUP BY MONTH(date_completed)";
$sql_service = "SELECT MONTH(date_completed) as month, SUM(payment) as total_payment FROM service_request WHERE YEAR(date_completed) = YEAR(CURDATE()) GROUP BY MONTH(date_completed)";

$result_repair = $conn->query($sql_repair);
$result_service = $conn->query($sql_service);

$sales_data = array();

for ($i = 1; $i <= 12; $i++) {
    $sales_data[$i] = array('repair' => 0, 'service' => 0);
}

if ($result_repair->num_rows > 0) {
    while ($row = $result_repair->fetch_assoc()) {
        $sales_data[intval($row['month'])]['repair'] = floatval($row['total_payment']);
    }
}

if ($result_service->num_rows > 0) {
    while ($row = $result_service->fetch_assoc()) {
        $sales_data[intval($row['month'])]['service'] = floatval($row['total_payment']);
    }
}

echo json_encode($sales_data);

$conn->close();
?>
