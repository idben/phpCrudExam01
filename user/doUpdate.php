<?php
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
$level = $_POST["level"];
$img = $_POST["img"];

// 檢查是密碼是否正確
$pwdCheck = false;
$sql = "SELECT * FROM user WHERE id = $id";
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

// 由上傳檔的的檔名來組合不同的 SQL
if($newImg != ""){
  $sql = "UPDATE user SET `name` = '$name', `password` = '$password', `level` = '$level', `img` = '$newImg', `modifyTime` = CURRENT_TIMESTAMP WHERE id = $id;";
}else{
  $sql = "UPDATE user SET `name` = '$name', `password` = '$password', `level` = '$level', `img` = '$img', `modifyTime` = CURRENT_TIMESTAMP WHERE id = $id;";
}

// 寫入資料庫，將結果存在變數 error
$error = "";
try {
  $conn->query($sql);
} catch (mysqli_sql_exception $exception) {
  $error = $exception->getMessage();
}

$conn->close();

// 由變數 error 來判斷要轉跳回列表，或失敗了回上一頁
if($error === ""){
  alertAndGoToList("資料修改成功");
  exit;
}else{
  alertAndGoBack("資料修改錯誤：" .$error);
  exit;
}

