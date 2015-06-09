<?php
// ============== Formulaire Panier

	$message = ""; // Contient les messages d'erreur à afficher
	/*$status = "";
	$payment = 0;
	$adresse = 0;
	$TTC_price = 0;*/


	// récupération id de la commande. Si pas d'id, rien à faire ici
	//echo "id commande : " $_GET['id_order'];

	// Requête nombre d'enregistrements. 
	$select0 = $db->query("SELECT COUNT(*) as nbRows, 
							orders.id as myordersid,
							orders.TTC_price as myttcprice
								  FROM   orders, order_item
							      WHERE  orders.id = order_item.id_order
							      AND    orders.status = '2'				      
							      AND    orders.id = ". $_GET['id_order'] )->fetch(PDO::FETCH_ASSOC);


	// calcul prix total
	$TTC_price = $select0['myttcprice'];
	$shipping_fees = 0;

	// frais de port de 5% en dessous de 50 euros d'achat, gratuit au dessus
	if ($TTC_price < 50)
	{
		$shipping_fees  = $TTC_price * 5/100;
	}
	$TTC_price_with_fees = $TTC_price + $shipping_fees;

	// MAJ frais de port
    $update0 =  'UPDATE orders 
                 SET TTC_price_with_fees = '.$db->quote($TTC_price_with_fees).'                                                         
     			    WHERE orders.id     = '.$db->quote($_GET['id_order'] );

	$db->exec($update0);


	

	// Si le formulaire est validé
	if (!empty($_POST['action']) AND $_POST['action'] == 'validate_panier') 
	{

		// faut sélectionner une adresse, un moyen de payement
		if (!empty($_POST['adresse']) AND !empty($_POST['payment'])) 
		{
			// mise à jour de la commande. besoin order_ID, status
			$client_id = $_SESSION['id'];
			/*$status = $_POST['status'];*/
			$payment = $_POST['payment'];
			$adresse = $_POST['adresse'];  // si 1, adresse de livraison, si 2, adresse principale, si 3, adresse secondaire. On devrais faire des vérif pour voir si existe...


			// UPDATE SQL
            $update1 =  'UPDATE orders 
                        SET status              = 0,
                            payment_id          = '.$db->quote($payment).', 
                            adresse_id          = '.$db->quote($adresse).',     
                            shipping_fees       = '.$db->quote($shipping_fees).', 
                            TTC_price_with_fees = '.$db->quote($TTC_price_with_fees).'                                                         
             			    WHERE orders.id     = '.$db->quote($_GET['id_order'] );

			$db->exec($update1);


			$_SESSION['message'] = '<div class="alert alert-success" role="alert">Your commande has been successfully validated !</div>';
			header('Location: index.php?page=process');
		}
		else
		{
			$message = '<div class="alert alert-danger" role="alert">All fields are required in order to publish.</div>';
		}
	}

	// Si la commande est annulée
	if (!empty($_POST['action']) AND $_POST['action'] == 'cancel_panier') 
	{


		// mise à jour de la commande. besoin order_ID, status
		$client_id = $_SESSION['id'];
		/*$status = $_POST['status'];*/


		// UPDATE SQL
        $update1 =  'UPDATE orders 
                     SET status              = 1                                                       
         			 WHERE orders.id     = '.$db->quote($_GET['id_order'] );

		$db->exec($update1);


		$_SESSION['message'] = '<div class="alert alert-success" role="alert">Your commande has been successfully cancelled !</div>';
		header('Location: index.php?page=process');

	}












	// On calcule le nombre de pages à créer
	/*$itemsPage = 5;
	$nbPage = ceil($select0['nbRows'] / $itemsPage);
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
	}*/
	// On calcule le numéro de la première ligne qu'on prend pour le LIMIT de MySQL LIMIT".$firstRow.','.$itemsPage
	//$firstRow = ($pagin - 1) * $itemsPage; ." 
	//						      ORDER BY orders.order_date DESC LIMIT ".$firstRow.','.$itemsPage  
	// Requête de sélection pour affichage

	$select1 = $db->query("SELECT COUNT(*)                          as nbRows1,
										 orders.id                  as monpanier1_orderid, 
		                                 orders.client_id           as monpanier1_clientid,
		                                 orders.order_date          as monpanier1_order_date,
		                                 orders.order_rate          as monpanier1_order_rate,	
		                                 orders.HT_price            as monpanier1_HT_price,		 		                                 
		                                 orders.TTC_price           as monpanier1_TTC_price,		                                 	                                 
<<<<<<< HEAD
		                                 orders.TTC_price_with_fees as monpanier1_TTC_price_with_fees
								  FROM   orders
=======
		                                 orders.TTC_price_with_fees as monpanier1_TTC_price_with_fees,
		                                 client.firstname           as monpanier1_firstname,
		                                 client.lastname            as monpanier1_lastname
								  FROM   orders
								  LEFT JOIN client ON orders.client_id = client.id
>>>>>>> master
							      WHERE  orders.status = '2'				      
							      AND    orders.client_id = ". $_SESSION['id'] )->fetchAll(PDO::FETCH_ASSOC);



	//$select2 = $db->query("SELECT article.id, article.title, article.author_id, article.time_create, article.time_update, article.category, member.pseudo FROM article JOIN member ON member.id = article.author_id ORDER BY time_create DESC LIMIT ".$firstRow.','.$itemsPage)->fetchAll(PDO::FETCH_ASSOC);
	function displayLoop($select1)
	{
		/*foreach ($select2 as $key=>$row)
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
		}*/

		foreach ($select1 as $row)
		{
			echo '<tr>
			<td>'.$row['monpanier1_orderid'].'</td>
<<<<<<< HEAD
			<td>'.$row['monpanier1_clientid'].'</td>
			<td>'.$row['monpanier1_order_rate'].'</td>		
			<td>'.$row['monpanier1_HT_price'].'</td>			
			<td>'.$row['monpanier1_TTC_price'].'</td>
			<td>'.$row['monpanier1_TTC_price_with_fees'].'</td>
=======
			<td>'.$row['monpanier1_firstname'].'</td>
			<td>'.$row['monpanier1_lastname'].'</td>
			<td>'.$row['monpanier1_order_rate'].'</td>		
			<td>'.$row['monpanier1_HT_price'].' €</td>			
			<td>'.$row['monpanier1_TTC_price'].' €</td>
			<td>'.$row['monpanier1_TTC_price_with_fees'].' €</td>
>>>>>>> master
			<td>'.$row['monpanier1_order_date'].'</td>
			</tr>';
		}
	}

	require('index.phtml');
	require('./validation_panier_view/index.php');
	//require('./validation_panier_view/index.phtml');
?>