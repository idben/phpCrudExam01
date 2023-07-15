<?php
session_start();
$stopLogin = false;
if(isset($_SESSION["error"])){
  $times = $_SESSION["error"]["times"];
  $timestamp = $_SESSION["error"]["timestamp"];
  $timeNow = time();
  $dTime = abs($timeNow - $timestamp) / 60;
  if($times > 5 && $dTime < 2){
    $stopLogin = true;
  }
}
$status = isset($_GET["status"])?$_GET["status"]:0;
$uid = isset($_GET["uid"])?$_GET["uid"]:"";
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>登入</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
      .block{
        width: 300px;
        height: 250px;
      }
      .block2{
        width: 300px;
        height: 300px;
      }
    </style>
  </head>
  <body>
    <div class="block bg-primary-subtle p-3 position-absolute start-0 end-0 m-auto rounded-2 mt-5 <?=$stopLogin?"block2":""?>">
      <h1>登入</h1>
      <?php if($stopLogin): ?>
        <div class="tip text-danger">您已超過登入錯誤次數，請稍後再登入</div>
      <?php endif; ?>
      <form action="./doLogin.php" method="post">
        <input type="hidden" name="status" value="<?=$status?>">
        <input type="hidden" name="uid" value="<?=$uid?>">
        <input type="text" name="email" class="form-control mb-1" placeholder="使用者帳號">
        <input type="password" name="password1" class="form-control mb-1" placeholder="使用者密碼">
        <input type="password" name="password2" class="form-control mb-1" placeholder="再輸入一次使用者密碼">
        <div class="text-end">
          <button class="btn btn-info btn-send me-1" <?=$stopLogin?"disabled hidden":""?>>送出</button>
          <a class="btn btn-info btn-send">註冊</a>
        </div>
      </form>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      let btnSend = document.querySelector(".btn-send");
      let form = document.querySelector("form");
      btnSend.addEventListener("click", function(e){
        e.preventDefault();
        let email = document.querySelector("input[name=email]").value;
        let pwd1 = document.querySelector("input[name=password1]").value;
        let pwd2 = document.querySelector("input[name=password1]").value;
        if(email === ""){
          alert("請輸入使用者帳號");
          return false;
        }
        if(pwd1 === ""){
          alert("請輸入密碼");
          return false;
        }
        if(pwd2 === ""){
          alert("請再輸入一次密碼");
          return false;
        }
        if(pwd1 !== pwd2){
          alert("兩次密碼不一致");
          return false;
        }
        form.submit();
      });
    </script>
  </body>
</html>