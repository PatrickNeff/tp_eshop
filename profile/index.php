<?php


$email = '';
$phone = '';

/*-------------------------------
Affichage des infos de profil
---------------------------------*/

if (isset($_SESSION['auth'])) //isset($_GET["id"]))
{
	$identifiant  = intval($_SESSION['auth']); //$_GET["id"]);
	$sql = "SELECT * FROM client WHERE id='".$identifiant."'";
	//exécution de la requête:
	$utilisateur = $db->query($sql)->fetch();
	$email = $utilisateur['email'];
	$phone = $utilisateur['phone'];
	$pass = $utilisateur['password'];


/*-------------------------------
Modification des infos de profil
---------------------------------*/

	if (isset($_POST['validation']))
	{

   		$phonemodif = $_POST["formphone"]; // le tél du formulaire devient la variable $phonemodif
   	    $emailmodif = $_POST["formemail"] ; // l'email du formulaire devient la variable $emailmodif

		// dans la table member, le champ email est remplacé par la variable $email où le champ id vaut la variable $identifiant
		$sql = "UPDATE client SET email = '".$emailmodif."', phone = '".$phonemodif."' WHERE id = '".$identifiant."' " ; 
		//exécution de la requête SQL:
	  	$requete = $db->exec($sql);

		$tab_des_modifs = array();

		if ($email!=$emailmodif)
		{
			$tab_des_modifs[] = $emailmodif;
		}
		if ($phone!=$phonemodif)
		{
			$tab_des_modifs[] = $phonemodif;
		}


		$i=0;
		while (isset($tab_des_modifs[$i]))
		{
			echo "<div class='col-md-12'><p class='ok'>".$tab_des_modifs[$i]." a été modifié dans vos informations personnelles !</p></div>";
			$i++;
		}
	}



/*-------------------------------
Modification du mot de passe
---------------------------------*/


	if (isset($_POST['validationmdp']))
	{
		$amdp=$_POST['ancienpassword'];
		$sql = "SELECT password FROM client WHERE id = '".$identifiant."' ";
		$utilisateur = $db->query($sql)->fetch();

		if ($amdp==$utilisateur['password'])
		{
			$nmdp=$_POST['nouveaupassword'];
			$vmdp=$_POST['confirmpassword'];
			if ($nmdp==$vmdp)
			{
				$sql = "UPDATE client SET password = '".$nmdp."' WHERE id = '".$identifiant."' " ;
				//exécution de la requête SQL:
		  		$requete = $db->exec($sql);
		  		echo "<div class='col-md-12'><p class='ok'>Votre mot de passe a été modifié !</p></div>";
			}
			else
			{
				echo "<div class='col-md-12'><p class='no'>L'ancien mot de passe et le nouveau mot de passe ne sont pas identiques !</p></div>";
			}
		}
		else
		{
			echo "<div class='alert alert-danger' role='alert'>L'ancien mot de passe est incorrect !</div>";
		}
	}

/*-------------------------------
Réactualisation des infos de profil
---------------------------------*/

	// Réactualisation des champs du formulaire
	$sql = "SELECT * FROM client WHERE id='".$identifiant."'";
	//exécution de la requête:
	$utilisateur = $db->query($sql)->fetch();
	$email = $utilisateur['email'];
	$phone = $utilisateur['phone'];
	$pass = $utilisateur['password'];
	require('index.phtml');

}

else
{
	echo "<div class='alert alert-danger' role='alert'>Vous devez vous connecter pour accéder à cette page !</div>";
}



?>

