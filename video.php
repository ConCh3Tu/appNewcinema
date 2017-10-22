<!DOCTYPE html>
<html lang="es">
<head>	
	<meta charset="utf-8">    
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="X-UA-Compatible" content="IE=9">    
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- <link rel="shortcut icon" href="inc/theme/cozy/recursos/img/favicon.ico"> -->
    <link rel="shortcut icon" href="inc/theme/videocine/recursos/img/demo.jpg">    
	<title>Video Cine</title>
	<link  href="inc/theme/videocine/recursos/css/bootstrap.css?lk=v4" rel="stylesheet" type="text/css" >						   
	<link  href="inc/theme/videocine/recursos/css/videocine.css?lk=v1.0" rel="stylesheet" type="text/css" >
	<script src="inc/theme/videocine/recursos/js/jquery.js?vlk=10.2" type="text/javascript" ></script>
	<script src="inc/theme/videocine/recursos/js/init.js?lk=v1.0" type="text/javascript" ></script>	
</head>
<body>
	<header>
		<div class="head-title">
			<p>Video Cine</p>
		</div>
	</header>
	<article class="jumbotron jumbotron-fluid jumbotron-hr">
		<aside class="container-fluid">

			<section class="container container-left ">
				<figure>
					<img src="inc/theme/videocine/recursos/img/demo.jpg" class="img" alt="Video Cine">
				</figure>
			</section>

			<section class="container container-right">								
				<div class="form-cozy">
					<form  name="data-login" id="data-login" method="POST">
						<figure>
							<p>
								<img src="inc/theme/videocine/recursos/img/demo.jpg" width="34px" alt="Video Cine">
								<small>Video Cine</small>									
							</p>
						</figure>
						<div class="login-form">
							<label for="login" class="col-form-label">Usuario</label>
							<small id="aler_0"></small>
							<input type="text" name="login" maxlength="20" value="oscar">
							<label for="clave">Clave</label>
							<small id="aler_1"></small>
							<input type="password" name="clave" maxlength="16" value="123">		
							<input type="button" name="btn-login" id="btn-login" value="Aceptar" class="btn btn-warning">
							<small id="aler_3"></small>							
						</div>
					</form>					
				</div>
				</div>	
			</section>
		</aside>
	</article>

	<footer>
		<div class="container-fluid contenedor-footer">
			<small>todos los derechos reservados, Video Cinema 2017</small>
		</div>
	</footer>
</body>
</html>