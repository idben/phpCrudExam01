<?php
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

$sql = "SELECT * FROM category WHERE isValid = 1 LIMIT $pageStart, $perPage";
$sqlAll = "SELECT * FROM category WHERE `isValid` = 1";
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


?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>分類清單</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/admin.css">
  </head>
  <body>
    <?php require("../utilities/nav1.php"); ?>
    <div class="container my-3">
      <h1>分類清單<span class="badge text-bg-warning fs-6 align-middle ms-1">清單</span></h1>
      <div class="d-flex mb-2">
        <a class="btn btn-info btn-sm ms-auto" href="./add.php">增加分類</a>
      </div>
      <?php if($error !== ""): ?>
        <div class="text-danger fw-bold fs-3">發生錯誤，請洽管理人員</div>
      <?php else:?>
        <div class="category data head bg-primary p-1 text-white">
          <div class="sn">sn</div>
          <div class="name">分類名稱</div>
          <div class="cTime">建立時間</div>
          <div class="ctrl text-center">操作管理</div>
        </div>
        <?php foreach($rows as $index => $row): ?>
          <div class="category data">
            <div class="sn"><?=($perPage*($page-1))+$index+1?></div>
            <div class="name"><?=$row["name"]?></div>
            <div class="cTime"><?=$row["createTime"]?></div>
            <div class="ctrl text-center">
              <div href="#" class="btn btn-danger btn-sm btn-del" idn="<?=$row["id"]?>">刪除</div>
              <a href="./update.php?id=<?=$row["id"]?>" class="btn btn-primary btn-sm">管理</a>
            </div>
          </div>
        <?php endforeach; ?>
        <div class="category data footer bg-primary"></div>
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