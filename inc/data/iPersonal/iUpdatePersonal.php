<?php
	$detalle = $_POST;		
	require_once("../class/Personal.php");
	$obj  = new Personal();
	$data = $obj->setUpdatePersonal($detalle);		
	$data2 = $obj->setUpdateAcceso($detalle);		

	echo json_encode(array(
        'success' => true,        
        'data' => $data,
        'data2' => $data2,
    ));
		
?>