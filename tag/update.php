<?php
require_once("../connect.php");
require_once("../utilities/alertFunc.php");

if (!isset($_GET["id"])) {
  echo "請由正式方法進入頁面";
  exit;
}

$id = intval($_GET["id"]);
$sql = "SELECT * FROM tag WHERE id = '$id'";
try {
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
} catch (mysqli_sql_exception $exception) {
  $row = "ERROR";
}
if ($row == "ERROR" || $row == NULL) {
  alertAndGoToList("讀取錯誤，請洽管理人員");
  exit;
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>tag 分類</title>
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/admin.css">
</head>

<body>
  <?php require("../utilities/nav1.php"); ?>
  <div class="container my-3">
    <h1>tag 分類<span class="badge text-bg-info fs-6 align-middle ms-1">表單</span></h1>
    <form action="./doUpdate.php" method="post" enctype="multipart/form-data">
      <!-- 隱藏欄位 tag 編號 -->
      <input type="hidden" name="id" value="<?= $row["id"] ?>">
      <div class="input-group mb-1">
        <span class="input-group-text">tag 名稱</span>
        <input name="name" type="text" class="form-control" placeholder="使用者姓名" value="<?= $row["name"] ?>">
      </div>
      <div class="mt-1 text-end">
        <button type="submit" class="btn btn-primary btn-send">送出</button>
        <a class="btn btn-info" href="./list.php">取消</a>
      </div>
    </form>
  </div>
  <script src="../js/bootstrap.bundle.min.js"></script>
  <script>
    const form = document.querySelector("form");
    const btnSend = document.querySelector(".btn-send");
    btnSend.addEventListener("click", function(e) {
      e.preventDefault();
      let name = document.querySelector("input[name=name]").value;
      if (name == "") {
        alert("請填寫 tag 名稱");
        return false;
      }
      form.submit();
    })
  </script>
</body>

</html>