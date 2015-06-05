<?php
	// FORMATER EN UTF-8
	$db->exec("SET CHARACTER SET UTF8");

	if (isset($_POST['search']) && strlen($_POST['search']) > 2)
	{
		$search = $_POST['search'];
		$search = strtolower($search);

		echo "<br>"."search : ".htmlentities($search)."<br><hr><br>";

		// Rèquète qui pointe vers le chemin de recherche dans la base SQL
		$req = "SELECT * FROM product WHERE name LIKE ".$db->quote('%'.$search.'%')." OR description LIKE ".$db->quote('%'.$search.'%');
		// Récupération du tableau
		$tab_recup = $db->query($req);
		// Récupération du tableau contenant TOUTES les lignes d'enregistrements
		$tab_result = $tab_recup->fetchAll();

		// On créé une boucle qui récupère les informations dans le tableau.
		$i = 0;
		// Tant que $i est inférieur au nombre d'éléments du tableaux alors... : 
		while($i < sizeof($tab_result))
		{
			// On met le résultat dans une variable. On sécurise avec htmlentities.
			$search = '<ul><li>' .htmlentities($tab_result[$i]['name']).'</li><li>' .htmlentities($tab_result[$i]['description']).'</li><li>' .htmlentities($tab_result[$i]['image'])."</li></ul>"."<br>";
			// On récupère l'id du produit pour pouvoir afficher la page produit en cliquant sur le lien.
			$id_product = htmlentities($tab_result[$i]['id_product']);
			// On affiche le résultat de la recherche.
			echo'<a href="index.php?page=catalogue_view&id_product='.$id_product.'">'.$search.'</a>';
			$i++;
		}
		if ($i == 0)
		{
			echo "Aucun résultat n'a été trouvé.";
		}
	}
	else if (isset($_POST['search']) && strlen($_POST['search']) <= 2)
	{
		echo "Pour effectuer une recherche, veuillez entrer au minimum 3 caractères";
	}
?>