<?php
	$detalle = $_POST;		
	require_once("../class/Personal.php");
	$obj  = new Personal();
	$data = $obj->getSelectPersonal($detalle);	
	$total= $obj->getSelectPersonalCount($detalle);	
	if (count($data) == 0) {
		$data = null;
	}
	echo json_encode(array(
        'success' => true,        
        'totalCount' => (int)$total['total'],        
        'totalPagina' => (int)$total['totalp'],        
        'data' => $data
    ));
		

?>