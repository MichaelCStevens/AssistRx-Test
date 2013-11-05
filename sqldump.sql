
--
-- Database: `assistrx`
--

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_time_stamp` datetime NOT NULL,
  `session_ip` varchar(245) NOT NULL,
  `session_user` int(11) NOT NULL,
  `session_id` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=150 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Test User',
  `hint` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `session_id` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `name`, `hint`, `session_id`) VALUES
(1, 'test1', '5a105e8b9d40e1329780d62ea2265d8a', 'test1@foo.com', 'Test User', 'testhint1', 0),
(2, 'test2', 'ad0234829205b9033196ba818f7a872b', 'test2@foo.com', 'Test User', 'testhint2', 0),
(3, 'test3', '8ad8757baa8564dc136c1e07507f4a98', 'test3@foo.com', 'Test User', 'testhint3', 0),
(4, 'test4', '86985e105f79b95d6bc918fb45ec7727', 'test4@foo.com', 'Test User', 'testhint4', 0),
(5, 'test5', 'e3d704f3542b44a621ebed70dc0efe13', 'test5@foo.com', 'Test User', 'testhint5', 0),
(13, 'test', '098f6bcd4621d373cade4e832627b4f6', 'test2', 'test', '', 0),
(11, 'test123', '098f6bcd4621d373cade4e832627b4f6', 'test', 'test', '', 0);
