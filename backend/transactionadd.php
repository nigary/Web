<?php
include_once("connectdb.inc.php");

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];


    // Fetch transaction details for editing
    $query = "SELECT * FROM transactions WHERE id_transaction = $id";
    $result = $mysqli->query($query);

    // Check if the result is valid and contains data
    if ($result && $result->num_rows > 0) {
        $transaction = $result->fetch_assoc();
    } else {
        echo "Transaction not found.";
        exit();
    }
} else {
    echo "Invalid request. ID not set.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
    // Extract and sanitize form data
    $amount = filter_var($_POST["amount"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $category = $_POST["category"];
    $date = $_POST["date"];
    
    $paymentMethod = $_POST["payment_method"];

    // Perform database update
    $updateQuery = "UPDATE transactions 
                    SET date = ' id_category = $category, id_payment = $paymentMethod ,$date, amount = $amount'
                    WHERE id_transaction = $id";

    $updateResult = mysqli_query($mysqli, $updateQuery);


    if ($updateResult) {
        echo '
            <script>
                alert("Transaction ' . $id . ' Updated!");
                window.location.href = "homepage.php";
            </script>
        ';
    
    
    } else {
        echo "Error: " . mysqli_error($mysqli);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update to the transaction</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h1>Update to the transaction</h1>

    <form action="" method="post">
        <label for="amount">Amount:</label>
        <input type="number" name="amount" value="<?php echo $transaction['amount']; ?>" required>

        <label for="category">Category:</label>
        <select name="category" required>

        <?php
            $categoriesQuery = "SELECT * FROM categories";
            $categoriesResult = $mysqli->query($categoriesQuery);

            if ($categoriesResult && $categoriesResult->num_rows > 0) {
                while ($categoryRow = $categoriesResult->fetch_assoc()) {
                    $selected = ($categoryRow['id_category'] == $transaction['id_category']) ? 'selected' : '';
                    echo "<option value=\"{$categoryRow['id_category']}\" $selected>{$categoryRow['category']}</option>";
                }
            }
            ?>

        <label for="date">Date:</label>
        <input type="date" name="date" value="<?php echo $transaction['date']; ?>" required>

        
        
        </select>

        <label for="payment_method">Payment Method:</label>
        <select name="payment_method" required>
            <?php
            $paymentMethodsQuery = "SELECT * FROM payments";
            $paymentMethodsResult = $mysqli->query($paymentMethodsQuery);

            if ($paymentMethodsResult && $paymentMethodsResult->num_rows > 0) {
                while ($methodRow = $paymentMethodsResult->fetch_assoc()) {
                    $selected = ($methodRow['id_payment'] == $transaction['id_payment']) ? 'selected' : '';
                    echo "<option value=\"{$methodRow['id_payment']}\" $selected>{$methodRow['payment_method']}</option>";
                }
            }
            ?>
        </select>

        <button type="submit" name="submit">Submit</button>
    </form>

</body>
</html>

