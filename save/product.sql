
--
-- Contenu de la table `product`
--

INSERT INTO `product` (`id_product`, `name`, `description`, `sub_category_id`, `price`, `image`, `origine`, `stock_quantity`, `note_id`, `supplier_id`) VALUES
(1, 'reines des reinettes', 'une des variétés préférées des amateurs de pommes', 1, 2.00, 'images/pomme-reine-des-reinettes.jpg', 'sud de la France', 200, 0, 0),
(2, 'granny smith', 'pomme avec un goût assez acidulé, très fermes, croquantes, juteuses, excellentes à cuire ou à croquer', 1, 2.00, 'images/pomme-granny-smith.jpg', 'sud de la France', 150, 0, 0),
(4, 'golden', 'pomme la plus cultivée puisqu''elle représente plus d''un tiers de la production nationale', 1, 1.80, 'images/pomme-golden.jpg', 'france', 180, 0, 0),
(5, 'boskoop', 'pomme à chair est ferme, finement acidulée et légèrement jaune et sucrée', 1, 1.00, 'images/pomme-boskoop.jpg', 'sais pas', 250, 0, 0),
(6, 'jonagold', 'pomme à à peau moyennement fine, grosse et parfumée', 1, 1.00, 'images/pomme-jonagold.jpg', 'allemagne', 240, 0, 0),
(7, 'antares', 'pomme d’aspect rustique obtenue dans les années 1990', 1, 2.00, 'images/pomme-antares.jpg', 'france', 10, 0, 0),
(8, 'conference', 'poire à couteau allongée en forme de bouteille, de taille moyenne.', 2, 2.20, 'images/poire-conference.jpg', 'portugal', 50, 0, 0),
(9, 'rochas', 'poire portugaise découverte en 1836', 2, 2.20, 'images/poire-rochas.jpg', 'portugal', 5, 0, 0),
(10, 'williams', 'poire assez grosse, juteuse, sucrée avec une pointe d’acidité. Sa chair blanche non granuleuse est très aromatique.', 2, 1.80, 'images/poire-williams.jpg', 'france', 0, 0, 0),
(11, 'clementine', 'ne clémentine se divise généralement en une dizaine de quartiers. Un quartier est parfois appelé une cuisse, un grain ou un taillon', 3, 1.60, 'images/clementine.jpg', 'maroc', 50, 0, 0),
(12, 'clemenvilla', 'mandarine sans pépin', 3, 1.80, 'images/clemenvilla.jpg', 'maroc', 100, 0, 0),
(13, 'minneola', 'fruit orangé, au zeste brillant et granuleux, juteux, la pulpe est d''une couleur oranger saturée', 3, 1.50, 'images/minneola.jpg', 'france', 50, 0, 0),
(14, 'orange', 'fruit de couleur orange qui possède une peau épaisse et assez rugueuse', 3, 1.80, 'images/orange.jpg', 'maroc', 20, 0, 0),
(15, 'fraises', 'faux fruit : réceptacle charnu sur lequel sont disposés régulièrement des akènes dans des alvéoles plus ou moins profondes, la fraise étant donc un polyakène.', 4, 5.00, 'images/fraise.jpg', 'sud de la france', 20, 0, 0),
(16, 'framboises', 'fruit issu de la transformation de la quarantaine de minuscules carpelles d''une seule et même fleur, qui se transforment en drupéoles semi-soudées', 4, 4.00, 'images/framboises.jpg', 'sud de la france', 20, 0, 0),
(17, 'epinards', 'demande à popeye!', 5, 1.60, 'images/epinard.jpg', 'alsace', 20, 0, 0),
(18, 'petits-pois', 'des trucs verts tout petits', 5, 2.00, 'images/petits-pois.jpg', 'alsace', 20, 0, 0),
(19, 'haricots verts', 'Les haricots verts cultivés sont des variétés de Phaseolus vulgaris, le haricot commun.', 5, 2.00, 'images/haricots-verts.jpg', 'alsace', 5, 0, 0),
(20, 'choux fleurs', 'Les variétés de choux-fleur fleurissent toute l''année. On parle donc de chou-fleur de printemps, d''été, d''automne et d''hiver.', 6, 1.50, 'images/choufleur.jpg', 'france', 5, 0, 0),
(21, 'brocoli', 'Choux d''Italie défini aussi comme "le petit rejeton que le tronc d''un vieux chou pousse après l''hiver". ', 6, 1.20, 'images/brocoli.jpg', 'france', 5, 0, 0),
(22, 'mangue', 'Délicieusement parfumée, juteuse et tendre, la mangue est un fruit charnu.', 7, 1.50, 'images/mangue.jpg', 'îles paradisiaques', 5, 0, 0),
(23, 'kiwi', 'fruits de plusieurs espèces de lianes du genre Actinidia, famille des Actinidiaceae', 8, 6.00, 'images/kiwi.jpg', 'îles paradisiaques', 10, 0, 0),
(24, 'ananas', 'tu connais pas?', 8, 3.00, 'images/ananas', 'îles paradisiaques', 20, 0, 0),
(25, 'noisettes', 'coquille akène doté d’un péricarpe ligneux appelé involucre ou quelquefois, par erreur, écale et renfermant une seule2 graine (l''amande) qui occupe normalement3 toute la cavité interne du péricarpe', 9, 5.00, 'images/noisettes.jpg', 'mon jardin :-)', 25, 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
