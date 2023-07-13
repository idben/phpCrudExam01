<?php
require_once("../connect.php");
require_once("../utilities/alertFunc.php"); // 引用常用函數

if(!isset($_GET["id"])){
  echo "請由正式方法進入頁面";
  exit;
}

$id = intval($_GET["id"]);
$sql = "UPDATE category SET `isValid` = 0, `modifyTime` = CURRENT_TIMESTAMP WHERE id = $id;";

// 寫入資料庫，將結果存在變數 error
$error = "";
try {
  $conn->query($sql);
} catch (mysqli_sql_exception $exception) {
  $error = "ERROR";
}
$conn->close();

// 由變數 error 來判斷要轉跳回列表，或失敗了回上一頁
if($error === ""){
  alertAndGoToList("分類刪除成功");
  exit;
}else{
  alertAndGoBack("分類刪除錯誤：" .$conn->error);
  exit;
}