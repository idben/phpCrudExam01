<?php
session_start();
require_once("../connect.php");
require_once("../utilities/alertFunc.php"); // 引用常用函數

if(!isset($_POST["email"])){
  echo "請循正常管道進入本頁";
  exit;
}

$email = $_POST["email"];
$password1 = $_POST["password1"];
$password2 = $_POST["password2"];


$sql = "SELECT * FROM user WHERE email = '$email'";

try {
  $result = $conn->query($sql);
  $userCount = $result->num_rows;
  if($userCount > 0){
    $row = $result->fetch_assoc();
    if (password_verify($password1, $row["password"])) {
      $_SESSION["user"] = [
        "id"=>$row["id"],
        "name"=>$row["name"],
        "email"=>$row["email"],
        "level"=>$row["level"],
        "img"=>$row["img"]
      ];
      unset($_SESSION["error"]);
      header("location: ../admin.php");
    } else {
      loginFailed();
    }
  }else{
    loginFailed();
  }
} catch (mysqli_sql_exception $exception) {
  $result = "error";
}




function loginFailed(){
  if(!isset($_SESSION["error"]["times"])){
    $_SESSION["error"]["times"] = 1;
  }else{
    $_SESSION["error"]["times"]++;
    $dTime = abs(time()- $_SESSION["error"]["timestamp"]) / 60;
    if($dTime > 2){
      $_SESSION["error"]["times"] = 1;
    }
  }
  $_SESSION["error"]["timestamp"] = time();
  $_SESSION["error"]["message"] = "登入失敗，請確認帳號碼";
  unset($_SESSION["user"]);
  alertAndGoBack("登入失敗，請確認帳號碼！");
}
