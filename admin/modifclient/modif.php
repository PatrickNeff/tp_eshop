<?php

/*-------------------------------
Modification des infos de profil
---------------------------------*/
if (isset($_POST['validation']))
{
	// Modification de la table client :

	$phonemodif = trim($_POST["formphone"]); // le tél du formulaire devient la variable $phonemodif
    $emailmodif = trim($_POST["formemail"]); // l'email du formulaire devient la variable $emailmodif

	// dans la table member, le champ email est remplacé par la variable $email où le champ id vaut la variable $identifiant
	$sql1 = "UPDATE client SET email = '".$emailmodif."', phone = '".$phonemodif."' WHERE id = '".$identifiant."' " ; 
	//exécution de la requête SQL:
  	$requete1 = $db->exec($sql1);

  	// Modification de la table adresse principale :
  	$streetmodif = trim($_POST["formstreet"]); 
	$zipmodif = trim($_POST["formzip"]); 
  	$citymodif = trim($_POST["formcity"]); 
    $countrymodif = trim($_POST["formpays"]); 

	// dans la table member, le champ email est remplacé par la variable $email où le champ id vaut la variable $identifiant
	$sql2 = "UPDATE adresse SET street = '".$streetmodif."', zipcode = '".$zipmodif."', city = '".$citymodif."', country = '".$countrymodif."' WHERE client_id = '".$identifiant."' AND type_adresse = 'principale' " ; 
	//exécution de la requête SQL:
  	$requete2 = $db->exec($sql2);


  	// Modification de la table adresse de livraison :
  	$streetmodif2 = trim($_POST["formstreet2"]); 
    $zipmodif2 = trim($_POST["formzip2"]);
  	$citymodif2 = trim($_POST["formcity2"]);
    $countrymodif2 = trim($_POST["formpays2"]);
	// dans la table member, le champ email est remplacé par la variable $email où le champ id vaut la variable $identifiant
	$sql2 = "UPDATE adresse SET street = '".$streetmodif2."', zipcode = '".$zipmodif2."', city = '".$citymodif2."', country = '".$countrymodif2."' WHERE client_id = '".$identifiant."' AND type_adresse = 'livraison' " ; 
	//exécution de la requête SQL:
  	$requete2 = $db->exec($sql2);

	$success="<div class='alert alert-success'>Les modifications ont été sauvegardées</div>";

}

/*-------------------------------
Modification du mot de passe
---------------------------------*/

if (isset($_POST['validationmdp']))
{
	$nmdp = $_POST['nouveaupassword'];
	$vmdp = $_POST['confirmpassword'];

	if ($nmdp==$vmdp)
	{
		$nmdp = trim($_POST['nouveaupassword']);
		$nmdp = password_hash($nmdp, PASSWORD_BCRYPT, ["cost" => 10]);


		$sql = "UPDATE client SET password = '".$nmdp."' WHERE id = '".$identifiant."' " ;
		//exécution de la requête SQL:
  		$requete = $db->exec($sql);
  		echo "<div class='alert alert-success'><p class='ok'>Votre mot de passe a été modifié !</p></div>";
	}
	else
	{
		echo "<div class='alert alert-danger' role='alert'>Les mots de passe ne correspondent pas !</div>";
	}
}


/*-------------------------------
Modification des permissions
---------------------------------*/

if (isset($_POST['validationperm']))
{

	$niveau_perm = $_POST["droits"];

	$sql = "UPDATE client SET permission_id = '".$niveau_perm."' WHERE id = '".$identifiant."' " ;
	//exécution de la requête SQL:
	$requete = $db->exec($sql);

	echo "<div class='alert alert-success'><p class='ok'>Les droits de l'utilisateur ont été modifiés !</p></div>";

}


?>