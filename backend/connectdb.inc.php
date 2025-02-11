<?php
session_start();

$host="";
$user="";
$passwd="";
$bd="";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $mysqli=new mysqli($host,$user,$passwd,$bd);
    $mysqli->set_charset("utf8");
} catch (Exception $e) { 
    echo "MySQLi Error Code: " . $e->getCode();
    echo "Exception Msg: " . $e->getMessage();
    exit();
}

?>
