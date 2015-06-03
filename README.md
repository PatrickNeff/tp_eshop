========== Projet eshop ==========

Mettre ici les MAJ critique (base de données...)


rappel : - les pages existantes sont listées dans la variable àpage de index.php de la racine de notre site
           si on ajoute des nouvelles pages, il faudras donc rajouter le nom de la nouvelle page à ce niveau.
         - si le nom de votre base de données n'est pas "eshop", penser à remodifier cette valeur dans le même fichier            au niveau de votre config pour que cela corresponde au nom de votre base
         


03/05 Patrick

ajout de colonnes dans la table note : 
// pensez à changer le nom du dossier notes en note pour être cohérent avec la base

ALTER TABLE `note` ADD `time_create` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'timestamp de mise à jour de l''avis' AFTER `comment` ;
ALTER TABLE `note` CHANGE `time_create` `time_create` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'timestamp de mise à jour de l''avis'; 

03/05 Fred

Pour ajouter une colonne type d'adresse à la table adresse :

ALTER TABLE `adresse` ADD `type_adresse` VARCHAR( 40 ) NOT NULL AFTER `client_id` ;







29/05:

Mise en place de la DB

Fonctionnalités du site pour préparer structure MVC

Pour info, il ay a plusieurs fichiers sql que j'ai rajouté

le fichier eshop.sql  a été remplacé par le fichier eshop_maj1.sql.

ce dernier contient à la fois les insert des différentes tables (category, sub_category, prodcut, permissions... dont on retrouve les fichiers sql) ainsi que quelques modifications mineures comme par exemple la gestion des chiffres après la virgule dans les champs de type décimal.

si on veux partir sur une base propre, le plus simple est de supprimer les tables crées au début avec eshop.sql et de lancer le eshop_maj_sql1 pour avoir toutes les tables à jour ainsi que les données contenues

si jamais il y auras une autre modification de base de données, j'enregistrerais la requête (alter...) de façon à n'avoir plus qu'à éxécuter cette dernière requête.

si pas clair (ou si suggestions...), suis à coté :-)

patrick
