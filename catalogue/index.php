<?php
// ============== Formulaire catalogue

	$message = ''; // Contient les messages d'erreur à afficher
	$pagin = "";
	$nbPage = "";

	//echo "id de session : " . $_SESSION["id"] . "<br>";

	// si on a choisis une sous catégorie, il faudras lister tous les articles de cette sous catégorie
	if (!empty($_GET['id_subcategory']))// || !empty($_GET['id_product'])) 
	//if (!empty($_POST['action']) AND $_POST['action'] == 'select_sc') // Si le formulaire est validé
	{                                                 

		// si une sous category a été choisie, mais pas le produit en lui même, on liste les produits correspondants

		$selectsc = $db->query("SELECT COUNT(*) AS nbRows FROM sub_category, product WHERE id_sub_category = sub_category_id and  id_sub_category = ".$_GET['id_subcategory'])->fetch(PDO::FETCH_ASSOC);

		if ($selectsc['nbRows'] > 0)
		{ 
			// gestion pagination
			$nb_articles = $selectsc['nbRows'];
			$itemsPage = 2; // 5 articles/page
			$nbPage = ceil($selectsc['nbRows'] / $itemsPage); // nombre total de page à afficher

			// Vérifie que la page demandée existe sinon choix première ou dernière page
			if (isset($_GET['pagin']))
			{
				$pagin = $_GET['pagin'];
				if ($pagin > $nbPage)
				{
				$pagin = $nbPage;
				}
				if ($pagin < 1)
				{
				$pagin = 1;
				}
			}
			else
			{
				$pagin = 1;
			}

			// On calcule le numéro de la première ligne qu'on prend pour le LIMIT de MySQL LIMIT".$firstRow.','.$itemsPage
			$firstRow = ($pagin - 1) * $itemsPage;

			// Requête de sélection pour affichage
			//echo "$firstRow  : " .$firstRow ;
			// selection de tous les produits correspondants à la sous catégorie

			//<td>'.$row['myproduct2_name'].'</td> patpack 
			// id_subcategory='.$row['mysubcategory2_idsubcategory'].'">'.$row['mysubcategory2_name'] .'&amp;
			$selectsc2 = $db->query("SELECT sub_category.id_sub_category as mysubcategory2_idsubcategory, sub_category.name as mysubcategory2_name, product.id_product as myproduct2_idproduct, product.name as myproduct2_name, product.price as myproduct2_price, product.image as myproduct2_image, product.origine as myproduct2_origine, product.stock_quantity as myproduct2_stockquantity FROM sub_category, product WHERE id_sub_category = sub_category_id and  id_sub_category = ".$_GET['id_subcategory'] . " ORDER BY product.name DESC LIMIT ".$firstRow.','.$itemsPage)->fetchAll(PDO::FETCH_ASSOC);
			echo '<p align="right">' .  $selectsc['nbRows'] . ' articles trouvés</p>';
			echo '<div class="title">' . $selectsc2[0]['mysubcategory2_name'] . '</div>';

			function displayLoop($selectsc2)
			{	
				echo '<tr>'; // attention patpack, modif lien	

				$amount = 0;
				if (isset($_POST['amount'])) { 
					$amount = $_POST["amount"];
				}	

				foreach ($selectsc2 as $row)
				{
					echo '<tr> 
					
					
					<td><a href="index.php?page=catalogue_view&amp;id_product='.$row['myproduct2_idproduct'].'">'.$row['myproduct2_name'].'</a></td>	
					<td>'.$row['myproduct2_price'].' €</td>
					<td>'.$row['myproduct2_origine'].'</td>
					<td><img src='.$row['myproduct2_image'].' height="60"></td> 
					<td>'.$row['myproduct2_stockquantity'].' kg</td>';

					echo '</tr>';
				}
			}
			// Patpack : si on voudrait tester si une image est bien chargé il faudrait le faire en javascript en vérifiant que l'image est bien chargé
			// et dans le cas contraire, lui mettre notre image par défaut. Top compliqué, on oublie
			// ajouter les quantités à cette page : marche pas. 
			// <td><form method="post" action="index.php?page=ajout_panier&id_product='.$row['myproduct2_idproduct'].'" enctype="multipart/form-data">	</td>
			//	<td> quantité à commander en kg <input type="text" name="amount" width="150px"  value="' . strip_tags($amount) . '" id="champAmount" placeholder="0" maxlength="10" class="form-control"></td>
			//	<td><button type="submit" name="ajout_panier" class="btn btn-primary">Ajouter au panier</button></td>';

			require('index.phtml');	
		} // if voir si besoin requête pour trouver le nom de la sous-categorie
		else{

			$selectsc4 = $db->query("SELECT sub_category.name as mysubcategory4_name
									 FROM   sub_category 
									 WHERE  id_sub_category = ".$_GET['id_subcategory'])->fetch(PDO::FETCH_ASSOC);

			echo 'il n y a aucun article correspondant à la sous catégorie <strong>' . $selectsc4["mysubcategory4_name"] . '</strong><br>';
			echo '<a href="index.php?page=catalogue"><button type="button" class="btn btn-primary">Retour vers le catalogue</button></a>';
		}
	}
		
	// aucune sous-categories n'a été sélectionnée, on affiche la liste de toute les categories et sub_categories	
	else
	{	$mycategory = "";
		$selectc = $db->query("SELECT category.id_category as mycategory_id, category.name as mycategory_name, sub_category.id_sub_category as mysubcategory_id, sub_category.name as mysubcategory_name FROM category, sub_category WHERE id_category = category_id")->fetchAll(PDO::FETCH_ASSOC);
		echo '<table><tr><div class="title"><strong>alimentation générale</strong></div></tr>';

		foreach ($selectc as $row)
		{
			echo '<tr>';
			/*echo '<td>'.$row['myname'].'</td>';
			echo '<td><a href="index.php?page=catalogue-view&amp;id_product='.$row['id_product'].'">'.$row['product_name'].'</a></td>';
			echo '<td>'.$row['product_origine'].'</td>';
			echo '<td>'.$row['product_stock_quantity'].'</td>';
			echo '<td>'.$row['product.price'].'</td>';*/

			if ($mycategory  != $row['mycategory_id'])
			{
				
				echo '</tr><tr>';
				echo '<div class="title"><td><h2>'.$row['mycategory_name'].'</h2></td></div>';
				echo '</tr><tr>';

			}

			echo '<td><a href="index.php?page=catalogue&amp;id_subcategory='.$row['mysubcategory_id'].'">'.$row['mysubcategory_name'].'</a></td>';	
			echo '</tr>';
			$mycategory = $row['mycategory_id'];


		}
		echo '</table>';
		//require('index.phtml');	

	}
	?>

<style>

	.title{
		text-align: center;
		font-size: 30px;
		text-transform: uppercase;
		color:rgb(0,220,150);
		margin: 30px 0;
	}

</style>

