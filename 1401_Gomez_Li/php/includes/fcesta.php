<?php

	/*
	 * libera los contenidos de la cesta.
	*/
	function clean_cesta(){
		unset($_SESSION['cesta']);
		unset($_SESSION['cesta_len']);
	}

	/*
	 * añade el id de una pelicula a la cesta de la compra
	*/
	function add_to_cesta($id){
		if(!in_array ( $id , $_SESSION['cesta'] )){
			array_push($_SESSION['cesta'],$id);
                        return true;
                }
                return false;
	}

	/*
	 * en caso de que el usuario con sesión iniciada quisiera haber comprado un producto que ya compró con anterioridad, lo elimina de la cesta
	 * devuelve true en caso de que tuviera que arreglar la cesta de la compra y false en caso contrario
	*/
	function fix_cesta(){
		if(!isset($_SESSION['username']) or !isset($_SESSION['cesta']))
			return false;

	}

	/*
	 * en caso de que el usuario quiera comprar algo que ya compro anteriormente, devuelve False
	 * devuelve true si se puede añadir el producto a la cesta o si el usuario no ha iniciado sesion
	 * devuelve false en caso de que el usuario no pueda añadir el producto debido a que ya compró el producto anteriormente
	*/
	function is_valid_compra($id){
		
		/*
		if(!isset($_SESSION['username']))
			return true;
		$xml = new DOMDocument();
		$path = '../../usuarios/'.$_SESSION['username'].'/historial.xml';
    	$xml->load($path);
    	$xpath = new DOMXPath($xml);
    	foreach($xml->getElementsByTagName('id') as $elem){
    		if($elem == $id) return false;
    	}
    	return true;
    	*/
	}

	/*
	 * elimina un elemento de la cesta de la compra
	*/
	function remove_from_cesta($id){
		$i = 0;
		foreach($_SESSION['cesta'] as $product){
			if($product == $id){//si encontramos el elemento lo borramos, arreglamos el array y salimos
				array_splice($_SESSION['cesta'], $i, 1);
				return;
			}
			$i++;
		}
	}
	
	/*
	 * calcula el precio total de la cesta de la compra
	*/
	function calculate_total($xml){
		$total = 0;
		foreach($_SESSION['cesta'] as $id){
			$film = $xml->xpath("/catalogo/pelicula[id='$id']")[0];
			$total += floatval($film->precio);
		}
		return $total;
	}

?>
