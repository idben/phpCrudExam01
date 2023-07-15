<?php
require_once("../utilities/alertFunc.php");
session_start();
session_destroy();

$status = isset($_GET["status"]) ? $_GET["status"] : 0;
$uid = isset($_GET["uid"]) ? $_GET["uid"] : 0;

if($status == 1){
  $url = "../index.php?";
  if($uid != 0){
    $url .= "&uid=" . $uid;
  }
  alertAndBackToPage("您已登出系統", $url);
}else{
  alertAndGoToList("您已登出系統");
}
