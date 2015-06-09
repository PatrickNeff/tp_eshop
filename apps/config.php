<?php
<<<<<<< HEAD
// Constante pour connexion DB
define("DB_HOST", "localhost");
define("DB_NAME", "eshop");
define("DB_USER", "root");
define("DB_PASS", "troiswa");
define("DB_CHARSET","UTF8");
// Constantes pour permissions
define ('CLIENT',                  0x01); // => editer profil + poster avis
define ('EDITER_AVIS',             0x02);
define ('SUPPRIMER_AVIS',          0x04);
define ('AJOUTER_PRODUIT',         0x08);
define ('EDITER_PRODUIT',          0x10);
define ('SUPPRIMER_PRODUIT',       0x20);
define ('EDITER_STOCK',            0x40);
define ('EDITER_PRIX',             0x80);
define ('EDITER_CLIENT',           0x100);
define ('EDITER_PERMISSION',       0x200);
=======
// Connexion DB
$dbname = 'eshop';
$host = 'localhost';
$charset = 'UTF8';
$dblogin = 'root';
$dbpwd = 'troiswa';
// Constantes pour permissions
define ('PUBLIER_CONTENU',         0x01);
define ('MODIFIER_CONTENU',        0x02);
define ('SUPPRIMER_CONTENU',       0x04);
define ('VALIDER_TOUT_CONTENU',    0x08);
define ('MODIFIER_TOUT_CONTENU',   0x10);
define ('SUPPRIMER_TOUT_CONTENU',  0x20);
define ('GERER_MEMBRES',           0x40);
define ('GERER_PERMISSIONS',       0x80);
>>>>>>> dev-patrick
?>