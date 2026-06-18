-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-10-2024 a las 18:12:18
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bt5clean`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `account`
--

CREATE TABLE `account` (
  `AccountID` int(11) NOT NULL,
  `AuditDate` datetime DEFAULT NULL,
  `AuditUser` varchar(16) DEFAULT NULL,
  `AuditMessage` text DEFAULT NULL,
  `IsActive` tinyint(4) DEFAULT NULL,
  `ParentAccount` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `account`
--

INSERT INTO `account` (`AccountID`, `AuditDate`, `AuditUser`, `AuditMessage`, `IsActive`, `ParentAccount`) VALUES
(207, '2017-07-26 00:00:00', 'User', NULL, 1, NULL),
(221, '2022-10-25 00:08:52', 'System', NULL, 1, NULL),
(223, '2022-11-15 13:11:19', 'System', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `country`
--

CREATE TABLE `country` (
  `CountryID` int(11) NOT NULL,
  `Abbreviation` varchar(2) NOT NULL,
  `Name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `country`
--

INSERT INTO `country` (`CountryID`, `Abbreviation`, `Name`) VALUES
(1, 'AF', 'Afganistán'),
(2, 'AX', 'Islas Gland'),
(3, 'AL', 'Albania'),
(4, 'DE', 'Alemania'),
(5, 'AD', 'Andorra'),
(6, 'AO', 'Angola'),
(7, 'AI', 'Anguilla'),
(8, 'AQ', 'Antártida'),
(9, 'AG', 'Antigua y Barbuda'),
(10, 'AN', 'Antillas Holandesas'),
(11, 'SA', 'Arabia Saudí'),
(12, 'DZ', 'Argelia'),
(13, 'AR', 'Argentina'),
(14, 'AM', 'Armenia'),
(15, 'AW', 'Aruba'),
(16, 'AU', 'Australia'),
(17, 'AT', 'Austria'),
(18, 'AZ', 'Azerbaiyán'),
(19, 'BS', 'Bahamas'),
(20, 'BH', 'Bahréin'),
(21, 'BD', 'Bangladesh'),
(22, 'BB', 'Barbados'),
(23, 'BY', 'Bielorrusia'),
(24, 'BE', 'Bélgica'),
(25, 'BZ', 'Belice'),
(26, 'BJ', 'Benin'),
(27, 'BM', 'Bermudas'),
(28, 'BT', 'Bhután'),
(29, 'BO', 'Bolivia'),
(30, 'BA', 'Bosnia y Herzegovina'),
(31, 'BW', 'Botsuana'),
(32, 'BV', 'Isla Bouvet'),
(33, 'BR', 'Brasil'),
(34, 'BN', 'Brunéi'),
(35, 'BG', 'Bulgaria'),
(36, 'BF', 'Burkina Faso'),
(37, 'BI', 'Burundi'),
(38, 'CV', 'Cabo Verde'),
(39, 'KY', 'Islas Caimán'),
(40, 'KH', 'Camboya'),
(41, 'CM', 'Camerún'),
(42, 'CA', 'Canadá'),
(43, 'CF', 'República Centroafricana'),
(44, 'TD', 'Chad'),
(45, 'CZ', 'República Checa'),
(46, 'CL', 'Chile'),
(47, 'CN', 'China'),
(48, 'CY', 'Chipre'),
(49, 'CX', 'Isla de Navidad'),
(50, 'VA', 'Ciudad del Vaticano'),
(51, 'CC', 'Islas Cocos'),
(52, 'CO', 'Colombia'),
(53, 'KM', 'Comoras'),
(54, 'CD', 'República Democrática del Congo'),
(55, 'CG', 'Congo'),
(56, 'CK', 'Islas Cook'),
(57, 'KP', 'Corea del Norte'),
(58, 'KR', 'Corea del Sur'),
(59, 'CI', 'Costa de Marfil'),
(60, 'CR', 'Costa Rica'),
(61, 'HR', 'Croacia'),
(62, 'CU', 'Cuba'),
(63, 'DK', 'Dinamarca'),
(64, 'DM', 'Dominica'),
(65, 'DO', 'República Dominicana'),
(66, 'EC', 'Ecuador'),
(67, 'EG', 'Egipto'),
(68, 'SV', 'El Salvador'),
(69, 'AE', 'Emiratos Árabes Unidos'),
(70, 'ER', 'Eritrea'),
(71, 'SK', 'Eslovaquia'),
(72, 'SI', 'Eslovenia'),
(73, 'ES', 'España'),
(74, 'UM', 'Islas ultramarinas de Estados Unidos'),
(75, 'US', 'Estados Unidos'),
(76, 'EE', 'Estonia'),
(77, 'ET', 'Etiopía'),
(78, 'FO', 'Islas Feroe'),
(79, 'PH', 'Filipinas'),
(80, 'FI', 'Finlandia'),
(81, 'FJ', 'Fiyi'),
(82, 'FR', 'Francia'),
(83, 'GA', 'Gabón'),
(84, 'GM', 'Gambia'),
(85, 'GE', 'Georgia'),
(86, 'GS', 'Islas Georgias del Sur y Sandwich del Sur'),
(87, 'GH', 'Ghana'),
(88, 'GI', 'Gibraltar'),
(89, 'GD', 'Granada'),
(90, 'GR', 'Grecia'),
(91, 'GL', 'Groenlandia'),
(92, 'GP', 'Guadalupe'),
(93, 'GU', 'Guam'),
(94, 'GT', 'Guatemala'),
(95, 'GF', 'Guayana Francesa'),
(96, 'GN', 'Guinea'),
(97, 'GQ', 'Guinea Ecuatorial'),
(98, 'GW', 'Guinea-Bissau'),
(99, 'GY', 'Guyana'),
(100, 'HT', 'Haití'),
(101, 'HM', 'Islas Heard y McDonald'),
(102, 'HN', 'Honduras'),
(103, 'HK', 'Hong Kong'),
(104, 'HU', 'Hungría'),
(105, 'IN', 'India'),
(106, 'ID', 'Indonesia'),
(107, 'IR', 'Irán'),
(108, 'IQ', 'Iraq'),
(109, 'IE', 'Irlanda'),
(110, 'IS', 'Islandia'),
(111, 'IL', 'Israel'),
(112, 'IT', 'Italia'),
(113, 'JM', 'Jamaica'),
(114, 'JP', 'Japón'),
(115, 'JO', 'Jordania'),
(116, 'KZ', 'Kazajstán'),
(117, 'KE', 'Kenia'),
(118, 'KG', 'Kirguistán'),
(119, 'KI', 'Kiribati'),
(120, 'KW', 'Kuwait'),
(121, 'LA', 'Laos'),
(122, 'LS', 'Lesotho'),
(123, 'LV', 'Letonia'),
(124, 'LB', 'Líbano'),
(125, 'LR', 'Liberia'),
(126, 'LY', 'Libia'),
(127, 'LI', 'Liechtenstein'),
(128, 'LT', 'Lituania'),
(129, 'LU', 'Luxemburgo'),
(130, 'MO', 'Macao'),
(131, 'MK', 'ARY Macedonia'),
(132, 'MG', 'Madagascar'),
(133, 'MY', 'Malasia'),
(134, 'MW', 'Malawi'),
(135, 'MV', 'Maldivas'),
(136, 'ML', 'Malí'),
(137, 'MT', 'Malta'),
(138, 'FK', 'Islas Malvinas'),
(139, 'MP', 'Islas Marianas del Norte'),
(140, 'MA', 'Marruecos'),
(141, 'MH', 'Islas Marshall'),
(142, 'MQ', 'Martinica'),
(143, 'MU', 'Mauricio'),
(144, 'MR', 'Mauritania'),
(145, 'YT', 'Mayotte'),
(146, 'MX', 'México'),
(147, 'FM', 'Micronesia'),
(148, 'MD', 'Moldavia'),
(149, 'MC', 'Mónaco'),
(150, 'MN', 'Mongolia'),
(151, 'MS', 'Montserrat'),
(152, 'MZ', 'Mozambique'),
(153, 'MM', 'Myanmar'),
(154, 'NA', 'Namibia'),
(155, 'NR', 'Nauru'),
(156, 'NP', 'Nepal'),
(157, 'NI', 'Nicaragua'),
(158, 'NE', 'Níger'),
(159, 'NG', 'Nigeria'),
(160, 'NU', 'Niue'),
(161, 'NF', 'Isla Norfolk'),
(162, 'NO', 'Noruega'),
(163, 'NC', 'Nueva Caledonia'),
(164, 'NZ', 'Nueva Zelanda'),
(165, 'OM', 'Omán'),
(166, 'NL', 'Países Bajos'),
(167, 'PK', 'Pakistán'),
(168, 'PW', 'Palau'),
(169, 'PS', 'Palestina'),
(170, 'PA', 'Panamá'),
(171, 'PG', 'Papúa Nueva Guinea'),
(172, 'PY', 'Paraguay'),
(173, 'PE', 'Perú'),
(174, 'PN', 'Islas Pitcairn'),
(175, 'PF', 'Polinesia Francesa'),
(176, 'PL', 'Polonia'),
(177, 'PT', 'Portugal'),
(178, 'PR', 'Puerto Rico'),
(179, 'QA', 'Qatar'),
(180, 'GB', 'Reino Unido'),
(181, 'RE', 'Reunión'),
(182, 'RW', 'Ruanda'),
(183, 'RO', 'Rumania'),
(184, 'RU', 'Rusia'),
(185, 'EH', 'Sahara Occidental'),
(186, 'SB', 'Islas Salomón'),
(187, 'WS', 'Samoa'),
(188, 'AS', 'Samoa Americana'),
(189, 'KN', 'San Cristóbal y Nevis'),
(190, 'SM', 'San Marino'),
(191, 'PM', 'San Pedro y Miquelón'),
(192, 'VC', 'San Vicente y las Granadinas'),
(193, 'SH', 'Santa Helena'),
(194, 'LC', 'Santa Lucía'),
(195, 'ST', 'Santo Tomé y Príncipe'),
(196, 'SN', 'Senegal'),
(197, 'CS', 'Serbia y Montenegro'),
(198, 'SC', 'Seychelles'),
(199, 'SL', 'Sierra Leona'),
(200, 'SG', 'Singapur'),
(201, 'SY', 'Siria'),
(202, 'SO', 'Somalia'),
(203, 'LK', 'Sri Lanka'),
(204, 'SZ', 'Suazilandia'),
(205, 'ZA', 'Sudáfrica'),
(206, 'SD', 'Sudán'),
(207, 'SE', 'Suecia'),
(208, 'CH', 'Suiza'),
(209, 'SR', 'Surinam'),
(210, 'SJ', 'Svalbard y Jan Mayen'),
(211, 'TH', 'Tailandia'),
(212, 'TW', 'Taiwán'),
(213, 'TZ', 'Tanzania'),
(214, 'TJ', 'Tayikistán'),
(215, 'IO', 'Territorio Británico del Océano Índico'),
(216, 'TF', 'Territorios Australes Franceses'),
(217, 'TL', 'Timor Oriental'),
(218, 'TG', 'Togo'),
(219, 'TK', 'Tokelau'),
(220, 'TO', 'Tonga'),
(221, 'TT', 'Trinidad y Tobago'),
(222, 'TN', 'Túnez'),
(223, 'TC', 'Islas Turcas y Caicos'),
(224, 'TM', 'Turkmenistán'),
(225, 'TR', 'Turquía'),
(226, 'TV', 'Tuvalu'),
(227, 'UA', 'Ucrania'),
(228, 'UG', 'Uganda'),
(229, 'UY', 'Uruguay'),
(230, 'UZ', 'Uzbekistán'),
(231, 'VU', 'Vanuatu'),
(232, 'VE', 'Venezuela'),
(233, 'VN', 'Vietnam'),
(234, 'VG', 'Islas Vírgenes Británicas'),
(235, 'VI', 'Islas Vírgenes de los Estados Unidos'),
(236, 'WF', 'Wallis y Futuna'),
(237, 'YE', 'Yemen'),
(238, 'DJ', 'Yibuti'),
(239, 'ZM', 'Zambia'),
(240, 'ZW', 'Zimbabue'),
(241, 'UK', 'unknown');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `directory`
--

CREATE TABLE `directory` (
  `DirectoryID` int(11) NOT NULL,
  `Name` varchar(128) NOT NULL,
  `BusinessName` text DEFAULT NULL,
  `NIT` varchar(128) NOT NULL,
  `NumberPhone` text DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `DescriptionEng` text DEFAULT NULL,
  `Address` text DEFAULT NULL,
  `PathImage` text DEFAULT NULL,
  `WebSite` varchar(220) DEFAULT NULL,
  `Facebook` varchar(220) DEFAULT NULL,
  `Twitter` varchar(220) DEFAULT NULL,
  `Whatsapp` varchar(220) DEFAULT NULL,
  `Instagram` varchar(220) DEFAULT NULL,
  `Issuu` varchar(220) DEFAULT NULL,
  `Skype` varchar(220) DEFAULT NULL,
  `Linkedin` varchar(220) DEFAULT NULL,
  `Video` varchar(220) DEFAULT NULL,
  `VideoChannel` varchar(220) DEFAULT NULL,
  `LinkProductCatalog` varchar(220) DEFAULT NULL,
  `Email` varchar(128) DEFAULT NULL,
  `Latitud` varchar(120) DEFAULT NULL,
  `Longitud` varchar(120) DEFAULT NULL,
  `Origin` int(11) DEFAULT NULL,
  `CrmID` varchar(220) DEFAULT NULL,
  `CbmID` varchar(220) DEFAULT NULL,
  `SapCode` varchar(220) DEFAULT NULL,
  `ValidationCode` varchar(220) DEFAULT NULL,
  `AccountID` int(11) DEFAULT NULL,
  `Keywords` text DEFAULT NULL,
  `Export` int(11) DEFAULT NULL,
  `TypeExport` int(11) NOT NULL DEFAULT 0,
  `Prov` int(11) NOT NULL DEFAULT 0,
  `IsActive` int(11) NOT NULL DEFAULT 1,
  `Associated` int(11) DEFAULT NULL,
  `ExportCode` varchar(120) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `directory`
--

INSERT INTO `directory` (`DirectoryID`, `Name`, `BusinessName`, `NIT`, `NumberPhone`, `Description`, `DescriptionEng`, `Address`, `PathImage`, `WebSite`, `Facebook`, `Twitter`, `Whatsapp`, `Instagram`, `Issuu`, `Skype`, `Linkedin`, `Video`, `VideoChannel`, `LinkProductCatalog`, `Email`, `Latitud`, `Longitud`, `Origin`, `CrmID`, `CbmID`, `SapCode`, `ValidationCode`, `AccountID`, `Keywords`, `Export`, `TypeExport`, `Prov`, `IsActive`, `Associated`, `ExportCode`) VALUES
(1, 'Empresa', NULL, '55545545', '1111111', 'Empresa', '', 'Guatemala Mixco', 'http://localhost/MKD-EXPORTIC/nexportic/images/Logos/Directory_ade7ed.jpg', 'http://google.com', 'fb.com', '', '', '', '', '', '', '', '', '', '', '36.7275974', '-4.4208521', NULL, NULL, NULL, NULL, NULL, 223, 'Frutas, Verduras, empresa, exportar', 1, 1, 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logdata`
--

CREATE TABLE `logdata` (
  `LogDataID` int(11) NOT NULL,
  `Module` varchar(60) NOT NULL,
  `AppliedAction` varchar(120) NOT NULL,
  `UserName` varchar(120) NOT NULL,
  `TextInfo` text DEFAULT NULL,
  `DateLog` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `MenuID` int(11) NOT NULL,
  `MenuName` varchar(74) NOT NULL,
  `ClassIcon` varchar(74) NOT NULL,
  `ControllerUse` varchar(74) NOT NULL,
  `Type` int(11) NOT NULL,
  `Path` varchar(74) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`MenuID`, `MenuName`, `ClassIcon`, `ControllerUse`, `Type`, `Path`) VALUES
(1, 'Administración', 'fa fa-cogs', 'usuario', 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menubyrole`
--

CREATE TABLE `menubyrole` (
  `MenuByRoleID` int(11) NOT NULL,
  `RoleID` int(11) NOT NULL,
  `MenuID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `menubyrole`
--

INSERT INTO `menubyrole` (`MenuByRoleID`, `RoleID`, `MenuID`) VALUES
(108, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `page`
--

CREATE TABLE `page` (
  `PageID` int(11) NOT NULL,
  `MenuID` int(11) NOT NULL,
  `PageName` varchar(64) DEFAULT NULL,
  `PagePath` varchar(256) DEFAULT NULL,
  `ClassIcon` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `page`
--

INSERT INTO `page` (`PageID`, `MenuID`, `PageName`, `PagePath`, `ClassIcon`) VALUES
(155, 1, 'Configurar menú', 'menu/index', NULL),
(156, 1, 'Usuarios', 'index', NULL),
(157, 1, 'Roles', 'roles', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role`
--

CREATE TABLE `role` (
  `RoleID` int(11) NOT NULL,
  `RoleName` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `role`
--

INSERT INTO `role` (`RoleID`, `RoleName`) VALUES
(1, 'Administrador'),
(2, 'Empresa'),
(19, 'Coordinador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `typeusers`
--

CREATE TABLE `typeusers` (
  `TypeUsersID` int(11) NOT NULL,
  `Name` varchar(64) NOT NULL,
  `Layout` varchar(64) NOT NULL,
  `UserHome` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `typeusers`
--

INSERT INTO `typeusers` (`TypeUsersID`, `Name`, `Layout`, `UserHome`) VALUES
(1, 'Administrador', '/template', 'home'),
(2, 'Empresa', '/template', 'home');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `useraccount`
--

CREATE TABLE `useraccount` (
  `UserName` varchar(64) NOT NULL,
  `Name` varchar(128) CHARACTER SET utf8 DEFAULT NULL,
  `Email` varchar(128) DEFAULT NULL,
  `AccountID` int(11) NOT NULL,
  `UserPassword` varchar(256) DEFAULT NULL,
  `IsActive` tinyint(4) DEFAULT NULL,
  `AuditDate` datetime DEFAULT NULL,
  `AuditUser` varchar(16) DEFAULT NULL,
  `AuditMessage` text DEFAULT NULL,
  `IsAdminUser` tinyint(4) DEFAULT NULL,
  `TypeUser` int(2) NOT NULL,
  `IsRootUser` tinyint(4) DEFAULT NULL,
  `PhotoUrl` varchar(255) DEFAULT NULL,
  `ApiToken` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `useraccount`
--

INSERT INTO `useraccount` (`UserName`, `Name`, `Email`, `AccountID`, `UserPassword`, `IsActive`, `AuditDate`, `AuditUser`, `AuditMessage`, `IsAdminUser`, `TypeUser`, `IsRootUser`, `PhotoUrl`, `ApiToken`) VALUES
('admin', NULL, NULL, 207, '827ccb0eea8a706c4c34a16891f84e7b', 1, '2017-07-26 00:00:00', 'User', NULL, 1, 1, 1, 'Wikipedia_User-ICON_byNightsight_72b9df.png', NULL),
('admin-exportic', 'Admin', 'admin@export.com', 221, '827ccb0eea8a706c4c34a16891f84e7b', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2MbOiIaI4S5ggYJ7Vj9ms4jTkSkzef9pTUW5lVHEAMvg9ebLIE9p3qrfmavb'),
('empresa', 'Emprendimiento', 'empresa@gmail.com', 223, '827ccb0eea8a706c4c34a16891f84e7b', NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, 'XEcahzbI2lRqRgbcIUmqiwMNFqKrHJA9CBhup7hlxPlBi7SizOYASIptlEOU');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `userbyrole`
--

CREATE TABLE `userbyrole` (
  `UserByRoleID` int(11) NOT NULL,
  `UserName` varchar(64) NOT NULL,
  `RoleID` int(11) NOT NULL,
  `AuditUser` varchar(16) DEFAULT NULL,
  `AuditDate` datetime DEFAULT NULL,
  `AuditMessage` text DEFAULT NULL,
  `IsActive` tinyint(4) DEFAULT NULL,
  `IsDefault` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `userbyrole`
--

INSERT INTO `userbyrole` (`UserByRoleID`, `UserName`, `RoleID`, `AuditUser`, `AuditDate`, `AuditMessage`, `IsActive`, `IsDefault`) VALUES
(1, 'admin', 1, NULL, '2017-08-09 00:00:00', 'usuario registrado desde la base de datos', 1, NULL),
(21, 'admin-exportic', 1, NULL, NULL, NULL, NULL, NULL),
(23, 'empresa', 2, NULL, NULL, NULL, NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`AccountID`);

--
-- Indices de la tabla `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`CountryID`);

--
-- Indices de la tabla `directory`
--
ALTER TABLE `directory`
  ADD PRIMARY KEY (`DirectoryID`),
  ADD KEY `AccountID` (`AccountID`);

--
-- Indices de la tabla `logdata`
--
ALTER TABLE `logdata`
  ADD PRIMARY KEY (`LogDataID`);

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`MenuID`);

--
-- Indices de la tabla `menubyrole`
--
ALTER TABLE `menubyrole`
  ADD PRIMARY KEY (`MenuByRoleID`),
  ADD KEY `RoleID` (`RoleID`),
  ADD KEY `MenuID` (`MenuID`);

--
-- Indices de la tabla `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`PageID`),
  ADD KEY `RefMenu14` (`MenuID`);

--
-- Indices de la tabla `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`RoleID`);

--
-- Indices de la tabla `typeusers`
--
ALTER TABLE `typeusers`
  ADD PRIMARY KEY (`TypeUsersID`);

--
-- Indices de la tabla `useraccount`
--
ALTER TABLE `useraccount`
  ADD PRIMARY KEY (`UserName`),
  ADD KEY `RefAccount15` (`AccountID`),
  ADD KEY `TypeUser` (`TypeUser`);

--
-- Indices de la tabla `userbyrole`
--
ALTER TABLE `userbyrole`
  ADD PRIMARY KEY (`UserByRoleID`),
  ADD KEY `userName` (`UserName`),
  ADD KEY `Rol` (`RoleID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `account`
--
ALTER TABLE `account`
  MODIFY `AccountID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=224;

--
-- AUTO_INCREMENT de la tabla `country`
--
ALTER TABLE `country`
  MODIFY `CountryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=242;

--
-- AUTO_INCREMENT de la tabla `directory`
--
ALTER TABLE `directory`
  MODIFY `DirectoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `logdata`
--
ALTER TABLE `logdata`
  MODIFY `LogDataID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `MenuID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `menubyrole`
--
ALTER TABLE `menubyrole`
  MODIFY `MenuByRoleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT de la tabla `page`
--
ALTER TABLE `page`
  MODIFY `PageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- AUTO_INCREMENT de la tabla `role`
--
ALTER TABLE `role`
  MODIFY `RoleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `typeusers`
--
ALTER TABLE `typeusers`
  MODIFY `TypeUsersID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `userbyrole`
--
ALTER TABLE `userbyrole`
  MODIFY `UserByRoleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `directory`
--
ALTER TABLE `directory`
  ADD CONSTRAINT `directory_ibfk_1` FOREIGN KEY (`AccountID`) REFERENCES `account` (`AccountID`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `menubyrole`
--
ALTER TABLE `menubyrole`
  ADD CONSTRAINT `MenuByRole_ibfk_1` FOREIGN KEY (`RoleID`) REFERENCES `role` (`RoleID`) ON DELETE CASCADE,
  ADD CONSTRAINT `MenuByRole_ibfk_2` FOREIGN KEY (`MenuID`) REFERENCES `menu` (`MenuID`) ON DELETE CASCADE;

--
-- Filtros para la tabla `page`
--
ALTER TABLE `page`
  ADD CONSTRAINT `RefMenu14` FOREIGN KEY (`MenuID`) REFERENCES `menu` (`MenuID`) ON DELETE CASCADE;

--
-- Filtros para la tabla `useraccount`
--
ALTER TABLE `useraccount`
  ADD CONSTRAINT `UserAccount_ibfk_1` FOREIGN KEY (`AccountID`) REFERENCES `account` (`AccountID`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `UserAccount_ibfk_2` FOREIGN KEY (`TypeUser`) REFERENCES `typeusers` (`TypeUsersID`) ON DELETE NO ACTION;

--
-- Filtros para la tabla `userbyrole`
--
ALTER TABLE `userbyrole`
  ADD CONSTRAINT `UserByRole_ibfk_1` FOREIGN KEY (`UserName`) REFERENCES `useraccount` (`UserName`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `UserByRole_ibfk_2` FOREIGN KEY (`RoleID`) REFERENCES `role` (`RoleID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
