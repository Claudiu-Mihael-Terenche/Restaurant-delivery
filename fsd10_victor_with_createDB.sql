-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3304
-- Generation Time: Nov 06, 2023 at 04:36 PM
-- Server version: 5.7.24
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fsd10_victor`
--
CREATE DATABASE IF NOT EXISTS `fsd10_victor` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `fsd10_victor`;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE `cart` (
  `dish_id` int(11) NOT NULL,
  `dish_name` varchar(100) NOT NULL,
  `dish_price` int(100) NOT NULL,
  `dish_image` varchar(255) NOT NULL,
  `dish_qty` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `contactus`
--

DROP TABLE IF EXISTS `contactus`;
CREATE TABLE `contactus` (
  `ContactUsID` int(11) NOT NULL,
  `FullName` varchar(100) NOT NULL,
  `UserEmail` varchar(100) NOT NULL,
  `Message` text NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contactus`
--

INSERT INTO `contactus` (`ContactUsID`, `FullName`, `UserEmail`, `Message`, `Timestamp`) VALUES
(1, 'Restaurant Information', 'DeliveryChef@gmail.com', 'Address: 122 Rue Saint-Paul E, Montreal, Quebec, h2Y 1G6\nPhone: 514-123-4567', '2023-11-05 04:54:50'),
(2, 'John Doe', 'johndoe@example.com', 'This is my message about the delivery service.', '2023-11-05 04:54:50'),
(4, 'Sunny Shinny', 'Sunny@sunny.com', 'adsggggggggggggggggggggggggggggggggggggggggggggggggg', '2023-11-05 05:46:45'),
(5, 'Lora Parker', 'Lora@email.com', 'HHHHHEeeeeeeeeeeeeeeellllllllllllllllllloooooooooooooooooooooooooooooo', '2023-11-05 05:48:13');

-- --------------------------------------------------------

--
-- Table structure for table `emp_delivery`
--

DROP TABLE IF EXISTS `emp_delivery`;
CREATE TABLE `emp_delivery` (
  `emp_id` int(11) NOT NULL,
  `emp_email` varchar(255) NOT NULL,
  `emp_pw` varchar(255) NOT NULL,
  `emp_fname` varchar(40) DEFAULT NULL,
  `emp_lname` varchar(40) DEFAULT NULL,
  `emp_phone` varchar(40) DEFAULT NULL,
  `status_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `emp_delivery`
--

INSERT INTO `emp_delivery` (`emp_id`, `emp_email`, `emp_pw`, `emp_fname`, `emp_lname`, `emp_phone`, `status_id`) VALUES
(1, 'emp01@dchef.com', '$2y$10$ERPnBIvviFL0.vdWugoRLeLbG78DJWKKWKHRsaO6Q5vHJo5Zp7ax.', 'John', 'doe', '123-456-7890', 100),
(2, 'emp02@dchef.com', '$2y$10$aTT5hkPVPOIzBCKCdKtJdODyyJT2Yv/SpuKCDKnWhttL7HGE2Mxz2', 'Bruce', 'Willice', '123-456-7890', 100),
(3, 'emp03@dchef.com', '$2y$10$Vu0orcMPX6lbn41gtP8SXOPkT/.nSiJepKDoqrsw1g2frWy6WiTEC', 'Jane', 'Eyre', '2223334444', 100),
(4, 'emp04@dchef.com', '$2y$10$uLOYlDgYcBg9dHWyJdN5NevnB53rxJgmiuZb4oLD/L9SonfOO.UrO', 'Bill', 'Bore', '333-555-4444', 400),
(5, 'emp05@dchef.com', '$2y$10$4Yw41fPqZTFAH34WlNA76e9nEuyEFiX/we3bOyCati6d0yKyfMA6e', 'Sam', 'Grim', '777-555-4444', 400),
(8, 'emp100@emp.com', '$2y$10$4gs4CzP7WBvhEmZFswQ55ulDvYfnXKx5Pcdkhh.7SO2bE55ymFqza', 'empFName', 'empLName', '999-8888-7777', 100);

-- --------------------------------------------------------

--
-- Table structure for table `food_cat`
--

DROP TABLE IF EXISTS `food_cat`;
CREATE TABLE `food_cat` (
  `foodcat_id` int(11) NOT NULL,
  `foodcat_desc` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `food_cat`
--

INSERT INTO `food_cat` (`foodcat_id`, `foodcat_desc`) VALUES
(100, 'Entree'),
(200, 'Vegetarian'),
(300, 'Meat'),
(400, 'Seafood'),
(500, 'Beverage');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `menu_id` int(11) NOT NULL,
  `dish_title` varchar(100) NOT NULL,
  `foodcat_id` int(11) NOT NULL,
  `price` bigint(20) NOT NULL,
  `image` varchar(100) DEFAULT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menu_id`, `dish_title`, `foodcat_id`, `price`, `image`, `description`) VALUES
(5, 'Wonton Soup', 100, 8, 'image/menu/100_Wonton_Soup.jpg', 'Indulge in the ultimate comfort food experience with our Wonton Soup with Tofu. This classic soup combines succulent, handcrafted wontons filled with flavorful goodness, gently floating in a savory, aromatic broth. The addition of delicate tofu cubes elevates this dish to a new level of satisfaction. Every spoonful is a harmonious blend of textures and tastes, making it a delightful choice for both meat lovers and vegetarians. Join us for a bowl of pure culinary comfort, and discover the joy of Wonton Soup with Tofu at its finest.'),
(14, 'Chinese Pepper Steak', 300, 16, 'image/menu/300_Chinese_Pepper_Steak.jpg', 'Indulge in the exquisite flavors of our Chinese Pepper Steak, a culinary masterpiece that invites your taste buds on a journey through the heart of Chinese cuisine. This delectable dish showcases succulent cuts of beef, stir-fried to perfection with a medley of crisp, vibrant vegetables, all harmoniously blended with a rich and aromatic symphony of Chinese spices and sauces.\r\n\r\nOur secret ingredient, Chinese pepper, adds a tantalizing hint of fragrance and just the right amount of subtle spiciness, creating a mouthwatering sensation that will leave you craving for more. Whether it\'s a special celebration or a cozy family dinner, our Chinese Pepper Steak is the ideal choice to elevate your dining experience.\r\n\r\nWhat sets us apart is the ability to customize this dish to suit your unique preferences. We\'re dedicated to ensuring that every plate served is a personalized masterpiece that caters to your specific tastes. So why not explore the captivating world of Chinese cuisine and savor the flavors of our Chinese Pepper Steak? Your culinary adventure awaits!'),
(15, 'Mongolian Beef', 300, 17, 'image/menu/300_Mongolian_Beef.jpg', 'Experience the bold and savory allure of our Mongolian Beef, a dish that brings the rich flavors of Mongolia to your plate. Succulent strips of tender beef are wok-fried to perfection, then generously coated with a delectable, sweet and savory sauce. Our chefs skillfully infuse this classic Mongolian recipe with their own unique touch.\n\nEach bite is a harmonious blend of succulent beef, crisp scallions, and a symphony of flavors that captures the essence of this beloved Asian dish. It\'s a tantalizing journey for your taste buds, providing a perfect balance of textures and tastes.\n\nMongolian Beef is a true crowd-pleaser, suitable for any occasion. Whether you\'re joining us for a quick lunch or a special dinner, this dish promises an unforgettable culinary experience. We invite you to savor the taste of Mongolia right here in our restaurant, where tradition meets innovation for a truly memorable dining adventure.'),
(17, 'Shrimp Fried Rice', 400, 16, 'image/menu/400_Shrimp_Fried_Rice.jpg', 'Delight in the classic flavors of our Shrimp Fried Rice, a timeless favorite that\'s the perfect blend of simplicity and deliciousness. Plump, succulent shrimp are expertly stir-fried with fluffy rice, farm-fresh vegetables, and our secret blend of savory seasonings.\r\n\r\nEach forkful of Shrimp Fried Rice offers a tantalizing combination of textures and tastes, from the tender shrimp to the perfectly cooked vegetables, all kissed with the savory aroma of our signature seasonings. This dish is a comforting and satisfying choice that never goes out of style.\r\n\r\nShrimp Fried Rice is the ideal companion for a quick lunch or a laid-back dinner, offering both heartwarming comfort and a taste of culinary excellence. Join us and savor this timeless classic, where every bite transports you to a world of flavor.'),
(18, 'Shrimp and Rice with Soybean sauce', 400, 16, 'image/menu/400_Shrimp_Rice_SoyBean_sauce.jpg', 'Embark on a culinary adventure with our Shrimp and Rice with Soybean Sauce, a dish that combines the exquisite flavors of the sea and the depth of umami. Plump, succulent shrimp are meticulously cooked and then lovingly drizzled with our secret soybean sauce, which infuses every bite with a burst of rich, savory goodness.\r\n\r\nThis dish brings together the succulence of shrimp and the comforting embrace of rice, creating a harmonious balance of textures and tastes. The soybean sauce, a culinary treasure, adds depth and complexity to each mouthful, making it a true gourmet experience.\r\n\r\nShrimp and Rice with Soybean Sauce is the epitome of fusion cuisine, where tradition meets innovation for a truly memorable dining adventure. It\'s an ideal choice for those seeking a unique and unforgettable flavor journey. Join us to savor the extraordinary combination of seafood and soybean sauce that transcends the ordinary.'),
(23, 'Crispy Teriyaki Tofu Broccoli', 200, 16, 'image/menu/200_Sheet_Pan_Crispy_Teriyaki_Tofu_Broccoli.jpg', 'Discover the perfect balance of textures and flavors with our Crispy Teriyaki Tofu and Broccoli. Tender tofu, lightly fried to a crispy perfection, is paired with vibrant broccoli florets, all generously coated in our signature teriyaki sauce. This delectable dish offers a delightful contrast between the crunchy tofu and the tender broccoli, while the sweet and savory teriyaki glaze ties it all together. Whether you\'re a tofu enthusiast or looking for a satisfying and wholesome meal, our Crispy Teriyaki Tofu and Broccoli is a delightful choice. Come experience the fusion of crispiness and succulence in every bite.'),
(24, 'Salmon Poke Bowl', 100, 12, 'image/menu/100_pokebowl.jpg', 'A salmon poke bowl is a mouthwatering Hawaiian-inspired dish that combines the freshness of salmon with a variety of complementary ingredients. It typically features cubed or thinly sliced salmon, served on a base of either white or brown rice. This luscious fish is then accompanied by a medley of vibrant vegetables such as cucumbers, avocados, and edamame.\r\n\r\nThe key to its irresistible flavor is the savory sauce, which often consists of soy sauce, sesame oil, and a hint of chili paste for a touch of heat. Toppings like sesame seeds and sliced scallions add texture and depth to the bowl.'),
(25, 'Ricotta quiche', 200, 16, 'image/menu/200_quiche.jpg', 'Indulge in a delectable culinary experience with our Ricotta Quiche, a savory delight that harmoniously combines the richness of creamy ricotta cheese with an array of flavorful ingredients. This dish is a symphony of flavors and textures, offering a comforting and satisfying meal.'),
(26, 'Thai Tea', 500, 8, 'image/menu/500_thaitea.jpg', 'Transport your taste buds to the enchanting flavors of Thailand with our meticulously crafted Thai Tea. This delightful beverage is a sweet and creamy blend of Thai tea leaves, condensed milk, and a hint of exotic spices, making it the perfect harmony of sweetness and refreshment.'),
(27, 'Seasonal Fruit Smoothie', 500, 10, 'image/menu/500_fruitsmoothie.jpg', 'Embark on a culinary journey through the changing seasons with our Seasonal Fruit Smoothie. This dynamic and vibrant beverage captures the essence of each season, offering a refreshing blend of locally sourced, in-season fruits that evolve with the time of year. It\'s a delightful tribute to the flavors and colors of nature.\r\n\r\nThe Seasonal Fruit Smoothie offers a rotating array of flavors that celebrate the changing seasons. Each sip is a unique blend of sweet, tart, and refreshing notes that mirror the fruits of the moment. The yogurt contributes to a velvety, indulgent texture, while the optional honey adds a touch of natural sweetness. When served with ice, it becomes a cool and revitalizing treat.'),
(28, 'Chocolate Chiapas', 500, 6, 'image/menu/500_chocolatechiapas.jpg', 'Embark on a rich and exotic journey through the heart of Chiapas, Mexico, with our Chocolate Chiapas beverage. This sumptuous creation pays homage to the traditional cacao-based beverages of the region, infusing the timeless allure of Mexican chocolate with a modern twist. It\'s a decadent and soul-warming experience in a cup.\r\n\r\nThe Chocolate Chiapas is a mesmerizing combination of flavors and textures. The Mexican chocolate imparts a profound, earthy chocolate taste, subtly spiced with notes of cinnamon. The steamed milk adds a creamy, indulgent quality, and the optional whipped cream and chocolate shavings provide a delightful contrast in both texture and flavor.'),
(29, 'Ramen (Miso Broth)', 300, 16, 'image/menu/300_Ramen.jpg', 'Miso Broth Ramen is a flavorful and comforting Japanese noodle soup that derives its unique and savory taste from miso paste, a fermented soybean seasoning. This beloved ramen variation is a harmonious combination of perfectly cooked noodles, umami-rich miso broth, and an assortment of delightful toppings, creating a truly satisfying and memorable culinary experience.\r\n\r\nMiso Broth Ramen offers a complex and satisfying taste experience. The miso broth infuses the noodles with a deep umami flavor, while the noodles themselves provide a chewy and hearty backdrop. Toppings contribute a variety of textures and flavors, from the tender chashu pork to the creaminess of the soft-boiled egg. The addition of seasonings allows diners to customize the dish, adding spiciness and depth according to their preferences.'),
(30, 'Paella', 400, 18, 'image/menu/400_Paella.jpg', 'Paella is a vibrant and iconic Spanish dish that celebrates the rich flavors of the Mediterranean, combining saffron-infused rice with an array of ingredients such as seafood, chicken, rabbit, vegetables, and spices. This one-pan wonder is a culinary masterpiece, offering a delectable taste of Spain\'s diverse culinary traditions.\r\n\r\nPaella offers a symphony of textures and flavors. The rice, delicately flavored with saffron and broth, is tender and slightly crispy at the bottom, providing a delightful contrast. The proteins and vegetables infuse the dish with their unique tastes and textures, creating a well-balanced and aromatic experience.'),
(31, 'Sarmale', 100, 12, 'image/menu/100_Sarmale.jpg', 'Sarmale, also known as \"cabbage rolls,\" is a traditional and beloved dish found in various Eastern and Southeastern European countries. This dish is a celebration of comfort and tradition, consisting of seasoned ground meat and rice, wrapped in cabbage leaves, and slow-cooked to perfection in a flavorful tomato sauce. Sarmale is a symbol of hospitality and a culinary treasure in the region.'),
(32, 'Vegan Burrito', 200, 16, 'image/menu/200_Burrito.jpeg', 'Experience the mouthwatering fusion of flavors and wholesome ingredients with our Vegan Burrito. This delicious and satisfying dish takes the traditional Mexican burrito and gives it a plant-based twist, showcasing a vibrant medley of vegetables, legumes, and spices, all wrapped in a soft tortilla. It\'s a satisfying and cruelty-free culinary delight that celebrates the art of vegan cooking.'),
(33, 'Bibimbap', 300, 14, 'image/menu/300_bibimbap.jpg', 'Bibimbap is a colorful and flavorful Korean dish that showcases the art of balance and harmony. Translated as \"mixed rice,\" this delectable meal is a captivating ensemble of fresh and sautéed vegetables, marinated meat (often beef), a sunny-side-up egg, and a fiery gochujang (red pepper paste) sauce, all served on a bed of steamed rice. Bibimbap is a culinary masterpiece, offering a delightful combination of textures and tastes that celebrate the essence of Korean cuisine.');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `address` varchar(40) NOT NULL,
  `city` varchar(40) NOT NULL,
  `province` char(2) NOT NULL,
  `zip` varchar(10) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `status_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_time`, `user_id`, `name`, `address`, `city`, `province`, `zip`, `phone`, `status_id`) VALUES
(2, '2023-11-03 17:14:07', 29, NULL, '375 Rue King Ouest', 'Sherbrooke', 'QC', 'J1H6B9', NULL, 100),
(3, '2023-11-04 15:37:33', 30, NULL, '1957 Saint-Catherine St W', 'Montreal', 'QC', 'H3H1M5', NULL, 100),
(4, '2023-11-06 01:25:49', 31, NULL, '1240 Fort St', 'Montreal', 'QC', 'H3H2B7', NULL, 102),
(6, '2023-11-06 16:22:09', 29, 'Jane Doe', '1234 st John', 'Montreal', 'QC', 'H1H2A3', '999-888-7777', 100),
(7, '2023-11-05 03:42:42', 32, 'Jane aere12345678824', '1234 rue Saint', 'Montreal', 'QC', 'A1A2B3', '222-2222-2222', 102),
(8, '2023-11-06 01:37:23', 32, 'SKK', '9999 Street Bob', 'Montreal', 'QC', 'H3Y2J3', '159-1591-1591', 100),
(9, '2023-11-06 02:38:00', 32, 'John ', '1234 street merry', 'Montreal', 'QC', 'H3Y2A1', '99999999999', 400),
(10, '2023-11-06 03:28:51', 32, 'assssssss', '1234 street merry', 'Montreal', 'QC', 'H3Y2A1', '99999999999', 400),
(11, '2023-11-06 16:29:38', 32, 'Sam simpson', '1234 street', 'MMM', 'QQ', 'H3H3H3', '555-5555-6666', 400),
(12, '2023-11-06 16:30:48', 32, 'Jane ', '2222 st-saint', 'Montreal', 'QC', 'H3H2J3', '222-3333-2222', 400),
(13, '2023-11-06 16:32:40', 32, 'Lora Parker', '2222 st-parker', 'LLLLL', 'LL', 'L2L4J4', '88888888888', 400),
(14, '2023-11-06 16:33:48', 32, 'Sarah', '8989 st-rolen', 'Montreal', 'QC', 'A2A2B3', '77799998888', 400),
(15, '2023-11-06 16:35:10', 32, 'Tom Cat', '8956 street Robert', 'Montreal', 'QC', 'A2A2B3', '5147772313', 400);

-- --------------------------------------------------------

--
-- Table structure for table `sched_order`
--

DROP TABLE IF EXISTS `sched_order`;
CREATE TABLE `sched_order` (
  `sched_id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `scheduleTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sched_order`
--

INSERT INTO `sched_order` (`sched_id`, `emp_id`, `order_id`, `scheduleTime`) VALUES
(5, 3, 2, '2023-11-03 03:11:03'),
(6, 2, 3, '2023-11-04 15:37:33'),
(7, 1, 4, '2023-11-04 16:30:58'),
(8, 4, 7, '2023-11-05 03:41:37'),
(9, 1, 8, '2023-11-06 01:37:23'),
(10, 8, 6, '2023-11-06 16:22:09');

-- --------------------------------------------------------

--
-- Table structure for table `service_sts`
--

DROP TABLE IF EXISTS `service_sts`;
CREATE TABLE `service_sts` (
  `status_id` int(11) NOT NULL,
  `status_desc` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `service_sts`
--

INSERT INTO `service_sts` (`status_id`, `status_desc`) VALUES
(100, 'Preparing'),
(101, 'On Delivery'),
(102, 'Delivered'),
(200, 'Pick Up'),
(400, 'Not Allocated');

-- --------------------------------------------------------

--
-- Table structure for table `tblgallery`
--

DROP TABLE IF EXISTS `tblgallery`;
CREATE TABLE `tblgallery` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `file_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblgallery`
--

INSERT INTO `tblgallery` (`id`, `title`, `file_path`) VALUES
(1, 'Quiche', 'image/menu/200_quiche.jpg'),
(2, 'Chicken Soup', 'image/ChickenSoup.jpg'),
(3, 'Ramen', 'image/menu/300_Ramen.jpg'),
(4, 'Spaghetti', 'image/spaghetti.jpg'),
(5, 'Mongolian Beef', 'image/menu/300_Mongolian_Beef.jpg'),
(6, 'Wonton Soup', 'image/menu/100_Wonton_Soup.jpg'),
(7, 'Pepper Steak', 'image/menu/300_Chinese_Pepper_Steak.jpg'),
(8, 'Sarmale', 'image/Sarmale.jpg'),
(9, 'Burrito', 'image/Burrito.jpeg'),
(10, 'thai tea', 'image/menu/500_thaitea.jpg'),
(11, 'chocolate chiapas', 'image/menu/500_chocolatechiapas.jpg'),
(12, 'steak', 'image/steak.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT NULL,
  `fname` varchar(100) DEFAULT NULL,
  `lname` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `province` char(2) DEFAULT NULL,
  `zip` varchar(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `role`, `fname`, `lname`, `phone`, `address`, `city`, `province`, `zip`) VALUES
(1, 'admin@admin.com', '$2y$10$.NjxUiW5O/pVxwDaMD1lUu61CKv4JFOSo/DrtwEk/rVY4L9JzwHNW', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 'mjs@mjs.com', '$2y$10$EUc4/FVARl4n0wFevC1Bs.3LCrr0UeKnU0wx8ujIakwDLx2aDrtiS', 'user', 'Mark', 'Sumoba', '1234567890', '203 sherbrooke st', 'Montreal', 'QC', 'A2A1H1'),
(30, 'nrt@nrt.com', '$2y$10$0pOeQp83Ex6V4GMS7iCgPOXSTicTNwjl/LnP/MJjhBWtGey3lZlmC', 'user', 'Nori', 'Nori', '0000000000', '123 chambly ave.', 'Montreal', 'QC', 'H1H2G2'),
(31, 'cmt@cmt.com', '$2y$10$ZExznmuSAyTpdvXlZwRoTOTwtXObW8ODqemlYuGfwAUyPzP9eJOKm', 'user', 'claudio', 'terrence', '0000000000', '38 verdun st', 'Montreal', 'QC', 'H1H2G2'),
(32, 'skk@skk.com', '$2y$10$p/VFAkEWgZXWOqWdIK/t6OSdNNeUdJlsB9ClRw7Df/UlMdQ1tAIE6', 'user', 'SAM', 'KIM', '777-7777-7777', '5555 rue SSSSA', 'City A', 'QC', 'J1J2A2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`dish_id`);

--
-- Indexes for table `contactus`
--
ALTER TABLE `contactus`
  ADD PRIMARY KEY (`ContactUsID`),
  ADD UNIQUE KEY `UC_UserEmail` (`UserEmail`);

--
-- Indexes for table `emp_delivery`
--
ALTER TABLE `emp_delivery`
  ADD PRIMARY KEY (`emp_id`),
  ADD KEY `empDelivery_status_fk` (`status_id`);

--
-- Indexes for table `food_cat`
--
ALTER TABLE `food_cat`
  ADD PRIMARY KEY (`foodcat_id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`menu_id`),
  ADD KEY `menu_foodCat_id_fk` (`foodcat_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `orders_status_fk` (`status_id`),
  ADD KEY `orders_users_fk` (`user_id`);

--
-- Indexes for table `sched_order`
--
ALTER TABLE `sched_order`
  ADD PRIMARY KEY (`sched_id`),
  ADD KEY `sched_emp_fk` (`emp_id`),
  ADD KEY `sched_order_fk` (`order_id`);

--
-- Indexes for table `service_sts`
--
ALTER TABLE `service_sts`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `tblgallery`
--
ALTER TABLE `tblgallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `dish_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `contactus`
--
ALTER TABLE `contactus`
  MODIFY `ContactUsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `emp_delivery`
--
ALTER TABLE `emp_delivery`
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `sched_order`
--
ALTER TABLE `sched_order`
  MODIFY `sched_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tblgallery`
--
ALTER TABLE `tblgallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `emp_delivery`
--
ALTER TABLE `emp_delivery`
  ADD CONSTRAINT `empDelivery_status_fk` FOREIGN KEY (`status_id`) REFERENCES `service_sts` (`status_id`);

--
-- Constraints for table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_foodCat_id_fk` FOREIGN KEY (`foodcat_id`) REFERENCES `food_cat` (`foodcat_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_users_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sched_order`
--
ALTER TABLE `sched_order`
  ADD CONSTRAINT `sched_order_fk` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
