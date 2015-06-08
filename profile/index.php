<?php


$email = '';
$phone = '';

/*-------------------------------
Affichage des infos de profil
---------------------------------*/

if (isset($_SESSION['id'])) //isset($_GET["id"]))
{
	$identifiant  = $db->quote(intval($_SESSION['id'])); //$_GET["id"]);



/*-------------------------------
Vérification de l'existence du client_ID
---------------------------------*/

  	$sql = "SELECT * FROM adresse WHERE client_id=".$identifiant."";
	//exécution de la requête:
	$infosadresse = $db->query($sql)->fetchAll();

	


	if (empty($infosadresse))
	{

		// insérer une ligne avec la client id = id de l'utilisateur
        $request1 ="INSERT INTO adresse (id, client_id, type_adresse, street, zipcode, city, country) VALUES ('', ".$identifiant.", 'principale', '', '', '', '')";
		$db->exec($request1);

        $request2 ="INSERT INTO adresse (id, client_id, type_adresse, street, zipcode, city, country) VALUES ('', ".$identifiant.", 'livraison', '', '', '', '')";
        $db->exec($request2);

        echo "<div class='alert alert-success'>Vous ajouter à votre profile une adresse principale et une adresse de livraison si vous le souhaitez !</div>";
	}


/*-------------------------------
Modification des infos de profil
---------------------------------*/

	if (isset($_POST['validation']))
	{


		// Modification de la table client :

   		$phonemodif = $db->quote(trim($_POST["formphone"])); // le tél du formulaire devient la variable $phonemodif
   	    $emailmodif = $db->quote(trim($_POST["formemail"])); // l'email du formulaire devient la variable $emailmodif

		// dans la table member, le champ email est remplacé par la variable $email où le champ id vaut la variable $identifiant
		$sql1 = "UPDATE client SET email = ".$emailmodif.", phone = ".$phonemodif." WHERE id = ".$identifiant." " ; 
		//exécution de la requête SQL:
	  	$requete1 = $db->exec($sql1);



	  	// Modification de la table adresse principale :

	  	$streetmodif = $db->quote(trim($_POST["formstreet"])); 
   	    $zipmodif = $db->quote(trim($_POST["formzip"])); 
	  	$citymodif = $db->quote(trim($_POST["formcity"])); 
   	    $countrymodif = $db->quote(trim($_POST["formpays"])); 

		// dans la table member, le champ email est remplacé par la variable $email où le champ id vaut la variable $identifiant
		$sql2 = "UPDATE adresse SET street = ".$streetmodif.", zipcode = ".$zipmodif.", city = ".$citymodif.", country = ".$countrymodif." WHERE client_id = ".$identifiant." AND type_adresse = 'principale' " ; 
		//exécution de la requête SQL:
	  	$requete2 = $db->exec($sql2);


	  	// Modification de la table adresse de livraison :

	  	$streetmodif2 = $db->quote(trim($_POST["formstreet2"])); 
   	    $zipmodif2 = $db->quote(trim($_POST["formzip2"]));
	  	$citymodif2 = $db->quote(trim($_POST["formcity2"]));
   	    $countrymodif2 = $db->quote(trim($_POST["formpays2"]));

		// dans la table member, le champ email est remplacé par la variable $email où le champ id vaut la variable $identifiant
		$sql2 = "UPDATE adresse SET street = ".$streetmodif2.", zipcode = ".$zipmodif2.", city = ".$citymodif2.", country = ".$countrymodif2." WHERE client_id = ".$identifiant." AND type_adresse = 'livraison' " ; 
		//exécution de la requête SQL:
	  	$requete2 = $db->exec($sql2);

	  	echo ("<div class='alert alert-success'>Vos informations personnelles ont été modifiées !</div>");
	}




/*-------------------------------
Modification du mot de passe
---------------------------------*/

		if (isset($_POST['validationmdp']))
		{
			$amdp = $_POST['ancienpassword'];
			$sql = "SELECT * FROM client WHERE id=".$identifiant."";
			$client= $db->query($sql)->fetch();
			$mdpbdd = $client['password'];

			if (password_verify($amdp, $mdpbdd ))
			{
				$nmdp = $_POST['nouveaupassword'];
				$vmdp = $_POST['confirmpassword'];


				if ($nmdp==$vmdp)
				{
					$nmdp = password_hash($nmdp, PASSWORD_BCRYPT, ["cost" => 10]);
					$sql = "UPDATE client SET password = ".$db->quote($nmdp)." WHERE id = ".$identifiant." " ;
					//exécution de la requête SQL:

			  		$requete = $db->exec($sql);

			  		echo "<div class='alert alert-success'>Le nouveau mot de passe a été sauvegardée !</div>";;
				}
				else
				{
					echo "<div class='alert alert-danger' role='alert'>Les mots de passe ne correspondent pas !</div>";
				}
			}
			else
			{
				echo "<div class='alert alert-danger' role='alert'>L'ancien mot de passe est erroné !</div>";
			}
		}

/*-------------------------------
Réactualisation des infos de profil
---------------------------------*/

	// Réactualisation des champs du formulaire

	$sql = "SELECT * FROM client WHERE id=".$identifiant."";
	//exécution de la requête:
	$utilisateur = $db->query($sql)->fetch();
	$email = $utilisateur['email'];
	$phone = $utilisateur['phone'];
	$pass = $utilisateur['password'];

	$sql = "SELECT * FROM adresse WHERE client_id=".$identifiant." AND type_adresse = 'principale'";
	//exécution de la requête:
	$utilisateur = $db->query($sql)->fetch();
	$street = $utilisateur['street'];
	$zipcode = $utilisateur['zipcode'];
	$city = $utilisateur['city'];
	$country = $utilisateur['country'];

	$sql = "SELECT * FROM adresse WHERE client_id=".$identifiant." AND type_adresse = 'livraison'";
	//exécution de la requête:
	$utilisateur = $db->query($sql)->fetch();
	$street2 = $utilisateur['street'];
	$zipcode2 = $utilisateur['zipcode'];
	$city2 = $utilisateur['city'];
	$country2 = $utilisateur['country'];

	require('index.phtml');

}

else
{
	echo "<div class='alert alert-danger' role='alert'>Vous devez vous connecter pour accéder à cette page !</div>";
}



?>