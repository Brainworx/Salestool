--
-- Tabelstructuur voor tabel `location`
--

CREATE TABLE IF NOT EXISTS `location` (
	`id` int NOT NULL,
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `apbnumber` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lattitude` decimal(11,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `address` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `zipcode` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'BE',
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` int NOT NULL DEFAULT '1',
  `create_dt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_dt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `location`
--
ALTER TABLE `location`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `location`
--
ALTER TABLE `location`
MODIFY `id` int NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Tabelstructuur voor tabel `Exclusivety`
--

CREATE TABLE IF NOT EXISTS `exclusivety` (
`id` int NOT NULL,
  `location_id` int NOT NULL,
  `blocked_location_id` int NOT NULL,
  `rule_active` tinyint(4) NOT NULL DEFAULT '1',
  `create_dt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_dt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `Exclusivety`
--
ALTER TABLE `exclusivety`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `Exclusivety`
--
ALTER TABLE `exclusivety`
MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Tabelstructuur voor tabel `User`
--

CREATE TABLE IF NOT EXISTS `user` (
`id` int NOT NULL,
  `username` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `update_dt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `User`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `User`
--
ALTER TABLE `user`
MODIFY `id` int NOT NULL AUTO_INCREMENT;
