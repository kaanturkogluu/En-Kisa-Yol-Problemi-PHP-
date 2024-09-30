-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 07 Eyl 2024, 16:05:11
-- Sunucu sürümü: 10.4.28-MariaDB
-- PHP Sürümü: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `proje`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `closedpoints`
--

CREATE TABLE `closedpoints` (
  `point_id` int(11) NOT NULL,
  `floor_id` int(11) DEFAULT NULL,
  `x_coordinate` char(1) DEFAULT NULL,
  `y_coordinate` int(11) DEFAULT NULL,
  `style` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `closedpoints`
--

INSERT INTO `closedpoints` (`point_id`, `floor_id`, `x_coordinate`, `y_coordinate`, `style`) VALUES
(1, 1, '4', 3, 'black'),
(2, 2, '4', 5, 'black');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `elevators`
--

CREATE TABLE `elevators` (
  `elevator_id` int(11) NOT NULL,
  `floor_id` int(11) DEFAULT NULL,
  `elevator_name` varchar(100) DEFAULT NULL,
  `x_coordinate` char(2) DEFAULT NULL,
  `y_coordinate` int(11) DEFAULT NULL,
  `style` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `elevators`
--

INSERT INTO `elevators` (`elevator_id`, `floor_id`, `elevator_name`, `x_coordinate`, `y_coordinate`, `style`) VALUES
(1, 1, 'Elevator1', '5', 5, 'blue'),
(2, 2, 'Elevator2', '5', 5, 'blue');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `floors`
--

CREATE TABLE `floors` (
  `floor_id` int(11) NOT NULL,
  `floor_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `floors`
--

INSERT INTO `floors` (`floor_id`, `floor_name`) VALUES
(1, '1.Kat'),
(2, '2. Kat');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kiosks`
--

CREATE TABLE `kiosks` (
  `kiosk_id` int(11) NOT NULL,
  `kiosk_name` varchar(50) NOT NULL,
  `floor_id` int(11) DEFAULT NULL,
  `x_coordinate` char(2) DEFAULT NULL,
  `y_coordinate` int(11) DEFAULT NULL,
  `style` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `kiosks`
--

INSERT INTO `kiosks` (`kiosk_id`, `kiosk_name`, `floor_id`, `x_coordinate`, `y_coordinate`, `style`, `description`) VALUES
(1, 'Kiosk 1', 1, '5', 1, 'red', ''),
(2, 'Kiosk 2', 1, '11', 5, 'red', ''),
(3, 'Kiosk 3', 1, '5', 11, 'red', '');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `stairs`
--

CREATE TABLE `stairs` (
  `stair_id` int(11) NOT NULL,
  `floor_id` int(11) DEFAULT NULL,
  `x_coordinate` char(2) DEFAULT NULL,
  `y_coordinate` int(11) DEFAULT NULL,
  `style` varchar(255) NOT NULL,
  `stairs_name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `stairs`
--

INSERT INTO `stairs` (`stair_id`, `floor_id`, `x_coordinate`, `y_coordinate`, `style`, `stairs_name`, `description`) VALUES
(1, 1, '1', 5, 'green', 'stair1', 'Floor 1 stair'),
(2, 2, '1', 5, 'green', 'Stair2', 'Floor 2 stair');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `stores`
--

CREATE TABLE `stores` (
  `store_id` int(11) NOT NULL,
  `store_name` varchar(100) NOT NULL,
  `floor_id` int(11) DEFAULT NULL,
  `x_coordinate` char(1) DEFAULT NULL,
  `y_coordinate` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `style` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `stores`
--

INSERT INTO `stores` (`store_id`, `store_name`, `floor_id`, `x_coordinate`, `y_coordinate`, `description`, `style`) VALUES
(21, 'Zara', 1, '1', 1, 'Kıyafet Mağazası', ' #FFD700'),
(22, 'MediaMarkt', 1, '5', 1, 'Elektronik Mağazası', ' #00FF00'),
(23, 'Toyzz Shop', 1, '8', 1, 'Oyuncak Mağazası', ' #FF69B4'),
(24, 'Burger King', 1, '4', 2, 'Restoran', ' #FFA500'),
(25, 'Nike', 1, '1', 3, 'Spor Giyim Mağazası', ' #87CEEB'),
(26, 'D&R', 1, '6', 3, 'Kitap Mağazası', ' #8A2BE2'),
(27, 'Starbucks', 1, '9', 3, 'Kafe', ' #228B22'),
(28, 'Flo', 1, '2', 4, 'Ayakkabı Mağazası', ' #FF6347'),
(29, 'Atasay', 1, '7', 4, 'Mücevherat Mağazası', ' #FF4500'),
(30, 'Sephora', 1, '3', 5, 'Kozmetik Mağazası', ' #FF1493'),
(31, 'Playland', 1, '8', 5, 'Oyun Salonu', ' #32CD32'),
(32, 'Bosch', 2, '2', 1, 'Beyaz Eşya', ' #4B0082'),
(33, 'IKEA', 2, '4', 1, 'Ev Dekorasyonu', ' #FFDAB9'),
(34, 'Pandora', 2, '8', 1, 'Takı Mağazası', ' #00CED1'),
(35, 'Toyzz Shop', 2, '3', 2, 'Oyuncak Dünyası', ' #FF69B4'),
(36, 'Kahve Dünyası', 2, '6', 2, 'Kahve Dükkânı', ' #8B4513'),
(37, 'LC Waikiki', 2, '1', 2, 'Tekstil', ' #FFD700'),
(38, 'Çiçek Sepeti', 2, '2', 3, 'Çiçekçi', ' #FFB6C1'),
(39, 'Petshop', 2, '7', 3, 'Evcil Hayvan Dükkanı', ' #FF6347'),
(40, 'Teknosa', 2, '4', 4, 'Cep Telefonu Aksesuarları', ' #00FF00'),
(41, 'Cinemaximum', 2, '8', 4, 'Sinema', ' #0000FF'),
(42, 'Oto Yedek Parça', 2, '2', 5, 'Oto Yedek Parça', ' #696969'),
(43, 'Mado', 2, '8', 5, 'Yemek Alanı', ' #F08080'),
(44, 'D&R', 2, '1', 5, 'Müzik Mağazası', ' #8A2BE2');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `closedpoints`
--
ALTER TABLE `closedpoints`
  ADD PRIMARY KEY (`point_id`),
  ADD KEY `floor_id` (`floor_id`);

--
-- Tablo için indeksler `elevators`
--
ALTER TABLE `elevators`
  ADD PRIMARY KEY (`elevator_id`),
  ADD KEY `floor_id` (`floor_id`);

--
-- Tablo için indeksler `floors`
--
ALTER TABLE `floors`
  ADD PRIMARY KEY (`floor_id`);

--
-- Tablo için indeksler `kiosks`
--
ALTER TABLE `kiosks`
  ADD PRIMARY KEY (`kiosk_id`),
  ADD KEY `floor_id` (`floor_id`);

--
-- Tablo için indeksler `stairs`
--
ALTER TABLE `stairs`
  ADD PRIMARY KEY (`stair_id`),
  ADD KEY `floor_id` (`floor_id`);

--
-- Tablo için indeksler `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`store_id`),
  ADD KEY `floor_id` (`floor_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `closedpoints`
--
ALTER TABLE `closedpoints`
  MODIFY `point_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `elevators`
--
ALTER TABLE `elevators`
  MODIFY `elevator_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `floors`
--
ALTER TABLE `floors`
  MODIFY `floor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `kiosks`
--
ALTER TABLE `kiosks`
  MODIFY `kiosk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `stairs`
--
ALTER TABLE `stairs`
  MODIFY `stair_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `stores`
--
ALTER TABLE `stores`
  MODIFY `store_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `closedpoints`
--
ALTER TABLE `closedpoints`
  ADD CONSTRAINT `closedpoints_ibfk_1` FOREIGN KEY (`floor_id`) REFERENCES `floors` (`floor_id`);

--
-- Tablo kısıtlamaları `elevators`
--
ALTER TABLE `elevators`
  ADD CONSTRAINT `elevators_ibfk_1` FOREIGN KEY (`floor_id`) REFERENCES `floors` (`floor_id`);

--
-- Tablo kısıtlamaları `kiosks`
--
ALTER TABLE `kiosks`
  ADD CONSTRAINT `kiosks_ibfk_1` FOREIGN KEY (`floor_id`) REFERENCES `floors` (`floor_id`);

--
-- Tablo kısıtlamaları `stairs`
--
ALTER TABLE `stairs`
  ADD CONSTRAINT `stairs_ibfk_1` FOREIGN KEY (`floor_id`) REFERENCES `floors` (`floor_id`);

--
-- Tablo kısıtlamaları `stores`
--
ALTER TABLE `stores`
  ADD CONSTRAINT `stores_ibfk_1` FOREIGN KEY (`floor_id`) REFERENCES `floors` (`floor_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
