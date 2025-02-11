<?php
include("connectdb.inc.php");

$query = "SELECT accounting.accounting_type, SUM(transactions.amount * accounting.accounting_coefficient) AS total_amount
          FROM transactions 
          JOIN categories ON transactions.id_category = categories.id_category 
          JOIN accounting ON categories.id_accounting = accounting.id_accounting
          GROUP BY accounting.accounting_type";

$result = $mysqli->query($query);

$dataPoints = array();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $accountingType = ($row['accounting_type'] == 'debit') ? 'debit' : 'credit';
        $amount = $row['total_amount'];
        
        // Construct the data points array
        $dataPoints[] = array("y" => $amount, "label" => $accountingType);
    }
} else {
    echo "No data found for summary by accounting type.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accounting Type</title>
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
    <h1>Accounting Type</h1>

    <?php
    $result = $mysqli->query($query);
    
    if ($result && $result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr>
                <th>Accounting Type</th>
                <th>Amount</th>
              </tr>";
    
        while ($row = $result->fetch_assoc()) {
            $accountingType = ($row['accounting_type'] == 'debit') ? 'debit' : 'credit';
            $formattedAmount = number_format($row['total_amount'], 2); // Format the amount to two decimal places
            echo "<tr>
                    <td>{$accountingType}</td>
                    <td>{$formattedAmount}</td>
                </tr>";
        }
    
        echo "</table>";
    } else {
        echo "No data found for summary by accounting type.";
    }
    ?>
    <div id="chartContainer" style="height: 370px; width: 80%; margin: 0 auto;"></div>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>

    <a href="homepage.php" class="click">Back to the Homepage</a>
</body>
</html>
