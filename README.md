========== Projet eshop ==========

Mettre ici les MAJ critique (base de données...)


rappel : - les pages existantes sont listées dans la variable àpage de index.php de la racine de notre site
           si on ajoute des nouvelles pages, il faudras donc rajouter le nom de la nouvelle page à ce niveau.
         - si le nom de votre base de données n'est pas "eshop", penser à remodifier cette valeur dans le même fichier            au niveau de votre config pour que cela corresponde au nom de votre base
         

09/06 mon lien vers ma page 			<p><a href="index.php?page=validation_panier&id_order=<?=$selectcv9['monpanier1a_orderid']?>">
					<button type="button" class="btn btn-primary" width="200px">valider le panier</button></a>
			</p>
			
faut juste changer la variable $selectcv9['monpanier1a_orderid'] par ce que tu as .			

08/06 15h30 Patrick mise à jour de la table orders

           3 champs sont à rajouter dans la table orders afin d'avoir tout ce qu'il nous faut
           - l'identifiant de l'adresse qui auras été choisis par le client pour sa livraison
           - les frais de port (5 euros en dessous de 50 euros, gratuit au delà)
           - le coup total après frais de port
           
           si vous voyez autre chose, je suis preneur.
           En attendant, vous pouvez executer la commande suivante pour créer ces champs :
           
ALTER TABLE  `orders` ADD  `shipping_fees` DECIMAL( 8, 2 ) NOT NULL COMMENT  'frais de port' AFTER  `order_rate` ;
ALTER TABLE  `orders` ADD  `TTC_price_with_fees` DECIMAL( 8, 2 ) NOT NULL COMMENT  'prix avec frais de port' AFTER  `TTC_price` ;
ALTER TABLE  `orders` ADD  `adresse_id` INT( 11 ) NOT NULL COMMENT  'identifiant de l''adresse du client' AFTER  `client_id` ;


05/06 patrick. table order

comme j'ai bien refaire les mêmes conneries, j'ai appelé la table commande "order" qui est un mot clé (un peu comme group quoi)
il faut modifier cela!
procédure à suivre:
1) exporter la table order
2) ouvrir le sql et changer le nom de la table en orders (et pas des champs, même si commance par order...). Bien vérifier pour le modifier partout ou nécessaire
3) retourner dans la base eshop, copier le fichier dans sql et executer
On auras donc une table order et une table orders qui seras utilisée. Si vous savez coment virer la table order, je suis preneur :-)

>> Le DROP fonctionne bien.  table/opérations/supprimer la table (DROP) -> écrit en rouge.


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
