<?php
session_start();
require_once("../connect.php"); // 引用連線
require_once("../utilities/alertFunc.php"); // 引用常用函數
if(!isset($_SESSION["user"])){
  $url = "../user/login.php?status=1";
  alertAndBackToPage("請先登入才能結帳", $url);
  exit;
}

$msg = "";

$uid = $_SESSION["user"]["id"];
// 製作像信用卡號的帳單編號
$timestamp = time();
$timestampStr = strval($timestamp); // 將時間戳轉換為字符串
$halfLength = intdiv(strlen($timestampStr), 2); // 找到字符串中點的索引
// 使用 substr 插入下劃線
$firstHalf = substr($timestampStr, 0, $halfLength);
$secondHalf = substr($timestampStr, $halfLength);
$idsn= "OD_".$firstHalf . "_" . $secondHalf;
// 整理 SQL

$sql = "INSERT INTO `orders` 
  (`id`, `orderID`, `uid`, `createTime`) VALUES 
  (NULL, '$idsn' , $uid, CURRENT_TIMESTAMP);";

// 寫入主要訂單資料庫
try {
  $conn->query($sql);
  $oid = $conn->insert_id; // 取得訂單的流水編號
} catch (mysqli_sql_exception $exception) {
  // echo "產品新增錯誤：" .$conn->error;
  $msg = "產品新增錯誤，請洽管理人員";
  exit;
}

// 從 SESSION 整理訂購內容的 SQL
if(isset($_SESSION["cart"]) && count($_SESSION["cart"]) > 0){
  $sql2 = "";
  foreach ($_SESSION["cart"] as $pt){
    $pid = $pt["id"];
    $num = $pt["num"];
    $sql2 .= "INSERT INTO `orders_product` 
      (`id`, `oid`, `pid`, `num`) VALUES 
      (NULL, $oid, $pid, $num);";
  }

  // 寫入 orders_product 資料庫
  try {
    $conn->multi_query($sql2);
    while ($conn->more_results() && $conn->next_result()) { 
      // 不做任何事情，只是將結果清除掉 
    }
    unset($_SESSION["cart"]); // 寫入完成，清空購物車
  } catch (mysqli_sql_exception $exception) {
    // echo "發生錯誤：" .$conn->error;
    $msg = "產品寫入發生錯誤，請洽管理人員";
    exit;
  }
}else{
  $msg = "購物車中沒有商品";
}



?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>結帳</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
  </head>
  <body>
    <div class="container mt-3">
      <?php if($msg == ""): ?>
        <div class="h1">完成結帳</div>
        <p class="my-2">
          您的訂單編號是：<span class="bg-success text-white fs-3 p-1 px-2 rounded"><?=$idsn?></span>
        </p>
        <p>
          到這邊已經將 session 中的購物記錄寫入資料庫 <br>
          再來的就要同學自己開始寫了。
        </p>
        <p>
          <a href="../index.php" class="btn btn-primary">去逛逛</a>
        </p>
      <?php else: ?>
        <h1>ERROR</h1>
        <p>
          <?=$msg?>
          <a href="../index.php" class="btn btn-primary">去逛逛</a>
        </p>
      <?php endif; ?>
    </div>
    <script src=".//js/bootstrap.bundle.min.js"></script>
  </body>
</html>