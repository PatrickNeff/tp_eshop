<?php 

	$sql = "SELECT * FROM client";
	$result = $db->query($sql);
	$tab_client = $result->fetchAll();

	foreach ($tab_client as $ligne) // Pour chaque ligne existante de la table :
	{
			$id = $ligne['id'];

			$pseudo = $ligne['pseudo'];

			echo "<li>Identifiant : ".$id." / Pseudo : ".$pseudo."</li>";
	}

 ?>