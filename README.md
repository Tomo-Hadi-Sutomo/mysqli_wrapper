# mysqli_wrapper
Mysqli Wrapper untuk PHP lama.
Mengatasi deprecated mysql functions pada PHP > 5.5.0 dan removed pada PHP > 7.0.0  Dengan wrapper ini, maka Anda tetap bisa menggunakan mysql function yang telah deprecated pada lingkungan PHP > 5.5.0.0 , maupun removed pada lingkungan PHP 7.0.0 
Caranya tinggal includkan saja file ini pada file koneksi (.php) Anda.
```
//wajib require atau include file mysql.php
require_once ('mysql.php');

//script dibawah ini mandatory dan bisa bervariasi sesuai dengan script koneksi mysql Anda.
$host	= "localhost";	
$user	= "namauser";
$pass	= "passwordmysql";
$db	= "namadatabase";
$kon = mysql_connect($host, $user, $pass);
$kondb = mysql_select_db($db, $kon);
```
