<?php
	$titulo = $_POST;	

	require_once("class/Usuario.php");
	
	$obj = new Usuario();
	$obj->InsertPelicula($titulo);

	// print_r($obj);

?>