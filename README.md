# mysqli_wrapper
Mysqli Wrapper untuk PHP lama.
Mengatasi deprecated mysql functions pada PHP 7. Dengan wrapper ini, maka Anda bisa tetap menggunakan mysql function yang te;ah deprecated, pada lingkungan PHP 7. 
caranya tinggal includkan saja file ini pada file koneksi Anda.
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
