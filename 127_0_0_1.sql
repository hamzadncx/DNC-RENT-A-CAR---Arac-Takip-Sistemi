-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 19 May 2026, 18:37:57
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `vt_242703017`
--
CREATE DATABASE IF NOT EXISTS `vt_242703017` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci;
USE `vt_242703017`;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `dnc_araclar`
--

CREATE TABLE `dnc_araclar` (
  `dnc_arac_id` int(11) NOT NULL,
  `dnc_plaka` varchar(15) DEFAULT NULL,
  `dnc_marka_model` varchar(50) DEFAULT NULL,
  `dnc_gunluk_fiyat` int(11) DEFAULT NULL,
  `dnc_durum` tinyint(4) DEFAULT NULL,
  `dnc_tarih` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `dnc_araclar`
--

INSERT INTO `dnc_araclar` (`dnc_arac_id`, `dnc_plaka`, `dnc_marka_model`, `dnc_gunluk_fiyat`, `dnc_durum`, `dnc_tarih`) VALUES
(1, '42DNC01', 'Peugeot 3008', 15000, 1, '2026-04-03 17:12:46'),
(2, '42DNC02', 'Cupra Formentor', 20000, 1, '2026-04-03 17:13:28'),
(3, '42DNC03', 'Volvo XC60', 35000, 1, '2026-04-03 17:17:38'),
(4, '42DNC04', 'Renault Megane', 9500, 1, '2026-04-03 17:17:38'),
(5, '42DNC05', 'Hyundai Tucson', 12000, 1, '2026-04-03 17:17:38'),
(6, '42DNC06', 'Volkswagen Golf', 11500, 1, '2026-04-03 17:17:38'),
(7, '42DNC07', 'Hyundai i20', 8600, 1, '2026-04-03 17:17:38'),
(8, '42DNC08', 'Renault Clio', 8200, 1, '2026-04-03 17:17:38'),
(9, '42DNC09', 'Volvo XC90', 38500, 1, '2026-04-03 17:17:38'),
(10, '42DNC10', 'Fiat Egea', 9400, 1, '2026-04-03 17:17:38');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `dnc_bakimlar`
--

CREATE TABLE `dnc_bakimlar` (
  `dnc_bakim_id` int(11) NOT NULL,
  `dnc_arac_id` int(11) DEFAULT NULL,
  `dnc_bakim_tarihi` date DEFAULT NULL,
  `dnc_aciklama` varchar(100) DEFAULT NULL,
  `dnc_maliyet` int(11) DEFAULT NULL,
  `dnc_tarih` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `dnc_bakimlar`
--

INSERT INTO `dnc_bakimlar` (`dnc_bakim_id`, `dnc_arac_id`, `dnc_bakim_tarihi`, `dnc_aciklama`, `dnc_maliyet`, `dnc_tarih`) VALUES
(1, 1, '2026-04-15', 'Yağ Bakımı', 7500, '2026-04-03 17:25:13'),
(2, 2, '2026-04-29', 'Yağ Bakımı', 7800, '2026-04-03 17:25:13'),
(3, 3, '2026-04-18', 'Motor Bakımı', 11000, '2026-04-03 17:25:13'),
(4, 4, '2026-04-18', 'Balata Değişimi', 12600, '2026-04-03 17:25:13'),
(5, 5, '2026-05-07', 'Yağ Bakımı', 7000, '2026-04-03 17:25:13'),
(6, 6, '2026-05-21', 'Direksiyon Titreme', 14600, '2026-04-03 17:25:13'),
(7, 7, '2026-05-11', 'Yağ Bakımı', 7800, '2026-04-03 17:25:13'),
(8, 8, '2026-06-02', 'Akü Şarj Edilecek', 6000, '2026-04-03 17:25:13'),
(9, 9, '2026-05-22', 'Balata', 13000, '2026-04-03 17:25:13'),
(10, 10, '2026-05-30', 'Genel Kontroller', 25000, '2026-04-03 17:25:13');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `dnc_kiralamalar`
--

CREATE TABLE `dnc_kiralamalar` (
  `dnc_kiralama_id` int(11) NOT NULL,
  `dnc_musteri_id` int(11) DEFAULT NULL,
  `dnc_arac_id` int(11) DEFAULT NULL,
  `dnc_gun_sayisi` int(11) DEFAULT NULL,
  `dnc_toplam_tutar` int(11) DEFAULT NULL,
  `dnc_tarih` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `dnc_kiralamalar`
--

INSERT INTO `dnc_kiralamalar` (`dnc_kiralama_id`, `dnc_musteri_id`, `dnc_arac_id`, `dnc_gun_sayisi`, `dnc_toplam_tutar`, `dnc_tarih`) VALUES
(1, 2, 7, 7, 60200, '2026-04-03 17:41:05'),
(2, 3, 10, 3, 28200, '2026-04-03 17:41:05'),
(3, 4, 3, 4, 140000, '2026-04-03 17:41:05'),
(4, 1, 2, 2, 40000, '2026-04-03 17:41:05'),
(5, 6, 6, 8, 92000, '2026-04-03 17:41:05'),
(6, 8, 4, 3, 28500, '2026-04-03 17:41:05'),
(7, 5, 9, 5, 192500, '2026-04-03 17:41:05'),
(8, 10, 1, 6, 90000, '2026-04-03 17:41:05'),
(9, 7, 5, 3, 60000, '2026-04-03 17:41:05'),
(10, 9, 8, 2, 16400, '2026-04-03 17:41:05');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `dnc_musteriler`
--

CREATE TABLE `dnc_musteriler` (
  `dnc_musteri_id` int(11) NOT NULL,
  `dnc_ad_soyad` varchar(50) DEFAULT NULL,
  `dnc_telefon` varchar(15) DEFAULT NULL,
  `dnc_tarih` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `dnc_musteriler`
--

INSERT INTO `dnc_musteriler` (`dnc_musteri_id`, `dnc_ad_soyad`, `dnc_telefon`, `dnc_tarih`) VALUES
(1, 'Berat Aras', '5346889433', '2026-04-03 17:31:17'),
(2, 'Adem Taflı', '5468775455', '2026-04-03 17:31:17'),
(3, 'Faruk Yazıcı', '5445683244', '2026-04-03 17:31:17'),
(4, 'Uğur Can Gavga', '5462334577', '2026-04-03 17:31:17'),
(5, 'Kutay Berkin Demir', '532455007', '2026-04-03 17:31:17'),
(6, 'Ahmet Can Yılmaz', '5441223456', '2026-04-03 17:31:17'),
(7, 'Mehmet Emin Çelik', '5324775544', '2026-04-03 17:31:17'),
(8, 'Buğra Bulut', '5346773233', '2026-04-03 17:31:17'),
(9, 'Yaşar Ek', '5441220044', '2026-04-03 17:31:17'),
(10, 'İbrahim Simitci', '5326211380', '2026-04-03 17:31:17');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `dnc_yoneticiler`
--

CREATE TABLE `dnc_yoneticiler` (
  `oto_id` int(11) NOT NULL,
  `dnc_kullanici` varchar(50) DEFAULT NULL,
  `dnc_sifre` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `dnc_yoneticiler`
--

INSERT INTO `dnc_yoneticiler` (`oto_id`, `dnc_kullanici`, `dnc_sifre`) VALUES
(1, 'hamza', '123456');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `dnc_araclar`
--
ALTER TABLE `dnc_araclar`
  ADD PRIMARY KEY (`dnc_arac_id`);

--
-- Tablo için indeksler `dnc_bakimlar`
--
ALTER TABLE `dnc_bakimlar`
  ADD PRIMARY KEY (`dnc_bakim_id`),
  ADD KEY `arac_id` (`dnc_arac_id`);

--
-- Tablo için indeksler `dnc_kiralamalar`
--
ALTER TABLE `dnc_kiralamalar`
  ADD PRIMARY KEY (`dnc_kiralama_id`),
  ADD KEY `musteri_id` (`dnc_musteri_id`),
  ADD KEY `arac_id` (`dnc_arac_id`);

--
-- Tablo için indeksler `dnc_musteriler`
--
ALTER TABLE `dnc_musteriler`
  ADD PRIMARY KEY (`dnc_musteri_id`);

--
-- Tablo için indeksler `dnc_yoneticiler`
--
ALTER TABLE `dnc_yoneticiler`
  ADD PRIMARY KEY (`oto_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `dnc_araclar`
--
ALTER TABLE `dnc_araclar`
  MODIFY `dnc_arac_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Tablo için AUTO_INCREMENT değeri `dnc_bakimlar`
--
ALTER TABLE `dnc_bakimlar`
  MODIFY `dnc_bakim_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Tablo için AUTO_INCREMENT değeri `dnc_kiralamalar`
--
ALTER TABLE `dnc_kiralamalar`
  MODIFY `dnc_kiralama_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Tablo için AUTO_INCREMENT değeri `dnc_musteriler`
--
ALTER TABLE `dnc_musteriler`
  MODIFY `dnc_musteri_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Tablo için AUTO_INCREMENT değeri `dnc_yoneticiler`
--
ALTER TABLE `dnc_yoneticiler`
  MODIFY `oto_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `dnc_bakimlar`
--
ALTER TABLE `dnc_bakimlar`
  ADD CONSTRAINT `dnc_bakimlar_ibfk_1` FOREIGN KEY (`dnc_arac_id`) REFERENCES `dnc_araclar` (`dnc_arac_id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `dnc_kiralamalar`
--
ALTER TABLE `dnc_kiralamalar`
  ADD CONSTRAINT `dnc_kiralamalar_ibfk_1` FOREIGN KEY (`dnc_musteri_id`) REFERENCES `dnc_musteriler` (`dnc_musteri_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dnc_kiralamalar_ibfk_2` FOREIGN KEY (`dnc_arac_id`) REFERENCES `dnc_araclar` (`dnc_arac_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
