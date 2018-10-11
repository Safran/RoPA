-- phpMyAdmin SQL Dump
-- version 4.7.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  mar. 02 oct. 2018 à 13:53
-- Version du serveur :  5.6.35
-- Version de PHP :  7.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `db`
--

-- --------------------------------------------------------

--
-- Structure de la table `answers`
--

CREATE TABLE `answers` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `statement_id` int(10) UNSIGNED NOT NULL,
  `form_element_id` int(10) UNSIGNED NOT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `validated_at` date DEFAULT NULL,
  `created_by` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `attachments`
--

CREATE TABLE `attachments` (
  `id` int(10) UNSIGNED NOT NULL,
  `uuid` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `md5` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `path` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` int(10) UNSIGNED NOT NULL,
  `model_id` int(10) UNSIGNED DEFAULT NULL,
  `model_type` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `answer_id` int(10) UNSIGNED NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `comment_templates`
--

CREATE TABLE `comment_templates` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locale` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'fr',
  `form_element_id` int(10) UNSIGNED NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `modified_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `companies`
--

CREATE TABLE `companies` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lawyer_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `companies`
--

INSERT INTO `companies` (`id`, `name`, `logo`, `lawyer_id`, `created_at`, `updated_at`) VALUES
(1, 'Company', NULL, NULL, '2018-03-18 15:48:58', '2018-07-10 13:20:28');

-- --------------------------------------------------------

--
-- Structure de la table `countries`
--

CREATE TABLE `countries` (
  `id` int(10) UNSIGNED NOT NULL,
  `capital` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `citizenship` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` char(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_sub_unit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_symbol` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_decimals` int(11) DEFAULT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `iso_3166_2` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `iso_3166_3` char(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `region_code` char(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `sub_region_code` char(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `eea` tinyint(1) NOT NULL DEFAULT '0',
  `calling_code` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `flag` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `countries`
--

INSERT INTO `countries` (`id`, `capital`, `citizenship`, `country_code`, `currency`, `currency_code`, `currency_sub_unit`, `currency_symbol`, `currency_decimals`, `full_name`, `iso_3166_2`, `iso_3166_3`, `name`, `region_code`, `sub_region_code`, `eea`, `calling_code`, `flag`) VALUES
(1, 'Kabul', 'Afghan', '004', 'afghani', 'AFN', 'pul', '؋', 2, 'Islamic Republic of Afghanistan', 'AF', 'AFG', 'Afghanistan', '142', '034', 0, '93', 'AF.png'),
(2, 'Tirana', 'Albanian', '008', 'lek', 'ALL', '(qindar (pl. qindarka))', 'Lek', 2, 'Republic of Albania', 'AL', 'ALB', 'Albania', '150', '039', 0, '355', 'AL.png'),
(3, 'Antartica', 'of Antartica', '010', '', '', '', '', 2, 'Antarctica', 'AQ', 'ATA', 'Antarctica', '', '', 0, '672', 'AQ.png'),
(4, 'Algiers', 'Algerian', '012', 'Algerian dinar', 'DZD', 'centime', 'DZD', 2, 'People’s Democratic Republic of Algeria', 'DZ', 'DZA', 'Algeria', '002', '015', 0, '213', 'DZ.png'),
(5, 'Pago Pago', 'American Samoan', '016', 'US dollar', 'USD', 'cent', '$', 2, 'Territory of American', 'AS', 'ASM', 'American Samoa', '009', '061', 0, '1', 'AS.png'),
(6, 'Andorra la Vella', 'Andorran', '020', 'euro', 'EUR', 'cent', '€', 2, 'Principality of Andorra', 'AD', 'AND', 'Andorra', '150', '039', 0, '376', 'AD.png'),
(7, 'Luanda', 'Angolan', '024', 'kwanza', 'AOA', 'cêntimo', 'Kz', 2, 'Republic of Angola', 'AO', 'AGO', 'Angola', '002', '017', 0, '244', 'AO.png'),
(8, 'St John’s', 'of Antigua and Barbuda', '028', 'East Caribbean dollar', 'XCD', 'cent', '$', 2, 'Antigua and Barbuda', 'AG', 'ATG', 'Antigua and Barbuda', '019', '029', 0, '1', 'AG.png'),
(9, 'Baku', 'Azerbaijani', '031', 'Azerbaijani manat', 'AZN', 'kepik (inv.)', 'ман', 2, 'Republic of Azerbaijan', 'AZ', 'AZE', 'Azerbaijan', '142', '145', 0, '994', 'AZ.png'),
(10, 'Buenos Aires', 'Argentinian', '032', 'Argentine peso', 'ARS', 'centavo', '$', 2, 'Argentine Republic', 'AR', 'ARG', 'Argentina', '019', '005', 0, '54', 'AR.png'),
(11, 'Canberra', 'Australian', '036', 'Australian dollar', 'AUD', 'cent', '$', 2, 'Commonwealth of Australia', 'AU', 'AUS', 'Australia', '009', '053', 0, '61', 'AU.png'),
(12, 'Vienna', 'Austrian', '040', 'euro', 'EUR', 'cent', '€', 2, 'Republic of Austria', 'AT', 'AUT', 'Austria', '150', '155', 1, '43', 'AT.png'),
(13, 'Nassau', 'Bahamian', '044', 'Bahamian dollar', 'BSD', 'cent', '$', 2, 'Commonwealth of the Bahamas', 'BS', 'BHS', 'Bahamas', '019', '029', 0, '1', 'BS.png'),
(14, 'Manama', 'Bahraini', '048', 'Bahraini dinar', 'BHD', 'fils (inv.)', 'BHD', 3, 'Kingdom of Bahrain', 'BH', 'BHR', 'Bahrain', '142', '145', 0, '973', 'BH.png'),
(15, 'Dhaka', 'Bangladeshi', '050', 'taka (inv.)', 'BDT', 'poisha (inv.)', 'BDT', 2, 'People’s Republic of Bangladesh', 'BD', 'BGD', 'Bangladesh', '142', '034', 0, '880', 'BD.png'),
(16, 'Yerevan', 'Armenian', '051', 'dram (inv.)', 'AMD', 'luma', 'AMD', 2, 'Republic of Armenia', 'AM', 'ARM', 'Armenia', '142', '145', 0, '374', 'AM.png'),
(17, 'Bridgetown', 'Barbadian', '052', 'Barbados dollar', 'BBD', 'cent', '$', 2, 'Barbados', 'BB', 'BRB', 'Barbados', '019', '029', 0, '1', 'BB.png'),
(18, 'Brussels', 'Belgian', '056', 'euro', 'EUR', 'cent', '€', 2, 'Kingdom of Belgium', 'BE', 'BEL', 'Belgium', '150', '155', 1, '32', 'BE.png'),
(19, 'Hamilton', 'Bermudian', '060', 'Bermuda dollar', 'BMD', 'cent', '$', 2, 'Bermuda', 'BM', 'BMU', 'Bermuda', '019', '021', 0, '1', 'BM.png'),
(20, 'Thimphu', 'Bhutanese', '064', 'ngultrum (inv.)', 'BTN', 'chhetrum (inv.)', 'BTN', 2, 'Kingdom of Bhutan', 'BT', 'BTN', 'Bhutan', '142', '034', 0, '975', 'BT.png'),
(21, 'Sucre (BO1)', 'Bolivian', '068', 'boliviano', 'BOB', 'centavo', '$b', 2, 'Plurinational State of Bolivia', 'BO', 'BOL', 'Bolivia, Plurinational State of', '019', '005', 0, '591', 'BO.png'),
(22, 'Sarajevo', 'of Bosnia and Herzegovina', '070', 'convertible mark', 'BAM', 'fening', 'KM', 2, 'Bosnia and Herzegovina', 'BA', 'BIH', 'Bosnia and Herzegovina', '150', '039', 0, '387', 'BA.png'),
(23, 'Gaborone', 'Botswanan', '072', 'pula (inv.)', 'BWP', 'thebe (inv.)', 'P', 2, 'Republic of Botswana', 'BW', 'BWA', 'Botswana', '002', '018', 0, '267', 'BW.png'),
(24, 'Bouvet island', 'of Bouvet island', '074', '', '', '', 'kr', 2, 'Bouvet Island', 'BV', 'BVT', 'Bouvet Island', '', '', 0, '47', 'BV.png'),
(25, 'Brasilia', 'Brazilian', '076', 'real (pl. reais)', 'BRL', 'centavo', 'R$', 2, 'Federative Republic of Brazil', 'BR', 'BRA', 'Brazil', '019', '005', 0, '55', 'BR.png'),
(26, 'Belmopan', 'Belizean', '084', 'Belize dollar', 'BZD', 'cent', 'BZ$', 2, 'Belize', 'BZ', 'BLZ', 'Belize', '019', '013', 0, '501', 'BZ.png'),
(27, 'Diego Garcia', 'Changosian', '086', 'US dollar', 'USD', 'cent', '$', 2, 'British Indian Ocean Territory', 'IO', 'IOT', 'British Indian Ocean Territory', '', '', 0, '246', 'IO.png'),
(28, 'Honiara', 'Solomon Islander', '090', 'Solomon Islands dollar', 'SBD', 'cent', '$', 2, 'Solomon Islands', 'SB', 'SLB', 'Solomon Islands', '009', '054', 0, '677', 'SB.png'),
(29, 'Road Town', 'British Virgin Islander;', '092', 'US dollar', 'USD', 'cent', '$', 2, 'British Virgin Islands', 'VG', 'VGB', 'Virgin Islands, British', '019', '029', 0, '1', 'VG.png'),
(30, 'Bandar Seri Begawan', 'Bruneian', '096', 'Brunei dollar', 'BND', 'sen (inv.)', '$', 2, 'Brunei Darussalam', 'BN', 'BRN', 'Brunei Darussalam', '142', '035', 0, '673', 'BN.png'),
(31, 'Sofia', 'Bulgarian', '100', 'lev (pl. leva)', 'BGN', 'stotinka', 'лв', 2, 'Republic of Bulgaria', 'BG', 'BGR', 'Bulgaria', '150', '151', 1, '359', 'BG.png'),
(32, 'Yangon', 'Burmese', '104', 'kyat', 'MMK', 'pya', 'K', 2, 'Union of Myanmar/', 'MM', 'MMR', 'Myanmar', '142', '035', 0, '95', 'MM.png'),
(33, 'Bujumbura', 'Burundian', '108', 'Burundi franc', 'BIF', 'centime', 'BIF', 0, 'Republic of Burundi', 'BI', 'BDI', 'Burundi', '002', '014', 0, '257', 'BI.png'),
(34, 'Minsk', 'Belarusian', '112', 'Belarusian rouble', 'BYR', 'kopek', 'p.', 2, 'Republic of Belarus', 'BY', 'BLR', 'Belarus', '150', '151', 0, '375', 'BY.png'),
(35, 'Phnom Penh', 'Cambodian', '116', 'riel', 'KHR', 'sen (inv.)', '៛', 2, 'Kingdom of Cambodia', 'KH', 'KHM', 'Cambodia', '142', '035', 0, '855', 'KH.png'),
(36, 'Yaoundé', 'Cameroonian', '120', 'CFA franc (BEAC)', 'XAF', 'centime', 'FCF', 0, 'Republic of Cameroon', 'CM', 'CMR', 'Cameroon', '002', '017', 0, '237', 'CM.png'),
(37, 'Ottawa', 'Canadian', '124', 'Canadian dollar', 'CAD', 'cent', '$', 2, 'Canada', 'CA', 'CAN', 'Canada', '019', '021', 0, '1', 'CA.png'),
(38, 'Praia', 'Cape Verdean', '132', 'Cape Verde escudo', 'CVE', 'centavo', 'CVE', 2, 'Republic of Cape Verde', 'CV', 'CPV', 'Cape Verde', '002', '011', 0, '238', 'CV.png'),
(39, 'George Town', 'Caymanian', '136', 'Cayman Islands dollar', 'KYD', 'cent', '$', 2, 'Cayman Islands', 'KY', 'CYM', 'Cayman Islands', '019', '029', 0, '1', 'KY.png'),
(40, 'Bangui', 'Central African', '140', 'CFA franc (BEAC)', 'XAF', 'centime', 'CFA', 0, 'Central African Republic', 'CF', 'CAF', 'Central African Republic', '002', '017', 0, '236', 'CF.png'),
(41, 'Colombo', 'Sri Lankan', '144', 'Sri Lankan rupee', 'LKR', 'cent', '₨', 2, 'Democratic Socialist Republic of Sri Lanka', 'LK', 'LKA', 'Sri Lanka', '142', '034', 0, '94', 'LK.png'),
(42, 'N’Djamena', 'Chadian', '148', 'CFA franc (BEAC)', 'XAF', 'centime', 'XAF', 0, 'Republic of Chad', 'TD', 'TCD', 'Chad', '002', '017', 0, '235', 'TD.png'),
(43, 'Santiago', 'Chilean', '152', 'Chilean peso', 'CLP', 'centavo', 'CLP', 0, 'Republic of Chile', 'CL', 'CHL', 'Chile', '019', '005', 0, '56', 'CL.png'),
(44, 'Beijing', 'Chinese', '156', 'renminbi-yuan (inv.)', 'CNY', 'jiao (10)', '¥', 2, 'People’s Republic of China', 'CN', 'CHN', 'China', '142', '030', 0, '86', 'CN.png'),
(45, 'Taipei', 'Taiwanese', '158', 'new Taiwan dollar', 'TWD', 'fen (inv.)', 'NT$', 2, 'Republic of China, Taiwan (TW1)', 'TW', 'TWN', 'Taiwan, Province of China', '142', '030', 0, '886', 'TW.png'),
(46, 'Flying Fish Cove', 'Christmas Islander', '162', 'Australian dollar', 'AUD', 'cent', '$', 2, 'Christmas Island Territory', 'CX', 'CXR', 'Christmas Island', '', '', 0, '61', 'CX.png'),
(47, 'Bantam', 'Cocos Islander', '166', 'Australian dollar', 'AUD', 'cent', '$', 2, 'Territory of Cocos (Keeling) Islands', 'CC', 'CCK', 'Cocos (Keeling) Islands', '', '', 0, '61', 'CC.png'),
(48, 'Santa Fe de Bogotá', 'Colombian', '170', 'Colombian peso', 'COP', 'centavo', '$', 2, 'Republic of Colombia', 'CO', 'COL', 'Colombia', '019', '005', 0, '57', 'CO.png'),
(49, 'Moroni', 'Comorian', '174', 'Comorian franc', 'KMF', '', 'KMF', 0, 'Union of the Comoros', 'KM', 'COM', 'Comoros', '002', '014', 0, '269', 'KM.png'),
(50, 'Mamoudzou', 'Mahorais', '175', 'euro', 'EUR', 'cent', '€', 2, 'Departmental Collectivity of Mayotte', 'YT', 'MYT', 'Mayotte', '002', '014', 0, '262', 'YT.png'),
(51, 'Brazzaville', 'Congolese', '178', 'CFA franc (BEAC)', 'XAF', 'centime', 'FCF', 0, 'Republic of the Congo', 'CG', 'COG', 'Congo', '002', '017', 0, '242', 'CG.png'),
(52, 'Kinshasa', 'Congolese', '180', 'Congolese franc', 'CDF', 'centime', 'CDF', 2, 'Democratic Republic of the Congo', 'CD', 'COD', 'Congo, the Democratic Republic of the', '002', '017', 0, '243', 'CD.png'),
(53, 'Avarua', 'Cook Islander', '184', 'New Zealand dollar', 'NZD', 'cent', '$', 2, 'Cook Islands', 'CK', 'COK', 'Cook Islands', '009', '061', 0, '682', 'CK.png'),
(54, 'San José', 'Costa Rican', '188', 'Costa Rican colón (pl. colones)', 'CRC', 'céntimo', '₡', 2, 'Republic of Costa Rica', 'CR', 'CRI', 'Costa Rica', '019', '013', 0, '506', 'CR.png'),
(55, 'Zagreb', 'Croatian', '191', 'kuna (inv.)', 'HRK', 'lipa (inv.)', 'kn', 2, 'Republic of Croatia', 'HR', 'HRV', 'Croatia', '150', '039', 1, '385', 'HR.png'),
(56, 'Havana', 'Cuban', '192', 'Cuban peso', 'CUP', 'centavo', '₱', 2, 'Republic of Cuba', 'CU', 'CUB', 'Cuba', '019', '029', 0, '53', 'CU.png'),
(57, 'Nicosia', 'Cypriot', '196', 'euro', 'EUR', 'cent', 'CYP', 2, 'Republic of Cyprus', 'CY', 'CYP', 'Cyprus', '142', '145', 1, '357', 'CY.png'),
(58, 'Prague', 'Czech', '203', 'Czech koruna (pl. koruny)', 'CZK', 'halér', 'Kč', 2, 'Czech Republic', 'CZ', 'CZE', 'Czech Republic', '150', '151', 1, '420', 'CZ.png'),
(59, 'Porto Novo (BJ1)', 'Beninese', '204', 'CFA franc (BCEAO)', 'XOF', 'centime', 'XOF', 0, 'Republic of Benin', 'BJ', 'BEN', 'Benin', '002', '011', 0, '229', 'BJ.png'),
(60, 'Copenhagen', 'Danish', '208', 'Danish krone', 'DKK', 'øre (inv.)', 'kr', 2, 'Kingdom of Denmark', 'DK', 'DNK', 'Denmark', '150', '154', 1, '45', 'DK.png'),
(61, 'Roseau', 'Dominican', '212', 'East Caribbean dollar', 'XCD', 'cent', '$', 2, 'Commonwealth of Dominica', 'DM', 'DMA', 'Dominica', '019', '029', 0, '1', 'DM.png'),
(62, 'Santo Domingo', 'Dominican', '214', 'Dominican peso', 'DOP', 'centavo', 'RD$', 2, 'Dominican Republic', 'DO', 'DOM', 'Dominican Republic', '019', '029', 0, '1', 'DO.png'),
(63, 'Quito', 'Ecuadorian', '218', 'US dollar', 'USD', 'cent', '$', 2, 'Republic of Ecuador', 'EC', 'ECU', 'Ecuador', '019', '005', 0, '593', 'EC.png'),
(64, 'San Salvador', 'Salvadoran', '222', 'Salvadorian colón (pl. colones)', 'SVC', 'centavo', '$', 2, 'Republic of El Salvador', 'SV', 'SLV', 'El Salvador', '019', '013', 0, '503', 'SV.png'),
(65, 'Malabo', 'Equatorial Guinean', '226', 'CFA franc (BEAC)', 'XAF', 'centime', 'FCF', 2, 'Republic of Equatorial Guinea', 'GQ', 'GNQ', 'Equatorial Guinea', '002', '017', 0, '240', 'GQ.png'),
(66, 'Addis Ababa', 'Ethiopian', '231', 'birr (inv.)', 'ETB', 'cent', 'ETB', 2, 'Federal Democratic Republic of Ethiopia', 'ET', 'ETH', 'Ethiopia', '002', '014', 0, '251', 'ET.png'),
(67, 'Asmara', 'Eritrean', '232', 'nakfa', 'ERN', 'cent', 'Nfk', 2, 'State of Eritrea', 'ER', 'ERI', 'Eritrea', '002', '014', 0, '291', 'ER.png'),
(68, 'Tallinn', 'Estonian', '233', 'euro', 'EUR', 'cent', 'kr', 2, 'Republic of Estonia', 'EE', 'EST', 'Estonia', '150', '154', 1, '372', 'EE.png'),
(69, 'Tórshavn', 'Faeroese', '234', 'Danish krone', 'DKK', 'øre (inv.)', 'kr', 2, 'Faeroe Islands', 'FO', 'FRO', 'Faroe Islands', '150', '154', 0, '298', 'FO.png'),
(70, 'Stanley', 'Falkland Islander', '238', 'Falkland Islands pound', 'FKP', 'new penny', '£', 2, 'Falkland Islands', 'FK', 'FLK', 'Falkland Islands (Malvinas)', '019', '005', 0, '500', 'FK.png'),
(71, 'King Edward Point (Grytviken)', 'of South Georgia and the South Sandwich Islands', '239', '', '', '', '£', 2, 'South Georgia and the South Sandwich Islands', 'GS', 'SGS', 'South Georgia and the South Sandwich Islands', '', '', 0, '44', 'GS.png'),
(72, 'Suva', 'Fijian', '242', 'Fiji dollar', 'FJD', 'cent', '$', 2, 'Republic of Fiji', 'FJ', 'FJI', 'Fiji', '009', '054', 0, '679', 'FJ.png'),
(73, 'Helsinki', 'Finnish', '246', 'euro', 'EUR', 'cent', '€', 2, 'Republic of Finland', 'FI', 'FIN', 'Finland', '150', '154', 1, '358', 'FI.png'),
(74, 'Mariehamn', 'Åland Islander', '248', 'euro', 'EUR', 'cent', NULL, NULL, 'Åland Islands', 'AX', 'ALA', 'Åland Islands', '150', '154', 0, '358', NULL),
(75, 'Paris', 'French', '250', 'euro', 'EUR', 'cent', '€', 2, 'French Republic', 'FR', 'FRA', 'France', '150', '155', 1, '33', 'FR.png'),
(76, 'Cayenne', 'Guianese', '254', 'euro', 'EUR', 'cent', '€', 2, 'French Guiana', 'GF', 'GUF', 'French Guiana', '019', '005', 0, '594', 'GF.png'),
(77, 'Papeete', 'Polynesian', '258', 'CFP franc', 'XPF', 'centime', 'XPF', 0, 'French Polynesia', 'PF', 'PYF', 'French Polynesia', '009', '061', 0, '689', 'PF.png'),
(78, 'Port-aux-Francais', 'of French Southern and Antarctic Lands', '260', 'euro', 'EUR', 'cent', '€', 2, 'French Southern and Antarctic Lands', 'TF', 'ATF', 'French Southern Territories', '', '', 0, '33', 'TF.png'),
(79, 'Djibouti', 'Djiboutian', '262', 'Djibouti franc', 'DJF', '', 'DJF', 0, 'Republic of Djibouti', 'DJ', 'DJI', 'Djibouti', '002', '014', 0, '253', 'DJ.png'),
(80, 'Libreville', 'Gabonese', '266', 'CFA franc (BEAC)', 'XAF', 'centime', 'FCF', 0, 'Gabonese Republic', 'GA', 'GAB', 'Gabon', '002', '017', 0, '241', 'GA.png'),
(81, 'Tbilisi', 'Georgian', '268', 'lari', 'GEL', 'tetri (inv.)', 'GEL', 2, 'Georgia', 'GE', 'GEO', 'Georgia', '142', '145', 0, '995', 'GE.png'),
(82, 'Banjul', 'Gambian', '270', 'dalasi (inv.)', 'GMD', 'butut', 'D', 2, 'Republic of the Gambia', 'GM', 'GMB', 'Gambia', '002', '011', 0, '220', 'GM.png'),
(83, NULL, 'Palestinian', '275', NULL, NULL, NULL, '₪', 2, NULL, 'PS', 'PSE', 'Palestinian Territory, Occupied', '142', '145', 0, '970', 'PS.png'),
(84, 'Berlin', 'German', '276', 'euro', 'EUR', 'cent', '€', 2, 'Federal Republic of Germany', 'DE', 'DEU', 'Germany', '150', '155', 1, '49', 'DE.png'),
(85, 'Accra', 'Ghanaian', '288', 'Ghana cedi', 'GHS', 'pesewa', '¢', 2, 'Republic of Ghana', 'GH', 'GHA', 'Ghana', '002', '011', 0, '233', 'GH.png'),
(86, 'Gibraltar', 'Gibraltarian', '292', 'Gibraltar pound', 'GIP', 'penny', '£', 2, 'Gibraltar', 'GI', 'GIB', 'Gibraltar', '150', '039', 0, '350', 'GI.png'),
(87, 'Tarawa', 'Kiribatian', '296', 'Australian dollar', 'AUD', 'cent', '$', 2, 'Republic of Kiribati', 'KI', 'KIR', 'Kiribati', '009', '057', 0, '686', 'KI.png'),
(88, 'Athens', 'Greek', '300', 'euro', 'EUR', 'cent', '€', 2, 'Hellenic Republic', 'GR', 'GRC', 'Greece', '150', '039', 1, '30', 'GR.png'),
(89, 'Nuuk', 'Greenlander', '304', 'Danish krone', 'DKK', 'øre (inv.)', 'kr', 2, 'Greenland', 'GL', 'GRL', 'Greenland', '019', '021', 0, '299', 'GL.png'),
(90, 'St George’s', 'Grenadian', '308', 'East Caribbean dollar', 'XCD', 'cent', '$', 2, 'Grenada', 'GD', 'GRD', 'Grenada', '019', '029', 0, '1', 'GD.png'),
(91, 'Basse Terre', 'Guadeloupean', '312', 'euro', 'EUR', 'cent', '€', 2, 'Guadeloupe', 'GP', 'GLP', 'Guadeloupe', '019', '029', 0, '590', 'GP.png'),
(92, 'Agaña (Hagåtña)', 'Guamanian', '316', 'US dollar', 'USD', 'cent', '$', 2, 'Territory of Guam', 'GU', 'GUM', 'Guam', '009', '057', 0, '1', 'GU.png'),
(93, 'Guatemala City', 'Guatemalan', '320', 'quetzal (pl. quetzales)', 'GTQ', 'centavo', 'Q', 2, 'Republic of Guatemala', 'GT', 'GTM', 'Guatemala', '019', '013', 0, '502', 'GT.png'),
(94, 'Conakry', 'Guinean', '324', 'Guinean franc', 'GNF', '', 'GNF', 0, 'Republic of Guinea', 'GN', 'GIN', 'Guinea', '002', '011', 0, '224', 'GN.png'),
(95, 'Georgetown', 'Guyanese', '328', 'Guyana dollar', 'GYD', 'cent', '$', 2, 'Cooperative Republic of Guyana', 'GY', 'GUY', 'Guyana', '019', '005', 0, '592', 'GY.png'),
(96, 'Port-au-Prince', 'Haitian', '332', 'gourde', 'HTG', 'centime', 'G', 2, 'Republic of Haiti', 'HT', 'HTI', 'Haiti', '019', '029', 0, '509', 'HT.png'),
(97, 'Territory of Heard Island and McDonald Islands', 'of Territory of Heard Island and McDonald Islands', '334', '', '', '', '$', 2, 'Territory of Heard Island and McDonald Islands', 'HM', 'HMD', 'Heard Island and McDonald Islands', '', '', 0, '61', 'HM.png'),
(98, 'Vatican City', 'of the Holy See/of the Vatican', '336', 'euro', 'EUR', 'cent', '€', 2, 'the Holy See/ Vatican City State', 'VA', 'VAT', 'Holy See (Vatican City State)', '150', '039', 0, '39', 'VA.png'),
(99, 'Tegucigalpa', 'Honduran', '340', 'lempira', 'HNL', 'centavo', 'L', 2, 'Republic of Honduras', 'HN', 'HND', 'Honduras', '019', '013', 0, '504', 'HN.png'),
(100, '(HK3)', 'Hong Kong Chinese', '344', 'Hong Kong dollar', 'HKD', 'cent', '$', 2, 'Hong Kong Special Administrative Region of the People’s Republic of China (HK2)', 'HK', 'HKG', 'Hong Kong', '142', '030', 0, '852', 'HK.png'),
(101, 'Budapest', 'Hungarian', '348', 'forint (inv.)', 'HUF', '(fillér (inv.))', 'Ft', 2, 'Republic of Hungary', 'HU', 'HUN', 'Hungary', '150', '151', 1, '36', 'HU.png'),
(102, 'Reykjavik', 'Icelander', '352', 'króna (pl. krónur)', 'ISK', '', 'kr', 0, 'Republic of Iceland', 'IS', 'ISL', 'Iceland', '150', '154', 0, '354', 'IS.png'),
(103, 'New Delhi', 'Indian', '356', 'Indian rupee', 'INR', 'paisa', '₹', 2, 'Republic of India', 'IN', 'IND', 'India', '142', '034', 0, '91', 'IN.png'),
(104, 'Jakarta', 'Indonesian', '360', 'Indonesian rupiah (inv.)', 'IDR', 'sen (inv.)', 'Rp', 2, 'Republic of Indonesia', 'ID', 'IDN', 'Indonesia', '142', '035', 0, '62', 'ID.png'),
(105, 'Tehran', 'Iranian', '364', 'Iranian rial', 'IRR', '(dinar) (IR1)', '﷼', 2, 'Islamic Republic of Iran', 'IR', 'IRN', 'Iran, Islamic Republic of', '142', '034', 0, '98', 'IR.png'),
(106, 'Baghdad', 'Iraqi', '368', 'Iraqi dinar', 'IQD', 'fils (inv.)', 'IQD', 3, 'Republic of Iraq', 'IQ', 'IRQ', 'Iraq', '142', '145', 0, '964', 'IQ.png'),
(107, 'Dublin', 'Irish', '372', 'euro', 'EUR', 'cent', '€', 2, 'Ireland (IE1)', 'IE', 'IRL', 'Ireland', '150', '154', 1, '353', 'IE.png'),
(108, '(IL1)', 'Israeli', '376', 'shekel', 'ILS', 'agora', '₪', 2, 'State of Israel', 'IL', 'ISR', 'Israel', '142', '145', 0, '972', 'IL.png'),
(109, 'Rome', 'Italian', '380', 'euro', 'EUR', 'cent', '€', 2, 'Italian Republic', 'IT', 'ITA', 'Italy', '150', '039', 1, '39', 'IT.png'),
(110, 'Yamoussoukro (CI1)', 'Ivorian', '384', 'CFA franc (BCEAO)', 'XOF', 'centime', 'XOF', 0, 'Republic of Côte d’Ivoire', 'CI', 'CIV', 'Côte d\'Ivoire', '002', '011', 0, '225', 'CI.png'),
(111, 'Kingston', 'Jamaican', '388', 'Jamaica dollar', 'JMD', 'cent', '$', 2, 'Jamaica', 'JM', 'JAM', 'Jamaica', '019', '029', 0, '1', 'JM.png'),
(112, 'Tokyo', 'Japanese', '392', 'yen (inv.)', 'JPY', '(sen (inv.)) (JP1)', '¥', 0, 'Japan', 'JP', 'JPN', 'Japan', '142', '030', 0, '81', 'JP.png'),
(113, 'Astana', 'Kazakh', '398', 'tenge (inv.)', 'KZT', 'tiyn', 'лв', 2, 'Republic of Kazakhstan', 'KZ', 'KAZ', 'Kazakhstan', '142', '143', 0, '7', 'KZ.png'),
(114, 'Amman', 'Jordanian', '400', 'Jordanian dinar', 'JOD', '100 qirsh', 'JOD', 2, 'Hashemite Kingdom of Jordan', 'JO', 'JOR', 'Jordan', '142', '145', 0, '962', 'JO.png'),
(115, 'Nairobi', 'Kenyan', '404', 'Kenyan shilling', 'KES', 'cent', 'KES', 2, 'Republic of Kenya', 'KE', 'KEN', 'Kenya', '002', '014', 0, '254', 'KE.png'),
(116, 'Pyongyang', 'North Korean', '408', 'North Korean won (inv.)', 'KPW', 'chun (inv.)', '₩', 2, 'Democratic People’s Republic of Korea', 'KP', 'PRK', 'Korea, Democratic People\'s Republic of', '142', '030', 0, '850', 'KP.png'),
(117, 'Seoul', 'South Korean', '410', 'South Korean won (inv.)', 'KRW', '(chun (inv.))', '₩', 0, 'Republic of Korea', 'KR', 'KOR', 'Korea, Republic of', '142', '030', 0, '82', 'KR.png'),
(118, 'Kuwait City', 'Kuwaiti', '414', 'Kuwaiti dinar', 'KWD', 'fils (inv.)', 'KWD', 3, 'State of Kuwait', 'KW', 'KWT', 'Kuwait', '142', '145', 0, '965', 'KW.png'),
(119, 'Bishkek', 'Kyrgyz', '417', 'som', 'KGS', 'tyiyn', 'лв', 2, 'Kyrgyz Republic', 'KG', 'KGZ', 'Kyrgyzstan', '142', '143', 0, '996', 'KG.png'),
(120, 'Vientiane', 'Lao', '418', 'kip (inv.)', 'LAK', '(at (inv.))', '₭', 0, 'Lao People’s Democratic Republic', 'LA', 'LAO', 'Lao People\'s Democratic Republic', '142', '035', 0, '856', 'LA.png'),
(121, 'Beirut', 'Lebanese', '422', 'Lebanese pound', 'LBP', '(piastre)', '£', 2, 'Lebanese Republic', 'LB', 'LBN', 'Lebanon', '142', '145', 0, '961', 'LB.png'),
(122, 'Maseru', 'Basotho', '426', 'loti (pl. maloti)', 'LSL', 'sente', 'L', 2, 'Kingdom of Lesotho', 'LS', 'LSO', 'Lesotho', '002', '018', 0, '266', 'LS.png'),
(123, 'Riga', 'Latvian', '428', 'euro', 'EUR', 'cent', 'Ls', 2, 'Republic of Latvia', 'LV', 'LVA', 'Latvia', '150', '154', 1, '371', 'LV.png'),
(124, 'Monrovia', 'Liberian', '430', 'Liberian dollar', 'LRD', 'cent', '$', 2, 'Republic of Liberia', 'LR', 'LBR', 'Liberia', '002', '011', 0, '231', 'LR.png'),
(125, 'Tripoli', 'Libyan', '434', 'Libyan dinar', 'LYD', 'dirham', 'LYD', 3, 'Socialist People’s Libyan Arab Jamahiriya', 'LY', 'LBY', 'Libya', '002', '015', 0, '218', 'LY.png'),
(126, 'Vaduz', 'Liechtensteiner', '438', 'Swiss franc', 'CHF', 'centime', 'CHF', 2, 'Principality of Liechtenstein', 'LI', 'LIE', 'Liechtenstein', '150', '155', 0, '423', 'LI.png'),
(127, 'Vilnius', 'Lithuanian', '440', 'euro', 'EUR', 'cent', 'Lt', 2, 'Republic of Lithuania', 'LT', 'LTU', 'Lithuania', '150', '154', 1, '370', 'LT.png'),
(128, 'Luxembourg', 'Luxembourger', '442', 'euro', 'EUR', 'cent', '€', 2, 'Grand Duchy of Luxembourg', 'LU', 'LUX', 'Luxembourg', '150', '155', 1, '352', 'LU.png'),
(129, 'Macao (MO3)', 'Macanese', '446', 'pataca', 'MOP', 'avo', 'MOP', 2, 'Macao Special Administrative Region of the People’s Republic of China (MO2)', 'MO', 'MAC', 'Macao', '142', '030', 0, '853', 'MO.png'),
(130, 'Antananarivo', 'Malagasy', '450', 'ariary', 'MGA', 'iraimbilanja (inv.)', 'MGA', 2, 'Republic of Madagascar', 'MG', 'MDG', 'Madagascar', '002', '014', 0, '261', 'MG.png'),
(131, 'Lilongwe', 'Malawian', '454', 'Malawian kwacha (inv.)', 'MWK', 'tambala (inv.)', 'MK', 2, 'Republic of Malawi', 'MW', 'MWI', 'Malawi', '002', '014', 0, '265', 'MW.png'),
(132, 'Kuala Lumpur (MY1)', 'Malaysian', '458', 'ringgit (inv.)', 'MYR', 'sen (inv.)', 'RM', 2, 'Malaysia', 'MY', 'MYS', 'Malaysia', '142', '035', 0, '60', 'MY.png'),
(133, 'Malé', 'Maldivian', '462', 'rufiyaa', 'MVR', 'laari (inv.)', 'Rf', 2, 'Republic of Maldives', 'MV', 'MDV', 'Maldives', '142', '034', 0, '960', 'MV.png'),
(134, 'Bamako', 'Malian', '466', 'CFA franc (BCEAO)', 'XOF', 'centime', 'XOF', 0, 'Republic of Mali', 'ML', 'MLI', 'Mali', '002', '011', 0, '223', 'ML.png'),
(135, 'Valletta', 'Maltese', '470', 'euro', 'EUR', 'cent', 'MTL', 2, 'Republic of Malta', 'MT', 'MLT', 'Malta', '150', '039', 1, '356', 'MT.png'),
(136, 'Fort-de-France', 'Martinican', '474', 'euro', 'EUR', 'cent', '€', 2, 'Martinique', 'MQ', 'MTQ', 'Martinique', '019', '029', 0, '596', 'MQ.png'),
(137, 'Nouakchott', 'Mauritanian', '478', 'ouguiya', 'MRO', 'khoum', 'UM', 2, 'Islamic Republic of Mauritania', 'MR', 'MRT', 'Mauritania', '002', '011', 0, '222', 'MR.png'),
(138, 'Port Louis', 'Mauritian', '480', 'Mauritian rupee', 'MUR', 'cent', '₨', 2, 'Republic of Mauritius', 'MU', 'MUS', 'Mauritius', '002', '014', 0, '230', 'MU.png'),
(139, 'Mexico City', 'Mexican', '484', 'Mexican peso', 'MXN', 'centavo', '$', 2, 'United Mexican States', 'MX', 'MEX', 'Mexico', '019', '013', 0, '52', 'MX.png'),
(140, 'Monaco', 'Monegasque', '492', 'euro', 'EUR', 'cent', '€', 2, 'Principality of Monaco', 'MC', 'MCO', 'Monaco', '150', '155', 0, '377', 'MC.png'),
(141, 'Ulan Bator', 'Mongolian', '496', 'tugrik', 'MNT', 'möngö (inv.)', '₮', 2, 'Mongolia', 'MN', 'MNG', 'Mongolia', '142', '030', 0, '976', 'MN.png'),
(142, 'Chisinau', 'Moldovan', '498', 'Moldovan leu (pl. lei)', 'MDL', 'ban', 'MDL', 2, 'Republic of Moldova', 'MD', 'MDA', 'Moldova, Republic of', '150', '151', 0, '373', 'MD.png'),
(143, 'Podgorica', 'Montenegrin', '499', 'euro', 'EUR', 'cent', '€', 2, 'Montenegro', 'ME', 'MNE', 'Montenegro', '150', '039', 0, '382', 'ME.png'),
(144, 'Plymouth (MS2)', 'Montserratian', '500', 'East Caribbean dollar', 'XCD', 'cent', '$', 2, 'Montserrat', 'MS', 'MSR', 'Montserrat', '019', '029', 0, '1', 'MS.png'),
(145, 'Rabat', 'Moroccan', '504', 'Moroccan dirham', 'MAD', 'centime', 'MAD', 2, 'Kingdom of Morocco', 'MA', 'MAR', 'Morocco', '002', '015', 0, '212', 'MA.png'),
(146, 'Maputo', 'Mozambican', '508', 'metical', 'MZN', 'centavo', 'MT', 2, 'Republic of Mozambique', 'MZ', 'MOZ', 'Mozambique', '002', '014', 0, '258', 'MZ.png'),
(147, 'Muscat', 'Omani', '512', 'Omani rial', 'OMR', 'baiza', '﷼', 3, 'Sultanate of Oman', 'OM', 'OMN', 'Oman', '142', '145', 0, '968', 'OM.png'),
(148, 'Windhoek', 'Namibian', '516', 'Namibian dollar', 'NAD', 'cent', '$', 2, 'Republic of Namibia', 'NA', 'NAM', 'Namibia', '002', '018', 0, '264', 'NA.png'),
(149, 'Yaren', 'Nauruan', '520', 'Australian dollar', 'AUD', 'cent', '$', 2, 'Republic of Nauru', 'NR', 'NRU', 'Nauru', '009', '057', 0, '674', 'NR.png'),
(150, 'Kathmandu', 'Nepalese', '524', 'Nepalese rupee', 'NPR', 'paisa (inv.)', '₨', 2, 'Nepal', 'NP', 'NPL', 'Nepal', '142', '034', 0, '977', 'NP.png'),
(151, 'Amsterdam (NL2)', 'Dutch', '528', 'euro', 'EUR', 'cent', '€', 2, 'Kingdom of the Netherlands', 'NL', 'NLD', 'Netherlands', '150', '155', 1, '31', 'NL.png'),
(152, 'Willemstad', 'Curaçaoan', '531', 'Netherlands Antillean guilder (CW1)', 'ANG', 'cent', NULL, NULL, 'Curaçao', 'CW', 'CUW', 'Curaçao', '019', '029', 0, '599', NULL),
(153, 'Oranjestad', 'Aruban', '533', 'Aruban guilder', 'AWG', 'cent', 'ƒ', 2, 'Aruba', 'AW', 'ABW', 'Aruba', '019', '029', 0, '297', 'AW.png'),
(154, 'Philipsburg', 'Sint Maartener', '534', 'Netherlands Antillean guilder (SX1)', 'ANG', 'cent', NULL, NULL, 'Sint Maarten', 'SX', 'SXM', 'Sint Maarten (Dutch part)', '019', '029', 0, '721', NULL),
(155, NULL, 'of Bonaire, Sint Eustatius and Saba', '535', 'US dollar', 'USD', 'cent', NULL, NULL, NULL, 'BQ', 'BES', 'Bonaire, Sint Eustatius and Saba', '019', '029', 0, '599', NULL),
(156, 'Nouméa', 'New Caledonian', '540', 'CFP franc', 'XPF', 'centime', 'XPF', 0, 'New Caledonia', 'NC', 'NCL', 'New Caledonia', '009', '054', 0, '687', 'NC.png'),
(157, 'Port Vila', 'Vanuatuan', '548', 'vatu (inv.)', 'VUV', '', 'Vt', 0, 'Republic of Vanuatu', 'VU', 'VUT', 'Vanuatu', '009', '054', 0, '678', 'VU.png'),
(158, 'Wellington', 'New Zealander', '554', 'New Zealand dollar', 'NZD', 'cent', '$', 2, 'New Zealand', 'NZ', 'NZL', 'New Zealand', '009', '053', 0, '64', 'NZ.png'),
(159, 'Managua', 'Nicaraguan', '558', 'córdoba oro', 'NIO', 'centavo', 'C$', 2, 'Republic of Nicaragua', 'NI', 'NIC', 'Nicaragua', '019', '013', 0, '505', 'NI.png'),
(160, 'Niamey', 'Nigerien', '562', 'CFA franc (BCEAO)', 'XOF', 'centime', 'XOF', 0, 'Republic of Niger', 'NE', 'NER', 'Niger', '002', '011', 0, '227', 'NE.png'),
(161, 'Abuja', 'Nigerian', '566', 'naira (inv.)', 'NGN', 'kobo (inv.)', '₦', 2, 'Federal Republic of Nigeria', 'NG', 'NGA', 'Nigeria', '002', '011', 0, '234', 'NG.png'),
(162, 'Alofi', 'Niuean', '570', 'New Zealand dollar', 'NZD', 'cent', '$', 2, 'Niue', 'NU', 'NIU', 'Niue', '009', '061', 0, '683', 'NU.png'),
(163, 'Kingston', 'Norfolk Islander', '574', 'Australian dollar', 'AUD', 'cent', '$', 2, 'Territory of Norfolk Island', 'NF', 'NFK', 'Norfolk Island', '009', '053', 0, '672', 'NF.png'),
(164, 'Oslo', 'Norwegian', '578', 'Norwegian krone (pl. kroner)', 'NOK', 'øre (inv.)', 'kr', 2, 'Kingdom of Norway', 'NO', 'NOR', 'Norway', '150', '154', 0, '47', 'NO.png'),
(165, 'Saipan', 'Northern Mariana Islander', '580', 'US dollar', 'USD', 'cent', '$', 2, 'Commonwealth of the Northern Mariana Islands', 'MP', 'MNP', 'Northern Mariana Islands', '009', '057', 0, '1', 'MP.png'),
(166, 'United States Minor Outlying Islands', 'of United States Minor Outlying Islands', '581', 'US dollar', 'USD', 'cent', '$', 2, 'United States Minor Outlying Islands', 'UM', 'UMI', 'United States Minor Outlying Islands', '', '', 0, '1', 'UM.png'),
(167, 'Palikir', 'Micronesian', '583', 'US dollar', 'USD', 'cent', '$', 2, 'Federated States of Micronesia', 'FM', 'FSM', 'Micronesia, Federated States of', '009', '057', 0, '691', 'FM.png'),
(168, 'Majuro', 'Marshallese', '584', 'US dollar', 'USD', 'cent', '$', 2, 'Republic of the Marshall Islands', 'MH', 'MHL', 'Marshall Islands', '009', '057', 0, '692', 'MH.png'),
(169, 'Melekeok', 'Palauan', '585', 'US dollar', 'USD', 'cent', '$', 2, 'Republic of Palau', 'PW', 'PLW', 'Palau', '009', '057', 0, '680', 'PW.png'),
(170, 'Islamabad', 'Pakistani', '586', 'Pakistani rupee', 'PKR', 'paisa', '₨', 2, 'Islamic Republic of Pakistan', 'PK', 'PAK', 'Pakistan', '142', '034', 0, '92', 'PK.png'),
(171, 'Panama City', 'Panamanian', '591', 'balboa', 'PAB', 'centésimo', 'B/.', 2, 'Republic of Panama', 'PA', 'PAN', 'Panama', '019', '013', 0, '507', 'PA.png'),
(172, 'Port Moresby', 'Papua New Guinean', '598', 'kina (inv.)', 'PGK', 'toea (inv.)', 'PGK', 2, 'Independent State of Papua New Guinea', 'PG', 'PNG', 'Papua New Guinea', '009', '054', 0, '675', 'PG.png'),
(173, 'Asunción', 'Paraguayan', '600', 'guaraní', 'PYG', 'céntimo', 'Gs', 0, 'Republic of Paraguay', 'PY', 'PRY', 'Paraguay', '019', '005', 0, '595', 'PY.png'),
(174, 'Lima', 'Peruvian', '604', 'new sol', 'PEN', 'céntimo', 'S/.', 2, 'Republic of Peru', 'PE', 'PER', 'Peru', '019', '005', 0, '51', 'PE.png'),
(175, 'Manila', 'Filipino', '608', 'Philippine peso', 'PHP', 'centavo', 'Php', 2, 'Republic of the Philippines', 'PH', 'PHL', 'Philippines', '142', '035', 0, '63', 'PH.png'),
(176, 'Adamstown', 'Pitcairner', '612', 'New Zealand dollar', 'NZD', 'cent', '$', 2, 'Pitcairn Islands', 'PN', 'PCN', 'Pitcairn', '009', '061', 0, '649', 'PN.png'),
(177, 'Warsaw', 'Polish', '616', 'zloty', 'PLN', 'grosz (pl. groszy)', 'zł', 2, 'Republic of Poland', 'PL', 'POL', 'Poland', '150', '151', 1, '48', 'PL.png'),
(178, 'Lisbon', 'Portuguese', '620', 'euro', 'EUR', 'cent', '€', 2, 'Portuguese Republic', 'PT', 'PRT', 'Portugal', '150', '039', 1, '351', 'PT.png'),
(179, 'Bissau', 'Guinea-Bissau national', '624', 'CFA franc (BCEAO)', 'XOF', 'centime', 'XOF', 0, 'Republic of Guinea-Bissau', 'GW', 'GNB', 'Guinea-Bissau', '002', '011', 0, '245', 'GW.png'),
(180, 'Dili', 'East Timorese', '626', 'US dollar', 'USD', 'cent', '$', 2, 'Democratic Republic of East Timor', 'TL', 'TLS', 'Timor-Leste', '142', '035', 0, '670', 'TL.png'),
(181, 'San Juan', 'Puerto Rican', '630', 'US dollar', 'USD', 'cent', '$', 2, 'Commonwealth of Puerto Rico', 'PR', 'PRI', 'Puerto Rico', '019', '029', 0, '1', 'PR.png'),
(182, 'Doha', 'Qatari', '634', 'Qatari riyal', 'QAR', 'dirham', '﷼', 2, 'State of Qatar', 'QA', 'QAT', 'Qatar', '142', '145', 0, '974', 'QA.png'),
(183, 'Saint-Denis', 'Reunionese', '638', 'euro', 'EUR', 'cent', '€', 2, 'Réunion', 'RE', 'REU', 'Réunion', '002', '014', 0, '262', 'RE.png'),
(184, 'Bucharest', 'Romanian', '642', 'Romanian leu (pl. lei)', 'RON', 'ban (pl. bani)', 'lei', 2, 'Romania', 'RO', 'ROU', 'Romania', '150', '151', 1, '40', 'RO.png'),
(185, 'Moscow', 'Russian', '643', 'Russian rouble', 'RUB', 'kopek', 'руб', 2, 'Russian Federation', 'RU', 'RUS', 'Russian Federation', '150', '151', 0, '7', 'RU.png'),
(186, 'Kigali', 'Rwandan; Rwandese', '646', 'Rwandese franc', 'RWF', 'centime', 'RWF', 0, 'Republic of Rwanda', 'RW', 'RWA', 'Rwanda', '002', '014', 0, '250', 'RW.png'),
(187, 'Gustavia', 'of Saint Barthélemy', '652', 'euro', 'EUR', 'cent', NULL, NULL, 'Collectivity of Saint Barthélemy', 'BL', 'BLM', 'Saint Barthélemy', '019', '029', 0, '590', NULL),
(188, 'Jamestown', 'Saint Helenian', '654', 'Saint Helena pound', 'SHP', 'penny', '£', 2, 'Saint Helena, Ascension and Tristan da Cunha', 'SH', 'SHN', 'Saint Helena, Ascension and Tristan da Cunha', '002', '011', 0, '290', 'SH.png'),
(189, 'Basseterre', 'Kittsian; Nevisian', '659', 'East Caribbean dollar', 'XCD', 'cent', '$', 2, 'Federation of Saint Kitts and Nevis', 'KN', 'KNA', 'Saint Kitts and Nevis', '019', '029', 0, '1', 'KN.png'),
(190, 'The Valley', 'Anguillan', '660', 'East Caribbean dollar', 'XCD', 'cent', '$', 2, 'Anguilla', 'AI', 'AIA', 'Anguilla', '019', '029', 0, '1', 'AI.png'),
(191, 'Castries', 'Saint Lucian', '662', 'East Caribbean dollar', 'XCD', 'cent', '$', 2, 'Saint Lucia', 'LC', 'LCA', 'Saint Lucia', '019', '029', 0, '1', 'LC.png'),
(192, 'Marigot', 'of Saint Martin', '663', 'euro', 'EUR', 'cent', NULL, NULL, 'Collectivity of Saint Martin', 'MF', 'MAF', 'Saint Martin (French part)', '019', '029', 0, '590', NULL),
(193, 'Saint-Pierre', 'St-Pierrais; Miquelonnais', '666', 'euro', 'EUR', 'cent', '€', 2, 'Territorial Collectivity of Saint Pierre and Miquelon', 'PM', 'SPM', 'Saint Pierre and Miquelon', '019', '021', 0, '508', 'PM.png'),
(194, 'Kingstown', 'Vincentian', '670', 'East Caribbean dollar', 'XCD', 'cent', '$', 2, 'Saint Vincent and the Grenadines', 'VC', 'VCT', 'Saint Vincent and the Grenadines', '019', '029', 0, '1', 'VC.png'),
(195, 'San Marino', 'San Marinese', '674', 'euro', 'EUR', 'cent', '€', 2, 'Republic of San Marino', 'SM', 'SMR', 'San Marino', '150', '039', 0, '378', 'SM.png'),
(196, 'São Tomé', 'São Toméan', '678', 'dobra', 'STD', 'centavo', 'Db', 2, 'Democratic Republic of São Tomé and Príncipe', 'ST', 'STP', 'Sao Tome and Principe', '002', '017', 0, '239', 'ST.png'),
(197, 'Riyadh', 'Saudi Arabian', '682', 'riyal', 'SAR', 'halala', '﷼', 2, 'Kingdom of Saudi Arabia', 'SA', 'SAU', 'Saudi Arabia', '142', '145', 0, '966', 'SA.png'),
(198, 'Dakar', 'Senegalese', '686', 'CFA franc (BCEAO)', 'XOF', 'centime', 'XOF', 0, 'Republic of Senegal', 'SN', 'SEN', 'Senegal', '002', '011', 0, '221', 'SN.png'),
(199, 'Belgrade', 'Serb', '688', 'Serbian dinar', 'RSD', 'para (inv.)', NULL, NULL, 'Republic of Serbia', 'RS', 'SRB', 'Serbia', '150', '039', 0, '381', NULL),
(200, 'Victoria', 'Seychellois', '690', 'Seychelles rupee', 'SCR', 'cent', '₨', 2, 'Republic of Seychelles', 'SC', 'SYC', 'Seychelles', '002', '014', 0, '248', 'SC.png'),
(201, 'Freetown', 'Sierra Leonean', '694', 'leone', 'SLL', 'cent', 'Le', 2, 'Republic of Sierra Leone', 'SL', 'SLE', 'Sierra Leone', '002', '011', 0, '232', 'SL.png'),
(202, 'Singapore', 'Singaporean', '702', 'Singapore dollar', 'SGD', 'cent', '$', 2, 'Republic of Singapore', 'SG', 'SGP', 'Singapore', '142', '035', 0, '65', 'SG.png'),
(203, 'Bratislava', 'Slovak', '703', 'euro', 'EUR', 'cent', 'Sk', 2, 'Slovak Republic', 'SK', 'SVK', 'Slovakia', '150', '151', 1, '421', 'SK.png'),
(204, 'Hanoi', 'Vietnamese', '704', 'dong', 'VND', '(10 hào', '₫', 2, 'Socialist Republic of Vietnam', 'VN', 'VNM', 'Viet Nam', '142', '035', 0, '84', 'VN.png'),
(205, 'Ljubljana', 'Slovene', '705', 'euro', 'EUR', 'cent', '€', 2, 'Republic of Slovenia', 'SI', 'SVN', 'Slovenia', '150', '039', 1, '386', 'SI.png'),
(206, 'Mogadishu', 'Somali', '706', 'Somali shilling', 'SOS', 'cent', 'S', 2, 'Somali Republic', 'SO', 'SOM', 'Somalia', '002', '014', 0, '252', 'SO.png'),
(207, 'Pretoria (ZA1)', 'South African', '710', 'rand', 'ZAR', 'cent', 'R', 2, 'Republic of South Africa', 'ZA', 'ZAF', 'South Africa', '002', '018', 0, '27', 'ZA.png'),
(208, 'Harare', 'Zimbabwean', '716', 'Zimbabwe dollar (ZW1)', 'ZWL', 'cent', 'Z$', 2, 'Republic of Zimbabwe', 'ZW', 'ZWE', 'Zimbabwe', '002', '014', 0, '263', 'ZW.png'),
(209, 'Madrid', 'Spaniard', '724', 'euro', 'EUR', 'cent', '€', 2, 'Kingdom of Spain', 'ES', 'ESP', 'Spain', '150', '039', 1, '34', 'ES.png'),
(210, 'Juba', 'South Sudanese', '728', 'South Sudanese pound', 'SSP', 'piaster', NULL, NULL, 'Republic of South Sudan', 'SS', 'SSD', 'South Sudan', '002', '015', 0, '211', NULL),
(211, 'Khartoum', 'Sudanese', '729', 'Sudanese pound', 'SDG', 'piastre', NULL, NULL, 'Republic of the Sudan', 'SD', 'SDN', 'Sudan', '002', '015', 0, '249', NULL),
(212, 'Al aaiun', 'Sahrawi', '732', 'Moroccan dirham', 'MAD', 'centime', 'MAD', 2, 'Western Sahara', 'EH', 'ESH', 'Western Sahara', '002', '015', 0, '212', 'EH.png'),
(213, 'Paramaribo', 'Surinamese', '740', 'Surinamese dollar', 'SRD', 'cent', '$', 2, 'Republic of Suriname', 'SR', 'SUR', 'Suriname', '019', '005', 0, '597', 'SR.png'),
(214, 'Longyearbyen', 'of Svalbard', '744', 'Norwegian krone (pl. kroner)', 'NOK', 'øre (inv.)', 'kr', 2, 'Svalbard and Jan Mayen', 'SJ', 'SJM', 'Svalbard and Jan Mayen', '150', '154', 0, '47', 'SJ.png'),
(215, 'Mbabane', 'Swazi', '748', 'lilangeni', 'SZL', 'cent', 'SZL', 2, 'Kingdom of Swaziland', 'SZ', 'SWZ', 'Swaziland', '002', '018', 0, '268', 'SZ.png'),
(216, 'Stockholm', 'Swedish', '752', 'krona (pl. kronor)', 'SEK', 'öre (inv.)', 'kr', 2, 'Kingdom of Sweden', 'SE', 'SWE', 'Sweden', '150', '154', 1, '46', 'SE.png'),
(217, 'Berne', 'Swiss', '756', 'Swiss franc', 'CHF', 'centime', 'CHF', 2, 'Swiss Confederation', 'CH', 'CHE', 'Switzerland', '150', '155', 0, '41', 'CH.png'),
(218, 'Damascus', 'Syrian', '760', 'Syrian pound', 'SYP', 'piastre', '£', 2, 'Syrian Arab Republic', 'SY', 'SYR', 'Syrian Arab Republic', '142', '145', 0, '963', 'SY.png'),
(219, 'Dushanbe', 'Tajik', '762', 'somoni', 'TJS', 'diram', 'TJS', 2, 'Republic of Tajikistan', 'TJ', 'TJK', 'Tajikistan', '142', '143', 0, '992', 'TJ.png'),
(220, 'Bangkok', 'Thai', '764', 'baht (inv.)', 'THB', 'satang (inv.)', '฿', 2, 'Kingdom of Thailand', 'TH', 'THA', 'Thailand', '142', '035', 0, '66', 'TH.png'),
(221, 'Lomé', 'Togolese', '768', 'CFA franc (BCEAO)', 'XOF', 'centime', 'XOF', 0, 'Togolese Republic', 'TG', 'TGO', 'Togo', '002', '011', 0, '228', 'TG.png'),
(222, '(TK2)', 'Tokelauan', '772', 'New Zealand dollar', 'NZD', 'cent', '$', 2, 'Tokelau', 'TK', 'TKL', 'Tokelau', '009', '061', 0, '690', 'TK.png'),
(223, 'Nuku’alofa', 'Tongan', '776', 'pa’anga (inv.)', 'TOP', 'seniti (inv.)', 'T$', 2, 'Kingdom of Tonga', 'TO', 'TON', 'Tonga', '009', '061', 0, '676', 'TO.png'),
(224, 'Port of Spain', 'Trinidadian; Tobagonian', '780', 'Trinidad and Tobago dollar', 'TTD', 'cent', 'TT$', 2, 'Republic of Trinidad and Tobago', 'TT', 'TTO', 'Trinidad and Tobago', '019', '029', 0, '1', 'TT.png'),
(225, 'Abu Dhabi', 'Emirian', '784', 'UAE dirham', 'AED', 'fils (inv.)', 'AED', 2, 'United Arab Emirates', 'AE', 'ARE', 'United Arab Emirates', '142', '145', 0, '971', 'AE.png'),
(226, 'Tunis', 'Tunisian', '788', 'Tunisian dinar', 'TND', 'millime', 'TND', 3, 'Republic of Tunisia', 'TN', 'TUN', 'Tunisia', '002', '015', 0, '216', 'TN.png'),
(227, 'Ankara', 'Turk', '792', 'Turkish lira (inv.)', 'TRY', 'kurus (inv.)', '₺', 2, 'Republic of Turkey', 'TR', 'TUR', 'Turkey', '142', '145', 0, '90', 'TR.png'),
(228, 'Ashgabat', 'Turkmen', '795', 'Turkmen manat (inv.)', 'TMT', 'tenge (inv.)', 'm', 2, 'Turkmenistan', 'TM', 'TKM', 'Turkmenistan', '142', '143', 0, '993', 'TM.png'),
(229, 'Cockburn Town', 'Turks and Caicos Islander', '796', 'US dollar', 'USD', 'cent', '$', 2, 'Turks and Caicos Islands', 'TC', 'TCA', 'Turks and Caicos Islands', '019', '029', 0, '1', 'TC.png'),
(230, 'Funafuti', 'Tuvaluan', '798', 'Australian dollar', 'AUD', 'cent', '$', 2, 'Tuvalu', 'TV', 'TUV', 'Tuvalu', '009', '061', 0, '688', 'TV.png'),
(231, 'Kampala', 'Ugandan', '800', 'Uganda shilling', 'UGX', 'cent', 'UGX', 0, 'Republic of Uganda', 'UG', 'UGA', 'Uganda', '002', '014', 0, '256', 'UG.png'),
(232, 'Kiev', 'Ukrainian', '804', 'hryvnia', 'UAH', 'kopiyka', '₴', 2, 'Ukraine', 'UA', 'UKR', 'Ukraine', '150', '151', 0, '380', 'UA.png'),
(233, 'Skopje', 'of the former Yugoslav Republic of Macedonia', '807', 'denar (pl. denars)', 'MKD', 'deni (inv.)', 'ден', 2, 'the former Yugoslav Republic of Macedonia', 'MK', 'MKD', 'Macedonia, the former Yugoslav Republic of', '150', '039', 0, '389', 'MK.png'),
(234, 'Cairo', 'Egyptian', '818', 'Egyptian pound', 'EGP', 'piastre', '£', 2, 'Arab Republic of Egypt', 'EG', 'EGY', 'Egypt', '002', '015', 0, '20', 'EG.png'),
(235, 'London', 'British', '826', 'pound sterling', 'GBP', 'penny (pl. pence)', '£', 2, 'United Kingdom of Great Britain and Northern Ireland', 'GB', 'GBR', 'United Kingdom', '150', '154', 1, '44', 'GB.png'),
(236, 'St Peter Port', 'of Guernsey', '831', 'Guernsey pound (GG2)', 'GGP (GG2)', 'penny (pl. pence)', NULL, NULL, 'Bailiwick of Guernsey', 'GG', 'GGY', 'Guernsey', '150', '154', 0, '44', NULL),
(237, 'St Helier', 'of Jersey', '832', 'Jersey pound (JE2)', 'JEP (JE2)', 'penny (pl. pence)', NULL, NULL, 'Bailiwick of Jersey', 'JE', 'JEY', 'Jersey', '150', '154', 0, '44', NULL),
(238, 'Douglas', 'Manxman; Manxwoman', '833', 'Manx pound (IM2)', 'IMP (IM2)', 'penny (pl. pence)', NULL, NULL, 'Isle of Man', 'IM', 'IMN', 'Isle of Man', '150', '154', 0, '44', NULL),
(239, 'Dodoma (TZ1)', 'Tanzanian', '834', 'Tanzanian shilling', 'TZS', 'cent', 'TZS', 2, 'United Republic of Tanzania', 'TZ', 'TZA', 'Tanzania, United Republic of', '002', '014', 0, '255', 'TZ.png'),
(240, 'Washington DC', 'American', '840', 'US dollar', 'USD', 'cent', '$', 2, 'United States of America', 'US', 'USA', 'United States', '019', '021', 0, '1', 'US.png'),
(241, 'Charlotte Amalie', 'US Virgin Islander', '850', 'US dollar', 'USD', 'cent', '$', 2, 'United States Virgin Islands', 'VI', 'VIR', 'Virgin Islands, U.S.', '019', '029', 0, '1', 'VI.png'),
(242, 'Ouagadougou', 'Burkinabe', '854', 'CFA franc (BCEAO)', 'XOF', 'centime', 'XOF', 0, 'Burkina Faso', 'BF', 'BFA', 'Burkina Faso', '002', '011', 0, '226', 'BF.png'),
(243, 'Montevideo', 'Uruguayan', '858', 'Uruguayan peso', 'UYU', 'centésimo', '$U', 0, 'Eastern Republic of Uruguay', 'UY', 'URY', 'Uruguay', '019', '005', 0, '598', 'UY.png'),
(244, 'Tashkent', 'Uzbek', '860', 'sum (inv.)', 'UZS', 'tiyin (inv.)', 'лв', 2, 'Republic of Uzbekistan', 'UZ', 'UZB', 'Uzbekistan', '142', '143', 0, '998', 'UZ.png'),
(245, 'Caracas', 'Venezuelan', '862', 'bolívar fuerte (pl. bolívares fuertes)', 'VEF', 'céntimo', 'Bs', 2, 'Bolivarian Republic of Venezuela', 'VE', 'VEN', 'Venezuela, Bolivarian Republic of', '019', '005', 0, '58', 'VE.png'),
(246, 'Mata-Utu', 'Wallisian; Futunan; Wallis and Futuna Islander', '876', 'CFP franc', 'XPF', 'centime', 'XPF', 0, 'Wallis and Futuna', 'WF', 'WLF', 'Wallis and Futuna', '009', '061', 0, '681', 'WF.png'),
(247, 'Apia', 'Samoan', '882', 'tala (inv.)', 'WST', 'sene (inv.)', 'WS$', 2, 'Independent State of Samoa', 'WS', 'WSM', 'Samoa', '009', '061', 0, '685', 'WS.png'),
(248, 'San’a', 'Yemenite', '887', 'Yemeni rial', 'YER', 'fils (inv.)', '﷼', 2, 'Republic of Yemen', 'YE', 'YEM', 'Yemen', '142', '145', 0, '967', 'YE.png'),
(249, 'Lusaka', 'Zambian', '894', 'Zambian kwacha (inv.)', 'ZMW', 'ngwee (inv.)', 'ZK', 2, 'Republic of Zambia', 'ZM', 'ZMB', 'Zambia', '002', '014', 0, '260', 'ZM.png'),
(250, 'Monde', 'Monde', '894', 'Monde', 'MDE', 'Monde', 'MD', 2, 'Monde', 'MD', 'MDE', 'Monde', '000', '000', 0, '000', 'MD.png');

-- --------------------------------------------------------

--
-- Structure de la table `disclaimerstatuses`
--

CREATE TABLE `disclaimerstatuses` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `seen_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `forms`
--

CREATE TABLE `forms` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `disclaimer` text COLLATE utf8mb4_unicode_ci,
  `published_at` datetime DEFAULT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `modified_by` int(10) UNSIGNED DEFAULT NULL,
  `published_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `forms`
--

INSERT INTO `forms` (`id`, `title`, `disclaimer`, `published_at`, `created_by`, `modified_by`, `published_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '{\"en\":\"Initial form\",\"fr\":\"Formulaire Initial\"}', '{\"en\":\"<p style=\\\"margin-left:0cm; margin-right:0cm; text-align:justify\\\"><span style=\\\"font-family:&quot;Arial&quot;,sans-serif; font-size:12pt\\\"><strong>Disclaimer P1&nbsp;<\\/strong><\\/span><\\/p>\\r\\n\\r\\n<div style=\\\"page-break-after:always\\\"><span style=\\\"display:none\\\">&nbsp;<\\/span><\\/div>\\r\\n\\r\\n<p style=\\\"margin-left:0cm; margin-right:0cm; text-align:justify\\\"><span style=\\\"font-family:&quot;Arial&quot;,sans-serif; font-size:12pt\\\"><strong>Disclaimer P2&nbsp; <\\/strong> <\\/span><\\/p>\\r\\n\\r\\n<div style=\\\"page-break-after:always\\\"><span style=\\\"display:none\\\">&nbsp;<\\/span><\\/div>\\r\\n\\r\\n<p style=\\\"margin-left:0cm; margin-right:0cm; text-align:justify\\\"><span style=\\\"font-family:&quot;Arial&quot;,sans-serif; font-size:12pt\\\"><strong>Disclaimer P3&nbsp;<\\/strong><\\/span><\\/p>\",\"fr\":\"<p style=\\\"margin-left:0cm; margin-right:0cm; text-align:justify\\\"><span style=\\\"font-family:&quot;Arial&quot;,sans-serif; font-size:12pt\\\"><strong>Disclaimer P1&nbsp;<\\/strong><\\/span><\\/p>\\r\\n\\r\\n<div style=\\\"page-break-after:always\\\"><span style=\\\"display:none\\\">&nbsp;<\\/span><\\/div>\\r\\n\\r\\n<p style=\\\"margin-left:0cm; margin-right:0cm; text-align:justify\\\"><span style=\\\"font-family:&quot;Arial&quot;,sans-serif; font-size:12pt\\\"><strong>Disclaimer P2&nbsp; <\\/strong> <\\/span><\\/p>\\r\\n\\r\\n<div style=\\\"page-break-after:always\\\"><span style=\\\"display:none\\\">&nbsp;<\\/span><\\/div>\\r\\n\\r\\n<p style=\\\"margin-left:0cm; margin-right:0cm; text-align:justify\\\"><span style=\\\"font-family:&quot;Arial&quot;,sans-serif; font-size:12pt\\\"><strong>Disclaimer P3&nbsp;<\\/strong><\\/span><\\/p>\"}', '2018-10-02 13:24:29', 1, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:24:29', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `form_elements`
--

CREATE TABLE `form_elements` (
  `id` int(10) UNSIGNED NOT NULL,
  `page_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` text COLLATE utf8mb4_unicode_ci,
  `tips` text COLLATE utf8mb4_unicode_ci,
  `placeholder` text COLLATE utf8mb4_unicode_ci,
  `special` text COLLATE utf8mb4_unicode_ci,
  `field_required` tinyint(1) NOT NULL DEFAULT '0',
  `cnil_required` tinyint(1) NOT NULL DEFAULT '0',
  `ordering` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `created_by` int(10) UNSIGNED NOT NULL,
  `modified_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `form_elements`
--

INSERT INTO `form_elements` (`id`, `page_id`, `name`, `type`, `label`, `tips`, `placeholder`, `special`, `field_required`, `cnil_required`, `ordering`, `created_by`, `modified_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'name', 'text', '{\"en\":\"Name of the processing\",\"fr\":\"Nom du traitement\"}', '{\"en\":null,\"fr\":null}', '{\"en\": \"Name of your project\", \"fr\": \"Nom de votre projet\"}', '{\"en\": null, \"fr\": null}', 1, 1, 1, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(2, 1, 'date', 'datepicker', '{\"en\":\"Date of the analysis\",\"fr\":\"Date de l\'analyse\"}', '{\"en\": null, \"fr\": null}', '{\"en\": null, \"fr\": null}', '{\n    \"default_to_now\": \"1\"\n}', 1, 0, 2, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(3, 1, 'user', 'username', '{\"en\": \"Name of the declarant\", \"fr\": \"Nom du déclarant\"}', '{\"en\": null, \"fr\": null}', '{\"en\":\"The declarant is the person in charge of the implementation of the processing\",\"fr\":\"Le d\\u00e9clarant est la personne qui est en charge du traitement\"}', '{\"en\": null, \"fr\": null}', 1, 0, 3, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(4, 1, 'responsable', 'text', '{\"en\": \"Designation of the department or director responsible for implementation\", \"fr\": \"Désignation du département ou de la direction chargé(e) de la mise en oeuvre\"}', '{\"en\": null, \"fr\": null}', '{\"en\": \"Enter the designation\", \"fr\": \"Entrez la désignation\"}', '{\"en\": null, \"fr\": null}', 1, 0, 4, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(5, 1, 'type_project', 'radiogroup', '{\"fr\":\"Le traitement est-il r\\u00e9alis\\u00e9 par et pour la soci\\u00e9t\\u00e9 ou par la soci\\u00e9t\\u00e9 pour un de ses clients ?\",\"en\":\"Does the processing is implemented by and for the company or by the company on behalf of a client:\"}', '{\"fr\":null,\"en\":null}', '{\"fr\":null,\"en\":null}', '[\n    {\n        \"value\": 1,\n        \"label\": {\n            \"fr\": \"Par et pour le compte de la soci\\u00e9t\\u00e9\",\n            \"en\": \"By and for the company\"\n        },\n        \"default\": false\n    },\n    {\n        \"value\": 2,\n        \"label\": {\n            \"fr\": \"Par la soci\\u00e9t\\u00e9 pour le compte d\'un client\",\n            \"en\": \"By the company and on behalf of a client\"\n        },\n        \"default\": false\n    }\n]', 1, 1, 5, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:21:59', NULL),
(6, 1, 'name_client', 'text', '{\"fr\":\"Quel est le nom du client pour lequel la soci\\u00e9t\\u00e9 r\\u00e9alise le traitement ?\",\"en\":\"What is the name of the Client for which the processing is implemented by the company ?\"}', '{\"fr\":null,\"en\":null}', '{\"fr\":null,\"en\":null}', NULL, 0, 0, 6, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(7, 1, 'common_treatment_10', 'radiogroup', '{\"en\":\"Is this a common processing for the companies of the Group?\",\"fr\":\"S\'agit-il d\'un traitement commun aux soci\\u00e9t\\u00e9s du Groupe ?\"}', '{\"en\": null, \"fr\": null}', '{\"en\": null, \"fr\": null}', '[\n    {\n        \"value\": 2,\n        \"label\": {\n            \"fr\": \"Non\",\n            \"en\": \"No\"\n        },\n        \"default\": false\n    },\n    {\n        \"value\": 1,\n        \"label\": {\n            \"fr\": \"Oui\",\n            \"en\": \"Yes\"\n        },\n        \"default\": false\n    }\n]', 0, 0, 7, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(8, 1, 'company', 'company', '{\"en\":\"Which company implements the processing? (on its behalf or on the behalf of a client)\",\"fr\":\"Quelle soci\\u00e9t\\u00e9 met en oeuvre le traitement ? (pour son compte ou celui d\'un client)\"}', '{\"en\": null, \"fr\": null}', '{\"en\": null, \"fr\": null}', '{\"en\": null, \"fr\": null}', 1, 1, 8, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(9, 1, 'model', 'model', '{\"en\": \"Apply template\", \"fr\": \"Appliquer un modèle\"}', '{\"en\": null, \"fr\": null}', '{\"en\":\"Some data processing are recurrent. Several models have been drafted to help you out.Yet, the information automatically filled-in must be carefully read and validated.\",\"fr\":\"Certains traitements sont r\\u00e9currents. Pour vous aider des mod\\u00e8les ont \\u00e9t\\u00e9 r\\u00e9alis\\u00e9s. Cependant, les informations seront \\u00e0 relire attentivement et \\u00e0 valider.\"}', '{\"en\": \"Yes\\r\\nNo*\", \"fr\": \"Oui\\r\\nNon*\"}', 0, 0, 9, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(10, 1, 'estimated_date_of_implementation_08', 'datepicker', '{\"en\":\"Estimated date of implementation of the processing\",\"fr\":\"Date pr\\u00e9visionnelle de mise en oeuvre du traitement\"}', '{\"en\": null, \"fr\": null}', '{\"en\":null,\"fr\":null}', '{\n    \"default_to_now\": false\n}', 0, 0, 10, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(11, 2, 'purpose_11', 'textarea', '{\"en\": \"What is the purpose of the processing of personal data?\", \"fr\": \"Quelle est la finalité du traitement de données personnelles ?\"}', '{\"en\": null, \"fr\": null}', '{\"en\": null, \"fr\": null}', '{\"en\": null, \"fr\": null}', 1, 1, 11, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(12, 3, 'base_juridiq', 'checkboxgroup', '{\"fr\":\"Quelle est la base juridique du traitement ?\",\"en\":\"What is the processing legal basis?\"}', '{\"fr\":null,\"en\":null}', '{\"fr\":null,\"en\":null}', '[\n    {\n        \"value\": 1,\n        \"label\": {\n            \"fr\": \"Consentement de la personne\",\n            \"en\": \"Consent given by the data subject\"\n        }\n    },\n    {\n        \"value\": 2,\n        \"label\": {\n            \"fr\": \"N\\u00e9cessaire \\u00e0 l\'ex\\u00e9cution d\'un contrat auquel la personne concern\\u00e9e est partie ou \\u00e0 l\'ex\\u00e9cution de mesures pr\\u00e9contractuelles prises \\u00e0 la demande de celle-ci\",\n            \"en\": \"Performance of a contract to which the data subject is party or in order to take steps at the request of the data subject prior to entering into a contractual relation\"\n        }\n    },\n    {\n        \"value\": 3,\n        \"label\": {\n            \"fr\": \"N\\u00e9cessaire au respect d\'une obligation l\\u00e9gale\",\n            \"en\": \"Necessary for complying with a legal obligation\"\n        }\n    },\n    {\n        \"value\": 4,\n        \"label\": {\n            \"fr\": \"N\\u00e9cessaire \\u00e0 la sauvegarde des int\\u00e9r\\u00eats vitaux de la personne concern\\u00e9e ou d\'une autre personne\",\n            \"en\": \"Necessary in order to protect the vital interests of the concerned person or another person\"\n        }\n    },\n    {\n        \"value\": 5,\n        \"label\": {\n            \"fr\": \"N\\u00e9cessaire \\u00e0 l\'ex\\u00e9cution d\'une mission d\'int\\u00e9r\\u00eat public\",\n            \"en\": \"Necessary for the performance of a task carried out in the public interest\"\n        }\n    },\n    {\n        \"value\": 6,\n        \"label\": {\n            \"fr\": \"Int\\u00e9r\\u00eats l\\u00e9gitimes de la soci\\u00e9t\\u00e9\",\n            \"en\": \"Legitimate interests of the company\"\n        }\n    }\n]', 0, 1, 12, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:21:02', NULL),
(13, 3, 'how_did_person_give_consent_21_02', 'textarea', '{\"en\":\"How does the person give his\\/her consent?\",\"fr\":\"Comment la personne donne-t-elle son consentement ?\"}', '{\"en\": null, \"fr\": null}', '{\"en\": null, \"fr\": null}', '{\"en\": null, \"fr\": null}', 0, 0, 13, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(14, 3, 'traitement_justified_by_contract_21_03', 'radiogroup', '{\"en\":\"Is the processing justified by an employment contract?\",\"fr\":\"Le traitement est-il justifi\\u00e9 par un contrat de travail ?\"}', '{\"en\": null, \"fr\": null}', '{\"en\": null, \"fr\": null}', '[\n    {\n        \"value\": 1,\n        \"label\": {\n            \"fr\": \"Oui\",\n            \"en\": \"Oui\"\n        },\n        \"default\": false\n    },\n    {\n        \"value\": 2,\n        \"label\": {\n            \"fr\": \"Non\",\n            \"en\": \"Non\"\n        },\n        \"default\": true\n    }\n]', 0, 0, 14, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(15, 3, 'legal_oblig', 'textarea', '{\"fr\":\"Indiquer la r\\u00e9f\\u00e9rence de l\'obligation l\\u00e9gale (ex : article XX du code du travail fran\\u00e7ais)\",\"en\":\"Indicate the reference to the legal obligation (ex: article XX of the french labour code)\"}', '{\"fr\":null,\"en\":null}', '{\"fr\":null,\"en\":null}', NULL, 0, 0, 15, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(16, 3, 'legitimate_interest', 'textarea', '{\"fr\":\"Indiquer l\'int\\u00e9r\\u00eat l\\u00e9gitime de la soci\\u00e9t\\u00e9\",\"en\":\"Indicate the concerned legitimate interest\"}', '{\"fr\":null,\"en\":null}', '{\"fr\":null,\"en\":null}', NULL, 0, 0, 16, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:22:21', NULL),
(17, 4, 'pers_concernees', 'textarea', '{\"fr\":\"Quelles sont les cat\\u00e9gories de personnes concern\\u00e9es par ce traitement ?\",\"en\":\"Who are the data subjects affected by the processing?\"}', '{\"fr\":null,\"en\":null}', '{\"fr\":null,\"en\":null}', '{}', 0, 1, 17, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(18, 5, 'identification_data_14', 'radiogroup', '{\"en\":\"Identification data and\\/or of personal life\",\"fr\":\"Donn\\u00e9es d\'identification et\\/ou de vie personnelle\"}', '{\"en\":null,\"fr\":null}', '{\"en\": null, \"fr\": null}', '[\n    {\n        \"value\": 1,\n        \"label\": {\n            \"fr\": \"Oui\",\n            \"en\": \"Yes\"\n        },\n        \"default\": false\n    },\n    {\n        \"value\": 2,\n        \"label\": {\n            \"fr\": \"Non\",\n            \"en\": \"No\"\n        },\n        \"default\": true\n    }\n]', 0, 1, 18, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(19, 5, 'identification_processed_data_14_02', 'textarea', '{\"en\":\"Specify the processed data\",\"fr\":\"Pr\\u00e9ciser les donn\\u00e9es trait\\u00e9es\"}', '{\"en\": null, \"fr\": null}', '{\"en\":null,\"fr\":null}', '{\"en\": null, \"fr\": null}', 0, 1, 19, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(20, 5, 'identification_purpose_of_personal_data_14_03', 'textarea', '{\"en\":\"For what use will the personal data be processed?\",\"fr\":\"Quelle est l\\u2019utilit\\u00e9 des donn\\u00e9es personnelles qui vont \\u00eatre trait\\u00e9es ?\"}', '{\"en\": null, \"fr\": null}', '{\"en\":null,\"fr\":null}', '{\"en\": null, \"fr\": null}', 0, 1, 20, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(21, 5, 'identification_data_source_14_04', 'text', '{\"en\":\"What is the source of the data?\",\"fr\":\"Quelle est la provenance des donn\\u00e9es ?\"}', '{\"en\": null, \"fr\": null}', '{\"en\":null,\"fr\":null}', '{\"en\": null, \"fr\": null}', 0, 1, 21, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(22, 5, 'computer_data_15', 'radiogroup', '{\"en\":\"Connection data\",\"fr\":\"Donn\\u00e9es de connexion\"}', '{\"en\":null,\"fr\":null}', '{\"en\": null, \"fr\": null}', '[\n    {\n        \"value\": 1,\n        \"label\": {\n            \"fr\": \"Oui\",\n            \"en\": \"Yes\"\n        },\n        \"default\": false\n    },\n    {\n        \"value\": 2,\n        \"label\": {\n            \"fr\": \"Non\",\n            \"en\": \"No\"\n        },\n        \"default\": true\n    }\n]', 0, 1, 22, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(23, 5, 'computer_processed_data_15_02', 'textarea', '{\"en\":\"Specify the processed data\",\"fr\":\"Pr\\u00e9ciser les donn\\u00e9es trait\\u00e9es\"}', '{\"en\": null, \"fr\": null}', '{\"en\":null,\"fr\":null}', '{\"en\": null, \"fr\": null}', 0, 1, 23, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(24, 5, 'computer_purpose_of_personal_data_15_04', 'textarea', '{\"en\":\"For what use will the personal data be processed?\",\"fr\":\"Quelle est l\\u2019utilit\\u00e9 des donn\\u00e9es personnelles qui vont \\u00eatre trait\\u00e9es ?\"}', '{\"en\": null, \"fr\": null}', '{\"en\":null,\"fr\":null}', '{\"en\": null, \"fr\": null}', 0, 1, 24, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(25, 5, 'computer_data_source_15_03', 'text', '{\"en\": \"What is the source of the data?\", \"fr\": \"Quelles est la provenance des données ?\"}', '{\"en\": null, \"fr\": null}', '{\"en\":null,\"fr\":null}', '{\"en\": null, \"fr\": null}', 0, 1, 25, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(26, 5, 'professional_data_16', 'radiogroup', '{\"en\":\"Professional data\",\"fr\":\"Donn\\u00e9es professionnelles\"}', '{\"en\":null,\"fr\":null}', '{\"en\": null, \"fr\": null}', '[\n    {\n        \"value\": 1,\n        \"label\": {\n            \"fr\": \"Oui\",\n            \"en\": \"Yes\"\n        },\n        \"default\": false\n    },\n    {\n        \"value\": 2,\n        \"label\": {\n            \"fr\": \"Non\",\n            \"en\": \"No\"\n        },\n        \"default\": true\n    }\n]', 0, 1, 26, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(27, 5, 'professional_processed_data_16_02', 'textarea', '{\"en\":\"Specify the processed data\",\"fr\":\"Pr\\u00e9ciser les donn\\u00e9es trait\\u00e9es\"}', '{\"en\": null, \"fr\": null}', '{\"en\":null,\"fr\":null}', '{\"en\": null, \"fr\": null}', 0, 1, 27, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(28, 5, 'professional_purpose_of_personnal_data_16_04', 'textarea', '{\"en\":\"For what use will the personal data be processed?\",\"fr\":\"Quelle est l\\u2019utilit\\u00e9 des donn\\u00e9es personnelles qui vont \\u00eatre trait\\u00e9es ?\"}', '{\"en\": null, \"fr\": null}', '{\"en\":null,\"fr\":null}', '{\"en\": null, \"fr\": null}', 0, 1, 28, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(29, 5, 'professional_data_source_16_03', 'text', '{\"en\":\"What is the source of the data?\",\"fr\":\"Quelle est la provenance des donn\\u00e9es ?\"}', '{\"en\": null, \"fr\": null}', '{\"en\":null,\"fr\":null}', '{\"en\": null, \"fr\": null}', 0, 1, 29, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(30, 5, 'bank_data_17', 'radiogroup', '{\"en\": \"Bank data\", \"fr\": \"Données bancaires\"}', '{\"en\": null, \"fr\": null}', '{\"en\": null, \"fr\": null}', '[\n    {\n        \"value\": 1,\n        \"label\": {\n            \"fr\": \"Oui\",\n            \"en\": \"Yes\"\n        },\n        \"default\": false\n    },\n    {\n        \"value\": 2,\n        \"label\": {\n            \"fr\": \"Non\",\n            \"en\": \"No\"\n        },\n        \"default\": true\n    }\n]', 0, 1, 30, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(31, 5, 'bank_processed_data_17_02', 'textarea', '{\"en\":\"Specify the processed data\",\"fr\":\"Pr\\u00e9ciser les donn\\u00e9es trait\\u00e9es\"}', '{\"en\": null, \"fr\": null}', '{\"en\":null,\"fr\":null}', '{\"en\": null, \"fr\": null}', 0, 1, 31, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(32, 5, 'bank_purpose_of_personnal_data_17_04', 'textarea', '{\"en\":\"For what use will the personal data be processed?\",\"fr\":\"Quelle est l\\u2019utilit\\u00e9 des donn\\u00e9es personnelles qui vont \\u00eatre trait\\u00e9es ?\"}', '{\"en\": null, \"fr\": null}', '{\"en\":null,\"fr\":null}', '{\"en\": null, \"fr\": null}', 0, 1, 32, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(33, 5, 'bank_data_source_17_03', 'text', '{\"en\":\"What is the source of the data?\",\"fr\":\"Quelle est la provenance des donn\\u00e9es ?\"}', '{\"en\": null, \"fr\": null}', '{\"en\":null,\"fr\":null}', '{\"en\": null, \"fr\": null}', 0, 1, 33, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(34, 5, 'other_data_19', 'radiogroup', '{\"en\":\"Do you collect other categories of personal data than the one descirbed hereabove?\",\"fr\":\"Collectez-vous d\'autres cat\\u00e9gories de donn\\u00e9es personnelles que celles indiqu\\u00e9es ci-dessus?\"}', '{\"en\": null, \"fr\": null}', '{\"en\": null, \"fr\": null}', '[\n    {\n        \"value\": 1,\n        \"label\": {\n            \"fr\": \"Oui\",\n            \"en\": \"Yes\"\n        },\n        \"default\": false\n    },\n    {\n        \"value\": 2,\n        \"label\": {\n            \"fr\": \"Non\",\n            \"en\": \"No\"\n        },\n        \"default\": true\n    }\n]', 0, 1, 34, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(35, 5, 'other_data_name_19_01', 'textarea', '{\"en\":\"Specify the processed data\",\"fr\":\"Pr\\u00e9ciser les donn\\u00e9es trait\\u00e9es\"}', '{\"en\": null, \"fr\": null}', '{\"en\":null,\"fr\":null}', '{\"en\": null, \"fr\": null}', 0, 1, 35, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(36, 5, 'other_data_usage_19_03', 'textarea', '{\"en\":\"For what use will the personal data be processed?\",\"fr\":\"Quelle est l\\u2019utilit\\u00e9 des donn\\u00e9es personnelles qui vont \\u00eatre trait\\u00e9es ?\"}', '{\"en\": null, \"fr\": null}', '{\"en\":null,\"fr\":null}', '{\"en\": null, \"fr\": null}', 0, 1, 36, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(37, 5, 'other_data_source_19_02', 'text', '{\"en\":\"What is the source of the data?\",\"fr\":\"Quelle est la provenance des donn\\u00e9es ?\"}', '{\"en\": null, \"fr\": null}', '{\"en\":null,\"fr\":null}', '{\"en\": null, \"fr\": null}', 0, 1, 37, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(38, 5, 'fully_automated_20', 'radiogroup', '{\"en\":\"Is the treatment fully automated, that is, done entirely without human intervention?\",\"fr\":\"Le traitement est-il enti\\u00e8rement automatis\\u00e9 c\\u2019est-\\u00e0-dire r\\u00e9alis\\u00e9 sans aucune intervention humaine ?\"}', '{\"en\": null, \"fr\": null}', '{\"en\": null, \"fr\": null}', '[\n    {\n        \"value\": 1,\n        \"label\": {\n            \"fr\": \"Oui\",\n            \"en\": \"Yes\"\n        },\n        \"default\": false\n    },\n    {\n        \"value\": 2,\n        \"label\": {\n            \"fr\": \"Non\",\n            \"en\": \"No\"\n        },\n        \"default\": false\n    }\n]', 0, 0, 38, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(39, 5, 'automated_processing_have_impact_20_02', 'radiogroup', '{\"en\":\"Do the results of this automated processing have an impact on employee rights?\",\"fr\":\"Les r\\u00e9sultats de ce traitement automatis\\u00e9 ont-ils des cons\\u00e9quences sur les droits des salari\\u00e9s ?\"}', '{\"en\": null, \"fr\": null}', '{\"en\": null, \"fr\": null}', '[\n    {\n        \"value\": 1,\n        \"label\": {\n            \"fr\": \"Oui\",\n            \"en\": \"Yes\"\n        },\n        \"default\": false\n    },\n    {\n        \"value\": 2,\n        \"label\": {\n            \"fr\": \"Non\",\n            \"en\": \"No\"\n        },\n        \"default\": true\n    },\n    {\n        \"value\": 3,\n        \"label\": {\n            \"fr\": \"Non applicable\",\n            \"en\": \"Not relevant\"\n        },\n        \"default\": false\n    }\n]', 0, 1, 39, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(40, 5, 'automated_processing_have_impact_justification_20_03', 'text', '{\"en\":\"Justify\",\"fr\":\"Justifier\"}', '{\"en\": null, \"fr\": null}', '{\"en\": null, \"fr\": null}', '{\"en\": null, \"fr\": null}', 0, 0, 40, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(41, 5, 'automated_processing_have_impact_justification_yes_20_04', 'text', '{\"fr\":\"Quelles sont ces cons\\u00e9quences ?\",\"en\":\"What are the consequences?\"}', '{\"fr\":null,\"en\":null}', '{\"fr\":null,\"en\":null}', NULL, 0, 0, 41, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(42, 5, 'sensible_1', 'checkboxgroup', '{\"fr\":\"Le traitement a-t-il pour objet de traiter les donn\\u00e9es suivantes :\",\"en\":\"Does the processing applies to the following data:\"}', '{\"fr\":null,\"en\":null}', '{\"fr\":null,\"en\":null}', '[\n    {\n        \"value\": 1,\n        \"label\": {\n            \"fr\": \"Donn\\u00e9es sensibles (Ex : N\\u00b0 s\\u00e9curit\\u00e9 sociale, orientation sexuelle, donn\\u00e9es biom\\u00e9triques ou de sant\\u00e9, etc.)\",\n            \"en\": \"Sensitive data (Ex: social security number, sexual orientation, biometric data, health data, etc.)\"\n        }\n    },\n    {\n        \"value\": 2,\n        \"label\": {\n            \"fr\": \"Donn\\u00e9es relatives \\u00e0 des condamnations p\\u00e9nales et \\u00e0 des infractions ou des mesures de s\\u00fbret\\u00e9 connexes\",\n            \"en\": \"Personal data related to criminal convictions and offences or related security measures\"\n        }\n    },\n    {\n        \"value\": 3,\n        \"label\": {\n            \"fr\": \"Donn\\u00e9es concernant des personnes vuln\\u00e9rables (toute personne pour laquelle un d\\u00e9s\\u00e9quilibre dans la relation avec la soci\\u00e9t\\u00e9 peut \\u00eatre identifi\\u00e9. Ex : employ\\u00e9s, enfants, personnes \\u00e2g\\u00e9es.)\",\n            \"en\": \"Personal data of vulnerable natural persons (every person for whom an imbalance in the relation with the company can be identified. Ex: employees, children, elderly persons)\"\n        }\n    },\n    {\n        \"value\": 4,\n        \"label\": {\n            \"fr\": \"Les donn\\u00e9es trait\\u00e9es ne correspondent \\u00e0 aucune de ces cat\\u00e9gories\",\n            \"en\": \"The processed data does not fit any of the categories listed above\"\n        }\n    }\n]', 0, 0, 42, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(43, 6, 'who_will_access_data_23', 'textarea', '{\"en\":\"Categories of people who will have access to the personal data\",\"fr\":\"Cat\\u00e9gories de personnes qui auront acc\\u00e8s aux donn\\u00e9es personnelles\"}', '{\"en\":null,\"fr\":null}', '{\"en\":null,\"fr\":null}', '{\"en\": null, \"fr\": null}', 0, 1, 43, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(44, 7, 'retention_period_defined_25', 'textarea', '{\"en\":\"Retention period\",\"fr\":\"Dur\\u00e9e de conservation des donn\\u00e9es\"}', '{\"en\":null,\"fr\":null}', '{\"en\": null, \"fr\": null}', '{}', 0, 1, 44, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(45, 7, 'justif_conservation', 'textarea', '{\"fr\":\"Justifier la dur\\u00e9e de conservation\",\"en\":\"Justify the retention period\"}', '{\"fr\":null,\"en\":null}', '{\"fr\":null,\"en\":null}', NULL, 0, 1, 45, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(46, 7, 'data_update_scheduled_26', 'text', '{\"en\":\"Update frequency (if pertinent)\",\"fr\":\"Fr\\u00e9quence de mise \\u00e0 jour (si applicable)\"}', '{\"en\": null, \"fr\": null}', '{\"en\": null, \"fr\": null}', '{}', 0, 0, 46, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(47, 8, 'individual_information_set', 'radiogroup', '{\"fr\":\"Une information des personnes concern\\u00e9es a-t-elle \\u00e9t\\u00e9 mise en place ?\",\"en\":\"Does a legal information have been set?\"}', '{\"fr\":null,\"en\":null}', '{\"fr\":null,\"en\":null}', '[\n    {\n        \"value\": 1,\n        \"label\": {\n            \"fr\": \"Oui\",\n            \"en\": \"Yes\"\n        },\n        \"default\": false\n    },\n    {\n        \"value\": 2,\n        \"label\": {\n            \"fr\": \"Non\",\n            \"en\": \"No\"\n        },\n        \"default\": false\n    }\n]', 0, 0, 47, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(48, 9, 'actual_security_mechanisms_37', 'textarea', '{\"en\":\"What are the physical and IT security mechanisms in place to protect personal data?\",\"fr\":\"Quels sont les m\\u00e9canismes de s\\u00e9curit\\u00e9 (physique\\/logique) mis en place pour prot\\u00e9ger les donn\\u00e9es personnelles ?\"}', '{\"en\":null,\"fr\":null}', '{\"en\":null,\"fr\":null}', '{\"en\": null, \"fr\": null}', 0, 1, 48, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(49, 10, 'outsourced_30', 'radiogroup', '{\"en\":\"Is all or part of the processing outsourced to a provider?\",\"fr\":\"Tout ou partie du traitement est-il sous-trait\\u00e9 \\u00e0 un prestataire ?\"}', '{\"en\": null, \"fr\": null}', '{\"en\": null, \"fr\": null}', '[\n    {\n        \"value\": 1,\n        \"label\": {\n            \"fr\": \"Oui\",\n            \"en\": \"Yes\"\n        },\n        \"default\": false\n    },\n    {\n        \"value\": 2,\n        \"label\": {\n            \"fr\": \"Non\",\n            \"en\": \"No\"\n        },\n        \"default\": false\n    }\n]', 0, 0, 49, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(50, 10, 'names_st', 'list', '{\"fr\":\"Indiquer le nom du prestataire et le type de prestation\",\"en\":\"Indicate the name of the service provider and the servicer\"}', '{\"fr\":\"<p>Ex : h&eacute;bergement des donn&eacute;es : soci&eacute;t&eacute; X, op&eacute;rations de maintenance : soci&eacute;t&eacute; Y...<\\/p>\",\"en\":\"<p>Ex: Data Hosting: Company X, Maintenance Operations: Company Y ...<\\/p>\"}', '{\"fr\":null,\"en\":null}', NULL, 0, 0, 50, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(51, 10, 'following_providers_name_30_04', 'list', '{\"en\":\"Specify the types of services and the name (s)  of the following provider (s)?\",\"fr\":\"Pr\\u00e9cisez le(s) nom(s) et types de prestation(s) de ce(s) prestataire(s) ult\\u00e9rieur(s) ?\"}', '{\"en\": null, \"fr\": null}', '{\"en\": null, \"fr\": null}', '{\"en\": null, \"fr\": null}', 0, 0, 51, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:24:17', '2018-10-02 11:24:17'),
(52, 10, 'contract_contains_cil_clause_31', 'radiogroup', '{\"en\":\"Does the contract with the service provider contain a clause on the protection of personal data validated by the DPO?\",\"fr\":\"Le contrat avec le prestataire contient-il une clause sur la protection des donn\\u00e9es personnelles valid\\u00e9e par le DPO ?\"}', '{\"en\": null, \"fr\": null}', '{\"en\": null, \"fr\": null}', '[\n    {\n        \"value\": 1,\n        \"label\": {\n            \"fr\": \"Oui\",\n            \"en\": \"Yes\"\n        },\n        \"default\": false\n    },\n    {\n        \"value\": 2,\n        \"label\": {\n            \"fr\": \"Non\",\n            \"en\": \"No\"\n        },\n        \"default\": false\n    },\n    {\n        \"value\": 3,\n        \"label\": {\n            \"fr\": \"Non applicable\",\n            \"en\": \"Not applicable\"\n        },\n        \"default\": false\n    }\n]', 0, 0, 52, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(53, 10, 'contract_comment', 'textarea', '{\"fr\":\"Pr\\u00e9ciser pour chaque contrat\",\"en\":\"Please detail for each contract\"}', '{\"fr\":null,\"en\":null}', '{\"fr\":null,\"en\":null}', NULL, 0, 0, 53, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(54, 11, 'transfer_or_not', 'radiogroup', '{\"fr\":\"Certaines donn\\u00e9es sont-elles transf\\u00e9r\\u00e9es hors Union europ\\u00e9enne ?\",\"en\":\"Are the data transferred to a country outside the European Union?\"}', '{\"fr\":null,\"en\":null}', '{\"fr\":null,\"en\":null}', '[\n    {\n        \"value\": 1,\n        \"label\": {\n            \"fr\": \"Oui\",\n            \"en\": \"Yes\"\n        },\n        \"default\": false\n    },\n    {\n        \"value\": 2,\n        \"label\": {\n            \"fr\": \"Non\",\n            \"en\": \"No\"\n        },\n        \"default\": false\n    }\n]', 0, 1, 54, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(55, 11, 'objet_transfert_n1', 'textarea', '{\"fr\":\"Quel est l\'objet du transfert ?\",\"en\":\"What is the object of the transfer ?\"}', '{\"fr\":null,\"en\":null}', '{\"fr\":null,\"en\":null}', NULL, 0, 0, 55, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(56, 11, 'purpose_of_transfert_n1', 'textarea', '{\"en\":\"Purpose of the transfer\",\"fr\":\"Finalit\\u00e9 du transfert\"}', '{\"en\": null, \"fr\": null}', '{\"en\": null, \"fr\": null}', '{\"en\": null, \"fr\": null}', 0, 0, 56, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:23:36', NULL),
(57, 11, 'recipients_n1', 'textarea', '{\"en\": \"Identity of the recipient (s)\", \"fr\": \"Identité du (des) destinataire(s)\"}', '{\"en\": null, \"fr\": null}', '{\"en\": null, \"fr\": null}', '{\"en\": null, \"fr\": null}', 0, 0, 57, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(58, 11, 'recipient_country_n1', 'text', '{\"en\": \"Country of establishment of the recipient\", \"fr\": \"Pays d’établissement du destinataire\"}', '{\"en\": null, \"fr\": null}', '{\"en\": null, \"fr\": null}', '{\"en\": null, \"fr\": null}', 0, 0, 58, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(59, 11, 'processing_nature_n1', 'textarea', '{\"en\":\"Nature of the processing operated by the addressee\",\"fr\":\"Nature des traitements op\\u00e9r\\u00e9s chez le destinataire\"}', '{\"en\": null, \"fr\": null}', '{\"en\": null, \"fr\": null}', '{\"en\": null, \"fr\": null}', 0, 0, 59, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(60, 11, 'person_affected_n1', 'textarea', '{\"en\": \"People affected by the transfer\", \"fr\": \"Personnes concernées par le transfert\"}', '{\"en\": null, \"fr\": null}', '{\"en\": null, \"fr\": null}', '{\"en\": null, \"fr\": null}', 0, 0, 60, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(61, 11, 'transferred_data_n1', 'textarea', '{\"en\": \"Transferred data\", \"fr\": \"Données transférées\"}', '{\"en\": null, \"fr\": null}', '{\"en\": null, \"fr\": null}', '{\"en\": null, \"fr\": null}', 0, 0, 61, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(62, 11, 'retention_period_n1', 'text', '{\"en\": \"Retention period of the data at the addressee\", \"fr\": \"Durée de conservation des données chez le destinataire\"}', '{\"en\": null, \"fr\": null}', '{\"en\": null, \"fr\": null}', '{\"en\": null, \"fr\": null}', 0, 0, 62, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(63, 11, 'recipient_data_guarantees_n1', 'textarea', '{\"en\": \"What are the guarantees implemented by the recipient of the data?\", \"fr\": \"Quelles sont les garanties mises en oeuvre par le destinataire des données ?\"}', '{\"en\":null,\"fr\":null}', '{\"en\": null, \"fr\": null}', '{\"en\": null, \"fr\": null}', 0, 0, 63, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(64, 11, 'modal_info_n1', 'textarea', '{\"en\":\"How are the concerned people informed about the transfer?\",\"fr\":\"Modalit\\u00e9s d\\u2019information des personnes concern\\u00e9es concernant le transfert de donn\\u00e9es\"}', '{\"en\": null, \"fr\": null}', '{\"en\":null,\"fr\":null}', '{\"en\": null, \"fr\": null}', 0, 0, 64, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `form_elements_rules`
--

CREATE TABLE `form_elements_rules` (
  `element_id` int(10) UNSIGNED NOT NULL,
  `if_element_id` int(10) UNSIGNED NOT NULL,
  `if_element_value` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `form_elements_rules`
--

INSERT INTO `form_elements_rules` (`element_id`, `if_element_id`, `if_element_value`) VALUES
(6, 5, 2),
(7, 5, 1),
(13, 12, 1),
(14, 12, 2),
(15, 12, 3),
(16, 12, 6),
(19, 18, 1),
(20, 18, 1),
(21, 18, 1),
(23, 22, 1),
(24, 22, 1),
(25, 22, 1),
(27, 26, 1),
(28, 26, 1),
(29, 26, 1),
(31, 30, 1),
(32, 30, 1),
(33, 30, 1),
(35, 34, 1),
(36, 34, 1),
(37, 34, 1),
(39, 38, 1),
(40, 39, 3),
(41, 39, 1),
(50, 49, 1),
(52, 49, 1),
(53, 52, 1),
(55, 54, 1),
(56, 54, 1),
(57, 54, 1),
(58, 54, 1),
(59, 54, 1),
(60, 54, 1),
(61, 54, 1),
(62, 54, 1),
(63, 54, 1),
(64, 54, 1);

-- --------------------------------------------------------

--
-- Structure de la table `form_pages`
--

CREATE TABLE `form_pages` (
  `id` int(10) UNSIGNED NOT NULL,
  `form_id` int(10) UNSIGNED NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `disclaimer` text COLLATE utf8mb4_unicode_ci,
  `ordering` int(10) UNSIGNED NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `modified_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `form_pages`
--

INSERT INTO `form_pages` (`id`, `form_id`, `title`, `disclaimer`, `ordering`, `created_by`, `modified_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '{\"en\": \"Overview\", \"fr\": \"Généralités\"}', '{\"en\": null, \"fr\": null}', 1, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(2, 1, '{\"en\":\"Purpose of the Processing\",\"fr\":\"Finalit\\u00e9 du traitement\"}', '{\"en\":null,\"fr\":null}', 2, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(3, 1, '{\"fr\":\"Base juridique du traitement\",\"en\":\"Legal basis of the processing\"}', '{\"fr\":null,\"en\":null}', 3, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(4, 1, '{\"fr\":\"Cat\\u00e9gories de personnes concern\\u00e9es\",\"en\":\"Categories of concerned persons\"}', '{\"fr\":null,\"en\":null}', 4, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(5, 1, '{\"en\":\"Categories of processed personal data\",\"fr\":\"Cat\\u00e9gories des donn\\u00e9es personnelles trait\\u00e9es\"}', '{\"en\":null,\"fr\":null}', 5, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(6, 1, '{\"en\":\"Recipients\",\"fr\":\"Destinataires\"}', '{\"en\": null, \"fr\": null}', 6, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(7, 1, '{\"en\": \"Retention and archiving of data\", \"fr\": \"Durée de conservation et d’archivage des données\"}', '{\"en\":null,\"fr\":null}', 7, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(8, 1, '{\"en\":\"Individual information\",\"fr\":\"Information individuelle\"}', '{\"en\":null,\"fr\":null}', 8, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(9, 1, '{\"en\": \"Security\", \"fr\": \"Sécurité\"}', '{\"en\": null, \"fr\": null}', 9, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(10, 1, '{\"en\":\"Subcontracting\",\"fr\":\"Sous-traitance\"}', '{\"en\": null, \"fr\": null}', 10, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL),
(11, 1, '{\"en\":\"Transfer of personal data outside the EU\",\"fr\":\"Transfert de donn\\u00e9es personnelles hors UE\"}', '{\"en\":null,\"fr\":null}', 11, 1, 1, '2018-10-02 11:18:18', '2018-10-02 11:18:18', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `job_statuses`
--

CREATE TABLE `job_statuses` (
  `id` int(10) UNSIGNED NOT NULL,
  `job_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attempts` int(11) NOT NULL DEFAULT '0',
  `progress_now` int(11) NOT NULL DEFAULT '0',
  `progress_max` int(11) NOT NULL DEFAULT '0',
  `status` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'queued',
  `input` longtext COLLATE utf8mb4_unicode_ci,
  `output` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `started_at` timestamp NULL DEFAULT NULL,
  `finished_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `language_lines`
--

CREATE TABLE `language_lines` (
  `id` int(10) UNSIGNED NOT NULL,
  `group` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `menus`
--

CREATE TABLE `menus` (
  `id` int(10) UNSIGNED NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `modified_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `menus`
--

INSERT INTO `menus` (`id`, `slug`, `title`, `created_by`, `modified_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'footer', '{\"en\": \"Footer\", \"fr\": \"Pieds de page\"}', 1, 1, '2018-03-24 13:13:54', '2018-03-24 15:50:23', NULL),
(2, 'main-menu', '{\"en\": \"Main menu\", \"fr\": \"Menu principal\"}', 1, 1, '2018-03-24 17:14:13', '2018-04-27 16:32:32', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `menu_id` int(10) UNSIGNED NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `ordering` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('employee','lawyer','admin') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `modified_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `menu_items`
--

INSERT INTO `menu_items` (`id`, `menu_id`, `title`, `active`, `ordering`, `path`, `role`, `created_by`, `modified_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '{\"en\": \"Legal mention\", \"fr\": \"Mentions légales\"}', 1, 1, 'mentions-legales', 'employee', 1, 1, '2018-03-24 14:45:18', '2018-03-24 15:38:03', NULL),
(2, 1, '{\"en\": \"Contact\", \"fr\": \"Contact\"}', 1, 2, 'contact', 'employee', 1, NULL, '2018-03-24 15:34:37', '2018-03-24 15:38:03', NULL),
(3, 2, '{\"en\":\"New analysis\",\"fr\":\"Nouvelle analyse\"}', 1, 3, 'statements/create', 'employee', 1, 1, '2018-03-24 17:21:58', '2018-07-11 09:23:27', NULL),
(4, 2, '{\"en\": \"In progress\", \"fr\": \"En cours\"}', 1, 3, 'statements/in-progress', 'employee', 1, NULL, '2018-03-25 07:07:07', '2018-03-25 07:07:07', NULL),
(5, 2, '{\"en\": \"Finished\", \"fr\": \"Terminées\"}', 1, 4, 'statements/finished', 'employee', 1, 1, '2018-03-25 07:07:36', '2018-03-29 17:30:56', NULL),
(6, 2, '{\"en\": \"Administration\", \"fr\": \"Administration\"}', 1, 5, 'admin', 'admin', 1, NULL, '2018-03-26 05:13:25', '2018-03-26 05:13:25', NULL),
(7, 1, '{\"en\": \"© 2018 Company\", \"fr\": \"© 2018 Company\"}', 1, 6, '#', 'employee', 1, NULL, '2018-03-31 13:52:31', '2018-03-31 13:52:31', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `key` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('BOOLEAN','NUMBER','DATE','TEXT','SELECT','FILE','TEXTAREA') COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `value` longtext COLLATE utf8mb4_unicode_ci,
  `group` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'main',
  `ordering` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `settings`
--

INSERT INTO `settings` (`id`, `key`, `type`, `label`, `active`, `value`, `group`, `ordering`, `created_at`, `updated_at`) VALUES
(1, 'home_picture_desktop', 'FILE', '{\"en\": \"Home page picture ( Desktop )\", \"fr\": \"Photo page d\'accueil ( Version bureau )\"}', 1, 'http://localhost:8888/elfinder/connector?_token=uEbgHZMj9AjKKiaPAEr8DfmHMTMpCESxX9fmoyzE&cmd=file&target=fls2_aG9tZXBhZ2Uuc3Zn', 'main', 1, '2018-04-02 22:00:00', '2018-09-26 11:21:21'),
(2, 'home_picture_pad', 'FILE', '{\"en\": \"Home page picture ( Pad )\", \"fr\": \"Photo page d\'accueil ( Version tablette )\"}', 1, 'http://localhost:8888/elfinder/connector?_token=uEbgHZMj9AjKKiaPAEr8DfmHMTMpCESxX9fmoyzE&cmd=file&target=fls2_dGFibGV0LnN2Zw', 'main', 2, '2018-04-02 22:00:00', '2018-09-26 11:21:39');

-- --------------------------------------------------------

--
-- Structure de la table `statements`
--

CREATE TABLE `statements` (
  `id` int(10) UNSIGNED NOT NULL,
  `form_id` int(10) UNSIGNED NOT NULL,
  `supervisor_id` int(10) UNSIGNED DEFAULT NULL,
  `owner_id` int(10) UNSIGNED DEFAULT NULL,
  `validated` tinyint(1) NOT NULL DEFAULT '0',
  `archived` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `modified_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `statement_templates`
--

CREATE TABLE `statement_templates` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `modified_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `statement_template_answers`
--

CREATE TABLE `statement_template_answers` (
  `id` int(10) UNSIGNED NOT NULL,
  `statement_template_id` int(10) UNSIGNED NOT NULL,
  `form_element_id` int(10) UNSIGNED NOT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `staticpages`
--

CREATE TABLE `staticpages` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `modified_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `staticpages`
--

INSERT INTO `staticpages` (`id`, `created_at`, `updated_at`, `slug`, `title`, `body`, `created_by`, `modified_by`, `deleted_at`) VALUES
(1, '2018-03-22 18:50:40', '2018-10-02 12:33:36', 'contact', '{\"fr\":\"Contact\",\"en\":\"Contact\"}', '{\"fr\":\"<p>Contacts<\\/p>\",\"en\":\"<p>Contacts<\\/p>\"}', 1, NULL, NULL),
(2, '2018-03-22 19:02:56', '2018-10-02 12:33:25', 'mentions-legales', '{\"fr\":\"Mentions l\\u00e9gales\",\"en\":\"Legal Notice\"}', '{\"fr\":\"<p>Mentions<\\/p>\",\"en\":\"<p>Mentions<\\/p>\"}', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `sid` char(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'id saml2',
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `last_connexion` datetime DEFAULT NULL,
  `role` enum('employee','lawyer','admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'employee',
  `type` enum('local','ldap','ldap_pending') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'local',
  `company_id` int(10) UNSIGNED NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `sid`, `username`, `first_name`, `last_name`, `email`, `password`, `active`, `last_connexion`, `role`, `type`, `company_id`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, 'admin', 'Admin', 'DPO', 'adminusername@changethisemail.changethisdomain', '$2y$10$7Z6B8qROrkdG.ya3S4oYlOUpYecMIv2ajc2w1e7FQ0CwPLKVdYMD.', 1, '2018-10-02 11:07:01', 'admin', 'local', 1, '', '2018-03-18 15:49:00', '2018-10-02 09:07:01', NULL), 
(2, NULL, 'dpo', 'DPO', 'DPO', 'dpousername@changethisemail.changethisdomain', '$2y$10$u/EKyqTuCmDPpp.25f0oXeE136N71k9lqnrkzX75w4Dr3jA.cPIZ6', 1, '2018-10-02 11:07:01', 'lawyer', 'local', 1, '', '2018-03-18 15:49:00', '2018-10-02 09:07:01', NULL), 
(3, NULL, 'employee', 'Employee', 'Employee', 'employeeusername@changethisemail.changethisdomain', '$2y$10$GrA3ZXQhNkcNbhqi09rzcOtPvwAhibSAnBklh8xoI5RWyq2UGkrZm', 1, '2018-10-02 11:07:01', 'employee', 'local', 1, '', '2018-03-18 15:49:00', '2018-10-02 09:07:01', NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `statement_id` (`statement_id`,`form_element_id`),
  ADD KEY `answers_statement_id_foreign` (`statement_id`),
  ADD KEY `answers_created_by_foreign` (`created_by`),
  ADD KEY `answers_form_element_id_foreign` (`form_element_id`);

--
-- Index pour la table `attachments`
--
ALTER TABLE `attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attachments_uuid_index` (`uuid`),
  ADD KEY `attachments_model_id_index` (`model_id`),
  ADD KEY `attachments_created_by_foreign` (`created_by`);

--
-- Index pour la table `cache`
--
ALTER TABLE `cache`
  ADD UNIQUE KEY `cache_key_unique` (`key`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_answer_id_foreign` (`answer_id`),
  ADD KEY `comments_created_by_foreign` (`created_by`);

--
-- Index pour la table `comment_templates`
--
ALTER TABLE `comment_templates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comment_templates_created_by_foreign` (`created_by`),
  ADD KEY `comment_templates_modified_by_foreign` (`modified_by`),
  ADD KEY `comment_templates_form_element_id_foreign` (`form_element_id`);

--
-- Index pour la table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `companies_name_unique` (`name`);

--
-- Index pour la table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `disclaimerstatuses`
--
ALTER TABLE `disclaimerstatuses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `desclaimerstatuses_user_id_foreign` (`user_id`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `forms_created_by_foreign` (`created_by`),
  ADD KEY `forms_modified_by_foreign` (`modified_by`),
  ADD KEY `forms_published_by_foreign` (`published_by`);

--
-- Index pour la table `form_elements`
--
ALTER TABLE `form_elements`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `form_elements_page_id_name_unique` (`page_id`,`name`),
  ADD KEY `form_elements_created_by_foreign` (`created_by`),
  ADD KEY `form_elements_modified_by_foreign` (`modified_by`);

--
-- Index pour la table `form_elements_rules`
--
ALTER TABLE `form_elements_rules`
  ADD PRIMARY KEY (`element_id`,`if_element_id`,`if_element_value`),
  ADD KEY `form_elements_rules_element_id_index` (`element_id`),
  ADD KEY `form_elements_rules_if_element_id_index` (`if_element_id`);

--
-- Index pour la table `form_pages`
--
ALTER TABLE `form_pages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `form_pages_form_id_foreign` (`form_id`),
  ADD KEY `form_pages_created_by_foreign` (`created_by`),
  ADD KEY `form_pages_modified_by_foreign` (`modified_by`);

--
-- Index pour la table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Index pour la table `job_statuses`
--
ALTER TABLE `job_statuses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_statuses_job_id_index` (`job_id`),
  ADD KEY `job_statuses_type_index` (`type`),
  ADD KEY `job_statuses_queue_index` (`queue`),
  ADD KEY `job_statuses_status_index` (`status`);

--
-- Index pour la table `language_lines`
--
ALTER TABLE `language_lines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `language_lines_group_index` (`group`);

--
-- Index pour la table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menus_created_by_foreign` (`created_by`),
  ADD KEY `menus_modified_by_foreign` (`modified_by`);

--
-- Index pour la table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_items_menu_id_foreign` (`menu_id`),
  ADD KEY `menu_items_created_by_foreign` (`created_by`),
  ADD KEY `menu_items_modified_by_foreign` (`modified_by`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Index pour la table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`),
  ADD KEY `settings_group_index` (`group`);

--
-- Index pour la table `statements`
--
ALTER TABLE `statements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `statements_form_id_foreign` (`form_id`),
  ADD KEY `statements_supervisor_id_foreign` (`supervisor_id`),
  ADD KEY `statements_owner_id_foreign` (`owner_id`),
  ADD KEY `statements_created_by_foreign` (`created_by`),
  ADD KEY `statements_modified_by_foreign` (`modified_by`);

--
-- Index pour la table `statement_templates`
--
ALTER TABLE `statement_templates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `statement_templates_created_by_foreign` (`created_by`),
  ADD KEY `statement_templates_modified_by_foreign` (`modified_by`);

--
-- Index pour la table `statement_template_answers`
--
ALTER TABLE `statement_template_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `statement_template_answers_statement_template_id_foreign` (`statement_template_id`),
  ADD KEY `statement_template_answers_form_element_id_foreign` (`form_element_id`);

--
-- Index pour la table `staticpages`
--
ALTER TABLE `staticpages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `staticpages_slug_unique` (`slug`),
  ADD KEY `staticpages_created_by_foreign` (`created_by`),
  ADD KEY `staticpages_modified_by_foreign` (`modified_by`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `sid_unique` (`sid`) USING BTREE,
  ADD KEY `users_company_id_foreign` (`company_id`),
  ADD KEY `uuid_2` (`sid`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `attachments`
--
ALTER TABLE `attachments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `comment_templates`
--
ALTER TABLE `comment_templates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `disclaimerstatuses`
--
ALTER TABLE `disclaimerstatuses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `forms`
--
ALTER TABLE `forms`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `form_elements`
--
ALTER TABLE `form_elements`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `form_pages`
--
ALTER TABLE `form_pages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `job_statuses`
--
ALTER TABLE `job_statuses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `language_lines`
--
ALTER TABLE `language_lines`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `statements`
--
ALTER TABLE `statements`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `statement_templates`
--
ALTER TABLE `statement_templates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `statement_template_answers`
--
ALTER TABLE `statement_template_answers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `staticpages`
--
ALTER TABLE `staticpages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `answers_form_element_id_foreign` FOREIGN KEY (`form_element_id`) REFERENCES `form_elements` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `answers_statement_id_foreign` FOREIGN KEY (`statement_id`) REFERENCES `statements` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `attachments`
--
ALTER TABLE `attachments`
  ADD CONSTRAINT `attachments_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_answer_id_foreign` FOREIGN KEY (`answer_id`) REFERENCES `answers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `comment_templates`
--
ALTER TABLE `comment_templates`
  ADD CONSTRAINT `comment_templates_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comment_templates_form_element_id_foreign` FOREIGN KEY (`form_element_id`) REFERENCES `form_elements` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comment_templates_modified_by_foreign` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `disclaimerstatuses`
--
ALTER TABLE `disclaimerstatuses`
  ADD CONSTRAINT `desclaimerstatuses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `forms`
--
ALTER TABLE `forms`
  ADD CONSTRAINT `forms_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `forms_modified_by_foreign` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `forms_published_by_foreign` FOREIGN KEY (`published_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `form_elements`
--
ALTER TABLE `form_elements`
  ADD CONSTRAINT `form_elements_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `form_elements_modified_by_foreign` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `form_elements_page_id_foreign` FOREIGN KEY (`page_id`) REFERENCES `form_pages` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `form_elements_rules`
--
ALTER TABLE `form_elements_rules`
  ADD CONSTRAINT `form_elements_rules_element_id_foreign` FOREIGN KEY (`element_id`) REFERENCES `form_elements` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `form_elements_rules_if_element_id_foreign` FOREIGN KEY (`if_element_id`) REFERENCES `form_elements` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `form_pages`
--
ALTER TABLE `form_pages`
  ADD CONSTRAINT `form_pages_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `form_pages_form_id_foreign` FOREIGN KEY (`form_id`) REFERENCES `forms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `form_pages_modified_by_foreign` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `menus_modified_by_foreign` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `menu_items`
--
ALTER TABLE `menu_items`
  ADD CONSTRAINT `menu_items_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `menu_items_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `menu_items_modified_by_foreign` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `statements`
--
ALTER TABLE `statements`
  ADD CONSTRAINT `statements_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `statements_form_id_foreign` FOREIGN KEY (`form_id`) REFERENCES `forms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `statements_modified_by_foreign` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `statements_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `statements_supervisor_id_foreign` FOREIGN KEY (`supervisor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `statement_templates`
--
ALTER TABLE `statement_templates`
  ADD CONSTRAINT `statement_templates_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `statement_templates_modified_by_foreign` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `statement_template_answers`
--
ALTER TABLE `statement_template_answers`
  ADD CONSTRAINT `statement_template_answers_form_element_id_foreign` FOREIGN KEY (`form_element_id`) REFERENCES `form_elements` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `statement_template_answers_statement_template_id_foreign` FOREIGN KEY (`statement_template_id`) REFERENCES `statement_templates` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `staticpages`
--
ALTER TABLE `staticpages`
  ADD CONSTRAINT `staticpages_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `staticpages_modified_by_foreign` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;
