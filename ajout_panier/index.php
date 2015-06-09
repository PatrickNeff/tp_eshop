<?php

/*

ajout au panier : 
panier = commande avec status à en cours (2)
on accède pas de nouveau enreg pour un client tant qu'il reste une commande avec un panier en cours

algorythme en pseudo code


si on a cliqué sur le bouton ajouter au panier et qu'une quantité a été chosie
	si on a bien mis une quantité exploitable
		recherche le produit à ajouter, dans la table produit
		boucle sur tous les paniers existants dans lequel on trouve ce produit
		
		si un panier existe déjà pour ce client 
			si ce produit est déjà dans la panier
			    cumul de la quantité tous les paniers existants et de la quantité à rajouter
			    si quantité commandable
					MAJ item_order
					MAJ orders
				sinon
					message (ajout article refusé, pas assez de stock)

			si existe pas encore
				cumul de la quantité de tous les paniers existants et de la quantité à rajouter
				si quantité commandable
					INSERT item_order
					MAJ orders
				sinon
					message (ajout article refusé, pas assez de stock)

		si pas de panier
			cumul de la quantité de tous les paniers existants et de la quantité à rajouter
			si quantité commandable
				INSERT item_order
				INSERT orders
			sinon
				message (ajout article refusé, pas assez de stock)
									
	si pas exploitable
		message (ajout article refusé, pas assez de stock)
si pas de quantité choisie
	message (pas de quantité commandée)

*/

//$_SESSION['id']  = 1; // danger patpack forçage provisoire

//echo "début ajout panier<br>";
//echo "id de session : " . $_SESSION["id"];

// initialisation variables de travail
$amount = 0;                  // quantité qu'il tente de rajouter au panier
$amount_stock = 0;            // quantité en stock dans la table produit
$amount_panier = 0;           // quantité peexistente dans le panier
$amount_panier_order = 0;     // quantité dans mon panier + ma commande en cours
$amount_all_panier = 0;       // quantité en cours de commande partout (sans ma commande)
$amount_all_panier_order = 0; // quantité en cours de commande dans tous les paniers  + dans ma commande
$amount_panier_affichage = 0;

// variables de travail
$order_HT_price = 0;               // couts total hors taxe de la commande
$order_TTC_price = 0;              // couts total TTC de la commande
$order_item_price_before_rate = 0; // couts article avant taxe
$order_item_price_total = 0;       // couts article apres taxe
$order_rate = 0.20; // patpack voir pour mettre la constante au niveau du site 

$vide = "";

if (isset($_POST['amount'])) { $amount = ($_POST['amount']) ; }


// recherche du produit. On appelle toujours pour avoir le nom du produit pour la redirection
$select = $db->query("SELECT    COUNT(*)            as nbRows,
	                         	id_product          as monproduit_idproduct,
							 	product.name        as monproduit_name,
								product.description as monproduit_description,
								sub_category_id     as monproduit_subcategoryid,
								price               as monproduit_price,
								image               as monproduit_image,
								origine             as monproduit_origine, 
								stock_quantity      as monproduit_stockquantity,
								note_id             as monproduit_noteid
					  FROM product
				      WHERE id_product = ". $_GET['id_product'] )->fetch(PDO::FETCH_ASSOC);

//echo "la quantité en stock sur le produit  " . $select['monproduit_name'] . " est de " . $select['monproduit_stockquantity'] . "<br>";


// foreach ($_POST as $field => $value) { echo "$field = $value<br />ZZZ\n";} patpack trace tous les posts


// si on a cliqué sur le bouton ajouter panier avec quantité
if (isset($_POST['ajout_panier']) && (isset($_POST['amount'])) && (!empty($_POST['amount']))) 
{

	//echo "on a une quantité de choisie<br>";

	// si on a bien rentré un nombre // voir si besoin intval)
	//if (is_float($amount)){
	if (is_numeric($amount) && $amount > 0)
	{ 
	//if (!empty($amount) && ){

		//echo "on a une quantité numérique<br>";
		$vide = "non";

		$amount = round($amount, 3);

		$amount_stock = $select['monproduit_stockquantity']; 	

		// recherche de tous les paniers pouvant exister et dans lequel on peux trouver le produit en question
		$select1b = $db->query("SELECT COUNT(*)            as nbRows1b,
									 orders.id             as monpanier1b_orderid, 
	                                 orders.client_id      as monpanier1b_clientid,
								     order_item.id         as monpanier1b_itemid,
								     order_item.id_product as monpanier1b_idproduct,
								     order_item.weight     as monpanier1b_weight
							  FROM   orders, order_item
						      WHERE  orders.id = order_item.id_order
						      AND    order_item.id_product = ". $_GET['id_product']	."	
						      AND    orders.status = '2' " )->fetchAll(PDO::FETCH_ASSOC);

		// calcul pour ce produit de toutes les quantités déjà en cours de commande (qui existe dans tous les paniers existants, dont le mien...)
		foreach ($select1b as $row)
		{
			$amount_all_panier += $row['monpanier1b_weight'];
		}

		//echo "pour ce produit la quantité déjà en cours de commande est de : " . $amount_all_panier . "<br>";


		// recherche du panier
		$select2 = $db->query("SELECT   COUNT(*)             as nbRows2,
									 	orders.id            as monpanier2_orderid, 
	                                 	orders.client_id     as monpanier2_clientid,
									 	orders.HT_price      as monpanier2_HT_price, 
	                                 	orders.TTC_price     as monpanier2_TTC_price,	                                 	
								     	orders.status        as monpanier2_status
							  FROM orders
						      WHERE status = '2' 
						      and   client_id = ". $_SESSION['id'] )->fetch(PDO::FETCH_ASSOC); 


		//echo "le panier est trouvé avec l'id " . $select2['monpanier2_orderid'] . "<br>";	

		// si existe, rechercher si cette article a déjà été commandé pour savoir si il faut modifier cette quantité dans la ligne de commande. 
		if ($select2['nbRows2'] > 0)
		{

			$select3 = $db->query("SELECT COUNT(*)             as nbRows3,
										 orders.id             as monpanier3_orderid, 
		                                 orders.client_id      as monpanier3_clientid,
		                                 orders.HT_price       as monpanier3_HT_price,
		                                 orders.TTC_price      as monpanier3_TTC_price,
									     order_item.id         as monpanier3_itemid,
									     order_item.id_product as monpanier3_idproduct,
									     order_item.weight     as monpanier3_weight
								  FROM   orders, order_item
							      WHERE  orders.id = order_item.id_order
							      AND    orders.status = '2'
							      AND    order_item.id_product = ". $_GET['id_product']	."						      
							      AND    orders.client_id = ". $_SESSION['id'] )->fetch(PDO::FETCH_ASSOC);


			// article déjà en cours de commande, faut cumuler pour comparer (il ne peux exister qu'un panier pour un client donné)
			if ($select3['nbRows3'] > 0)
			{

				// quantité à comparer au stock : tous ce qui existe déjà dans tous les paniers (y compris le mien) + la quantité que j'essaye de commander
				$amount_all_panier_order = $amount_all_panier + $amount; 

				// quantité à renseigner dans ma ligne de commande si OK
				$amount_panier = $select3['monpanier3_weight'] ;
				$amount_panier_order = $amount  + $amount_panier;

				//echo "article déjà existant dans votre panier. Quantité totale à commander : " . $amount_panier_order  . ". Il y avait déjà " . $amount_panier . " dans le panier<br>";;

				// si il reste du stock, ajout de la quantité choisis au panier	
				if ($amount_all_panier_order > $amount_stock )
				{
					echo "<div class='alert alert-danger' role='alert'>vous ne pouvez pas rentrer une quantité supérieure au stock !</div>";
					$vide = "";
				}

				else	
				{

					// cout article : prix récup de la base * quantité
					$order_item_price_before_rate = $select['monproduit_price'] * $amount_panier_order; 
					$order_item_price_total = $order_item_price_before_rate; 

					// cout commande hors taxe (et avant frais de port) : couts avant modif de tous les produits + (quantité commande en cours * prix article)
					$order_HT_price  = $select2['monpanier2_HT_price'] + ($amount * $select['monproduit_price']);
					$order_TTC_price = $order_HT_price + ($order_HT_price * $order_rate); 


					// update de l'item du panier 
		            $update1 =  'UPDATE order_item 
	                            SET weight              = '.$db->quote($amount_panier_order).',
	                                price_before_rate   = '.$db->quote($order_item_price_before_rate).', 
	                                price_total         = '.$db->quote($order_item_price_total).'                                
	                 			WHERE order_item.id     = '.$db->quote($select3['monpanier3_itemid']).'';
	                 //echo "SQL > ".$update1.'<br/>';
	                 $db->exec($update1);

	                 //echo "update ORDER_ITEM CAS1 avec en price_before_rate : " . $order_item_price_before_rate . " et en price_total " . $order_item_price_total ."<br>";

					// update du panier
		            $update2 = 'UPDATE orders 
	                           SET HT_price   = '.$db->quote($order_HT_price).',
	                               TTC_price  = '.$db->quote($order_TTC_price).' 
	                 WHERE orders.id = '.$select2['monpanier2_orderid'].'';

	                 //echo "SQL > ".$update2.'<br/>';
	                 $db->exec($update2);

	                 //echo "update ORDERS CAS1 avec en HT_price : " . $order_HT_price . " TTC_price " . $order_TTC_price ."<br>";

				}

			//echo "article déjà existant. Quantité à commander : " . $amount_panier_order  . ". il y avait déjà " . $amount_panier . " dans le panier<br>";
			} 


			// article pas en cours de commande, on rajoute l'article au panier, puis on recalcule les couts totaux
			else 
			{

				// quantité à comparer au stock : tous ce qui existe déjà dans tous les paniers + la quantité que j'essaye de commander
				$amount_all_panier_order = $amount_all_panier + $amount; 

				// quantité à renseigner dans ma ligne de commande si OK
				$amount_panier = 0;
				$amount_panier_order = $amount;
				$amount_order = $amount;

				/*echo "article existant pas encore dans votre panier. Quantité totale à commander : " . $amount_panier_order  . 
				" et quantité totale en cours de commande " . $amount_all_panier_order . "<br>";*/

				// si il reste du stock, ajout de la quantité choisis au panier	
				if ($amount_all_panier_order > $amount_stock )
				{
					echo "<div class='alert alert-danger' role='alert'>vous ne pouvez pas rentrer une quantité supérieure au stock !</div>";
					$vide = "";
				}

				else
				{
			
					// cout article : prix récup de la base * quantité
					$order_item_price_before_rate = $select['monproduit_price'] * $amount_panier_order;
					$order_item_price_total = $order_item_price_before_rate; 

					// cout commande hors taxe (et avant frais de port) : couts avant modif de tous les produits + (quantité commande en cours * prix article)
					$order_HT_price  = $select2['monpanier2_HT_price']+ ($amount * $select['monproduit_price']);
					$order_TTC_price = $order_HT_price + ($order_HT_price * $order_rate); 

					// creation de l' item du panier
					$insert1 = 'INSERT INTO order_item (id_order, id_product, weight, price_per_kilo, rate_article, price_before_rate, price_total ) 
							  VALUES (
							  	'.$db->quote($select2['monpanier2_orderid']).',
							  	'.$db->quote($_GET['id_product']).',
							  	'.$db->quote($amount_panier_order).',
							  	'.$db->quote($select['monproduit_price']).',
							  	0,
							  	'.$db->quote($order_item_price_before_rate).',
							  	'.$db->quote($order_item_price_total).')';
					$db->exec($insert1);
					//echo $query;
					//echo "update ORDER_ITEM CAS2 avec en price_before_rate : " . $order_item_price_before_rate . " et en price_total " . $order_item_price_total ."<br>";

					// mise à jour des prix dans la table orders
		            $update3 =  'UPDATE orders 
	                             SET HT_price   = '.$db->quote($order_HT_price).',
	                                 TTC_price  = '.$db->quote($order_TTC_price).' 
	                 WHERE orders.id = '.$select2['monpanier2_orderid'].'';
	                 //echo "<<< $update3 : " . $update3 . " >>>";
	                 $db->exec($update3);



	                 //echo "update ORDERS CAS2 avec en HT_price : " . $order_HT_price . " TTC_price " . $order_TTC_price ."<br>";
                }

			}

		}


		// pas de panier => comparaison de la quantité avec le stock
		else
		{

			// quantité à comparer au stock : tous ce qui existe déjà dans tous les paniers + la quantité que j'essaye de commander
			$amount_all_panier_order = $amount_all_panier + $amount; 

			// quantité à renseigner dans ma ligne de commande si OK
			$amount_panier = 0;
			$amount_order = $amount;
			$amount_panier_order = $amount;

			//echo "panier existant pas encore. Quantité totale à commander : " . $amount_panier_order  . " et quantité en stock " . $amount_stock . "<br>";

			if ($amount_panier_order > $amount_stock )
			{
				//echo "<div class='alert alert-danger' role='alert'>vous ne pouvez pas rentrer une quantité supérieure au stock !</div>";
				$vide = "";
			}

			// creation du panier avec la quantité choisis	
			else
			{
				
				// cout article : prix récup de la base * quantité
				$order_item_price_before_rate = $select['monproduit_price'] * $amount_panier_order;
				$order_item_price_total = $order_item_price_before_rate; 

				// cout commande hors taxe (et avant frais de port) : couts avant modif + (quantité commande en cours * prix article)
				$order_HT_price  = $order_item_price_total; // pas de cumul car pas encore de panier
				$order_TTC_price = $order_HT_price + ($order_HT_price * $order_rate); 
				// creation du panier global
				$insert2 = 'INSERT INTO orders (client_id, order_date, payment_id, order_rate, HT_price, TTC_price, status ) 
						  VALUES (
						  	'.$db->quote($_SESSION['id']).',
						  	NOW(),
						  	0,
						  	'.$db->quote($order_rate).',
						  	'.$db->quote($order_HT_price).',
						  	'.$db->quote($order_TTC_price).',
						  	2)';
				$db->exec($insert2);

				//echo "insert order3 OK<br>";
				//echo "INSERT ORDERS CAS3 avec en HT_price : " . $order_HT_price . " TTC_price " . $order_TTC_price ."<br>";
				
				// récupérer l'id du panier que l'on vient de créer. Seul 1 enreg peut correspondre et on vient de le créer, donc c bon quoi!
				$select4 = $db->query("SELECT orders.id            as monpanier4_orderid, 
			                                  orders.client_id     as monpanier4_clientid,
										      orders.status        as monpanier4_status
									  FROM orders
								      WHERE orders.status = '2'
								      AND  client_id = ". $_SESSION['id'] )->fetch(PDO::FETCH_ASSOC);

				// creation de l' item du panier
				$insert3 = 'INSERT INTO order_item (id_order, id_product, weight, price_per_kilo, rate_article, price_before_rate, price_total ) 
						  VALUES (
						  	'.$db->quote($select4['monpanier4_orderid']).',
						  	'.$db->quote($_GET['id_product']).',
						  	'.$db->quote($amount_panier_order).',
						  	'.$db->quote($select['monproduit_price']).',
						  	0,
						  	'.$db->quote($order_item_price_before_rate).',
						  	'.$db->quote($order_item_price_total).')';
				$db->exec($insert3);

				//echo "INSERT ORDER_ITEM CAS3 avec en price_before_rate : " . $order_item_price_before_rate . " et en price_total " . $order_item_price_total ."<br>";
			}

		}
							    
	}
	else
	{
		//echo "on a une quantité saisie, mais pas numérique<br>";
		$_POST['amount'] = 0;
		echo "<div class='alert alert-danger' role='alert'>Nos articles sont vendus par kilos. veuillez rentrer un poids crédible !</div>";
	}

}


else
{
	$_POST['amount'] = 0;
	echo "<div class='alert alert-danger' role='alert'>pas de commande, vous n'avez rien à foutre sur cette page !</div>";
}

require('index.phtml');	
 // patpack voir ou on fout le require pour affichage


/* jeu de test
penser à faire le require avec les liens

cas à tester                                                       / resultat voulu                            / resultat obtenu                         / conclusion            
                                                                   /                                           /                                         /
on ne rentre pas de quantité ou 0                                  / message d'erreur rien à faire ici + phtml / message OK, pas d'enreg                 / OK
on rentre des lettres                                              / message d'erreur pas de chiffres + phtml  / message OK, pas d'enreg                 / OK
on rentre 0                                                        / message d'erreur rien à faire ici + phtml / message OK, pas d'enreg                 / OK

pas de panier, quantité > stock                                    / message erreur, pas bdd                   / message OK                              / OK
pas de panier, quantité < stock                                    / achat                                     / bdd OK                                  / OK
pas de panier, quantité = stock                                    / achat                                     / bdd OK                                  / Ok

panier, mais pas ce produit + > stock                              / message erreur pas bdd                    / message OK                              / OK
panier, mais pas ce produit + < stock                              / achat                                     / bdd OK                                  / Ok
panier, mais pas ce produit + = stock                              / achat                                     / bdd OK                                  / Ok

panier, avec ce produit + quantité commandée seule > stock         / message erreur pas bdd                    / message OK                              / OK
panier, avec ce produit + quan en base  + quan commandé > stock    / message erreur pas bdd                    / message OK                              / OK
panier, avec ce produit + quantité total < stock                   / achat                                     / bdd OK                                  / Ok

refaire tous les calculs pour différents clients

les quantités en stock pour chaque produit ne seront débitées que lorts de la validation de la commande
mais ce serait bien sur des pages comme catalogue_view de débiter ce qui est déjà en cours de commande. A voir.
séparateur décimal = . 

patpack : rajouter le lien aussi de l'autre page
calcul des quantités OK
vérif si tous les messages OK, puis mettre traces en commentaire


*/

?>