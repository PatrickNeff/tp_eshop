<?php
class panier{

	private $db;

	function __construct($db){
		if(!isset($_SESSION)){
			session_start();
		}
		if(!isset($_SESSION['panier'])){
			$_SESSION['panier'] = array();
		}
		$this->db = $db;

		if(isset($_GET['delPanier'])){
			$this->del($_GET['delPanier']);
		}
		if(isset($_POST['panier']['quantity'])){
			$this->recalc();
		}
	}

	function recalc(){
		foreach($_SESSION['panier'] as $product_id => $quantity){
			if(isset($_POST['panier']['quantity'][$product_id])){
				$_SESSION['panier'][$product_id] = $_POST['panier']['quantity'][$product_id];
			}
		}
	}

	function count(){
		return array_sum($_SESSION['panier']);
	}

	function total(){
		$total = 0;
		$ids = array_keys($_SESSION['panier']);
		if(empty($ids)){
			$product = array();
		}else{
			$product = $this->db->query('SELECT id, price FROM product WHERE id IN ('.implode(',',$ids).')');
		}
		foreach( $product as $product ) {
			$total += $product->price * $_SESSION['panier'][$product->id];
		}
		return $total;
	}

	function add($product_id){
		if(isset($_SESSION['panier'][$product_id])){
			$_SESSION['panier'][$product_id]++;
		}else{
			$_SESSION['panier'][$product_id] = 1;
		}
	}

	function del($product_id){
		unset($_SESSION['panier'][$product_id]);
	}

}