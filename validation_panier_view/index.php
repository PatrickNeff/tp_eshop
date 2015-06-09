<?php
// Requête de sélection pour affichage


	$select2 = $db->query("SELECT 
										 orders.id              as monpanier2_orderid, 
									     order_item.id          as monpanier2_itemid,
									     order_item.id_product  as monpanier2_idproduct,
									     order_item.weight      as monpanier2_weight,
									     order_item.price_per_kilo as monpanier2_price_per_kilo,
									     order_item.price_total as monpanier2_price_total,
									     product.name           as monpanier2_productname
								  FROM   orders
								  LEFT JOIN order_item ON orders.id = order_item.id_order
								  LEFT JOIN product ON order_item.id_product = product.id_product

							      WHERE  orders.status = '2'				      
							      AND    orders.client_id = ". $_SESSION['id'] . " 
							      ORDER BY monpanier2_itemid")->fetchAll(PDO::FETCH_ASSOC);
							      //ORDER BY monpanier2_itemid DESC LIMIT ".$firstRow.','.$itemsPage)->fetchAll(PDO::FETCH_ASSOC);
	//var_dump($select2);
	/*$select = $db->query("SELECT title, content, author_id, time_create, time_update, category FROM article WHERE id = ".$_GET['id'])->fetchAll(PDO::FETCH_ASSOC);*/
	?><table>
		<thead>
			<th>Article </th>
			<th>Prix au kilo</th>					
			<th>Quantité</th>
			<th>Prix total</th>					
		</thead>
	<?php

	foreach ($select2 as $row)
	{
		/*if ($row['time_update'] == '0000-00-00 00:00:00')
		{
			$update = '-';
		}
		else
		{
			$update = systeme_date(strtotime($row['time_update']));
		}*/
		//$itemid = $row['monpanier2_itemid'];
		$article = $row['monpanier2_productname'];
		$price_per_kilo = $row['monpanier2_price_per_kilo'];
		$weight = $row['monpanier2_weight'];
		$monpanier2_price_total = $row['monpanier2_price_total'];
		require('index.phtml');
	}
	?>
	</table><?php
	/*require('index.phtml');*/
?>

<style>

	table{
		width: 100%;
	}
</style>