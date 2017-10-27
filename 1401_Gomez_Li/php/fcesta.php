<?php
	session_start();

	function clean_cesta(){
		unset($_SESSION['cesta']);
		unset($_SESSION['cesta_len']);
	}

	function add_to_cesta($title){
		if(!in_array ( $title , $_SESSION['cesta'] ))
			array_push($_SESSION['cesta'],$title);
	}

	function remove_from_cesta($title){
		$i = 0;
		foreach($_SESSION['cesta'] as $product){
			if($product == $title){//si encontramos el elemento lo borramos, arreglamos el array y salimos
				array_splice($_SESSION['cesta'], $i, 1);
				return;
			}
			$i++;
		}
	}
	/*
	function get_prize_of_film($title){
		$xml=simplexml_load_file("../xml/catalogo.xml") or die("Error: Cannot create object");
		$film = $xml->xpath("/catalogo/pelicula[titulo='$titulo']")[0];
		return $film->precio;
	}
	*/

	function calculate_total($xml){
		$total = 0;
		foreach($_SESSION['cesta'] as $title){
			$film = $xml->xpath("/catalogo/pelicula[titulo='$title']")[0];
			$total += floatval($film->precio);
		}
		return $total;
	}



	/*
	if(!empty($_POST["quantity"])) {
		$productByCode = $db_handle->runQuery("SELECT * FROM tblproduct WHERE code='" . $_GET["code"] . "'");
		$itemArray = array($productByCode[0]["code"]=>array('name'=>$productByCode[0]["name"], 'code'=>$productByCode[0]["code"], 'quantity'=>$_POST["quantity"], 'price'=>$productByCode[0]["price"]));
		
		if(!empty($_SESSION["cart_item"])) {
			if(in_array($productByCode[0]["code"],array_keys($_SESSION["cart_item"]))) {
				foreach($_SESSION["cart_item"] as $k => $v) {
						if($productByCode[0]["code"] == $k) {
							if(empty($_SESSION["cart_item"][$k]["quantity"])) {
								$_SESSION["cart_item"][$k]["quantity"] = 0;
							}
							$_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
						}
				}
			} else {
				$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
			}
		} else {
			$_SESSION["cart_item"] = $itemArray;
		}
	}
	*/

?>

<!--
<div class="product-item">
	<form method="post" action="index.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
	<div class="product-image"><img src="<?php echo $product_array[$key]["image"]; ?>"></div>
	<div><strong><?php echo $product_array[$key]["name"]; ?></strong></div>
	<div class="product-price"><?php echo "$".$product_array[$key]["price"]; ?></div>
	<div><input type="text" name="quantity" value="1" size="2" /><input type="submit" value="Add to cart" class="btnAddAction" /></div>
	</form>
</div>
-->
