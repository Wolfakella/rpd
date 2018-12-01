-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 01 2018 г., 06:53
-- Версия сервера: 5.6.38
-- Версия PHP: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `rpd`
--

-- --------------------------------------------------------

--
-- Структура таблицы `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `short_name` varchar(255) DEFAULT NULL,
  `faculty_id` int(11) DEFAULT NULL,
  `secretary_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `department`
--

INSERT INTO `department` (`id`, `name`, `short_name`, `faculty_id`, `secretary_id`) VALUES
(1, 'Кафедра вычислительной механики и информационных технологий', 'ВМиИТ', 1, 2),
(2, 'Кафедра компьютерной топологии и алгебры', 'КТиА', 1, NULL),
(4, 'Кафедра теории управления и оптимизации', 'ТУиО', 1, NULL),
(5, 'Кафедра вычислительной математики', 'ВычМат', 1, NULL),
(19, 'Кафедра истории России', 'Историки', 1, NULL),
(35, 'Кафедра математических методов в экономике', 'ММЭ', 2, NULL),
(36, 'Кафедра социальной работы и социологии', 'СРиС', 2, NULL),
(37, 'Кафедра учета и финансов', 'УиФ', 2, NULL),
(38, 'Кафедра экономической теории и регионального развития', 'ЭТиРР', 2, NULL),
(45, 'Кафедра теории и истории государства и права', 'Юристы', 1, NULL),
(48, 'Кафедра общей и профессиональной педагогики', 'КОПП', 1, NULL),
(53, 'Кафедра делового иностранного языка', 'ИнЯз', 1, NULL),
(54, 'Кафедра философии', 'Философы', 1, NULL),
(55, 'Кафедра физического воспитания и спорта', 'ФВиС', 1, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `faculty`
--

CREATE TABLE `faculty` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `short_name` varchar(255) DEFAULT NULL,
  `secretary_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `faculty`
--

INSERT INTO `faculty` (`id`, `name`, `short_name`, `secretary_id`) VALUES
(1, 'Математический факультет', 'МФ', NULL),
(2, 'Экономический факультет', 'ЭФ', NULL),
(3, 'Институт экономики отраслей, бизнеса и администрирования', 'ИЭкОБиА', NULL),
(4, 'Факультет управления', 'УФ', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1507305230),
('m130524_201442_init', 1508257986),
('m171007_091903_create_faculty_table', 1508257986),
('m171007_092314_create_department_table', 1508257988),
('m171007_092554_create_plan_table', 1515783942),
('m171007_092714_create_teacher_table', 1515869018),
('m171007_092818_create_program_table', 1516302196),
('m180316_171458_add_secretary_id_column_to_faculty_table', 1543634554),
('m180316_171753_add_secretary_id_column_to_department_table', 1543634554);

-- --------------------------------------------------------

--
-- Структура таблицы `plan`
--

CREATE TABLE `plan` (
  `id` int(11) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `profile` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `year` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `plan`
--

INSERT INTO `plan` (`id`, `code`, `title`, `profile`, `type`, `link`, `department_id`, `year`) VALUES
(38, '38.03.01', 'Экономика', 'Мировая экономика и международный бизнес', 'ОЧНАЯ', '/var/www/rpd/common/uploads/38.03.01_ ЭК_МЭ_О_2017 .plm.xml', 35, 2017);

-- --------------------------------------------------------

--
-- Структура таблицы `program`
--

CREATE TABLE `program` (
  `id` int(11) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `link` varchar(1000) DEFAULT NULL,
  `plan_id` int(11) DEFAULT NULL,
  `index` int(11) NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `program`
--

INSERT INTO `program` (`id`, `code`, `name`, `link`, `plan_id`, `index`, `department_id`, `teacher_id`) VALUES
(279, 'Б1.Б.1', 'Иностранный язык', NULL, 38, 0, 53, NULL),
(280, 'Б1.Б.2', 'Философия', NULL, 38, 1, 54, NULL),
(281, 'Б1.Б.3', 'История', NULL, 38, 2, 19, NULL),
(282, 'Б1.Б.4', 'Право', NULL, 38, 3, 45, NULL),
(283, 'Б1.Б.5', 'Правовое обеспечение хозяйственной деятельности', NULL, 38, 4, 37, 1),
(284, 'Б1.Б.6', 'Психология', NULL, 38, 5, 48, NULL),
(285, 'Б1.Б.7', 'Математический анализ', NULL, 38, 6, 5, NULL),
(286, 'Б1.Б.8', 'Теория вероятностей и математическая статистика', NULL, 38, 7, 4, NULL),
(287, 'Б1.Б.9', 'Линейная алгебра', NULL, 38, 8, 2, NULL),
(288, 'Б1.Б.10', 'Методы оптимальных решений', NULL, 38, 9, 35, 1),
(289, 'Б1.Б.11', 'Микроэкономика', NULL, 38, 10, 38, NULL),
(290, 'Б1.Б.12', 'Макроэкономика', NULL, 38, 11, 38, NULL),
(291, 'Б1.Б.13', 'Эконометрика', NULL, 38, 12, 35, 2),
(292, 'Б1.Б.14', 'Статистика', NULL, 38, 13, 35, 2),
(293, 'Б1.Б.15', 'Безопасность жизнедеятельности', NULL, 38, 14, 55, NULL),
(294, 'Б1.Б.16', 'Модуль \"Бухгалтерский учет и анализ\"', NULL, 38, 15, NULL, NULL),
(295, 'Б1.Б.16.1', 'Основы бухгалтерского учета и отчетности', NULL, 38, 16, 37, 2),
(296, 'Б1.Б.16.2', 'Основы экономического анализа', NULL, 38, 17, 37, 2),
(297, 'Б1.Б.16.3', 'Основы аудита', NULL, 38, 18, 37, NULL),
(298, 'Б1.Б.17', 'Финансы', NULL, 38, 19, 37, NULL),
(299, 'Б1.Б.18', 'История экономических учений', NULL, 38, 20, 38, NULL),
(300, 'Б1.Б.19', 'Маркетинг', NULL, 38, 21, 38, NULL),
(301, 'Б1.Б.20', 'Менеджмент', NULL, 38, 22, 38, NULL),
(302, 'Б1.Б.21', 'Деньги, кредит, банки', NULL, 38, 23, 37, NULL),
(303, 'Б1.Б.22', 'Экономика труда', NULL, 38, 24, 38, NULL),
(304, 'Б1.Б.23', 'Физическая_культура', NULL, 38, 25, 55, NULL),
(305, 'Б1.В.1', 'Информационная культура', NULL, 38, 26, 35, 1),
(306, 'Б1.В.2', 'Русский язык и культура речи', NULL, 38, 27, NULL, NULL),
(307, 'Б1.В.3', 'Социология', NULL, 38, 28, 36, NULL),
(308, 'Б1.В.4', 'Введение в экономику', NULL, 38, 29, 38, NULL),
(309, 'Б1.В.5', 'Информационные технологии в экономике', NULL, 38, 30, 35, 2),
(310, 'Б1.В.6', 'Налоги и налогообложение', NULL, 38, 31, 37, NULL),
(311, 'Б1.В.7', 'Экономика организаций', NULL, 38, 32, 38, NULL),
(312, 'Б1.В.8', 'Рынок ценных бумаг', NULL, 38, 33, 37, NULL),
(313, 'Б1.В.9', 'Экономическая география и регионалистика', NULL, 38, 34, 38, NULL),
(314, 'Б1.В.10', 'Корпоративные финансы', NULL, 38, 35, 37, NULL),
(315, 'Б1.В.11', 'Дисциплины профиля', NULL, 38, 36, NULL, NULL),
(316, 'Б1.В.11.1', 'Иностранный язык (профессиональный)', NULL, 38, 37, 53, NULL),
(317, 'Б1.В.11.2', 'Организация внешнеэкономической деятельности и экономическая безопасность', NULL, 38, 38, 38, NULL),
(318, 'Б1.В.11.3', 'Международные стандарты учета и финансовой отчетности', NULL, 38, 39, 37, NULL),
(319, 'Б1.В.11.4', 'Стратегический менеджмент', NULL, 38, 40, 38, NULL),
(320, 'Б1.В.11.5', 'Инвестиции', NULL, 38, 41, 37, NULL),
(321, 'Б1.В.11.6', 'Современные концепции экономики', NULL, 38, 42, 38, NULL),
(322, 'Б4.Б.1', 'Прикладная физическая культура', NULL, 38, 43, 55, NULL),
(323, 'Б1.ДВ1.1', 'Ценообразование', NULL, 38, 44, 37, NULL),
(324, 'Б1.ДВ1.2', 'Ценовая политика фирмы', NULL, 38, 45, 37, NULL),
(325, 'Б1.ДВ2.1', 'Профессиональная этика', NULL, 38, 46, NULL, NULL),
(326, 'Б1.ДВ2.2', 'Культура делового общения', NULL, 38, 47, 38, NULL),
(327, 'Б1.ДВ3.1', 'Математические методы анализа в экономике', NULL, 38, 48, 35, 1),
(328, 'Б1.ДВ3.2', 'Экономико-математическое моделирование', NULL, 38, 49, 35, 2),
(329, 'Б1.ДВ4.1', 'Инвестиционный климат и иностранные инвестиции', NULL, 38, 50, 37, NULL),
(330, 'Б1.ДВ4.2', 'Международный рынок капитала', NULL, 38, 51, 37, NULL),
(331, 'Б1.ДВ5.1', 'Институциональная экономика', NULL, 38, 52, 38, NULL),
(332, 'Б1.ДВ5.2', 'Государственное регулирование внешнеэкономической деятельности', NULL, 38, 53, 38, NULL),
(333, 'Б1.ДВ6.1', 'Мировая экономика и международные экономические отношения', NULL, 38, 54, 38, NULL),
(334, 'Б1.ДВ6.2', 'Экономика мирохозяйственных связей', NULL, 38, 55, 38, NULL),
(335, 'Б1.ДВ7.1', 'Национальная и региональная экономика в системе международного разделения труда', NULL, 38, 56, 38, NULL),
(336, 'Б1.ДВ7.2', 'Экономические стратегии развития', NULL, 38, 57, 38, NULL),
(337, 'Б1.ДВ8.1', 'Страхование', NULL, 38, 58, 37, NULL),
(338, 'Б1.ДВ8.2', 'Международная деятельность в сфере страхования', NULL, 38, 59, 37, NULL),
(339, 'Б1.ДВ9.1', 'Международные валютно-кредитные отношения', NULL, 38, 60, 38, NULL),
(340, 'Б1.ДВ9.2', 'Мировые финансовые рынки и финансовые операции', NULL, 38, 61, 38, NULL),
(341, 'Б1.ДВ10.1', 'Экономика общественного сектора', NULL, 38, 62, 38, NULL),
(342, 'Б1.ДВ10.2', 'Системный анализ экономических явлений и процессов', NULL, 38, 63, 38, NULL),
(343, 'Б1.ДВ11.1', 'Международная логистика', NULL, 38, 64, 35, 2),
(344, 'Б1.ДВ11.2', 'Институциональные основы международного бизнеса', NULL, 38, 65, 38, NULL),
(345, 'Б1.ДВ12.1', 'Международный менеджмент', NULL, 38, 66, 38, NULL),
(346, 'Б1.ДВ12.2', 'Международный маркетинг', NULL, 38, 67, 38, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `teacher`
--

CREATE TABLE `teacher` (
  `id` int(11) NOT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `teacher`
--

INSERT INTO `teacher` (`id`, `lastname`, `middlename`, `firstname`, `department_id`, `user_id`) VALUES
(1, 'Клейман', 'Владимировна', 'Анна', 38, 2),
(2, 'Ольховский', 'Александрович', 'Николай', 35, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `email`, `auth_key`, `password_hash`, `password_reset_token`, `status`, `created_at`, `updated_at`) VALUES
(2, 'kleyman.av@csu.ru', 'll3sxw8l9iQW8z7y2o9FH2rvCQrVL5k0', '$2y$12$7W1sotVYTkm/ONSQTgenoOlkubPclFQ5rqLis1haX3lfUvPcIntPC', NULL, 10, 1508265395, 1508265395),
(3, 'nikolay.olkhovsky@gmail.com', 'wwQZEmGZV-F9K1yV8TGVliIBu4hWDYjz', '$2y$12$2DDXzIac24iV1wG5M9vP2ulEZHosFx3YP2Wk09UQf545ie.A98/ju', NULL, 10, 1515686244, 1515686244);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `idx-department-faculty_id` (`faculty_id`),
  ADD KEY `idx-department-secretary_id` (`secretary_id`);

--
-- Индексы таблицы `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `idx-faculty-secretary_id` (`secretary_id`);

--
-- Индексы таблицы `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `plan`
--
ALTER TABLE `plan`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `program`
--
ALTER TABLE `program`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-program-plan_id` (`plan_id`),
  ADD KEY `idx-program-department_id` (`department_id`),
  ADD KEY `idx-program-teacher_id` (`teacher_id`);

--
-- Индексы таблицы `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `idx-teacher-department_id` (`department_id`),
  ADD KEY `idx-teacher-user_id` (`user_id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT для таблицы `faculty`
--
ALTER TABLE `faculty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `plan`
--
ALTER TABLE `plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT для таблицы `program`
--
ALTER TABLE `program`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=347;

--
-- AUTO_INCREMENT для таблицы `teacher`
--
ALTER TABLE `teacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `department`
--
ALTER TABLE `department`
  ADD CONSTRAINT `fk-department-faculty_id` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk-department-secretary_id` FOREIGN KEY (`secretary_id`) REFERENCES `teacher` (`id`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `faculty`
--
ALTER TABLE `faculty`
  ADD CONSTRAINT `fk-faculty-secretary_id` FOREIGN KEY (`secretary_id`) REFERENCES `teacher` (`id`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `program`
--
ALTER TABLE `program`
  ADD CONSTRAINT `fk-program-department_id` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk-program-plan_id` FOREIGN KEY (`plan_id`) REFERENCES `plan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-program-teacher_id` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`id`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `teacher`
--
ALTER TABLE `teacher`
  ADD CONSTRAINT `fk-teacher-department_id` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk-teacher-user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
