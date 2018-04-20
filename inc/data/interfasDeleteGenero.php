<?php
	$detalle = $_POST;	

	require_once("class/Usuario.php");
	
	$obj = new Usuario();
	$obj->deleteGenero($detalle);

	// print_r($obj);

?>