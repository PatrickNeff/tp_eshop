--
-- Contenu de la table `sub_category`
--

INSERT INTO `sub_category` (`id_sub_category`, `name`, `description`, `category_id`, `time_update`) VALUES
(1, 'pommes', 'ben des pommes pardi!', 1, '0000-00-00 00:00:00'),
(2, 'poires', 'ben des poires pardi', 1, '0000-00-00 00:00:00'),
(3, 'agrumes', 'un truc bien juteux qui t''en laisse plein les doigts', 1, '0000-00-00 00:00:00'),
(4, 'fruits rouges', 'du gros rouge qui tache', 1, '0000-00-00 00:00:00'),
(5, 'legumes verts', 'interdit aux daltoniens', 2, '0000-00-00 00:00:00'),
(6, 'fleurs', 'certaines fleurs se mangent, eh oui!', 2, '2015-05-29 12:45:00'),
(7, 'avec noyaux', 'au milieu il y a un truc qui s’appelle noyau', 5, '0000-00-00 00:00:00'),
(8, 'sans noyaux', 'si tu recherche un noyaux, court toujours', 5, '0000-00-00 00:00:00'),
(9, 'noix', 'des noix, des noisettes, des amandes...', 6, '0000-00-00 00:00:00'),
(10, 'autres', 'tout sauf les noix et descendant', 6, '0000-00-00 00:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
