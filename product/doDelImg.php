<?php
require_once("../connect.php");
require_once("../utilities/alertFunc.php");

if (!isset($_GET["id"])) {
  echo "請由正式方法進入頁面";
  exit;
}
$msg = "";
$id = $_GET["id"];
$pid = $_GET["pid"];
$sql = "SELECT * FROM `product_img` WHERE id = $id;";
$sqlDel = "DELETE FROM `product_img` WHERE id = $id;";
$file = "";
try {
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $conn->query($sqlDel);
  $file = "../pimg/".$row["file"];
} catch (mysqli_sql_exception $exception) {
  $row = "ERROR";
}
if($file!=""){
  try {
    deleteFile($file);
    $msg = "檔案已成功刪除";
  } catch (Exception $e) {
    $msg = $e->getMessage();
  }
}

$url = "./update.php?id=$pid";
alertAndBackToPage($msg, $url);

function deleteFile($file) {
  if(file_exists($file)) {
    if(!unlink($file)) {
      throw new Exception("檔案刪除失敗");
    }
  }else{
    throw new Exception("檔案不存在");
  }
}