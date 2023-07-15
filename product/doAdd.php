<?php
session_start();
require_once("../connect.php"); // 引用連線
require_once("../utilities/alertFunc.php"); // 引用常用函數

if(!isset($_POST["name"])){
  echo "請由正式方法進入頁面";
  exit;
}


// 整理表單變數
$name = htmlspecialchars($_POST["name"]);
$price = intval($_POST["price"]);
$category = intval($_POST["category"]);
$info = $_POST["info"];
if(isset($_POST["tag"])){
  $tags = $_POST["tag"]; 
}else{
  $tags = array();
}
$uid = $_SESSION["user"]["id"];


// 整理 SQL
$sql = "INSERT INTO `product` 
  (`id`, `uid`, `name`, `price`, `category`, `info`, `createTime`) VALUES 
  (NULL, $uid, '$name', $price, $category, '$info', CURRENT_TIMESTAMP);";

// 寫入資料庫
try {
  $conn->query($sql);
  $pid = $conn->insert_id;
} catch (mysqli_sql_exception $exception) {
  alertAndGoToList("產品新增錯誤：" .$conn->error);
  exit;
}

if(count($tags) > 0){
  $sql = "";
  for($i=0; $i<count($tags); $i++){
    $tid = intval($tags[$i]);
    $sql .= "INSERT INTO `product_tag` 
      (`id`, `pid`, `tid`) VALUES 
      (NULL, $pid, $tid);";
  }
  // 寫入 product_tag 資料庫
  try {
    $conn->multi_query($sql);
    while ($conn->more_results() && $conn->next_result()) { 
      // 不做任何事情，只是將結果清除掉 
    }
  } catch (mysqli_sql_exception $exception) {
    // echo "加入 tag 發生錯誤：" .$conn->error;
    alertAndGoToList("加入 tag 發生錯誤");
    exit;
  }
}


$sql = "";
$fileCount = count($_FILES['myFile']['name']);
$timestemp = time();
for($i=0; $i<$fileCount; $i++){
  if($_FILES["myFile"]["error"][$i] == 0){
    $ext = pathinfo($_FILES["myFile"]['name'][$i], PATHINFO_EXTENSION);
    $newFileName = ($timestemp + $i) . "." . $ext;
    if(move_uploaded_file($_FILES["myFile"]["tmp_name"][$i], "../pimg/".$newFileName)){
      $sql .= "INSERT INTO `product_img` 
        (`id`, `pid`, `file`, `createTime`) VALUES 
        (NULL, $pid, '$newFileName', CURRENT_TIMESTAMP);";
    }
  }
}

// 寫入 product_img 資料庫
try {
  $conn->multi_query($sql);
  while ($conn->more_results() && $conn->next_result()) { 
    // 不做任何事情，只是將結果清除掉 
  }
  alertAndGoToList("產品新增成功");
} catch (mysqli_sql_exception $exception) {
  // echo "加入 tag 發生錯誤：" .$conn->error;
  alertAndGoToList("產品圖加入發生錯誤");

}

$conn->close();
