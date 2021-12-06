# Lazy_DB-CSC-4710
This is a project developed for CSC 4710 at gsu
## ER Diagram
We decided to mock a chain of online stores that sells a variety of products notably in the food industry. 
We have a total of 10 stores each in different stores each in different cities around the world. Each product is identified by its upc, and different stores have different inventory and price for a specefic products. Some products are also part of a promotion, so if bought, consumner will see a reduction of price when they decide to checkout. 

phpMyAdmin is used as a web interface for handling the database administration and queries. By this, backend acess to lazy_DN is made possible for fetching, updating and analyzing data on the database sever. Our consumers need to register with an account before being able to order anything in our store. After successful registration. A consumer can order many products under one specific order and get added to order_item list.

<img width="551" alt="E-R Diagram" src="https://user-images.githubusercontent.com/83239858/144768634-b5f47eef-bd4c-4bab-bed3-f4139c6f45f5.png">


## SQL DDL and Insert

```
-- lazy_db.customer definition

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- lazy_db.vendor definition

CREATE TABLE `vendor` (
  `vendor_id` int(11) NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`vendor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- lazy_db.order_ definition

CREATE TABLE `order_` (
  `year` int(11) NOT NULL,
  `month` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `week` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  PRIMARY KEY (`order_id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `order__ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- lazy_db.product definition

CREATE TABLE `product` (
  `upc` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_type` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`upc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- lazy_db.order_item definition

CREATE TABLE `order_item` (
  `upc` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_id` int(11) NOT NULL,
  PRIMARY KEY (`upc`,`order_id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `order_item_ibfk_1` FOREIGN KEY (`upc`) REFERENCES `product` (`upc`),
  CONSTRAINT `order_item_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `order_` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- lazy_db.deals definition

CREATE TABLE `deals` (
  `deal_id` int(11) NOT NULL,
  PRIMARY KEY (`deal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- lazy_db.promotion definition

CREATE TABLE `promotion` (
  `deal_id` int(11) NOT NULL,
  `upc` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount` decimal(5,2) NOT NULL,
  PRIMARY KEY (`deal_id`,`upc`),
  KEY `upc` (`upc`),
  CONSTRAINT `promotion_ibfk_1` FOREIGN KEY (`upc`) REFERENCES `product` (`upc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- lazy_db.inventory definition

CREATE TABLE `inventory` (
  `inventory_id` int(11) NOT NULL,
  `upc` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_count` int(11) NOT NULL,
  PRIMARY KEY (`inventory_id`),
  KEY `upc` (`upc`),
  CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`upc`) REFERENCES `product` (`upc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- lazy_db.location definition

CREATE TABLE `location` (
  `city` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `income_range` int(11) NOT NULL,
  PRIMARY KEY (`city`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
-- lazy_db.store definition

CREATE TABLE `store` (
  `open_time` time NOT NULL,
  `close_time` time NOT NULL,
  `store_id` int(11) NOT NULL,
  `city` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`store_id`),
  KEY `city` (`city`),
  CONSTRAINT `store_ibfk_1` FOREIGN KEY (`city`) REFERENCES `location` (`city`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- lazy_db.check_product definition

CREATE TABLE `check_product` (
  `store_id` int(11) NOT NULL,
  `inventory_id` int(11) NOT NULL,
  `upc` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`store_id`,`inventory_id`,`upc`),
  KEY `inventory_id` (`inventory_id`),
  KEY `upc` (`upc`),
  CONSTRAINT `check_product_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `store` (`store_id`),
  CONSTRAINT `check_product_ibfk_2` FOREIGN KEY (`inventory_id`) REFERENCES `inventory` (`inventory_id`),
  CONSTRAINT `check_product_ibfk_3` FOREIGN KEY (`upc`) REFERENCES `product` (`upc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- lazy_db.has_prod definition

CREATE TABLE `has_prod` (
  `upc` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_id` int(11) NOT NULL,
  `price` decimal(19,2) NOT NULL,
  `currency` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`upc`,`store_id`),
  KEY `store_id` (`store_id`),
  CONSTRAINT `has_prod_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `store` (`store_id`),
  CONSTRAINT `has_prod_ibfk_2` FOREIGN KEY (`upc`) REFERENCES `product` (`upc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- lazy_db.supply definition

CREATE TABLE `supply` (
  `vendor_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `upc` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supply_count` int(11) NOT NULL,
  PRIMARY KEY (`vendor_id`,`store_id`,`upc`),
  KEY `store_id` (`store_id`),
  KEY `upc` (`upc`),
  CONSTRAINT `supply_ibfk_1` FOREIGN KEY (`vendor_id`) REFERENCES `vendor` (`vendor_id`),
  CONSTRAINT `supply_ibfk_2` FOREIGN KEY (`store_id`) REFERENCES `store` (`store_id`),
  CONSTRAINT `supply_ibfk_3` FOREIGN KEY (`upc`) REFERENCES `product` (`upc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
 ```
 ```
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (17710494, 'Felipa Lemke', 'gina19', '92bed7bf3578a6db5ee2153b2b04adda324109cf');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (87201097, 'Soledad Von', 'xhahn', '836d24693ff316ba4217b2dbb25d48e83fac4016');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (128163133, 'Cora Kshlerin', 'maci.erdman', '590adcc1adada6750deadf5156d3994222107a9f');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (129226034, 'Mrs. Clementine Waelchi', 'hschinner', 'bc6e40408254e51bf745dcc8f720a15afbd136c5');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (168045844, 'Elizabeth Harvey', 'ellis.glover', '9a3c80a5e84f8af96b23474c22c16634cfe0c18c');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (187488933, 'Prof. Kirk Oberbrunner I', 'llarkin', '1504378e60de428cea05e55b7a42a803052d27a2');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (191934165, 'Ofelia Hintz III', 'sroberts', 'a06d41aa11a224dd910fa58d5b9480d62f5a23b1');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (204193118, 'Dr. Jacklyn Gusikowski', 'damian.kreiger', 'c5fcbd36ac8a128a91bcc6b333ad949bfc928bd9');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (205409415, 'Dr. Nathen Hermiston', 'zackary85', 'd044c390fe9916a4ff9b0173a13afad352be7c1b');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (253627527, 'Benjamin Toy', 'libby41', 'b6d13d1606913cb200421acf28252fcd18e0e5ef');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (280737845, 'Prof. Kianna Sanford', 'rylee.lebsack', '70ff59edf9f03b09abfb557b7fbf530413b08662');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (292762451, 'Maximillian Upton', 'schuppe.conner', 'ebdc31b6af0bf44dcbd385f1ea77517b682c519c');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (307171625, 'Krista Wintheiser', 'wolff.ned', '63ef478deee44b5d46552c14e37c65d25622f4cc');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (358868118, 'Glenda Greenfelder MD', 'powlowski.hilario', '6baf2a9d7c3197187004d5325cef192faad274b5');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (384969951, 'Ms. Bernita Jakubowski', 'nico.bauch', '10df86a85b2bc1b6d41030a71d877f6c8d44bc12');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (391733781, 'Mr. Garrick Blick III', 'jamey29', '9808a38639c9ccc1652b67fa43160b807af36c4a');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (406134106, 'Una Quitzon', 'jaylon93', 'cef149aaad1a785eba62796c7f284dfcdd8bf8b2');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (416252481, 'Ray McKenzie', 'lakin.keara', 'b53a0555b50541c6dcdff484f79801dceb59b41d');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (416682441, 'Miss Virgie Halvorson', 'langosh.brenda', 'c055f93615caadc6fcac070f26e5152e981ca833');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (427764181, 'Mortimer Fritsch', 'mary.price', '4042f3773be73f0178fe7f8d061d27f274a63279');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (434898684, 'Prof. Uriah O\'Kon', 'hschmidt', 'e677c18d87e1b62ffbe891deb7fd79f98d7df619');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (472674614, 'Darrin Upton', 'willy.schaefer', '780bde209672093c36b94c265183e62e672ce396');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (473559949, 'Israel Robel', 'ada68', '05f7a7ce1d4944745315a758374b835bf2da5707');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (475456428, 'Kobe Bradtke', 'lydia90', 'd1553ed177e7dff764bf0dba8e4de0204c225814');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (490165113, 'Dr. Tamia Leuschke', 'rick39', '2592846fb4fb7a2e49d7e652ed733e1e47e9da2e');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (491080454, 'Mario Robel', 'ojohns', '87f46eeae4932d85d463be0cc113eec0b177f713');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (496179528, 'Quincy Heidenreich DDS', 'sfeil', '799359553b03a44a309e224c7c5733859fa0ee6b');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (504499850, 'Phoebe White', 'zoila76', '8a274ea2705819b0d8d41fcd8bd702c1f4d7d388');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (513849348, 'Hattie Littel V', 'mathilde.ferry', '996ec3cd1e193c274e227ba29f7dcd16b35b623e');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (545980730, 'Ms. Jaunita Fahey PhD', 'vicky97', '62d6287fdc18f9c48bebd25b5fd2847aff35be96');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (567776519, 'Christophe Will', 'dibbert.tad', '20eb74858da84f8c836848dec96888f82c20bd16');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (577418564, 'Rubie Kessler II', 'delphine.thiel', '1e32611503931a1983b0a16d5b5664f0eca5ec56');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (579790811, 'Frederik Jacobi MD', 'qherman', 'a2e173330a514badb036e7f5f3da2a35a08fe669');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (609718022, 'Mazie Dickens IV', 'rita.stokes', 'e616768fd493ade2c2fbbd74a5b2beab822e7740');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (628599613, 'Kamryn Borer', 'carole90', 'fe8e3f3a7d3ad76545bc40a83b02968dd56c985c');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (635518932, 'Eleanora Schuster', 'thelma24', 'ffe8de6f339380e3e1dc9a4743b543e7e582ee5b');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (641948846, 'Ms. Billie Goodwin V', 'leuschke.kiarra', '07ae4d23198e6fab597dce6d54d7250cbf52e67a');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (663809073, 'Mr. Jamir Farrell DVM', 'karlee29', '5ee506259540a0e30e0bc8a5cd86e0187203d41b');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (700163831, 'Dr. Eduardo Effertz', 'krowe', '58f489f0aee5a9b315a0977c1a3c2d5cdfd5aec2');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (723597373, 'Prof. Nakia Eichmann Sr.', 'wisozk.cindy', 'a167994060956d7b2db5e0b113e24c118d30a2b1');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (761275427, 'Elisa Kutch', 'kianna78', '42820e1f0e4021b395d63135fc301d37d791996b');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (800581622, 'Dr. Rory Kunze', 'mohammed.vandervort', '634ff35aa667bf944d0f3e1f569b22924a32d65b');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (801585088, 'Troy Franecki', 'abatz', '2b167427a1b5ce89f71b2aed7a94e4a0ee0daf8f');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (810922874, 'Josie Dicki', 'uriah.hessel', '1f0aa5883aa56eb8984971a96e65b0f2483de8a2');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (853955349, 'Prof. Amparo Abernathy', 'pagac.gerson', '6016f158543b16fef46dfa83ef877ca96c7834d1');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (872454713, 'Cordia Hilll', 'o\'kon.floy', '7c9fdfebf42f758484a9d2e1861653e633a43e52');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (885872578, 'Jack Zieme IV', 'nhansen', 'bf7760d1ffe532a347194fab0f16b49fc43045c4');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (905816104, 'Zion Terry', 'akessler', 'fde5f90e9a66cf07c63319b951da333fe793ba8a');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (915380748, 'Prof. Ray Schamberger', 'rogahn.candido', '681d342fc88c544071420d4ec6ac7a9e3ca7d6d7');
INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`) VALUES (979323971, 'Dorian Wuckert', 'roberts.loma', 'ff33ccc45140f1210dd3168e58946f3fe90e16aa');

INSERT INTO `vendor` (`vendor_id`, `name`) VALUES (489103, 'Pauline Wisoky');
INSERT INTO `vendor` (`vendor_id`, `name`) VALUES (4209344, 'Prof. Rachael Sauer');
INSERT INTO `vendor` (`vendor_id`, `name`) VALUES (8933662, 'Barry Russel');
INSERT INTO `vendor` (`vendor_id`, `name`) VALUES (10133460, 'Ayden Mohr MD');
INSERT INTO `vendor` (`vendor_id`, `name`) VALUES (14971450, 'Lonnie Gislason');
INSERT INTO `vendor` (`vendor_id`, `name`) VALUES (18287437, 'Lazaro Veum PhD');
INSERT INTO `vendor` (`vendor_id`, `name`) VALUES (18464804, 'Sabryna Hills');
INSERT INTO `vendor` (`vendor_id`, `name`) VALUES (19459904, 'Delores Feest');
INSERT INTO `vendor` (`vendor_id`, `name`) VALUES (25931796, 'Kaleigh Jast');
INSERT INTO `vendor` (`vendor_id`, `name`) VALUES (28419463, 'Prof. Julian Schiller I');
INSERT INTO `vendor` (`vendor_id`, `name`) VALUES (29941791, 'Hobart Kulas V');
INSERT INTO `vendor` (`vendor_id`, `name`) VALUES (32225375, 'Dr. Jacinto O\'Hara');
INSERT INTO `vendor` (`vendor_id`, `name`) VALUES (35332905, 'Lelah O\'Connell');
INSERT INTO `vendor` (`vendor_id`, `name`) VALUES (38636502, 'Salvatore Kris');
INSERT INTO `vendor` (`vendor_id`, `name`) VALUES (39838868, 'Vickie Gorczany');
INSERT INTO `vendor` (`vendor_id`, `name`) VALUES (41336071, 'Joe Leannon');
INSERT INTO `vendor` (`vendor_id`, `name`) VALUES (42079582, 'Camden Ankunding I');
INSERT INTO `vendor` (`vendor_id`, `name`) VALUES (43719351, 'Mr. Conor Herman Jr.');
INSERT INTO `vendor` (`vendor_id`, `name`) VALUES (47314679, 'Eusebio Ernser');
INSERT INTO `vendor` (`vendor_id`, `name`) VALUES (47348493, 'Prof. Johnpaul Legros');
INSERT INTO `vendor` (`vendor_id`, `name`) VALUES (51435922, 'Francisco Fritsch III');
INSERT INTO `vendor` (`vendor_id`, `name`) VALUES (55520340, 'Zane Lemke');
INSERT INTO `vendor` (`vendor_id`, `name`) VALUES (56579516, 'Reid Lang');
INSERT INTO `vendor` (`vendor_id`, `name`) VALUES (57160271, 'Prof. Heaven Metz IV');
INSERT INTO `vendor` (`vendor_id`, `name`) VALUES (59018930, 'Prof. Paxton Dibbert PhD');
INSERT INTO `vendor` (`vendor_id`, `name`) VALUES (65071437, 'Kayley Reinger');
INSERT INTO `vendor` (`vendor_id`, `name`) VALUES (68731780, 'Dr. Reva Eichmann');
INSERT INTO `vendor` (`vendor_id`, `name`) VALUES (70828753, 'Candace Lehner');
INSERT INTO `vendor` (`vendor_id`, `name`) VALUES (73840886, 'Haleigh Howell');
INSERT INTO `vendor` (`vendor_id`, `name`) VALUES (74006596, 'Prof. Fernando Krajcik');
INSERT INTO `vendor` (`vendor_id`, `name`) VALUES (74031368, 'Cordelia Kassulke Sr.');
INSERT INTO `vendor` (`vendor_id`, `name`) VALUES (76285165, 'Waldo Bartoletti');
INSERT INTO `vendor` (`vendor_id`, `name`) VALUES (81623550, 'Herman Erdman');
INSERT INTO `vendor` (`vendor_id`, `name`) VALUES (81811191, 'Mr. Oren Kiehn Sr.');
INSERT INTO `vendor` (`vendor_id`, `name`) VALUES (82514640, 'Jaden Schimmel');
INSERT INTO `vendor` (`vendor_id`, `name`) VALUES (87791972, 'Prof. Guy Gorczany');
INSERT INTO `vendor` (`vendor_id`, `name`) VALUES (88460780, 'Daniella Rutherford');
INSERT INTO `vendor` (`vendor_id`, `name`) VALUES (91913467, 'Yesenia Zemlak');
INSERT INTO `vendor` (`vendor_id`, `name`) VALUES (93906938, 'Mariam O\'Conner');
INSERT INTO `vendor` (`vendor_id`, `name`) VALUES (98892187, 'Dayne Upton');

INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2015, 'November', 25, 46875, 490165113);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2020, 'May', 41, 597250, 628599613);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2015, 'September', 9, 6251525, 204193118);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2018, 'February', 2, 7585520, 427764181);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2019, 'January', 26, 10254207, 628599613);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2019, 'December', 15, 12908067, 416252481);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2016, 'April', 51, 15480994, 307171625);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2018, 'March', 23, 15994684, 307171625);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2017, 'July', 11, 23901158, 545980730);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2016, 'November', 2, 25890246, 853955349);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2020, 'July', 24, 26720828, 416252481);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2015, 'August', 37, 27632355, 700163831);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2017, 'April', 40, 28920714, 700163831);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2019, 'January', 8, 36359292, 434898684);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2018, 'February', 12, 39342329, 168045844);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2015, 'June', 39, 51454921, 872454713);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2017, 'October', 41, 58826056, 490165113);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2017, 'April', 10, 81701941, 292762451);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2018, 'February', 35, 83925858, 384969951);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2021, 'February', 32, 88331155, 490165113);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2015, 'August', 24, 92633616, 191934165);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2020, 'May', 18, 93702423, 810922874);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2020, 'February', 20, 96682415, 641948846);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2015, 'August', 47, 98749946, 663809073);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2019, 'September', 13, 100435676, 663809073);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2017, 'December', 12, 107734592, 87201097);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2015, 'February', 14, 126406281, 205409415);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2020, 'August', 40, 130332644, 191934165);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2018, 'October', 20, 130920141, 504499850);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2021, 'June', 9, 134875818, 187488933);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2016, 'August', 47, 136312874, 280737845);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2020, 'September', 3, 148055779, 292762451);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2020, 'August', 3, 148589133, 609718022);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2016, 'December', 53, 149070934, 545980730);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2016, 'September', 6, 156032250, 853955349);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2016, 'April', 17, 156920186, 358868118);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2017, 'December', 12, 157266943, 700163831);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2017, 'April', 41, 163561422, 579790811);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2021, 'February', 14, 166305058, 473559949);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2020, 'February', 3, 168672597, 205409415);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2017, 'April', 46, 184003386, 700163831);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2016, 'May', 48, 187383016, 577418564);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2018, 'February', 52, 203814185, 723597373);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2017, 'December', 11, 208873753, 723597373);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2015, 'May', 11, 222065856, 205409415);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2021, 'May', 7, 224271224, 292762451);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2015, 'February', 17, 242960973, 579790811);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2021, 'November', 16, 246063880, 168045844);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2020, 'January', 16, 249361244, 187488933);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2020, 'January', 14, 249932031, 358868118);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2021, 'July', 42, 253231522, 853955349);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2016, 'November', 49, 263635088, 87201097);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2018, 'November', 24, 267238984, 761275427);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2018, 'January', 49, 272584214, 723597373);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2021, 'January', 1, 274015344, 800581622);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2015, 'March', 49, 274108007, 872454713);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2020, 'June', 22, 280949433, 416682441);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2021, 'June', 17, 281363835, 885872578);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2016, 'July', 35, 295813647, 905816104);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2021, 'May', 11, 298366709, 384969951);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2016, 'April', 23, 298850673, 204193118);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2019, 'August', 45, 312493264, 800581622);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2018, 'October', 44, 313310320, 609718022);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2015, 'April', 6, 315382124, 307171625);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2015, 'June', 1, 315448681, 628599613);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2021, 'February', 3, 332154463, 416682441);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2021, 'December', 14, 343611166, 577418564);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2018, 'May', 37, 351359930, 979323971);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2020, 'April', 9, 351679679, 567776519);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2021, 'February', 34, 356051395, 391733781);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2016, 'June', 27, 356836108, 801585088);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2021, 'July', 23, 358308181, 307171625);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2020, 'May', 6, 358990202, 205409415);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2018, 'July', 27, 361485584, 810922874);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2020, 'August', 23, 369369041, 905816104);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2020, 'April', 36, 376104257, 579790811);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2016, 'July', 53, 389183905, 545980730);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2016, 'July', 44, 390191636, 391733781);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2018, 'October', 37, 398528108, 168045844);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2019, 'March', 15, 411713330, 391733781);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2021, 'October', 28, 414269919, 761275427);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2020, 'February', 28, 414449959, 87201097);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2015, 'November', 17, 424830012, 129226034);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2016, 'June', 38, 425440362, 187488933);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2020, 'January', 14, 429084300, 416682441);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2020, 'January', 45, 429306390, 168045844);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2019, 'October', 23, 430740422, 609718022);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2021, 'February', 47, 440551543, 434898684);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2016, 'February', 31, 447639374, 504499850);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2017, 'May', 47, 466838775, 641948846);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2021, 'December', 50, 472978859, 905816104);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2016, 'July', 27, 475156688, 545980730);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2021, 'June', 36, 477343248, 885872578);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2020, 'March', 34, 480794979, 723597373);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2017, 'January', 18, 491646602, 475456428);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2017, 'October', 28, 492614322, 473559949);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2021, 'April', 48, 507866661, 761275427);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2020, 'January', 31, 514800179, 129226034);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2020, 'February', 51, 522693998, 635518932);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2018, 'August', 23, 525985311, 635518932);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2017, 'June', 12, 529453969, 475456428);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2017, 'December', 3, 539206321, 427764181);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2016, 'June', 36, 541381834, 427764181);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2015, 'September', 40, 545896450, 579790811);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2018, 'May', 16, 551383852, 416252481);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2018, 'March', 30, 554393350, 504499850);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2017, 'April', 7, 567789307, 513849348);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2018, 'June', 3, 569544094, 577418564);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2019, 'August', 39, 571470361, 472674614);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2021, 'September', 48, 571571770, 17710494);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2016, 'August', 25, 575508481, 801585088);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2015, 'July', 3, 577321496, 87201097);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2018, 'August', 27, 587347482, 915380748);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2019, 'November', 27, 589075752, 253627527);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2021, 'September', 15, 591903948, 406134106);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2018, 'June', 21, 592534581, 128163133);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2016, 'January', 51, 592833245, 384969951);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2019, 'May', 7, 599756385, 280737845);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2016, 'April', 32, 603563032, 204193118);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2021, 'October', 29, 608628481, 641948846);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2015, 'April', 34, 618420549, 128163133);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2015, 'April', 3, 626453411, 491080454);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2017, 'September', 42, 627473205, 800581622);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2015, 'November', 51, 630732119, 491080454);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2018, 'October', 49, 642603236, 472674614);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2015, 'March', 26, 648660354, 253627527);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2017, 'April', 39, 649397867, 491080454);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2019, 'November', 50, 654212632, 253627527);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2020, 'June', 45, 656311322, 915380748);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2021, 'December', 5, 660399008, 406134106);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2020, 'January', 42, 665256477, 191934165);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2015, 'December', 16, 667892155, 434898684);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2020, 'September', 5, 678759368, 915380748);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2016, 'February', 38, 686840441, 810922874);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2017, 'February', 14, 696678812, 872454713);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2019, 'March', 16, 699367467, 490165113);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2019, 'April', 7, 700262429, 609718022);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2021, 'October', 31, 713863219, 979323971);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2021, 'February', 11, 723728220, 885872578);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2019, 'June', 43, 728747560, 628599613);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2021, 'August', 23, 731539422, 496179528);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2017, 'October', 35, 732594209, 513849348);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2015, 'October', 21, 735319202, 475456428);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2016, 'October', 37, 738871587, 17710494);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2015, 'December', 35, 742012229, 253627527);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2017, 'April', 33, 745766946, 472674614);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2021, 'March', 2, 751285366, 915380748);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2016, 'March', 19, 754322727, 663809073);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2020, 'November', 5, 755813755, 280737845);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2015, 'November', 18, 761969227, 801585088);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2017, 'May', 20, 772078987, 635518932);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2016, 'May', 53, 780933591, 800581622);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2019, 'June', 49, 786951177, 406134106);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2016, 'November', 16, 787475816, 885872578);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2016, 'June', 25, 792483101, 663809073);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2017, 'October', 44, 798118011, 872454713);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2017, 'July', 45, 798402148, 635518932);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2021, 'June', 45, 798491643, 641948846);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2019, 'April', 36, 798639586, 416682441);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2015, 'May', 2, 805173042, 567776519);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2018, 'April', 40, 813535312, 473559949);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2019, 'September', 18, 816265574, 567776519);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2017, 'April', 27, 819100439, 979323971);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2015, 'August', 38, 819554701, 384969951);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2021, 'April', 18, 823496158, 472674614);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2018, 'October', 52, 824482797, 496179528);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2019, 'January', 23, 825856784, 513849348);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2019, 'February', 39, 829008706, 905816104);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2015, 'March', 2, 831889249, 129226034);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2017, 'January', 43, 849966370, 567776519);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2021, 'August', 23, 850027985, 129226034);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2017, 'July', 50, 855200768, 187488933);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2021, 'June', 19, 866724273, 406134106);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2019, 'September', 45, 871062464, 416252481);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2021, 'September', 47, 873628585, 577418564);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2019, 'April', 34, 873682803, 496179528);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2020, 'August', 37, 879277362, 358868118);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2021, 'October', 43, 879395004, 128163133);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2015, 'October', 51, 881974122, 427764181);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2016, 'April', 13, 887252513, 473559949);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2020, 'December', 19, 887533522, 292762451);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2021, 'November', 48, 893176886, 280737845);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2016, 'January', 24, 894984368, 496179528);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2017, 'July', 19, 896372097, 17710494);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2017, 'February', 35, 904935349, 475456428);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2020, 'January', 39, 911282891, 801585088);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2019, 'January', 15, 911647886, 513849348);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2015, 'February', 22, 913216585, 761275427);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2018, 'January', 30, 923029839, 128163133);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2015, 'August', 49, 924341556, 979323971);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2021, 'December', 5, 925160919, 358868118);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2015, 'December', 27, 932939409, 434898684);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2019, 'October', 48, 933170158, 491080454);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2018, 'April', 30, 936500186, 853955349);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2017, 'June', 25, 944528888, 810922874);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2021, 'December', 32, 947491661, 204193118);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2021, 'June', 46, 950950849, 391733781);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2021, 'April', 38, 977487872, 191934165);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2019, 'June', 20, 993548873, 504499850);
INSERT INTO `order_` (`year`, `month`, `week`, `order_id`, `customer_id`) VALUES (2016, 'July', 3, 995975061, 17710494);

INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('0035806606194', 'Murray LLC', 'and Sons', 'Triple-buffered high-level analyzer');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('0063834193072', 'Russel-Kessler', 'Group', 'Multi-channelled zeroadministration util');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('0408293241177', 'Ziemann and Sons', 'Ltd', 'Extended optimal portal');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('0466391660320', 'Green Inc', 'Ltd', 'Synergistic nextgeneration forecast');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('0621911607838', 'Olson and Sons', 'Group', 'Grass-roots maximized strategy');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('0681663848484', 'Schumm LLC', 'LLC', 'Secured high-level monitoring');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('0783263548662', 'Fahey-Treutel', 'and Sons', 'Upgradable grid-enabled task-force');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('0796993154034', 'Gaylord, Tremblay and Hills', 'PLC', 'Down-sized explicit productivity');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('0803319641694', 'Goyette-Johnston', 'PLC', 'Organic optimal conglomeration');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('0810419392326', 'Kutch and Sons', 'PLC', 'Exclusive dedicated intranet');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('0821775646213', 'Carter PLC', 'and Sons', 'Distributed interactive interface');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('1264555157032', 'Schmeler, Kovacek and Conn', 'Group', 'Inverse multi-state toolset');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('1347144525655', 'Block-Langworth', 'Group', 'Enterprise-wide human-resource infrastru');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('1423030454022', 'Witting, Walker and Kessler', 'Ltd', 'Expanded even-keeled knowledgeuser');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('1507798943247', 'Sauer, Heaney and Roob', 'and Sons', 'Synergistic radical implementation');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('1602647701617', 'Kiehn, Mohr and Gutmann', 'and Sons', 'Managed methodical instructionset');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('2098000499984', 'Koelpin PLC', 'LLC', 'Organic transitional moderator');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('2214999621179', 'Schmeler PLC', 'and Sons', 'Reduced zerotolerance alliance');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('2253089902194', 'Lueilwitz PLC', 'Inc', 'Implemented modular flexibility');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('2334815592039', 'Pouros, Bernier and Lueilwitz', 'Inc', 'Multi-channelled zeroadministration hier');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('2514350269850', 'Green, Wunsch and Lueilwitz', 'PLC', 'Organized high-level localareanetwork');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('2652816879288', 'Doyle, Wehner and Olson', 'Inc', 'Function-based local openarchitecture');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('2704937306348', 'Lueilwitz, Ruecker and Leannon', 'Group', 'Seamless full-range forecast');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('3048780214405', 'McDermott-Pfannerstill', 'Group', 'Multi-lateral composite throughput');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('3403392318017', 'Hegmann-Conn', 'LLC', 'Multi-tiered exuding focusgroup');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('3458477346836', 'Koch-Rippin', 'Ltd', 'Distributed grid-enabled localareanetwor');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('3516213175765', 'Wintheiser, Rau and Jacobi', 'Group', 'Multi-channelled zerodefect framework');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('3549928630472', 'Ryan LLC', 'and Sons', 'Enhanced 3rdgeneration service-desk');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('3591999026586', 'Swift and Sons', 'Inc', 'Horizontal incremental framework');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('4309852705610', 'Parker and Sons', 'and Sons', 'Triple-buffered 24hour core');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('4509759477539', 'McClure, Anderson and Parker', 'Inc', 'Organized composite contingency');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('4602736841948', 'Johns PLC', 'and Sons', 'Assimilated incremental toolset');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('4634634001513', 'Bernhard-Hane', 'LLC', 'Front-line eco-centric parallelism');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('4750010800935', 'Reichert LLC', 'and Sons', 'Decentralized radical info-mediaries');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('4914532984416', 'Howe, Wolf and King', 'Group', 'Horizontal global GraphicalUserInterface');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('4955346930190', 'Schmitt, Balistreri and Murazik', 'LLC', 'Mandatory dedicated structure');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('5503930120336', 'Barrows, Ernser and Berge', 'Inc', 'Sharable object-oriented flexibility');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('5668902380238', 'Hodkiewicz-Spinka', 'Inc', 'Sharable solution-oriented knowledgeuser');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('5754225189822', 'Hermann Inc', 'Group', 'Distributed bottom-line database');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('6186729089398', 'Swift Ltd', 'Ltd', 'Triple-buffered stable paradigm');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('6251518655549', 'Bogan and Sons', 'LLC', 'Reverse-engineered optimal strategy');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('6383439406327', 'Metz, McDermott and Grady', 'PLC', 'Programmable static throughput');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('6601017833816', 'Schumm-Shanahan', 'Ltd', 'Adaptive multimedia frame');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('6695441528172', 'Gleason and Sons', 'LLC', 'Synergized upward-trending hierarchy');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('6710753296745', 'Sanford-Metz', 'Ltd', 'Triple-buffered leadingedge GraphicalUse');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('6830754971844', 'Eichmann Ltd', 'Inc', 'Compatible maximized circuit');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('6936974380197', 'Johnson PLC', 'PLC', 'Proactive reciprocal moderator');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('7135167940203', 'Schmeler, McDermott and Collier', 'and Sons', 'Programmable uniform support');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('7290310341334', 'Olson, Zulauf and Breitenberg', 'Inc', 'Digitized static migration');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('7313688965268', 'Gislason, Thiel and Bradtke', 'Ltd', 'Multi-tiered object-oriented database');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('7380775890765', 'Lind-Heidenreich', 'Inc', 'Synergized maximized knowledgeuser');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('7704054370050', 'Ziemann-Fritsch', 'Inc', 'Implemented executive leverage');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('7858651552941', 'Nolan Ltd', 'Inc', 'Reactive zeroadministration collaboratio');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('8140718371732', 'Quigley, Toy and Wehner', 'Inc', 'Pre-emptive motivating structure');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('8207032721176', 'Prosacco-Cole', 'Group', 'Cloned system-worthy monitoring');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('8336419746737', 'Nolan-Feest', 'Group', 'Multi-layered didactic matrix');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('8519119552659', 'Friesen LLC', 'LLC', 'De-engineered mobile contingency');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('8707158165897', 'Stanton-Harris', 'Group', 'Phased methodical moratorium');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('8752689764453', 'Graham-Cartwright', 'PLC', 'Expanded hybrid approach');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('8880235979829', 'Harris LLC', 'and Sons', 'Centralized assymetric support');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('9081209267990', 'Ankunding LLC', 'Inc', 'Enterprise-wide demand-driven neural-net');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('9133323161262', 'Runte, Jaskolski and Carroll', 'and Sons', 'Implemented reciprocal migration');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('9217578338027', 'Glover-Greenfelder', 'Group', 'Future-proofed system-worthy portal');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('9233915964636', 'Nader and Sons', 'LLC', 'Team-oriented multi-tasking website');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('9343034703525', 'Ryan PLC', 'Inc', 'Reverse-engineered solution-oriented gro');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('9347961640861', 'Schulist, Ortiz and Wiegand', 'LLC', 'Synergized discrete core');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('9569730145630', 'Mueller-Ernser', 'Ltd', 'Self-enabling 3rdgeneration openarchitec');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('9917692218853', 'Hessel Ltd', 'and Sons', 'Focused clear-thinking workforce');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('9939960960264', 'Kulas-Yost', 'PLC', 'Business-focused bottom-line throughput');
INSERT INTO `product` (`upc`, `name`, `product_type`, `brand`) VALUES ('9945284976812', 'Medhurst, Becker and Altenwerth', 'and Sons', 'Progressive methodical functionalities');

INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('0035806606194', 46875, 30, 'h');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('0035806606194', 356836108, 28, 'a');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('0035806606194', 731539422, 24, 'k');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('0063834193072', 597250, 18, 's');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('0063834193072', 358308181, 6, 'e');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('0063834193072', 732594209, 8, 'u');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('0408293241177', 6251525, 21, 'v');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('0408293241177', 358990202, 20, 'p');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('0408293241177', 735319202, 26, 'g');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('0466391660320', 7585520, 7, 'f');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('0466391660320', 361485584, 10, 'q');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('0466391660320', 738871587, 21, 'g');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('0621911607838', 10254207, 29, 'd');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('0621911607838', 369369041, 23, 'o');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('0621911607838', 742012229, 22, 'z');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('0681663848484', 12908067, 18, 'j');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('0681663848484', 376104257, 27, 'y');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('0681663848484', 745766946, 4, 'z');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('0783263548662', 15480994, 18, 'z');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('0783263548662', 389183905, 20, 'b');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('0783263548662', 751285366, 15, 'v');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('0796993154034', 15994684, 5, 'i');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('0796993154034', 390191636, 8, 'g');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('0796993154034', 754322727, 2, 'u');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('0803319641694', 23901158, 14, 'm');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('0803319641694', 398528108, 29, 'b');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('0803319641694', 755813755, 3, 'p');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('0810419392326', 25890246, 21, 'v');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('0810419392326', 411713330, 4, 'h');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('0810419392326', 761969227, 18, 'g');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('0821775646213', 26720828, 22, 'b');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('0821775646213', 414269919, 20, 'n');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('0821775646213', 772078987, 23, 'b');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('1264555157032', 27632355, 14, 'z');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('1264555157032', 414449959, 6, 'w');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('1264555157032', 780933591, 29, 'g');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('1347144525655', 28920714, 15, 'l');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('1347144525655', 424830012, 26, 'b');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('1347144525655', 786951177, 28, 'n');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('1423030454022', 36359292, 25, 'u');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('1423030454022', 425440362, 22, 't');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('1423030454022', 787475816, 4, 'z');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('1507798943247', 39342329, 27, 'd');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('1507798943247', 429084300, 4, 'e');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('1507798943247', 792483101, 2, 'i');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('1602647701617', 51454921, 1, 'q');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('1602647701617', 429306390, 20, 'z');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('1602647701617', 798118011, 29, 'a');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('2098000499984', 58826056, 11, 'o');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('2098000499984', 430740422, 5, 'a');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('2098000499984', 798402148, 22, 'n');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('2214999621179', 81701941, 29, 'd');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('2214999621179', 440551543, 15, 'c');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('2214999621179', 798491643, 20, 'l');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('2253089902194', 83925858, 28, 'd');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('2253089902194', 447639374, 26, 'd');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('2253089902194', 798639586, 17, 'c');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('2334815592039', 88331155, 13, 'v');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('2334815592039', 466838775, 4, 'g');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('2334815592039', 805173042, 14, 'q');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('2514350269850', 92633616, 11, 'n');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('2514350269850', 472978859, 6, 's');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('2514350269850', 813535312, 22, 'd');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('2652816879288', 93702423, 3, 'w');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('2652816879288', 475156688, 29, 'q');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('2652816879288', 816265574, 6, 'f');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('2704937306348', 96682415, 27, 'z');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('2704937306348', 477343248, 24, 'g');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('2704937306348', 819100439, 20, 'h');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('3048780214405', 98749946, 3, 'u');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('3048780214405', 480794979, 18, 's');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('3048780214405', 819554701, 4, 'h');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('3403392318017', 100435676, 9, 'f');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('3403392318017', 491646602, 30, 'a');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('3403392318017', 823496158, 19, 'u');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('3458477346836', 107734592, 11, 'g');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('3458477346836', 492614322, 9, 'p');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('3458477346836', 824482797, 29, 'q');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('3516213175765', 126406281, 1, 'h');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('3516213175765', 507866661, 27, 'q');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('3516213175765', 825856784, 11, 'j');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('3549928630472', 130332644, 20, 's');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('3549928630472', 514800179, 18, 'm');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('3549928630472', 829008706, 11, 's');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('3591999026586', 130920141, 12, 'r');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('3591999026586', 522693998, 19, 'q');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('3591999026586', 831889249, 25, 'q');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('4309852705610', 134875818, 3, 'j');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('4309852705610', 525985311, 19, 'j');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('4309852705610', 849966370, 16, 'n');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('4509759477539', 136312874, 6, 'i');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('4509759477539', 529453969, 10, 'j');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('4509759477539', 850027985, 19, 'z');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('4602736841948', 148055779, 1, 'o');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('4602736841948', 539206321, 10, 'q');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('4602736841948', 855200768, 9, 'u');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('4634634001513', 148589133, 29, 'h');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('4634634001513', 541381834, 18, 'y');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('4634634001513', 866724273, 23, 'f');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('4750010800935', 149070934, 2, 'u');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('4750010800935', 545896450, 14, 'x');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('4750010800935', 871062464, 21, 'z');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('4914532984416', 156032250, 10, 'r');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('4914532984416', 551383852, 3, 'u');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('4914532984416', 873628585, 26, 'p');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('4955346930190', 156920186, 28, 's');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('4955346930190', 554393350, 3, 'x');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('4955346930190', 873682803, 19, 'a');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('5503930120336', 157266943, 6, 'p');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('5503930120336', 567789307, 10, 'q');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('5503930120336', 879277362, 8, 'j');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('5668902380238', 163561422, 3, 'n');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('5668902380238', 569544094, 17, 'f');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('5668902380238', 879395004, 3, 'w');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('5754225189822', 166305058, 1, 'p');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('5754225189822', 571470361, 2, 'y');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('5754225189822', 881974122, 12, 'b');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('6186729089398', 168672597, 6, 'i');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('6186729089398', 571571770, 27, 'n');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('6186729089398', 887252513, 19, 'a');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('6251518655549', 184003386, 23, 'c');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('6251518655549', 575508481, 18, 's');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('6251518655549', 887533522, 6, 'w');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('6383439406327', 187383016, 14, 'i');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('6383439406327', 577321496, 13, 'a');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('6383439406327', 893176886, 16, 't');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('6601017833816', 203814185, 2, 'r');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('6601017833816', 587347482, 11, 'l');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('6601017833816', 894984368, 6, 'b');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('6695441528172', 208873753, 6, 'f');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('6695441528172', 589075752, 5, 'h');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('6695441528172', 896372097, 28, 'j');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('6710753296745', 222065856, 2, 'l');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('6710753296745', 591903948, 12, 'c');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('6710753296745', 904935349, 8, 'h');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('6830754971844', 224271224, 14, 'v');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('6830754971844', 592534581, 15, 'w');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('6830754971844', 911282891, 25, 'r');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('6936974380197', 242960973, 28, 'c');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('6936974380197', 592833245, 24, 'b');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('6936974380197', 911647886, 9, 'a');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('7135167940203', 246063880, 16, 'g');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('7135167940203', 599756385, 27, 'a');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('7135167940203', 913216585, 13, 'h');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('7290310341334', 249361244, 8, 'z');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('7290310341334', 603563032, 7, 'u');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('7290310341334', 923029839, 5, 'p');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('7313688965268', 249932031, 17, 'q');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('7313688965268', 608628481, 3, 't');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('7313688965268', 924341556, 4, 'i');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('7380775890765', 253231522, 13, 'f');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('7380775890765', 618420549, 28, 'y');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('7380775890765', 925160919, 4, 'x');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('7704054370050', 263635088, 25, 'x');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('7704054370050', 626453411, 21, 'c');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('7704054370050', 932939409, 5, 'p');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('7858651552941', 267238984, 17, 'd');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('7858651552941', 627473205, 17, 'i');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('7858651552941', 933170158, 25, 'e');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('8140718371732', 272584214, 12, 'o');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('8140718371732', 630732119, 5, 'e');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('8140718371732', 936500186, 15, 'i');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('8207032721176', 274015344, 7, 'u');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('8207032721176', 642603236, 29, 'x');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('8207032721176', 944528888, 19, 'w');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('8336419746737', 274108007, 27, 'i');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('8336419746737', 648660354, 29, 'r');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('8336419746737', 947491661, 22, 'i');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('8519119552659', 280949433, 8, 'w');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('8519119552659', 649397867, 28, 'b');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('8519119552659', 950950849, 15, 'w');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('8707158165897', 281363835, 16, 'q');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('8707158165897', 654212632, 11, 'i');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('8707158165897', 977487872, 6, 't');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('8752689764453', 295813647, 22, 'l');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('8752689764453', 656311322, 19, 'x');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('8752689764453', 993548873, 7, 'w');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('8880235979829', 298366709, 17, 'q');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('8880235979829', 660399008, 9, 'y');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('8880235979829', 995975061, 15, 'e');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('9081209267990', 298850673, 23, 'c');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('9081209267990', 665256477, 7, 'a');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('9133323161262', 312493264, 12, 'i');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('9133323161262', 667892155, 11, 'u');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('9217578338027', 313310320, 27, 'c');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('9217578338027', 678759368, 8, 'g');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('9233915964636', 315382124, 4, 'v');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('9233915964636', 686840441, 18, 'n');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('9343034703525', 315448681, 23, 'c');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('9343034703525', 696678812, 15, 'c');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('9347961640861', 332154463, 5, 'c');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('9347961640861', 699367467, 28, 'b');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('9569730145630', 343611166, 22, 'q');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('9569730145630', 700262429, 2, 'x');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('9917692218853', 351359930, 21, 'w');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('9917692218853', 713863219, 3, 'i');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('9939960960264', 351679679, 2, 'j');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('9939960960264', 723728220, 6, 'd');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('9945284976812', 356051395, 18, 'r');
INSERT INTO `order_item` (`upc`, `order_id`, `amount_sold`, `currency`) VALUES ('9945284976812', 728747560, 16, 'i');

INSERT INTO `deals` (`deal_id`) VALUES (130611311);
INSERT INTO `deals` (`deal_id`) VALUES (139536279);
INSERT INTO `deals` (`deal_id`) VALUES (200114195);
INSERT INTO `deals` (`deal_id`) VALUES (322365556);
INSERT INTO `deals` (`deal_id`) VALUES (408286829);
INSERT INTO `deals` (`deal_id`) VALUES (463775762);
INSERT INTO `deals` (`deal_id`) VALUES (762340988);
INSERT INTO `deals` (`deal_id`) VALUES (786855263);
INSERT INTO `deals` (`deal_id`) VALUES (877592576);
INSERT INTO `deals` (`deal_id`) VALUES (997134500);

INSERT INTO `promotion` (`deal_id`, `upc`, `discount`) VALUES (130611311, '0035806606194', '18.00');
INSERT INTO `promotion` (`deal_id`, `upc`, `discount`) VALUES (130611311, '0821775646213', '9.00');
INSERT INTO `promotion` (`deal_id`, `upc`, `discount`) VALUES (139536279, '0063834193072', '26.00');
INSERT INTO `promotion` (`deal_id`, `upc`, `discount`) VALUES (139536279, '1264555157032', '22.00');
INSERT INTO `promotion` (`deal_id`, `upc`, `discount`) VALUES (200114195, '0408293241177', '26.00');
INSERT INTO `promotion` (`deal_id`, `upc`, `discount`) VALUES (200114195, '1347144525655', '25.00');
INSERT INTO `promotion` (`deal_id`, `upc`, `discount`) VALUES (322365556, '0466391660320', '26.00');
INSERT INTO `promotion` (`deal_id`, `upc`, `discount`) VALUES (322365556, '1423030454022', '17.00');
INSERT INTO `promotion` (`deal_id`, `upc`, `discount`) VALUES (408286829, '0621911607838', '14.00');
INSERT INTO `promotion` (`deal_id`, `upc`, `discount`) VALUES (408286829, '1507798943247', '11.00');
INSERT INTO `promotion` (`deal_id`, `upc`, `discount`) VALUES (463775762, '0681663848484', '20.00');
INSERT INTO `promotion` (`deal_id`, `upc`, `discount`) VALUES (463775762, '1602647701617', '19.00');
INSERT INTO `promotion` (`deal_id`, `upc`, `discount`) VALUES (762340988, '0783263548662', '14.00');
INSERT INTO `promotion` (`deal_id`, `upc`, `discount`) VALUES (762340988, '2098000499984', '27.00');
INSERT INTO `promotion` (`deal_id`, `upc`, `discount`) VALUES (786855263, '0796993154034', '10.00');
INSERT INTO `promotion` (`deal_id`, `upc`, `discount`) VALUES (786855263, '2214999621179', '29.00');
INSERT INTO `promotion` (`deal_id`, `upc`, `discount`) VALUES (877592576, '0803319641694', '12.00');
INSERT INTO `promotion` (`deal_id`, `upc`, `discount`) VALUES (877592576, '2253089902194', '9.00');
INSERT INTO `promotion` (`deal_id`, `upc`, `discount`) VALUES (997134500, '0810419392326', '12.00');
INSERT INTO `promotion` (`deal_id`, `upc`, `discount`) VALUES (997134500, '2334815592039', '7.00');


INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (5190000, '9569730145630', 521);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (5458414, '3048780214405', 678);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (6353602, '3549928630472', 893);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (19243010, '8880235979829', 182);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (20444577, '6383439406327', 280);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (25522265, '0466391660320', 766);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (27560840, '0063834193072', 693);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (44775020, '2514350269850', 687);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (48304780, '4509759477539', 844);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (51733775, '6936974380197', 782);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (59925007, '5503930120336', 549);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (60823227, '7380775890765', 448);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (69611448, '6186729089398', 551);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (85109669, '1347144525655', 286);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (85936893, '3403392318017', 296);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (91395553, '7380775890765', 458);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (100489664, '8707158165897', 516);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (106550479, '4955346930190', 338);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (107893470, '3048780214405', 823);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (109309730, '0035806606194', 544);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (116466294, '0466391660320', 732);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (128242700, '5754225189822', 95);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (134339492, '3516213175765', 587);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (134522165, '9939960960264', 15);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (143421630, '8140718371732', 362);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (144425971, '2334815592039', 937);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (152798855, '9939960960264', 213);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (156930394, '6830754971844', 915);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (159774437, '4914532984416', 526);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (165016646, '9081209267990', 458);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (170741365, '8336419746737', 546);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (177346054, '3458477346836', 679);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (178682374, '2514350269850', 927);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (183534111, '8207032721176', 76);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (184887694, '1264555157032', 0);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (185189083, '3591999026586', 192);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (185242872, '3403392318017', 125);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (194421291, '0783263548662', 555);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (198530904, '0783263548662', 994);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (203992134, '9347961640861', 578);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (208075280, '8140718371732', 802);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (212065078, '8752689764453', 865);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (215849200, '1602647701617', 461);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (216692795, '2253089902194', 547);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (225846046, '4750010800935', 88);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (228606967, '8207032721176', 103);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (240165848, '7704054370050', 563);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (243666195, '3591999026586', 294);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (243689255, '2652816879288', 602);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (246824070, '9343034703525', 890);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (252646098, '6383439406327', 373);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (255634078, '0803319641694', 206);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (262083620, '8752689764453', 128);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (266901629, '4914532984416', 415);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (285061346, '6186729089398', 676);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (287935696, '5668902380238', 159);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (289832702, '4509759477539', 903);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (290397888, '6830754971844', 536);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (299050078, '4634634001513', 880);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (309165795, '7313688965268', 68);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (319353387, '2334815592039', 878);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (325869581, '0681663848484', 946);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (326050289, '3403392318017', 851);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (326691403, '6695441528172', 85);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (338226091, '0796993154034', 92);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (338594194, '6695441528172', 233);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (346977470, '6710753296745', 820);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (355298521, '7135167940203', 121);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (357307388, '1264555157032', 59);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (361271999, '0621911607838', 309);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (373093444, '1347144525655', 395);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (373261301, '7704054370050', 700);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (373937066, '0821775646213', 515);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (378012832, '7313688965268', 719);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (378520984, '9217578338027', 97);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (380387818, '8519119552659', 796);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (381496613, '4602736841948', 774);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (382717298, '9133323161262', 386);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (389321288, '6830754971844', 639);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (392792582, '1423030454022', 5);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (400427808, '0821775646213', 217);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (402311555, '5503930120336', 803);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (403880558, '8880235979829', 879);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (423153987, '5754225189822', 81);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (433843049, '3048780214405', 581);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (436300003, '0803319641694', 809);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (436440058, '0681663848484', 313);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (440030174, '3516213175765', 284);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (441653949, '5668902380238', 93);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (447621320, '8880235979829', 919);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (449472689, '9945284976812', 350);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (449546695, '3591999026586', 997);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (452575074, '9233915964636', 900);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (459302462, '4309852705610', 447);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (460299973, '8707158165897', 936);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (471300660, '1602647701617', 156);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (477042763, '0796993154034', 802);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (486390415, '0621911607838', 238);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (487184915, '6601017833816', 675);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (505002418, '8336419746737', 236);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (508626875, '1423030454022', 880);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (510283127, '8752689764453', 881);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (512980893, '0035806606194', 418);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (513218858, '1423030454022', 947);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (514546927, '3458477346836', 222);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (515871823, '5668902380238', 473);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (520315114, '0063834193072', 966);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (521559320, '9081209267990', 462);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (529823612, '7135167940203', 73);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (533776471, '2253089902194', 290);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (550992234, '7704054370050', 13);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (555043391, '6251518655549', 462);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (563157979, '1507798943247', 912);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (565139277, '3516213175765', 837);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (576931988, '1507798943247', 217);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (594228218, '6251518655549', 25);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (619329118, '8519119552659', 986);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (629020451, '6695441528172', 217);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (631713181, '8336419746737', 369);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (636670727, '4602736841948', 879);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (638573398, '0796993154034', 406);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (641193014, '2214999621179', 551);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (649183928, '6251518655549', 144);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (650405797, '4914532984416', 865);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (653785351, '6601017833816', 955);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (660439502, '6936974380197', 430);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (664415819, '1507798943247', 157);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (674738825, '7290310341334', 589);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (675408308, '4955346930190', 629);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (680144553, '0783263548662', 81);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (681831392, '6710753296745', 394);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (685031507, '7858651552941', 187);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (686166855, '9569730145630', 31);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (686515810, '0803319641694', 522);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (689670954, '0063834193072', 106);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (703546305, '9917692218853', 864);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (713456890, '4509759477539', 891);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (714019144, '9347961640861', 392);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (725588200, '5503930120336', 601);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (726450684, '2652816879288', 762);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (727220365, '2514350269850', 400);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (732698979, '7858651552941', 589);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (736519052, '9945284976812', 489);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (738045796, '2704937306348', 189);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (739121690, '2704937306348', 477);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (742766324, '6186729089398', 683);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (742920072, '8140718371732', 863);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (760360051, '4309852705610', 256);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (761075503, '9917692218853', 638);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (761551038, '6710753296745', 774);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (761883760, '0408293241177', 61);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (765304319, '8207032721176', 604);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (773163306, '0408293241177', 958);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (780074115, '2334815592039', 147);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (781116808, '2253089902194', 935);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (794315191, '2098000499984', 901);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (797690947, '7313688965268', 767);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (800722183, '0810419392326', 849);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (801612721, '9217578338027', 0);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (803589325, '0408293241177', 824);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (819924855, '3458477346836', 444);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (821038281, '1264555157032', 559);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (826911600, '1347144525655', 343);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (828413449, '5754225189822', 661);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (829190171, '2214999621179', 809);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (830146007, '7290310341334', 44);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (837458189, '9133323161262', 573);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (853021559, '3549928630472', 144);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (853596849, '7290310341334', 249);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (860281524, '2214999621179', 546);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (866495827, '0810419392326', 130);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (866765258, '7858651552941', 724);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (870139633, '0810419392326', 664);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (871871867, '8707158165897', 241);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (875187019, '7135167940203', 937);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (877856578, '2098000499984', 786);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (878415252, '6601017833816', 18);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (882224868, '1602647701617', 597);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (885499320, '4955346930190', 871);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (886198235, '2704937306348', 172);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (887550107, '2098000499984', 420);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (893261439, '3549928630472', 700);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (894149348, '0681663848484', 790);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (900532641, '0035806606194', 196);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (911051767, '0821775646213', 4);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (912254257, '4634634001513', 133);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (912871929, '9233915964636', 303);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (917663842, '0466391660320', 254);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (925306701, '9343034703525', 174);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (931713828, '8519119552659', 565);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (936392396, '0621911607838', 342);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (944697745, '4309852705610', 252);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (946429622, '4750010800935', 925);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (946715489, '4602736841948', 711);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (950512390, '4634634001513', 660);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (956858063, '2652816879288', 685);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (964851514, '7380775890765', 108);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (978490786, '6936974380197', 639);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (989706696, '4750010800935', 647);
INSERT INTO `inventory` (`inventory_id`, `upc`, `product_count`) VALUES (995554149, '6383439406327', 105);

INSERT INTO `location` (`city`, `income_range`) VALUES ('East Louvenia', 226764);
INSERT INTO `location` (`city`, `income_range`) VALUES ('Greysonside', 612965);
INSERT INTO `location` (`city`, `income_range`) VALUES ('Josefinaville', 118768);
INSERT INTO `location` (`city`, `income_range`) VALUES ('New Jared', 861208);
INSERT INTO `location` (`city`, `income_range`) VALUES ('North Maya', 410547);
INSERT INTO `location` (`city`, `income_range`) VALUES ('Prosaccobury', 162485);
INSERT INTO `location` (`city`, `income_range`) VALUES ('Robertsburgh', 59398);
INSERT INTO `location` (`city`, `income_range`) VALUES ('Sedrickburgh', 419809);
INSERT INTO `location` (`city`, `income_range`) VALUES ('West Kallie', 936492);
INSERT INTO `location` (`city`, `income_range`) VALUES ('West Tyrell', 200720);

INSERT INTO `store` (`open_time`, `close_time`, `store_id`, `city`) VALUES ('05:44:51', '23:26:15', 67609902, 'West Tyrell');
INSERT INTO `store` (`open_time`, `close_time`, `store_id`, `city`) VALUES ('21:17:56', '03:37:08', 289009106, 'North Maya');
INSERT INTO `store` (`open_time`, `close_time`, `store_id`, `city`) VALUES ('22:50:53', '16:16:45', 323152775, 'Greysonside');
INSERT INTO `store` (`open_time`, `close_time`, `store_id`, `city`) VALUES ('20:49:27', '14:56:59', 350042626, 'Sedrickburgh');
INSERT INTO `store` (`open_time`, `close_time`, `store_id`, `city`) VALUES ('22:15:32', '20:22:57', 413877052, 'East Louvenia');
INSERT INTO `store` (`open_time`, `close_time`, `store_id`, `city`) VALUES ('03:48:37', '01:13:16', 454942058, 'Robertsburgh');
INSERT INTO `store` (`open_time`, `close_time`, `store_id`, `city`) VALUES ('21:34:19', '20:41:44', 622427387, 'Josefinaville');
INSERT INTO `store` (`open_time`, `close_time`, `store_id`, `city`) VALUES ('23:41:53', '21:38:59', 725443371, 'West Kallie');
INSERT INTO `store` (`open_time`, `close_time`, `store_id`, `city`) VALUES ('06:26:25', '13:47:25', 841957994, 'New Jared');
INSERT INTO `store` (`open_time`, `close_time`, `store_id`, `city`) VALUES ('19:40:31', '04:40:50', 919883165, 'Prosaccobury');

INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (67609902, 5190000, '0035806606194');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (67609902, 59925007, '0821775646213');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (67609902, 116466294, '2514350269850');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (67609902, 170741365, '4509759477539');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (67609902, 208075280, '6251518655549');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (67609902, 252646098, '7380775890765');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (67609902, 319353387, '9081209267990');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (67609902, 373093444, '0035806606194');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (67609902, 400427808, '0821775646213');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (67609902, 449472689, '2514350269850');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (67609902, 508626875, '4509759477539');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (67609902, 550992234, '6251518655549');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (67609902, 638573398, '7380775890765');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (67609902, 681831392, '9081209267990');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (67609902, 727220365, '0035806606194');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (67609902, 761883760, '0821775646213');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (67609902, 819924855, '2514350269850');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (67609902, 866495827, '4509759477539');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (67609902, 887550107, '6251518655549');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (67609902, 936392396, '7380775890765');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (289009106, 5458414, '0063834193072');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (289009106, 60823227, '1264555157032');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (289009106, 128242700, '2652816879288');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (289009106, 177346054, '4602736841948');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (289009106, 212065078, '6383439406327');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (289009106, 255634078, '7704054370050');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (289009106, 325869581, '9133323161262');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (289009106, 373261301, '0063834193072');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (289009106, 402311555, '1264555157032');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (289009106, 449546695, '2652816879288');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (289009106, 510283127, '4602736841948');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (289009106, 555043391, '6383439406327');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (289009106, 641193014, '7704054370050');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (289009106, 685031507, '9133323161262');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (289009106, 732698979, '0063834193072');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (289009106, 765304319, '1264555157032');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (289009106, 821038281, '2652816879288');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (289009106, 866765258, '4602736841948');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (289009106, 893261439, '6383439406327');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (289009106, 944697745, '7704054370050');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (323152775, 6353602, '0408293241177');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (323152775, 69611448, '1347144525655');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (323152775, 134339492, '2704937306348');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (323152775, 178682374, '4634634001513');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (323152775, 215849200, '6601017833816');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (323152775, 262083620, '7858651552941');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (323152775, 326050289, '9217578338027');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (323152775, 373937066, '0408293241177');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (323152775, 403880558, '1347144525655');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (323152775, 452575074, '2704937306348');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (323152775, 512980893, '4634634001513');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (323152775, 563157979, '6601017833816');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (323152775, 649183928, '7858651552941');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (323152775, 686166855, '9217578338027');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (323152775, 736519052, '0408293241177');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (323152775, 773163306, '1347144525655');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (323152775, 826911600, '2704937306348');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (323152775, 870139633, '4634634001513');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (323152775, 894149348, '6601017833816');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (323152775, 946429622, '7858651552941');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (350042626, 19243010, '0466391660320');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (350042626, 85109669, '1423030454022');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (350042626, 134522165, '3048780214405');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (350042626, 183534111, '4750010800935');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (350042626, 216692795, '6695441528172');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (350042626, 266901629, '8140718371732');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (350042626, 326691403, '9233915964636');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (350042626, 378012832, '0466391660320');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (350042626, 423153987, '1423030454022');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (350042626, 459302462, '3048780214405');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (350042626, 513218858, '4750010800935');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (350042626, 565139277, '6695441528172');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (350042626, 650405797, '8140718371732');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (350042626, 686515810, '9233915964636');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (350042626, 738045796, '0466391660320');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (350042626, 780074115, '1423030454022');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (350042626, 828413449, '3048780214405');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (350042626, 871871867, '4750010800935');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (350042626, 900532641, '6695441528172');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (350042626, 946715489, '8140718371732');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (413877052, 20444577, '0621911607838');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (413877052, 85936893, '1507798943247');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (413877052, 143421630, '3403392318017');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (413877052, 184887694, '4914532984416');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (413877052, 225846046, '6710753296745');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (413877052, 285061346, '8207032721176');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (413877052, 338226091, '9343034703525');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (413877052, 378520984, '0621911607838');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (413877052, 433843049, '1507798943247');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (413877052, 460299973, '3403392318017');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (413877052, 514546927, '4914532984416');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (413877052, 576931988, '6710753296745');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (413877052, 653785351, '8207032721176');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (413877052, 689670954, '9343034703525');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (413877052, 739121690, '0621911607838');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (413877052, 781116808, '1507798943247');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (413877052, 829190171, '3403392318017');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (413877052, 875187019, '4914532984416');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (413877052, 911051767, '6710753296745');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (413877052, 950512390, '8207032721176');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (454942058, 25522265, '0681663848484');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (454942058, 91395553, '1602647701617');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (454942058, 144425971, '3458477346836');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (454942058, 185189083, '4955346930190');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (454942058, 228606967, '6830754971844');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (454942058, 287935696, '8336419746737');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (454942058, 338594194, '9347961640861');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (454942058, 380387818, '0681663848484');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (454942058, 436300003, '1602647701617');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (454942058, 471300660, '3458477346836');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (454942058, 515871823, '4955346930190');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (454942058, 594228218, '6830754971844');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (454942058, 660439502, '8336419746737');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (454942058, 703546305, '9347961640861');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (454942058, 742766324, '0681663848484');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (454942058, 794315191, '1602647701617');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (454942058, 830146007, '3458477346836');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (454942058, 877856578, '4955346930190');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (454942058, 912254257, '6830754971844');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (454942058, 956858063, '8336419746737');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (622427387, 27560840, '0783263548662');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (622427387, 100489664, '2098000499984');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (622427387, 152798855, '3516213175765');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (622427387, 185242872, '5503930120336');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (622427387, 240165848, '6936974380197');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (622427387, 289832702, '8519119552659');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (622427387, 346977470, '9569730145630');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (622427387, 381496613, '0783263548662');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (622427387, 436440058, '2098000499984');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (622427387, 477042763, '3516213175765');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (622427387, 520315114, '5503930120336');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (622427387, 619329118, '6936974380197');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (622427387, 664415819, '8519119552659');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (622427387, 713456890, '9569730145630');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (622427387, 742920072, '0783263548662');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (622427387, 797690947, '2098000499984');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (622427387, 837458189, '3516213175765');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (622427387, 878415252, '5503930120336');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (622427387, 912871929, '6936974380197');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (622427387, 964851514, '8519119552659');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (725443371, 44775020, '0796993154034');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (725443371, 106550479, '2214999621179');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (725443371, 156930394, '3549928630472');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (725443371, 194421291, '5668902380238');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (725443371, 243666195, '7135167940203');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (725443371, 290397888, '8707158165897');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (725443371, 355298521, '9917692218853');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (725443371, 382717298, '0796993154034');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (725443371, 440030174, '2214999621179');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (725443371, 486390415, '3549928630472');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (725443371, 521559320, '5668902380238');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (725443371, 629020451, '7135167940203');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (725443371, 674738825, '8707158165897');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (725443371, 714019144, '9917692218853');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (725443371, 760360051, '0796993154034');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (725443371, 800722183, '2214999621179');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (725443371, 853021559, '3549928630472');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (725443371, 882224868, '5668902380238');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (725443371, 917663842, '7135167940203');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (725443371, 978490786, '8707158165897');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (841957994, 48304780, '0803319641694');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (841957994, 107893470, '2253089902194');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (841957994, 159774437, '3591999026586');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (841957994, 198530904, '5754225189822');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (841957994, 243689255, '7290310341334');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (841957994, 299050078, '8752689764453');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (841957994, 357307388, '9939960960264');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (841957994, 389321288, '0803319641694');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (841957994, 441653949, '2253089902194');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (841957994, 487184915, '3591999026586');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (841957994, 529823612, '5754225189822');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (841957994, 631713181, '7290310341334');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (841957994, 675408308, '8752689764453');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (841957994, 725588200, '9939960960264');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (841957994, 761075503, '0803319641694');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (841957994, 801612721, '2253089902194');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (841957994, 853596849, '3591999026586');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (841957994, 885499320, '5754225189822');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (841957994, 925306701, '7290310341334');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (841957994, 989706696, '8752689764453');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (919883165, 51733775, '0810419392326');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (919883165, 109309730, '2334815592039');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (919883165, 165016646, '4309852705610');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (919883165, 203992134, '6186729089398');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (919883165, 246824070, '7313688965268');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (919883165, 309165795, '8880235979829');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (919883165, 361271999, '9945284976812');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (919883165, 392792582, '0810419392326');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (919883165, 447621320, '2334815592039');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (919883165, 505002418, '4309852705610');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (919883165, 533776471, '6186729089398');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (919883165, 636670727, '7313688965268');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (919883165, 680144553, '8880235979829');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (919883165, 726450684, '9945284976812');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (919883165, 761551038, '0810419392326');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (919883165, 803589325, '2334815592039');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (919883165, 860281524, '4309852705610');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (919883165, 886198235, '6186729089398');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (919883165, 931713828, '7313688965268');
INSERT INTO `check_product` (`store_id`, `inventory_id`, `upc`) VALUES (919883165, 995554149, '8880235979829');

INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('0035806606194', 67609902, '4.00', 'b');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('0063834193072', 289009106, '11.00', 'e');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('0408293241177', 323152775, '10.00', 'e');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('0466391660320', 350042626, '5.00', 'o');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('0621911607838', 413877052, '13.00', 'a');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('0681663848484', 454942058, '6.00', 'f');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('0783263548662', 622427387, '2.00', 'a');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('0796993154034', 725443371, '2.00', 's');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('0803319641694', 841957994, '13.00', 'r');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('0810419392326', 919883165, '5.00', 'x');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('0821775646213', 67609902, '5.00', 'i');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('1264555157032', 289009106, '1.00', 'm');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('1347144525655', 323152775, '14.00', 'o');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('1423030454022', 350042626, '5.00', 'g');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('1507798943247', 413877052, '14.00', 'a');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('1602647701617', 454942058, '13.00', 'l');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('2098000499984', 622427387, '7.00', 'n');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('2214999621179', 725443371, '12.00', 'm');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('2253089902194', 841957994, '1.00', 'n');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('2334815592039', 919883165, '14.00', 'o');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('2514350269850', 67609902, '3.00', 'd');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('2652816879288', 289009106, '7.00', 'l');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('2704937306348', 323152775, '1.00', 'n');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('3048780214405', 350042626, '8.00', 'b');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('3403392318017', 413877052, '6.00', 'o');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('3458477346836', 454942058, '11.00', 'y');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('3516213175765', 622427387, '8.00', 'm');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('3549928630472', 725443371, '9.00', 'g');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('3591999026586', 841957994, '12.00', 'p');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('4309852705610', 919883165, '4.00', 'l');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('4509759477539', 67609902, '6.00', 'b');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('4602736841948', 289009106, '1.00', 'q');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('4634634001513', 323152775, '7.00', 'x');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('4750010800935', 350042626, '3.00', 'e');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('4914532984416', 413877052, '12.00', 't');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('4955346930190', 454942058, '3.00', 'u');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('5503930120336', 622427387, '7.00', 'e');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('5668902380238', 725443371, '2.00', 'x');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('5754225189822', 841957994, '6.00', 'q');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('6186729089398', 919883165, '10.00', 'r');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('6251518655549', 67609902, '12.00', 'b');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('6383439406327', 289009106, '15.00', 'z');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('6601017833816', 323152775, '13.00', 'w');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('6695441528172', 350042626, '5.00', 'w');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('6710753296745', 413877052, '8.00', 't');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('6830754971844', 454942058, '5.00', 'q');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('6936974380197', 622427387, '3.00', 'm');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('7135167940203', 725443371, '5.00', 'a');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('7290310341334', 841957994, '12.00', 'a');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('7313688965268', 919883165, '7.00', 'v');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('7380775890765', 67609902, '6.00', 'y');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('7704054370050', 289009106, '3.00', 'b');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('7858651552941', 323152775, '5.00', 'k');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('8140718371732', 350042626, '2.00', 'k');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('8207032721176', 413877052, '2.00', 'h');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('8336419746737', 454942058, '4.00', 'x');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('8519119552659', 622427387, '12.00', 'r');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('8707158165897', 725443371, '2.00', 'c');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('8752689764453', 841957994, '6.00', 'j');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('8880235979829', 919883165, '13.00', 'k');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('9081209267990', 67609902, '13.00', 'q');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('9133323161262', 289009106, '2.00', 's');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('9217578338027', 323152775, '14.00', 'd');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('9233915964636', 350042626, '11.00', 'j');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('9343034703525', 413877052, '6.00', 'd');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('9347961640861', 454942058, '9.00', 'r');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('9569730145630', 622427387, '7.00', 'z');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('9917692218853', 725443371, '15.00', 'k');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('9939960960264', 841957994, '6.00', 'y');
INSERT INTO `has_prod` (`upc`, `store_id`, `price`, `currency`) VALUES ('9945284976812', 919883165, '7.00', 'm');

INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (489103, 67609902, '0035806606194', 152);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (489103, 67609902, '0821775646213', 550);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (489103, 67609902, '2514350269850', 112);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (489103, 67609902, '6251518655549', 308);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (489103, 67609902, '7380775890765', 715);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (4209344, 289009106, '0063834193072', 428);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (4209344, 289009106, '1264555157032', 358);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (4209344, 289009106, '2652816879288', 277);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (4209344, 289009106, '6383439406327', 670);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (4209344, 289009106, '7704054370050', 367);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (8933662, 323152775, '0408293241177', 755);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (8933662, 323152775, '1347144525655', 499);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (8933662, 323152775, '2704937306348', 65);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (8933662, 323152775, '6601017833816', 156);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (8933662, 323152775, '7858651552941', 376);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (10133460, 350042626, '0466391660320', 33);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (10133460, 350042626, '1423030454022', 731);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (10133460, 350042626, '3048780214405', 226);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (10133460, 350042626, '6695441528172', 90);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (10133460, 350042626, '8140718371732', 415);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (14971450, 413877052, '0621911607838', 882);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (14971450, 413877052, '1507798943247', 214);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (14971450, 413877052, '3403392318017', 326);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (14971450, 413877052, '6710753296745', 58);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (14971450, 413877052, '8207032721176', 313);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (18287437, 454942058, '0681663848484', 32);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (18287437, 454942058, '1602647701617', 453);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (18287437, 454942058, '3458477346836', 684);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (18287437, 454942058, '6830754971844', 964);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (18287437, 454942058, '8336419746737', 770);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (18464804, 622427387, '0783263548662', 776);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (18464804, 622427387, '2098000499984', 123);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (18464804, 622427387, '3516213175765', 834);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (18464804, 622427387, '6936974380197', 566);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (18464804, 622427387, '8519119552659', 861);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (19459904, 725443371, '0796993154034', 644);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (19459904, 725443371, '2214999621179', 388);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (19459904, 725443371, '3549928630472', 816);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (19459904, 725443371, '7135167940203', 719);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (19459904, 725443371, '8707158165897', 768);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (25931796, 841957994, '0803319641694', 838);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (25931796, 841957994, '2253089902194', 186);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (25931796, 841957994, '3591999026586', 563);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (25931796, 841957994, '7290310341334', 927);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (25931796, 841957994, '8752689764453', 461);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (28419463, 919883165, '0810419392326', 866);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (28419463, 919883165, '2334815592039', 707);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (28419463, 919883165, '4309852705610', 438);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (28419463, 919883165, '7313688965268', 996);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (28419463, 919883165, '8880235979829', 470);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (29941791, 67609902, '0821775646213', 541);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (29941791, 67609902, '2514350269850', 773);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (29941791, 67609902, '4509759477539', 828);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (29941791, 67609902, '7380775890765', 899);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (29941791, 67609902, '9081209267990', 917);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (32225375, 289009106, '1264555157032', 504);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (32225375, 289009106, '2652816879288', 21);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (32225375, 289009106, '4602736841948', 917);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (32225375, 289009106, '7704054370050', 578);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (32225375, 289009106, '9133323161262', 616);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (35332905, 323152775, '1347144525655', 310);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (35332905, 323152775, '2704937306348', 522);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (35332905, 323152775, '4634634001513', 414);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (35332905, 323152775, '7858651552941', 266);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (35332905, 323152775, '9217578338027', 857);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (38636502, 350042626, '1423030454022', 865);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (38636502, 350042626, '3048780214405', 862);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (38636502, 350042626, '4750010800935', 260);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (38636502, 350042626, '8140718371732', 745);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (38636502, 350042626, '9233915964636', 150);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (39838868, 413877052, '1507798943247', 578);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (39838868, 413877052, '3403392318017', 436);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (39838868, 413877052, '4914532984416', 390);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (39838868, 413877052, '8207032721176', 870);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (39838868, 413877052, '9343034703525', 326);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (41336071, 454942058, '1602647701617', 145);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (41336071, 454942058, '3458477346836', 274);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (41336071, 454942058, '4955346930190', 220);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (41336071, 454942058, '8336419746737', 699);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (41336071, 454942058, '9347961640861', 486);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (42079582, 622427387, '2098000499984', 357);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (42079582, 622427387, '3516213175765', 63);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (42079582, 622427387, '5503930120336', 14);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (42079582, 622427387, '8519119552659', 8);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (42079582, 622427387, '9569730145630', 782);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (43719351, 725443371, '2214999621179', 510);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (43719351, 725443371, '3549928630472', 132);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (43719351, 725443371, '5668902380238', 145);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (43719351, 725443371, '8707158165897', 430);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (43719351, 725443371, '9917692218853', 58);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (47314679, 841957994, '2253089902194', 875);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (47314679, 841957994, '3591999026586', 880);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (47314679, 841957994, '5754225189822', 768);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (47314679, 841957994, '8752689764453', 977);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (47314679, 841957994, '9939960960264', 246);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (47348493, 919883165, '2334815592039', 148);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (47348493, 919883165, '4309852705610', 840);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (47348493, 919883165, '6186729089398', 82);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (47348493, 919883165, '8880235979829', 441);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (47348493, 919883165, '9945284976812', 956);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (51435922, 67609902, '0035806606194', 137);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (51435922, 67609902, '2514350269850', 324);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (51435922, 67609902, '4509759477539', 174);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (51435922, 67609902, '6251518655549', 43);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (51435922, 67609902, '9081209267990', 784);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (55520340, 289009106, '0063834193072', 908);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (55520340, 289009106, '2652816879288', 328);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (55520340, 289009106, '4602736841948', 798);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (55520340, 289009106, '6383439406327', 28);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (55520340, 289009106, '9133323161262', 205);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (56579516, 323152775, '0408293241177', 2);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (56579516, 323152775, '2704937306348', 430);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (56579516, 323152775, '4634634001513', 883);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (56579516, 323152775, '6601017833816', 848);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (56579516, 323152775, '9217578338027', 121);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (57160271, 350042626, '0466391660320', 446);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (57160271, 350042626, '3048780214405', 230);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (57160271, 350042626, '4750010800935', 862);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (57160271, 350042626, '6695441528172', 555);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (57160271, 350042626, '9233915964636', 620);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (59018930, 413877052, '0621911607838', 839);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (59018930, 413877052, '3403392318017', 284);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (59018930, 413877052, '4914532984416', 301);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (59018930, 413877052, '6710753296745', 793);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (59018930, 413877052, '9343034703525', 582);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (65071437, 454942058, '0681663848484', 89);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (65071437, 454942058, '3458477346836', 263);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (65071437, 454942058, '4955346930190', 73);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (65071437, 454942058, '6830754971844', 826);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (65071437, 454942058, '9347961640861', 725);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (68731780, 622427387, '0783263548662', 409);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (68731780, 622427387, '3516213175765', 959);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (68731780, 622427387, '5503930120336', 18);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (68731780, 622427387, '6936974380197', 538);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (68731780, 622427387, '9569730145630', 476);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (70828753, 725443371, '0796993154034', 494);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (70828753, 725443371, '3549928630472', 944);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (70828753, 725443371, '5668902380238', 200);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (70828753, 725443371, '7135167940203', 259);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (70828753, 725443371, '9917692218853', 916);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (73840886, 841957994, '0803319641694', 643);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (73840886, 841957994, '3591999026586', 501);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (73840886, 841957994, '5754225189822', 908);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (73840886, 841957994, '7290310341334', 871);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (73840886, 841957994, '9939960960264', 955);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (74006596, 919883165, '0810419392326', 760);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (74006596, 919883165, '4309852705610', 643);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (74006596, 919883165, '6186729089398', 876);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (74006596, 919883165, '7313688965268', 812);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (74006596, 919883165, '9945284976812', 746);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (74031368, 67609902, '0035806606194', 594);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (74031368, 67609902, '0821775646213', 624);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (74031368, 67609902, '4509759477539', 185);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (74031368, 67609902, '6251518655549', 40);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (74031368, 67609902, '7380775890765', 344);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (76285165, 289009106, '0063834193072', 816);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (76285165, 289009106, '1264555157032', 323);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (76285165, 289009106, '4602736841948', 28);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (76285165, 289009106, '6383439406327', 32);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (76285165, 289009106, '7704054370050', 652);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (81623550, 323152775, '0408293241177', 862);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (81623550, 323152775, '1347144525655', 478);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (81623550, 323152775, '4634634001513', 695);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (81623550, 323152775, '6601017833816', 294);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (81623550, 323152775, '7858651552941', 515);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (81811191, 350042626, '0466391660320', 118);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (81811191, 350042626, '1423030454022', 492);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (81811191, 350042626, '4750010800935', 973);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (81811191, 350042626, '6695441528172', 123);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (81811191, 350042626, '8140718371732', 781);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (82514640, 413877052, '0621911607838', 245);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (82514640, 413877052, '1507798943247', 891);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (82514640, 413877052, '4914532984416', 344);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (82514640, 413877052, '6710753296745', 17);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (82514640, 413877052, '8207032721176', 457);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (87791972, 454942058, '0681663848484', 288);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (87791972, 454942058, '1602647701617', 493);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (87791972, 454942058, '4955346930190', 889);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (87791972, 454942058, '6830754971844', 410);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (87791972, 454942058, '8336419746737', 443);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (88460780, 622427387, '0783263548662', 257);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (88460780, 622427387, '2098000499984', 836);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (88460780, 622427387, '5503930120336', 772);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (88460780, 622427387, '6936974380197', 502);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (88460780, 622427387, '8519119552659', 162);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (91913467, 725443371, '0796993154034', 224);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (91913467, 725443371, '2214999621179', 61);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (91913467, 725443371, '5668902380238', 111);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (91913467, 725443371, '7135167940203', 879);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (91913467, 725443371, '8707158165897', 932);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (93906938, 841957994, '0803319641694', 253);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (93906938, 841957994, '2253089902194', 845);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (93906938, 841957994, '5754225189822', 28);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (93906938, 841957994, '7290310341334', 903);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (93906938, 841957994, '8752689764453', 569);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (98892187, 919883165, '0810419392326', 599);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (98892187, 919883165, '2334815592039', 493);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (98892187, 919883165, '6186729089398', 949);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (98892187, 919883165, '7313688965268', 202);
INSERT INTO `supply` (`vendor_id`, `store_id`, `upc`, `supply_count`) VALUES (98892187, 919883165, '8880235979829', 435);
 ```

## Data Generation

Data was generated using [filldb](http://filldb.info/dummy). FillDb is a free web tool for generating database data. Our design schema was passed in as input with customized entries to generate data for our tables - with foreign and primary keys identified - in order to fit in with our database model. We updated some of the tables columns value for more realistic data after first generation with data from [mockaroo](https://www.mockaroo.com/) using the ***update.php*** script
all run on a sql server. All the generated data have been commited here as excel files.

**Note: Some of the data was edited manually once the appropriate tables were created. So the data in the INSERT file might be sligthly different from our actual data.**

## Queries Run

## Testing

There are two options when it comes to testing. 
- [phpMyAdmin](https://codd.cs.gsu.edu/~mchristopherraoul1/phpMyAdmin/)
- Locally using maria db or mySql

you can use our online database using [phpMyAdmin](https://codd.cs.gsu.edu/~mchristopherraoul1/phpMyAdmin/) and login with the following credentials
username: ***mchristopherraoul1***
password: ***mchristopherraoul1***
All of the dll and Insert statements were already run on there, so one could just go and run the queries in the sql editor.
(**Not recommended**) You can also use the DLL and Insert sql files to create all of the tables locally with their respective data using mariaDb or mySql. However, you would need to run the update.php with the product json file in order to update product names. Since there were also some changes done manually on phpMyAdmin, you will not be able to have the database completetely up to date locally.
**Note: Some of the queries will not return desired result if you decide to run it locally. 
## Video Presentation
