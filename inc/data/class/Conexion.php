<?php
	session_start();
	class Conexion {
		public static function cnx() {			
			
			// $cnn=mysqli_connect("localhost","root","root","videocine");
			$cnn=mysqli_connect("mysql", "oscar", "Ch3Tu123", "sampledb");
			
			/* verificar la conexión */
			if (mysqli_connect_errno()) {
			    printf("Falló la conexión: %s\n", mysqli_connect_error());
			    exit();
			}

			// printf("Conjunto de caracteres inicial: %s\n", mysqli_character_set_name($cnn));
			// cambiar el conjunto de caracteres a utf8 
			mysqli_set_charset($cnn, "utf8");
			
			return $cnn;
			
			mysqli_close($cnn);
		}
	}


	// $resultado = mysqli_query(Conexion::cnx(),"SELECT * FROM db_acceso");				

	// print_r($resultado);

	// $fila = mysqli_fetch_assoc($resultado);



	// echo "<br>";
	// echo $fila['acc_clave']."<br>";

	// $resultado = mysqli_query($mysqli, "SELECT 'Por favor, no use ' AS _msg FROM DUAL");


?>