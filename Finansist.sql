-- phpMyAdmin SQL Dump
-- version 4.4.15.7
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Фев 05 2018 г., 07:32
-- Версия сервера: 5.5.50
-- Версия PHP: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `finansist`
--

-- --------------------------------------------------------

--
-- Структура таблицы `calc_limit_dates`
--

CREATE TABLE IF NOT EXISTS `calc_limit_dates` (
  `Id` tinyint(2) NOT NULL,
  `Date_calc_limit` date NOT NULL,
  `GSZ_Id` tinyint(2) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `calc_limit_dates`
--

INSERT INTO `calc_limit_dates` (`Id`, `Date_calc_limit`, `GSZ_Id`) VALUES
(1, '2017-09-06', 1),
(4, '2017-11-06', 2),
(5, '2018-01-28', 7);

-- --------------------------------------------------------

--
-- Структура таблицы `company`
--

CREATE TABLE IF NOT EXISTS `company` (
  `Id` int(10) unsigned NOT NULL,
  `INN` bigint(20) NOT NULL,
  `GSZ_Id` tinyint(2) NOT NULL,
  `User_Id` int(10) NOT NULL,
  `Name` char(150) NOT NULL,
  `OPF_Id` tinyint(2) NOT NULL,
  `SNO_Id` tinyint(2) NOT NULL,
  `Date_Registr` date DEFAULT NULL,
  `Date_Begin_Work` date DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `company`
--

INSERT INTO `company` (`Id`, `INN`, `GSZ_Id`, `User_Id`, `Name`, `OPF_Id`, `SNO_Id`, `Date_Registr`, `Date_Begin_Work`) VALUES
(1, 1234567123, 1, 1, 'ООО "Рога и копыта"', 2, 1, '2017-11-06', '2017-11-06'),
(4, 1234567899, 1, 0, 'ПАО "Друг 1"', 4, 4, '2017-01-04', '2017-01-04'),
(6, 1122334455, 2, 0, 'ООО Синдерелла', 2, 1, '2017-05-03', '2017-05-03'),
(10, 123123121212, 1, 0, 'ИП "Ленин"', 1, 1, '2016-01-01', '2016-01-01'),
(15, 1234567888, 2, 0, 'Компания "Друг"', 2, 3, NULL, NULL),
(17, 123456789012, 7, 0, 'Компания &quot;Друг&quot;', 1, 2, '2016-05-04', '2016-05-04'),
(18, 123456789011, 2, 0, 'ИП "Ленин"', 1, 1, '2017-01-13', '2017-07-07'),
(20, 1234512345, 2, 0, 'Компания "Компания"', 3, 3, '2017-10-02', '2017-10-02'),
(28, 1111112222, 2, 0, 'Компашка', 2, 5, '2017-04-05', '2017-07-06');

-- --------------------------------------------------------

--
-- Структура таблицы `Corp_Balance_Article`
--

CREATE TABLE IF NOT EXISTS `Corp_Balance_Article` (
  `Id` tinyint(3) unsigned NOT NULL,
  `Section_Id` tinyint(2) unsigned NOT NULL COMMENT 'FK',
  `Code` char(5) NOT NULL COMMENT 'Код статьи',
  `Has_Children` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1 - есть подкоды (вычисляемый), 0 - нет',
  `Parent_Code` char(5) DEFAULT '0' COMMENT 'Код статьи-родителя',
  `Description` char(100) NOT NULL,
  `Is_Sum_Section` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 - сумма раздела',
  `Is_Sum_Part` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 - сумма актива или пассива',
  `Value` float NOT NULL DEFAULT '0' COMMENT 'Сумма по статье баланса'
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8 COMMENT='Статьи баланса для организация';

--
-- Дамп данных таблицы `Corp_Balance_Article`
--

INSERT INTO `Corp_Balance_Article` (`Id`, `Section_Id`, `Code`, `Has_Children`, `Parent_Code`, `Description`, `Is_Sum_Section`, `Is_Sum_Part`, `Value`) VALUES
(1, 1, '1110', 1, '0', 'Нематериальные активы', 0, 0, 0),
(2, 1, '11101', 0, '1110', 'Нематериальные активы в организации', 0, 0, 0),
(3, 1, '11102', 0, '1110', 'Приобретение нематериальных активов', 0, 0, 0),
(4, 1, '1120', 1, '0', 'Результаты исследований и разработок', 0, 0, 0),
(5, 1, '11201', 0, '1120', 'Расходы на научно-исследовательские, опытно-конструкторские и технологические работы', 0, 0, 0),
(6, 1, '11202', 0, '1120', 'Выполнение научно-исследовательских, опытно-конструкторских и технологических работ', 0, 0, 0),
(7, 1, '1130', 0, '0', 'Нематериальные поисковые активы', 0, 0, 0),
(8, 1, '1140', 0, '0', 'Материальные поисковые активы', 0, 0, 0),
(9, 1, '1150', 1, '0', 'Основные средства', 0, 0, 0),
(10, 1, '11501', 0, '1150', 'Основные средства в организации', 0, 0, 0),
(11, 1, '11502', 0, '9', 'Объекты недвижимости, права собственности на которые не зарегистрированы', 0, 0, 0),
(12, 1, '11503', 0, '1150', 'Оборудование к установке', 0, 0, 0),
(13, 1, '11504', 0, '1150', 'Приобретение земельных участков', 0, 0, 0),
(14, 1, '11505', 0, '1150', 'Приобретение объектов природопользования', 0, 0, 0),
(15, 1, '11506', 0, '1150', 'Строительство объектов основных средств', 0, 0, 0),
(16, 1, '11507', 0, '1150', 'Приобретение объектов основных средств', 0, 0, 0),
(17, 1, '11508', 0, '1150', 'Расходы будущих периодов', 0, 0, 0),
(18, 1, '11509', 0, '1150', 'Арендованное имущество', 0, 0, 0),
(19, 1, '1160', 1, '0', 'Доходные вложения в материальные ценности', 0, 0, 0),
(20, 1, '11601', 0, '1160', 'Материальные ценности в организации', 0, 0, 0),
(21, 1, '11602', 0, '1160', 'Материальные ценности предоставленные во временное владение и пользование', 0, 0, 0),
(22, 1, '11603', 0, '1160', 'Материальные ценности предоставленные во временное пользование', 0, 0, 0),
(23, 1, '11604', 0, '1160', 'Прочие доходные вложения', 0, 0, 0),
(24, 1, '1170', 0, '0', 'Финансовые вложения', 0, 0, 0),
(25, 1, '1180', 0, '0', 'Финансовые вложения', 0, 0, 0),
(26, 1, '1190', 1, '0', 'Прочие внеоборотные активы', 0, 0, 0),
(27, 1, '11901', 0, '1190', 'Перевод молодняка животных в основное стадо', 0, 0, 0),
(28, 1, '11902', 0, '1190', 'Приобретение взрослых животных', 0, 0, 0),
(29, 1, '11903', 0, '1190', 'Расходы будущих периодов', 0, 0, 0),
(30, 1, '1100', 0, '0', 'Итого по разделу I', 1, 0, 0),
(31, 2, '1210', 1, '0', 'Запасы', 0, 0, 0),
(32, 2, '12101', 0, '1210', 'Материалы', 0, 0, 0),
(33, 2, '12102', 0, '1210', 'Товары', 0, 0, 0),
(34, 2, '12103', 0, '1210', 'Готовая продукция', 0, 0, 0),
(35, 2, '1220', 0, '0', 'Налог на добавленную стоимость по приобретенным ценностям', 0, 0, 0),
(36, 2, '1230', 1, '0', 'Дебиторская задолженность', 0, 0, 0),
(37, 2, '12301', 0, '1230', 'Расчеты с поставщиками и подрядчиками', 0, 0, 0),
(38, 2, '12302', 0, '1230', 'Расчеты с покупателями и заказчиками', 0, 0, 0),
(39, 2, '12303', 0, '1230', 'Расчеты с подотчетными лицами', 0, 0, 0),
(40, 2, '12304', 0, '1230', 'Расчеты с персоналом по прочим операциям', 0, 0, 0),
(41, 2, '12305', 0, '1230', 'Расчеты с разными дебиторами и кредиторами', 0, 0, 0),
(42, 2, '12306', 0, '1230', 'Расходы будущих периодов', 0, 0, 0),
(43, 2, '12307', 0, '1230', 'Оценочные обязательства', 0, 0, 0),
(44, 2, '1240', 0, '0', 'Финансовые вложения (за исключением денежных эквивалентов)', 0, 0, 0),
(45, 2, '1250', 1, '0', 'Денежные средства и денежные эквиваленты', 0, 0, 0),
(46, 2, '12501', 0, '1250', 'Касса организации', 0, 0, 0),
(47, 2, '12502', 0, '1250', 'Расчетные счета', 0, 0, 0),
(48, 2, '1260', 0, '0', 'Прочие оборотные активы', 0, 0, 0),
(49, 2, '1200', 0, '0', 'Итого по разделу II', 1, 0, 0),
(50, 6, '1600', 0, '0', 'БАЛАНС', 0, 1, 0),
(51, 3, '1310', 0, '0', 'Уставный капитал (складочный капитал, уставный фонд, вклады товарищей)', 0, 0, 0),
(52, 3, '1320', 0, '0', 'Собственные акции, выкупленные у акционеров', 0, 0, 0),
(53, 3, '1340', 0, '0', 'Переоценка внеоборотных активов', 0, 0, 0),
(54, 3, '1350', 0, '0', 'Добавочный капитал (без переоценки)', 0, 0, 0),
(55, 3, '1360', 0, '0', 'Резервный капитал', 0, 0, 0),
(56, 3, '1370', 0, '0', 'Нераспределенная прибыль (непокрытый убыток)', 0, 0, 0),
(57, 3, '1300', 0, '0', 'Итого по разделу III', 1, 0, 0),
(58, 4, '1410', 0, '0', 'Заемные средства', 0, 0, 0),
(59, 4, '1420', 0, '0', 'Отложенные налоговые обязательства', 0, 0, 0),
(60, 4, '1430', 0, '0', 'Оценочные обязательства', 0, 0, 0),
(61, 4, '1450', 0, '0', 'Прочие обязательства', 0, 0, 0),
(62, 4, '1400', 0, '0', 'Итого по разделу IV', 1, 0, 0),
(63, 5, '1510', 1, '0', 'Заемные средства', 0, 0, 0),
(64, 5, '15101', 0, '1510', 'Краткосрочные займы', 0, 0, 0),
(65, 5, '15102', 0, '1510', 'Проценты по краткосрочным займам', 0, 0, 0),
(66, 5, '1520', 1, '0', 'Кредиторская задолженность', 0, 0, 0),
(67, 5, '15201', 0, '1520', 'Расчеты с поставщиками и подрядчиками', 0, 0, 0),
(68, 5, '15202', 0, '1520', 'Расчеты с покупателями и заказчиками', 0, 0, 0),
(69, 5, '15203', 0, '1520', 'Расчеты по налогам и сборам', 0, 0, 0),
(70, 5, '15204', 0, '1520', 'Расчеты по социальному страхованию и обеспечению', 0, 0, 0),
(71, 5, '15205', 0, '1520', 'Расчеты с персоналом по оплате труда', 0, 0, 0),
(72, 5, '15206', 0, '1520', 'Расчеты с подотчетными лицами', 0, 0, 0),
(73, 5, '15207', 0, '1520', 'Расчеты с персоналом по прочим операциям', 0, 0, 0),
(74, 5, '15208', 0, '1520', 'Задолженность участникам (учредителям) по выплате доходов', 0, 0, 0),
(75, 5, '15209', 0, '1520', 'Расчеты с разными дебиторами и кредиторами', 0, 0, 0),
(76, 5, '1530', 0, '0', 'Доходы будущих периодов', 0, 0, 0),
(77, 5, '1540', 1, '0', 'Оценочные обязательства', 0, 0, 0),
(78, 5, '15401', 0, '1540', 'Оценочные обязательства по вознаграждениям работников', 0, 0, 0),
(79, 5, '15402', 0, '1540', 'Резервы предстоящих расходов прочие', 0, 0, 0),
(80, 5, '1550', 0, '0', 'Прочие обязательства', 0, 0, 0),
(81, 5, '1500', 0, '0', 'Итого по разделу V', 1, 0, 0),
(82, 7, '1700', 0, '0', 'БАЛАНС', 0, 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `Corp_Balance_Section`
--

CREATE TABLE IF NOT EXISTS `Corp_Balance_Section` (
  `Id` tinyint(3) unsigned NOT NULL,
  `Section_Code` tinyint(2) unsigned NOT NULL COMMENT 'Числовой код раздела баланса (1..5)',
  `Balance_Part` tinyint(1) unsigned zerofill NOT NULL COMMENT '1 - актив, 0 - пассив',
  `Description` char(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Разделы баланса для организаций';

-- --------------------------------------------------------

--
-- Структура таблицы `GSZ`
--

CREATE TABLE IF NOT EXISTS `GSZ` (
  `Id` tinyint(2) unsigned NOT NULL,
  `Brief_Name` char(30) DEFAULT NULL,
  `Full_Name` char(150) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `GSZ`
--

INSERT INTO `GSZ` (`Id`, `Brief_Name`, `Full_Name`) VALUES
(1, 'Группа 1', 'Описание первой группы'),
(2, 'Группа 2', 'Описание второй группы связанных заемщиков'),
(7, 'Группа 4 "пппп"', 'впфвыавыаваываы выф');

-- --------------------------------------------------------

--
-- Структура таблицы `OPF`
--

CREATE TABLE IF NOT EXISTS `OPF` (
  `Id` tinyint(2) unsigned NOT NULL,
  `Brief_Name` varchar(10) NOT NULL,
  `Full_Name` varchar(100) NOT NULL,
  `INN_Length` tinyint(2) unsigned NOT NULL,
  `Is_Corporation` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Признак того, что компания является организацией (не ИП). У ИП=0, у других = 1.'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `OPF`
--

INSERT INTO `OPF` (`Id`, `Brief_Name`, `Full_Name`, `INN_Length`, `Is_Corporation`) VALUES
(1, 'ИП', 'Индивидуальный предприниматель', 12, 0),
(2, 'ООО', 'Общество с ограниченной ответственностью', 10, 1),
(3, 'АО', 'Акционерное общество', 10, 1),
(4, 'ПАО', 'Публичное акционерное общество', 10, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `SNO`
--

CREATE TABLE IF NOT EXISTS `SNO` (
  `Id` tinyint(2) unsigned NOT NULL,
  `Brief_Name` varchar(10) NOT NULL,
  `Full_Name` varchar(100) NOT NULL,
  `Cred_Limit_Affect` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `SNO`
--

INSERT INTO `SNO` (`Id`, `Brief_Name`, `Full_Name`, `Cred_Limit_Affect`) VALUES
(1, 'OCНО', 'Общая система налогообложения, уплачивается НДС', 1),
(2, 'УСН/Д-Р', 'Упрощенная система налогообложения, объект обложения - доходы, уменьшенные на величину расходов', 1),
(3, 'УСН/Д', 'Упрощенная система налогообложения, объект обложения - доходы', 1),
(4, 'ЕСХН', 'Единый сельхозналог', 1),
(5, 'ЕНВД', 'Единый налог на вмененный доход', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `User`
--

CREATE TABLE IF NOT EXISTS `User` (
  `Id` int(10) unsigned NOT NULL,
  `Email` varchar(64) NOT NULL,
  `Nickname` varchar(64) NOT NULL,
  `Password` varchar(124) NOT NULL,
  `Full_Name` varchar(80) DEFAULT NULL,
  `Newsletter` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `User`
--

INSERT INTO `User` (`Id`, `Email`, `Nickname`, `Password`, `Full_Name`, `Newsletter`) VALUES
(1, 'abramizsaransk@gmail.com', 'ex2life', '$1$op4.R80.$4LykvO/VJ6j6F5llaRQ0D/', 'Абрамов Сергей', 1),
(2, 'sdfsdf@dsfsdf.sdf', 'lolol', '$1$Bs3.051.$xnsQe8s2PmcRBBoaKbEf8/', 'sdfsdf', 1),
(3, 'dfgfdf@fsfdgf.sdf', 'frog5', '$1$b//.Is..$y.DsB9JdwmNX19oJZMaHO/', 'frog5', 1),
(4, 'frog6@frog6.ty', 'frog6', '$1$Un4.Ni2.$OKggiBJlttYH1tc1HdgLk.', 'frog6frog6', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `users_profiles`
--

CREATE TABLE IF NOT EXISTS `users_profiles` (
  `user_id` int(15) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(35) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users_profiles`
--

INSERT INTO `users_profiles` (`user_id`, `username`, `password`) VALUES
(1, 'klop', '25d55ad283aa400af464c76d713c07ad'),
(2, 'andrey', '25d55ad283aa400af464c76d713c07ad');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `calc_limit_dates`
--
ALTER TABLE `calc_limit_dates`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `GSZ_Id` (`GSZ_Id`);

--
-- Индексы таблицы `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `INN` (`INN`,`GSZ_Id`);

--
-- Индексы таблицы `Corp_Balance_Article`
--
ALTER TABLE `Corp_Balance_Article`
  ADD PRIMARY KEY (`Id`);

--
-- Индексы таблицы `Corp_Balance_Section`
--
ALTER TABLE `Corp_Balance_Section`
  ADD PRIMARY KEY (`Id`);

--
-- Индексы таблицы `GSZ`
--
ALTER TABLE `GSZ`
  ADD PRIMARY KEY (`Id`);

--
-- Индексы таблицы `OPF`
--
ALTER TABLE `OPF`
  ADD PRIMARY KEY (`Id`);

--
-- Индексы таблицы `SNO`
--
ALTER TABLE `SNO`
  ADD PRIMARY KEY (`Id`);

--
-- Индексы таблицы `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`Id`);

--
-- Индексы таблицы `users_profiles`
--
ALTER TABLE `users_profiles`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `calc_limit_dates`
--
ALTER TABLE `calc_limit_dates`
  MODIFY `Id` tinyint(2) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `company`
--
ALTER TABLE `company`
  MODIFY `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT для таблицы `Corp_Balance_Article`
--
ALTER TABLE `Corp_Balance_Article`
  MODIFY `Id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=83;
--
-- AUTO_INCREMENT для таблицы `Corp_Balance_Section`
--
ALTER TABLE `Corp_Balance_Section`
  MODIFY `Id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `GSZ`
--
ALTER TABLE `GSZ`
  MODIFY `Id` tinyint(2) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT для таблицы `OPF`
--
ALTER TABLE `OPF`
  MODIFY `Id` tinyint(2) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `SNO`
--
ALTER TABLE `SNO`
  MODIFY `Id` tinyint(2) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `User`
--
ALTER TABLE `User`
  MODIFY `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `users_profiles`
--
ALTER TABLE `users_profiles`
  MODIFY `user_id` int(15) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `calc_limit_dates`
--
ALTER TABLE `calc_limit_dates`
  ADD CONSTRAINT `calc_limit_dates_ibfk_1` FOREIGN KEY (`GSZ_Id`) REFERENCES `GSZ` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
