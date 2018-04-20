<?php 
	session_start();	
	session_destroy();
	//devuelvo al usuario al formulario
	header("Location: ../../video.php");
	/*
	echo "<script type='text/javascript'> window.location='index.php'; </script>'";
	*/
?>