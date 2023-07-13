<?php
require_once("../connect.php"); // 引用連線
require_once("../utilities/alertFunc.php"); // 引用常用函數

$sql = "SELECT * FROM `category` WHERE `isValid` = 1";
$result = $conn->query($sql);
$categoryRows = $result->fetch_all(MYSQLI_ASSOC);
$categoryCount = $result->num_rows;

$sql = "SELECT * FROM `tag` WHERE `isValid` = 1";
$result = $conn->query($sql);
$tagRows = $result->fetch_all(MYSQLI_ASSOC);
$tagCount = $result->num_rows;

$conn->close();
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>增加產品</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/admin.css">
  </head>
  <body>
    <?php require("../utilities/nav1.php"); ?>
    <div class="container my-3">
      <h1>增加產品<span class="badge text-bg-info fs-6 align-middle ms-1">表單</span></h1>
      <form action="./doAdd.php" method="post" enctype="multipart/form-data">
        <div class="input-group mb-1">
          <span class="input-group-text">產品名稱</span>
          <input name="name" type="text" class="form-control" placeholder="輸入產品名稱">
        </div>
        <div class="input-group mb-1">
          <span class="input-group-text">產品價錢</span>
          <input name="price" type="number" class="form-control" placeholder="輸入產品價錢">
        </div>
        <div class="input-group mb-1">
          <span class="input-group-text">產品描述</span>
          <textarea name="info" type="number" class="form-control" placeholder="輸入產品描述"></textarea>
        </div>
        <div class="mb-1 d-flex">
          <span class="bg-light p-2 border rounded-start">tag</span>
          <div class="w-100 border border-start-0 p-2">
            <?php foreach($tagRows as $tagRow): ?>
              <div class="d-inline-block p-1 mb-1 px-2 rounded bg-warning-subtle">
                <input name="tag[]" id="tag<?=$tagRow["id"]?>" class=" mt-0" type="checkbox" value="<?=$tagRow["id"]?>">
                <label class="ms-1 me-2" for="tag<?=$tagRow["id"]?>"><?=$tagRow["name"]?></label>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
        <div class="input-group mt-1">
          <span class="input-group-text">分類</span>
          <select name="category" class="form-select">
            <option value disabled selected>請選擇</option>
            <?php foreach($categoryRows as $catRow): ?>
              <option value="<?=$catRow["id"]?>"><?=$catRow["name"]?></option>
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
        if(files.length === 1){
          if(files[0].value == ""){
            alert("請選擇產品圖");
            return false;
          };
        }else{
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
    </script>
  </body>
</html>