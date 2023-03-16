<?php
header('Content-Type: application/json');
session_start();

require_once '../homeIncludes/dbconfig.php';

$sql_repair = "SELECT WEEK(date_completed, 1) as week, SUM(payment) as total_payment FROM rprq WHERE YEAR(date_completed) = YEAR(CURDATE()) GROUP BY WEEK(date_completed, 1)";
$sql_service = "SELECT WEEK(date_completed, 1) as week, SUM(payment) as total_payment FROM service_request WHERE YEAR(date_completed) = YEAR(CURDATE()) GROUP BY WEEK(date_completed, 1)";

$result_repair = $conn->query($sql_repair);
$result_service = $conn->query($sql_service);

$sales_data = array();

for ($i = 1; $i <= 53; $i++) {
    $sales_data[$i] = array('repair' => 0, 'service' => 0);
}

if ($result_repair->num_rows > 0) {
    while ($row = $result_repair->fetch_assoc()) {
        $sales_data[intval($row['week'])]['repair'] = floatval($row['total_payment']);
    }
}

if ($result_service->num_rows > 0) {
    while ($row = $result_service->fetch_assoc()) {
        $sales_data[intval($row['week'])]['service'] = floatval($row['total_payment']);
    }
}

echo json_encode($sales_data);

$conn->close();
?>
