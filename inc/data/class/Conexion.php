<?php
	session_start();
	class Conexion {
		public static function cnx()
		{			
			$cnn=mysql_connect("localhost","root","root");
				 mysql_query("SET NAMES utf8");
				 mysql_select_db("videocine"); 			
			return $cnn;
		}
	}
?>


