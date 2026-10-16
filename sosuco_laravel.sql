-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 15 oct. 2026 à 23:58
-- Version du serveur : 8.4.7
-- Version de PHP : 8.5.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `sosuco_laravel`
--

-- --------------------------------------------------------

--
-- Structure de la table `audit_logs`
--

DROP TABLE IF EXISTS `audit_logs`;
CREATE TABLE IF NOT EXISTS `audit_logs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `action` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_id` bigint UNSIGNED DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `audit_logs_user_id_action_index` (`user_id`,`action`),
  KEY `audit_logs_created_at_index` (`created_at`)
) ENGINE=MyISAM AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`) VALUES
(1, 1, 'create', 'App\\Models\\Courrier', 5, 'Création du courrier N° DEP-2026-0002', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '2026-07-30 20:49:22', '2026-07-30 20:49:22'),
(2, 1, 'create', 'App\\Models\\Courrier', 6, 'Création du courrier N° DEP-2026-0003', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '2026-07-30 20:49:59', '2026-07-30 20:49:59'),
(3, 1, 'create', 'App\\Models\\Courrier', 7, 'Création du courrier N° DEP-2026-0004', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '2026-07-31 09:33:58', '2026-07-31 09:33:58'),
(4, 1, 'distribute', 'App\\Models\\Courrier', 7, 'Distribution du courrier N° DEP-2026-0004 au département Culture', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '2026-07-31 11:27:34', '2026-07-31 11:27:34'),
(5, 1, 'create', 'App\\Models\\Courrier', 8, 'Création du courrier N° INT-2026-0001', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-08 22:43:13', '2026-08-08 22:43:13'),
(6, 1, 'create', 'App\\Models\\Courrier', 9, 'Création du courrier N° ARR-2026-0004', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-10 17:46:27', '2026-08-10 17:46:27'),
(7, 1, 'create', 'App\\Models\\Courrier', 10, 'Création du courrier N° ARR-2026-0005', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-10 17:46:29', '2026-08-10 17:46:29'),
(8, 1, 'create', 'App\\Models\\Courrier', 11, 'Création du courrier N° ARR-2026-0006', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-11 12:10:06', '2026-08-11 12:10:06'),
(9, 1, 'update', 'App\\Models\\Courrier', 9, 'Modification du courrier N° ARR-2026-0004 (Nouveau statut: en_cours)', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-11 12:16:28', '2026-08-11 12:16:28'),
(10, 1, 'create', 'App\\Models\\Courrier', 12, 'Création du courrier N° ARR-2026-0007', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-11 17:20:13', '2026-08-11 17:20:13'),
(11, 10, 'create', 'App\\Models\\Courrier', 13, 'Création du courrier N° DEP-2026-0005', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-13 07:23:18', '2026-08-13 07:23:18'),
(12, 10, 'create', 'App\\Models\\Courrier', 14, 'Création du courrier N° DEP-2026-0006', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-13 07:23:21', '2026-08-13 07:23:21'),
(13, 1, 'create', 'App\\Models\\Courrier', 15, 'Création du courrier N° ARR-2026-0008', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-13 10:36:42', '2026-08-13 10:36:42'),
(14, 10, 'create', 'App\\Models\\Courrier', 16, 'Création du courrier N° INT-2026-0002', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-24 13:32:59', '2026-08-24 13:32:59'),
(15, 1, 'update', 'App\\Models\\Courrier', 2, 'Modification du courrier N° ARR-2026-0002 (Nouveau statut: en_cours)', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-25 07:43:41', '2026-08-25 07:43:41'),
(16, 1, 'access_denied', NULL, NULL, 'Tentative d\'accès non autorisé à : http://localhost:8000/admin/users', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-25 09:46:38', '2026-08-25 09:46:38'),
(17, 1, 'update', 'App\\Models\\Courrier', 14, 'Modification du courrier N° DEP-2026-0006 (Nouveau statut: en_cours)', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-26 11:05:31', '2026-08-26 11:05:31'),
(18, 1, 'create', 'App\\Models\\Courrier', 17, 'Création du courrier N° ARR-2026-0009', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-27 10:35:20', '2026-08-27 10:35:20'),
(19, 1, 'update', 'App\\Models\\Courrier', 17, 'Modification du courrier N° ARR-2026-0009', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-27 10:38:09', '2026-08-27 10:38:09'),
(20, 1, 'update', 'App\\Models\\Courrier', 17, 'Modification du courrier N° ARR-2026-0009', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-27 10:38:38', '2026-08-27 10:38:38'),
(21, 1, 'access_denied', NULL, NULL, 'Tentative d\'accès non autorisé à : http://127.0.0.1:8000/courriers/17/receptionner', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-27 11:45:21', '2026-08-27 11:45:21'),
(22, 1, 'access_denied', NULL, NULL, 'Tentative d\'accès non autorisé à : http://127.0.0.1:8000/courriers/17/receptionner', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-27 12:30:45', '2026-08-27 12:30:45'),
(23, 1, 'create', 'App\\Models\\Courrier', 18, 'Création du courrier N° ARR-2026-0010', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-27 12:35:35', '2026-08-27 12:35:35'),
(24, 1, 'update', 'App\\Models\\Courrier', 18, 'Modification du courrier N° ARR-2026-0010', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-27 12:36:36', '2026-08-27 12:36:36'),
(25, 1, 'update', 'App\\Models\\Courrier', 18, 'Modification du courrier N° ARR-2026-0010', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-27 12:37:21', '2026-08-27 12:37:21'),
(26, 1, 'update', 'App\\Models\\Courrier', 18, 'Modification du courrier N° ARR-2026-0010', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-27 12:37:59', '2026-08-27 12:37:59'),
(27, 10, 'receptionne', 'App\\Models\\Courrier', 4, 'Réception du courrier N° DEP-2026-0001', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-27 19:13:20', '2026-08-27 19:13:20'),
(28, 10, 'receptionne', 'App\\Models\\Courrier', 3, 'Réception du courrier N° ARR-2026-0003', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-27 19:13:39', '2026-08-27 19:13:39'),
(29, 10, 'envoye_direction', 'App\\Models\\Courrier', 3, 'Envoi à la direction du courrier N° ARR-2026-0003', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-27 19:13:48', '2026-08-27 19:13:48'),
(30, 1, 'create', 'App\\Models\\Courrier', 19, 'Création du courrier N° ARR-2026-0011', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-28 07:44:41', '2026-08-28 07:44:41'),
(31, 10, 'create', 'App\\Models\\Courrier', 20, 'Création du courrier N° DEP-2026-0007', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-28 09:39:40', '2026-08-28 09:39:40'),
(32, 10, 'create', 'App\\Models\\Courrier', 21, 'Création du courrier N° INT-2026-0003', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-28 10:23:39', '2026-08-28 10:23:39'),
(33, 10, 'receptionne', 'App\\Models\\Courrier', 21, 'Réception du courrier N° INT-2026-0003', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-29 07:35:33', '2026-08-29 07:35:33'),
(34, 1, 'create', 'App\\Models\\Courrier', 22, 'Création du courrier N° ARR-2026-0012', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-08-30 10:04:16', '2026-08-30 10:04:16'),
(35, 1, 'send', 'App\\Models\\Courrier', 22, 'Envoi du courrier N° ARR-2026-0012', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-08-30 10:04:16', '2026-08-30 10:04:16'),
(36, 1, 'create', 'App\\Models\\Courrier', 23, 'Création du courrier N° DEP-2026-0008', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-08-30 10:10:55', '2026-08-30 10:10:55'),
(37, 1, 'send', 'App\\Models\\Courrier', 23, 'Envoi du courrier N° DEP-2026-0008', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-08-30 10:10:55', '2026-08-30 10:10:55'),
(38, 1, 'update', 'App\\Models\\Courrier', 23, 'Modification du courrier N° DEP-2026-0008', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-08-30 10:11:10', '2026-08-30 10:11:10'),
(39, 9, 'create', 'App\\Models\\Courrier', 24, 'Création du courrier N° ARR-2026-0013', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-08-30 10:28:17', '2026-08-30 10:28:17'),
(40, 9, 'send', 'App\\Models\\Courrier', 24, 'Envoi du courrier N° ARR-2026-0013', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-08-30 10:28:17', '2026-08-30 10:28:17'),
(41, 1, 'send', 'App\\Models\\Courrier', 25, 'Création et envoi du courrier N° INT-2026-0004', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-08-30 14:56:43', '2026-08-30 14:56:43'),
(42, 1, 'update', 'App\\Models\\Courrier', 25, 'Modification du courrier N° INT-2026-0004', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-08-30 14:57:08', '2026-08-30 14:57:08'),
(43, 1, 'receptionne', 'App\\Models\\Courrier', 25, 'Réception du courrier N° INT-2026-0004', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-08-30 14:57:14', '2026-08-30 14:57:14'),
(44, 1, 'envoye_direction', 'App\\Models\\Courrier', 25, 'Envoi à la direction du courrier N° INT-2026-0004', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-08-30 14:57:21', '2026-08-30 14:57:21'),
(45, 1, 'access_denied', NULL, NULL, 'Tentative d\'accès non autorisé à : http://127.0.0.1:8000/courriers/a-receptionner', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-08-30 14:58:34', '2026-08-30 14:58:34'),
(46, 1, 'receptionne', 'App\\Models\\Courrier', 24, 'Réception du courrier N° ARR-2026-0013', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-08-30 14:59:42', '2026-08-30 14:59:42'),
(47, 6, 'access_denied', NULL, NULL, 'Tentative d\'accès non autorisé à : http://127.0.0.1:8000/courriers/a-receptionner', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-08-30 15:07:00', '2026-08-30 15:07:00'),
(48, 6, 'access_denied', NULL, NULL, 'Tentative d\'accès non autorisé à : http://127.0.0.1:8000/courriers/a-receptionner', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-08-30 15:08:16', '2026-08-30 15:08:16'),
(49, 6, 'receptionne', 'App\\Models\\Courrier', 2, 'Réception du courrier N° ARR-2026-0002', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-08-30 15:10:32', '2026-08-30 15:10:32'),
(50, 6, 'envoye_direction', 'App\\Models\\Courrier', 2, 'Envoi à la direction du courrier N° ARR-2026-0002', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-08-30 15:12:31', '2026-08-30 15:12:31'),
(51, 1, 'create', 'App\\Models\\Courrier', 26, 'Création du courrier N° ARR-2026-0014', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-09-05 07:58:26', '2026-09-05 07:58:26'),
(52, 1, 'transmettre', 'App\\Models\\Courrier', 26, 'Transmission du courrier N° ARR-2026-0014', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-09-05 08:09:16', '2026-09-05 08:09:16'),
(53, 10, 'prendre_en_charge', 'App\\Models\\Courrier', 26, 'Prise en charge du courrier N° ARR-2026-0014', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-09-05 08:15:53', '2026-09-05 08:15:53'),
(54, 1, 'create', 'App\\Models\\Courrier', 27, 'Création du courrier N° ARR-2026-0015', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-09-08 09:05:35', '2026-09-08 09:05:35'),
(55, 1, 'transmettre', 'App\\Models\\Courrier', 27, 'Transmission du courrier N° ARR-2026-0015', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-09-08 09:06:58', '2026-09-08 09:06:58'),
(56, 10, 'access_denied', NULL, NULL, 'Tentative d\'accès non autorisé à : http://127.0.0.1:8000/courriers/27/transmettre', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-09-08 09:07:16', '2026-09-08 09:07:16'),
(57, 10, 'prendre_en_charge', 'App\\Models\\Courrier', 27, 'Prise en charge du courrier N° ARR-2026-0015', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-09-08 09:09:49', '2026-09-08 09:09:49'),
(58, 10, 'update', 'App\\Models\\Courrier', 27, 'Modification du courrier N° ARR-2026-0015', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-09-08 09:10:49', '2026-09-08 09:10:49'),
(59, 1, 'send', 'App\\Models\\Courrier', 28, 'Création et envoi du courrier N° INT-2026-0005', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-09-08 22:17:09', '2026-09-08 22:17:09'),
(60, 1, 'transmettre', 'App\\Models\\Courrier', 28, 'Transmission du courrier N° INT-2026-0005', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-09-08 22:17:48', '2026-09-08 22:17:48'),
(61, 10, 'receptionner_interne', 'App\\Models\\Courrier', 28, 'Réception du courrier interne N° INT-2026-0005', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-09-08 23:13:04', '2026-09-08 23:13:04'),
(62, 10, 'access_denied', NULL, NULL, 'Tentative d\'accès non autorisé à : http://127.0.0.1:8000/courriers/28/transit', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-09-08 23:18:18', '2026-09-08 23:18:18'),
(63, 10, 'transit_interne', 'App\\Models\\Courrier', 28, 'Transmission en transit du courrier N° INT-2026-0005 vers Communication', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-09-08 23:29:23', '2026-09-08 23:29:23'),
(64, 10, 'envoye_direction', 'App\\Models\\Courrier', 21, 'Envoi à la direction du courrier N° INT-2026-0003', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-09-08 23:39:52', '2026-09-08 23:39:52'),
(65, 9, 'create', 'App\\Models\\Courrier', 29, 'Création du courrier N° ARR-2026-0016', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-09-10 23:52:58', '2026-09-10 23:52:58'),
(66, 9, 'transmettre', 'App\\Models\\Courrier', 29, 'Transmission du courrier N° ARR-2026-0016', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-09-10 23:53:45', '2026-09-10 23:53:45'),
(67, 10, 'receptionner_interne', 'App\\Models\\Courrier', 29, 'Réception du courrier interne N° ARR-2026-0016', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-09-10 23:54:20', '2026-09-10 23:54:20'),
(68, 10, 'envoyer_directeur', 'App\\Models\\Courrier', 29, 'Envoi au directeur du courrier N° ARR-2026-0016', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-09-11 00:08:53', '2026-09-11 00:08:53'),
(69, 12, 'valider', 'App\\Models\\Courrier', 29, 'Validation du courrier N° ARR-2026-0016 par le directeur', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-09-11 00:09:57', '2026-09-11 00:09:57'),
(70, 12, 'update', 'App\\Models\\Courrier', 29, 'Modification du courrier N° ARR-2026-0016', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-09-11 00:10:35', '2026-09-11 00:10:35'),
(71, 12, 'update', 'App\\Models\\Courrier', 29, 'Modification du courrier N° ARR-2026-0016', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-09-11 06:44:40', '2026-09-11 06:44:40'),
(72, 10, 'access_denied', NULL, NULL, 'Tentative d\'accès non autorisé à : http://127.0.0.1:8000/courriers/29/classer-sans-reponse', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 Edg/152.0.0.0', '2026-09-11 06:47:21', '2026-09-11 06:47:21');

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `couleur` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#1e3a5f',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_code_unique` (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `courriers`
--

DROP TABLE IF EXISTS `courriers`;
CREATE TABLE IF NOT EXISTS `courriers` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `numero_enregistrement` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sous_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `objet` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_arrivee` date DEFAULT NULL,
  `heure_arrivee` time DEFAULT NULL,
  `date_courrier_expediteur` date DEFAULT NULL,
  `type_document` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_transmission` date DEFAULT NULL,
  `priorite_envoi` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'normal',
  `mode_envoi_effectif` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_envoi_physique` date DEFAULT NULL,
  `destinataire_nom_fonction` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `destinataire_structure` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `destinataire_ville_adresse` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signataire_nom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signataire_fonction` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mode_expedition` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transmis_standardiste` tinyint(1) NOT NULL DEFAULT '0',
  `expediteur` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'Non spécifié',
  `destinataire` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'Non spécifié',
  `date_reception` date DEFAULT NULL,
  `date_envoi_direction` timestamp NULL DEFAULT NULL,
  `date_traitement` timestamp NULL DEFAULT NULL,
  `date_envoi` date DEFAULT NULL,
  `date_validation` date DEFAULT NULL,
  `statut` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en_cours',
  `contenu` text COLLATE utf8mb4_unicode_ci,
  `fichier_scanne` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre_pieces_jointes` int NOT NULL DEFAULT '1',
  `necessite_reponse` tinyint(1) NOT NULL DEFAULT '0',
  `priorite` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'normal',
  `courrier_arrive_lie_id` bigint UNSIGNED DEFAULT NULL,
  `date_envoi_effectif` date DEFAULT NULL,
  `numero_suivi` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ar_recu` tinyint(1) NOT NULL DEFAULT '0',
  `date_reception_ar` date DEFAULT NULL,
  `fichier_ar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accuse_reception_date` date DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `user_createur_id` bigint UNSIGNED DEFAULT NULL,
  `departement_id` bigint UNSIGNED DEFAULT NULL,
  `categorie_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `courriers_numero_enregistrement_unique` (`numero_enregistrement`),
  KEY `courriers_user_id_foreign` (`user_id`),
  KEY `courriers_departement_id_foreign` (`departement_id`),
  KEY `courriers_categorie_id_foreign` (`categorie_id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `courriers`
--

INSERT INTO `courriers` (`id`, `numero_enregistrement`, `type`, `sous_type`, `objet`, `reference`, `date_arrivee`, `heure_arrivee`, `date_courrier_expediteur`, `type_document`, `date_transmission`, `priorite_envoi`, `mode_envoi_effectif`, `date_envoi_physique`, `destinataire_nom_fonction`, `destinataire_structure`, `destinataire_ville_adresse`, `signataire_nom`, `signataire_fonction`, `mode_expedition`, `transmis_standardiste`, `expediteur`, `destinataire`, `date_reception`, `date_envoi_direction`, `date_traitement`, `date_envoi`, `date_validation`, `statut`, `contenu`, `fichier_scanne`, `nombre_pieces_jointes`, `necessite_reponse`, `priorite`, `courrier_arrive_lie_id`, `date_envoi_effectif`, `numero_suivi`, `ar_recu`, `date_reception_ar`, `fichier_ar`, `accuse_reception_date`, `user_id`, `user_createur_id`, `departement_id`, `categorie_id`, `created_at`, `updated_at`) VALUES
(1, 'ARR-2026-0001', 'arrivee', NULL, 'Demande stage', 'NON-DEFINIE', NULL, NULL, NULL, NULL, NULL, 'normal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Sanou sita', 'Directions des ressources humaines', '2026-07-27', NULL, NULL, '2026-07-29', NULL, 'traite', NULL, 'scans_courriers/JbjMSiZ9FpeXcTGem8kgqiMnyyNL2jYwWsgQ6GAL.pdf', 1, 0, 'normal', NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, 7, NULL, '2026-07-29 04:50:54', '2026-07-29 17:50:30'),
(2, 'ARR-2026-0002', 'arrivee', NULL, 'verification de l\'auto-génération', '2022/001', NULL, NULL, NULL, NULL, NULL, 'normal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Banque BOA', 'Ressources Humaines', '2026-08-30', NULL, NULL, '2026-07-14', NULL, 'en_attente_decision', '\n\n--- Note de distribution ---\nurgent à traiter avant 72h', 'scans_courriers/lkoEUkczrTeryw0fs2Jvn0kx3TXMF80v9u5KCJkR.pdf', 1, 0, 'normal', NULL, NULL, NULL, 0, NULL, NULL, NULL, 7, NULL, 9, NULL, '2026-07-29 16:08:51', '2026-08-30 15:12:31'),
(3, 'ARR-2026-0003', 'arrivee', NULL, 'facturers', '2026/002', NULL, NULL, NULL, NULL, NULL, 'normal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'sonabel', 'Commercial', '2026-08-27', NULL, NULL, '2026-07-29', NULL, 'en_attente_decision', '\n\n--- Note de distribution ---\nfactures pas urgent', NULL, 1, 0, 'normal', NULL, NULL, NULL, 0, NULL, NULL, NULL, 7, NULL, 9, NULL, '2026-07-29 19:19:16', '2026-08-27 19:13:48'),
(4, 'DEP-2026-0001', 'depart', NULL, 'demande de matériels', '2026/009', NULL, NULL, NULL, NULL, NULL, 'normal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Non spécifié', 'usine fer sarl', '2026-08-27', NULL, NULL, NULL, NULL, 'receptionne', NULL, 'scans_courriers/nL32qBGWk6BpfLlHYEgC9rO3cGxUCCraRRJFQZ2j.pdf', 1, 0, 'normal', NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, 2, NULL, '2026-07-30 20:10:42', '2026-08-27 19:13:20'),
(5, 'DEP-2026-0002', 'depart', NULL, 'demande de matériels', '2026/009', NULL, NULL, NULL, NULL, NULL, 'normal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Non spécifié', 'usine fer sarl', '2026-07-30', NULL, NULL, NULL, NULL, 'en_attente_reception', NULL, 'scans_courriers/knxCxRW9lFwN7IIfGt48oEnaqK8RLzaU3SV4DWTI.pdf', 1, 0, 'normal', NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2026-07-30 20:49:22', '2026-07-30 20:49:22'),
(6, 'DEP-2026-0003', 'depart', NULL, 'demande de matériels', '2026/009', NULL, NULL, NULL, NULL, NULL, 'normal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Non spécifié', 'usine fer sarl', '2026-07-30', NULL, NULL, NULL, NULL, 'en_attente_reception', NULL, 'scans_courriers/mjCzYbIXZVZTf3dtzn5T2RmSQAPoegbFtTcBqdTT.pdf', 1, 0, 'normal', NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2026-07-30 20:49:59', '2026-07-30 20:49:59'),
(7, 'DEP-2026-0004', 'depart', NULL, 'prêt', '2026/009', NULL, NULL, NULL, NULL, NULL, 'normal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Non spécifié', 'Culture', NULL, NULL, NULL, '2026-07-31', NULL, 'en_attente_reception', NULL, 'scans_courriers/RJ7EHstZ0FFHukvFkOezBOAiGB74c2DfQXbhMvzd.pdf', 1, 0, 'normal', NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, 1, NULL, '2026-07-31 09:33:58', '2026-07-31 11:27:34'),
(8, 'INT-2026-0001', 'interne', NULL, 'facturers', '2026/003', NULL, NULL, NULL, NULL, NULL, 'normal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Mécanisation', 'Distillerie', '2026-08-12', NULL, NULL, '2026-08-28', NULL, 'en_attente_reception', 'bjkkl', 'scans_courriers/uhmw5StPdlnOct1s68iXimIOqjkXiNjsBuhBaxRl.pdf', 1, 0, 'normal', NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, 8, NULL, '2026-08-08 22:43:13', '2026-08-08 22:43:13'),
(9, 'ARR-2026-0004', 'arrivee', NULL, 'Demande stage', '2026/009', NULL, NULL, NULL, NULL, NULL, 'normal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Non spécifié', 'Non spécifié', '2026-08-10', NULL, NULL, NULL, NULL, 'en_attente_reception', NULL, 'scans_courriers/yMSguyRUM2tMaouWTBqYUNoeNVApeVmO32P7n7zr.pdf', 1, 0, 'normal', NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2026-08-10 17:46:27', '2026-08-10 17:46:27'),
(10, 'ARR-2026-0005', 'arrivee', NULL, 'Demande stage', '2026/009', NULL, NULL, NULL, NULL, NULL, 'normal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Non spécifié', 'Non spécifié', '2026-08-10', NULL, NULL, NULL, NULL, 'en_attente_reception', NULL, 'scans_courriers/kXd6YAXydepfwq3HHPffl6awklB2wfDar79dmdqR.pdf', 1, 0, 'normal', NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2026-08-10 17:46:29', '2026-08-10 17:46:29'),
(11, 'ARR-2026-0006', 'arrivee', NULL, 'Demande stage', '2026/009', NULL, NULL, NULL, NULL, NULL, 'normal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Non spécifié', 'Non spécifié', '2026-08-11', NULL, NULL, NULL, NULL, 'en_attente_reception', NULL, 'scans_courriers/ngqFpbgGkp1npMQYC4ZwvLvowNyvg8dTuwxO0lB5.pdf', 1, 0, 'normal', NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2026-08-11 12:10:06', '2026-08-11 12:10:06'),
(12, 'ARR-2026-0007', 'arrivee', NULL, 'verification de l\'auto-génération', '2022/001', NULL, NULL, NULL, NULL, NULL, 'normal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Non spécifié', 'Non spécifié', '2026-08-11', NULL, NULL, NULL, NULL, 'en_attente_reception', NULL, 'scans_courriers/u9gcn5DKNzroFqrb9ZwxH32I1rJsjyOxxC5u29zq.pdf', 1, 0, 'normal', NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2026-08-11 17:20:13', '2026-08-11 17:20:13'),
(13, 'DEP-2026-0005', 'depart', NULL, 'facturers', '2026/003', NULL, NULL, NULL, NULL, NULL, 'normal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Non spécifié', 'Non spécifié', '2026-08-13', NULL, NULL, NULL, NULL, 'en_attente_reception', NULL, 'scans_courriers/RahtX7U6W5q1ppF7kfLXNdmOtzvaSlxNp3y1mcC5.pdf', 1, 0, 'normal', NULL, NULL, NULL, 0, NULL, NULL, NULL, 10, NULL, NULL, NULL, '2026-08-13 07:23:18', '2026-08-13 07:23:18'),
(14, 'DEP-2026-0006', 'depart', NULL, 'facturers', '2026/003', NULL, NULL, NULL, NULL, NULL, 'normal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Non spécifié', 'Non spécifié', '2026-08-13', NULL, NULL, NULL, NULL, 'en_attente_reception', NULL, 'scans_courriers/JP9iwzq6zFz7sdfaYtetWnEWeQIOiWfqyWl9nJLE.pdf', 1, 0, 'normal', NULL, NULL, NULL, 0, NULL, NULL, NULL, 10, NULL, NULL, NULL, '2026-08-13 07:23:21', '2026-08-13 07:23:21'),
(15, 'ARR-2026-0008', 'arrivee', NULL, 'Demande stage', '2026/011', NULL, NULL, NULL, NULL, NULL, 'normal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Non spécifié', 'Non spécifié', '2026-08-13', NULL, NULL, NULL, NULL, 'en_attente_reception', NULL, 'scans_courriers/x6L1Iz8CWGWscJL99z1WtK12lCKE2n50HB8bz9vb.pdf', 1, 0, 'normal', NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2026-08-13 10:36:42', '2026-08-13 10:36:42'),
(16, 'INT-2026-0002', 'interne', NULL, 'Demande stage', '2026/005', NULL, NULL, NULL, NULL, NULL, 'normal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Culture', 'Département Qualité', '2026-08-24', NULL, NULL, NULL, NULL, 'en_attente_reception', NULL, 'scans_courriers/mE8QAV3DU6x4cAVHMsdr4u7dJzRHM1te5th3qv2N.pdf', 1, 0, 'normal', NULL, NULL, NULL, 0, NULL, NULL, NULL, 10, NULL, 1, NULL, '2026-08-24 13:32:59', '2026-08-24 13:32:59'),
(17, 'ARR-2026-0009', 'arrivee', NULL, 'Demande de stage', '2026/010', NULL, NULL, NULL, NULL, NULL, 'normal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Traoré Mariame', 'culture', NULL, NULL, NULL, NULL, NULL, 'en_attente_reception', NULL, 'scans_courriers/LFninGRtL3jDMA3BHpGd1c8FRJoqe5eI7AbmVxm7.pdf', 1, 0, 'normal', NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2026-08-27 10:35:20', '2026-08-27 10:38:09'),
(18, 'ARR-2026-0010', 'arrivee', NULL, 'Test Workflow', 'NON-DEFINIE', NULL, NULL, NULL, NULL, NULL, 'normal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Kan Jean', 'secretaire culture', NULL, NULL, NULL, NULL, NULL, 'en_attente_reception', NULL, 'scans_courriers/Mj0M2HIbS3d68St5qwpPdzYQ1HNbosA23VplwSNB.jpg', 1, 0, 'normal', NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2026-08-27 12:35:35', '2026-08-27 12:37:59'),
(19, 'ARR-2026-0011', 'arrivee', NULL, 'Test Workflow', 'NON-DEFINIE', NULL, NULL, NULL, NULL, NULL, 'normal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Kan Jean', 'Non spécifié', NULL, NULL, NULL, NULL, NULL, 'en_attente_reception', NULL, 'scans_courriers/ME4Km0H5LpipjgwGa0Z1pHeCOJByKAUzUlTSBKBG.pdf', 1, 0, 'normal', NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2026-08-28 07:44:41', '2026-08-28 07:44:41'),
(20, 'DEP-2026-0007', 'depart', NULL, 'factures', 'NON-DEFINIE', NULL, NULL, NULL, NULL, NULL, 'normal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Non spécifié', 'BAF', NULL, NULL, NULL, NULL, NULL, 'en_attente_reception', NULL, 'scans_courriers/wtuuzBMoYbZD2yM3sF3pp1QTjt0biQf9Wg84Q3GF.pdf', 1, 0, 'normal', NULL, NULL, NULL, 0, NULL, NULL, NULL, 10, NULL, NULL, NULL, '2026-08-28 09:39:40', '2026-08-28 09:39:40'),
(21, 'INT-2026-0003', 'interne', NULL, 'Facture', 'NON-DEFINIE', NULL, NULL, NULL, NULL, NULL, 'normal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Non spécifié', 'Non spécifié', '2026-08-29', NULL, NULL, NULL, NULL, 'en_attente_decision', NULL, 'scans_courriers/xwwiUDfcod67ry5GZdrc4Rf6Y8lNBvs2nAt1Kmoc.pdf', 1, 0, 'normal', NULL, NULL, NULL, 0, NULL, NULL, NULL, 7, NULL, 9, NULL, '2026-08-28 10:23:39', '2026-09-08 23:39:52'),
(22, 'ARR-2026-0012', 'arrivee', NULL, 'Demande stage', '2026/009', NULL, NULL, NULL, NULL, NULL, 'normal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Non spécifié', 'Non spécifié', NULL, NULL, NULL, '2026-08-30', NULL, 'en_attente_reception', NULL, 'scans_courriers/ApaQHrD3INhEn3mQ1Uk4sXuOZBp848kn9EatDc5P.pdf', 1, 0, 'normal', NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2026-08-30 10:04:16', '2026-08-30 10:04:16'),
(23, 'DEP-2026-0008', 'depart', NULL, 'Demande stage', '2026/011', NULL, NULL, NULL, NULL, NULL, 'normal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Non spécifié', 'culure', NULL, NULL, NULL, '2026-08-30', NULL, 'en_attente_reception', NULL, 'scans_courriers/EGfSqCAY6WmcDJpGC9LADAbqJZOgAQtBMD0zQoLU.jpg', 1, 0, 'normal', NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2026-08-30 10:10:55', '2026-08-30 10:10:55'),
(24, 'ARR-2026-0013', 'arrivee', NULL, 'Demande stage', '2026/012', NULL, NULL, NULL, NULL, NULL, 'normal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Kan Jean', 'Non spécifié', '2026-08-30', NULL, NULL, '2026-08-30', NULL, 'receptionne', NULL, 'scans_courriers/bwDxI9TsJhZJBuxmlVeQmT9aZF7VgUJKMrUk3luR.jpg', 1, 0, 'normal', NULL, NULL, NULL, 0, NULL, NULL, NULL, 9, NULL, NULL, NULL, '2026-08-30 10:28:17', '2026-08-30 14:59:42'),
(25, 'INT-2026-0004', 'interne', NULL, 'Demande stage', '2026/011', NULL, NULL, NULL, NULL, NULL, 'normal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Non spécifié', 'commercial', '2026-08-30', NULL, NULL, NULL, NULL, 'en_attente_decision', NULL, 'scans_courriers/jjl2hUZnFyZA0hBTe3p9OGioREvSobBOaAXlGnlH.jpg', 1, 0, 'normal', NULL, NULL, NULL, 0, NULL, NULL, NULL, 7, NULL, 9, NULL, '2026-08-30 14:56:43', '2026-08-30 14:57:21'),
(26, 'ARR-2026-0014', 'arrivee', NULL, 'Test courrier arrivé', 'TEST-2026-0001', '2026-09-05', '08:51:00', '2026-09-04', NULL, '2026-09-05', 'normal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'OBC', 'Commercial', '2026-09-05', NULL, NULL, NULL, NULL, 'pris_en_charge', NULL, 'scans_courriers/8eQu4ZE1E2EJEFf3SafD3KcmEXLPCx9vwCYpX6gn.pdf', 1, 1, 'normal', NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, 2, NULL, '2026-09-05 07:58:26', '2026-09-05 08:15:53'),
(27, 'ARR-2026-0015', 'arrivee', NULL, 'Test courrier arrivé', 'TEST-2026-0001', '2026-09-08', '10:04:00', '2026-09-04', 'facture', '2026-09-08', 'normal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'ABC', 'Commercial', '2026-09-08', NULL, NULL, NULL, NULL, 'pris_en_charge', NULL, 'scans_courriers/pIPQvXkyeqDFjIgKZKneapbMv1mLJBrgxu2nBAns.pdf', 1, 1, 'normal', NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, 2, NULL, '2026-09-08 09:05:35', '2026-09-08 09:09:49'),
(28, 'INT-2026-0005', 'interne', 'transit', 'Testinitié', '2026/014', '2026-09-08', '23:15:00', NULL, NULL, '2026-09-08', 'normal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Non spécifié', 'Communication', '2026-09-09', NULL, NULL, NULL, NULL, 'en_attente_reception', NULL, 'scans_courriers/grmanF9d5LZwoJ8ehi0JxiKKbLos1YXv5NnUNy0H.pdf', 1, 0, 'normal', NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, 3, NULL, '2026-09-08 22:17:09', '2026-09-08 23:29:23'),
(29, 'ARR-2026-0016', 'arrivee', 'initie', 'Demande stage', 'STAGE-2026-0001', '2026-09-11', '00:51:00', '2026-09-04', 'lettre', '2026-09-11', 'normal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Anna', 'Commercial', '2026-09-11', NULL, NULL, NULL, NULL, 'a_modifier', '--- 📤 Envoyé au directeur par Assita Traoré ---\r\n\r\n--- ✅ Décision du Directeur (Edmond Kaboré) ---\r\nDécision: Modifie\r\nCommentaire: Aucun commentaire\r\nDate: 11/09/2026 01:09', 'scans_courriers/oC1D1ciHUasPcxfkb09YlBYgyIcxyKRxBJVCmFbc.pdf', 1, 1, 'normal', NULL, NULL, NULL, 0, NULL, NULL, NULL, 12, NULL, 2, NULL, '2026-09-10 23:52:58', '2026-09-11 00:10:35');

-- --------------------------------------------------------

--
-- Structure de la table `departements`
--

DROP TABLE IF EXISTS `departements`;
CREATE TABLE IF NOT EXISTS `departements` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `departements_code_unique` (`code`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `departements`
--

INSERT INTO `departements` (`id`, `nom`, `code`, `created_at`, `updated_at`) VALUES
(1, 'Culture', 'CUL', '2026-07-29 16:00:24', '2026-07-29 16:00:24'),
(2, 'Commercial', 'COM', '2026-07-29 16:00:24', '2026-07-29 16:00:24'),
(3, 'Communication', 'COMM', '2026-07-29 16:00:24', '2026-07-29 16:00:24'),
(4, 'Direction Générale', 'DG', '2026-07-29 16:00:24', '2026-07-29 16:00:24'),
(5, 'Direction Industrie', 'DI', '2026-07-29 16:00:24', '2026-07-29 16:00:24'),
(6, 'Département Qualité', 'DQ', '2026-07-29 16:00:24', '2026-07-29 16:00:24'),
(7, 'Ressources Humaines', 'RH', '2026-07-29 16:00:24', '2026-07-29 16:00:24'),
(8, 'Mécanisation', 'MEC', '2026-07-29 16:00:24', '2026-07-29 16:00:24'),
(9, 'Achats et Stocks', 'AS', '2026-07-29 16:00:24', '2026-07-29 16:00:24'),
(10, 'Distillerie', 'DIST', '2026-07-29 16:00:24', '2026-07-29 16:00:24'),
(11, 'Direction Exploitation', 'DE', '2026-07-29 16:00:24', '2026-07-29 16:00:24');

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_07_28_201335_create_departements_table', 1),
(6, '2026_07_28_201708_create_courriers_table', 1),
(7, '2026_07_28_213349_add_scan_and_number_to_courriers_table', 2),
(8, '2026_07_30_104915_create_categories_table', 3),
(9, '2026_07_30_105128_add_categorie_id_to_courriers_table', 3),
(10, '2026_07_30_121724_create_audit_logs_table', 4),
(11, '2026_07_31_095648_create_notifications_table', 5),
(14, '2026_08_03_074407_create_type_courriers_table', 7),
(13, '2026_08_08_224643_add_date_validation_to_courriers_table', 6),
(15, '2026_08_09_075121_create_roles_table', 8),
(16, '2026_08_09_083518_create_workflows_table', 9),
(17, '2026_08_09_083532_create_workflow_etapes_table', 9),
(18, '2026_08_17_053548_add_permissions_to_roles_table', 10),
(19, '2026_08_24_105653_create_role_user_table', 11),
(20, '2026_08_24_111553_create_workflows_table', 12),
(21, '2026_08_24_120157_add_name_column_to_workflows_table', 12),
(22, '2026_08_25_091913_create_permissions_table', 13),
(23, '2026_08_25_101156_drop_permissions_column_from_roles_table', 14),
(24, '2026_08_27_100549_update_statuts_courriers_table', 15),
(25, '2026_08_29_074303_create_permissions_and_role_permissions_tables', 16),
(26, '2026_09_01_090704_add_sous_type_to_courriers_table', 17),
(27, '2026_09_03_131304_add_champs_arrivee_depart_to_courriers_table', 18),
(28, '2026_09_03_133835_add_workflow_fields_to_courriers_table', 19),
(29, '2026_09_03_215832_add_champs_depart_suivi_to_courriers_table', 20);

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('1aea0916-8904-4402-a2bc-aa2cfb6bf010', 'App\\Notifications\\NouveauCourrierNotification', 'App\\Models\\User', 1, '{\"message\":\"Nouveau courrier N\\u00b0 DEP-2026-0004 en attente de distribution.\",\"courrier_id\":7,\"type\":\"nouveau_courrier\"}', '2026-07-31 10:30:47', '2026-07-31 09:33:58', '2026-07-31 10:30:47'),
('2a32a363-4077-4c31-8ea5-2d2d7ec54dea', 'App\\Notifications\\NouveauCourrierNotification', 'App\\Models\\User', 8, '{\"message\":\"Nouveau courrier N\\u00b0 DEP-2026-0004 en attente de distribution.\",\"courrier_id\":7,\"type\":\"nouveau_courrier\"}', NULL, '2026-07-31 09:33:58', '2026-07-31 09:33:58'),
('678452f3-3115-492a-bd46-bbed4f82866f', 'App\\Notifications\\NouveauCourrierNotification', 'App\\Models\\User', 9, '{\"message\":\"Nouveau courrier N\\u00b0 DEP-2026-0004 en attente de distribution.\",\"courrier_id\":7,\"type\":\"nouveau_courrier\"}', NULL, '2026-07-31 09:33:58', '2026-07-31 09:33:58'),
('bd24516b-d18e-4ec8-8a46-adfd497ab9c7', 'App\\Notifications\\NouveauCourrierNotification', 'App\\Models\\User', 1, '{\"message\":\"Nouveau courrier N\\u00b0 INT-2026-0001 en attente de distribution.\",\"courrier_id\":8,\"type\":\"nouveau_courrier\"}', '2026-08-09 06:36:02', '2026-08-08 22:43:14', '2026-08-09 06:36:02'),
('71525049-45c7-4ddc-ab2f-aad4d69ec6d3', 'App\\Notifications\\NouveauCourrierNotification', 'App\\Models\\User', 8, '{\"message\":\"Nouveau courrier N\\u00b0 INT-2026-0001 en attente de distribution.\",\"courrier_id\":8,\"type\":\"nouveau_courrier\"}', NULL, '2026-08-08 22:43:14', '2026-08-08 22:43:14'),
('63a9e84a-024e-4be0-af1e-03c586de70e8', 'App\\Notifications\\NouveauCourrierNotification', 'App\\Models\\User', 9, '{\"message\":\"Nouveau courrier N\\u00b0 INT-2026-0001 en attente de distribution.\",\"courrier_id\":8,\"type\":\"nouveau_courrier\"}', NULL, '2026-08-08 22:43:14', '2026-08-08 22:43:14'),
('bfff1ac3-e499-41b2-b444-b012e3db0edc', 'App\\Notifications\\NouveauCourrierNotification', 'App\\Models\\User', 1, '{\"message\":\"Nouveau courrier N\\u00b0 ARR-2026-0004 en attente de distribution.\",\"courrier_id\":9,\"type\":\"nouveau_courrier\"}', '2026-08-26 12:46:52', '2026-08-10 17:46:29', '2026-08-26 12:46:52'),
('6ccc8d5c-b618-4cca-a5fc-4687c7984a9f', 'App\\Notifications\\NouveauCourrierNotification', 'App\\Models\\User', 8, '{\"message\":\"Nouveau courrier N\\u00b0 ARR-2026-0004 en attente de distribution.\",\"courrier_id\":9,\"type\":\"nouveau_courrier\"}', NULL, '2026-08-10 17:46:29', '2026-08-10 17:46:29'),
('839caad2-3969-46e4-bebd-6d9121da0ddd', 'App\\Notifications\\NouveauCourrierNotification', 'App\\Models\\User', 9, '{\"message\":\"Nouveau courrier N\\u00b0 ARR-2026-0004 en attente de distribution.\",\"courrier_id\":9,\"type\":\"nouveau_courrier\"}', NULL, '2026-08-10 17:46:29', '2026-08-10 17:46:29'),
('70eface0-eb30-4854-8fc9-c92c8be6804a', 'App\\Notifications\\NouveauCourrierNotification', 'App\\Models\\User', 1, '{\"message\":\"Nouveau courrier N\\u00b0 ARR-2026-0005 en attente de distribution.\",\"courrier_id\":10,\"type\":\"nouveau_courrier\"}', '2026-08-26 12:46:52', '2026-08-10 17:46:29', '2026-08-26 12:46:52'),
('dfeed311-6221-49fc-8105-9d5b4b8f3cf4', 'App\\Notifications\\NouveauCourrierNotification', 'App\\Models\\User', 8, '{\"message\":\"Nouveau courrier N\\u00b0 ARR-2026-0005 en attente de distribution.\",\"courrier_id\":10,\"type\":\"nouveau_courrier\"}', NULL, '2026-08-10 17:46:29', '2026-08-10 17:46:29'),
('1b723e9d-0909-44c1-a900-ced353b6ac3a', 'App\\Notifications\\NouveauCourrierNotification', 'App\\Models\\User', 9, '{\"message\":\"Nouveau courrier N\\u00b0 ARR-2026-0005 en attente de distribution.\",\"courrier_id\":10,\"type\":\"nouveau_courrier\"}', NULL, '2026-08-10 17:46:29', '2026-08-10 17:46:29'),
('702976e4-bab8-48b1-95ef-04c513fd88d3', 'App\\Notifications\\NouveauCourrierNotification', 'App\\Models\\User', 1, '{\"message\":\"Nouveau courrier N\\u00b0 ARR-2026-0006 en attente de distribution.\",\"courrier_id\":11,\"type\":\"nouveau_courrier\"}', '2026-08-26 12:46:52', '2026-08-11 12:10:08', '2026-08-26 12:46:52'),
('a2ae31c1-5b30-4db4-9c5e-a98430fa813a', 'App\\Notifications\\NouveauCourrierNotification', 'App\\Models\\User', 8, '{\"message\":\"Nouveau courrier N\\u00b0 ARR-2026-0006 en attente de distribution.\",\"courrier_id\":11,\"type\":\"nouveau_courrier\"}', NULL, '2026-08-11 12:10:08', '2026-08-11 12:10:08'),
('a4253a25-b9ff-426c-949a-67227c2060e0', 'App\\Notifications\\NouveauCourrierNotification', 'App\\Models\\User', 9, '{\"message\":\"Nouveau courrier N\\u00b0 ARR-2026-0006 en attente de distribution.\",\"courrier_id\":11,\"type\":\"nouveau_courrier\"}', NULL, '2026-08-11 12:10:08', '2026-08-11 12:10:08'),
('dd59fda3-5461-475b-9dc8-c07489694507', 'App\\Notifications\\NouveauCourrierNotification', 'App\\Models\\User', 1, '{\"message\":\"Nouveau courrier N\\u00b0 ARR-2026-0007 en attente de distribution.\",\"courrier_id\":12,\"type\":\"nouveau_courrier\"}', '2026-08-26 12:46:52', '2026-08-11 17:20:13', '2026-08-26 12:46:52'),
('6085a88e-9dcc-47da-bee4-f2ee63c44a7b', 'App\\Notifications\\NouveauCourrierNotification', 'App\\Models\\User', 8, '{\"message\":\"Nouveau courrier N\\u00b0 ARR-2026-0007 en attente de distribution.\",\"courrier_id\":12,\"type\":\"nouveau_courrier\"}', NULL, '2026-08-11 17:20:13', '2026-08-11 17:20:13'),
('200c770e-bfdb-4355-ae4a-d1f1f410b40d', 'App\\Notifications\\NouveauCourrierNotification', 'App\\Models\\User', 9, '{\"message\":\"Nouveau courrier N\\u00b0 ARR-2026-0007 en attente de distribution.\",\"courrier_id\":12,\"type\":\"nouveau_courrier\"}', NULL, '2026-08-11 17:20:13', '2026-08-11 17:20:13'),
('d7a673c7-c62f-4217-89e9-cd5ac1870ddb', 'App\\Notifications\\NouveauCourrierNotification', 'App\\Models\\User', 1, '{\"message\":\"Nouveau courrier N\\u00b0 DEP-2026-0005 en attente de distribution.\",\"courrier_id\":13,\"type\":\"nouveau_courrier\"}', '2026-08-26 12:46:52', '2026-08-13 07:23:21', '2026-08-26 12:46:52'),
('fe6a988c-8a26-48ba-b27c-909c8f74cc2b', 'App\\Notifications\\NouveauCourrierNotification', 'App\\Models\\User', 8, '{\"message\":\"Nouveau courrier N\\u00b0 DEP-2026-0005 en attente de distribution.\",\"courrier_id\":13,\"type\":\"nouveau_courrier\"}', NULL, '2026-08-13 07:23:21', '2026-08-13 07:23:21'),
('50445cca-f8e5-4af4-b6e7-3436d03642bb', 'App\\Notifications\\NouveauCourrierNotification', 'App\\Models\\User', 9, '{\"message\":\"Nouveau courrier N\\u00b0 DEP-2026-0005 en attente de distribution.\",\"courrier_id\":13,\"type\":\"nouveau_courrier\"}', NULL, '2026-08-13 07:23:21', '2026-08-13 07:23:21'),
('69291fc6-0a54-4aae-844e-e824802a8da5', 'App\\Notifications\\NouveauCourrierNotification', 'App\\Models\\User', 1, '{\"message\":\"Nouveau courrier N\\u00b0 DEP-2026-0006 en attente de distribution.\",\"courrier_id\":14,\"type\":\"nouveau_courrier\"}', '2026-08-26 12:46:52', '2026-08-13 07:23:21', '2026-08-26 12:46:52'),
('16668b7d-e9be-4599-b70b-df3420246ec5', 'App\\Notifications\\NouveauCourrierNotification', 'App\\Models\\User', 8, '{\"message\":\"Nouveau courrier N\\u00b0 DEP-2026-0006 en attente de distribution.\",\"courrier_id\":14,\"type\":\"nouveau_courrier\"}', NULL, '2026-08-13 07:23:21', '2026-08-13 07:23:21'),
('a1c7be52-295b-4dbf-a26c-7af6d55a0189', 'App\\Notifications\\NouveauCourrierNotification', 'App\\Models\\User', 9, '{\"message\":\"Nouveau courrier N\\u00b0 DEP-2026-0006 en attente de distribution.\",\"courrier_id\":14,\"type\":\"nouveau_courrier\"}', NULL, '2026-08-13 07:23:21', '2026-08-13 07:23:21'),
('e61315d0-1f27-49ef-8437-61d6d907f510', 'App\\Notifications\\NouveauCourrierNotification', 'App\\Models\\User', 1, '{\"message\":\"Nouveau courrier N\\u00b0 ARR-2026-0008 en attente de distribution.\",\"courrier_id\":15,\"type\":\"nouveau_courrier\"}', '2026-08-26 12:46:52', '2026-08-13 10:36:42', '2026-08-26 12:46:52'),
('e7a27038-1331-4f95-81a6-270974dbde3e', 'App\\Notifications\\NouveauCourrierNotification', 'App\\Models\\User', 8, '{\"message\":\"Nouveau courrier N\\u00b0 ARR-2026-0008 en attente de distribution.\",\"courrier_id\":15,\"type\":\"nouveau_courrier\"}', NULL, '2026-08-13 10:36:42', '2026-08-13 10:36:42'),
('de0508a9-c829-44f2-9fb4-a753fafa3565', 'App\\Notifications\\NouveauCourrierNotification', 'App\\Models\\User', 9, '{\"message\":\"Nouveau courrier N\\u00b0 ARR-2026-0008 en attente de distribution.\",\"courrier_id\":15,\"type\":\"nouveau_courrier\"}', NULL, '2026-08-13 10:36:42', '2026-08-13 10:36:42'),
('7c14799e-6779-4cc4-b97b-7ad033c4d27d', 'App\\Notifications\\NouveauCourrierNotification', 'App\\Models\\User', 1, '{\"message\":\"Nouveau courrier N\\u00b0 INT-2026-0002 en attente de distribution.\",\"courrier_id\":16,\"type\":\"nouveau_courrier\"}', '2026-08-26 12:46:52', '2026-08-24 13:32:59', '2026-08-26 12:46:52'),
('80430d7c-c806-454b-b599-a67ea1654255', 'App\\Notifications\\NouveauCourrierNotification', 'App\\Models\\User', 9, '{\"message\":\"Nouveau courrier N\\u00b0 INT-2026-0002 en attente de distribution.\",\"courrier_id\":16,\"type\":\"nouveau_courrier\"}', NULL, '2026-08-24 13:32:59', '2026-08-24 13:32:59'),
('b1ad012c-c5f4-4544-9503-3a46bae41964', 'App\\Notifications\\NouveauCourrierNotification', 'App\\Models\\User', 1, '{\"message\":\"Nouveau courrier N\\u00b0 ARR-2026-0009 en attente de distribution.\",\"courrier_id\":17,\"type\":\"nouveau_courrier\"}', NULL, '2026-08-27 10:35:21', '2026-08-27 10:35:21'),
('05cc08a7-a164-448a-881b-8f40a8c3e9ae', 'App\\Notifications\\NouveauCourrierNotification', 'App\\Models\\User', 9, '{\"message\":\"Nouveau courrier N\\u00b0 ARR-2026-0009 en attente de distribution.\",\"courrier_id\":17,\"type\":\"nouveau_courrier\"}', NULL, '2026-08-27 10:35:21', '2026-08-27 10:35:21'),
('d9b2023b-c377-452d-ac04-641183229f32', 'App\\Notifications\\NouveauCourrierNotification', 'App\\Models\\User', 1, '{\"message\":\"Nouveau courrier N\\u00b0 ARR-2026-0010 en attente de distribution.\",\"courrier_id\":18,\"type\":\"nouveau_courrier\"}', NULL, '2026-08-27 12:35:35', '2026-08-27 12:35:35'),
('9e4578fb-8937-4201-ad32-a0b15f62481c', 'App\\Notifications\\NouveauCourrierNotification', 'App\\Models\\User', 9, '{\"message\":\"Nouveau courrier N\\u00b0 ARR-2026-0010 en attente de distribution.\",\"courrier_id\":18,\"type\":\"nouveau_courrier\"}', NULL, '2026-08-27 12:35:35', '2026-08-27 12:35:35'),
('8c828c84-20f2-47d6-bafe-fb346cc1e8c2', 'App\\Notifications\\NouveauCourrierNotification', 'App\\Models\\User', 7, '{\"message\":\"Nouveau courrier N\\u00b0 ARR-2026-0003 en attente de distribution.\",\"courrier_id\":3,\"type\":\"nouveau_courrier\"}', NULL, '2026-08-27 19:13:48', '2026-08-27 19:13:48'),
('3f3e72ca-f030-4d97-9ac9-458a968f85a1', 'App\\Notifications\\NouveauCourrierNotification', 'App\\Models\\User', 7, '{\"message\":\"Nouveau courrier N\\u00b0 INT-2026-0004 en attente de distribution.\",\"courrier_id\":25,\"type\":\"nouveau_courrier\"}', NULL, '2026-08-30 14:57:22', '2026-08-30 14:57:22'),
('781f3184-1b75-4710-8932-2d9124bbb9cd', 'App\\Notifications\\NouveauCourrierNotification', 'App\\Models\\User', 7, '{\"message\":\"Nouveau courrier N\\u00b0 ARR-2026-0002 en attente de distribution.\",\"courrier_id\":2,\"type\":\"nouveau_courrier\"}', NULL, '2026-08-30 15:12:31', '2026-08-30 15:12:31'),
('0b9c0afa-6316-4d4d-aa9b-06088aa67f1f', 'App\\Notifications\\NouveauCourrierNotification', 'App\\Models\\User', 10, '{\"message\":\"Nouveau courrier N\\u00b0 ARR-2026-0014 en attente de distribution.\",\"courrier_id\":26,\"type\":\"nouveau_courrier\"}', NULL, '2026-09-05 08:09:16', '2026-09-05 08:09:16'),
('5ddda849-6a8e-4d64-9515-49c7111a182d', 'App\\Notifications\\NouveauCourrierNotification', 'App\\Models\\User', 12, '{\"message\":\"Nouveau courrier N\\u00b0 ARR-2026-0014 en attente de distribution.\",\"courrier_id\":26,\"type\":\"nouveau_courrier\"}', NULL, '2026-09-05 08:09:16', '2026-09-05 08:09:16'),
('4d246554-d9df-4507-b99e-3c1e3b5a254a', 'App\\Notifications\\NouveauCourrierNotification', 'App\\Models\\User', 10, '{\"message\":\"Nouveau courrier N\\u00b0 ARR-2026-0015 en attente de distribution.\",\"courrier_id\":27,\"type\":\"nouveau_courrier\"}', NULL, '2026-09-08 09:06:58', '2026-09-08 09:06:58'),
('d86caecb-c70b-4200-8cd1-a9fde13e62d9', 'App\\Notifications\\NouveauCourrierNotification', 'App\\Models\\User', 12, '{\"message\":\"Nouveau courrier N\\u00b0 ARR-2026-0015 en attente de distribution.\",\"courrier_id\":27,\"type\":\"nouveau_courrier\"}', NULL, '2026-09-08 09:06:58', '2026-09-08 09:06:58'),
('43d6e54e-de9b-4ee3-a54a-241761fbc514', 'App\\Notifications\\NouveauCourrierNotification', 'App\\Models\\User', 10, '{\"message\":\"Nouveau courrier N\\u00b0 INT-2026-0005 en attente de distribution.\",\"courrier_id\":28,\"type\":\"nouveau_courrier\"}', NULL, '2026-09-08 22:17:48', '2026-09-08 22:17:48'),
('3f6a2d7c-280c-437b-9aee-2f504dcbfef9', 'App\\Notifications\\NouveauCourrierNotification', 'App\\Models\\User', 12, '{\"message\":\"Nouveau courrier N\\u00b0 INT-2026-0005 en attente de distribution.\",\"courrier_id\":28,\"type\":\"nouveau_courrier\"}', NULL, '2026-09-08 22:17:48', '2026-09-08 22:17:48'),
('a2eb044d-7b78-434d-8dd8-2404e64b6f76', 'App\\Notifications\\NouveauCourrierNotification', 'App\\Models\\User', 11, '{\"message\":\"Nouveau courrier N\\u00b0 INT-2026-0005 en attente de distribution.\",\"courrier_id\":28,\"type\":\"nouveau_courrier\"}', NULL, '2026-09-08 23:29:23', '2026-09-08 23:29:23'),
('04f221d9-fff2-4905-a1c3-85fd698e8648', 'App\\Notifications\\NouveauCourrierNotification', 'App\\Models\\User', 7, '{\"message\":\"Nouveau courrier N\\u00b0 INT-2026-0003 en attente de distribution.\",\"courrier_id\":21,\"type\":\"nouveau_courrier\"}', NULL, '2026-09-08 23:39:52', '2026-09-08 23:39:52'),
('2a8a809a-245d-4fe7-9400-1a91b3e34879', 'App\\Notifications\\NouveauCourrierNotification', 'App\\Models\\User', 10, '{\"message\":\"Nouveau courrier N\\u00b0 ARR-2026-0016 en attente de distribution.\",\"courrier_id\":29,\"type\":\"nouveau_courrier\"}', NULL, '2026-09-10 23:53:45', '2026-09-10 23:53:45'),
('41913f33-7a76-41f3-b304-9f01aefe8843', 'App\\Notifications\\NouveauCourrierNotification', 'App\\Models\\User', 12, '{\"message\":\"Nouveau courrier N\\u00b0 ARR-2026-0016 en attente de distribution.\",\"courrier_id\":29,\"type\":\"nouveau_courrier\"}', NULL, '2026-09-10 23:53:45', '2026-09-10 23:53:45'),
('fee7e5e4-4fc1-4cd8-81cf-0562bc896ed7', 'App\\Notifications\\NouveauCourrierNotification', 'App\\Models\\User', 12, '{\"message\":\"Nouveau courrier N\\u00b0 ARR-2026-0016 en attente de distribution.\",\"courrier_id\":29,\"type\":\"nouveau_courrier\"}', NULL, '2026-09-11 00:08:53', '2026-09-11 00:08:53');

-- --------------------------------------------------------

--
-- Structure de la table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_nom_unique` (`nom`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `permissions`
--

INSERT INTO `permissions` (`id`, `nom`, `label`, `created_at`, `updated_at`) VALUES
(1, 'creer_courrier', 'Créer un courrier', '2026-08-29 06:55:58', '2026-08-29 06:55:58'),
(2, 'distribuer_courrier', 'Distribuer un courrier (Standardiste)', '2026-08-29 06:55:58', '2026-08-29 06:55:58'),
(3, 'receptionner_courrier', 'Réceptionner un courrier', '2026-08-29 06:55:58', '2026-08-29 06:55:58'),
(4, 'envoyer_courrier', 'Envoyer un courrier au directeur', '2026-08-29 06:55:58', '2026-08-29 06:55:58'),
(5, 'traiter_courrier', 'Traiter/Valider un courrier (Directeur)', '2026-08-29 06:55:58', '2026-08-29 06:55:58'),
(6, 'supprimer_courrier', 'Supprimer un courrier', '2026-08-29 06:55:58', '2026-08-29 06:55:58'),
(7, 'voir_audit', 'Voir le journal d\'audit', '2026-08-29 06:55:58', '2026-08-29 06:55:58'),
(8, 'gerer_utilisateurs', 'Gérer les utilisateurs', '2026-08-29 06:55:58', '2026-08-29 06:55:58'),
(9, 'nouvelle_permission', 'Nouvelle permission', '2026-09-01 07:12:07', '2026-09-01 07:12:07');

-- --------------------------------------------------------

--
-- Structure de la table `permission_role`
--

DROP TABLE IF EXISTS `permission_role`;
CREATE TABLE IF NOT EXISTS `permission_role` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` bigint UNSIGNED NOT NULL,
  `permission_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permission_role_role_id_permission_id_unique` (`role_id`,`permission_id`),
  KEY `permission_role_permission_id_foreign` (`permission_id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `permission_role`
--

INSERT INTO `permission_role` (`id`, `role_id`, `permission_id`) VALUES
(17, 1, 1),
(2, 1, 2),
(18, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 2, 1),
(10, 2, 2),
(11, 3, 1),
(12, 3, 3),
(19, 3, 4),
(14, 4, 1),
(15, 4, 5),
(20, 3, 2),
(21, 4, 2);

-- --------------------------------------------------------

--
-- Structure de la table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_nom_unique` (`nom`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id`, `nom`, `description`, `actif`, `created_at`, `updated_at`) VALUES
(1, 'administrateur', 'Accès complet à toutes les fonctionnalités et à la configuration', 1, '2026-08-09 06:56:06', '2026-08-17 09:02:51'),
(2, 'standardiste', 'Réception, enregistrement et distribution des courriers', 1, '2026-08-09 06:56:06', '2026-08-17 05:42:06'),
(3, 'secretaire', 'Traitement et suivi des courriers au sein d\'un département', 1, '2026-08-09 06:56:06', '2026-08-17 05:42:18'),
(4, 'directeur', 'Validation et supervision des courriers du département', 1, '2026-08-09 06:56:06', '2026-08-17 05:42:27');

-- --------------------------------------------------------

--
-- Structure de la table `role_user`
--

DROP TABLE IF EXISTS `role_user`;
CREATE TABLE IF NOT EXISTS `role_user` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_user_user_id_foreign` (`user_id`),
  KEY `role_user_role_id_foreign` (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `role_user`
--

INSERT INTO `role_user` (`id`, `user_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2026-08-25 09:56:42', '2026-08-25 09:56:42'),
(2, 14, 4, '2026-08-26 11:55:14', '2026-08-26 11:55:14'),
(3, 15, 4, '2026-08-26 12:45:26', '2026-08-26 12:45:26'),
(4, 13, 3, '2026-08-26 20:36:12', '2026-08-26 20:36:12'),
(5, 16, 3, '2026-08-27 10:40:42', '2026-08-27 10:40:42'),
(6, 10, 3, '2026-08-27 19:57:53', '2026-08-27 19:57:53'),
(7, 11, 3, '2026-08-28 09:42:18', '2026-08-28 09:42:18'),
(8, 9, 2, '2026-08-30 10:26:34', '2026-08-30 10:26:34'),
(9, 6, 3, '2026-08-30 15:10:07', '2026-08-30 15:10:07'),
(10, 17, 3, '2026-09-02 13:13:25', '2026-09-02 13:13:25'),
(11, 12, 4, '2026-09-10 23:56:06', '2026-09-10 23:56:06');

-- --------------------------------------------------------

--
-- Structure de la table `type_courriers`
--

DROP TABLE IF EXISTS `type_courriers`;
CREATE TABLE IF NOT EXISTS `type_courriers` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prefixe` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `type_courriers`
--

INSERT INTO `type_courriers` (`id`, `nom`, `prefixe`, `description`, `actif`, `created_at`, `updated_at`) VALUES
(1, 'Arrivée', 'ARR', 'Courrier reçu de l\'extérieur', 1, '2026-08-08 22:32:31', '2026-08-08 22:32:31'),
(2, 'Départ', 'DEP', 'Courrier envoyé à l\'extérieur', 1, '2026-08-08 22:32:31', '2026-08-08 22:32:31'),
(3, 'Interne', 'INT', 'Courrier entre départements', 1, '2026-08-08 22:32:31', '2026-08-08 22:32:31');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `matricule` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `departement_id` bigint UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_matricule_unique` (`matricule`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_departement_id_foreign` (`departement_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `matricule`, `nom`, `prenom`, `email`, `email_verified_at`, `password`, `role`, `departement_id`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, '000001', 'Hebié', 'Elvis', 'elvis@sosuco.com', NULL, '$2y$10$a0tfAbiz.YShhQo5B12moe1ZZ0Qed.OVvXdlvAPTngw2pwDq2587W', 'administrateur', NULL, 1, NULL, '2026-07-29 03:45:25', '2026-08-26 12:35:40'),
(7, '100001', 'Keita', 'Hamza', 'hamza@sosuco.com', NULL, '$2y$10$wnro7eQtYwSsL6skv6t.Lep8dz.SyY1VA8WY.YSf6CIwd7TQhoB.a', 'directeur', 9, 1, NULL, '2026-07-29 17:21:14', '2026-07-29 19:03:03'),
(6, '000007', 'Kan', 'Maryse', 'maryse@sosuco.com', NULL, '$2y$10$Kq1nO4dHgJRazGb5YCrS9OOOa3NDKwXLwTjev4V8flfoeXB/.k3Ne', 'secretaire', 7, 1, NULL, '2026-07-29 17:15:51', '2026-07-29 17:48:32'),
(13, '140010', 'Nebié', 'Annaêlle', 'Annaelle@sosuco.com', NULL, '$2y$10$DhH4Ty4f6NWiiR0pNeJeVuqZq/wLBCteT1qBHEqvvrr3LGox1XPBC', NULL, 10, 1, NULL, '2026-08-24 12:06:43', '2026-08-26 20:36:12'),
(9, '000011', 'Rwamba', 'Rihana', 'rihana@sosuco.com', NULL, '$2y$10$OBfsuL0dKfBi/iAnLfC0IuTZK9LXnyzlyuO/76jgaXNgr9sP83HCW', 'standardiste', NULL, 1, NULL, '2026-07-29 19:02:03', '2026-07-29 19:03:24'),
(10, '000014', 'Traoré', 'Assita', 'assita@sosuco.com', NULL, '$2y$10$cQgSOQN7UXalQHEykYfT9Oj8bzgswS6cv9bS.fP5jujYK.TdtcHxi', 'secretaire', 2, 1, NULL, '2026-07-29 19:16:14', '2026-07-29 19:16:59'),
(11, '100017', 'sanon', 'ALI', 'ali@sosuco.com', NULL, '$2y$10$G4jyih74bCN00Hzk/R.UGO9u0.kK6xHlYZkASC8KaAlGvZ2Py1QCy', 'directeur', 3, 1, NULL, '2026-07-31 11:18:44', '2026-07-31 11:19:37'),
(12, '100015', 'Kaboré', 'Edmond', 'edmond@sosuco.com', NULL, '$2y$10$j9JPdsorgdccDZaGW5pWxeXu6nBJz7zWfILPni1LsMWluCd7cyRC2', 'secretaire', 2, 1, NULL, '2026-08-05 08:00:12', '2026-08-05 08:04:16'),
(15, '106798', 'Traoré', 'Abdala', 'abdala@sosuco.com', NULL, '$2y$10$CzKJ3e/1jNPlpYlq9GMOOOxe0m56G/0LtQIQCG1s68gCcgAqjUL5i', NULL, 5, 1, NULL, '2026-08-26 12:45:26', '2026-08-26 12:45:26'),
(16, '000020', 'Kaboré', 'Sitha', 'sitha@sosuco.com', NULL, '$2y$10$WOiCu5DnfY/T4xSUMrn0I.pjTHUuux/040LpIIM.POX.ski1t5qUi', NULL, 1, 1, NULL, '2026-08-27 10:40:42', '2026-08-27 10:40:42'),
(17, '200011', 'Diallo', 'Awa', 'awa@sosuco.com', NULL, '$2y$10$XTYsEtZDF1TR19fVo4iK7uQgzqQ./D2Wrba4jLwmo7pFBPug1Aj9K', NULL, 5, 1, NULL, '2026-09-02 13:13:25', '2026-09-02 13:13:25');

-- --------------------------------------------------------

--
-- Structure de la table `workflows`
--

DROP TABLE IF EXISTS `workflows`;
CREATE TABLE IF NOT EXISTS `workflows` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `type` enum('arrivee','depart','interne') COLLATE utf8mb4_unicode_ci NOT NULL,
  `steps` json NOT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `workflows_created_by_foreign` (`created_by`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `workflows`
--

INSERT INTO `workflows` (`id`, `name`, `description`, `type`, `steps`, `created_by`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'workflow Arrivée', NULL, 'arrivee', '[{\"type\": \"arrivee\", \"order\": 1, \"role_id\": \"2\", \"description\": null, \"deadline_hours\": \"48\"}]', 1, 1, '2026-08-24 11:16:01', '2026-08-24 11:16:01');

-- --------------------------------------------------------

--
-- Structure de la table `workflow_etapes`
--

DROP TABLE IF EXISTS `workflow_etapes`;
CREATE TABLE IF NOT EXISTS `workflow_etapes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `workflow_id` bigint UNSIGNED NOT NULL,
  `ordre` int NOT NULL,
  `role_nom` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action_requise` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'traiter',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `workflow_etapes_workflow_id_foreign` (`workflow_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
