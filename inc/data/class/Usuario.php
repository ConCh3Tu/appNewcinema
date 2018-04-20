<?php
	require_once("Conexion.php");	
	class Usuario {

		private $nivel = array();
		private $nivels = array();
		private $genero = array();
		private $data = array();
		private $cont;


		public function login($log,$clv) {			

			if (empty($log) or empty($clv)  ) {
				$data['error'] = "se requieren login y clave";				
			}else {
				$sql = "SELECT * FROM db_acceso WHERE acc_login = '".$log."' and acc_clave= PASSWORD('$clv')";
				
				$rs = mysql_query($sql,Conexion::cnx());				
				if (mysql_num_rows($rs) == 0) {
					$data['error'] = "Los datos no coinciden o no esta habilitado";
					$data['op']	= 1;														
				}else{
					if ($reg=mysql_fetch_array($rs)) {
						$_SESSION['user'] = $reg['acc_login'];
						$_SESSION['nivel'] = $reg['acc_nivel'];
						$_SESSION['iduser'] = $reg['acc_id'];						
						$data['self'] = "movie.php";												
						$data['success'] = true;	
						$data['op']	= 1;															
					}else{
						$data['error'] = "ocurrio un problema  comuniquese con el administrador";			
						$data['op']	= 0;
					}
				}
			}
 			echo json_encode($data);			
		}
		public function nivelSelect() {
			$sql = "SELECT * FROM db_nivel";
			$rs=mysql_query($sql,Conexion::cnx());
			while ($reg=mysql_fetch_assoc($rs)) {
				$this->nivels[]=$reg;				
			}				
			
			return $this->nivels;
		}		
		public function nivel() {
			$sql = "SELECT * FROM db_nivel WHERE niv_id = '".$_SESSION['nivel']. "'";
			$rs=mysql_query($sql,Conexion::cnx());
			if ($reg=mysql_fetch_assoc($rs)) {
				$this->nivel[]=$reg;
			}
			return $this->nivel;
		}
		public function getGenero() {					
			$rs=mysql_query($sqlc,Conexion::cnx());		
			$sql = "SELECT * FROM db_genero";
			$rs=mysql_query($sql,Conexion::cnx());		
			while ($reg=mysql_fetch_assoc($rs)) {
				$this->genero[]=$reg;				
			}									
			return $this->genero;
		}

		public function getGeneroPaginacion($page) {			
			$sqlNum = "SELECT count(*) AS total FROM db_genero";			
			$rs=mysql_query($sqlNum,Conexion::cnx());	
			$num_tatal = mysql_fetch_assoc($rs);					

			if ($num_tatal['total'] > 0) {			
				$rows_page = 4;
				$page_num = 1;
				if (isset($page)) {					
					$page_num = $page;
				}
				$offset = ($page_num - 1) * $rows_page;
				$total_paginas = ceil($num_tatal['total'] / $rows_page);				

				$links = "";
				$dlink = array();

				if ($total_paginas >= 1) {				
    				if ($page_num != 0) {    					
    					$datalink['previous'] = ($page_num-1);
    					for ($i=1; $i <= $total_paginas ; $i++) { 
    					 	if ($page_num == $i) {
    							$datalink['pag'][$i] = $i;
    					 	}else {
    							$datalink['pag'][$i]= 0;
    					 	}
    					}
    					if ($page_num != $total_paginas) {
    						$datalink['next'] = ($page_num+1);
    					}
    				}
				}
			
				$sql = "SELECT * FROM db_genero LIMIT $offset, $rows_page";			
				$rs=mysql_query($sql,Conexion::cnx());		
				while ($reg=mysql_fetch_assoc($rs)) {
					$this->genero[]=$reg;				
				}			
				$dlink['gro_detalle'] = $datalink;
				$dlink['success'] = 1;
				// $dlink['data'] = json_encode($datalink);
				$this->genero['link']=$dlink;						
				$this->genero['err']=$dlink;						
			}else {
				$dlink['success'] = 0;
				$this->genero['err']=$dlink;						
			}
			return $this->genero;
		}	
		public function getGeneroListCount($data){
			$page   = $data['page'];
			$search = $data['g-search'];
			
			$condicion = "";			
			$search = str_replace("'", ' ', $search);
			if (isset($search)) {
				$condicion .= " WHERE gro_detalle LIKE '$search%' OR gro_key LIKE '$search%'";
			}
			$sqlNum = "SELECT count(*) AS total FROM db_genero ". $condicion;			
			$tot = array();
			$rs=mysql_query($sqlNum,Conexion::cnx());	
			$num_total = mysql_fetch_assoc($rs);					
			$tot['total'] = $num_total['total'];
			if ($tot['total'] > 0) {
				$rows_page =10;
				$page_num = 1;
				if (isset($page)) {					
					$page_num = $page;
				}
				$tot['totalp'] = ceil($tot['total'] / $rows_page);				
			}				
			$this->cont = $tot;					
			return $this->cont;			
		}		
		public function getGeneroList($data) {
			$page   = $data['page'];
			$search = $data['g-search'];
			$condicion = "";
			$search = str_replace("'", ' ', $search);

			if (isset($search)) {
				$condicion .= " WHERE gro_detalle LIKE '$search%' OR gro_key LIKE '$search%'";
			}
			$sqlNum = "SELECT count(*) AS total FROM db_genero ". $condicion;			

			$rs=mysql_query($sqlNum,Conexion::cnx());	
			$num_total = mysql_fetch_assoc($rs);					
			$total = $num_total['total'];

			if ($total > 0) {

				$rows_page =10;
				$page_num = 1;
				if (isset($page)) {					
					$page_num = $page;
				}

				$offset = ($page_num - 1) * $rows_page;

				$sql = "SELECT * FROM db_genero ".$condicion." ORDER BY gro_id ASC LIMIT $offset, $rows_page";			
				$rs=mysql_query($sql,Conexion::cnx());		
				while ($reg=mysql_fetch_assoc($rs)) {
					$this->genero[]=$reg;				
				}				

				return $this->genero;

			}else {

			}

		}
		public function getGeneroId($id,$nm) {						
			$dataGro = array();
			$sql = "SELECT CONCAT(SUBSTRING(g.gro_detalle, 1,1),'-', p.pel_codigo) AS cod, (p.pel_codigo + 0) AS nextCod FROM db_pelicula p INNER JOIN db_genero g ON p.pel_genero = g.gro_id WHERE g.gro_id = $id ORDER BY p.pel_codigo DESC LIMIT 0,1";
			// echo $sql;
			$rs=mysql_query($sql,Conexion::cnx());		
			$reg=mysql_fetch_assoc($rs);
			if ($reg == '') {
				$nm = substr($nm,0,1)."-0000";
				$reg = array('cod' => $nm, 'nextCod' => 0 );
				$this->genero[] = $reg;								
			}else {			
				$this->genero[] = $reg;								
			}
			$dataGro['genero'] = $this->genero;
			echo json_encode($dataGro);
			
			
		
		}
		public function insertGenero($data){
			$detalle = $data['m-detalle'];
			$key     = $data['m-cod'];
			$defi    = $data['m-defi'];
			$sql = "INSERT INTO db_genero (gro_detalle,gro_key,gro_defi) VALUES ('$detalle','$key','$defi') ";			
			$rs=mysql_query($sql,Conexion::cnx());
			if($rs) {
				$sqlS = "SELECT * FROM db_genero WHERE gro_key = '$key' ";
				$rsS=mysql_query($sqlS,Conexion::cnx());
				$idreg=mysql_fetch_assoc($rsS);

				$resp['success'] = true;
				$resp['data'] = $idreg;

			}else {
				$resp['success'] = false;
			}
			echo json_encode($resp);
		}
		public function updateGenero($data){
			$detalle = $data['m-detalle'];
			$key     = $data['m-detalle-id'];						
			$defi    = $data['m-defi'];			
			if ($defi  == "") {
				$defi = "";
			}else {
				$defi = ", gro_defi = '$defi' ";
			}

			$sql = "UPDATE db_genero SET gro_detalle = '$detalle' $defi WHERE gro_key = '$key' ";			
			$rs=mysql_query($sql,Conexion::cnx());
			if($rs) {
				$sqlS = "SELECT * FROM db_genero WHERE gro_key = '$key' ";
				$rsS=mysql_query($sqlS,Conexion::cnx());
				$idreg=mysql_fetch_assoc($rsS);

				$resp['success'] = true;
				$resp['data'] = $idreg;

			}else {
				$resp['success'] = false;
			}
			echo json_encode($resp);
		}
		public function deleteGenero($data){
			$id = $data['md-id'];									
			$sql = "DELETE FROM db_genero  WHERE gro_id = '$id' ";			
			$rs=mysql_query($sql,Conexion::cnx());
			if($rs) {				
				$resp['success'] = true;						
			}else {
				$resp['success'] = false;
			}
			echo json_encode($resp);
		}
		

		public function InsertPelicula($data){

			$titulo =  $data['titulo'];
			$director =  $data['director'];
			$genero =  $data['genero'];
			$anio =  $data['anio'];
			$actor =  $data['actor'];
			$sinopsis =  $data['sinopsis'];
			$url =  $data['url'];
			$cod =  $data['cod'];
			$user =  $_SESSION['iduser'];



			$sql = "INSERT INTO db_pelicula (pel_titulo, pel_director, pel_anio, pel_genero, pel_actor1, pel_poster, pel_sinopsis, pel_codigo, pel_usurio ) VALUES ( '$titulo', '$director', '$anio', $genero, '$actor', '$url', '$sinopsis', $cod, $user )";
			$rs=mysql_query($sql,Conexion::cnx());			
			if($rs) {
				$resp['success'] = true;
			}else {
				$resp['success'] = false;
			}
			echo json_encode($resp);

		}
	}	
?>
