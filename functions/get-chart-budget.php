<?php
include_once 'connection.php';
header('Access-Control-Allow-Origin: *');

// Get the raw POST data
$postData = file_get_contents('php://input');

// Decode the JSON data
$request = json_decode($postData, true);

// Retrieve the values from the decoded JSON data
$start_date = $request['start_date'];
$end_date = $request['end_date'];
$project_id = $request['budget_id'];

$sql = "SELECT YEAR(created_at) AS year, MONTH(created_at) AS month, SUM(fund) AS total_fund
        FROM project_fund
        WHERE created_at BETWEEN :start_date AND :end_date AND project_id = :project_id
        GROUP BY YEAR(created_at), MONTH(created_at)
        ORDER BY YEAR(created_at), MONTH(created_at)";

$stmt = $db->prepare($sql);
$stmt->bindParam(':start_date', $start_date);
$stmt->bindParam(':end_date', $end_date);
$stmt->bindParam(':project_id', $project_id);
$stmt->execute();

$labels = [];
$data = [];
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $monthName = date("M", mktime(0, 0, 0, $row['month'], 10));
    $labels[] = $monthName . ' ' . $row['year'];
    $data[] = $row['total_fund'];
}

$chartData = [
    'labels' => $labels,
    'datasets' => [
        [
            'label' => 'Population',
            'fill' => true,
            'data' => $data,
            'backgroundColor' => 'rgba(78, 115, 223, 0.05)',
            'borderColor' => 'rgba(78, 115, 223, 1)'
        ]
    ]
];

$chartDataJson = json_encode($chartData);
echo $chartDataJson;  // Send the JSON response back to the client
?>
