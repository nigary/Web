<?php
include("connectdb.inc.php");

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM transactions WHERE id_transaction = $id";
    $result = mysqli_query($mysqli, $query);

    if ($result) {
     echo '   <script>
     alert("Transaction ' . $id . ' Deleted!");
     window.location.href = "homepage.php";
 </script>';
    } else {
        echo "Error deleting transaction: " . mysqli_error($mysqli);
    }
} else {
    echo "Invalid request.";
}
?>

