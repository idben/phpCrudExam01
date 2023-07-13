<?php
require_once("../connect.php");
require_once("../utilities/alertFunc.php");

if (!isset($_GET["id"])) {
  echo "請由正式方法進入頁面";
  exit;
}

$id = intval($_GET["id"]);
$sql = "SELECT 
  product.*, 
  GROUP_CONCAT(DISTINCT product_img.file) as files,
  GROUP_CONCAT(DISTINCT product_img.id) as fileIDs,
  GROUP_CONCAT(DISTINCT product_tag.tid) as tagIDs
  FROM 
  product
  LEFT JOIN 
  product_img ON product.id = product_img.pid
  LEFT JOIN
  product_tag ON product.id = product_tag.pid
  WHERE 
  product.id = $id
  GROUP BY 
product.id;";
try {
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
} catch (mysqli_sql_exception $exception) {
  $row = "ERROR";
}
if ($row == "ERROR" || $row == NULL) {
  alertAndGoToList("讀取錯誤，請洽管理人員");
  exit;
}

$fileIDs = explode(",", $row["fileIDs"]);
$files = explode(",", $row["files"]);
$tags = explode(",", $row["tagIDs"]);

$sql = "SELECT * FROM `category` WHERE `isValid` = 1";
$result = $conn->query($sql);
$categoryRows = $result->fetch_all(MYSQLI_ASSOC);
$categoryCount = $result->num_rows;

$sql = "SELECT * FROM `tag` WHERE `isValid` = 1";
$result = $conn->query($sql);
$tagRows = $result->fetch_all(MYSQLI_ASSOC);
$tagCount = $result->num_rows;
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>產品管理</title>
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/admin.css">
</head>

<body>
  <?php require("../utilities/nav1.php"); ?>
  <div class="container my-3">
    <h1>產品管理<span class="badge text-bg-info fs-6 align-middle ms-1">表單</span></h1>
    <form action="./doUpdate.php" method="post" enctype="multipart/form-data">
      <!-- 隱藏欄位產品編號 -->
      <input type="hidden" name="id" value="<?= $row["id"] ?>">
      <div class="input-group mb-1">
          <span class="input-group-text">產品名稱</span>
          <input name="name" type="text" class="form-control" placeholder="輸入產品名稱" value="<?=$row["name"]?>">
        </div>
        <div class="input-group mb-1">
          <span class="input-group-text">產品價錢</span>
          <input name="price" type="number" class="form-control" placeholder="輸入產品價錢" value="<?=$row["price"]?>">
        </div>
        <div class="input-group mb-1">
          <span class="input-group-text">產品描述</span>
          <textarea name="info" type="number" class="form-control" placeholder="輸入產品描述" ><?=$row["info"]?></textarea>
        </div>
        <div class="mb-1 d-flex">
          <span class="bg-light p-2 border rounded-start">tag</span>
          <div class="w-100 border border-start-0 p-2">
            <?php foreach($tagRows as $tagRow): ?>
              <div class="d-inline-block p-1 mb-1 px-2 rounded bg-warning-subtle">
                <input name="tag[]" id="tag<?=$tagRow["id"]?>" class="mt-0" type="checkbox" value="<?=$tagRow["id"]?>" <?php echo in_array($tagRow["id"], $tags)?"checked":""; ?>>
                <label class="ms-1 me-2" for="tag<?=$tagRow["id"]?>"><?=$tagRow["name"]?></label>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
        <div class="input-group mt-1">
          <span class="input-group-text">分類</span>
          <select name="category" class="form-select">
            <option value disabled>請選擇</option>
            <?php foreach($categoryRows as $catRow): ?>
              <option value="<?=$catRow["id"]?>" <?=($catRow["id"]==$row["category"])?"selected":""?>><?=$catRow["name"]?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="myFiles">
          <div class="input-group mt-1">
            <span class="input-group-text">產品圖</span>
            <input class="form-control" type="file" name="myFile[]" accept=".png,.jpg,.jpeg">
            <div class="btn btn-info btn-add-file">+</div>
          </div>
        </div>
      <div class="mt-1 text-end">
        <button type="submit" class="btn btn-primary btn-send">送出</button>
        <a class="btn btn-info" href="./list.php">取消</a>
      </div>
    </form>
    <div class="product">
      <?php foreach($files as $index => $file): ?>
        <img class="pimg delImg" src="../pimg/<?=$file?>" pid="<?=$id?>" idn="<?=$fileIDs[$index]?>" alt="">
      <?php endforeach; ?>
    </div>
  </div>
  <template id="myFile">
    <div class="input-group mt-1 pdUnit">
      <span class="input-group-text">產品圖</span>
      <input class="form-control" type="file" name="myFile[]" accept=".png,.jpg,.jpeg">
      <div class="btn btn-danger btn-del-file">-</div>
    </div>
  </template>
  <script src="../js/bootstrap.bundle.min.js"></script>
  <script>
    const form = document.querySelector("form");
    const btnSend = document.querySelector(".btn-send");
    btnSend.addEventListener("click", function(e){
        e.preventDefault();
        let name = document.querySelector("input[name=name]").value;
        let price = document.querySelector("input[name=price]").value;
        let info = document.querySelector("textarea").value;
        let category = document.querySelector("select").value;
        let files = document.querySelectorAll("input[type=file]");
        if(name == ""){
          alert("請填寫產品名稱");
          return false;
        }
        if(price == ""){
          alert("請填寫產品價錢");
          return false;
        }
        if(info == ""){
          alert("請填寫產品描述");
          return false;
        }
        if(category == ""){
          alert("請選擇產品分類");
          return false;
        }
        if(files.length > 1){
          let empty = false;
          files.forEach(function(file){
            if(file.value == ""){
              empty = true;
            }
          })
          if(empty === true){
            alert("請選擇產品圖");
            return false;
          }
        }
        form.submit();
      })

    const btnAddFile = document.querySelector(".btn-add-file");
      const myFiles = document.querySelector(".myFiles");
      btnAddFile.addEventListener("click", function(e){
        e.preventDefault();
        let template = document.querySelector("#myFile");
        let dom = template.content.cloneNode(true);
        removeEvent();
        myFiles.append(dom);
        setDelFileBtn();
      })

      function removeEvent(){
        const btnDelFiles = document.querySelectorAll(".btn-del-file");
        [...btnDelFiles].map(function(btn){
          btn.removeEventListener("click", _aa);
        });
      }

      function setDelFileBtn(){
        const btnDelFiles = document.querySelectorAll(".btn-del-file");
        [...btnDelFiles].map(function(btn){
          btn.addEventListener("click", _aa);
        });
      }
      function _aa(e){
        let tg = e.currentTarget;
        let dom = tg.closest(".pdUnit");
        dom.remove();
      }


    let delImgs = document.querySelectorAll(".delImg");
    delImgs.forEach(function(img){
      img.addEventListener("click", function(e) {
        let id = this.getAttribute("idn");
        let pid = this.getAttribute("pid");
        if(confirm("確定要刪除圖片？")){
          window.location.href = `./doDelImg.php?id=${id}&pid=${pid}`;
        }
      });
    })
  </script>
</body>

</html>