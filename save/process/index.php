<?php
if (!isset($_SESSION['message']))
{
	header('Location: index.php?page=home');
	die();
}
require('index.phtml');
unset($_SESSION['message']);
?>