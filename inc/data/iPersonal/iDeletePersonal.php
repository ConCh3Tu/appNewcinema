<?php
	$detalle = $_POST;		
	require_once("../class/Personal.php");
	$obj  = new Personal();
	$data = $obj->deletePersonal($detalle);	
	$data2 = $obj->deleteAcceso($detalle);	


	echo json_encode(array(
        'success' => true,        
        'data2' => $data,
        'data' => $data2,
    ));
		
?>