<?php
session_start();
require_once("../connect.php"); // 引用連線
require_once("../utilities/alertFunc.php"); // 引用常用函數

$error = ""; // 初始化錯訊訊息，預設無錯誤
$perPage = 10; // 每頁筆數
// 抓取網址變數 頁數
if (isset($_GET["page"])) {
  $page = intval($_GET["page"]);
} else {
  $page = 1;
}
// 計算初始筆數
$pageStart = ($page - 1) * $perPage;

// 判斷使用者與其額外的 SQL 語句
$uid = $_SESSION["user"]["id"];
$level = $_SESSION["user"]["level"];
if($level == 9){
  $uSQL = "";
}else{
  $uSQL = "WHERE product.uid = $uid ";
}

$sql = "SELECT orders_product.*, product.*, orders.status, orders.orderID, orders.uid as buyID, 
user.name as userName, 
user.email as userEmail
FROM orders_product
INNER JOIN product ON orders_product.pid = product.id
INNER JOIN orders ON orders_product.oid = orders.id
INNER JOIN user ON user.id = orders.uid
$uSQL
LIMIT $pageStart, $perPage";
$sqlAll = "SELECT orders_product.*, product.*, orders.status, orders.orderID, orders.uid as buyID, 
user.name as userName, 
user.email as userEmail
FROM orders_product
INNER JOIN product ON orders_product.pid = product.id
INNER JOIN orders ON orders_product.oid = orders.id
INNER JOIN user ON user.id = orders.uid
$uSQL";
try {
  $result = $conn->query($sql);
  $userCount = $result->num_rows;
  $rows = $result->fetch_all(MYSQLI_ASSOC);
  $resultAll = $conn->query($sqlAll);
  $totalCount = $resultAll->num_rows;
  $totalPage = ceil($totalCount / $perPage);
} catch (mysqli_sql_exception $exception) {
  $error = "資料讀取錯誤：" . $conn->error;
}

// var_dump($rows);

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>訂單記錄</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/admin.css">
  </head>
  <body>
    <?php require("../utilities/nav1.php"); ?>
    <div class="container my-3">
      <h1>訂單記錄<span class="badge text-bg-warning fs-6 align-middle ms-1">清單</span></h1>
      <div class="d-flex mb-2">
      </div>
      <?php if($error !== ""): ?>
        <div class="text-danger fw-bold fs-3">發生錯誤，請洽管理人員</div>
      <?php else:?>
        <div class="user data head bg-primary p-1 text-white">
          <div class="sn">sn</div>
          <div class="email">訂單帳號</div>
          <div class="name">訂單編號</div>
          <div class="level text-center">狀態</div>
          <div class="cTime">建立時間</div>
          <div class="ctrl text-center">操作管理</div>
        </div>
        <?php foreach($rows as $index => $row): ?>
          <div class="user data">
            <div class="sn"><?=$index+1?></div>
            <div class="email"><?=$row["name"]?><span class="bg-danger-subtle p-1 px-2 rounded"><?=$row["num"]?>個</span>(<?=$row["userName"]?>: <?=$row["userEmail"]?>)</div>
            <div class="name"><?=$row["orderID"]?></div>
            <div class="level text-center"><?=$row["status"]?></div>
            <div class="cTime"><?=$row["createTime"]?></div>
            <div class="ctrl text-center">
              <div href="#" class="btn btn-danger btn-sm btn-del" idn="<?=$row["id"]?>">刪除</div>
              <a href="./update.php?id=<?=$row["id"]?>" class="btn btn-primary btn-sm">管理</a>
            </div>
          </div>
        <?php endforeach; ?>
        <div class="user data footer bg-primary"></div>
        <div class="pagination pagination-sm justify-content-center my-2">
          <?php for($i=1;$i<=$totalPage;$i++): ?>
            <div class="page-item">
              <a href="?page=<?=$i?>" class="page-link <?=($page==$i)?"active":""?>"><?=$i?></a>
            </div>
          <?php endfor; ?>
        </div>
      <?php endif; ?>
    </div>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script>
      let btnDels = document.querySelectorAll(".btn-del");
      [...btnDels].map(function(btnDel){
        btnDel.addEventListener("click", function(){
          let id = this.getAttribute("idn");
          if(confirm("確定要刪除嗎？")){
            window.location.href = `./doDelete.php?id=${id}`;
          }
        })
      });
    </script>
  </body>
</html>