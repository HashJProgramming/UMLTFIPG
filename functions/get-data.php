<?php
include_once 'connection.php';

function get_female(){
    global $db;
    $sql = "SELECT COUNT(id) AS total 
    FROM residents 
    WHERE sex = 'Female'";
    $statement = $db->prepare($sql);
    $statement->execute();
    $result = $statement->fetch();
    return $result['total'] ?? 0;
}

function get_male(){
    global $db;
    $sql = "SELECT COUNT(id) AS total 
    FROM residents 
    WHERE sex = 'Male'";
    $statement = $db->prepare($sql);
    $statement->execute();
    $result = $statement->fetch();
    return $result['total'] ?? 0;
}

function get_residents(){
    global $db;
    $sql = "SELECT COUNT(id) AS total 
    FROM residents";
    $statement = $db->prepare($sql);
    $statement->execute();
    $result = $statement->fetch();
    return $result['total'] ?? 0;
}

function get_projects(){
    global $db;
    $sql = "SELECT COUNT(id) AS total 
    FROM projects ";
    $statement = $db->prepare($sql);
    $statement->execute();
    $result = $statement->fetch();
    return $result['total'] ?? 0;
}

function population_month_chart(){
    global $db;
    $sql = "SELECT YEAR(created_at) AS year, MONTH(created_at) AS month, COUNT(id) AS total_residents
    FROM residents
    GROUP BY YEAR(created_at), MONTH(created_at)
    ORDER BY YEAR(created_at), MONTH(created_at)";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    $labels = [];
    $data = [];
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $monthName = date("M", mktime(0, 0, 0, $row['month'], 10));
    $labels[] = $monthName . ' ' . $row['year'];
    $data[] = $row['total_residents'];
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
    ?>
    <canvas data-bss-chart='{"type":"line","data":<?php echo $chartDataJson; ?>,"options":{"maintainAspectRatio":false,"legend":{"display":false,"labels":{"fontStyle":"normal"}},"title":{"fontStyle":"normal"},"scales":{"xAxes":[{"gridLines":{"color":"rgb(234, 236, 244)","zeroLineColor":"rgb(234, 236, 244)","drawBorder":false,"drawTicks":false,"borderDash":["2"],"zeroLineBorderDash":["2"],"drawOnChartArea":false},"ticks":{"fontColor":"#858796","fontStyle":"normal","padding":20}}],"yAxes":[{"gridLines":{"color":"rgb(234, 236, 244)","zeroLineColor":"rgb(234, 236, 244)","drawBorder":false,"drawTicks":false,"borderDash":["2"],"zeroLineBorderDash":["2"]},"ticks":{"fontColor":"#858796","fontStyle":"normal","padding":20}}]}}}'></canvas>
    <?php
}

function male_month_chart(){
    global $db;
    $sql = "SELECT YEAR(created_at) AS year, MONTH(created_at) AS month, COUNT(id) AS total_residents
    FROM residents
    WHERE sex = 'Male'
    GROUP BY YEAR(created_at), MONTH(created_at)
    ORDER BY YEAR(created_at), MONTH(created_at)";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    $labels = [];
    $data = [];
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $monthName = date("M", mktime(0, 0, 0, $row['month'], 10));
    $labels[] = $monthName . ' ' . $row['year'];
    $data[] = $row['total_residents'];
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
    ?>
    <canvas data-bss-chart='{"type":"line","data":<?php echo $chartDataJson; ?>,"options":{"maintainAspectRatio":false,"legend":{"display":false,"labels":{"fontStyle":"normal"}},"title":{"fontStyle":"normal"},"scales":{"xAxes":[{"gridLines":{"color":"rgb(234, 236, 244)","zeroLineColor":"rgb(234, 236, 244)","drawBorder":false,"drawTicks":false,"borderDash":["2"],"zeroLineBorderDash":["2"],"drawOnChartArea":false},"ticks":{"fontColor":"#858796","fontStyle":"normal","padding":20}}],"yAxes":[{"gridLines":{"color":"rgb(234, 236, 244)","zeroLineColor":"rgb(234, 236, 244)","drawBorder":false,"drawTicks":false,"borderDash":["2"],"zeroLineBorderDash":["2"]},"ticks":{"fontColor":"#858796","fontStyle":"normal","padding":20}}]}}}'></canvas>
    <?php
}

function female_month_chart(){
    global $db;
    $sql = "SELECT YEAR(created_at) AS year, MONTH(created_at) AS month, COUNT(id) AS total_residents
    FROM residents
    WHERE sex = 'Female'
    GROUP BY YEAR(created_at), MONTH(created_at)
    ORDER BY YEAR(created_at), MONTH(created_at)";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    $labels = [];
    $data = [];
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $monthName = date("M", mktime(0, 0, 0, $row['month'], 10));
    $labels[] = $monthName . ' ' . $row['year'];
    $data[] = $row['total_residents'];
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
    ?>
    <canvas data-bss-chart='{"type":"line","data":<?php echo $chartDataJson; ?>,"options":{"maintainAspectRatio":false,"legend":{"display":false,"labels":{"fontStyle":"normal"}},"title":{"fontStyle":"normal"},"scales":{"xAxes":[{"gridLines":{"color":"rgb(234, 236, 244)","zeroLineColor":"rgb(234, 236, 244)","drawBorder":false,"drawTicks":false,"borderDash":["2"],"zeroLineBorderDash":["2"],"drawOnChartArea":false},"ticks":{"fontColor":"#858796","fontStyle":"normal","padding":20}}],"yAxes":[{"gridLines":{"color":"rgb(234, 236, 244)","zeroLineColor":"rgb(234, 236, 244)","drawBorder":false,"drawTicks":false,"borderDash":["2"],"zeroLineBorderDash":["2"]},"ticks":{"fontColor":"#858796","fontStyle":"normal","padding":20}}]}}}'></canvas>
    <?php
}

function budget_month_chart(){
    global $db;
    $sql = "SELECT YEAR(created_at) AS year, MONTH(created_at) AS month, SUM(fund) AS total_fund
    FROM project_fund
    GROUP BY YEAR(created_at), MONTH(created_at)
    ORDER BY YEAR(created_at), MONTH(created_at)";
    $stmt = $db->prepare($sql);
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
    'label' => 'Budgets',
    'fill' => true,
    'data' => $data,
    'backgroundColor' => 'rgba(78, 115, 223, 0.05)',
    'borderColor' => 'rgba(78, 115, 223, 1)'
    ]
    ]
    ];
  
  
    $chartDataJson = json_encode($chartData);
    ?>
    <canvas data-bss-chart='{"type":"line","data":<?php echo $chartDataJson; ?>,"options":{"maintainAspectRatio":false,"legend":{"display":false,"labels":{"fontStyle":"normal"}},"title":{"fontStyle":"normal"},"scales":{"xAxes":[{"gridLines":{"color":"rgb(234, 236, 244)","zeroLineColor":"rgb(234, 236, 244)","drawBorder":false,"drawTicks":false,"borderDash":["2"],"zeroLineBorderDash":["2"],"drawOnChartArea":false},"ticks":{"fontColor":"#858796","fontStyle":"normal","padding":20}}],"yAxes":[{"gridLines":{"color":"rgb(234, 236, 244)","zeroLineColor":"rgb(234, 236, 244)","drawBorder":false,"drawTicks":false,"borderDash":["2"],"zeroLineBorderDash":["2"]},"ticks":{"fontColor":"#858796","fontStyle":"normal","padding":20}}]}}}'></canvas>
    <?php

  }