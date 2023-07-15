<?php
session_start();
require_once("../utilities/alertFunc.php"); // 引用常用函數
if(!isset($_GET["pid"])){
  alertAndGoBack("請由正常管道進入!!!");
  exit;
}else{
  $pid = $_GET["pid"];
}

$newid = "s".$pid;
if(isset($_SESSION["cart"][$newid])){
  $_SESSION["cart"][$pid]["num"] +=1;
  alertAndGoBack("產品數量加一");
  exit;
}else{
  $_SESSION["cart"][$newid] = [
    "id" => $pid,
    "num" => 1
  ];
  alertAndGoBack("已加入購物車!");
}
