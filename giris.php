<?php
if($_POST){
    $vtbaglan=new mysqli("localhost","root","","vt_242703017");
    $kulad=$_POST["kad"];
    $kuls=$_POST["ks"];
    $sql_test="SELECT * FROM dnc_yoneticiler where dnc_kullanici='$kulad' and dnc_sifre='$kuls'";
    $sonuc=$vtbaglan->query($sql_test);
    //print_r($sonuc);
    if($sonuc->num_rows>0){
        //echo "OK";
        session_start();
        $_SESSION["kullanici"]="$kulad";
        header('Location:anasayfa.php');
    }
    else
        {
            //echo"OPSSS";
            header('Location:giris.php');
        }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Hatalı</title>
    <style>
        body { 
            background-color: #0f3460; color: white; font-family: 'Segoe UI', Tahoma, sans-serif; 
            display: flex; flex-direction: column; justify-content: center; align-items: center; height: 100vh; margin: 0; 
        }
        h1 { color: #ff6b6b; text-shadow: 2px 2px 4px rgba(0,0,0,0.3); text-align: center; }
        form { background: rgba(255, 255, 255, 0.1); padding: 40px; border-radius: 15px; box-shadow: 0 8px 32px rgba(0,0,0,0.3); width: 320px; text-align: center; }
        pre { font-family: inherit; font-size: 16px; margin: 0; white-space: normal; }
        input[type="text"], input[type="password"] { display: block; width: 100%; padding: 10px; border-radius: 5px; border: none; margin: 10px 0 20px 0; box-sizing: border-box; }
        input[type="submit"], input[type="reset"] { padding: 12px 15px; border-radius: 5px; border: none; cursor: pointer; font-weight: bold; margin: 5px; }
        input[type="submit"] { background-color: #4CAF50; color: white; }
        input[type="submit"]:hover { background-color: #45a049; }
        input[type="reset"] { background-color: #ddd; color: #333; }
        input[type="reset"]:hover { background-color: #ccc; }
    </style>
</head>
<body>
    <h1>Kullanıcı Adı/Şifre Hatalı!!!</h1>
    <form action="#" method="post">
        <pre align="center">
        Kullanıcı Adı:  <input type="text" name="kad">
        Kullanıcı Şifre:<input type="password" name="ks">
                        <input type="submit" value="Sisteme Giriş"> <input type="reset" value="İptal Et">
                        
        </pre>
    </form>
</body>
</html>