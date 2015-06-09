<?php
var_dump($_POST);


// ON ne récupère pas encore la variable.
// var_dump($order);


$action ="DELETE * FROM order_item WHERE id=" .$id;



// Redirection vers index.php?page=panier&order_id=6;
header('Location: index.php?page=panier&order_id=6');
?>

