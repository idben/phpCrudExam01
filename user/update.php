<?php
require_once("../connect.php");
require_once("../utilities/alertFunc.php");

if (!isset($_GET["id"])) {
  echo "請由正式方法進入頁面";
  exit;
}

$id = $_GET["id"];
$sql = "SELECT * FROM user WHERE id = '$id'";
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
  <title>管理使用者</title>
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/admin.css">
</head>

<body>
  <?php require("../utilities/nav1.php"); ?>
  <div class="container my-3">
    <h1>管理使用者<span class="badge text-bg-info fs-6 align-middle ms-1">表單</span></h1>
    <form action="./doUpdate.php" method="post" enctype="multipart/form-data">
      <div class="d-flex">
        <div>
          <img class="user update img" src="../uimg/<?= $row["img"] ?>" alt="">
          <div class="fs-4"><?= $row["name"] ?></div>
          <div>
            <?php for($i=0; $i<intval($row["level"]); $i++): ?>
              <img class="user update satrt" src="../images/star.png" alt="">
              <?php if($i == 4): ?>
                <br>
              <?php endif; ?>
            <?php endfor; ?>
          </div>
        </div>
        <div class="w-100 ms-2">
          <!-- 隱藏欄位 圖片名稱 使用者編號 -->
          <input type="hidden" name="img" value="<?= $row["img"] ?>">
          <input type="hidden" name="id" value="<?= $row["id"] ?>">
          <div class="input-group mb-1">
            <span class="input-group-text">信箱</span>
            <input name="email" type="text" class="form-control" placeholder="使用者信箱" value="<?= $row["email"] ?>" readonly>
          </div>
          <div class="bg-warning rounded p-1 pb-1">
            <div class="input-group mb-1">
              <span class="input-group-text">舊密碼</span>
              <input name="password" type="password" class="form-control" placeholder="使用者密碼，修改需要密碼驗證" value="">
            </div>
            <div class="input-group">
              <span class="input-group-text">舊密碼</span>
              <input name="password2" type="password" class="form-control" placeholder="確認密碼，再輸入一次">
            </div>
          </div>
          <div class="input-group my-1">
            <span class="input-group-text">新密碼</span>
            <input name="password3" type="password" class="form-control" placeholder="如需要更新密碼，請再輸入一次">
          </div>
          <div class="input-group mb-1">
            <span class="input-group-text">姓名</span>
            <input name="name" type="text" class="form-control" placeholder="使用者姓名" value="<?= $row["name"] ?>">
          </div>
          <?php if($_SESSION["user"]["level"] == 9): ?>
            <div class="input-group mb-1">
              <span class="input-group-text">等級</span>
              <input max="9" min="0" name="level" type="number" class="form-control" value="<?= $row["level"] ?>">
            </div>
          <?php endif; ?>
          <div class="input-group mb-1">
            <input class="form-control" type="file" name="myFile" accept=".png,.jpg,.jpeg">
          </div>
          <div class="mt-1 text-end">
            <button type="submit" class="btn btn-primary btn-send">送出</button>
            <?php if($_SESSION["user"]["level"] == 9): ?>
              <a class="btn btn-info" href="./list.php">取消</a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </form>
  </div>
  <script src="../js/bootstrap.bundle.min.js"></script>
  <script>
    const form = document.querySelector("form");
    const btnSend = document.querySelector(".btn-send");
    btnSend.addEventListener("click", function(e) {
      e.preventDefault();
      let pwd1 = document.querySelector("input[name=password]").value;
      let pwd2 = document.querySelector("input[name=password2]").value;
      let name = document.querySelector("input[name=name]").value;
      if (pwd1 == "") {
        alert("請填寫密碼");
        return false;
      }
      if (pwd2 == "") {
        alert("請填確認密碼");
        return false;
      }
      if (pwd2 != pwd1) {
        alert("請填確認密碼");
        return false;
      }
      if (name == "") {
        alert("請填寫姓名");
        return false;
      }
      form.submit();
    })
  </script>
</body>

</html>
