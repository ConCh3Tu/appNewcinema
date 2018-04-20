<?php
	$detalle = $_POST;	

	require_once("class/Usuario.php");
	
	$obj = new Usuario();
	$obj->insertGenero($detalle);

	// print_r($obj);

?>