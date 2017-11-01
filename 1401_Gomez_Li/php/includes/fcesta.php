<?php

/*
 * libera los contenidos de la cesta.
 */

function clean_cesta() {
    unset($_SESSION['cesta']);
    unset($_SESSION['cesta_len']);
}

/*
 * añade el id de una pelicula a la cesta de la compra
 */

function add_to_cesta($id) {
    if (!in_array($id, $_SESSION['cesta'])) {
        array_push($_SESSION['cesta'], $id);
        return true;
    }
    return false;
}

/*
 * en caso de que el usuario con sesión iniciada quisiera haber comprado un producto que ya compró con anterioridad, lo elimina de la cesta
 * devuelve true en caso de que tuviera que arreglar la cesta de la compra y false en caso contrario
 */

function fix_cesta() {
    $had_to_fix = false; //se retornara este flag y representa si la cesta tuvo que ser arreglada o no. A priori, es false
    if (!isset($_SESSION['username']) or ! isset($_SESSION['cesta'])) {
        return false;
    }
    $path = '../../usuarios/' . $_SESSION['username'] . '/historial.xml';
    include_once "utils.php";
    foreach ($_SESSION['cesta'] as $item) {
        if (history_contains_id($path, $item)) {
            remove_from_cesta($item);
            $had_to_fix = true;
        }
    }
    return $had_to_fix;
}

/*
 * en caso de que el usuario quiera comprar algo que ya compro anteriormente, devuelve False
 * devuelve true si se puede añadir el producto a la cesta o si el usuario no ha iniciado sesion
 * devuelve false en caso de que el usuario no pueda añadir el producto debido a que ya compró el producto anteriormente
 */

function is_valid_compra($id) {
    if (!isset($_SESSION['username']))
        return true;
    $path = '../../usuarios/' . $_SESSION['username'] . '/historial.xml';
    include_once "utils.php";
    return (!history_contains_id($path, $id));
}

/*
 * elimina un elemento de la cesta de la compra
 */

function remove_from_cesta($id) {
    $i = 0;
    foreach ($_SESSION['cesta'] as $product) {
        if ($product == $id) {//si encontramos el elemento lo borramos, arreglamos el array y salimos
            array_splice($_SESSION['cesta'], $i, 1);
            return;
        }
        $i++;
    }
}

/*
 * calcula el precio total de la cesta de la compra
 */

function calculate_total($xml) {
    $total = 0;
    foreach ($_SESSION['cesta'] as $id) {
        $film = $xml->xpath("/catalogo/pelicula[id='$id']")[0];
        $total += floatval($film->precio);
    }
    return $total;
}

?>
