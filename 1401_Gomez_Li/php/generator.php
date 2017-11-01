<?php

$x = rand(10, 100);
$array = array(
    'foo' => $x
);
echo json_encode($array);
?>