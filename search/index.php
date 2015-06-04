<?php

	$db->exec("SET CHARACTER SET UTF8"); // FORMATER EN UTF-8

	if (isset($_POST['search']) && strlen($_POST['search']) > 2)
	{
		$search = $_POST['search'];
		$search = strtolower($search);

		echo "<br>"."search : ".htmlentities($search)."<br><hr><br>";
		$req = "SELECT * FROM product WHERE name LIKE ".$db->quote('%'.$search.'%')." OR description LIKE ".$db->quote('%'.$search.'%')." "; // Requète (chemin qui pointe vers l'endroit MYSQL ou l'on veux récupérer, modifier, ou supprimer des données). On ajout le $db->quote() pour ne pas avoir de problème si l'utilisateur entre des quotes dans la fonction recherche.
		$tab_recup = $db->query($req); // Récupération du tableau
		$tab_result = $tab_recup->fetchAll(); // Récupération du tableau contenant TOUTES les lignes d'enregistrements

		//	var_dump($req);
		//	var_dump($tab_recup);
		//	var_dump($tab_result[0]['description']);

		// On créé une boucle qui récupère les informations dans le tableau.
		$i = 0;
		while($i < sizeof($tab_result)) // Tant que $i est inférieur au nombre d'éléments du tableaux alors... : 
		{
			// On met le résultat dans une variable. On sécurise avec htmlentities.
			$search = htmlentities($tab_result[$i]['id_product']).'		&#x27AA;	' .htmlentities($tab_result[$i]['name']).'	&#x27AA;	' .htmlentities($tab_result[$i]['description']).'	&#x27AA;	' .htmlentities($tab_result[$i]['image'])."<br>";
			// On affiche le résultat de la recherche.
			echo'<a id="results" href="index.php?page=catalogue_view&id_product=$id_product">'.$search.'</a>';

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