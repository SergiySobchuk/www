-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Фев 06 2017 г., 18:31
-- Версия сервера: 5.5.25
-- Версия PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `db_shop`
--

-- --------------------------------------------------------

--
-- Структура таблицы `buy_products`
--

CREATE TABLE IF NOT EXISTS `buy_products` (
  `buy_id` int(11) NOT NULL AUTO_INCREMENT,
  `buy_id_order` int(11) NOT NULL,
  `buy_id_product` int(11) NOT NULL,
  `buy_count_product` int(11) NOT NULL,
  PRIMARY KEY (`buy_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=61 ;

--
-- Дамп данных таблицы `buy_products`
--

INSERT INTO `buy_products` (`buy_id`, `buy_id_order`, `buy_id_product`, `buy_count_product`) VALUES
(57, 27, 12, 1),
(56, 27, 30, 1),
(58, 28, 9, 1),
(59, 28, 11, 1),
(60, 28, 14, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `cart`
--

CREATE TABLE IF NOT EXISTS `cart` (
  `cart_id` int(11) NOT NULL AUTO_INCREMENT,
  `cart_id_products` int(11) NOT NULL,
  `cart_price` int(11) NOT NULL,
  `cart_count` int(11) NOT NULL DEFAULT '1',
  `cart_datetime` datetime NOT NULL,
  `cart_ip` varchar(100) NOT NULL,
  PRIMARY KEY (`cart_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=123 ;

--
-- Дамп данных таблицы `cart`
--

INSERT INTO `cart` (`cart_id`, `cart_id_products`, `cart_price`, `cart_count`, `cart_datetime`, `cart_ip`) VALUES
(69, 16, 2899, 1, '2016-11-27 11:31:54', '95.69.195.221'),
(70, 15, 6588, 1, '2016-11-27 11:32:06', '95.69.195.221'),
(71, 15, 6588, 1, '2016-11-28 00:47:03', '37.53.155.76'),
(72, 16, 2899, 2, '2016-11-28 01:15:57', '37.53.155.76'),
(121, 9, 7995, 1, '2017-02-06 17:56:23', '127.0.0.1'),
(120, 11, 6499, 1, '2017-02-06 17:56:22', '127.0.0.1'),
(122, 14, 2333, 1, '2017-02-06 17:56:25', '127.0.0.1');

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) NOT NULL,
  `brand` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=44 ;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`id`, `type`, `brand`) VALUES
(1, 'mobile', 'Apple'),
(2, 'mobile', 'Lenovo'),
(3, 'mobile', 'Huawei'),
(4, 'mobile', 'Sony'),
(5, 'mobile', 'HTC'),
(6, 'mobile', 'LG'),
(7, 'mobile', 'Motorola'),
(8, 'mobile', 'Nokia'),
(9, 'mobile', 'Philips'),
(10, 'mobile', 'Samsung'),
(21, 'notebook', 'DNS'),
(23, 'notebook', 'Asus'),
(24, 'notebook', 'Dell'),
(25, 'notebook', 'HP'),
(26, 'notebook', 'Lenovo'),
(27, 'notebook', 'MSI'),
(36, 'notebook', 'DNS'),
(30, 'notebook', 'Samsung'),
(31, 'notepad', 'Apple'),
(32, 'notepad', 'Samsung'),
(33, 'notepad', 'Lenovo');

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Дамп данных таблицы `news`
--

INSERT INTO `news` (`id`, `title`, `text`, `date`) VALUES
(1, 'Безкоштовні вхідні в роумінгу', 'Пакет «25 вхідних хвилин щодня у Європі та СНГ»\\r\\nПакет «40 вхідних хвилин на 7 днів у всьому світі»\\r\\nПакет «50 вхідних хвилин на 7 днів у Європі та СНГ»', '2016-03-01'),
(3, 'SMS Пакети у роумінгу', 'SMS у роумінгу від 2 грн\\r\\nТермін дії послуги — 7 днів', '2016-03-03'),
(4, 'Facebook Безліміт', 'Переваги послуги\\r\\n\\r\\n0 грн/МБ за користування соціальною мережею Facebook!\\r\\nБезкоштовне підключення!', '2016-03-04'),
(5, 'Cупер Інтернет', 'Переваги\\r\\n\\r\\nБезлімітний Інтернет усього за 1,00 грн на день!\\r\\nБезкоштовна активація!\\r\\nОбирайте тариф саме для Ваших потреб!', '2016-03-06');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_datetime` datetime NOT NULL,
  `order_confirmed` varchar(10) NOT NULL DEFAULT 'no',
  `order_dostavka` varchar(255) NOT NULL,
  `order_pay` varchar(50) NOT NULL,
  `order_type_pay` varchar(100) NOT NULL,
  `order_fio` text NOT NULL,
  `order_address` text NOT NULL,
  `order_phone` varchar(50) NOT NULL,
  `order_note` text NOT NULL,
  `order_email` varchar(50) NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`order_id`, `order_datetime`, `order_confirmed`, `order_dostavka`, `order_pay`, `order_type_pay`, `order_fio`, `order_address`, `order_phone`, `order_note`, `order_email`) VALUES
(27, '2017-02-05 14:41:26', 'yes', 'Поштою', 'accepted', '', 'Бороденко Олександр', 'Головатого 1 кв. 21', '0636423350', 'Вивезу сам у пятницю в періоді між 17:00 і 18:00.', 'Borodenko@gmail.com'),
(28, '2017-02-06 17:56:45', 'no', 'Поштою', 'accepted', '', 'Собчук Сергій Вікторович', 'Івана Франка 57Б/39', '0639400228', 'прошу надіслати на відділення', 'SergiySobchuk@gmail.com');

-- --------------------------------------------------------

--
-- Структура таблицы `reg_admin`
--

CREATE TABLE IF NOT EXISTS `reg_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `fio` text NOT NULL,
  `role` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `view_orders` int(11) NOT NULL DEFAULT '0',
  `accept_orders` int(11) NOT NULL DEFAULT '0',
  `delete_orders` int(11) NOT NULL DEFAULT '0',
  `add_tovar` int(11) NOT NULL DEFAULT '0',
  `edit_tovar` int(11) NOT NULL DEFAULT '0',
  `delete_tovar` int(11) NOT NULL DEFAULT '0',
  `accept_reviews` int(11) NOT NULL DEFAULT '0',
  `delete_reviews` int(11) NOT NULL DEFAULT '0',
  `view_clients` int(11) NOT NULL DEFAULT '0',
  `delete_clients` int(11) NOT NULL DEFAULT '0',
  `add_news` int(11) NOT NULL DEFAULT '0',
  `delete_news` int(11) NOT NULL DEFAULT '0',
  `add_category` int(11) NOT NULL DEFAULT '0',
  `delete_category` int(11) NOT NULL DEFAULT '0',
  `view_admin` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `reg_admin`
--

INSERT INTO `reg_admin` (`id`, `login`, `pass`, `fio`, `role`, `email`, `phone`, `view_orders`, `accept_orders`, `delete_orders`, `add_tovar`, `edit_tovar`, `delete_tovar`, `accept_reviews`, `delete_reviews`, `view_clients`, `delete_clients`, `add_news`, `delete_news`, `add_category`, `delete_category`, `view_admin`) VALUES
(1, 'admin', 'dsfb4rf807b432d25170b469b57095ca269bc202ds4s5', 'Собчук Сергій', 'Адміністратор', 'admin@gmail.com', '43 423 423', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(7, 'admin1', 'dsfb4rf85e82af769bc15620147d2dbc8b07111eds4s5', 'Росоловський Віталя', 'Бармен', 'gsg@dfsf.dsdd', '435345345', 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 1),
(5, 'admin2', 'dsfb4rf84b704715dd4d8e75a9ff6cdfed5437afds4s5', 'Собчук Олександр', 'asdfdsf', 'safsdf', '343434', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `reg_user`
--

CREATE TABLE IF NOT EXISTS `reg_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(100) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `patronymic` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `datetime` datetime NOT NULL,
  `ip` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Дамп данных таблицы `reg_user`
--

INSERT INTO `reg_user` (`id`, `login`, `pass`, `surname`, `name`, `patronymic`, `email`, `phone`, `address`, `datetime`, `ip`) VALUES
(4, 'admin', 'dsfb4rf80cc4856e4fbbab44b76c641ed8c0bb5fds4s5', 'Собчук', 'Сергій', 'Вікторович', 'Serg@UKR.net', '937-99-92', 'Четвертного 11', '2016-09-21 12:53:01', '127.0.0.1'),
(6, 'admin', 'dsfb4rf80cc4856e4fbbab44b76c641ed8c0bb5fds4s5', 'Собчук', 'Сергій', 'Вікторович', 'Serg@UKR.net', '937-99-92', 'Четвертного 11', '2016-09-21 12:53:01', '127.0.0.1'),
(7, 'admin', 'dsfb4rf80cc4856e4fbbab44b76c641ed8c0bb5fds4s5', 'Собчук', 'Сергій', 'Вікторович', 'Serg@UKR.net', '937-99-92', 'Четвертного 11', '2016-09-21 12:53:01', '127.0.0.1'),
(8, 'admin', 'dsfb4rf80cc4856e4fbbab44b76c641ed8c0bb5fds4s5', 'Собчук', 'Сергій', 'Вікторович', 'Serg@UKR.net', '937-99-92', 'Четвертного 11', '2016-09-21 12:53:01', '127.0.0.1'),
(9, 'admin', 'dsfb4rf80cc4856e4fbbab44b76c641ed8c0bb5fds4s5', 'Собчук', 'Сергій', 'Вікторович', 'Serg@UKR.net', '937-99-92', 'Четвертного 11', '2016-09-21 12:53:01', '127.0.0.1');

-- --------------------------------------------------------

--
-- Структура таблицы `table_products`
--

CREATE TABLE IF NOT EXISTS `table_products` (
  `products_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `seo_words` text NOT NULL,
  `seo_description` text NOT NULL,
  `mini_description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `mini_features` text NOT NULL,
  `features` text NOT NULL,
  `datetime` datetime NOT NULL,
  `new` int(11) NOT NULL DEFAULT '0',
  `leader` int(11) NOT NULL DEFAULT '0',
  `sale` int(11) NOT NULL DEFAULT '0',
  `visible` int(11) NOT NULL DEFAULT '0',
  `count` int(11) NOT NULL DEFAULT '0',
  `type_tovara` varchar(255) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `yes_like` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`products_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=73 ;

--
-- Дамп данных таблицы `table_products`
--

INSERT INTO `table_products` (`products_id`, `title`, `price`, `brand`, `seo_words`, `seo_description`, `mini_description`, `image`, `description`, `mini_features`, `features`, `datetime`, `new`, `leader`, `sale`, `visible`, `count`, `type_tovara`, `brand_id`, `yes_like`) VALUES
(1, 'Смартфон Lenovo A2010 Black', 14300, 'Lenovo', '', '', 'Гарантія\\n12 місяців офіційної гарантії від виробника. Обмін / повернення товару протягом 14 днів', 'lenovo_a2010_black_2.jpg', '', 'Кіл-сть SIM-карт:2 шт.\\r\\nДіагональ:  4,5''''\\r\\nТип екрану:  TN', '', '2016-02-20 01:08:09', 1, 0, 0, 1, 0, 'mobile', 2, 1),
(2, 'Смартфон Huawei Y5C (Y541-U02) DS Black', 400600, 'Huawei', '', '', 'Гарантія\\n24 місяців офіційної гарантії від виробника. Обмін / повернення товару протягом 14 днів', 'huawei_y5c_y541-u02_ds_black.jpg', '', 'Кіл-сть SIM-карт: 2 шт.\\r\\nДіагональ:  4,5''''\\r\\nТип екрану:  TFT', '', '2016-02-20 03:22:29', 1, 0, 0, 1, 0, 'mobile', 3, 1),
(3, 'Смартфон HTC Desire 600 dual sim', 1000532, 'HTC', '', '', 'Эффективная работа в любом месте и непревзойденная скорость – вот сплав, из которого сделан HTC Desire 600 dual sim. ', 'HTC Desire 600 dual sim.jpg', '', 'Размер\\r\\n134,8 x 67 x 9,26 мм\\r\\nВес\\r\\n130 г\\r\\nЭкран\\r\\n4,5 дюйма, qHD\\r\\nПроцессор\\r\\nQualcomm® Snapdragon™ 200 1,2 ГГц\\r\\nПлатформа\\r\\nAndroid™ с ', '', '2016-03-03 00:00:00', 1, 0, 1, 1, 1, 'mobile', 5, 1),
(4, 'Смартфон Lenovo A2010 white', 4325, 'Lenovo', '', '', 'Гарантія\\r\\n12 місяців офіційної гарантії від виробника. Обмін / повернення товару протягом 14 днів', 'lenovo_a2010_white_2.jpg', '', 'Кіл-сть SIM-карт:2 шт.\\r\\nДіагональ:  4,5''''\\r\\nТип екрану:  TN', '', '2016-03-03 04:16:21', 0, 0, 1, 1, 2, 'mobile', 2, 1),
(6, 'Смартфон Samsung G531H/DS Grand Prime VE Gold', 3699, 'Samsung', '', '', 'Характеристики та комплектація товару можуть змінюватися виробником без попередження. Магазин не несе відповідальність за зміни, внесені виробником.', 'Samsung_g531h.JPG', '', 'Стандарти зв''язку: GSM850/900/1800/1900, 3G, LTE\\r\\nКількість SIM-карт: 2 слота для SIM-карт\\r\\nРозмір SIM-карти: Micro-SIM', '', '2016-03-23 06:15:18', 0, 1, 0, 1, 0, 'mobile', 10, 2),
(7, 'Nokia Lumia з Microsoft 640 ДС блакитний', 3699, 'Nokia', '', '', 'Характеристики та комплектація товару можуть змінюватися виробником без попередження. Магазин не несе відповідальність за зміни, внесені виробником.', 'Nokia_lumia_640.JPG', '', 'Діагональ дисплея: 5''''\\r\\nРоздільна здатність екрану: 1280x720\\r\\nТип екрану: IPS\\r\\nКількість кольорів екрану: 16,7 млн\\r\\n3D екран: Ні\\r\\nТехнологія захисного скла: Corning Gorilla Glass 3', '', '2016-03-16 08:19:25', 1, 0, 0, 1, 0, 'mobile', 8, 3),
(8, 'Смартфон HTC Desire 526 DS White/Blue', 4699, 'HTC', '', '', 'Характеристики та комплектація товару можуть змінюватися виробником без попередження. Магазин не несе відповідальність за зміни, внесені виробником.', 'HTC_DESIRE_526.JPG', '', 'Модель центрального процесора: Mediatek MT6592\\nКількість ядер: 4 ядра\\nЧастота центрального процесора: 1,3 ГГц\\nМодель графічного процесора: Mali-450MP4', '', '2016-03-08 05:12:18', 0, 1, 0, 1, 1, 'mobile', 5, 6),
(9, 'Смартфон HTC One M9 Gold on Silver', 7995, 'HTC', '', '', 'Характеристики та комплектація товару можуть змінюватися виробником без попередження. Магазин не несе відповідальність за зміни, внесені виробником.', 'HTC_GOLD.JPG', '', 'Об''єм ОЗП: 3 ГБ\\nОб''єм вбудованої пам''яті: 32 ГБ\\nРозширення пам''яті: microSD 2 ТБ', '', '2016-03-02 13:34:44', 0, 1, 0, 1, 3, 'mobile', 5, 7),
(30, 'Xiaomi Redmi 3 Pro 3/32GB Silver', 4199, 'Sony', 'Xiaomi Redmi 3', 'Xiaomi Redmi 3 Pro 3/32GB Silver', '<p>Новый&nbsp;<strong>Redmi 3 Pro</strong>&nbsp;оснащен процессором высокой производительности Qualcomm Snapdragon 616, 4100 мА*ч батареей большой емкости, привлекательным цельнометаллическим корпусом, 13 Мп камерой с поддержкой технологии фазовой фокусировки. Еще более впечатляющим является то, что, хотя его толщина меньше, чем у смартфонов предыдущего поколения всего на 0.9 мм (толщина составляет 8.5 мм), 5-дюймовый&nbsp;<strong>Redmi 3 Pro&nbsp;</strong>очень удобно располагается в руке и приятен на ощупь.</p>\r\n', 'mobile-3042.jpg', '<p><img src="https://i1.rozetka.com.ua/pages/169/169089.jpg" /></p>\n\n<p><strong>Версия Android 5.1.1 LolliPop, MIUI Global 7.3 (Стабильная) с обновлением по воздуху, русский и украинский языки!</strong></p>\n\n<p><img src="https://i1.rozetka.com.ua/pages/169/169068.jpg" /></p>\n\n<p>В качестве ОС используется Android 5.1.1, с фирменной оболочкой от&nbsp;<strong>Xiaomi</strong>&nbsp;&mdash; MIUI 7.3 (глобальная версия), с поддержкой украинского и русского языка и сервисами от Google. В MIUI 7 очень много преимуществ перед &laquo;чистой&raquo; версией Android: красивый и функциональный интерфейс, множество программных дополнений, возможность тонкой настройки.&nbsp;<br />\n<br />\nСпециально под разные вкусы пользователей в MIUI 7 предусмотрено 5 встроенных тем. Но достоинства MIUI 7 не ограничиваются только кастомизацией интерфейса. Благодаря проведенной оптимизации сократилось время отклика системы, а скорость запуска приложений увеличилась более чем на 30%. Также MIUI 7 способна регулировать расход заряда батареи в зависимости от задач, что позволяет продлить время использования смартфона на 25%. Помимо этого, она обогатилась огромным количеством приложений для чтения книг, игр, путешествий, быта и т.д., призванных помочь в решении повседневных задач в самых разных сферах жизни.</p>\n\n<p><strong>Высокая производительность</strong></p>\n\n<p><img src="https://i1.rozetka.com.ua/pages/169/169047.jpg" /></p>\n\n<p>Одним из основных показателей высокопроизводительного процессора является наличие 8 ядер и 64-битной архитектуры. Процессор, внедренный в&nbsp;<strong>Xiaomi Redmi 3 Pro</strong>, полностью соответствует этому требованию. Благодаря оптимизации, произведенной на системном уровне, четыре ведущих ядра 1.5 ГГц и четыре энергосберегающих ядра 1.2 ГГц способны переключаться в зависимости от задач, обеспечивая одновременно стабильность работы и экономный расход энергии.<br />\n<br />\nМесто графического ядра занимает Adreno 405. Увеличенный до 3 ГБ объем оперативной памяти. С таким &quot;железом&quot; аппарат с легкостью решает любые поставленные перед ним задачи, работает быстро, без каких-либо задержек.</p>\n\n<p><strong>Распознавание отпечатков пальцев</strong></p>\n\n<p><img src="https://i2.rozetka.com.ua/pages/169/169026.jpg" /></p>\n\n<p>Смартфон&nbsp;<strong>Xiaomi Redmi 3 Pro</strong>&nbsp;отличается наличием сканера отпечатков пальцев, позволяющих лучше защитить конфиденциальную информацию хранящуюся в смартфоне и не вводить каждый раз пароль для разблокировки смартфона. Благодаря распознаванию отпечатков пальцев можно разблокировать экран смартфона даже в спящем режиме всего лишь легким касанием пальца. При этом разблокировка происходит за 0.3 секунды, что гораздо быстрее, чем при вводе графического или цифрового пароля.</p>\n\n<p><strong>Один экран, три вида технологий</strong></p>\n\n<p><img src="https://i2.rozetka.com.ua/pages/168/168921.jpg" /></p>\n\n<p><strong>Redmi 3 Pro</strong>&nbsp;оснащен 5-дюймовым экраном на IPS-матрице с разрешением 1280x720 пикселей (HD), у него отличная цветопередача, контрастность и максимальные углы обзора.&nbsp;<strong>Xiaomi Redmi 3 Pro&nbsp;</strong>способен регулировать контрастность экрана в зависимости от степени освещенности, благодаря чему яркие солнечные лучи ему больше не страшны. Также он умеет регулировать яркость подсветки дисплея до комфортного уровня, что позволяет пользоваться смартфоном без вреда для глаз даже ночью. Специально для любителей чтения перед сном в кровати разработан режим защиты глаз, уменьшающий нагрузку на органы зрения.</p>\n\n<p>Многофункциональный дисплей с &laquo;умной&raquo; регулировкой яркости вполне соответствует современным критериям и является весомым достоинством нового&nbsp;<strong>Redmi 3 Pro</strong>.<br />\n<br />\n<strong>Камера с поддержкой технологии быстрой фазовой фокусировки</strong></p>\n\n<p><img src="https://i1.rozetka.com.ua/pages/169/169005.jpg" /></p>\n\n<p><strong>Redmi 3 Pro</strong>&nbsp;оснащен высококачественным датчиком высокой четкости, с ним фотографии будут всегда непревзойденными. Смартфон поддерживает технологию быстрой фазовой фокусировки, которая свойственна профессиональным фотоаппаратам. Скорость фокусировки достигает 0.1 секунды.</p>\n\n<p>Помимо основной,&nbsp;<strong>Redmi 3 Pro&nbsp;</strong>также получил фронтальную камеру на 5 Мп и апертуру f/2.2, она может снимать видео в Full HD, как и основная камера. Смартфон также поддерживает HDR режим, что значительно расширяет ваши возможности для создания креативных фото. Кроме того, передняя камера Redmi 3 имеет функцию улучшения фотографий, благодаря которой ваши селфи будут выглядеть еще лучше.</p>\n\n<p><strong>2 слота для SIM карт</strong></p>\n\n<p><img src="https://i2.rozetka.com.ua/pages/168/168963.jpg" /></p>\n\n<p><strong>Redmi 3 Pro</strong>&nbsp;поддерживает поддерживает Dual Sim, Dual Standby, поэтому вы можете пользоваться двумя карточками. Если же у вас только один мобильный номер, один свободный слот для SIM карты можно использовать для карты Micro SD, что позволит увеличить память смартфона до 128 ГБ и сохранять еще больше информации.</p>\n\n<ul>\n	<li>Nano SIM карта/ Mirco SD для расширения памяти &mdash; два варианта использования слота</li>\n	<li>Micro SIM карта</li>\n</ul>\n\n<p>&nbsp;</p>\n\n<p><strong>Емкость батареи 4100 мА*ч, тем не менее, смартфон стал тоньше на 0.9 мм</strong></p>\n\n<p><img src="https://i1.rozetka.com.ua/pages/168/168942.jpg" /></p>\n\n<p>Толщина батареи большой емкости 4100 мА*ч составляет всего 8.5 мм. Производителю удалось увеличить емкость аккумулятора устройства на 32% благодаря более продуманной внутренней компоновке и использованию аккумулятора с повышенной удельной энергоплотностью.</p>\n\n<p>Время разговора, по сравнению со смартфоном прошлого поколения, увеличился на 80%.&nbsp;<strong>Redmi 3 Pro</strong>оснащен абсолютно новой оптимизированной системой потребления электроэнергии, поэтому заряда телефона будет достаточно приблизительно на три дня его использования в нормальном режиме. Одновременная поддержка технологии быстрой подзарядки 5V/2A.</p>\n\n<p><strong>Использование батареи:</strong></p>\n\n<ul>\n	<li>Игры &mdash; 16 часов</li>\n	<li>Музыка &mdash; 91 час</li>\n	<li>Чтение литературы &mdash; 38 часов</li>\n	<li>Просмотр фильмов &mdash; 20 часов</li>\n</ul>\n', 'Процессор: Восьмиядерный Qualcomm Snapdragon 616 (1.5 ГГц + 1.2 ГГц)\nДисплей: IPS, емкостный, Multi-Touch\nРазрешение: 1280x720 пикселей\nПлотность пикселей: 294 ppi', '<p>Операционная система&nbsp;<a href="http://rozetka.com.ua/mobile-phones/c80003/glossary/"><img alt="Подробнее" src="http://i.rozetka.ua/design/_.gif" style="height:15px; margin:0px; width:14px" /></a></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Android</p>\r\n\r\n<p>Цвет&nbsp;<a href="http://rozetka.com.ua/mobile-phones/c80003/glossary/"><img alt="Подробнее" src="http://i.rozetka.ua/design/_.gif" style="height:15px; margin:0px; width:14px" /></a></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Silver</p>\r\n\r\n<p>Поддержка нескольких СИМ-карт&nbsp;<a href="http://rozetka.com.ua/mobile-phones/c80003/glossary/"><img alt="Подробнее" src="http://i.rozetka.ua/design/_.gif" style="height:15px; margin:0px; width:14px" /></a></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>2х</p>\r\n\r\n<p>Сканер отпечатков пальцев</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Есть</p>\r\n\r\n<p>Процессор&nbsp;<a href="http://rozetka.com.ua/mobile-phones/c80003/glossary/"><img alt="Подробнее" src="http://i.rozetka.ua/design/_.gif" style="height:15px; margin:0px; width:14px" /></a></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Восьмиядерный Qualcomm Snapdragon 616 (1.5 ГГц + 1.2 ГГц)</p>\r\n\r\n<p>Размеры и вес&nbsp;<a href="http://rozetka.com.ua/mobile-phones/c80003/glossary/"><img alt="Подробнее" src="http://i.rozetka.ua/design/_.gif" style="height:15px; margin:0px; width:14px" /></a></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>139.3 x 69.6 x 8.5 мм<br />\r\nВес: 144 г</p>\r\n\r\n<p>Форм-фактор телефона&nbsp;<a href="http://rozetka.com.ua/mobile-phones/c80003/glossary/"><img alt="Подробнее" src="http://i.rozetka.ua/design/_.gif" style="height:15px; margin:0px; width:14px" /></a></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Сенсорный моноблок</p>\r\n\r\n<p>Дисплей&nbsp;<a href="http://rozetka.com.ua/mobile-phones/c80003/glossary/"><img alt="Подробнее" src="http://i.rozetka.ua/design/_.gif" style="height:15px; margin:0px; width:14px" /></a></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>5&quot; IPS, емкостный, Multi-Touch&nbsp;<br />\r\nРазрешение: 1280x720 пикселей&nbsp;<br />\r\nПлотность пикселей: 294 ppi&nbsp;</p>\r\n\r\n<p>Сигналы вызова&nbsp;<a href="http://rozetka.com.ua/mobile-phones/c80003/glossary/"><img alt="Подробнее" src="http://i.rozetka.ua/design/_.gif" style="height:15px; margin:0px; width:14px" /></a></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Виброзвонок<br />\r\nПолифонические мелодии звонка<br />\r\nMP3 в качестве звонка</p>\r\n\r\n<p>Камера&nbsp;<a href="http://rozetka.com.ua/mobile-phones/c80003/glossary/"><img alt="Подробнее" src="http://i.rozetka.ua/design/_.gif" style="height:15px; margin:0px; width:14px" /></a></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Основная: 13 Мп&nbsp;<br />\r\nФазовый автофокус<br />\r\nВспышка<br />\r\nДиафрагма: f/2.0<br />\r\nФронтальная камера: 5 Мп<br />\r\nДиафрагма: f/2.2</p>\r\n\r\n<p>Стандарт&nbsp;<a href="http://rozetka.com.ua/mobile-phones/c80003/glossary/"><img alt="Подробнее" src="http://i.rozetka.ua/design/_.gif" style="height:15px; margin:0px; width:14px" /></a></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>GSM (2G): 900 / 1800 / 1900 МГц<br />\r\nHSDPA (3G)<br />\r\nLTE (4G)</p>\r\n\r\n<p>Размеры СИМ-карты&nbsp;<a href="http://rozetka.com.ua/mobile-phones/c80003/glossary/"><img alt="Подробнее" src="http://i.rozetka.ua/design/_.gif" style="height:15px; margin:0px; width:14px" /></a></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Nano-SIM&nbsp;<br />\r\nMicro-SIM</p>\r\n\r\n<p>Функции памяти&nbsp;<a href="http://rozetka.com.ua/mobile-phones/c80003/glossary/"><img alt="Подробнее" src="http://i.rozetka.ua/design/_.gif" style="height:15px; margin:0px; width:14px" /></a></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>3 ГБ оперативной памяти<br />\r\n32 ГБ встроенной памяти<br />\r\nПоддержка карт памяти microSD (до 128 ГБ)</p>\r\n\r\n<p>Органайзер&nbsp;<a href="http://rozetka.com.ua/mobile-phones/c80003/glossary/"><img alt="Подробнее" src="http://i.rozetka.ua/design/_.gif" style="height:15px; margin:0px; width:14px" /></a></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Календарь<br />\r\nЧасы<br />\r\nМировое время<br />\r\nБудильник<br />\r\nСекундомер<br />\r\nКалькулятор<br />\r\nЗаметки</p>\r\n\r\n<p>Управление вызовами&nbsp;<a href="http://rozetka.com.ua/mobile-phones/c80003/glossary/"><img alt="Подробнее" src="http://i.rozetka.ua/design/_.gif" style="height:15px; margin:0px; width:14px" /></a></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Громкая связь<br />\r\nИдентификация абонента<br />\r\nПоследние/Пропущенные/Исходящие</p>\r\n\r\n<p>Развлечения&nbsp;<a href="http://rozetka.com.ua/mobile-phones/c80003/glossary/"><img alt="Подробнее" src="http://i.rozetka.ua/design/_.gif" style="height:15px; margin:0px; width:14px" /></a></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Игры<br />\r\nFM радио<br />\r\nАудиоплеер<br />\r\nВидеоплеер&nbsp;<br />\r\nМобильные сервисы Google<br />\r\nИнтеграция с социальными сетями<br />\r\nДатчики: акселерометр, освещения, приближения<br />\r\nCканер отпечатка пальцев</p>\r\n\r\n<p>Работа с сообщениями&nbsp;<a href="http://rozetka.com.ua/mobile-phones/c80003/glossary/"><img alt="Подробнее" src="http://i.rozetka.ua/design/_.gif" style="height:15px; margin:0px; width:14px" /></a></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>SMS, MMS, Email</p>\r\n\r\n<p>Интернет&nbsp;<a href="http://rozetka.com.ua/mobile-phones/c80003/glossary/"><img alt="Подробнее" src="http://i.rozetka.ua/design/_.gif" style="height:15px; margin:0px; width:14px" /></a></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>GPRS / EDGE / 3G / LTE</p>\r\n\r\n<p>Беспроводные технологии</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Wi-Fi 802.11 b/g/n<br />\r\nWi-Fi Direct<br />\r\nWi-Fi Hotspot<br />\r\nGPS + A-GPS<br />\r\nBluetooth 4.1 + A2DP<br />\r\nGLONASS</p>\r\n\r\n<p>3D-экран и 3D-камера&nbsp;<a href="http://rozetka.com.ua/mobile-phones/c80003/glossary/"><img alt="Подробнее" src="http://i.rozetka.ua/design/_.gif" style="height:15px; margin:0px; width:14px" /></a></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Нет</p>\r\n\r\n<p>Питание&nbsp;<a href="http://rozetka.com.ua/mobile-phones/c80003/glossary/"><img alt="Подробнее" src="http://i.rozetka.ua/design/_.gif" style="height:15px; margin:0px; width:14px" /></a></p>\r\n\r\n<p>Литий-ионный аккумулятор 4100 мА*ч</p>\r\n\r\n<p>Комплект поставки&nbsp;<a href="http://rozetka.com.ua/mobile-phones/c80003/glossary/"><img alt="Подробнее" src="http://i.rozetka.ua/design/_.gif" style="height:15px; margin:0px; width:14px" /></a></p>\r\n\r\n<p>Cмартфон</p>\r\n\r\n<p>Блок зарядного устройства с USB входом<br />\r\nДата-кабель microUSB<br />\r\nГарантийный талон<br />\r\nИнструкция по эксплуатации</p>\r\n\r\n<p>Ширина</p>\r\n\r\n<p>69.6 мм</p>\r\n\r\n<p>Высота</p>\r\n\r\n<p>139.3 мм</p>\r\n\r\n<p>Глубина</p>\r\n\r\n<p>8.5 мм</p>\r\n\r\n<p>Гарантия</p>\r\n\r\n<p>12 месяцев</p>\r\n', '0000-00-00 00:00:00', 1, 1, 1, 1, 4, 'mobile', 4, 3),
(11, 'Смартфон Apple iPhone 5S 16 GB Space Grey', 6499, 'Apple', '', '', 'Характеристики та комплектація товару можуть змінюватися виробником без попередження. Магазин не несе відповідальність за зміни, внесені виробником.', 'Apple_5.JPG', '', 'Комплектація: Ні\\nМатеріал корпусу: Алюміній\\nВисота: 123,8 мм\\nШирина: 58,6 мм\\nГлибина: 7,6 мм\\nВага: 112 г\\nКолір: Сірий\\nГарантійний термін: 1 рік\\nКраїна виробництва: Китай', '', '2016-03-06 03:25:34', 0, 1, 0, 1, 2, 'mobile', 1, 26),
(12, 'Смартфон LG X155 Max Titan', 2888, 'LG', '', '', 'Характеристики та комплектація товару можуть змінюватися виробником без попередження. Магазин не несе відповідальність за зміни, внесені виробником.', 'LG_x155.JPG', '', 'Стандарти зв''язку: 2G: GSM 900 / 1800; 3G: 900 / 2100, HSPA+ 21 Мбит/с\\r\\nКількість SIM-карт: 2 слота для SIM-карт\\r\\nРозмір SIM-карти: Micro-SIM', '', '2016-03-22 04:09:15', 1, 0, 0, 1, 4, 'mobile', 6, 6),
(13, 'Смартфон Motorola Porto Black', 2888, 'Motorola', '', '', 'Характеристики та комплектація товару можуть змінюватися виробником без попередження. Магазин не несе відповідальність за зміни, внесені виробником.', 'Motorola_coolpad.JPG', '', 'Діагональ дисплея: 4,7''''\\r\\nРоздільна здатність екрану: 960x540\\r\\nТип екрану: IPS\\r\\nКількість кольорів екрану: 16,7 млн\\r\\n3D екран: Ні', '', '2016-03-15 03:20:39', 1, 0, 0, 1, 14, 'mobile', 7, 5),
(14, 'Смартфон Philips Rio Play RED', 2333, 'LG', 'Phone', 'Phone mobile', '<p>Характеристики та комплектація товару можуть змінюватися виробником без попередження. Магазин не несе відповідальність за зміни, внесені виробником. Зв&#39;язок</p>\r\n\r\n<p>Phone mobile</p>\r\n', 'mobile-1472.jpg', '<p>Phone mobile&nbsp;Phone mobile</p>\r\n', '<p>Висота: 123,8 мм Ширина: 58,6 мм Глибина: 7,6 мм Вага: 112 г Колір: Сірий Гарантійний термін: 1 рік Країна виробництва: Китай</p>\r\n\r\n<p>Phone mobile</p>\r\n', '<p>Phone mobilePhone mobile</p>\r\n', '2016-03-06 13:33:34', 1, 1, 1, 1, 14, 'mobile', 6, 7),
(15, 'Ноутбук Lenovo 100-15 IBY', 6588, 'Lenovo ', '', '', 'Характеристики та комплектація товару можуть змінюватися виробником без попередження. Магазин не несе відповідальність за зміни, внесені виробником.', 'N_lenovo_1.JPG', '3313312312', 'Діагональ екрану: 15,6''''\\nРоздільна здатність екрану: HD 1366x768\\nПокриття екрану: Глянцеве\\nСенсорний екран: Ні', '56466654', '2016-03-09 11:41:40', 1, 1, 0, 1, 29, 'notebook', 26, 16),
(72, 'IPHONE 6E', 43434543, 'tyu', 'sfsd fsdf asd', ' fsadf sd fsadf sdaf sdf sd', '<p>dgsd gd sdf g</p>\r\n', 'mobile-7227.jpg', '<p>&nbsp;sd gf gsd gfd gdf gdf gsd&nbsp;</p>\r\n', '<p>&nbsp;sdgf gsdf gfds gfffffffffffffffffff</p>\r\n', '<p>gggggggggggggg &nbsp;ggggggggggg</p>\r\n', '0000-00-00 00:00:00', 0, 1, 0, 1, 5, 'notepad', 0, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `table_reviews`
--

CREATE TABLE IF NOT EXISTS `table_reviews` (
  `reviews_id` int(11) NOT NULL AUTO_INCREMENT,
  `products_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `good_reviews` text NOT NULL,
  `bad_reviews` text NOT NULL,
  `comment` text NOT NULL,
  `date` datetime NOT NULL,
  `moderat` int(11) NOT NULL,
  PRIMARY KEY (`reviews_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=12 ;

--
-- Дамп данных таблицы `table_reviews`
--

INSERT INTO `table_reviews` (`reviews_id`, `products_id`, `name`, `good_reviews`, `bad_reviews`, `comment`, `date`, `moderat`) VALUES
(1, 72, 'Сергій', 'Хороший телефон', 'Поганий телефон', 'телефона купив 1 рік тому, всім задоволений окрів камери. телефона купив 1 рік тому, всім задоволений окрів камери. телефона купив 1 рік тому, всім задоволений окрів камери.', '2016-11-22 00:00:00', 1),
(2, 12, 'Петро', 'Так собі фон )', 'Глючить звязок, мушу лісти на сосну.', 'Нікому не можу порадити', '2016-12-16 00:00:00', 0),
(4, 12, 'івіваів', 'іпва', 'впівапв', 'івапві', '2017-01-17 20:08:35', 1),
(5, 72, 'впівапва', 'івпа', 'віпва', 'івпапів', '2017-01-17 20:10:32', 0),
(11, 30, 'Вася', 'Телефон бомба', 'Гівно', 'Дешево і сердито!', '2017-01-17 20:49:50', 1),
(10, 72, 'Сергій Пупкін', 'аоідлфао іфвлдао іфлд', 'оідлао ілдаоів лдао', 'аівофадфіовад олфі', '2017-01-17 20:46:13', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `uploads_images`
--

CREATE TABLE IF NOT EXISTS `uploads_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `products_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=90 ;

--
-- Дамп данных таблицы `uploads_images`
--

INSERT INTO `uploads_images` (`id`, `products_id`, `image`) VALUES
(41, 14, 'mobile-14295.jpg'),
(2, 14, 'Philips_rio_1.jpg'),
(3, 16, 'samsung_GT_1.jpg'),
(4, 16, 'samsung_GT_2.jpg'),
(5, 16, 'samsung_GT_3.jpg'),
(6, 16, 'samsung_GT_4.jpg'),
(7, 16, 'samsung_GT_5.jpg'),
(8, 16, 't_Samsung_tab_3.JPG'),
(9, 14, 'Philips_rio_3.jpg'),
(12, 15, 'N_lenovo_1.jpg'),
(13, 15, 'N_lenovo_2.jpg'),
(14, 15, 'N_lenovo_3.jpg'),
(15, 15, 'N_lenovo_4.jpg'),
(16, 15, 'N_lenovo_5.jpg'),
(17, 15, 'N_lenovo_6.jpg'),
(18, 0, 'mobile-0247.jpg'),
(19, 0, 'mobile-0153.jpg'),
(20, 0, 'mobile-0202.jpg'),
(21, 0, 'mobile-0216.jpg'),
(22, 0, 'mobile-0118.jpg'),
(23, 0, 'mobile-0145.jpg'),
(24, 0, 'mobile-0107.jpg'),
(25, 24, 'mobile-24126.jpg'),
(26, 24, 'mobile-24244.jpg'),
(27, 24, 'mobile-24191.jpg'),
(28, 24, 'mobile-24162.jpg'),
(29, 25, 'mobile-25208.jpg'),
(30, 25, 'mobile-25176.jpg'),
(31, 25, 'mobile-25160.jpg'),
(32, 25, 'mobile-25114.jpg'),
(33, 30, 'mobile-30167.jpg'),
(42, 14, 'mobile-14149.jpg'),
(35, 30, 'mobile-30100.jpg'),
(36, 30, 'mobile-30260.jpg'),
(37, 30, 'mobile-30297.jpg'),
(38, 30, 'mobile-30244.jpg'),
(43, 53, 'mobile-53275.jpg'),
(44, 53, 'mobile-53205.jpg'),
(45, 53, 'mobile-53228.jpg'),
(46, 53, 'mobile-53248.jpg'),
(47, 53, 'mobile-53122.jpg'),
(48, 54, 'mobile-54215.jpg'),
(49, 54, 'mobile-54248.jpg'),
(50, 55, 'mobile-55203.jpg'),
(51, 55, 'mobile-55124.jpg'),
(52, 56, 'mobile-56211.jpg'),
(53, 56, 'mobile-56270.jpg'),
(54, 57, 'mobile-57209.jpg'),
(55, 57, 'mobile-57205.jpg'),
(56, 58, 'mobile-58240.jpg'),
(57, 58, 'mobile-58266.jpg'),
(58, 59, 'mobile-59207.jpg'),
(59, 59, 'mobile-59275.jpg'),
(60, 60, 'mobile-60185.jpg'),
(61, 60, 'mobile-60157.jpg'),
(62, 61, 'mobile-61203.jpg'),
(63, 61, 'mobile-61210.jpg'),
(64, 62, 'mobile-62159.jpg'),
(65, 62, 'mobile-62300.jpg'),
(66, 62, 'mobile-62115.jpg'),
(67, 62, 'mobile-62266.jpg'),
(68, 62, 'mobile-62169.jpg'),
(69, 68, 'mobile-68168.jpg'),
(70, 70, 'mobile-70297.jpg'),
(71, 70, 'mobile-70260.jpg'),
(72, 70, 'mobile-70220.jpg'),
(73, 70, 'mobile-70189.jpg'),
(74, 71, 'mobile-71158.jpg'),
(75, 71, 'mobile-71274.jpg'),
(76, 71, 'mobile-71243.jpg'),
(77, 71, 'mobile-71248.jpg'),
(78, 72, 'mobile-72258.jpg'),
(83, 72, 'mobile-72284.jpg'),
(84, 72, 'mobile-72190.jpg'),
(87, 72, 'mobile-72246.jpg'),
(88, 72, 'mobile-72217.jpg'),
(89, 72, 'mobile-72124.jpg');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
