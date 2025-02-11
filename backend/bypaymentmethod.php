<?php
include("connectdb.inc.php");

$query = "SELECT transactions.id_payment, payments.payment_method, categories.category, SUM(transactions.amount  * accounting.accounting_coefficient) AS total_amount
          FROM transactions 
          JOIN payments ON transactions.id_payment = payments.id_payment
          JOIN categories ON transactions.id_category = categories.id_category 
          JOIN accounting ON categories.id_accounting = accounting.id_accounting
          GROUP BY transactions.id_payment, payments.payment_method";


$result = $mysqli->query($query);

$dataPoints = array();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $paymentMethod = $row['payment_method'];
        $amount = $row['total_amount'];
        
        // Construct the data points array
        $dataPoints[] = array("y" => $amount, "label" => $paymentMethod);
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
    <title>Payment Method</title>
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
    <h1>Payment Method</h1>
 

<?php
    
    
    $result = $mysqli->query($query);
    
    if ($result && $result->num_rows > 0) {
?>

        <table border='1'>
        <tr>
                <th>Payment Method</th>
                <th>Amount</th>
              </tr>";

<?php
while ($row = $result->fetch_assoc()) {
    $formattedAmount = number_format($row['total_amount'], 2); // Format the amount to two decimal places
?>
    <tr>
        <td><?php echo $row['payment_method']; ?></td>
        <td><?php echo $formattedAmount; ?></td>
    </tr>
<?php
} 
?>
</table>


<?php
    }

     else {
        echo "No records available.";
    }

    ?>
    <div id="chartContainer" style="height: 370px; width: 80%; margin: 0 auto;"></div>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>

    <a href="homepage.php" class="click">Back to the Homepage</a>   
</body>
</html>

