<?php

	$my_id = $_POST['my_id'];

	$request = "DELETE FROM order_item WHERE id=".$my_id;

	$db->exec($request);

	// Redirection vers index.php?page=panier&order_id=6;
	header('Location: index.php?page=panier&order_id=6');

?>