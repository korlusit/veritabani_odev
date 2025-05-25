-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 25 May 2025, 17:40:36
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
-- Veritabanı: `doktor_randevu`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `doktorlar`
--

CREATE TABLE `doktorlar` (
  `id` int(11) NOT NULL,
  `ad` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `doktorlar`
--

INSERT INTO `doktorlar` (`id`, `ad`) VALUES
(1, 'Dr. Talha Atalay Körlü'),
(2, 'Dr. Elif Baybars'),
(3, 'Dr. José Mourinho');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `hastalar`
--

CREATE TABLE `hastalar` (
  `id` int(11) NOT NULL,
  `ad` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `sifre` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `hastalar`
--

INSERT INTO `hastalar` (`id`, `ad`, `email`, `sifre`) VALUES
(1, 'Talha Atalay Körlü', 'talha', '$2y$10$DA.bGC2LY0lN7W69YvJeIe1EgMVP51hG9XJdVsQZsY2fBeTEVEq8u'),
(2, 'Talha Atalay Körlü', 'talhazpsatalay01@gmail.com', '335462'),
(3, 'Talha Atalay Körlü', 'talha.atalay01@gmail.com', '$2y$10$xIKsoRZtm19OLbNR/fPStOJdhvtn9v1jixjKff/RAfMakynYDoeWW'),
(4, 'Talha Atalay Körlü', 'talha.atalay@outlook.com', '$2y$10$m9gahp6ndfB3HrKEkTfHLeAv4F2UpXzdTOq5KQ/pHupbjn7veKh.K'),
(5, 'Deneme Hasta', 'denemehasta@gmail.com', '$2y$10$BHv5/ek13mZdakpSIASCP.o5yWP6S/yefdBCTMxjMUMDBzLe1xH..');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `randevular`
--

CREATE TABLE `randevular` (
  `id` int(11) NOT NULL,
  `hasta_id` int(11) DEFAULT NULL,
  `doktor_id` int(11) DEFAULT NULL,
  `tarih` date DEFAULT NULL,
  `saat` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `randevular`
--

INSERT INTO `randevular` (`id`, `hasta_id`, `doktor_id`, `tarih`, `saat`) VALUES
(1, 1, 1, '2025-06-04', '11:00:00'),
(2, 1, 1, '2025-06-04', '09:00:00'),
(6, 2, 1, '2025-05-29', '09:00:00'),
(7, 2, 1, '2025-05-25', '09:00:00'),
(8, 4, 1, '2025-05-29', '11:00:00'),
(9, 5, 1, '2025-05-30', '16:00:00'),
(10, 5, 1, '2025-05-31', '16:00:00'),
(11, 5, 1, '0000-00-00', '09:00:00'),
(12, 5, 2, '0000-00-00', '09:00:00'),
(13, 5, 3, '0000-00-00', '09:00:00'),
(14, 5, 1, '2025-05-25', '16:00:00');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `doktorlar`
--
ALTER TABLE `doktorlar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `hastalar`
--
ALTER TABLE `hastalar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `randevular`
--
ALTER TABLE `randevular`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hasta_id` (`hasta_id`),
  ADD KEY `doktor_id` (`doktor_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `doktorlar`
--
ALTER TABLE `doktorlar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `hastalar`
--
ALTER TABLE `hastalar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `randevular`
--
ALTER TABLE `randevular`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `randevular`
--
ALTER TABLE `randevular`
  ADD CONSTRAINT `randevular_ibfk_1` FOREIGN KEY (`hasta_id`) REFERENCES `hastalar` (`id`),
  ADD CONSTRAINT `randevular_ibfk_2` FOREIGN KEY (`doktor_id`) REFERENCES `doktorlar` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
