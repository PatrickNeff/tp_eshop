<?php
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
?>