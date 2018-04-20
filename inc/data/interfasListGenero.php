<?php
	$detalle = $_POST;		
	require_once("class/Usuario.php");
	$obj  = new Usuario();
	$data = $obj->getGeneroList($detalle);	
	$total= $obj->getGeneroListCount($detalle);	


	echo json_encode(array(
        'success' => true,        
        'totalCount' => (int)$total['total'],        
        'totalPagina' => (int)$total['totalp'],        
        'data' => $data,
    ));
	

?>