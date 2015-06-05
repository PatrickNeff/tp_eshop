<?php
require('./admin/menu.php');
require('./admin/menu.phtml');


if (isset($_POST['id_client'])) 
{
	if (!empty($_POST['id_client']))
	{
		$id_utilisateur  = $_POST['id_client'];
		$sql = "SELECT * FROM client WHERE id='".$id_utilisateur."'";
		$tab1 = $db->query($sql)->fetchAll();
		if (!empty($tab1))
		{
			$identifiant  = $tab1[0]['id'];
			require('./admin/modifclient/modif.php');
		}
		else
		{
			echo "<div class='alert alert-danger' role='alert'>L'identifiant ID ou le pseudo de l'utilisateur n'existe pas !</div>";
		}
	}
}
elseif (isset($_POST['pseudo_client']))
{
	if (!empty($_POST['pseudo_client']))
	{
		$pseudo_utilisateur  = $_POST['pseudo_client'];
		$sql = "SELECT * FROM client WHERE pseudo='".$pseudo_utilisateur."'";
		$tab2 = $db->query($sql)->fetchAll();
		if (!empty($tab2))
		{
			$identifiant  = $tab2[0]['id'];
			require('./admin/modifclient/modif.php');
		}
		else
		{
			echo "<div class='alert alert-danger' role='alert'>L'identifiant ID ou le pseudo de l'utilisateur n'existe pas !</div>";
		}	
	}
}
else
{
	echo "<div class='alert alert-danger' role='alert'>L'identifiant ID ou le pseudo de l'utilisateur n'existe pas !</div>";
}




require('./admin/modifclient/index.phtml');
?>