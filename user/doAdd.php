<?php
require_once("../connect.php"); // 引用連線
require_once("../utilities/alertFunc.php"); // 引用常用函數

if(!isset($_POST["email"])){
  echo "請由正式方法進入頁面";
  exit;
}

// 檢查是否有使用過 email
$email = $_POST["email"];
$sql = "SELECT * FROM user WHERE email = '$email'";
try {
  $result = $conn->query($sql);
} catch (mysqli_sql_exception $exception) {
  $result = "error";
}
if($result == "erroe"){
  alertAndGoBack("發生錯誤，請洽管理人員");
  exit;
}else if($result->num_rows > 0){
  alertAndGoBack("該帳號已經存在");
  exit;
}


// 整理表單變數
$name = htmlspecialchars($_POST["name"]);
$password = password_hash($_POST["password"], PASSWORD_BCRYPT);
// 上傳圖片
$img = "";
if($_FILES["myFile"]["error"] == 0){
  $timestemp = time();
  $ext = pathinfo($_FILES["myFile"]['name'], PATHINFO_EXTENSION);
  $newFileName = $timestemp . "." . $ext;
  if(move_uploaded_file($_FILES["myFile"]["tmp_name"], "../uimg/".$newFileName)){
    $img = $newFileName;
  }
}

// 整理 SQL
$sql = "INSERT INTO `user` 
  (`id`, `email`, `name`, `password`, `img`, `createTime`) VALUES 
  (NULL, '$email', '$name', '$password', '$img', CURRENT_TIMESTAMP);";
// 寫入資料庫
try {
  $conn->query($sql);
  alertAndGoToList("帳號新增成功");
} catch (mysqli_sql_exception $exception) {
  alertAndGoToList("帳號新增錯誤：" .$conn->error);
}
$conn->close();
