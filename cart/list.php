<?php
session_start();
require_once("../connect.php"); // 引用連線
$previous_url = $_SERVER['HTTP_REFERER']; // 判斷上一頁是哪一頁

$pid_ary = [];
if(isset($_SESSION["cart"])){
  foreach($_SESSION["cart"] as $pt){
    array_push($pid_ary, $pt["id"]);
  }
  $ids = implode(",", $pid_ary);
}

$totalMoney = 0;
if(count($pid_ary) > 0){
  $sql = "SELECT product.*, product_img.file
    FROM product
    LEFT JOIN product_img
    ON product.id = product_img.pid
    WHERE product.id IN ($ids)
    GROUP BY product.id";
  try {
    $result = $conn->query($sql);
    $pdCount = $result->num_rows;
    $pds = $result->fetch_all(MYSQLI_ASSOC);
    for($i=0; $i < $pdCount; $i++){
      $pid = "s".$pds[$i]["id"];
      $pds[$i]["file"] = explode(",", $pds[$i]["file"]);
      $pds[$i]["num"] = $_SESSION["cart"][$pid]["num"];
      $totalMoney += ($pds[$i]["price"]*$_SESSION["cart"][$pid]["num"]);
    }
  } catch (mysqli_sql_exception $exception) {
    $error = "資料讀取錯誤：" . $conn->error;
  }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>我的購物車</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/cart.css">
  </head>
  <body>
    <div class="container my-3">
      <div class="mb-3">
        <span class="h1 align-middle">我的購物車</span>
        <a href="<?=$previous_url?>" class="btn btn-primary btn-sm">回賣場</a>
      </div>
      <div class="cart">
        <div class="pt head bg-primary text-light rounded-top">
          <div class="sn text-center">序號</div>
          <div class="name">產品名稱</div>
          <div class="price  text-center">單價</div>
          <div class="num">數量</div>
          <div class="price  text-center">小計</div>
          <div class="ctrl">管理</div>
        </div>
        <?php if(count($pid_ary) > 0): ?>
          <?php foreach($pds as $index => $pd): ?>
            <div class="pt py-1">
              <div class="sn text-center"><?=$index+1?></div>
              <div class="name"><?=$pd["name"]?></div>
              <div class="price text-center"><?=$pd["price"]?></div>
              <div class="num">
                <div class="input-group input-group-sm">
                  <div price="<?=$pd["price"]?>" idn="<?=$pd["id"]?>" class="btn btn-primary btn-sm btn-addNum">+</div>
                  <input id="num<?=$pd["id"]?>" type="text" readonly class="form-control text-center ptotal" value="<?=$_SESSION["cart"]["s".$pd["id"]]["num"]?>">
                  <div price="<?=$pd["price"]?>" idn="<?=$pd["id"]?>" class="btn btn-primary btn-sm btn-delNum">-</div>
                </div>
              </div>
              <div id="tt<?=$pd["id"]?>" class="price text-center"><?=$pd["num"]*$pd["price"]?></div>
              <div class="ctrl">
                <a href="./doDel.php?pid=<?=$pd["id"]?>" class="btn btn-danger btn-sm delOne">刪除</a>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?> 
        <div class="bg-primary rounded-bottom text-end p-1 pe-3">
          <span class="bg-white p-1 ps-3 pe-3 pb-2 rounded totalAll"><?=$totalMoney?></span>
          <a href="./add.php" class="btn btn-info btn-sm">結帳</a>
        </div>
      </div>
    </div>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script>
      let btnAdds = document.querySelectorAll(".btn-addNum");
      let btnDels = document.querySelectorAll(".btn-delNum");
      btnAdds.forEach(function(btnAdd){
        btnAdd.addEventListener("click", function(){
          let id = this.getAttribute("idn");
          let price = parseInt(this.getAttribute("price"));
          let num = parseInt(document.querySelector("#num"+id).value);
          let newNum = num+1;
          document.querySelector("#num"+id).value = newNum;
          console.log(newNum)
          document.querySelector("#tt"+id).innerHTML = newNum*price;
          changeNum(id, "up");
          countAll();
        });
      });
      btnDels.forEach(function(btnDel){
        btnDel.addEventListener("click", function(){
          let id = this.getAttribute("idn");
          let price = parseInt(this.getAttribute("price"));
          let num = parseInt(document.querySelector("#num"+id).value);
          let newNum = num-1;
          if(newNum<=0){
            newNum=0;
          }
          document.querySelector("#num"+id).value = newNum;
          document.querySelector("#tt"+id).innerHTML = newNum*price;
          changeNum(id, "dw");
          countAll();
          if(newNum == 0){
            alert("產品數量為 0，將移除這項產品");
            window.location.href = `./doDel.php?pid=${id}`;
          }
        });
      });

      function countAll(){
        let total = 0;
        let totalAll = document.querySelector(".totalAll");
        let pts = document.querySelectorAll(".pt");
        pts.forEach(function(pt){
          if(pt.querySelector("input") != null){
            let price = parseInt(pt.querySelector(".price").innerHTML);
            let num = parseInt(pt.querySelector("input").value);
            total += (price*num);
          }
        });
        totalAll.innerHTML = total;
      }

      function changeNum(id,way){
        let url = `./apiChangeNum.php?id=${id}&way=${way}`
        fetch(url)
          .then(function(response){
            return response.json();
          })
          .then(function(result){
            console.log(result)
          })
          .catch(function(error){
            console.log(error);
          });
      }
    </script>
  </body>
</html>