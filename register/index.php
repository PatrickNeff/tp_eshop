<?php
$message = ''; // Contient les messages d'erreur à afficher
/*** Initialisation des champs ***/
if (isset($_POST['login'])) { $login = $_POST["login"]; }
else { $login = ""; }
if (isset($_POST['civility'])) { $civility = $_POST["civility"]; }
else { $civility = ""; }
if (isset($_POST['firstname'])) { $firstname = $_POST["firstname"]; }
else { $firstname = ""; } 
if (isset($_POST['lastname'])) { $lastname = $_POST["lastname"]; }
else { $lastname = ""; } 
if (isset($_POST['email'])) { $email = $_POST["email"]; }
else { $email = ""; }
if (isset($_POST['phone'])) { $phone = $_POST["phone"]; }
else { $phone = ""; }
$captcha = "";
// booléen de vérif
$champsOK = true;
$captchaOK = true;
// tableau des champs obligatoires vides
$tabVide = array();
// tableau des champs incorrects
$badFormat = array();
if (isset($_POST['register']))
{ 
    // tableau des champs à controler
    $labels = array("login" => "login",
                    "password" => "password",
                    "civility" => "civility",
                    "firstname" => "firstname",
                    "lastname" => "lastname",
                    "email" => "email",
                    "phone" => "phone",                
                    "captcha" => "captcha");
    /*** verif 1 : champs vides ***/
    foreach($_POST as $champ => $valeur)
    {
        //echo $champ . ": " . $valeur . "<br>";
        // vérification des champs vide
        // Tous les champs obligatoires vides alimenteront le tableau $tabVide
        if ($champ == "login" || $champ == "password" || $champ == "civility" || $champ == "firstname" || $champ == "lastname" || $champ == "captcha") {
            if ($valeur == "") {
                $tabVide[] = $champ;
            }
        }
    }
    // si il y a des champs obligatoires vides
    if(sizeof($tabVide) > 0)
    {
        $message = '<div class="alert alert-danger" role="alert">Tous les champs obligatoires n\'ont pas été saisie. veuillez saisir : <br>';
        foreach ($tabVide as $valeur2)
        {
            $message .= $labels[$valeur2].'<br />';
        }
        $message .= '</div>';
        $champsOK = false;
    }
    /*** verif 2 : valeurs incorrextes ***/
    if ($champsOK == true)
    {
        // vérif si le champs login ne contient que des lettres et des chiffres
        if (!preg_match("/^[A-Za-z0-9]{0,32}$/", $login )) {
            $badFormat[] = "login";
        }
        // pas de vérif pour le password, ni l'email, ni la civilité
        // vérif si le champs prénom ne contient que des lettres, tiret, apostrophes et espaces
        if (isset($_POST['nom'])) {
            if (!preg_match("/^[A-Za-z' -]{0,32}$/", $nom )) {
                $badFormat[] = "nom";
            }
        }
        // vérif si le champs prénom ne contient que des lettres, tiret, apostrophes et espaces
        if (isset($_POST['prenom'])) {
            if (!preg_match("/^[A-Za-z' -]{0,32}$/", $prenom )) {
                $badFormat[] = "prenom";
            }
        }
        // vérif si le champs phone ne contient que des chiffres, des espaces, des points et des tirets
        if (isset($_POST['phone'])) {
            if (!preg_match("/^[0-9. -]{0,20}$/", $phone )) {
                $badFormat[] = "phone";
            }
        }
        // si il y a des champs au mauvais format
        if (sizeof($badFormat) > 0) {
            $message = '<div class="alert alert-danger" role="alert">Certains champs contiennent des données invalides. veuillez ressaisir les champs : <br />';
            foreach ($badFormat as $valeur3) {
                $message .= $labels[$valeur3].'<br />';
            }
            $message .= '</div>';
            $champsOK = false;
            // réafficher la page livreor.php
        }
    }
    /*** verif 3 : captcha ***/
    if ($champsOK == true)
    {
        if (isset($_POST['captcha']))
        {
            if ($_POST['captcha'] !== $_POST['captchaGen'])
            {
                $captchaOK = false;
                $message = '<div class="alert alert-danger" role="alert">Captcha erroné</div>';
            }
        }
    }
    if ($captchaOK == false)
    {
        $champsOK = false;
    }
    /*** formattage 1 : trim et htmlspecialchars ***/
    if ($champsOK == true)
    {
        $login = trim($login);
        $password = trim($_POST['password']);
        $password = password_hash($password, PASSWORD_BCRYPT, ["cost" => 10]);        
        $civility = trim($civility); 
        $firstname = trim($firstname);
        $lastname = trim($lastname); 
        $phone = trim($phone);
        $permission_id = 1;// Défaut groupe avec permissions minimales

    	/*** verif doublon ***/ 
        $request2 = $db->query("SELECT COUNT(*) AS loginMatch FROM client WHERE pseudo = ".$db->quote($login))->fetch(PDO::FETCH_ASSOC);
        if ($request2['loginMatch'] > 0)
        {
            $message = '<div class="alert alert-danger" role="alert">Login déjà existant, veuillez en choisir un autre</div>'; 
            $champsOK = false;
        }
        if ($champsOK == true)
        {
            /*** formattage 2 : insertion avec pdo::quote qui vas gérer les quotes qui peuvent trainer ***/
            $request1 = 'INSERT INTO client(pseudo, password, civility, firstname, lastname, email, phone, permission_id, time_register) 
                        VALUES('. $db->quote($login)     .', 
                               '. $db->quote($password)  .', 
                               '. $db->quote($civility)  .', 
                               '. $db->quote($firstname) .', 
                               '. $db->quote($lastname)  .', 
                               '. $db->quote($email)     .',                       
                               '. $db->quote($phone)     .',
                               '. $db->quote($permission_id).',
                                NOW() )';
echo ($request1);

            // faire un strtotime quand on récupère la donnée
            $db->exec($request1);
            $_SESSION['message'] = '<div class="alert alert-success" role="alert">Vous avez bien été enregistré</div>';
            header('Location: index.php?page=process');
            die();
        }
    }
}
$captchaGen = captcha(); // Captcha affiché dans le formulaire + ajout champ POST caché pour comparaison
require('index.phtml');
?>