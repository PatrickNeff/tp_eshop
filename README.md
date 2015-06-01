========== Projet eshop ==========

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
