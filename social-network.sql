-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 31 2022 г., 15:14
-- Версия сервера: 8.0.19
-- Версия PHP: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `social-network`
--

-- --------------------------------------------------------

--
-- Структура таблицы `socials`
--

CREATE TABLE `socials` (
  `id` int NOT NULL,
  `vk` varchar(255) DEFAULT NULL,
  `tg` varchar(255) DEFAULT NULL,
  `inst` varchar(255) DEFAULT NULL,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `socials`
--

INSERT INTO `socials` (`id`, `vk`, `tg`, `inst`, `user_id`) VALUES
(1, 'asd', 'asd', 'asd', 15),
(2, NULL, NULL, NULL, 17),
(3, NULL, NULL, NULL, 18),
(4, NULL, NULL, NULL, 19),
(5, NULL, NULL, NULL, 20),
(6, NULL, NULL, NULL, 21),
(7, NULL, NULL, NULL, 22),
(8, NULL, NULL, NULL, 23),
(9, NULL, NULL, NULL, 24);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `role` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `avatar`, `status`, `role`) VALUES
(15, 'maks@mail.com', '$2y$10$4xpKigbt9y7MXGYSxMHGN.0al59gjt1POHvjL0taFhPkDXVbFmMPm', NULL, NULL, 'admin'),
(17, 'john@example.com', '$2y$10$M3Q4je7Ff/sTvhzgO24WCevfuByVhYeuQSKDebyBOxDJcCQl2/E1i', 'img/demo/avatars/avatar-b.png', 'Онлайн', 'user'),
(18, 'Alita@smartadminwebapp.com', '$2y$10$03R9YNdijVxeot67KYy5nO/HystNqFCd34nZ0w9NazRzFw00yMF3y', 'img/demo/avatars/avatar-c.png', 'Отошел', 'user'),
(19, 'john.cook@smartadminwebapp.com', '$2y$10$YiYUK.auT/vMAIvNsGf1WOsc9e6btlIqXaQeT4VGm72IuSdDxjJpi', 'img/demo/avatars/avatar-e.png', '1', 'user'),
(20, 'jim.ketty@smartadminwebapp.com', '$2y$10$AGsk44yrXxEoMov2YTUSRuDlN8Sbj5pV2CdYpradnbxPULdZf5z/G', 'img/demo/avatars/avatar-k.png', '1', 'user'),
(21, 'john.oliver@smartadminwebapp.com', '$2y$10$XlNASfKvrzJpW/7T9kIPKOsgfLB/JqazFo0Vpm7ihX2F6C5j5Ap9.', 'img/demo/avatars/avatar-g.png', '1', 'user'),
(22, 'sarah.mcbrook@smartadminwebapp.com', '$2y$10$btYKG7T7ANfdRJmWYpQ5ze/7iImEtZ6MGD7qLbwARzdlIynkG2Kui', 'img/demo/avatars/avatar-h.png', '1', 'user'),
(23, 'jimmy.fallan@smartadminwebapp.com', '$2y$10$2dDH4GffsFXMkje/gpukY.ucYJjFCYGBhjjH/UvGTbz9EyEuaKj56', 'img/demo/avatars/avatar-i.png', 'Не беспокоить', 'user'),
(24, 'arica.grace@smartadminwebapp.com', '$2y$10$XjrZV2/ojN.TQP7o3WuT/uHO1oA1onUjXiWQEk6ts5guzQbGoVztG', 'img/demo/avatars/avatar-j.png', '1', 'user');

-- --------------------------------------------------------

--
-- Структура таблицы `users_profile`
--

CREATE TABLE `users_profile` (
  `id` int NOT NULL,
  `username` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `phone` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `address` varchar(355) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `job` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users_profile`
--

INSERT INTO `users_profile` (`id`, `username`, `phone`, `address`, `job`, `user_id`) VALUES
(1, 'Иван иванов', '8 888 8888 88', 'Восточные Королевства, Штормград', 'Marlin Веб-разработчик', 17),
(3, 'Alita Gray', '13134611347', '134 Hamtrammac, Detroit, MI, 48314, USA', 'Project Manager, Gotbootstrap Inc', 18),
(4, 'Dr. John Cook PhD', '13137791347', '55 Smyth Rd, Detroit, MI, 48341, USA', 'Human Resources, Gotbootstrap Inc.', 19),
(7, 'Jim Ketty', '13137793314', '134 Tasy Rd, Detroit, MI, 48212, USA', 'Staff Orgnizer, Gotbootstrap Inc.', 20),
(8, 'Dr. John Oliver', '13137798134', '134 Gallery St, Detroit, MI, 46214, USA', 'Oncologist, Gotbootstrap Inc.', 21),
(11, 'Sarah McBrook', '13137797613', '13 Jamie Rd, Detroit, MI, 48313, USA', 'Xray Division, Gotbootstrap Inc.', 22),
(12, 'Jimmy Fellan', '13137794314', '55 Smyth Rd, Detroit, MI, 48341, USA', 'Accounting, Gotbootstrap Inc.', 23),
(13, 'Arica Grace', '13137793347', '798 Smyth Rd, Detroit, MI, 48341, USA', 'Accounting, Gotbootstrap Inc.', 24),
(26, 'Maks', '79994445522', 'ВВВ Ленинград точка ру', 'Frontend', 15);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `socials`
--
ALTER TABLE `socials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users_profile`
--
ALTER TABLE `users_profile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `socials`
--
ALTER TABLE `socials`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT для таблицы `users_profile`
--
ALTER TABLE `users_profile`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `socials`
--
ALTER TABLE `socials`
  ADD CONSTRAINT `socials_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `users_profile`
--
ALTER TABLE `users_profile`
  ADD CONSTRAINT `users_profile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
