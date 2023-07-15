<?php
session_start();
require_once("./connect.php"); // 引用連線

$cartTotal = 0;
if(isset($_SESSION["cart"])){
  foreach($_SESSION["cart"] as $pt){
    $cartTotal += $pt["num"];
  }
}


if (isset($_GET["uid"])) {
  $uid = intval($_GET["uid"]);
  $uSQL = "`id` = $uid AND";
} else {
  $uid = 0;
  $uSQL = "`id` = $uid AND";
}
$sqlUser = "SELECT * FROM `user` WHERE $uSQL `isValid` = 1";
$sqlAll = "SELECT 
  product.*, 
  GROUP_CONCAT(DISTINCT product_img.file) as files,
  GROUP_CONCAT(DISTINCT product_img.id) as fileIDs,
  GROUP_CONCAT(DISTINCT product_tag.tid) as tagIDs
  FROM 
  product
  LEFT JOIN 
  product_img ON product.id = product_img.pid
  LEFT JOIN
  product_tag ON product.id = product_tag.pid
  WHERE 
    product.uid = $uid AND product.isValid = 1
  GROUP BY product.id;";
try {
  $result = $conn->query($sqlUser);
  $userCount = $result->num_rows;
  $user = $result->fetch_assoc();
  $result = $conn->query($sqlAll);
  $pdCount = $result->num_rows;
  $pds = $result->fetch_all(MYSQLI_ASSOC);
  for($i=0; $i < $pdCount; $i++){
    $pds[$i]["files"] = explode(",", $pds[$i]["files"]);
    $pds[$i]["fileIDs"] = explode(",", $pds[$i]["fileIDs"]);
  }
} catch (mysqli_sql_exception $exception) {
  $error = "資料讀取錯誤：" . $conn->error;
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>賣場列表</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="./css/index.css">
  </head>
  <body>
    <div class="container mt-3">
      <?php if($userCount>0):?>
      <div class="d-flex align-items-center">
        <img class="imgHead align-center" src="./uimg/<?=$user["img"]?>" alt="">
        <span class="h1 me-auto"><?=$user["name"]?> 的賣場</span>
        <?php if(isset($_SESSION["user"])): ?>
          <div class="username me-2"><?=$_SESSION["user"]["name"]?></div>
          <a href="../user/doLogout.php?status=1&uid=<?=$uid?>" class="btn btn-warning btn-sm">登出</a>
        <?php else: ?>
          <a href="../user/login.php?status=2&uid=<?=$uid?>" class="btn btn-primary btn-sm">登入</a>  
        <?php endif; ?>
      </div>
        <div class="pds">
          <?php foreach($pds as $pd): ?>
            <div class="pd d-flex">
              <div class="right me-2">
                <img class="img1" src="./pimg/<?=$pd["files"][0]?>" alt="">
              </div>
              <div class="left">
                <h4><?=$pd["name"]?></h4>
                <div>$<span class="text-danger fs-2 fw-bold"><?=$pd["price"]?></span>元</div>
                <a href="./cart/doAdd.php?pid=<?=$pd["id"]?>" class="btn btn-primary btn-sm">加入購物車</a>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <h1>找不到賣場</h1>
        <p>
          推薦您拜訪這個
          <a href="?uid=1">小說賣場</a>
          或是
          <a href="?uid=5">蛋糕賣場</a>
        </p>
      <?php endif; ?>
    </div>
    <div class="cart position-fixed end-0">
      <a href="./cart/list.php" class="fs-3 py-2 ps-2 text-white bg-primary rounded-start">
        <i class="fa-solid fa-cart-shopping"></i>
      </a>
      <?php if($cartTotal>0): ?>
      <span class="fs-6 small position-absolute top-0 start-0 translate-middle badge rounded-pill bg-danger">
        <?=$cartTotal?>
      </span>
      <?php endif; ?>
    </div>
    <script src="./js/bootstrap.bundle.min.js"></script>
  </body>
</html>