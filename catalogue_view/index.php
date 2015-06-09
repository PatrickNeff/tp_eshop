<?php

/*$amount = "";
if (isset($_POST['amount'])) { $login = $_POST["amount"];}*/
//echo $_GET['id_product']; 

$amount = 0;
if (isset($_POST['amount'])) { 
	$amount = $_POST["amount"];
}

//$_SESSION['id'] = 1; // forçage patpack
//echo "id de session : " . $_SESSION["id"];



// verification si il existe un panier pour cet utilisateur
if (isset($_SESSION["id"]))
	{
	$selectcv9 = $db->query("SELECT   COUNT(*)           as nbRows1a,
								 	orders.id            as monpanier1a_orderid, 
	                             	orders.client_id     as monpanier1a_clientid,
								 	orders.HT_price      as monpanier1a_HT_price, 
	                             	orders.TTC_price     as monpanier1a_TTC_price,	                                 	
							     	orders.status        as monpanier1a_status
						  FROM orders
					      WHERE status = '2' 
					      and   client_id = ". $_SESSION['id'] )->fetch(PDO::FETCH_ASSOC); 

	if ($selectcv9['nbRows1a'] < 1)
	{ 
		//echo "aucun panier existant";
	}
	else{
		//echo $selectcv9['nbRows1a'] . "ok";
		
	}
}
else
{ 
	$message = "pas de panier pour cet utilisateur";
}

// si on a choisis un produit, il faudras aller sur la fiche produit
if (!empty($_GET['id_product'])) 
{

	$selectsc3 = $db->query("SELECT COUNT(*)            as nbRowsP,
		                            id_product          as myproduct3_idproduct,
									product.name        as myproduct3_name,
									product.description as myproduct3_description,
									sub_category_id     as myproduct3_subcategoryid,
									price               as myproduct3_price,
									image               as myproduct3_image,
									origine             as myproduct3_origine, 
									stock_quantity      as myproduct3_stockquantity,
									note_id             as myproduct3_noteid,
									sub_category.name   as myproduct3_subcategoryname
							FROM    sub_category, product 
							WHERE   id_sub_category = sub_category_id
							AND	    id_product = ".$_GET['id_product'] )->fetch(PDO::FETCH_ASSOC);
							    // id_sub_category = ".$_GET['id_subcategory'])->fetch(PDO::FETCH_ASSOC);

	if ($selectsc3['nbRowsP'] < 1)
	{ 
		$message = "anomalie : aucune produit correspondant";
	}
	else if ($selectsc3['nbRowsP'] > 0)
	{
		require('index.phtml');	
		//echo '<table><tr><td><a href="index.php?page=catalogue_view&amp;id_product='.$selectsc3['myproduct3_idproduct'].'">'.$selectsc3['myproduct3_name'].'</a></td></tr></table>';
	}
		
}


?>