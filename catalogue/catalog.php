<?php
// ============== Formulaire catalogue

	$message = ''; // Contient les messages d'erreur à afficher

	// si on a choisis une sous catégorie, il faudras lister tous les articles de cette sous catégorie
	if (!empty($_POST['action']) AND $_POST['action'] == 'select_sc') // Si le formulaire est validé
	{

		// si une sous category a été choisie, on liste les produits correspondants
		if (!empty($_POST['sub_category'])
		{

			$selectsc = $db->query("SELECT SELECT COUNT(*) AS nbRows FROM sub_category, product WHERE id_sub_category = sub_category_id and  id_sub_category = ".$_POST['id_sub_category'])->fetch(PDO::FETCH_ASSOC);

			// gestion pagination
			$itemsPage = 5; // 5 articles/page
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

			// selection de tous les produits correspondants à la sous catégorie
			$selectsc2 = $db->query("SELECT SELECT sub_category.name, product.id_product, product.name, product.price, product.image, product.origine, product.stock_quantity FROM sub_category, product WHERE id_sub_category = sub_category_id and  id_sub_category = ".$_POST['id_sub_category'] . " ORDER BY product.name DESC LIMIT ".$firstRow.','.$itemsPage)->fetchAll(PDO::FETCH_ASSOC);
			

			function displayLoop($selectsc2)
			{
				echo '<tr>';
				echo '<td>'.$row['sub_category.name'].'</td>';
				echo '<tr>';
				foreach ($selectsc2 as $row)
				{
					echo' 
					<td>'.$row['product.name'].'</td>
					<td>'.$row['product.price'].'</td>
					<td>'.$row['product.origine'].'</td>
					<td>'.$row['product.image'].'</td>
					<td>'.$row['product.stock_quantity'].'</td>'
				}
				echo '/<tr>';
			}


			// patpack : a implementer pour appel fichier phtml
			// voir ensuite gestion pagin
			/*foreach ($selectsc as $row)
			{
				$sub_category_name = $row['sub_category.name'];
				$id_product = $row['product.id_product'];
				$product_name = $row['product.name'];
				$product_origine = $row['product_origine'];
				$product_stock_quantity = $row['product_stock_quantity'];				
				$product_price = $row['product.price'];

				/* si non trouvé on mets l'image non trouvé */
				/*if ($row['product.image'] == "")
				{
					$product_image = "images/missing.jpg";
				}
				else
				{
					$product_image = $row['product.image'];
				}*/

		}

			//require('./views/catalog-view.phtml');
		// aucune sous category n'a été choisie, lui demander d'en choisir une
		else
		{
			$message = '<div class="alert alert-danger" role="alert">You must select a sub_category to see all products corresponding.</div>';
		}

	}
		
	// aucune sous-categories n'a été sélectionnée, on affiche la liste de toute les categories et sub_categories	
	else
	{
		$selectc = $db->query("SELECT category.id_category, category.name, sub_category.id_sub_category, sub_category.name FROM category, sub_category WHERE id_category = category_id"->fetchAll(PDO::FETCH_ASSOC);
		foreach ($selectc as $row)
		{
			echo '<table><tr>
			<td>'.$row['sub_category.name'].'</td>
			<td><a href="index.php?page=catalogue-view&amp;id_product='.$row['id_product'].'">'.$row['product_name'].'</a></td>
			<td>'.$row['product_origine'].'</td>
			<td>'.$row['product_stock_quantity'].'</td>
			<td>'.$row['product.price'].'</td>
			</tr></table>';
		}
		echo "<input type='submit' name='myproducts' value='Choisir la catégorie'>\n"
		require('./views/catalog.phtml');	

	}

/*






	if (!empty($_POST['action']) AND $_POST['action'] == 'publish_article') // Si le formulaire est validé
	{
		if (!empty($_POST['category']) AND !empty($_POST['title']) AND !empty($_POST['content'])) // Si les champs requis sont remplis
		{
			$author_id = $_SESSION['id'];
			$category = $_POST['category'];
			// Suppression espaces
			$title = trim($_POST['title']);
			$content = trim($_POST['content']);
			// Sécurité
			$title = $db->quote($title);
			$content = $db->quote($content);
			$category = $db->quote($category);
			// INSERT SQL
			$query = 'INSERT INTO article (title, content, author_id, time_create, category) VALUES ('.$title.','.$content.','.$author_id.',NOW(),'.$category.')';
			$db->exec($query);
			$_SESSION['message'] = '<div class="alert alert-success" role="alert">Your article has been successfully published !</div>';
			header('Location: index.php?page=process');
		}
		else
		{
			$message = '<div class="alert alert-danger" role="alert">All fields are required in order to publish.</div>';
		}
	}
	// Requête nombre d'enregistrements
	$select1 = $db->query("SELECT COUNT(*) AS nbRows FROM article")->fetch(PDO::FETCH_ASSOC);
	// On calcule le nombre de pages à créer
	$itemsPage = 5;
	$nbPage = ceil($select1['nbRows'] / $itemsPage);
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
	$select2 = $db->query("SELECT article.id, article.title, article.author_id, article.time_create, article.time_update, article.category, member.pseudo FROM article JOIN member ON member.id = article.author_id ORDER BY time_create DESC LIMIT ".$firstRow.','.$itemsPage)->fetchAll(PDO::FETCH_ASSOC);
	function displayLoop($select2)
	{
		foreach ($select2 as $key=>$row)
		{
			if ($row['time_update'] == '0000-00-00 00:00:00')
			{
			$select2[$key]['update'] = '-';
			}
			else
			{
			$select2[$key]['update'] = systeme_date(strtotime($row['time_update']));
			}
			$select2[$key]['create'] = systeme_date(strtotime($row['time_create']));
		}
		foreach ($select2 as $row)
		{
			echo '<tr>
			<td><a href="index.php?page=article-view&amp;id='.$row['id'].'">'.$row['title'].'</a></td>
			<td>'.$row['pseudo'].'</td>
			<td>'.$row['create'].'</td>
			<td>'.$row['update'].'</td>
			<td>'.$row['category'].'</td>
			</tr>';
		}
	}
	require('./views/articles.phtml');
?>*/