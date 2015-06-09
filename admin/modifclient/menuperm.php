<?php 

	$sql = "SELECT * FROM permission";
	$result = $db->query($sql);
	$tab_perm = $result->fetchAll();

	foreach ($tab_perm as $ligne) // Pour chaque ligne existante de la table :
	{
			$id_permission = $ligne["id_permission"];

			$name = $ligne['name'];

			echo "<option name='droits' value=".$id_permission.">".$name."</option>";
	}

 ?>