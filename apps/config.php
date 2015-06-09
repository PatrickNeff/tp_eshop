<?php
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
?>