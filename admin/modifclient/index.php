<?php
require('./admin/menu.php');
require('./admin/menu.phtml');

$email = "";
$phone = "";
$pass = "";
$street = "";
$zipcode = "";
$city = "";
$country = "";
$street2 = "";
$zipcode2 = "";
$city2 = "";
$country2 = "";
$identifiant = "";

if (isset($_POST['valrecherche'], $_POST['id_client'], $_POST['pseudo_client']))
{
	if (!empty($_POST['id_client']))
	{
		$sql = "SELECT * FROM client WHERE id=".$db->quote($_POST['id_client']);
	}
	else if (!empty($_POST['pseudo_client']))
	{
		$sql = "SELECT * FROM client WHERE pseudo=".$db->quote($_POST['pseudo_client']);
	}
	$result = $db->query($sql);
	if ($result)
	{
		$result = $result->fetchAll();
		if (isset($result[0]))
		{
			$client = $result[0];
			$identifiant = $client['id'];
		}
	}
}

if (isset($_POST['validation'], $_POST['id_client']))
{
	if (!empty($_POST['id_client']))
	{
		$sql = "SELECT * FROM client WHERE id=".$db->quote($_POST['id_client']);
	}
	else if (!empty($_POST['pseudo_client']))
	{
		$sql = "SELECT * FROM client WHERE pseudo=".$db->quote($_POST['pseudo_client']);
	}
	$result = $db->query($sql);
	if ($result)
	{
		$result = $result->fetchAll();
		if (isset($result[0]))
		{
			$client = $result[0];
			$identifiant = $client['id'];
			require('./admin/modifclient/modif.php');
		}
		else
		{
			$error = "<div class='alert alert-danger' role='alert'>L'identifiant ID ou le pseudo de l'utilisateur n'existe pas !</div>";
		}
	}
	else
	{
		$error = "<div class='alert alert-danger' role='alert'>L'identifiant ID ou le pseudo de l'utilisateur n'existe pas !</div>";
	}
}

if ($identifiant !== '')
{
	$sql = "SELECT * FROM client WHERE id='".$identifiant."'";
	$client = $db->query($sql)->fetch();
	$email = $client['email'];
	$phone = $client['phone'];
	$pass = $client['password'];
	$sql = "SELECT * FROM adresse WHERE client_id='".$identifiant."' AND type_adresse = 'principale'";
	$adresse1 = $db->query($sql)->fetch();
	$street = $adresse1['street'];
	$zipcode = $adresse1['zipcode'];
	$city = $adresse1['city'];
	$country = $adresse1['country'];
	$sql = "SELECT * FROM adresse WHERE client_id='".$identifiant."' AND type_adresse = 'livraison'";
	$adresse2 = $db->query($sql)->fetch();
	$street2 = $adresse2['street'];
	$zipcode2 = $adresse2['zipcode'];
	$city2 = $adresse2['city'];
	$country2 = $adresse2['country'];
}


require('./admin/modifclient/index.phtml');
?>