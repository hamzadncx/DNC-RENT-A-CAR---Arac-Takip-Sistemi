<?php
session_start();
if(!isset($_SESSION["kullanici"])){ header('Location:giris2.php'); exit; }

$vtbaglan = new mysqli("localhost", "root", "", "vt_242703017");
$mesaj = "";

// SİLME (İPTAL ETME)
if(isset($_GET["sil"])){
    $sil_id = $_GET["sil"];
    $bul = $vtbaglan->query("SELECT dnc_arac_id FROM dnc_kiralamalar WHERE dnc_kiralama_id='$sil_id'");
    if($f = $bul->fetch_assoc()){
        $a_id = $f["dnc_arac_id"];
        $vtbaglan->query("UPDATE dnc_araclar SET dnc_durum=1 WHERE dnc_arac_id='$a_id'");
    }
    $vtbaglan->query("DELETE FROM dnc_kiralamalar WHERE dnc_kiralama_id='$sil_id'");
    header("Location: kiralama.php");
}

// YENİ KİRALAMA EKLEME
if($_POST){
    if(isset($_POST["arac_kirala"])){
        $musteri_id = $_POST["k_musteri"];
        $arac_id = $_POST["k_arac"];
        $gun_sayisi = $_POST["k_gun"];

        $fiyat_sor = $vtbaglan->query("SELECT dnc_gunluk_fiyat FROM dnc_araclar WHERE dnc_arac_id='$arac_id'");
        $fiyat_cek = $fiyat_sor->fetch_assoc();
        $toplam_tutar = $fiyat_cek['dnc_gunluk_fiyat'] * $gun_sayisi;

        $kira_sql = "INSERT INTO dnc_kiralamalar (dnc_musteri_id, dnc_arac_id, dnc_gun_sayisi, dnc_toplam_tutar) VALUES ('$musteri_id', '$arac_id', '$gun_sayisi', '$toplam_tutar')";
        
        if($vtbaglan->query($kira_sql)){
            $vtbaglan->query("UPDATE dnc_araclar SET dnc_durum=0 WHERE dnc_arac_id='$arac_id'");
            $mesaj = "<div class='basarili'>Sözleşme Eklendi! Kiralama Başarılı! Toplam: $toplam_tutar TL</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kiralama Paneli</title>
    <style>
        body { background-color: #0f3460; color: white; font-family: 'Segoe UI', Tahoma, sans-serif; margin: 0; display: flex; }
        
        /* SIDEBAR */
        .sidebar { width: 260px; background: rgba(0,0,0,0.25); height: 100vh; position: fixed; left: 0; top: 0; display: flex; flex-direction: column; padding-top: 20px; box-shadow: 4px 0 15px rgba(0,0,0,0.3); z-index: 100; }
        .sidebar .logo { text-align: center; margin-bottom: 40px; padding-bottom: 20px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar .logo-icon { font-size: 50px; margin-bottom: 10px; }
        .sidebar h2 { margin: 0; color: #4CAF50; font-size: 22px; letter-spacing: 2px; text-shadow: 2px 2px 4px rgba(0,0,0,0.5); }
        .sidebar a { color: #ddd; text-decoration: none; padding: 15px 25px; font-size: 16px; font-weight: 600; display: flex; align-items: center; gap: 15px; transition: all 0.3s ease; margin: 5px 15px; border-radius: 12px; }
        .sidebar a:hover, .sidebar a.active { background: #4CAF50; color: white; transform: translateX(5px); box-shadow: 0 4px 10px rgba(76,175,80,0.3); }
        .sidebar .cikis-btn { margin-top: auto; margin-bottom: 30px; background: rgba(255,107,107,0.1); color: #ff6b6b; }
        .sidebar .cikis-btn:hover { background: #ff6b6b; color: white; }

        /* MAIN CONTENT */
        .main-content { margin-left: 260px; padding: 40px; width: calc(100% - 260px); box-sizing: border-box; min-height: 100vh; }
        
        .baslik-alani { border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 15px; margin-bottom: 30px; }
        .baslik-alani h1 { margin: 0; color: #4CAF50; font-size: 28px; }

        .container { display: flex; gap: 30px; flex-wrap: wrap; align-items: flex-start;}
        .form-kutu { background: rgba(255, 255, 255, 0.05); padding: 30px; border-radius: 15px; width: 320px; border: 1px solid rgba(255,255,255,0.1); }
        .list-kutu { background: rgba(255, 255, 255, 0.05); padding: 30px; border-radius: 15px; flex: 1; border: 1px solid rgba(255,255,255,0.1); }
        
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 12px; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1); }
        th { color: #4CAF50; font-size: 16px; }
        input[type="number"], select { width: 100%; padding: 12px; border-radius: 8px; border: none; margin: 10px 0 20px 0; box-sizing: border-box; background: rgba(255,255,255,0.9); }
        input[type="submit"] { width: 100%; padding: 12px; border-radius: 8px; border: none; cursor: pointer; font-weight: bold; background: #4CAF50; color: white; font-size: 16px; transition: 0.3s;}
        input[type="submit"]:hover { background: #45a049; }
        
        /* BUTON TASARIMLARI (KAYMAYI ÖNLEYEN KISIM) */
        .islem-butonlari { display: flex; justify-content: center; gap: 8px; }
        .btn-sil { background: #ff6b6b; color: white; padding: 8px 12px; text-decoration: none; border-radius: 6px; font-size: 13px; font-weight: bold; white-space: nowrap; transition: 0.2s;}
        .btn-sil:hover { background: #ff4757; }
        .btn-yazdir { background: #2ecc71; color: white; padding: 8px 12px; text-decoration: none; border-radius: 6px; font-size: 13px; font-weight: bold; white-space: nowrap; transition: 0.2s;}
        .btn-yazdir:hover { background: #27ae60; }
        
        .basarili { background-color: rgba(76, 175, 80, 0.2); border: 1px solid #4CAF50; color: white; padding: 15px; text-align: center; border-radius: 8px; margin-bottom: 20px; font-weight: bold;}
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="logo"><div class="logo-icon">🚗</div><h2>DNC RENT A CAR</h2></div>
        <a href="anasayfa.php"><span>🏠</span> Anasayfa Paneli</a>
        <a href="musteriler.php"><span>👥</span> Müşteri Yönetimi</a>
        <a href="araclar.php"><span>🚘</span> Araç Filosu</a>
        <a href="kiralama.php" class="active"><span>📄</span> Kiralama (Sözleşme)</a>
        <a href="bakimlar.php"><span>🔧</span> Araç Bakımları</a>
        <a href="giris.php" class="cikis-btn"><span>🚪</span> Güvenli Çıkış</a>
    </div>
    
    <div class="main-content">
        <div class="baslik-alani">
            <h1>Araç Kiralama Sözleşmeleri</h1>
        </div>
        
        <?php echo $mesaj; ?>
        
        <div class="container">
            <div class="form-kutu">
                <h3>Yeni Sözleşme Ekle</h3>
                <form action="kiralama.php" method="post">
                    <label>Müşteri Seçin:</label>
                    <select name="k_musteri" required>
                        <option value="">-- Seçiniz --</option>
                        <?php
                        $m_sor = $vtbaglan->query("SELECT * FROM dnc_musteriler");
                        while($m = $m_sor->fetch_assoc()) echo "<option value='".$m['dnc_musteri_id']."'>".$m['dnc_ad_soyad']."</option>";
                        ?>
                    </select>
                    
                    <label>Kiralık Araç (Sadece Boşlar):</label>
                    <select name="k_arac" required>
                        <option value="">-- Boş Araçlar --</option>
                        <?php
                        $a_sor = $vtbaglan->query("SELECT * FROM dnc_araclar WHERE dnc_durum=1");
                        while($a = $a_sor->fetch_assoc()) echo "<option value='".$a['dnc_arac_id']."'>".$a['dnc_marka_model']." (".$a['dnc_plaka'].")</option>";
                        ?>
                    </select>
                    
                    <label>Süre (Gün):</label>
                    <input type="number" name="k_gun" min="1" required>
                    
                    <input type="submit" name="arac_kirala" value="Sözleşmeyi Başlat">
                </form>
            </div>

            <div class="list-kutu">
                <h3>Aktif Sözleşmeler</h3>
                <table>
                    <tr><th>Müşteri</th><th>Araç</th><th>Süre</th><th>Tutar</th><th>İşlem</th></tr>
                    <?php
                    $sorgu = "SELECT k.dnc_kiralama_id, m.dnc_ad_soyad, a.dnc_marka_model, a.dnc_plaka, k.dnc_gun_sayisi, k.dnc_toplam_tutar 
                              FROM dnc_kiralamalar k
                              INNER JOIN dnc_musteriler m ON k.dnc_musteri_id = m.dnc_musteri_id
                              INNER JOIN dnc_araclar a ON k.dnc_arac_id = a.dnc_arac_id ORDER BY k.dnc_kiralama_id DESC";
                    $liste = $vtbaglan->query($sorgu);
                    while($satir = $liste->fetch_assoc()){
                        echo "<tr>
                                <td>".$satir['dnc_ad_soyad']."</td>
                                <td>".$satir['dnc_marka_model']." (".$satir['dnc_plaka'].")</td>
                                <td>".$satir['dnc_gun_sayisi']." Gün</td>
                                <td>".$satir['dnc_toplam_tutar']." TL</td>
                                <td>
                                    <div class='islem-butonlari'>
                                        <a href='yazdir.php?id=".$satir['dnc_kiralama_id']."' target='_blank' class='btn-yazdir'>🖨️ Yazdır</a>
                                        <a href='kiralama.php?sil=".$satir['dnc_kiralama_id']."' class='btn-sil'>İptal Et</a>
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