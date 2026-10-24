<?php
session_start();
if(!isset($_SESSION["kullanici"])){ header('Location:giris2.php'); exit; }

$vtbaglan = new mysqli("localhost", "root", "", "vt_242703017");
$mesaj = "";


if(isset($_GET["sil"])){
    $sil_id = $_GET["sil"];
    $vtbaglan->query("DELETE FROM dnc_musteriler WHERE dnc_musteri_id='$sil_id'");
    header("Location: musteriler.php");
}


if($_POST){
    if(isset($_POST["musteri_ekle"])){
        $ad_soyad = $_POST["m_ad"];
        $telefon = $_POST["m_tel"];
        $vtbaglan->query("INSERT INTO dnc_musteriler (dnc_ad_soyad, dnc_telefon) VALUES ('$ad_soyad', '$telefon')");
        $mesaj = "<div class='basarili'>Yeni Müşteri Başarıyla Eklendi!</div>";
    }
    if(isset($_POST["musteri_guncelle"])){
        $guncel_id = $_POST["m_id"];
        $ad_soyad = $_POST["m_ad"];
        $telefon = $_POST["m_tel"];
        $vtbaglan->query("UPDATE dnc_musteriler SET dnc_ad_soyad='$ad_soyad', dnc_telefon='$telefon' WHERE dnc_musteri_id='$guncel_id'");
        $mesaj = "<div class='basarili'>Müşteri Bilgileri Güncellendi!</div>";
    }
}


$duzenle_modu = false;
$d_ad = ""; $d_tel = ""; $d_id = "";
if(isset($_GET["duzenle"])){
    $duzenle_id = $_GET["duzenle"];
    $bul = $vtbaglan->query("SELECT * FROM dnc_musteriler WHERE dnc_musteri_id='$duzenle_id'");
    if($g = $bul->fetch_assoc()){
        $duzenle_modu = true;
        $d_id = $g["dnc_musteri_id"];
        $d_ad = $g["dnc_ad_soyad"];
        $d_tel = $g["dnc_telefon"];
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Müşteri Yönetimi</title>
    <style>
        body { background-color: #0f3460; color: white; font-family: 'Segoe UI', Tahoma, sans-serif; margin: 0; display: flex; }
        
        
        .sidebar { width: 260px; background: rgba(0,0,0,0.25); height: 100vh; position: fixed; left: 0; top: 0; display: flex; flex-direction: column; padding-top: 20px; box-shadow: 4px 0 15px rgba(0,0,0,0.3); z-index: 100; }
        .sidebar .logo { text-align: center; margin-bottom: 40px; padding-bottom: 20px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar .logo-icon { font-size: 50px; margin-bottom: 10px; }
        .sidebar h2 { margin: 0; color: #4CAF50; font-size: 22px; letter-spacing: 2px; text-shadow: 2px 2px 4px rgba(0,0,0,0.5); }
        .sidebar a { color: #ddd; text-decoration: none; padding: 15px 25px; font-size: 16px; font-weight: 600; display: flex; align-items: center; gap: 15px; transition: all 0.3s ease; margin: 5px 15px; border-radius: 12px; }
        .sidebar a:hover, .sidebar a.active { background: #4CAF50; color: white; transform: translateX(5px); box-shadow: 0 4px 10px rgba(76,175,80,0.3); }
        .sidebar .cikis-btn { margin-top: auto; margin-bottom: 30px; background: rgba(255,107,107,0.1); color: #ff6b6b; }
        .sidebar .cikis-btn:hover { background: #ff6b6b; color: white; }

        
        .main-content { margin-left: 260px; padding: 40px; width: calc(100% - 260px); box-sizing: border-box; min-height: 100vh; }
        
        .baslik-alani { border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 15px; margin-bottom: 30px; }
        .baslik-alani h1 { margin: 0; color: #4CAF50; font-size: 28px; }

        .container { display: flex; gap: 30px; flex-wrap: wrap; align-items: flex-start;}
        .form-kutu { background: rgba(255, 255, 255, 0.05); padding: 30px; border-radius: 15px; width: 320px; border: 1px solid rgba(255,255,255,0.1); }
        .list-kutu { background: rgba(255, 255, 255, 0.05); padding: 30px; border-radius: 15px; flex: 1; border: 1px solid rgba(255,255,255,0.1); }
        
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 12px; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1); }
        th { color: #4CAF50; font-size: 16px; }
        input[type="text"] { width: 100%; padding: 12px; border-radius: 8px; border: none; margin: 10px 0 20px 0; box-sizing: border-box; background: rgba(255,255,255,0.9); }
        input[type="submit"] { width: 100%; padding: 12px; border-radius: 8px; border: none; cursor: pointer; font-weight: bold; background: #4CAF50; color: white; font-size: 16px; transition: 0.3s;}
        input[type="submit"]:hover { background: #45a049; }
        .btn-sil { background: #ff6b6b; color: white; padding: 6px 12px; text-decoration: none; border-radius: 6px; font-size: 14px;}
        .btn-guncelle { background: #3498db; color: white; padding: 6px 12px; text-decoration: none; border-radius: 6px; font-size: 14px;}
        .btn-yeni { display: inline-block; background: #f39c12; color: white; padding: 8px 12px; text-decoration: none; border-radius: 6px; margin-bottom: 20px; font-size: 14px; width:100%; text-align:center; box-sizing: border-box;}
        .basarili { background-color: rgba(76, 175, 80, 0.2); border: 1px solid #4CAF50; color: white; padding: 15px; text-align: center; border-radius: 8px; margin-bottom: 20px; font-weight: bold;}
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="logo"><div class="logo-icon">🚗</div><h2>DNC RENT A CAR</h2></div>
        <a href="anasayfa.php"><span>🏠</span> Anasayfa Paneli</a>
        <a href="musteriler.php" class="active"><span>👥</span> Müşteri Yönetimi</a>
        <a href="araclar.php"><span>🚘</span> Araç Filosu</a>
        <a href="kiralama.php"><span>📄</span> Kiralama (Sözleşme)</a>
        <a href="bakimlar.php"><span>🔧</span> Araç Bakımları</a>
        <a href="giris.php" class="cikis-btn"><span>🚪</span> Çıkış Yap</a>
    </div>
    
    <div class="main-content">
        <div class="baslik-alani">
            <h1>Müşteri Yönetimi</h1>
        </div>
        
        <?php echo $mesaj; ?>
        
        <div class="container">
            <div class="form-kutu">
                <h3><?php echo $duzenle_modu ? "Müşteri Güncelle" : "Yeni Müşteri Ekle"; ?></h3>
                <?php if($duzenle_modu): ?><a href="musteriler.php" class="btn-yeni">İptal Et / Yeni Kayıt Ekle</a><?php endif; ?>

                <form action="musteriler.php" method="post">
                    <input type="hidden" name="m_id" value="<?php echo $d_id; ?>">
                    <label>Müşteri Ad Soyad:</label>
                    <input type="text" name="m_ad" value="<?php echo $d_ad; ?>" required>
                    <label>Telefon Numarası:</label>
                    <input type="text" name="m_tel" value="<?php echo $d_tel; ?>" required>
                    <?php if($duzenle_modu): ?>
                        <input type="submit" name="musteri_guncelle" value="Güncelle" style="background: #3498db;">
                    <?php else: ?>
                        <input type="submit" name="musteri_ekle" value="Kaydet">
                    <?php endif; ?>
                </form>
            </div>

            <div class="list-kutu">
                <h3>Kayıtlı Müşteriler</h3>
                <table>
                    <tr><th>ID</th><th>Ad Soyad</th><th>Telefon</th><th>İşlemler</th></tr>
                    <?php
                    $Sorgu = $vtbaglan->query("SELECT * FROM dnc_musteriler ORDER BY dnc_musteri_id DESC");
                    while($satir = $Sorgu->fetch_assoc()){
                        echo "<tr>
                                <td>".$satir['dnc_musteri_id']."</td>
                                <td>".$satir['dnc_ad_soyad']."</td>
                                <td>".$satir['dnc_telefon']."</td>
                                <td>
                                    <a href='musteriler.php?duzenle=".$satir['dnc_musteri_id']."' class='btn-guncelle'>Güncelle</a>
                                    <a href='musteriler.php?sil=".$satir['dnc_musteri_id']."' class='btn-sil'>Sil</a>
                                </td>
                              </tr>";
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
