<?php
// 通知的小視窗加上回列表
function alertAndGoToList($msg){
  echo "<script>
    alert(\"$msg\");
    window.location.href = \"./list.php\";
  </script>";
}
// 通知的小視窗加上回上一頁
function alertAndGoBack($msg){
  echo "<script>
    alert(\"$msg\");
    window.history.back();
  </script>";
}
// 通知的小視窗加上回上一頁
function alertAndBackToPage($msg, $page){
  echo "<script>
    alert(\"$msg\");
    window.location.href = \"$page\";
  </script>";
}