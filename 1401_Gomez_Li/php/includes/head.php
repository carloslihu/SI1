<?php
// Start the session
session_start();
if(!isset($_SESSION['cesta'])){
	$_SESSION['cesta'] = array();
	$_SESSION['cesta_len'] = 0;
}
echo '
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../css/mystyle.css?'.time().'">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta charset="UTF-8">
    <title>
        Tienda de DvDs
    </title>
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script> 
    <script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="../javascript/register.js"></script>
    <script type="text/javascript" src="../javascript/utils.js"></script>
    <script type="text/javascript" src="../javascript/toggle_script.js"></script>';
    ?>
