<?php
session_start();
if(!isset($_SESSION["kullanici"])){ header('Location:giris2.php'); exit; }

$vtbaglan = new mysqli("localhost", "root", "", "vt_242703017");

$m_sorgu = $vtbaglan->query("SELECT COUNT(*) AS toplam_musteri FROM dnc_musteriler");
$m_sayi = $m_sorgu->fetch_assoc()['toplam_musteri'];

$a_sorgu = $vtbaglan->query("SELECT COUNT(*) AS toplam_arac FROM dnc_araclar");
$a_sayi = $a_sorgu->fetch_assoc()['toplam_arac'];

$k_sorgu = $vtbaglan->query("SELECT COUNT(*) AS toplam_kira FROM dnc_kiralamalar");
$k_sayi = $k_sorgu->fetch_assoc()['toplam_kira'];

$b_sorgu = $vtbaglan->query("SELECT COUNT(*) AS toplam_bakim FROM dnc_bakimlar");
$b_sayi = $b_sorgu->fetch_assoc()['toplam_bakim'];
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>DNC Rent A Car - Ana Kontrol Paneli</title>
    <style>
        body { background-color: #0f3460; color: white; font-family: 'Segoe UI', Tahoma, sans-serif; margin: 0; display: flex; }
        
        /* MODERN SOL MENÜ (SIDEBAR) TASARIMI */
        .sidebar { width: 260px; background: rgba(0,0,0,0.25); height: 100vh; position: fixed; left: 0; top: 0; display: flex; flex-direction: column; padding-top: 20px; box-shadow: 4px 0 15px rgba(0,0,0,0.3); z-index: 100; }
        .sidebar .logo { text-align: center; margin-bottom: 40px; padding-bottom: 20px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar .logo-icon { font-size: 50px; margin-bottom: 10px; }
        .sidebar h2 { margin: 0; color: #4CAF50; font-size: 22px; letter-spacing: 2px; text-shadow: 2px 2px 4px rgba(0,0,0,0.5); }
        .sidebar a { color: #ddd; text-decoration: none; padding: 15px 25px; font-size: 16px; font-weight: 600; display: flex; align-items: center; gap: 15px; transition: all 0.3s ease; margin: 5px 15px; border-radius: 12px; }
        .sidebar a:hover, .sidebar a.active { background: #4CAF50; color: white; transform: translateX(5px); box-shadow: 0 4px 10px rgba(76,175,80,0.3); }
        .sidebar .cikis-btn { margin-top: auto; margin-bottom: 30px; background: rgba(255,107,107,0.1); color: #ff6b6b; }
        .sidebar .cikis-btn:hover { background: #ff6b6b; color: white; }

        /* SAĞ İÇERİK ALANI (MAIN CONTENT) */
        .main-content { margin-left: 260px; padding: 40px; width: calc(100% - 260px); box-sizing: border-box; min-height: 100vh; }
        .header { background: rgba(255,255,255,0.05); padding: 25px; border-radius: 15px; border: 1px solid rgba(255,255,255,0.1); box-shadow: 0 4px 15px rgba(0,0,0,0.2); margin-bottom: 40px; }
        .header h1 { margin: 0; color: white; letter-spacing: 1px; font-size: 28px; }
        .header p { margin: 10px 0 0 0; color: #aaa; font-size: 16px; }
        
        .dashboard-container { display: flex; gap: 30px; flex-wrap: wrap; }
        .card { background: rgba(255, 255, 255, 0.1); flex: 1; min-width: 200px; padding: 30px 20px; border-radius: 15px; text-align: center; text-decoration: none; color: white; box-shadow: 0 8px 32px rgba(0,0,0,0.3); transition: transform 0.3s; border: 2px solid transparent; }
        .card:hover { transform: translateY(-10px); background: rgba(255, 255, 255, 0.15); border-color: #4CAF50; }
        .card h2 { margin: 0 0 15px 0; font-size: 22px; }
        .card .icon { font-size: 50px; margin-bottom: 15px; }
        .card .stat { background: rgba(0,0,0,0.3); padding: 5px 15px; border-radius: 20px; color: #4CAF50; font-weight: bold; }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="logo">
            <div class="logo-icon">🚗</div>
            <h2>DNC RENT A CAR</h2>
        </div>
        <a href="anasayfa.php" class="active"><span>🏠</span> Anasayfa Paneli</a>
        <a href="musteriler.php"><span>👥</span> Müşteri Yönetimi</a>
        <a href="araclar.php"><span>🚘</span> Araç Filosu</a>
        <a href="kiralama.php"><span>📄</span> Kiralama (Sözleşme)</a>
        <a href="bakimlar.php"><span>🔧</span> Araç Bakımları</a>
        
        <a href="giris.php" class="cikis-btn"><span>🚪</span> Çıkış Yap</a>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>Sisteme Hoş Geldin, <?php echo $_SESSION["kullanici"]; ?>!</h1>
            <p>DNC Araç Kiralama Otomasyonu günlük istatistikleriniz aşağıdadır.</p>
        </div>

        <div class="dashboard-container">
            <a href="musteriler.php" class="card"><div class="icon">👥</div><h2>Müşteriler</h2><div class="stat">Toplam Kayıt: <?php echo $m_sayi; ?></div></a>
            <a href="araclar.php" class="card"><div class="icon">🚘</div><h2>Araç Filosu</h2><div class="stat">Toplam Araç: <?php echo $a_sayi; ?></div></a>
            <a href="kiralama.php" class="card"><div class="icon">📄</div><h2>Kiralamalar</h2><div class="stat">Aktif Sözleşme: <?php echo $k_sayi; ?></div></a>
            <a href="bakimlar.php" class="card"><div class="icon">🔧</div><h2>Bakımlar</h2><div class="stat">Kayıtlı Bakım: <?php echo $b_sayi; ?></div></a>
        </div>
    </div>

</body>
</html>