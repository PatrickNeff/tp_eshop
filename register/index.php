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
if (isset($_POST['street'])) { $street = $_POST["street"]; }
else { $street = ""; }
if (isset($_POST['zipcode'])) { $zipcode = $_POST["zipcode"]; }
else { $zipcode = ""; }
if (isset($_POST['city'])) { $city = $_POST["city"]; }
else { $city = ""; }
if (isset($_POST['country'])) { $country = $_POST["country"]; }
else { $country = ""; }
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
                    "street" => "street",
                    "zipcode" => "zipcode",
                    "city" => "city",
                    "country" => "country",
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
        // vérif si le champs street ne contient que des lettres, des chiffres, tiret, apostrophes et espaces
        if (isset($_POST['street'])) {
            if (!preg_match("/^[A-Za-z0-9' -]{0,64}$/", $street )) {
                $badFormat[] = "street";
            }
        }
            // vérif si le champs zipcode ne contient que des chiffres et 5 au max
        if (isset($_POST['zipcode'])) {
            if ((strlen($zipcode) > 5)) { //|| (!is_nan($zipcode) )) {
                $badFormat[] = "zipcode";
            }
        }
        // vérif si le champs city ne contient que des lettres, tiret, apostrophes et espaces
        if (isset($_POST['city'])) {
            if (!preg_match("/^[A-Za-z' -]{0,32}$/", $city )) {
                $badFormat[] = "city";
            }
        }
        // vérif si le champs country ne contient que des lettres, tiret, apostrophes et espaces
        if (isset($_POST['country'])) {
            if (!preg_match("/^[A-Za-z' -]{0,32}$/", $country )) {
                $badFormat[] = "country";
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
        $street = trim($street);
        $zipcode = trim($zipcode);
        $city = trim($city); 
        $country = trim($country);
        $phone = trim($phone);
        $id_groupe = 1;// Défaut groupe avec permissions minimales

    	/*** verif doublon ***/ 
        $request2 = $db->query("SELECT COUNT(*) AS loginMatch FROM member WHERE pseudo = ".$db->quote($login))->fetch(PDO::FETCH_ASSOC);
        if ($request2['loginMatch'] > 0)
        {
            $message = '<div class="alert alert-danger" role="alert">Login déjà existant, veuillez en choisir un autre</div>'; 
            $champsOK = false;
        }
        if ($champsOK == true)
        {
            /*** formattage 2 : insertion avec pdo::quote qui vas gérer les quotes qui peuvent trainer ***/
            $request = 'INSERT INTO member(pseudo, password, civility, firstname, lastname, email, street, zipcode, city, country, phone, id_groupe, time_register) 
                        VALUES('. $db->quote($login)     .', 
                               '. $db->quote($password)  .', 
                               '. $db->quote($civility)  .', 
                               '. $db->quote($firstname) .', 
                               '. $db->quote($lastname)  .', 
                               '. $db->quote($email)     .',                       
                               '. $db->quote($street)    .', 
                               '. $db->quote($zipcode)   .', 
                               '. $db->quote($city)      .', 
                               '. $db->quote($country)   .', 
                               '. $db->quote($phone)     .',
                               '.$id_groupe.', 
                                NOW() )';
            // faire un strtotime quand on récupère la donnée
            $db->exec($request);
            $_SESSION['message'] = '<div class="alert alert-success" role="alert">Vous avez bien été enregistré</div>';
            header('Location: index.php?page=process');
            die();
        }
    }
}
$captchaGen = captcha(); // Captcha affiché dans le formulaire + ajout champ POST caché pour comparaison
require('index.phtml');
?>