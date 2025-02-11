<?php
include("connectdb.inc.php");

// Default current date
$defaultDate = date("Y-m-d");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $amount = filter_var($_POST["amount"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $date = $_POST["date"];
    $category = $_POST["category"];
    $paymentMethod = $_POST["payment_method"];

    $query = "INSERT INTO transactions (date, amount, id_category, id_payment) VALUES ('$date', $amount, $category, $paymentMethod)";
    $result = mysqli_query($mysqli, $query);

    if ($result) {
        header("Location: homepage.php");
        die();
    } else {
        echo "Error recording transaction: " . mysqli_error($mysqli);
    }
}

$categories = [];
$resultCategories = $mysqli->query("SELECT * FROM categories");

if ($resultCategories) {
    while ($row = $resultCategories->fetch_assoc()) {
        $categories[] = $row;
    }
}

$paymentMethods = [];
$resultPayments = $mysqli->query("SELECT * FROM payments");

if ($resultPayments) {
    while ($row = $resultPayments->fetch_assoc()) {
        $paymentMethods[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add </title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h1>Add </h1>


    <form action="" method="post">
        <label for="amount">Amount:</label>
        <!-- Numeric keypad for amount input -->
        <input type="number" name="amount" required inputmode="numeric" pattern="[0-9]*" placeholder="Enter amount" step="0.01">

        <label for="date">Date:</label>
        <!-- Default current date -->
        <input type="date" name="date" required value="<?php echo $defaultDate; ?>">

        <label for="category">Category:</label>
        <select name="category" required>
            <?php
            foreach ($categories as $category) {
                echo "<option value=\"{$category['id_category']}\">{$category['category']}</option>";
            }
            ?>
        </select>

        <label for="payment_method">Payment Method:</label>
        <select name="payment_method" required>
            <?php
            foreach ($paymentMethods as $method) {
                echo "<option value=\"{$method['id_payment']}\">{$method['payment_method']}</option>";
            }
            ?>
        </select>

        <button type="submit">Add</button>
    </form>

    <a href="homepage.php" class="click">Homepage</a>

</body>
</html>
