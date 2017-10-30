<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function print_film($films){
     echo '
                    <div class="gallery">
                        <a href="product.php?id=' . $films->id . '">
                        <img src=' . $films->poster . ' alt="imagen" width="100" height="100">
                    </a>
                        <div class="desc">
                            <a href="product.php?id=' . $films->id . '">
                            <b>' . $films->titulo . '</b>
                        </a>
                            <br>' . $films->director . '</div>
                    </div>';
     return;
}
function print_film_by_id($id, $xml){
    $film = $xml->xpath("/catalogo/pelicula[id='$id']")[0];
    print_film($film);
}

function xml_history_setting($path){
    $xml = new DOMDocument();
    $xml->load($path);
    if($xml->getElementsByTagName('historial')[0])//si estaba creado el xml
        return $xml;
    //si era un xml vacio, creamos el nodo raiz
    $xml_historial = $xml->createElement("historial");
    $xml->appendChild( $xml_historial );

    $xml->save($path);
    return $xml;
}

function add_film_to_history($id, $when, $xml, $path){
    //$xml = simplexml_load_file($path) or die("Error: Cannot create object");
    $xpath = new DOMXPath($xml);
    $root = $xml->getElementsByTagName('historial')[0];
    if(!$root){
        echo "error al añadir pelicula al historial";
        return;
    }
    $node = $xpath->query('//historial/fecha[text()="'.$when.'"]')[0];
    echo '<p>'.var_dump($node).'</p>';
    if(!$node){
        $node = $xml->createElement('fecha');
        $node->nodeValue = $when;
        $root->appendChild($node);
    }
    echo '<p>'.var_dump($node).'</p>';
    $xml_id = $xml->createElement("id");
    $xml_id->nodeValue = $id;
    $node->appendChild( $xml_id );

    $xml->save($path);
    return $xml;
}

function history_contains_id($path, $id){
    $xml = new DOMDocument();
    $xml->load($path);
    $xpath = new DOMXPath($xml);
    foreach($xml->getElementsByTagName('id') as $elem){
        if($elem == $id) return true;
    }
    return false;
}

?>