<?php
session_start();
if(!isset($_GET["id"])){
  echo "請由正常管道進入";
  exit;
}

$msg = "";
$way = $_GET["way"];
$pid = "s".$_GET["id"];
if(isset($_SESSION["cart"][$pid])){
  if($way == "up"){
    $_SESSION["cart"][$pid]["num"] +=1;
    $msg = "產品數量已加一";
  }else{
    $_SESSION["cart"][$pid]["num"] -=1;
    if($_SESSION["cart"][$pid]["num"] <= 0){
      $_SESSION["cart"][$pid]["num"] = 0;
    }
    $msg = "產品數量已減一";
  }
}



$result = new stdClass();
$result -> result = $msg;
$json = json_encode($result);

echo $json;