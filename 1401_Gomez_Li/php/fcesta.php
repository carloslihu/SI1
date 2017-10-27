<?php

	function clean_cesta(){
		unset($_SESSION['cesta']);
		unset($_SESSION['cesta_len']);
	}

	function add_to_cesta($id){
		if(!in_array ( $id , $_SESSION['cesta'] )){
			array_push($_SESSION['cesta'],$id);
                        return true;
                }
                return false;
	}

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
	function get_prize_of_film($title){
		$xml=simplexml_load_file("../xml/catalogo.xml") or die("Error: Cannot create object");
		$film = $xml->xpath("/catalogo/pelicula[titulo='$titulo']")[0];
		return $film->precio;
	}
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
