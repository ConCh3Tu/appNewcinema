<?php
	$login = $_POST['login'];
	$clave = $_POST['clave'];
	require_once("class/Usuario.php");
	$obj = new Usuario();
	$obj->login($login,$clave);

?>