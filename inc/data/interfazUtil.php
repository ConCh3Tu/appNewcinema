<?php
	$id = $_POST['id'];	
	$nm = $_POST['nm'];	
	

	require_once("class/Usuario.php");
	$obj = new Usuario();
	$obj->getGeneroId($id,$nm);

	// print_r($obj);

?>