<?php
// ================= Listes des fonctions du site =================
// Fil d'ariane
function fil(&$titres, $separateur = ' <strong>&rsaquo;</strong> ')
{
	$baseUrl = 'http://' . $_SERVER['HTTP_HOST'];
	$retour = '<a href="">Home</a>';
	$chemin = explode("/", substr($_SERVER['PHP_SELF'], 1));

	if (is_array($chemin))
	{
		foreach ($chemin as $k=>$v)
		if ($titres[$v] !== false)
		{
			$baseUrl .= "/$v";
			$titre = isset($titres[$v]) ? $titres[$v] : $v;
			if ($titres[$v] == 'index')
			{
				$retour .= $separateur . 'Lecture de la page';
			}
			else
			{
				$retour .= $separateur . '<a href=' . append_sid($baseUrl) . '>' . $titre . '</a>';
			}
		}
	}
	return $retour;
}
$titres = array(
	'inscription' => 'Inscription',
	'index.php' => 'index');
//___________________________
//Limite nombre de caractères
function limite($nb_max, $chaine)
{
	$chaine = substr($chaine,0,$nb_max); 
	$espace = strrpos($chaine," ");
	if((!$espace > 0) OR ($espace > $nb_max))
	{
		$espace = $nb_max;
	} 
	$chaine = substr($chaine,0,$espace)." ...";
	return $chaine;
}
//___________________________
//Temps génération page
function generation()
{
	$temps = microtime();
	$temps = explode(' ', $temps);
	return $temps[1] + $temps[0];
}

/*function visualisationPanier($param)	

{ 	
	if (isset($_SESSION["id"]))
	{
		if ($param > 0)
		{
			require ('buttonpanier.phtml');
		}
	}
}*/


//___________________________
//Pagination
/*
$pagin: page demandée en cliquant dessus, variable $_GET['']
$nbPage: nombre de pages affichées (calculé à partir d'un SELECT COUNT(*))
$nb: nombre de pages affichées au début et à la fin. Ex $nb = 3 => 1,2,3,...,8,9,10 si $nbPage vaut 10
$toward: adresse URL de la page cliquée sous forme $_GET['']
*/
function pagination($pagin, $nbPage, $nb, $toward)
{
	$list_page = array();
	for ($i = 1; $i <= $nbPage; $i++)
	{
			if (($i <= $nb) OR ($i >= $nbPage - $nb) OR (($i < $pagin + $nb) AND ($i > $pagin - $nb)))
			{
				if ($i == $pagin)
				{
					$list_page[] = '<span class="pagin">' . $i . '</span>';
				}
				else
				{
					$list_page[] = '<a class="pagin" href="'.$toward.$i.'#pagination">'.$i.'</a>';
				}
			}
			else
			{
				if ($i >= $nb AND $i <= $pagin - $nb)
				{
					$i = $pagin - $nb;
				}
				elseif ($i >= $pagin + $nb AND $i <= $nbPage - $nb)
				{
					$i = $nbPage - $nb;
				}
			$list_page[] = '...';
			}
	}
	return $list_page;
}
//___________________________
//Timestamp
function systeme_date($date)
{
	if ($date > (time() - 60)) return date('s', time() - $date) . ' sec ago';
	elseif ($date > (time() - 3600)) return date('i', time() - $date) . ' min ago';
	elseif ($date > (time() - 7200)) return 'Since 1 hour ' . date('i', time() - $date) . ' min';
	elseif (date('d.m.Y', $date) == date('d.m.Y', time())) return 'Today at ' . date('H:i', $date);
	elseif (date('d.m.Y', $date) == date('d.m.Y', time() - 86400)) return 'Yesterday at ' . date('H:i', $date);
	else return date('d.m.Y \a\t H:i', $date);
}
//___________________________
//Captcha
function motHasard($n)
{
    $voyelles = array('a', 'e', 'i', 'o', 'u', 'ou', 'io','ou','ai');
    $consonnes = array('b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm','n', 'p', 'r', 's', 't', 'v', 'w',
            'br','bl', 'cr','ch', 'dr', 'fr', 'dr', 'fr', 'fl', 'gr','gl','pr','pl','ps','st','tr','vr');
                            
    $mot = '';
    $nv = count($voyelles)-1;
    $nc = count($consonnes)-1;
    for($i = 0; $i < round($n/2); ++$i)
    {
        $mot .= $voyelles[mt_rand(0,$nv)];
        $mot .= $consonnes[mt_rand(0,$nc)];
    }
    return substr($mot,0,$n); // Comme certaines syllabes font plus d'un caractère, on est obligé de couper pour avoir le nombre exact de caractères.
}
function captcha()
{
	// récup un mot de 6 chiffres ou lettres et mets cette variable en variable de session
    $mot = motHasard(6);
    return $mot;
}
?>