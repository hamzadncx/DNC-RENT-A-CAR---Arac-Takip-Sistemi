<?php
session_start();
if(!isset($_SESSION["kullanici"])){ header('Location:giris2.php'); exit; }

if(!isset($_GET["id"])){ echo "Sözleşme ID bulunamadı!"; exit; }

$vtbaglan = new mysqli("localhost", "root", "", "vt_242703017");
$kiralama_id = $_GET["id"];

// Tüm bilgileri tek seferde çekmek için detaylı INNER JOIN
$sorgu = "SELECT k.*, m.*, a.* FROM dnc_kiralamalar k
          INNER JOIN dnc_musteriler m ON k.dnc_musteri_id = m.dnc_musteri_id
          INNER JOIN dnc_araclar a ON k.dnc_arac_id = a.dnc_arac_id 
          WHERE k.dnc_kiralama_id = '$kiralama_id'";

$sonuc = $vtbaglan->query($sorgu);
$veri = $sonuc->fetch_assoc();

if(!$veri){ echo "Sözleşme bulunamadı!"; exit; }
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kiralama Sözleşmesi - No: <?php echo $veri['dnc_kiralama_id']; ?></title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; background-color: #fff; color: #000; padding: 40px; margin: 0; }
        .kagit { max-width: 800px; margin: 0 auto; border: 1px solid #ccc; padding: 50px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        
        .baslik { text-align: center; border-bottom: 2px solid #000; padding-bottom: 20px; margin-bottom: 30px; }
        .baslik h1 { margin: 0; font-size: 28px; letter-spacing: 2px; }
        .baslik h2 { margin: 10px 0 0 0; font-size: 18px; font-weight: normal; }
        
        .bilgi-kutu { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .bilgi-kutu th, .bilgi-kutu td { border: 1px solid #000; padding: 12px; text-align: left; }
        .bilgi-kutu th { background-color: #f2f2f2; width: 35%; font-weight: bold; }
        
        .maddeler { font-size: 14px; line-height: 1.6; margin-bottom: 50px; text-align: justify; }
        .maddeler h3 { font-size: 16px; text-decoration: underline; }
        
        .imzalar { display: flex; justify-content: space-between; margin-top: 50px; }
        .imza-alani { text-align: center; width: 40%; }
        .imza-alani .cizgi { border-bottom: 1px solid #000; margin-top: 50px; margin-bottom: 10px; }
        
        /* Yazdırılırken dış çerçeveyi ve gölgeyi kaldırır, sadece A4 içeriğini basar */
        @media print {
            body { padding: 0; }
            .kagit { border: none; box-shadow: none; padding: 0; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="kagit">
        <div class="baslik">
            <h1>DNC RENT A CAR</h1>
            <h2>ARAÇ KİRALAMA SÖZLEŞMESİ</h2>
        </div>

        <table class="bilgi-kutu">
            <tr>
                <th colspan="2" style="text-align:center; background-color:#e0e0e0;">SÖZLEŞME DETAYLARI (Sözleşme No: <?php echo $veri['dnc_kiralama_id']; ?>)</th>
            </tr>
            <tr>
                <th>Müşteri Adı Soyadı:</th>
                <td><?php echo $veri['dnc_ad_soyad']; ?></td>
            </tr>
            <tr>
                <th>İletişim Numarası:</th>
                <td><?php echo $veri['dnc_telefon']; ?></td>
            </tr>
            <tr>
                <th>Kiralanan Araç (Plaka):</th>
                <td><?php echo $veri['dnc_marka_model'] . " (" . $veri['dnc_plaka'] . ")"; ?></td>
            </tr>
            <tr>
                <th>Kiralama Süresi:</th>
                <td><?php echo $veri['dnc_gun_sayisi']; ?> Gün</td>
            </tr>
            <tr>
                <th>Toplam Tutar:</th>
                <td><strong><?php echo $veri['dnc_toplam_tutar']; ?> TL</strong></td>
            </tr>
            <tr>
                <th>İşlem Tarihi:</th>
                <td><?php echo date('d.m.Y H:i', strtotime($veri['dnc_tarih'])); ?></td>
            </tr>
        </table>

        <div class="maddeler">
            <h3>Sözleşme Şartları:</h3>
            <p>1. İşbu sözleşme ile DNC Rent A Car, yukarıda plaka ve modeli belirtilen aracı, belirtilen süre boyunca kiracıya tahsis etmiştir.</p>
            <p>2. Kiracı, aracı karayolları trafik kurallarına uygun olarak kullanmayı ve araca gelebilecek her türlü zararı (kullanıcı hatası kaynaklı) karşılamayı kabul ve taahhüt eder.</p>
            <p>3. Araç, kira süresi bitiminde DNC Rent A Car yetkililerine eksiksiz ve teslim alındığı gibi iade edilecektir. Gecikme durumunda günlük kiralama bedeli üzerinden ek ücret yansıtılacaktır.</p>
            <p>4. Yukarıda belirtilen toplam tutar (<?php echo $veri['dnc_toplam_tutar']; ?> TL) kiracı tarafından peşinen kabul edilmiştir.</p>
        </div>

        <div class="imzalar">
            <div class="imza-alani">
                <strong>KİRACI (MÜŞTERİ)</strong><br>
                <?php echo $veri['dnc_ad_soyad']; ?>
                <div class="cizgi"></div>
                İmza
            </div>
            <div class="imza-alani">
                <strong>FİRMA YETKİLİSİ</strong><br>
                DNC Rent A Car
                <div class="cizgi"></div>
                Kaşe / İmza
            </div>
        </div>
    </div>

</body>
</html>