-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  jeu. 28 nov. 2019 à 22:16
-- Version du serveur :  5.7.17
-- Version de PHP :  7.1.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `labernoisdb`
--
CREATE DATABASE IF NOT EXISTS `labernoisdb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;
USE `labernoisdb`;

-- --------------------------------------------------------

--
-- Structure de la table `accommodations`
--

CREATE TABLE `accommodations` (
  `id` int(11) NOT NULL,
  `location_id` int(11) DEFAULT NULL,
  `accommodation_type` enum('HOTEL','TENT','BOAT','HOUSE','CONDO','MOTEL','OTHER') COLLATE utf8mb4_bin NOT NULL,
  `link` varchar(2083) CHARACTER SET utf8 DEFAULT NULL,
  `rating` tinyint(4) DEFAULT NULL,
  `name` varchar(100) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `accommodations_locations`
--

CREATE TABLE `accommodations_locations` (
  `id` int(11) NOT NULL,
  `accommodation_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `accommodations_media`
--

CREATE TABLE `accommodations_media` (
  `id` int(11) NOT NULL,
  `accommodation_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `accommodations_periods`
--

CREATE TABLE `accommodations_periods` (
  `id` int(11) NOT NULL,
  `period_id` int(11) NOT NULL,
  `accommodation_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `activities`
--

CREATE TABLE `activities` (
  `id` int(11) NOT NULL,
  `activity_type` enum('TRANSPORT','RELAXING','ACTION','DISCOVERY','ARTS','OTHER') COLLATE utf8mb4_bin NOT NULL,
  `link` varchar(2083) COLLATE utf8mb4_bin DEFAULT NULL,
  `description` text COLLATE utf8mb4_bin DEFAULT NULL,
  `name` varchar(100) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `activities_locations`
--

CREATE TABLE `activities_locations` (
  `id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `activities_media`
--

CREATE TABLE `activities_media` (
  `id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `addresses`
--

CREATE TABLE `addresses` (
  `id` int(11) NOT NULL,
  `country` varchar(50) CHARACTER SET utf8 NOT NULL,
  `city` varchar(100) CHARACTER SET utf8 NOT NULL,
  `region` varchar(100) CHARACTER SET utf8 NOT NULL,
  `address_line_1` varchar(100) CHARACTER SET utf8 NOT NULL,
  `address_line_2` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `postal_code` varchar(20) COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `cancellations`
--

CREATE TABLE `cancellations` (
  `id` int(11) NOT NULL,
  `cancellation_date` date NOT NULL,
  `trip_id` int(11) NOT NULL,
  `transaction_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `cards`
--

CREATE TABLE `cards` (
  `id` int(11) NOT NULL,
  `circuit_id` int(11) NOT NULL,
  `media_id` int(11) DEFAULT NULL,
  `show_price` tinyint(1) NOT NULL,
  `show_promotion` tinyint(1) NOT NULL,
  `show_upcoming_departure` tinyint(1) NOT NULL,
  `description` text COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `description` text COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `chat_lines`
--

CREATE TABLE `chat_lines` (
  `id` int(11) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `member_id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `line` text COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `circuits`
--

CREATE TABLE `circuits` (
  `id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `description` text COLLATE utf8mb4_bin DEFAULT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `circuits_media`
--

CREATE TABLE `circuits_media` (
  `id` int(11) NOT NULL,
  `circuit_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `circuits_trips`
--

CREATE TABLE `circuits_trips` (
  `id` int(11) NOT NULL,
  `circuit_id` int(11) NOT NULL,
  `departure_date` datetime NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `refund_date` date NOT NULL,
  `cancellation_date` date NOT NULL,
  `cancellation_fee` decimal(10,2) NOT NULL,
  `places` int(11) NOT NULL,
  `quorum` int(11) NOT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `circuits_trips_employees`
--

CREATE TABLE `circuits_trips_employees` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `circuit_trip_id` int(11) NOT NULL,
  `description` text COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `circuits_trips_periods_rooms`
--

CREATE TABLE `circuits_trips_periods_rooms` (
  `id` int(11) NOT NULL,
  `circuit_trip_id` int(11) NOT NULL,
  `period_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `circuits_trips_periods_rooms_travelers`
--

CREATE TABLE `circuits_trips_periods_rooms_travelers` (
  `id` int(11) NOT NULL,
  `circuit_trip_period_room_id` int(11) NOT NULL,
  `traveler_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `last_name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `date_of_birth` date NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `media_id` int(11) DEFAULT NULL,
  `phone_number` varchar(15) COLLATE utf8mb4_bin DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `password_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `employees_languages`
--

CREATE TABLE `employees_languages` (
  `id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `exclusions`
--

CREATE TABLE `exclusions` (
  `id` int(11) NOT NULL,
  `circuit_id` int(11) NOT NULL,
  `description` text COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `exclusions_activities`
--

CREATE TABLE `exclusions_activities` (
  `id` int(11) NOT NULL,
  `trip_id` int(11) NOT NULL,
  `step_activity_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `exclusions_restaurants`
--

CREATE TABLE `exclusions_restaurants` (
  `id` int(11) NOT NULL,
  `trip_id` int(11) NOT NULL,
  `step_restaurant_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `flights`
--

CREATE TABLE `flights` (
  `id` int(11) NOT NULL,
  `flight_number` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `departing_city` varchar(100) CHARACTER SET utf8 NOT NULL,
  `departing_date_time` datetime NOT NULL,
  `landing_city` varchar(100) CHARACTER SET utf8 NOT NULL,
  `duration` time NOT NULL,
  `company_name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `link` varchar(2083) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `galleries`
--

CREATE TABLE `galleries` (
  `id` int(11) NOT NULL,
  `template_id` int(11) NOT NULL,
  `circuit_id` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `galleries_elements`
--

CREATE TABLE `galleries_elements` (
  `id` int(11) NOT NULL,
  `gallery_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  `title` varchar(100) CHARACTER SET utf8 NOT NULL,
  `description` text COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `inclusions`
--

CREATE TABLE `inclusions` (
  `id` int(11) NOT NULL,
  `circuit_id` int(11) NOT NULL,
  `description` text COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `landing_pages`
--

CREATE TABLE `landing_pages` (
  `id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `slogan` varchar(250) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `landing_pages_items`
--

CREATE TABLE `landing_pages_items` (
  `id` int(11) NOT NULL,
  `landing_page_id` int(11) NOT NULL,
  `landing_page_section_id` int(11) NOT NULL,
  `position` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `landing_pages_items_cards`
--

CREATE TABLE `landing_pages_items_cards` (
  `id` int(11) NOT NULL,
  `card_id` int(11) NOT NULL,
  `landing_page_item_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `landing_pages_items_news`
--

CREATE TABLE `landing_pages_items_news` (
  `id` int(11) NOT NULL,
  `news_id` int(11) NOT NULL,
  `landing_page_item_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `landing_pages_sections`
--

CREATE TABLE `landing_pages_sections` (
  `id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `description` text COLLATE utf8mb4_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `languages`
--

CREATE TABLE `languages` (
  `id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `locations`
--

CREATE TABLE `locations` (
  `id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `phone_number` varchar(15) COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `media`
--

CREATE TABLE `media` (
  `id` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `media_type` varchar(127) COLLATE utf8mb4_bin NOT NULL,
  `description` text COLLATE utf8mb4_bin,
  `path` VARCHAR(255) COLLATE utf8mb4_bin NOT NULL,
  `header` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `password_id` int(11) DEFAULT NULL,
  `address_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `first_name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `last_name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `phone_number` varchar(15) COLLATE utf8mb4_bin NOT NULL,
  `date_of_birth` date NOT NULL,
  `facebook_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `members_newsletters`
--

CREATE TABLE `members_newsletters` (
  `id` int(11) NOT NULL,
  `newsletter_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `media_id` int(11) DEFAULT NULL,
  `news_date` datetime NOT NULL,
  `description` text COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `newsletters`
--

CREATE TABLE `newsletters` (
  `id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `newsletters_messages`
--

CREATE TABLE `newsletters_messages` (
  `id` int(11) NOT NULL,
  `newsletter_id` int(11) NOT NULL,
  `content` text COLLATE utf8mb4_bin NOT NULL,
  `newsletter_message_date` datetime NOT NULL,
  `subject` varchar(100) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `passwords`
--

CREATE TABLE `passwords` (
  `id` int(11) NOT NULL,
  `password_salt` varchar(64) CHARACTER SET utf8 NOT NULL,
  `password_hash` varchar(64) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `payment_plan_id` int(11) NOT NULL,
  `amount_due` decimal(10,2) NOT NULL,
  `date_due` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `payments_plans`
--

CREATE TABLE `payments_plans` (
  `id` int(11) NOT NULL,
  `circuit_trip_id` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `periods`
--

CREATE TABLE `periods` (
  `id` int(11) NOT NULL,
  `step_id` int(11) NOT NULL,
  `time_after_step_start` mediumint(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `feature` varchar(100) COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `promotions`
--

CREATE TABLE `promotions` (
  `id` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `promotion_type_id` int(11) NOT NULL,
  `promo_code` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `value` decimal(10,2) NOT NULL,
  `description` text COLLATE utf8mb4_bin DEFAULT NULL,
  `availability_number` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `promotions_circuits_trips`
--

CREATE TABLE `promotions_circuits_trips` (
  `id` int(11) NOT NULL,
  `promotion_id` int(11) NOT NULL,
  `circuit_trip_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `promotions_trips_members`
--

CREATE TABLE `promotions_trips_members` (
  `id` int(11) NOT NULL,
  `promotion_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `trip_id` int(11) NOT NULL,
  `promotion_code` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `applied` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `promotions_types`
--

CREATE TABLE `promotions_types` (
  `id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `is_percentage_based` tinyint(1) NOT NULL,
  `is_gift_based` tinyint(1) NOT NULL,
  `is_exclusive` tinyint(1) NOT NULL,
  `group_discount_travelers_count` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `restaurants`
--

CREATE TABLE `restaurants` (
  `id` int(11) NOT NULL,
  `link` varchar(2083) COLLATE utf8mb4_bin DEFAULT NULL,
  `description` text COLLATE utf8mb4_bin,
  `location_id` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `restaurants_media`
--

CREATE TABLE `restaurants_media` (
  `id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(30) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `roles_permissions`
--

CREATE TABLE `roles_permissions` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `accommodation_id` int(11) NOT NULL,
  `description` text COLLATE utf8mb4_bin NOT NULL,
  `occupation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `steps`
--

CREATE TABLE `steps` (
  `id` int(11) NOT NULL,
  `circuit_id` int(11) NOT NULL,
  `description` text COLLATE utf8mb4_bin,
  `position` int(11) NOT NULL,
  `time_after_last_step` mediumint(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `steps_activities`
--

CREATE TABLE `steps_activities` (
  `id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `step_id` int(11) NOT NULL,
  `time_after_last_step` mediumint(9) NOT NULL,
  `duration` mediumint(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `steps_restaurants`
--

CREATE TABLE `steps_restaurants` (
  `id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `step_id` int(11) NOT NULL,
  `time_after_step_start` mediumint(9) NOT NULL,
  `duration` mediumint(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `templates`
--

CREATE TABLE `templates` (
  `id` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `currency_code` varchar(6) COLLATE utf8mb4_bin NOT NULL,
  `gross_amount` decimal(10,2) NOT NULL,
  `transaction_order` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `travelers`
--

CREATE TABLE `travelers` (
  `id` int(11) NOT NULL,
  `trip_id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL,
  `first_name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `last_name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `date_of_birth` date NOT NULL,
  `phone_number` varchar(15) COLLATE utf8mb4_bin NOT NULL,
  `gender` enum('MALE','FEMALE','OTHER') COLLATE utf8mb4_bin NOT NULL,
  `redress_number` varchar(20) COLLATE utf8mb4_bin DEFAULT NULL,
  `needs_special_assistance` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `travelers_flights`
--

CREATE TABLE `travelers_flights` (
  `id` int(11) NOT NULL,
  `traveler_id` int(11) NOT NULL,
  `flight_id` int(11) NOT NULL,
  `seat_class` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `seat` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `ticket` varchar(15) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `trips`
--

CREATE TABLE `trips` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `circuit_trip_id` int(11) NOT NULL,
  `departure_date` datetime NOT NULL,
  `return_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `trips_payments`
--

CREATE TABLE `trips_payments` (
  `id` int(11) NOT NULL,
  `trip_id` int(11) NOT NULL,
  `payment_plan_id` int(11) NOT NULL,
  `amount_due` decimal(10,2) NOT NULL,
  `date_due` datetime NOT NULL,
  `transaction_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `waiting_lists`
--

CREATE TABLE `waiting_lists` (
  `id` int(11) NOT NULL,
  `circuit_trip_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `accommodations`
--
ALTER TABLE `accommodations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `location_id` (`location_id`);

--
-- Index pour la table `accommodations_locations`
--
ALTER TABLE `accommodations_locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `accommodation_id` (`accommodation_id`),
  ADD KEY `location_id` (`location_id`);

--
-- Index pour la table `accommodations_media`
--
ALTER TABLE `accommodations_media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `accommodation_id` (`accommodation_id`),
  ADD KEY `media_id` (`media_id`);

--
-- Index pour la table `accommodations_periods`
--
ALTER TABLE `accommodations_periods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `period_id` (`period_id`),
  ADD KEY `accommodation_id` (`accommodation_id`);

--
-- Index pour la table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `activities_locations`
--
ALTER TABLE `activities_locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_id` (`activity_id`),
  ADD KEY `location_id` (`location_id`);

--
-- Index pour la table `activities_media`
--
ALTER TABLE `activities_media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_id` (`activity_id`),
  ADD KEY `media_id` (`media_id`);

--
-- Index pour la table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `cancellations`
--
ALTER TABLE `cancellations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trip_id` (`trip_id`),
  ADD KEY `transaction_id` (`transaction_id`);

--
-- Index pour la table `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `circuit_id` (`circuit_id`),
  ADD KEY `media_id` (`media_id`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `chat_lines`
--
ALTER TABLE `chat_lines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Index pour la table `circuits`
--
ALTER TABLE `circuits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_id` (`media_id`),
  ADD KEY `language_id` (`language_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Index pour la table `circuits_media`
--
ALTER TABLE `circuits_media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `circuit_id` (`circuit_id`),
  ADD KEY `media_id` (`media_id`);

--
-- Index pour la table `circuits_trips`
--
ALTER TABLE `circuits_trips`
  ADD PRIMARY KEY (`id`),
  ADD KEY `circuit_id` (`circuit_id`);

--
-- Index pour la table `circuits_trips_employees`
--
ALTER TABLE `circuits_trips_employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `circuit_trip_id` (`circuit_trip_id`);

--
-- Index pour la table `circuits_trips_periods_rooms`
--
ALTER TABLE `circuits_trips_periods_rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `circuit_trip_id` (`circuit_trip_id`),
  ADD KEY `period_id` (`period_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Index pour la table `circuits_trips_periods_rooms_travelers`
--
ALTER TABLE `circuits_trips_periods_rooms_travelers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `circuit_trip_period_room_id` (`circuit_trip_period_room_id`),
  ADD KEY `traveler_id` (`traveler_id`);

--
-- Index pour la table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_id` (`media_id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `password_id` (`password_id`);

--
-- Index pour la table `employees_languages`
--
ALTER TABLE `employees_languages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `language_id` (`language_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Index pour la table `exclusions`
--
ALTER TABLE `exclusions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `circuit_id` (`circuit_id`);

--
-- Index pour la table `exclusions_activities`
--
ALTER TABLE `exclusions_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trip_id` (`trip_id`),
  ADD KEY `step_activity_id` (`step_activity_id`);

--
-- Index pour la table `exclusions_restaurants`
--
ALTER TABLE `exclusions_restaurants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trip_id` (`trip_id`),
  ADD KEY `step_restaurant_id` (`step_restaurant_id`);

--
-- Index pour la table `flights`
--
ALTER TABLE `flights`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `template_id` (`template_id`),
  ADD KEY `circuit_id` (`circuit_id`);

--
-- Index pour la table `galleries_elements`
--
ALTER TABLE `galleries_elements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gallery_id` (`gallery_id`),
  ADD KEY `media_id` (`media_id`);

--
-- Index pour la table `inclusions`
--
ALTER TABLE `inclusions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `circuit_id` (`circuit_id`);

--
-- Index pour la table `landing_pages`
--
ALTER TABLE `landing_pages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_id` (`media_id`),
  ADD KEY `language_id` (`language_id`);

--
-- Index pour la table `landing_pages_items`
--
ALTER TABLE `landing_pages_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `landing_page_id` (`landing_page_id`),
  ADD KEY `landing_page_section_id` (`landing_page_section_id`);

--
-- Index pour la table `landing_pages_items_cards`
--
ALTER TABLE `landing_pages_items_cards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `card_id` (`card_id`),
  ADD KEY `landing_page_item_id` (`landing_page_item_id`);

--
-- Index pour la table `landing_pages_items_news`
--
ALTER TABLE `landing_pages_items_news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `news_id` (`news_id`),
  ADD KEY `landing_page_item_id` (`landing_page_item_id`);

--
-- Index pour la table `landing_pages_sections`
--
ALTER TABLE `landing_pages_sections`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `address_id` (`address_id`);

--
-- Index pour la table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `password_id` (`password_id`),
  ADD KEY `address_id` (`address_id`),
  ADD KEY `language_id` (`language_id`);

--
-- Index pour la table `members_newsletters`
--
ALTER TABLE `members_newsletters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `newsletter_id` (`newsletter_id`),
  ADD KEY `member_id` (`member_id`);

--
-- Index pour la table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_id` (`media_id`);

--
-- Index pour la table `newsletters`
--
ALTER TABLE `newsletters`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `newsletters_messages`
--
ALTER TABLE `newsletters_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `newsletter_id` (`newsletter_id`);

--
-- Index pour la table `passwords`
--
ALTER TABLE `passwords`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_plan_id` (`payment_plan_id`);

--
-- Index pour la table `payments_plans`
--
ALTER TABLE `payments_plans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `circuit_trip_id` (`circuit_trip_id`);

--
-- Index pour la table `periods`
--
ALTER TABLE `periods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `step_id` (`step_id`);

--
-- Index pour la table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `promotion_type_id` (`promotion_type_id`);

--
-- Index pour la table `promotions_circuits_trips`
--
ALTER TABLE `promotions_circuits_trips`
  ADD PRIMARY KEY (`id`),
  ADD KEY `promotion_id` (`promotion_id`),
  ADD KEY `circuit_trip_id` (`circuit_trip_id`);

--
-- Index pour la table `promotions_trips_members`
--
ALTER TABLE `promotions_trips_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `promotion_id` (`promotion_id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `trip_id` (`trip_id`);

--
-- Index pour la table `promotions_types`
--
ALTER TABLE `promotions_types`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `restaurants_media`
--
ALTER TABLE `restaurants_media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `restaurant_id` (`restaurant_id`),
  ADD KEY `media_id` (`media_id`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `roles_permissions`
--
ALTER TABLE `roles_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- Index pour la table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `accommodation_id` (`accommodation_id`);

--
-- Index pour la table `steps`
--
ALTER TABLE `steps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `circuit_id` (`circuit_id`);

--
-- Index pour la table `steps_activities`
--
ALTER TABLE `steps_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_id` (`activity_id`);

--
-- Index pour la table `steps_restaurants`
--
ALTER TABLE `steps_restaurants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `restaurant_id` (`restaurant_id`),
  ADD KEY `step_id` (`step_id`);

--
-- Index pour la table `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `travelers`
--
ALTER TABLE `travelers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trip_id` (`trip_id`),
  ADD KEY `address_id` (`address_id`);

--
-- Index pour la table `travelers_flights`
--
ALTER TABLE `travelers_flights`
  ADD PRIMARY KEY (`id`),
  ADD KEY `traveler_id` (`traveler_id`),
  ADD KEY `flight_id` (`flight_id`);

--
-- Index pour la table `trips`
--
ALTER TABLE `trips`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `circuit_trip_id` (`circuit_trip_id`);

--
-- Index pour la table `trips_payments`
--
ALTER TABLE `trips_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trip_id` (`trip_id`),
  ADD KEY `payment_plan_id` (`payment_plan_id`),
  ADD KEY `transaction_id` (`transaction_id`);

--
-- Index pour la table `waiting_lists`
--
ALTER TABLE `waiting_lists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `circuit_trip_id` (`circuit_trip_id`),
  ADD KEY `member_id` (`member_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `accommodations`
--
ALTER TABLE `accommodations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `accommodations_locations`
--
ALTER TABLE `accommodations_locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `accommodations_media`
--
ALTER TABLE `accommodations_media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `accommodations_periods`
--
ALTER TABLE `accommodations_periods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `activities_locations`
--
ALTER TABLE `activities_locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `activities_media`
--
ALTER TABLE `activities_media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `cancellations`
--
ALTER TABLE `cancellations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `cards`
--
ALTER TABLE `cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `chat_lines`
--
ALTER TABLE `chat_lines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `circuits`
--
ALTER TABLE `circuits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `circuits_media`
--
ALTER TABLE `circuits_media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `circuits_trips`
--
ALTER TABLE `circuits_trips`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `circuits_trips_employees`
--
ALTER TABLE `circuits_trips_employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `circuits_trips_periods_rooms`
--
ALTER TABLE `circuits_trips_periods_rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `circuits_trips_periods_rooms_travelers`
--
ALTER TABLE `circuits_trips_periods_rooms_travelers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `employees_languages`
--
ALTER TABLE `employees_languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `exclusions`
--
ALTER TABLE `exclusions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `exclusions_activities`
--
ALTER TABLE `exclusions_activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `exclusions_restaurants`
--
ALTER TABLE `exclusions_restaurants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `flights`
--
ALTER TABLE `flights`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `galleries_elements`
--
ALTER TABLE `galleries_elements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `inclusions`
--
ALTER TABLE `inclusions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `landing_pages`
--
ALTER TABLE `landing_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `landing_pages_items`
--
ALTER TABLE `landing_pages_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `landing_pages_items_cards`
--
ALTER TABLE `landing_pages_items_cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `landing_pages_items_news`
--
ALTER TABLE `landing_pages_items_news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `landing_pages_sections`
--
ALTER TABLE `landing_pages_sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `members_newsletters`
--
ALTER TABLE `members_newsletters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `newsletters`
--
ALTER TABLE `newsletters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `newsletters_messages`
--
ALTER TABLE `newsletters_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `passwords`
--
ALTER TABLE `passwords`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `payments_plans`
--
ALTER TABLE `payments_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `periods`
--
ALTER TABLE `periods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `promotions_circuits_trips`
--
ALTER TABLE `promotions_circuits_trips`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `promotions_trips_members`
--
ALTER TABLE `promotions_trips_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `promotions_types`
--
ALTER TABLE `promotions_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `restaurants_media`
--
ALTER TABLE `restaurants_media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `roles_permissions`
--
ALTER TABLE `roles_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `steps`
--
ALTER TABLE `steps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `steps_activities`
--
ALTER TABLE `steps_activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `steps_restaurants`
--
ALTER TABLE `steps_restaurants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `templates`
--
ALTER TABLE `templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `travelers`
--
ALTER TABLE `travelers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `travelers_flights`
--
ALTER TABLE `travelers_flights`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `trips`
--
ALTER TABLE `trips`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `trips_payments`
--
ALTER TABLE `trips_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `waiting_lists`
--
ALTER TABLE `waiting_lists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `accommodations`
--
ALTER TABLE `accommodations`
  ADD CONSTRAINT `accommodations_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`);

--
-- Contraintes pour la table `accommodations_locations`
--
ALTER TABLE `accommodations_locations`
  ADD CONSTRAINT `accommodations_locations_ibfk_1` FOREIGN KEY (`accommodation_id`) REFERENCES `accommodations` (`id`),
  ADD CONSTRAINT `accommodations_locations_ibfk_2` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`);

--
-- Contraintes pour la table `accommodations_media`
--
ALTER TABLE `accommodations_media`
  ADD CONSTRAINT `accommodations_media_ibfk_1` FOREIGN KEY (`accommodation_id`) REFERENCES `accommodations` (`id`),
  ADD CONSTRAINT `accommodations_media_ibfk_2` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`);

--
-- Contraintes pour la table `accommodations_periods`
--
ALTER TABLE `accommodations_periods`
  ADD CONSTRAINT `accommodations_periods_ibfk_1` FOREIGN KEY (`period_id`) REFERENCES `periods` (`id`),
  ADD CONSTRAINT `accommodations_periods_ibfk_2` FOREIGN KEY (`accommodation_id`) REFERENCES `accommodations` (`id`);

--
-- Contraintes pour la table `activities_locations`
--
ALTER TABLE `activities_locations`
  ADD CONSTRAINT `activities_locations_ibfk_1` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`),
  ADD CONSTRAINT `activities_locations_ibfk_2` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`);

--
-- Contraintes pour la table `activities_media`
--
ALTER TABLE `activities_media`
  ADD CONSTRAINT `activities_media_ibfk_1` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`),
  ADD CONSTRAINT `activities_media_ibfk_2` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`);

--
-- Contraintes pour la table `cancellations`
--
ALTER TABLE `cancellations`
  ADD CONSTRAINT `cancellations_ibfk_1` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`id`),
  ADD CONSTRAINT `cancellations_ibfk_2` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`);

--
-- Contraintes pour la table `cards`
--
ALTER TABLE `cards`
  ADD CONSTRAINT `cards_ibfk_1` FOREIGN KEY (`circuit_id`) REFERENCES `circuits` (`id`),
  ADD CONSTRAINT `cards_ibfk_2` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`);

--
-- Contraintes pour la table `chat_lines`
--
ALTER TABLE `chat_lines`
  ADD CONSTRAINT `chat_lines_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`),
  ADD CONSTRAINT `chat_lines_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`);

--
-- Contraintes pour la table `circuits`
--
ALTER TABLE `circuits`
  ADD CONSTRAINT `circuits_ibfk_1` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`),
  ADD CONSTRAINT `circuits_ibfk_2` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`),
  ADD CONSTRAINT `circuits_ibfk_3` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Contraintes pour la table `circuits_media`
--
ALTER TABLE `circuits_media`
  ADD CONSTRAINT `circuits_media_ibfk_1` FOREIGN KEY (`circuit_id`) REFERENCES `circuits` (`id`),
  ADD CONSTRAINT `circuits_media_ibfk_2` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`);

--
-- Contraintes pour la table `circuits_trips`
--
ALTER TABLE `circuits_trips`
  ADD CONSTRAINT `circuits_trips_ibfk_1` FOREIGN KEY (`circuit_id`) REFERENCES `circuits` (`id`);

--
-- Contraintes pour la table `circuits_trips_employees`
--
ALTER TABLE `circuits_trips_employees`
  ADD CONSTRAINT `circuits_trips_employees_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `circuits_trips_employees_ibfk_2` FOREIGN KEY (`circuit_trip_id`) REFERENCES `circuits_trips` (`id`);

--
-- Contraintes pour la table `circuits_trips_periods_rooms`
--
ALTER TABLE `circuits_trips_periods_rooms`
  ADD CONSTRAINT `circuits_trips_periods_rooms_ibfk_1` FOREIGN KEY (`circuit_trip_id`) REFERENCES `circuits_trips` (`id`),
  ADD CONSTRAINT `circuits_trips_periods_rooms_ibfk_2` FOREIGN KEY (`period_id`) REFERENCES `periods` (`id`),
  ADD CONSTRAINT `circuits_trips_periods_rooms_ibfk_3` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);

--
-- Contraintes pour la table `circuits_trips_periods_rooms_travelers`
--
ALTER TABLE `circuits_trips_periods_rooms_travelers`
  ADD CONSTRAINT `circuits_trips_periods_rooms_travelers_ibfk_1` FOREIGN KEY (`circuit_trip_period_room_id`) REFERENCES `travelers` (`id`),
  ADD CONSTRAINT `circuits_trips_periods_rooms_travelers_ibfk_2` FOREIGN KEY (`traveler_id`) REFERENCES `travelers` (`id`);

--
-- Contraintes pour la table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`),
  ADD CONSTRAINT `employees_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `employees_ibfk_3` FOREIGN KEY (`password_id`) REFERENCES `passwords` (`id`);

--
-- Contraintes pour la table `employees_languages`
--
ALTER TABLE `employees_languages`
  ADD CONSTRAINT `employees_languages_ibfk_1` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`),
  ADD CONSTRAINT `employees_languages_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`);

--
-- Contraintes pour la table `exclusions`
--
ALTER TABLE `exclusions`
  ADD CONSTRAINT `exclusions_ibfk_1` FOREIGN KEY (`circuit_id`) REFERENCES `circuits` (`id`);

--
-- Contraintes pour la table `exclusions_activities`
--
ALTER TABLE `exclusions_activities`
  ADD CONSTRAINT `exclusions_activities_ibfk_1` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`id`),
  ADD CONSTRAINT `exclusions_activities_ibfk_2` FOREIGN KEY (`step_activity_id`) REFERENCES `steps_activities` (`id`);

--
-- Contraintes pour la table `exclusions_restaurants`
--
ALTER TABLE `exclusions_restaurants`
  ADD CONSTRAINT `exclusions_restaurants_ibfk_1` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`id`),
  ADD CONSTRAINT `exclusions_restaurants_ibfk_2` FOREIGN KEY (`step_restaurant_id`) REFERENCES `steps_restaurants` (`id`);

--
-- Contraintes pour la table `galleries`
--
ALTER TABLE `galleries`
  ADD CONSTRAINT `galleries_ibfk_1` FOREIGN KEY (`template_id`) REFERENCES `templates` (`id`),
  ADD CONSTRAINT `galleries_ibfk_2` FOREIGN KEY (`circuit_id`) REFERENCES `circuits` (`id`);

--
-- Contraintes pour la table `galleries_elements`
--
ALTER TABLE `galleries_elements`
  ADD CONSTRAINT `galleries_elements_ibfk_1` FOREIGN KEY (`gallery_id`) REFERENCES `galleries` (`id`),
  ADD CONSTRAINT `galleries_elements_ibfk_2` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`);

--
-- Contraintes pour la table `inclusions`
--
ALTER TABLE `inclusions`
  ADD CONSTRAINT `inclusions_ibfk_1` FOREIGN KEY (`circuit_id`) REFERENCES `circuits` (`id`);

--
-- Contraintes pour la table `landing_pages`
--
ALTER TABLE `landing_pages`
  ADD CONSTRAINT `landing_pages_ibfk_1` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`),
  ADD CONSTRAINT `landing_pages_ibfk_2` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`);

--
-- Contraintes pour la table `landing_pages_items`
--
ALTER TABLE `landing_pages_items`
  ADD CONSTRAINT `landing_pages_items_ibfk_1` FOREIGN KEY (`landing_page_id`) REFERENCES `landing_pages` (`id`),
  ADD CONSTRAINT `landing_pages_items_ibfk_2` FOREIGN KEY (`landing_page_section_id`) REFERENCES `landing_pages_sections` (`id`);

--
-- Contraintes pour la table `landing_pages_items_cards`
--
ALTER TABLE `landing_pages_items_cards`
  ADD CONSTRAINT `landing_pages_items_cards_ibfk_1` FOREIGN KEY (`card_id`) REFERENCES `cards` (`id`),
  ADD CONSTRAINT `landing_pages_items_cards_ibfk_2` FOREIGN KEY (`landing_page_item_id`) REFERENCES `landing_pages_items` (`id`);

--
-- Contraintes pour la table `landing_pages_items_news`
--
ALTER TABLE `landing_pages_items_news`
  ADD CONSTRAINT `landing_pages_items_news_ibfk_1` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`),
  ADD CONSTRAINT `landing_pages_items_news_ibfk_2` FOREIGN KEY (`landing_page_item_id`) REFERENCES `landing_pages_items` (`id`);

--
-- Contraintes pour la table `locations`
--
ALTER TABLE `locations`
  ADD CONSTRAINT `locations_ibfk_1` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`);

--
-- Contraintes pour la table `members`
--
ALTER TABLE `members`
  ADD CONSTRAINT `members_ibfk_1` FOREIGN KEY (`password_id`) REFERENCES `passwords` (`id`),
  ADD CONSTRAINT `members_ibfk_2` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`),
  ADD CONSTRAINT `members_ibfk_3` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`);

--
-- Contraintes pour la table `members_newsletters`
--
ALTER TABLE `members_newsletters`
  ADD CONSTRAINT `members_newsletters_ibfk_1` FOREIGN KEY (`newsletter_id`) REFERENCES `newsletters` (`id`),
  ADD CONSTRAINT `members_newsletters_ibfk_2` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`);

--
-- Contraintes pour la table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`);

--
-- Contraintes pour la table `newsletters_messages`
--
ALTER TABLE `newsletters_messages`
  ADD CONSTRAINT `newsletters_messages_ibfk_1` FOREIGN KEY (`newsletter_id`) REFERENCES `newsletters` (`id`);

--
-- Contraintes pour la table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`payment_plan_id`) REFERENCES `payments_plans` (`id`);

--
-- Contraintes pour la table `payments_plans`
--
ALTER TABLE `payments_plans`
  ADD CONSTRAINT `payments_plans_ibfk_1` FOREIGN KEY (`circuit_trip_id`) REFERENCES `circuits_trips` (`id`);

--
-- Contraintes pour la table `periods`
--
ALTER TABLE `periods`
  ADD CONSTRAINT `periods_ibfk_1` FOREIGN KEY (`step_id`) REFERENCES `steps` (`id`);

--
-- Contraintes pour la table `promotions`
--
ALTER TABLE `promotions`
  ADD CONSTRAINT `promotions_ibfk_1` FOREIGN KEY (`promotion_type_id`) REFERENCES `promotions_types` (`id`);

--
-- Contraintes pour la table `promotions_circuits_trips`
--
ALTER TABLE `promotions_circuits_trips`
  ADD CONSTRAINT `promotions_circuits_trips_ibfk_1` FOREIGN KEY (`promotion_id`) REFERENCES `promotions` (`id`),
  ADD CONSTRAINT `promotions_circuits_trips_ibfk_2` FOREIGN KEY (`circuit_trip_id`) REFERENCES `circuits_trips` (`id`);

--
-- Contraintes pour la table `promotions_trips_members`
--
ALTER TABLE `promotions_trips_members`
  ADD CONSTRAINT `promotions_trips_members_ibfk_1` FOREIGN KEY (`promotion_id`) REFERENCES `promotions` (`id`),
  ADD CONSTRAINT `promotions_trips_members_ibfk_2` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`),
  ADD CONSTRAINT `promotions_trips_members_ibfk_3` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`id`);

--
-- Contraintes pour la table `restaurants_media`
--
ALTER TABLE `restaurants_media`
  ADD CONSTRAINT `restaurants_media_ibfk_1` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`),
  ADD CONSTRAINT `restaurants_media_ibfk_2` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`);

--
-- Contraintes pour la table `roles_permissions`
--
ALTER TABLE `roles_permissions`
  ADD CONSTRAINT `roles_permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `roles_permissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`);

--
-- Contraintes pour la table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`accommodation_id`) REFERENCES `accommodations` (`id`);

--
-- Contraintes pour la table `steps`
--
ALTER TABLE `steps`
  ADD CONSTRAINT `steps_ibfk_1` FOREIGN KEY (`circuit_id`) REFERENCES `circuits` (`id`);

--
-- Contraintes pour la table `steps_activities`
--
ALTER TABLE `steps_activities`
  ADD CONSTRAINT `steps_activities_ibfk_1` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`),
  ADD CONSTRAINT `steps_activities_ibfk_2` FOREIGN KEY (`id`) REFERENCES `steps` (`id`);

--
-- Contraintes pour la table `steps_restaurants`
--
ALTER TABLE `steps_restaurants`
  ADD CONSTRAINT `steps_restaurants_ibfk_1` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`),
  ADD CONSTRAINT `steps_restaurants_ibfk_2` FOREIGN KEY (`step_id`) REFERENCES `steps` (`id`);

--
-- Contraintes pour la table `travelers`
--
ALTER TABLE `travelers`
  ADD CONSTRAINT `travelers_ibfk_1` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`id`),
  ADD CONSTRAINT `travelers_ibfk_2` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`);

--
-- Contraintes pour la table `travelers_flights`
--
ALTER TABLE `travelers_flights`
  ADD CONSTRAINT `travelers_flights_ibfk_1` FOREIGN KEY (`traveler_id`) REFERENCES `travelers` (`id`),
  ADD CONSTRAINT `travelers_flights_ibfk_2` FOREIGN KEY (`flight_id`) REFERENCES `flights` (`id`);

--
-- Contraintes pour la table `trips`
--
ALTER TABLE `trips`
  ADD CONSTRAINT `trips_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`),
  ADD CONSTRAINT `trips_ibfk_2` FOREIGN KEY (`circuit_trip_id`) REFERENCES `circuits_trips` (`id`);

--
-- Contraintes pour la table `trips_payments`
--
ALTER TABLE `trips_payments`
  ADD CONSTRAINT `trips_payments_ibfk_1` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`id`),
  ADD CONSTRAINT `trips_payments_ibfk_2` FOREIGN KEY (`payment_plan_id`) REFERENCES `payments_plans` (`id`),
  ADD CONSTRAINT `trips_payments_ibfk_3` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`);

--
-- Contraintes pour la table `waiting_lists`
--
ALTER TABLE `waiting_lists`
  ADD CONSTRAINT `waiting_lists_ibfk_1` FOREIGN KEY (`circuit_trip_id`) REFERENCES `circuits_trips` (`id`),
  ADD CONSTRAINT `waiting_lists_ibfk_2` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
