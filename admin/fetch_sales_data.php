<?php
header('Content-Type: application/json');
session_start();

require_once '../homeIncludes/dbconfig.php';

$timeFilter = isset($_GET['timeFilter']) ? $_GET['timeFilter'] : 'monthly';

if ($timeFilter === 'yearly') {
    // Yearly data code
    $sql_repair = "SELECT YEAR(date_completed) as year, SUM(payment) as total_payment FROM rprq GROUP BY YEAR(date_completed)";
    $sql_service = "SELECT YEAR(date_completed) as year, SUM(payment) as total_payment FROM service_request GROUP BY YEAR(date_completed)";
  
    $result_repair = $conn->query($sql_repair);
    $result_service = $conn->query($sql_service);
  
    $current_year = date('Y');
    $years_range = range($current_year - 9, $current_year);
    $sales_data = array();
  
    foreach ($years_range as $year) {
      $sales_data[$year] = array('repair' => 0, 'service' => 0);
    }
  
    if ($result_repair->num_rows > 0) {
      while ($row = $result_repair->fetch_assoc()) {
        $sales_data[intval($row['year'])]['repair'] = floatval($row['total_payment']);
      }
    }
  
    if ($result_service->num_rows > 0) {
      while ($row = $result_service->fetch_assoc()) {
        $sales_data[intval($row['year'])]['service'] = floatval($row['total_payment']);
      }
    }

}elseif ($timeFilter === 'weekly') {
    // Weekly data code
    $sql_repair = "SELECT DAYOFWEEK(date_completed) as day, SUM(payment) as total_payment FROM rprq WHERE YEARWEEK(date_completed) = YEARWEEK(CURDATE()) GROUP BY DAYOFWEEK(date_completed)";
    $sql_service = "SELECT DAYOFWEEK(date_completed) as day, SUM(payment) as total_payment FROM service_request WHERE YEARWEEK(date_completed) = YEARWEEK(CURDATE()) GROUP BY DAYOFWEEK(date_completed)";

    $result_repair = $conn->query($sql_repair);
    $result_service = $conn->query($sql_service);

    $sales_data = array();

    for ($i = 1; $i <= 7; $i++) {
        $sales_data[$i] = array('repair' => 0, 'service' => 0);
    }

    if ($result_repair->num_rows > 0) {
        while ($row = $result_repair->fetch_assoc()) {
            $index = $row['day'] == 1 ? 7 : intval($row['day']) - 1;
            $sales_data[$index]['repair'] = floatval($row['total_payment']);
        }
    }

    if ($result_service->num_rows > 0) {
        while ($row = $result_service->fetch_assoc()) {
            $index = $row['day'] == 1 ? 7 : intval($row['day']) - 1;
            $sales_data[$index]['service'] = floatval($row['total_payment']);
        }
    }

} else {
    // Monthly data code
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
}

echo json_encode($sales_data);

$conn->close();
?>