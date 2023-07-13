<?php
$servername = "localhost";
$username = "admin";
$password = "a12345";
$dbname = "myProject";
$port = 8086;

try {
  $conn = new mysqli($servername, $username, $password, $dbname, $port);
} catch (mysqli_sql_exception $exception) {
  die("連線失敗：" . $exception->getMessage());
}

?>