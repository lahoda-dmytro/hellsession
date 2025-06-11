-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Час створення: Чрв 10 2025 р., 22:03
-- Версія сервера: 9.1.0
-- Версія PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `hellsession`
--

-- --------------------------------------------------------

--
-- Структура таблиці `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'Унікальний ідентифікатор категорії',
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Назва категорії, має бути унікальною',
  `slug` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Унікальний URL-friendly ідентифікатор категорії',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'Детальний опис категорії',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата і час створення запису',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Дата і час останнього оновлення запису',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_category_name` (`name`),
  UNIQUE KEY `uk_category_slug` (`slug`),
  KEY `idx_category_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Таблиця для зберігання категорій товарів';

--
-- Дамп даних таблиці `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(2, 'Necklaces', 'necklaces', '', '2025-06-03 12:39:57', '2025-06-03 12:39:57'),
(3, 'Earrings', 'earrings', '', '2025-06-03 12:40:17', '2025-06-03 12:40:17'),
(4, 'Bracelets', 'bracelets', NULL, '2025-06-03 16:48:45', '2025-06-06 16:48:45'),
(8, 'Rings', 'rings', NULL, '2025-06-06 01:25:08', '2025-06-06 01:25:08');

-- --------------------------------------------------------

--
-- Структура таблиці `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `city` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `address` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `postal_code` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `paid` tinyint(1) DEFAULT '0',
  `stripe_id` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `first_name`, `last_name`, `email`, `city`, `address`, `postal_code`, `created_at`, `updated_at`, `paid`, `stripe_id`) VALUES
(2, 2, 'Jonatan', 'Lean', 'qweqwe@gmail.com', 'Odesa', 'Odesa', '4848', '2025-06-07 19:05:50', '2025-06-07 19:05:50', 0, NULL),
(3, 3, 'Yuriy', 'Matyushevsky', 'qwe@gmail.com', 'Zhytomyr', 'Velika Berdychivska, 10', '10001', '2025-06-07 23:42:42', '2025-06-08 12:52:55', 1, NULL),
(4, 3, 'Yuriy', 'Matyushevsky', 'qwe@gmail.com', 'Zhytomyr', 'Velika Berdychivska, 10', '10001', '2025-06-07 23:43:21', '2025-06-07 23:43:21', 0, NULL),
(5, 3, 'Yuriy', 'Matyushevsky', 'qwe@gmail.com', 'Zhytomyr', 'Velika Berdychivska, 10', '10001', '2025-06-08 23:04:32', '2025-06-08 23:04:32', 0, NULL),
(7, 2, 'Jonatan', 'Lean', 'qweqwe@gmail.com', 'Zhytomyr', 'Stariy Bulvar, 10', '21333', '2025-06-09 12:19:19', '2025-06-09 12:19:19', 0, NULL),
(8, 2, 'Jonatan', 'Lean', 'qweqwe@gmail.com', 'Zhytomyr', 'Velika Berdychivska, 10', '12323', '2025-06-09 16:27:41', '2025-06-09 16:27:41', 0, NULL),
(9, 2, 'Jonatan', 'Lean', 'qweqwe@gmail.com', 'Warszawa', 'Jana Pawla II, 82', '02496', '2025-06-09 16:31:48', '2025-06-09 16:32:51', 1, NULL),
(11, 2, 'Jonatan', 'Lean', 'qweqwe@gmail.com', 'Warszawa', 'Velika Berdychivska, 10', '10001', '2025-06-09 18:38:55', '2025-06-09 18:44:26', 1, NULL),
(13, 3, 'Yuriy', 'Matyushevsky', 'qwe@gmail.com', 'Zhytomyr', 'Velika Berdychivska, 10', '10001', '2025-06-09 18:58:05', '2025-06-09 18:58:05', 0, NULL),
(15, 3, 'Yuriy', 'Matyushevsky', 'qwe@gmail.com', 'Odesa', 'Velika Berdychivska, 10', '10001', '2025-06-09 19:03:31', '2025-06-09 19:03:52', 1, NULL),
(16, 2, 'Jonatan', 'Lean', 'qweqwe@gmail.com', 'Zhytomyr', 'Stariy Bulvar, 10', '43234', '2025-06-10 12:14:49', '2025-06-10 12:15:11', 1, NULL),
(21, 6, 'Egor', 'Nightfall', 'zxczxc@gmail.com', 'Warszawa', 'Velika Berdychivska, 10', '4848', '2025-06-10 17:29:29', '2025-06-10 17:29:46', 1, NULL),
(22, 2, 'Jonatan', 'Lean', 'qweqwe@gmail.com', 'Warszawa', 'Velika Berdychivska, 10', '10001', '2025-06-10 23:26:17', '2025-06-10 23:27:14', 1, NULL);

-- --------------------------------------------------------

--
-- Структура таблиці `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` int UNSIGNED NOT NULL,
  `product_id` int UNSIGNED NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` smallint UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `price`, `quantity`) VALUES
(2, 2, 1, 42.75, 2),
(3, 2, 12, 54.00, 1),
(4, 3, 13, 43.95, 2),
(5, 3, 8, 45.90, 1),
(6, 4, 1, 42.75, 1),
(7, 4, 6, 90.00, 1),
(8, 5, 2, 27.32, 1),
(9, 5, 1, 42.75, 2),
(12, 7, 1, 42.75, 1),
(13, 7, 10, 54.00, 1),
(14, 8, 17, 38.00, 1),
(15, 9, 2, 27.32, 1),
(16, 9, 17, 38.00, 1),
(19, 11, 13, 43.95, 1),
(26, 13, 17, 38.00, 1),
(29, 15, 17, 38.00, 1),
(30, 15, 13, 43.95, 1),
(31, 15, 12, 54.00, 6),
(32, 16, 8, 45.90, 1),
(40, 21, 12, 54.00, 1),
(41, 21, 8, 45.90, 2),
(42, 22, 17, 38.00, 1),
(43, 22, 13, 43.95, 4);

-- --------------------------------------------------------

--
-- Структура таблиці `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'Унікальний ідентифікатор товару',
  `category_id` int NOT NULL COMMENT 'Зовнішній ключ до таблиці `categories`',
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Назва товару',
  `slug` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Унікальний URL-friendly ідентифікатор товару',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'Детальний опис товару',
  `short_description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Короткий опис для прев''ю або списків',
  `price` decimal(10,2) NOT NULL COMMENT 'Базова ціна товару',
  `discount_percentage` decimal(5,2) NOT NULL DEFAULT '0.00' COMMENT 'Відсоток знижки на товар (наприклад, 15.75 для 15.75%)',
  `available` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Статус наявності товару (1=в наявності, 0=немає в наявності)',
  `main_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Відносний шлях до головного зображення товару',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата і час створення запису',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Дата і час останнього оновлення запису',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_product_slug` (`slug`),
  KEY `idx_product_name` (`name`),
  KEY `idx_product_price` (`price`),
  KEY `idx_product_created_at` (`created_at`),
  KEY `fk_products_category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Таблиця для зберігання інформації про товари';

--
-- Дамп даних таблиці `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `description`, `short_description`, `price`, `discount_percentage`, `available`, `main_image`, `created_at`, `updated_at`) VALUES
(1, 3, 'Bacchanal Rose (P700)', 'bacchanal-rose-(p700)', 'A ornate pewter necklace of tangled grape vines surrounding three black resin roses and suspended with a clear Austrian crystal tear dropper.\r\n\r\nSizing/Capacity (approx.):\r\nOverall length 16\" (40 mm) , with a 1 ½\" extender chain.\r\n\r\nMaterials & Origin:\r\nDesigned and hand made in England incorporating highest quality, crystal* and fine English pewter. This item is compliant to all jewellery regulations including EU REACH Directives and California Proposition 65.\r\n*Crystal colours are subject to availability, and may vary from the image shown.', 'A sumptuous necklace with a romantic motif hiding, or revealing, a secret libertine passion for wine and sensual pleasures.', 47.50, 20.00, 1, '/uploads/products/1/main_image.jpg', '2025-06-03 13:04:53', '2025-06-10 20:25:18'),
(2, 4, 'Churchyard (A143)', '1990-churchyard', 'Introducing our exquisite \'Churchyard\' bracelet, a masterpiece we lovingly refer to as hand jewellery here at Alchemy! This intricately designed piece is more than just an accessory; it\'s a celebration of nature\'s beauty. Adorned with delicate Ivy leaves, baroque swirls and a stunning Ivy green Austrian cut crystal, this bracelet captures the essence of sorrow and tranquillity.\r\n\r\nMaterials & Origin:\r\nDesigned and hand made in England incorporating highest quality, crystal* and fine English pewter. This item is compliant to all jewellery regulations including EU REACH Directives and California Proposition 65.\r\n*Crystal colours are subject to availability, and may vary from the image shown.\r\n\r\n', 'An ivy strangled gothic cusping signifying sorrow and affection for those gone before, and those who are yet to go...\r\n\r\n', 30.36, 10.00, 1, '/uploads/products/1990-churchyard/6843509738c5f.jpg', '2025-06-04 19:53:42', '2025-06-10 13:13:47'),
(3, 3, 'Baroque Rose (P955)', 'baroque-rose-(p955)', 'Baroque style inspires this beautifully delicate necklace with rose vine detail and a single black rose, accentuated by a with a stunning black Austrian crystal.\r\n\r\nSizing/Capacity (approx.):\r\nOn an 18\" (46cm) split chain with chain adjuster.\r\n\r\nMaterials & Origin:\r\nDesigned and hand made in England in fine English pewter. This item is compliant to all jewellery regulations including EU REACH Directives and California Proposition 65.', 'Discovered in a former boudoir of Palais Cardinal, Paris. this jewel was said to have been given to the favourite lover of the powerful c17 French war minister and clergyman, and notorious womaniser, Cardinal Richelieu.', 35.83, 0.00, 1, '/uploads/products/2/main_image.jpg', '2025-06-05 20:14:13', '2025-06-06 11:53:56'),
(4, 4, 'Wild Black Rose Bangle', 'wild-black-rose-bangle', 'A trinity of jet-coloured blooms - a portent of love from the shadows.\r\n\r\nA hinged pewter, twisted rose thorn bracelet featuring three black resin roses upon the front. The central rose, (attached to a short safety chain), forms the locking device with a strong magnet; simply unfasten by pulling the centre rose out from its magnetic lock.\r\n\r\n', 'A trinity of jet-coloured blooms - a portent of love from the shadows.', 57.95, 0.00, 1, '/uploads/products/wild-black-rose-bangle/68432330e0497.jpg', '2025-06-06 15:07:19', '2025-06-06 17:19:44'),
(5, 8, 'qwerty', 'qwerty', 'A trinity of jet-coloured blooms - a portent of love from the shadows.\r\n\r\nA hinged pewter, twisted rose thorn bracelet featuring three black resin roses upon the front. The central rose, (attached to a short safety chain), forms the locking device with a strong magnet; simply unfasten by pulling the centre rose out from its magnetic lock.\r\n\r\n', 'A trinity of jet-coloured blooms - a portent of love from the shadows.', 85.00, 0.00, 1, '/uploads/products/qwerty/6842db6abd6ed_wild-black-rose-bangle.jpg', '2025-06-06 15:13:30', '2025-06-06 15:13:30'),
(6, 8, 'Eternal Peace (P971)', 'eternal-peace-(p971)', 'Fastening: Necklace hangs from a ribbon or nickel-free split chain with clasp fastener and chain adjuster. (Both options supplied)\r\n\r\nWeight & Dimensions (approx.): H: 66mm (2.60\") W: 40mm (1.57\") D: 11mm (0.43\") Weight: 37g (1.31oz) ... (Please note neck jewellery dimensions are excluding the fastenings)\r\n\r\nMaterials & Origin: Designed and hand made in England incorporating enamel work and fine English pewter. This item is compliant to all jewellery regulations including EU REACH Directives and California Proposition 65.', 'Fastening: Necklace hangs from a ribbon or nickel-free split chain with clasp fastener and chain adjuster. (Both options supplied)\r\n', 90.00, 0.00, 1, '/uploads/products/січммчсм/6842dc36a3a70_churchyadsdrd.jpg', '2025-06-06 15:16:54', '2025-06-06 23:26:56'),
(8, 2, 'Reina Wycca (P969)', 'reina-wycca-(p969)', 'Product Description: Embrace the awe of divine femininity and mystical power with our exquisite \'Wycca Queen\' crowned triple moon necklace. Inlaid with a stunning black onyx disc. Crafted with precision, the necklace is etched with intricate Alchemical sigils and the enigmatic seal of Lilith, connecting you to the depths of ancient wisdom and esoteric beauty. The polished pewter offers a celestial shine, while a mesmerizing grey Austrian crystal shimmers gracefully below, catching the light with every movement!\r\n\r\nWeight & Dimensions (approx.): H: 78mm (3.07\") W: 57mm (2.24\") D: 6mm (0.24\") Weight: 25g (0.88oz) ... (Please note neck jewellery dimensions are excluding the fastenings)\r\n\r\n', 'The crowned triple moon of the mother goddess endowed with the principle seal of Lilith upon the onyx disc, flanked by the alchemical sigils for mercury and sulphur.', 51.00, 10.00, 1, '/uploads/products/reina-wycca-(p969)/684350ecee713.jpg', '2025-06-06 18:05:17', '2025-06-10 13:13:43'),
(9, 2, 'Cross of the Dark Kiss (P975)', 'cross-of-the-dark-kiss-(p975)', 'Introducing the \'Cross of the Dark Kiss\' pendant-a dramatic statement piece that defies convention and celebrates individuality. Hand Crafted in antiqued English pewter, with meticulous detail, a long cross, adorned with intricately woven ivy and crescent moons. At its heart lies a stunning blood-red enamelled heart, echoing the passion and allure of love\'s deeper, darker facets. Anchored in its center is a jet black rose, a symbol of eternal beauty and resilience.\r\n\r\nVersatile and unique, the Alchemy \'Cross of the dark Kiss\' pendant comes complete with a long chain that can be worn in multiple ways-whether you prefer it as a double, long, or short piece, this jewellery adapts to your unique sense of style!\r\n\r\n', 'The escutcheon dramatis from the coffin lid, in grave memory of the eternally extant beauty so beloved of the revenant Count Magistus.', 52.00, 0.00, 1, '/uploads/products/cross-of-the-dark-kiss-(p975)/6843234977a62.jpg', '2025-06-06 18:05:53', '2025-06-06 17:20:09'),
(10, 3, 'BLACK WIDOW (P432B)', 'black-widow-(p432b)', 'A giant blackened pewter spider necklace set with red Austrian crystals.\r\n\r\n', 'The deadly predator, poised to sink its irresistible fangs.', 54.00, 0.00, 1, '/uploads/products/black-widow-(p432b)/6843235ee96e7.jpg', '2025-06-06 18:06:26', '2025-06-06 17:20:30'),
(11, 2, 'DESIRE MOI (P926)', 'desire-moi-(p926)', 'An elegant but striking cupids bow and arrow necklace. A hand polished baroque bow with crescent moon detail and contrasting black pewter arrow. A heart shaped arrowhead is inlaid with the most beautiful of Austrian crystals, a red Siam tear drop.\r\n\r\n', 'Erotic love will overwhelm any victim of Cupid\'s arrow.', 49.95, 0.00, 1, '/uploads/products/desire-moi-(p926)/6843236957158.jpg', '2025-06-06 18:07:31', '2025-06-06 17:20:41'),
(12, 2, 'P907 Mon Amour de Soubise Necklace', 'p907-mon-amour-de-soubise-necklace', 'Un collar de peltre de 4 ¼ \"de ancho por 3\" de intrincado pergamino rococó con un corazón negro esmaltado en el centro y un cristal rojo de Swarovski a cada lado.\r\n\r\nEn una cadena de traza dividida, 16 ½ \"(42 cm) de largo en general más un extensor de 35 mm.\r\n\'My Love of Soubise\' - a feature betraying an illicit affaire at the prince\'s palace.\r\n\r\nA 4 ¼\" wide by 3\" deep pewter necklace of intricate Rococo scrollwork with an enamelled black heart at its centre and a red Swarovski crystal on either side.\r\n\r\nOn a split trace chain, 16 ½\" (42cm) long overall plus a 35mm extender.\r\n\r\n\r\n', '\'My Love of Soubise\' - a feature betraying an illicit affaire at the prince\'s palace.', 54.00, 0.00, 1, '/uploads/products/p907-mon-amour-de-soubise-necklace/68432375a2f39.jpg', '2025-06-06 18:08:22', '2025-06-06 17:20:53'),
(13, 2, 'CROSS OF BAPHOMET (P952)', 'cross-of-baphomet-(p952)', 'A Templar counter-stroke against the Inquisition, with the skull of Baphomet impaled on the cross of cruxifixction.\r\n\r\nAn intricate cross with fleur de leys and scroll decoration impaled through a blackened rams skull with silver coloured horns.\r\n\r\n', 'A Templar counter-stroke against the Inquisition, with the skull of Baphomet impaled on the cross of cruxifixction.', 43.95, 0.00, 1, '/uploads/products/cross-of-baphomet-(p952)/6843238d776b6.jpg', '2025-06-06 18:08:49', '2025-06-06 20:47:24'),
(17, 2, 'Vampire\'s Eye (P966)', 'vampire\'s-eye-(p966)', 'Those before you are callously scrutinised by the glazed and sightless eye of this insatiable revenant.\r\n\r\nProduct Description: Discover a striking fusion of elegance and mystery with our exquisite \'Vampires Eye\' bat pendant. Handcrafted from fine English pewter, this dramatic piece captures the essence of the night sky, featuring a bat clutching a luminous pearl moon between its wings.\r\n\r\n', 'Those before you are callously scrutinised by the glazed and sightless eye of this insatiable revenant.\r\n\r\n', 38.00, 0.00, 1, '/uploads/products/vampire\'s-eye-(p966)/6845ff4a85341.jpg', '2025-06-09 00:23:22', '2025-06-09 15:41:44'),
(18, 2, 'Sweet Death Pendant', 'sweet-death-pendant', 'Glorifying the immortality of perfection, as perceived in the magnificent beauty of the human skull, only truly revealing its poetic harmony once stripped of its mortal mask!\r\n\r\nThis captivating necklace features a beautifully crafted polished skull adorned with intricate baroque detail. Suspended from delicate chains, this necklace exudes a sense of sophistication while maintaining its rebellious spirit. The piece is elegantly finished with a stunning jet black Austrian fine cut crystal, adding a touch of glamour to a dark look!', '', 40.00, 0.00, 1, '/uploads/products/sweet-death-pendant/684831af7752e.jpg', '2025-06-10 16:22:55', '2025-06-10 16:22:55');

-- --------------------------------------------------------

--
-- Структура таблиці `product_images`
--

DROP TABLE IF EXISTS `product_images`;
CREATE TABLE IF NOT EXISTS `product_images` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'Унікальний ідентифікатор зображення',
  `product_id` int NOT NULL COMMENT 'Зовнішній ключ до таблиці `products`',
  `image_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Відносний шлях до файлу зображення',
  `sort_order` int NOT NULL DEFAULT '0' COMMENT 'Порядок відображення зображення в галереї (менше число = вище в списку)',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата і час створення запису',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Дата і час останнього оновлення запису',
  PRIMARY KEY (`id`),
  KEY `idx_product_image_product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Таблиця для зберігання додаткових зображень товарів';

--
-- Дамп даних таблиці `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_path`, `sort_order`, `created_at`, `updated_at`) VALUES
(2, 1, 'uploads/products/1/gallery_2.jpg', 20, '2025-06-03 13:06:41', '2025-06-03 13:06:41'),
(3, 3, 'uploads/products/2/gallery_1.jpg', 10, '2025-06-05 20:14:53', '2025-06-05 20:15:45'),
(4, 4, '/uploads/products/wild-black-rose-bangle/68432330e12bd.jpg', 10, '2025-06-06 17:19:44', '2025-06-06 17:19:44'),
(5, 13, '/uploads/products/cross-of-baphomet-(p952)/6843238d79262.jpg', 10, '2025-06-06 17:21:17', '2025-06-06 17:21:17'),
(6, 13, '/uploads/products/cross-of-baphomet-(p952)/6843238d7a6d9.jpg', 20, '2025-06-06 17:21:17', '2025-06-06 17:21:17'),
(7, 1, '/uploads/products/bacchanal-rose-(p700)/6843507e61571.jpg', 10, '2025-06-06 20:33:02', '2025-06-06 20:33:02'),
(8, 8, '/uploads/products/reina-wycca-(p969)/684350ecef29f.jpg', 10, '2025-06-06 20:34:52', '2025-06-06 20:34:52'),
(9, 17, '/uploads/products/vampire\'s-eye-(p966)/6845ff4a87546.jpg', 10, '2025-06-08 21:23:22', '2025-06-08 21:23:22'),
(10, 18, '/uploads/products/sweet-death-pendant/684831af78b4d.jpg', 10, '2025-06-10 13:22:55', '2025-06-10 13:22:55');

-- --------------------------------------------------------

--
-- Структура таблиці `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `joined_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` datetime DEFAULT NULL,
  `is_superuser` tinyint NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `first_name`, `last_name`, `joined_date`, `last_login`, `is_superuser`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$lPAuHhpQsmRkokY.Ck800.QLblzD4WhP3KDntglS.4RTOJjovzN1a', 'admin@gmail.com', NULL, NULL, '2025-05-31 00:14:14', '2025-06-10 21:47:49', 1, '2025-05-31 00:14:14', '2025-06-02 16:06:48'),
(2, 'yunglean2001', '$2y$10$LBLoI65/92I0I0ByimQ5leUPp8CPnysSaCwb76.qOwMcWrqgWctU6', 'qweqwe@gmail.com', 'Jonatan', 'Lean', '2025-06-02 13:08:21', '2025-06-10 20:24:11', 0, '2025-06-02 16:08:21', '2025-06-02 16:08:21'),
(3, 'code10', '$2y$10$1xqehrDn7ZOL5VY/ANpWYuyEKCm.qDcHBQ.OoA6XHEDIP4EYyCDIK', 'qwe@gmail.com', 'Yuriy', 'Matyushevsky', '2025-06-02 13:22:14', '2025-06-10 21:26:41', 0, '2025-06-02 16:22:14', '2025-06-02 16:22:14'),
(4, 'entomb3nt', '$2y$10$SomLVhr05Y70cVwO8hPpNuxK/.bELc6FCW7zXYOQpFOGsFQ5xo3je', 'entomb3nt@gmail.com', 'Dmytro', 'Lahoda', '2025-06-02 13:43:56', NULL, 0, '2025-06-02 16:43:56', '2025-06-02 16:43:56'),
(5, 'xanaxhol1c', '$2y$10$k6yAbfG/W/EQA5SE6ZfcHu9y6pANXL/uBkNF4R3E1GPeFpZdsMVu2', 'zxc@gmail.com', 'Loram', 'Hoptan', '2025-06-02 14:48:12', '2025-06-02 14:48:12', 0, '2025-06-02 17:48:12', '2025-06-02 17:48:12'),
(6, 'epileptick1d', '$2y$10$efrvAhUzqhKoSDL9OP5BL.0XgnSAswpQ7l2lfwQv.X62ohPs/ZFI2', 'zxczxc@gmail.com', 'Egor', 'Nightfall', '2025-06-03 19:30:36', '2025-06-10 14:18:35', 0, '2025-06-03 22:30:36', '2025-06-03 22:30:36'),
(7, 'alohadance', '$2y$10$Gy6ljIOkdycDRK94x1ebtuhpIiiF9/QMwPLG99iEGZSTsxKs8l6h.', 'alohadance@gmail.com', 'Illia', 'Korobkin', '2025-06-10 20:49:30', '2025-06-10 20:49:30', 0, '2025-06-10 20:49:30', '2025-06-10 20:49:30');

--
-- Обмеження зовнішнього ключа збережених таблиць
--

--
-- Обмеження зовнішнього ключа таблиці `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_category_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Обмеження зовнішнього ключа таблиці `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `fk_product_images_product_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
