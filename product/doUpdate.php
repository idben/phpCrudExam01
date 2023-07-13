<?php
require_once("../connect.php");
require_once("../utilities/alertFunc.php");

if(!isset($_POST["id"])){
  echo "請由正式方法進入頁面";
  exit;
}


// 整理表單變數
$id = $_POST["id"];
$name = htmlspecialchars($_POST["name"]);
$price = intval($_POST["price"]);
$category = intval($_POST["category"]);
$info = $_POST["info"];
if(isset($_POST["tag"])){
  $tags = $_POST["tag"]; 
}else{
  $tags = array();
}

$sql = "UPDATE product 
  SET 
  `name` = '$name', 
  `price` = $price, 
  `category` = $category, 
  `info` = '$info', 
  `modifyTime` = CURRENT_TIMESTAMP 
  WHERE id = $id;";


// 寫入資料庫，將結果存在變數 error
$error = "";
try {
  $conn->query($sql);
} catch (mysqli_sql_exception $exception) {
  $error = $exception->getMessage();
}

// 由變數 error 來判斷要轉跳回列表，或失敗了回上一頁
if($error === ""){

}else{
  alertAndGoBack("產品修改錯誤：" .$error);
  exit;
}

// 寫入 tag
// 先把原有的 tag 移除再加入
if(count($tags) > 0){
  $sql = "DELETE FROM product_tag WHERE pid = $id;";
  for($i=0; $i<count($tags); $i++){
    $tid = intval($tags[$i]);
    $sql .= "INSERT INTO `product_tag` 
      (`id`, `pid`, `tid`) VALUES 
      (NULL, $id, $tid);";
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

// 處理圖片
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
        (NULL, $id, '$newFileName', CURRENT_TIMESTAMP);";
    }
  }
}

// 寫入 product_img 資料庫
// 如果有新的照片的話才做事
if($sql !== ""){
  try {
    $conn->multi_query($sql);
    while ($conn->more_results() && $conn->next_result()) { 
      // 不做任何事情，只是將結果清除掉 
    }
    alertAndGoToList("產品修改成功");
  } catch (mysqli_sql_exception $exception) {
    // echo "加入 tag 發生錯誤：" .$conn->error;
    alertAndGoToList("產品圖加入發生錯誤");
  
  }
}else{
  alertAndGoToList("產品修改成功");
}
$conn->close();