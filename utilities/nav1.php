<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
  $uri = 'https://';
} else {
  $uri = 'http://';
}
$uri .= $_SERVER['HTTP_HOST'];
if(!isset($_SESSION["user"])){
  header('Location: '.$uri.'/user/login.php');
  exit;
}
?>
<nav class="nav1">
  <div class="btn btn-primary btn-open position-absolute r1 rounded-end">o</div>
  <div>
    <div>
      <img class="imgHead" src="../uimg/<?=$_SESSION["user"]["img"]?>" alt="">
    </div>
    <?=$_SESSION["user"]["name"]?>
  </div>
  <a href="../user/doLogout.php" class="btn btn-primary btn-sm d-block">登出</a>
  <ul>
    <?php if(intval($_SESSION["user"]["level"]) >= 9): ?>
      <li><a href="../user/list.php">使用者管理</a></li>
    <?php endif; ?>
    <li><a href="../category/list.php">分類管理</a></li>
    <li><a href="../tag/list.php">標籤管理</a></li>
    <li><a href="../product/list.php">產品管理</a></li>
    <li><a href="../order/list.php">購買記錄</a></li>
    <li><a href="../order/list2.php">訂單管理</a></li>
  </ul>
</nav>
<script>
  let btnOpen = document.querySelector(".btn-open");
  btnOpen.addEventListener("click", function(){
    this.closest("nav").classList.toggle("close")
  })
</script>