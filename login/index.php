<?php
$login = '';
$password = '';
$message = ''; // Contient les messages d'erreur à afficher
if (isset($_POST['log-in']))
{ 
    if (isset($_POST['login'])) { $login = $_POST["login"];}
    if (isset($_POST['password'])) { $password = $_POST["password"];}
	// booléen de vérif
    $champsOK = true;
    // tableau des champs obligatoires vides
    $tabVide = array();
    // tableau des champs incorrects
    $badFormat = array();
    // tableau des champs à controler
    $labels = array("login" => "login",
                    "password" => "password");
    // vérif 1 : vérif des champs vides
    foreach ($_POST as $champ => $valeur)
    {
        // vérification des champs vide : Tous les champs obligatoires vides alimenteront le tableau $tabVide
        if ($champ == "login" || $champ == "password") {
            if ($valeur == "")
            {
                $tabVide[] = $champ;
            }
        }
    }
    // si il y a des champs obligatoires vides
    if (sizeof($tabVide) > 0)
    {
        $message = '<div class="alert alert-danger" role="alert">Tous les champs obligatoires n\'ont pas été saisie. veuillez saisir : <br />';
        foreach ($tabVide as $valeur2) {
            $message .= $labels[$valeur2].'<br />';
        }
        $message .= '</div>';      
        $champsOK = false;
    }
    // vérif 2 : vérif du format des champs
    if ($champsOK == true)
    { 
        if (isset($_POST['login'])) {
            if (!preg_match("/^[A-Za-z0-9' -]{1,32}$/", $_POST['login'])) {
                $badFormat[] = "login";
            }
        }
        if (sizeof($badFormat) > 0) {
            $message =  '<div class="alert alert-danger" role="alert">Certains champs contiennent des données invalides. veuillez ressaisir les champs : <br />';
            foreach ($badFormat as $valeur3) {
                $message .= $labels[$valeur3].'<br />';
            }
            $message .= '</div>';                
            $champsOK = false;
        }
    }
    if ($champsOK == true)
    { 
		// recherche le login dans la table membre
	    $requestLogin = $db->query("SELECT COUNT(*) AS loginMatch, client.id, client.password, permission.perms AS mypermissions FROM client, permission WHERE client.permission_id = permission.id_permission AND pseudo = ".$db->quote($login))->fetch(PDO::FETCH_ASSOC);
        if ($requestLogin['loginMatch'] == 1) // Login correspond, Ne paut valoir que 1 ou 0 car plusieurs logins identiques impossible car verif au register
        {
            $password = trim($password);
            if (password_verify($password,$requestLogin['password']))
            {
               $_SESSION["auth"]= true;
               $_SESSION["login"] = $login;
               $_SESSION["id"] = $requestLogin['id'];
               $_SESSION["permissions"] = $requestLogin['mypermissions'];
               $_SESSION['message'] = '<div class="alert alert-success" role="alert">Vous êtes maintenant connecté</div>';
               header('Location: index.php?page=process');
               die();
            }
            else
            {
                $message = '<div class="alert alert-danger" role="alert">Le mot de passe est incorrect</div>';
            }
        }
        else // Login correspond pas
        {
            $message = '<div class="alert alert-danger" role="alert">Le pseudo est incorrect</div>'; 
        }
    }
}
require('index.phtml');
?>