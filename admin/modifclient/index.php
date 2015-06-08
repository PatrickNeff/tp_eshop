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

/*$sql = "SELECT * FROM client";
$tab_utilisateurs = $db->query($sql)->fetchAll();

$i=0;
while (sizeof($tab_utilisateurs)) {
	$user = "<tr><td>".$tab_utilisateurs[$i]['id']."</td><td>".$tab_utilisateurs[$i]['pseudo']."</td></tr>";
	$i++;
}*/


/*-----------------------------------------------------
Recherche existence de l'utilisateur par ID ou pseudo
------------------------------------------------------*/

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

/*-----------------------------------------------------
Modification informations de l'utilisateur
------------------------------------------------------*/

if (isset($_POST['validation'], $_POST['id_client']))
{
	if (!empty($_POST['id_client']))
	{
		$sql = "SELECT * FROM client WHERE id=".$db->quote($_POST['id_client']);
		$result = $db->query($sql);
	}
	else if (!empty($_POST['pseudo_client']))
	{
		$sql = "SELECT * FROM client WHERE pseudo=".$db->quote($_POST['pseudo_client']);
		$result = $db->query($sql);
	}
	

	if (!empty($result))
	{
		$result = $result->fetchAll();
		if (isset($result[0]))
		{
			$client = $result[0];
			$identifiant = $client['id'];

			/*-------------------------------
			Vérification de l'existence du client_ID
			---------------------------------*/

			  	$sql = "SELECT * FROM adresse WHERE client_id='".$identifiant."'";
				//exécution de la requête:
				$infosadresse = $db->query($sql)->fetchAll();

				if (empty($infosadresse))
				{

					// insérer une ligne avec la client id = id de l'utilisateur
			        $request1 ="INSERT INTO adresse (id, client_id, type_adresse, street, zipcode, city, country) VALUES ('', '".$identifiant."', 'principale', '', '', '', '')";
					$db->exec($request1);

			        $request2 ="INSERT INTO adresse (id, client_id, type_adresse, street, zipcode, city, country) VALUES ('', '".$identifiant."', 'livraison', '', '', '', '')";
			        $db->exec($request2);

			        echo "<div class='alert alert-success'>Vous ajouter à votre profile une adresse principale et une adresse de livraison si vous le souhaitez !</div>";
				}

				require('./admin/modifclient/modif.php');
		}
		else
		{
			$error = "<div class='alert alert-danger' role='alert'>L'identifiant ID ou le pseudo de l'utilisateur n'existe pas !</div>";
		}
	}
	else
	{
		$error = "<div class='alert alert-danger' role='alert'>L'identifiant ID ou le pseudo de l'utilisateur n'existent pas !</div>";
	}
}

/*-----------------------------------------------------
Modification du mot de passe de l'utilisateur
------------------------------------------------------*/

if (isset($_POST['validationmdp'], $_POST['id_client']))
{
	if (!empty($_POST['id_client']))
	{
		$sql = "SELECT * FROM client WHERE id=".$db->quote($_POST['id_client']);
		$result = $db->query($sql);
	}
	else if (!empty($_POST['pseudo_client']))
	{
		$sql = "SELECT * FROM client WHERE pseudo=".$db->quote($_POST['pseudo_client']);
		$result = $db->query($sql);
	}
	

	if (!empty($result))
	{
		$result = $result->fetchAll();
		if (isset($result[0]))
		{
			$client = $result[0];
			$identifiant = $client['id'];

			/*-------------------------------
			Vérification de l'existence du client_ID
			---------------------------------*/

			  	$sql = "SELECT * FROM adresse WHERE client_id='".$identifiant."'";
				//exécution de la requête:
				$infosadresse = $db->query($sql)->fetchAll();

				if (empty($infosadresse))
				{

					// insérer une ligne avec la client id = id de l'utilisateur
			        $request1 ="INSERT INTO adresse (id, client_id, type_adresse, street, zipcode, city, country) VALUES ('', '".$identifiant."', 'principale', '', '', '', '')";
					$db->exec($request1);

			        $request2 ="INSERT INTO adresse (id, client_id, type_adresse, street, zipcode, city, country) VALUES ('', '".$identifiant."', 'livraison', '', '', '', '')";
			        $db->exec($request2);

			        echo "<div class='alert alert-success'>Vous ajouter à votre profile une adresse principale et une adresse de livraison si vous le souhaitez !</div>";
				}

				require('./admin/modifclient/modif.php');
		}
		else
		{
			$error = "<div class='alert alert-danger' role='alert'>L'identifiant ID ou le pseudo de l'utilisateur n'existe pas !</div>";
		}
	}
	else
	{
		$error = "<div class='alert alert-danger' role='alert'>L'identifiant ID ou le pseudo de l'utilisateur n'existent pas !</div>";
	}
}


/*-----------------------------------------------------
Modification des droits de l'utilisateur
------------------------------------------------------*/


if (isset($_POST['validationperm'], $_POST['id_client']))
{
	if (!empty($_POST['id_client']))
	{
		$sql = "SELECT * FROM client WHERE id=".$db->quote($_POST['id_client']);
		$result = $db->query($sql);
	}
	else if (!empty($_POST['pseudo_client']))
	{
		$sql = "SELECT * FROM client WHERE pseudo=".$db->quote($_POST['pseudo_client']);
		$result = $db->query($sql);
	}
	

	if (!empty($result))
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
		$error = "<div class='alert alert-danger' role='alert'>L'identifiant ID ou le pseudo de l'utilisateur n'existent pas !</div>";
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