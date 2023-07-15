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
  unset($_SESSION["cart"][$newid]);
  alertAndGoBack("已移除產品");
  exit;
}else{
  alertAndGoBack("入購物車內沒有相對的產品!");
}
