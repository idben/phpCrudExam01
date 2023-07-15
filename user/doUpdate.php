<?php
session_start();
require_once("../connect.php");
require_once("../utilities/alertFunc.php");

if(!isset($_POST["id"])){
  echo "請由正式方法進入頁面";
  exit;
}

// 收集表單變數
$id = intval($_POST["id"]);
$email = $_POST["email"];
$password = $_POST["password"];
$password2 = $_POST["password2"];
$password3 = $_POST["password3"];
$name = htmlspecialchars($_POST["name"]); // 移除 html 標籤
// 判斷有沒有 level 這個表單變數，有的話就設定同名變數為表單變數
// 沒有的話就什麼都不做，這時候就不會有 $level 這個變數
if(isset($_POST["level"])){
  $level = intval($_POST["level"]);
}
$img = $_POST["img"];

// 檢查是密碼是否正確
$pwdCheck = false;
if($_SESSION["user"]["level"] == 9){
  // 如果是超級帳號，是可以管理別人帳號的，所以密碼是要判別超級超帳號的密碼
  $aid = $_SESSION["user"]["id"];
  $sql = "SELECT * FROM user WHERE id = $aid";
}else{
  // 其他的狀況則是自己修改自己資料，所以是判斷自己密碼
  $sql = "SELECT * FROM user WHERE id = $id";
}

try {
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  if (password_verify($password, $row["password"])) {
    $pwdCheck = true;
  }
} catch (mysqli_sql_exception $exception) {
  $pwdCheck = "error";
}

if($pwdCheck === "erroe"){
  alertAndGoBack("發生錯誤，請洽管理人員");
  exit;
}elseif($pwdCheck === false){
  alertAndGoBack("密碼與前次記錄不符");
  exit;
}

// 由 password3 是不是空白來判斷有沒有要更新密碼
// 不管有沒有更新，都重新寫入一次，這樣 SQL 可以少一個判斷
if(empty($password3)){
  $password = password_hash($password, PASSWORD_BCRYPT);
}else{
  $password = password_hash($password3, PASSWORD_BCRYPT);
}

// 上傳檔案
$newImg = "";
if($_FILES["myFile"]["error"] == 0){
  $timestemp = time();
  $ext = pathinfo($_FILES["myFile"]['name'], PATHINFO_EXTENSION);
  $newFileName = $timestemp . "." . $ext;
  if(move_uploaded_file($_FILES["myFile"]["tmp_name"], "../uimg/".$newFileName)){
    $newImg = $newFileName;
  }
}
// 如果有上傳新圖片，把變數 $img 設為新圖片
// 沒有的話則維持原圖片
// 這樣寫的話不管有沒有上傳圖片都可以用變數 $img
$img = ($newImg != "") ? $newImg : $img;

// SQL 分段寫
// 第二句判斷有沒有變數 $level，有的話把 `level`=$level 的語句加入
$sql = "UPDATE user SET `name` = '$name', `password` = '$password', " . 
    (isset($level) ? "`level` = $level, " : "") . 
    "`img` = '$img', `modifyTime` = CURRENT_TIMESTAMP WHERE id = $id;";

// 寫入資料庫，將結果存在變數 error
$error = "";
try {
  $conn->query($sql);
} catch (mysqli_sql_exception $exception) {
  $error = $exception->getMessage();
}
// 更新 SESSION，會讓大頭照及顯示名稱即時切換
if($_SESSION["user"]["id"] == $id){
  $_SESSION["user"]["name"] = $name;
  $_SESSION["user"]["img"] = $img;
}


// 由變數 error 來判斷要轉跳回列表，或失敗了回上一頁
// 上一頁是動態判斷
// 超級管理者有可能是從列表頁進來
// 一般使用者只會從 update.php 進來
$url = "./update.php?id=$id";
if($_SESSION["user"]["level"] == 9){
  $url = "./list.php";
}
if($error === ""){
  alertAndBackToPage("資料修改成功", $url);
  exit;
}else{
  alertAndBackToPage("資料修改錯誤：" .$error, $url);
  exit;
}

