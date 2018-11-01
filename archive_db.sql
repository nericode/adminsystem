-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 01-11-2018 a las 17:25:11
-- Versión del servidor: 5.7.24-0ubuntu0.16.04.1
-- Versión de PHP: 7.1.20-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `archive_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id_categorie` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `path` varchar(550) DEFAULT NULL,
  `id_subproject` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `path` varchar(550) DEFAULT NULL,
  `code` varchar(45) DEFAULT NULL,
  `upload_date` varchar(45) DEFAULT NULL,
  `id_categorie` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `name_unique` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `user_created` varchar(10) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `files`
--

INSERT INTO `files` (`id`, `path`, `code`, `upload_date`, `id_categorie`, `name`, `name_unique`, `type`, `user_created`, `date_created`) VALUES
(1, '/var/www/html/adminsystem/public/storage/app/dfgdfg', NULL, NULL, NULL, 'dfgdfg', NULL, 'directory', 'Javier', '2018-11-01 22:11:45'),
(2, '/var/www/html/adminsystem/public/storage/app/nueva', NULL, NULL, NULL, 'nueva', NULL, 'directory', 'Javier', '2018-11-01 22:11:43'),
(3, '/var/www/html/adminsystem/public/storage/app/nueva/otra', NULL, NULL, NULL, 'otra', NULL, 'directory', 'Javier', '2018-11-01 22:11:55'),
(4, '/var/www/html/adminsystem/public/storage/app/nueva/otra/ggg', NULL, NULL, NULL, 'ggg', NULL, 'directory', 'Javier', '2018-11-01 22:11:12'),
(5, '/var/www/html/adminsystem/public/storage/app/adminsystemdb (1).sql', NULL, NULL, NULL, 'adminsystemdb (1).sql', 'daac22737fb698bc8b0ba02bb5ef90a0', 'file', 'Javier', '2018-11-01 22:11:34'),
(6, '/var/www/html/adminsystem/public/storage/app/adminsystemdb (1).sql', NULL, NULL, NULL, 'adminsystemdb (1).sql', '9d51d2f88ed5205ac7d3eee272e108e6', 'file', 'Javier', '2018-11-01 22:11:39'),
(7, '/var/www/html/adminsystem/public/storage/app/nueva/android.png', NULL, NULL, NULL, 'android.png', 'ed609466727fe055206cdd197b66f00e', 'file', 'Javier', '2018-11-01 22:11:50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `projects`
--

CREATE TABLE `projects` (
  `id_project` int(11) NOT NULL,
  `name` varchar(125) DEFAULT NULL,
  `code` varchar(45) DEFAULT NULL,
  `path` varchar(550) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_date_order` datetime DEFAULT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subprojects`
--

CREATE TABLE `subprojects` (
  `id_subproject` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `path` varchar(550) DEFAULT NULL,
  `created_date_order` datetime DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `id_project` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Javier', 'javier@gmail.com', '$2y$10$V5z08CrroSeI47g3liSd6.klKMAKytCGLgEBn0Wae.wJH0.H/VmUS', NULL, '2018-11-02 04:06:00', '2018-11-02 04:06:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id_categorie`),
  ADD KEY `fk_files_subprojects1_idx` (`id_subproject`);

--
-- Indices de la tabla `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_files_categories1_idx` (`id_categorie`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id_project`),
  ADD KEY `fk_projects_users_idx` (`id_user`);

--
-- Indices de la tabla `subprojects`
--
ALTER TABLE `subprojects`
  ADD PRIMARY KEY (`id_subproject`),
  ADD KEY `fk_subprojects_projects1_idx` (`id_project`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id_categorie` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `projects`
--
ALTER TABLE `projects`
  MODIFY `id_project` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `subprojects`
--
ALTER TABLE `subprojects`
  MODIFY `id_subproject` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `fk_files_subprojects1` FOREIGN KEY (`id_subproject`) REFERENCES `subprojects` (`id_subproject`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `fk_files_categories1` FOREIGN KEY (`id_categorie`) REFERENCES `categories` (`id_categorie`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
