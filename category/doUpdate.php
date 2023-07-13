<?php
require_once("../connect.php");
require_once("../utilities/alertFunc.php");

if(!isset($_POST["id"])){
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

// 收集表單變數
$id = intval($_POST["id"]);
$name = htmlspecialchars($_POST["name"]); // 移除 html 標籤
$sql = "UPDATE category SET `name` = '$name', `modifyTime` = CURRENT_TIMESTAMP WHERE id = $id;";

// 寫入資料庫，將結果存在變數 error
$error = "";
try {
  $conn->query($sql);
} catch (mysqli_sql_exception $exception) {
  $error = $exception->getMessage();
}

$conn->close();

// 由變數 error 來判斷要轉跳回列表，或失敗了回上一頁
if($error === ""){
  alertAndGoToList("資料修改成功");
  exit;
}else{
  alertAndGoBack("資料修改錯誤：" .$error);
  exit;
}

