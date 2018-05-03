<?php
require_once("Conexion.php");	
class Admin {

	private $nivel = array();		
	private $data = array();
	private $resp = array();
	private $cont;

	
	public function setInsertNivel($data){
		$detalle = $data['m-detalle'];
		$defi    = $data['m-defi'];
		$key     = $data['m-cod'];
		$sql = "INSERT INTO db_nivel (niv_detalle,niv_key,niv_defi) VALUES ('$detalle','$key','$defi') ";			
		$rs=mysqli_query(Conexion::cnx(),$sql);
		if($rs) {
			$sqlS = "SELECT * FROM db_nivel WHERE niv_key = '$key' ";
			$rsS=mysqli_query(Conexion::cnx(),$sqlS);
			$idreg=mysqli_fetch_assoc($rsS);
			$this->resp = $idreg;
		}			
		return $this->resp;	
	}

	public function setUpdateNivel($data){
		$detalle = $data['m-detalle'];
		$defi    = $data['m-defi'];			
		$key     = $data['m-detalle-id'];						
		if ($defi != "") {
			$defi = ", niv_defi = '$defi' ";
		}
		$sql = "UPDATE db_nivel SET niv_detalle = '$detalle' $defi WHERE niv_key = '$key' ";			
		$rs=mysqli_query(Conexion::cnx(),$sql);
		if($rs) {
			$sqlS = "SELECT * FROM db_nivel WHERE niv_key = '$key' ";
			$rsS=mysqli_query(Conexion::cnx(),$sqlS);
			$idreg=mysqli_fetch_assoc($rsS);
			$this->resp = $idreg;			
		}
		return $this->resp;
	}

	public function deleteNivel($data){
		$id = $data['md-id'];									
		$sql = "DELETE FROM db_nivel  WHERE niv_id = '$id' ";			
		$rs=mysqli_query(Conexion::cnx(),$sql);
		if($rs) {		
			$res['id'] = $id;		
			$res['rs'] = $rs;
			$this->resp	=$res;
		}
		return $this->resp;
	}

	public function getSelectNivelCount($data){
		$page_num = $data['page'];
		$search   = $data['n-search'];		
		$condicion= "";			
		$search   = str_replace("'", ' ', $search);
		$rows_page= 4;
		if (isset($search)) {
			$condicion .= " WHERE niv_detalle LIKE '$search%' OR niv_key LIKE '$search%'";
		}
		$sqlNum = "SELECT count(*) AS total FROM db_nivel ". $condicion;			
		$tot = array();
		$rs=mysqli_query(Conexion::cnx(),$sqlNum);	
		$num_total = mysqli_fetch_assoc($rs);					
		$tot['total'] = $num_total['total'];
		if ($tot['total'] > 0) {			
			$tot['totalp'] = ceil($tot['total'] / $rows_page);				
		}				
		$this->cont = $tot;					
		return $this->cont;			
	}
	public function getSelectNivel($data){
		$page_num   = $data['page'];
		$search     = $data['n-search'];
		$condicion  = "";
		$search     = str_replace("'", ' ', $search);
		$rows_page  = 4;
		if (isset($search)) {
			$condicion .= " WHERE niv_detalle LIKE '$search%' OR niv_key LIKE '$search%'";
		}
		$offset = ($page_num - 1) * $rows_page;
		$sql = "SELECT * FROM db_nivel ".$condicion." ORDER BY niv_id ASC LIMIT $offset, $rows_page";			
		$rs=mysqli_query(Conexion::cnx(),$sql);		
		while ($reg=mysqli_fetch_assoc($rs)) {
			$this->nivel[]=$reg;				
		}	
				
		return $this->nivel;		
	}

}

?>
