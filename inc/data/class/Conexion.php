<?php
	session_start();
	class Conexion {
		public static function cnx()
		{			
			$cnn=mysql_connect("mysql","oscar","Ch3Tu");
				 mysql_query("SET NAMES utf8");
				 mysql_select_db("sampledb"); 			
			return $cnn;
		}
	}
?>