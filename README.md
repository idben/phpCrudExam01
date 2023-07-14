# CRUD範例
## 更新日期
20230714 0823
## 資料庫
. 資料庫名 myProject
. 資料表內容在 (/data) 中
## 內容分類
1. 使用者 (/user)
2. 分類 (/category)
3. tag (/tag)
4. 產品 (/product)
5. 登入登出 (/user)
6. 狀態與導覽列 (/utilities/nav.php)
7. 一些 alert 與導頁 (/utilities/alertFunc.php)
8. 根目錄下的 admin.php 是主要入口
9. 連線設定在根目錄下的 connect.php
## 路徑
. 目前這個專案預設是直接放在 XAMPP 的 htdocs 下。
. 如果需要在 htdocs 下建立子目錄來放這個專案，記得改寫 admin.php 中的路徑，加上子目錄名稱：
```php
$uri .= $_SERVER['HTTP_HOST'] ."/子目錄名稱";
```
. 這樣的修改在使用上網址只要打 http://localhost/子目錄名稱/admin.php 就會導向註冊頁面。
. 除了這個地方的路徑有修改外，在 utilities/nav1.php 中，也有同樣的一句，也需要做同樣的修改。