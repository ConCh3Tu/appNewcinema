

<?php
	session_start();
	class Conexion {
		public static function cnx()
		{			
			$cnn=mysql_connect("localhost","oscar","Ch3Tu123");
				 mysql_query("SET NAMES utf8");
				 mysql_select_db("sampledb"); 			
			return $cnn;
		}
	}
?>



