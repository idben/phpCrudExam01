<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>增加使用者</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/admin.css">
  </head>
  <body>
    <?php require("../utilities/nav1.php"); ?>
    <div class="container my-3">
      <h1>增加使用者<span class="badge text-bg-info fs-6 align-middle ms-1">表單</span></h1>
      <form action="./doAdd.php" method="post" enctype="multipart/form-data">
        <div class="input-group mb-1">
          <span class="input-group-text">信箱</span>
          <input name="email" type="text" class="form-control" placeholder="使用者信箱">
        </div>
        <div class="input-group mb-1">
          <span class="input-group-text">密碼1</span>
          <input name="password" type="password" class="form-control" placeholder="使用者密碼">
        </div>
        <div class="input-group mb-1">
          <span class="input-group-text">密碼2</span>
          <input name="password2" type="password" class="form-control" placeholder="確認密碼，再輸入一次">
        </div>
        <div class="input-group mb-1">
          <span class="input-group-text">姓名</span>
          <input name="name" type="text" class="form-control" placeholder="使用者姓名">
        </div>
        <div class="input-group mt-1">
          <input class="form-control" type="file" name="myFile" accept=".png,.jpg,.jpeg">
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
      btnSend.addEventListener("click", function(e){
        e.preventDefault();
        let email = document.querySelector("input[name=email]").value;
        let pwd1 = document.querySelector("input[name=password]").value;
        let pwd2 = document.querySelector("input[name=password2]").value;
        let name = document.querySelector("input[name=name]").value;
        let img = document.querySelector("input[name=myFile]").value;
        if(email == ""){
          alert("請填寫信箱");
          return false;
        }
        if(pwd1 == ""){
          alert("請填寫密碼");
          return false;
        }
        if(pwd2 == ""){
          alert("請填確認密碼");
          return false;
        }
        if(pwd2 != pwd1){
          alert("請填確認密碼");
          return false;
        }
        if(name == ""){
          alert("請填寫姓名");
          return false;
        }
        if(img == ""){
          alert("請選擇使用者照片");
          return false;
        }
        form.submit();
      })
    </script>
  </body>
</html>