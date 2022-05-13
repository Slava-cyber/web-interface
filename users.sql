-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 13 2022 г., 03:44
-- Версия сервера: 5.7.29
-- Версия PHP: 7.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `users`
--

-- --------------------------------------------------------

--
-- Структура таблицы `admin`
--

CREATE TABLE `admin` (
  `login` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `admin`
--

INSERT INTO `admin` (`login`) VALUES
('admin');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `login` varchar(255) DEFAULT NULL,
  `password` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `birth_date`, `gender`, `login`, `password`) VALUES
(18, 'test', 'task', '2022-05-25', 'Мужской', 'test1', 'b0baee9d279d34fa1dfd71aadb908c3f'),
(19, 'admin', 'admin', '2022-05-12', 'Мужской', 'admin', '21232f297a57a5a743894a0e4a801fc3'),
(21, 'Тестовое', 'Задание', '2011-06-16', 'Мужской', 'Тест', 'b0baee9d279d34fa1dfd71aadb908c3f'),
(23, 'Иван', 'Иванов', '2022-05-13', 'Мужской', 'Ivan123', 'b0baee9d279d34fa1dfd71aadb908c3f'),
(26, 'Василий', 'Петрович', '2022-05-05', 'Мужской', 'ProstoVasya', 'b0baee9d279d34fa1dfd71aadb908c3f'),
(27, 'Марья', 'Петровна', '2022-05-01', 'Женский', 'Masha777', 'b0baee9d279d34fa1dfd71aadb908c3f'),
(29, 'Потенциальный', 'Админ', '2022-05-14', 'Женский', 'admin2', 'b0baee9d279d34fa1dfd71aadb908c3f'),
(38, 'Новый', 'Пользователь', '2022-05-04', 'Мужской', 'newuser', 'b0baee9d279d34fa1dfd71aadb908c3f'),
(39, 'Фантазии', 'Не хватает', '2022-05-02', 'Женский', 'test2', 'b0baee9d279d34fa1dfd71aadb908c3f');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `admin`
--
ALTER TABLE `admin`
  ADD UNIQUE KEY `login` (`login`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
