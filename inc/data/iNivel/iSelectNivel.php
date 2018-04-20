<?php
	$detalle = $_POST;		
	require_once("../class/Admin.php");
	$obj  = new Admin();
	$data = $obj->getSelectNivel($detalle);	
	$total= $obj->getSelectNivelCount($detalle);	
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