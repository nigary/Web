<?php
include("connectdb.inc.php");

$query = "SELECT MONTH(date) AS month, YEAR(date) AS year, SUM(amount * accounting.accounting_coefficient) AS total_amount
          FROM transactions 
          JOIN categories ON transactions.id_category = categories.id_category 
          JOIN accounting ON categories.id_accounting = accounting.id_accounting
          GROUP BY YEAR(date), MONTH(date)
          ORDER BY YEAR(date), MONTH(date)";

$result = $mysqli->query($query);

$dataPoints = array();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $period = date("M Y", strtotime($row['year'] . "-" . $row['month'] . "-01"));
        $amount = $row['total_amount'];
        $dataPoints[] = array("y" => $amount, "label" => $period);
    }
} else {
    echo "No records available.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Summary by Period</title>
    <link rel="stylesheet" href="style.css">
    <script>
        window.onload = function() {
            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                axisY: {
                    title: "Total Amount",
                    includeZero: true,
                    prefix: "$"
                },
                data: [{
                    type: "pie",
                    yValueFormatString: "$#,##0",
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();
        }
    </script>
</head>
<body>
    <h1>Period</h1>

    <?php
    $result = $mysqli->query($query);
    
    if ($result && $result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr>
                <th>Period</th>
                <th>Amount</th>
              </tr>";
    
        while ($row = $result->fetch_assoc()) {
            $period = date("M Y", strtotime($row['year'] . "-" . $row['month'] . "-01"));
            $formattedAmount = number_format($row['total_amount'], 2); // Format the amount to two decimal places
            echo "<tr>
                    <td>{$period}</td>
                    <td>{$formattedAmount}</td>
                </tr>";
        }
    
        echo "</table>";
    } else {
        echo "No records available.";
    }
    ?>
    
    <div id="chartContainer" style="height: 370px; width: 80%; margin: 0 auto;"></div>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>

    <a href="homepage.php" class="click">Back to the Homepage</a>
</body>
</html>

