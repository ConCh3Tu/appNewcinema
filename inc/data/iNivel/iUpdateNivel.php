<?php
	$detalle = $_POST;		
	require_once("../class/Admin.php");
	$obj  = new Admin();
	$data = $obj->setUpdateNivel($detalle);		

	echo json_encode(array(
        'success' => true,        
        'data' => $data,
    ));
		
?>