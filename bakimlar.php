<?php
session_start();
if(!isset($_SESSION["kullanici"])){ header('Location:giris2.php'); exit; }

$vtbaglan = new mysqli("localhost", "root", "", "vt_242703017");
$mesaj = "";

if(isset($_GET["sil"])){
    $sil_id = $_GET["sil"];
    $vtbaglan->query("DELETE FROM dnc_bakimlar WHERE dnc_bakim_id='$sil_id'");
    header("Location: bakimlar.php");
}

if($_POST){
    if(isset($_POST["bakim_ekle"])){
        $arac_id = $_POST["b_arac"];
        $tarih = $_POST["b_tarih"];
        $aciklama = $_POST["b_aciklama"];
        $maliyet = $_POST["b_maliyet"];
        $vtbaglan->query("INSERT INTO dnc_bakimlar (dnc_arac_id, dnc_bakim_tarihi, dnc_aciklama, dnc_maliyet) VALUES ('$arac_id', '$tarih', '$aciklama', '$maliyet')");
        $mesaj = "<div class='basarili'>Yeni Bakım Kaydı Eklendi!</div>";
    }
    if(isset($_POST["bakim_guncelle"])){
        $guncel_id = $_POST["b_id"];
        $arac_id = $_POST["b_arac"];
        $tarih = $_POST["b_tarih"];
        $aciklama = $_POST["b_aciklama"];
        $maliyet = $_POST["b_maliyet"];
        $vtbaglan->query("UPDATE dnc_bakimlar SET dnc_arac_id='$arac_id', dnc_bakim_tarihi='$tarih', dnc_aciklama='$aciklama', dnc_maliyet='$maliyet' WHERE dnc_bakim_id='$guncel_id'");
        $mesaj = "<div class='basarili'>Bakım Kaydı Güncellendi!</div>";
    }
}

$duzenle_modu = false;
$d_id=""; $d_arac=""; $d_tarih=""; $d_aciklama=""; $d_maliyet="";
if(isset($_GET["duzenle"])){
    $duzenle_id = $_GET["duzenle"];
    $bul = $vtbaglan->query("SELECT * FROM dnc_bakimlar WHERE dnc_bakim_id='$duzenle_id'");
    if($g = $bul->fetch_assoc()){
        $duzenle_modu = true;
        $d_id = $g["dnc_bakim_id"];
        $d_arac = $g["dnc_arac_id"];
        $d_tarih = $g["dnc_bakim_tarihi"];
        $d_aciklama = $g["dnc_aciklama"];
        $d_maliyet = $g["dnc_maliyet"];
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Bakım Yönetimi</title>
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
        input[type="text"], input[type="date"], input[type="number"], select { width: 100%; padding: 12px; border-radius: 8px; border: none; margin: 10px 0 20px 0; box-sizing: border-box; background: rgba(255,255,255,0.9); font-family: inherit;}
        input[type="submit"] { width: 100%; padding: 12px; border-radius: 8px; border: none; cursor: pointer; font-weight: bold; background: #4CAF50; color: white; font-size: 16px; transition: 0.3s;}
        input[type="submit"]:hover { background: #45a049; }
        
        
        .islem-butonlari { display: flex; justify-content: center; gap: 8px; }
        .btn-sil { background: #ff6b6b; color: white; padding: 6px 12px; text-decoration: none; border-radius: 6px; font-size: 14px; transition: 0.2s;}
        .btn-sil:hover { background: #ff4757; }
        .btn-guncelle { background: #3498db; color: white; padding: 6px 12px; text-decoration: none; border-radius: 6px; font-size: 14px; transition: 0.2s;}
        .btn-guncelle:hover { background: #2980b9; }
        
        .btn-yeni { display: inline-block; background: #f39c12; color: white; padding: 8px 12px; text-decoration: none; border-radius: 6px; margin-bottom: 20px; font-size: 14px; width:100%; text-align:center; box-sizing: border-box;}
        .basarili { background-color: rgba(76, 175, 80, 0.2); border: 1px solid #4CAF50; color: white; padding: 15px; text-align: center; border-radius: 8px; margin-bottom: 20px; font-weight: bold;}
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="logo"><div class="logo-icon">🚗</div><h2>DNC RENT A CAR</h2></div>
        <a href="anasayfa.php"><span>🏠</span> Anasayfa Paneli</a>
        <a href="musteriler.php"><span>👥</span> Müşteri Yönetimi</a>
        <a href="araclar.php"><span>🚘</span> Araç Filosu</a>
        <a href="kiralama.php"><span>📄</span> Kiralama (Sözleşme)</a>
        <a href="bakimlar.php" class="active"><span>🔧</span> Araç Bakımları</a>
        <a href="giris.php" class="cikis-btn"><span>🚪</span> Çıkış Yap</a>
    </div>
    
    <div class="main-content">
        <div class="baslik-alani">
            <h1>Araç Bakım Geçmişi</h1>
        </div>
        
        <?php echo $mesaj; ?>
        
        <div class="container">
            <div class="form-kutu">
                <h3><?php echo $duzenle_modu ? "Bakım Güncelle" : "Yeni Bakım Ekle"; ?></h3>
                <?php if($duzenle_modu): ?><a href="bakimlar.php" class="btn-yeni">İptal Et / Yeni Kayıt Ekle</a><?php endif; ?>

                <form action="bakimlar.php" method="post">
                    <input type="hidden" name="b_id" value="<?php echo $d_id; ?>">
                    <label>Bakım Yapılan Araç:</label>
                    <select name="b_arac" required>
                        <option value="">-- Seçiniz --</option>
                        <?php
                        $a_sor = $vtbaglan->query("SELECT * FROM dnc_araclar");
                        while($a = $a_sor->fetch_assoc()){
                            $secili = ($d_arac == $a['dnc_arac_id']) ? "selected" : "";
                            echo "<option value='".$a['dnc_arac_id']."' $secili>".$a['dnc_marka_model']." (".$a['dnc_plaka'].")</option>";
                        }
                        ?>
                    </select>
                    <label>Bakım Tarihi:</label>
                    <input type="date" name="b_tarih" value="<?php echo $d_tarih; ?>" required>
                    <label>Yapılan İşlem:</label>
                    <input type="text" name="b_aciklama" value="<?php echo $d_aciklama; ?>" required>
                    <label>Maliyet (TL):</label>
                    <input type="number" name="b_maliyet" value="<?php echo $d_maliyet; ?>" required>
                    <?php if($duzenle_modu): ?>
                        <input type="submit" name="bakim_guncelle" value="Güncelle" style="background: #3498db;">
                    <?php else: ?>
                        <input type="submit" name="bakim_ekle" value="Kaydet">
                    <?php endif; ?>
                </form>
            </div>

            <div class="list-kutu">
                <h3>Kayıtlı Bakımlar</h3>
                <table>
                    <tr><th>Araç / Plaka</th><th>Tarih</th><th>Açıklama</th><th>Maliyet</th><th>İşlemler</th></tr>
                    <?php
                    $sorgu = "SELECT b.dnc_bakim_id, a.dnc_marka_model, a.dnc_plaka, b.dnc_bakim_tarihi, b.dnc_aciklama, b.dnc_maliyet 
                              FROM dnc_bakimlar b
                              INNER JOIN dnc_araclar a ON b.dnc_arac_id = a.dnc_arac_id 
                              ORDER BY b.dnc_bakim_tarihi DESC";
                    $liste = $vtbaglan->query($sorgu);
                    while($satir = $liste->fetch_assoc()){
                        echo "<tr>
                                <td>".$satir['dnc_marka_model']." (".$satir['dnc_plaka'].")</td>
                                <td>".$satir['dnc_bakim_tarihi']."</td>
                                <td>".$satir['dnc_aciklama']."</td>
                                <td>".$satir['dnc_maliyet']." TL</td>
                                <td>
                                    <div class='islem-butonlari'>
                                        <a href='bakimlar.php?duzenle=".$satir['dnc_bakim_id']."' class='btn-guncelle'>Güncelle</a>
                                        <a href='bakimlar.php?sil=".$satir['dnc_bakim_id']."' class='btn-sil'>Sil</a>
                                    </div>
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
