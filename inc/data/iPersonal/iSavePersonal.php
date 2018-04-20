<?php
	$detalle = $_POST;			
	require_once("../class/Personal.php");
	$obj  = new Personal();
	$data = $obj->setInsertPersonal($detalle);		
	$data2  = $obj->setInsertAcceso($detalle);		

	echo json_encode(array(
        'success' => true,        
        'data' => $data,
        'data2' => $data2
    ));
		
?>