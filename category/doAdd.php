<?php
session_start();
require_once("../connect.php"); // 引用連線
require_once("../utilities/alertFunc.php"); // 引用常用函數

if(!isset($_POST["name"])){
  echo "請由正式方法進入頁面";
  exit;
}

// 檢查是否有使用過 name
$name = $_POST["name"];
$sql = "SELECT * FROM `category` WHERE `name` = '$name'";
try {
  $result = $conn->query($sql);
} catch (mysqli_sql_exception $exception) {
  $result = "error";
}

if($result == "error"){
  alertAndGoBack("發生錯誤，請洽管理人員");
  exit;
}else if($result->num_rows > 0){
  alertAndGoBack("該分類名稱已經使用過");
  exit;
}


// 整理表單變數
$name = htmlspecialchars($_POST["name"]);
$uid = $_SESSION["user"]["id"];

// 整理 SQL
$sql = "INSERT INTO `category` 
  (`id`, `uid`, `name`, `createTime`) VALUES 
  (NULL, $uid, '$name', CURRENT_TIMESTAMP);";
// 寫入資料庫
try {
  $conn->query($sql);
  alertAndGoToList("新增分類成功");
} catch (mysqli_sql_exception $exception) {
  alertAndGoToList("分類新增錯誤：" .$conn->error);
}
$conn->close();
