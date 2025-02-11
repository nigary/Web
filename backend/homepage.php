<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Transactions</title>

    <link rel="stylesheet" href="style.css">
</head>



<body>

    <h1>Transactions</h1>



<?php
    include("connectdb.inc.php");
    $query = "SELECT transactions.*, categories.category AS category_name, payments.payment_method AS payment_method_name 
              FROM transactions 
              JOIN categories ON transactions.id_category = categories.id_category 
              JOIN payments ON transactions.id_payment = payments.id_payment
              ORDER BY transactions.date";

    $result = $mysqli->query($query);


    if ($result && $result->num_rows > 0) {
?>

        <div class='table-container'>
        <table border ='1' id='myTable'>
        <tr>                
                <th>Amount</th>
                <th>Date</th>
                <th>Category</th>
                <th>Payment Method</th>
                <th>Edit</th>
                <th>Delete</th>
              </tr>;


<?php
        while ($row = $result->fetch_assoc()) {
?>

            <tr>
           
            <td><?php echo $row['amount']; ?></td>
            <td><?php echo $row['date']; ?></td>
            <td><?php echo $row['category_name']; ?></td>
            <td><?php echo $row['payment_method_name']; ?></td>
            <td><a href='transactionadd.php?id=<?php echo $row['id_transaction']; ?>'>Edit</a></td>
            <td><a href='transactiondelete.php?id=<?php echo $row['id_transaction']; ?>'>Delete</a></td>
          </tr>
          
<?php
        }
?>

       </table>
       </div>

       <?php
    }

    else {
        echo "No records available.";
    }
?>

<nav>
<a href="byacctype.php">By Accounting Type</a>
        <a href="byperiod.php">By Period</a>
        <a href="bycategory.php">By Category</a>
       
        <a href="bypaymentmethod.php">By Payment Method</a>
        <a href="transactionform.php">Add a New Transaction</a>
    </nav><br>

</body>
</html>
