<?php
$db = new PDO("mysql:dbname=tp_commun;host=127.0.0.1;charset=utf8", 'root', 'troiswa');

/** Pascal : Bien pour le dévelopemment, ne pas oublier de l'enlever lors de la mise en "live" **/
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 session_start();

$page = 'home';
if (isset($_GET['page']))
	$page = $_GET['page'];
require('views/index.phtml');
?>