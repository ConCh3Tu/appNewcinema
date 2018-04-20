<?php
require_once("Conexion.php");	
class Personal {

	private $nivel = array();		
	private $data  = array();
	private $resp  = array();
	private $acceso= array();
	private $cont;

	
	public function setInsertPersonal($data){
		$nombre= $data['nombre'];
		$apellido= $data['apellido'];
		$documento= $data['documento'];
		$codigo= $data['codigo'];		

		$sql = "INSERT INTO db_personal (prs_nombre,prs_apellido,prs_documendo,prs_codigo) VALUES ('$nombre','$apellido','$documento','$codigo') ";			
		$rs=mysql_query($sql,Conexion::cnx());
		if($rs) {
			$sqlS = "SELECT * FROM db_personal WHERE prs_codigo = '$codigo' ";
			$rsS=mysql_query($sqlS,Conexion::cnx());
			$idreg=mysql_fetch_assoc($rsS);
			$this->resp = $idreg;
		}			
		return $this->resp;	
	}
	public function setInsertAcceso($data){
		$login = $data['login'];
		$clave = $data['clave'];
		$codigo= $data['codigo'];
		$nivel = $data['nivel'];

		$sql = "INSERT INTO db_acceso (acc_login,acc_clave,acc_personal,acc_nivel) VALUES ('$login',PASSWORD('$clave'),'$codigo',$nivel) ";			
		$rs=mysql_query($sql,Conexion::cnx());
		if($rs) {
			$sqlS = "SELECT * FROM db_acceso INNER JOIN db_nivel ON db_acceso.acc_nivel = db_nivel.niv_id WHERE acc_personal = '$codigo' ";

			$rsS=mysql_query($sqlS,Conexion::cnx());
			$idreg=mysql_fetch_assoc($rsS);
			$this->acceso = $idreg;
		}			
		return $this->acceso;	
	}	

	public function setUpdatePersonal($data){
		$nombre= $data['nombre'];
		$apellido= $data['apellido'];
		$documento= $data['documento'];
		$codigo= $data['codigo'];
		
		$sql = "UPDATE db_personal SET prs_nombre = '$nombre', prs_apellido = '$apellido', prs_documendo = '$documento' WHERE prs_codigo = '$codigo' ";			
		$rs=mysql_query($sql,Conexion::cnx());
		if($rs) {
			$sqlS = "SELECT * FROM db_personal WHERE prs_codigo = '$codigo' ";
			$rsS=mysql_query($sqlS,Conexion::cnx());
			$idreg=mysql_fetch_assoc($rsS);
			$this->resp = $idreg;			
		}
		return $this->resp;
	}
	public function setUpdateAcceso($data){
		$login = $data['login'];
		$clave = $data['clave'];
		$codigo= $data['codigo'];
		$nivel = $data['nivel'];
		$accid = $data['accid'];
									
		if ($clave != "") {
			$clave = ", acc_clave = PASSWORD('$clave') ";
		}
		$sql = "UPDATE db_acceso SET acc_login = '$login', acc_nivel = $nivel $clave WHERE acc_id = $accid ";			
		$rs=mysql_query($sql,Conexion::cnx());
		if($rs) {
			$sqlS = "SELECT * FROM db_acceso  INNER JOIN db_nivel ON db_nivel.niv_id = db_acceso.acc_nivel  WHERE acc_id = $accid ";
			$rsS=mysql_query($sqlS,Conexion::cnx());
			$idreg=mysql_fetch_assoc($rsS);
			$this->acceso = $idreg;			
		}
		return $this->acceso;
	}	

	public function deletePersonal($data){
		$id = $data['md-cd'];									
		$sql = "DELETE FROM db_personal  WHERE prs_codigo = '$id' ";			
		$rs=mysql_query($sql,Conexion::cnx());
		if($rs) {		
			$res['id'] = $id;		
			$res['rs'] = $rs;
			$this->resp	=$res;
		}
		return $this->resp;
	}
	public function deleteAcceso($data){
		$id = $data['md-id'];									
		$sql = "DELETE FROM db_acceso  WHERE acc_id = '$id' ";			
		$rs=mysql_query($sql,Conexion::cnx());
		if($rs) {		
			$res['id'] = $id;		
			$res['rs'] = $rs;
			$this->acceso=$res;
		}
		return $this->acceso;
	}

	public function getSelectPersonalCount($data){
		$page_num = $data['page'];
		$search   = $data['p-search'];		
		$condicion= "";			
		$search   = str_replace("'", ' ', $search);
		$rows_page=10;
		if (isset($search)) {
			$condicion .= " WHERE prs.prs_nombre LIKE '$search%' OR acc.acc_login LIKE '$search%'";			
		}
		$sqlNum = "SELECT count(*) as total FROM (db_acceso acc INNER JOIN db_personal prs ON prs.prs_codigo = acc.acc_personal) INNER JOIN db_nivel niv ON niv.niv_id = acc.acc_nivel". $condicion;			
		$tot = array();		
		$rs=mysql_query($sqlNum,Conexion::cnx());	
		$num_total = mysql_fetch_assoc($rs);					
		$tot['total'] = $num_total['total'];
		if ($tot['total'] > 0) {			
			$tot['totalp'] = ceil($tot['total'] / $rows_page);				
		}				
		$this->cont = $tot;					
		return $this->cont;			
	}
	public function getSelectPersonal($data){
		$page_num   = $data['page'];
		$search     = $data['p-search'];
		$condicion  = "";
		$search     = str_replace("'", ' ', $search);
		$rows_page  = 10;

		if (isset($search)) {
			$condicion .= " WHERE prs.prs_nombre LIKE '$search%' OR acc.acc_login LIKE '$search%'";
		}
		$offset = ($page_num - 1) * $rows_page;
		$sql = "SELECT prs.prs_nombre, prs.prs_apellido, prs.prs_documendo, acc.acc_id, acc.acc_personal, acc.acc_login, niv.niv_id ,niv.niv_detalle FROM (db_acceso acc INNER JOIN db_personal prs ON prs.prs_codigo = acc.acc_personal) INNER JOIN db_nivel niv ON niv.niv_id = acc.acc_nivel ".$condicion." ORDER BY prs.prs_id ASC LIMIT $offset, $rows_page";			
		$rs=mysql_query($sql,Conexion::cnx());		
		while ($reg=mysql_fetch_assoc($rs)) {
			$this->nivel[]=$reg;				
		}				
		return $this->nivel;		
	}

}

?>
