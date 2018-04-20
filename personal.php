<?php
	$page_title = "Panel Personal";	
	$script_name= "script/v1/personal_config.js?v=1.0";
	require_once("inc/data/class/Usuario.php");
	if ($_SESSION['user'] AND $_SESSION['nivel']) {
		$objUser = new Usuario();
		$nivel = $objUser->nivel();	

		$fecha = isset($_GET['fecha']) ? base64_decode($_GET['fecha']) : date('Y');		
?>
 <!DOCTYPE html>
<html lang="es">
<head>
<?php
	include 'inc/plantilla/head.tpl.php';
?>


</head>
<body>	
<?php
	include 'inc/plantilla/header.tpl.php';
?>
	<main class="container-main">
		<article class="block-main">	
			<div class="row no-gutters">
				<div class="col col-md-2 color-col-left">
					<section class="menu-left">
						<div class="menu-head">
							<i class="fa fa-home"></i>
							<span>Menu</span>
						</div>
						<div class="menu-body">
							<nav>
								<ul>
									<li data-id="_1">
										<a data-name="ajax-nav" href="movie.php" id="l_1">
											<i class="fa fa-film"></i> <span>Registro de Peliculas</span>
										</a>
									</li>
									<li data-id="_2">
										<a class="article-me" data-name="ajax-nav" href="personal.php" id="l_2"><i class="fa fa-bar-chart-o"></i> <span>Registro Usuarios</span></a></li>
									<li data-id="_3">
										<a data-name="ajax-nav" href="genero.php" id="l_3"><i class="fa fa-group"></i> <span>Genero</span></a></li>
									<li data-id="_4">
										<a data-name="ajax-nav" href="nivel.php" id="l_4">
											<i class="fa fa-cogs"></i> <span>Nivel</span>
										</a>										
									</li>									
								</ul>
							</nav>
						</div>
					</section>	
				</div>


				<div class="col-5 col-md-10">
					<section class="panel" id="panel_1">
						<aside class="panel-head">
							<div class="row no-gutters wrap-header" >
							    <div class="col">
									<h4>Registro Personal</h4>		
							    </div>
							</div>
						</aside>
						
						<aside class="panel-body">
							<section class="panel-default">
								<div class="row no-gutters">
									<div class="col-md-3">
									
										<form name="p-form" id="p-form" class="form-control h-100 d-inline-block">
											<div class="form-group registro-form" id="p0" >
												<label for="p-nombre" class="col-form-label-sm">Nombre <b class="text-danger">*</b></label>
												<input type="text" name="p-nombre" id="p-nombre" data-id="0" class="form-control form-control-sm" autofocus="true">
												<input type="text" hidden name="p-key"  id="p-key" class="form-control form-control-sm" >
											</div>		
											<div class="form-group registro-form" id="p1" >
												<label for="p-apellido" class="col-form-label-sm">Apellidos </label>
												<input type="text" name="p-apellido" id="p-apellido" data-id="1" class="form-control form-control-sm">												
											</div>
											<div class="form-group registro-form" id="p2" >
												<label for="p-dni" class="col-form-label-sm">DNI </label>
												<input type="text" name="p-dni" id="p-dni" data-id="2" class="form-control form-control-sm" maxlength="8">
											</div>	

											<div class="form-group registro-form" id="p4" >
												<label for="p-nivel" class="col-form-label-sm">Nivel <b class="text-danger">*</b></label>
												<select name="p-nivel" id="p-nivel" class="form-control form-control-sm" data-id="4">
													<option value="">Select</option>
													<?php 												
													$getNivel = $objUser->nivelSelect();
													foreach ($getNivel as $key => $value) {										
														$id_niv = $value['niv_id'];
														$niv_detalle = $value['niv_detalle'];
														echo "<option value='$id_niv'>".$niv_detalle."</option>";
													}
													?>												
												</select>
											</div>
											<div class="form-group registro-form" id="p5" >
												<label for="p-user" class="col-form-label-sm">Usuario <b class="text-danger">*</b></label>
												<input type="text" name="p-user" id="p-user" data-id="5" class="form-control form-control-sm">
												<input type="text" hidden name="p-id"  id="p-id" class="form-control form-control-sm" >												
											</div>	
											<div class="form-group registro-form" id="p7" >
												<label for="p-clave" class="col-form-label-sm">Contraseña <b class="text-danger">*</b></label>
												<input type="text" name="p-clave" id="p-clave" data-id="7" class="form-control form-control-sm" placeholder="min 6" >
											</div>											

											<div class="modal-footer  modal-footer-pad-15">
                    							<button type="button" id="p-btnSave" class="btn btn-primary"><i class="fa fa-save fa-1x fa-fw"></i>Guardar</button>
                    							<button type="button" id="p-btnCancel" class="btn btn-danger hid"><i class="fa fa-close fa-1x fa-fw"></i>Cancelar</button>
                    							<button type="button" id="p-btnUpdate" class="btn btn-success hid"><i class="fa fa-edit fa-1x fa-fw"></i>Modificar</button>
											</div>											
										</form>
									</div>
									<div class="col-md-9">
                						<fieldset class="form-control h-100 d-inline-block">
											<p class="lead">Listar Personal</p>
 											<form method="post" id="form-search">
												<div class="row">
													<div class="col-lg-6"></div>
													<div class="col-lg-6">
														<div class="input-group">
															<input type="search" class="form-control" placeholder="Buscar..." aria-label="Buscar..." id="p-search" name="p-search">
															<span class="input-group-btn">
															<button class="btn btn-primary" id="p-btnSearch" type="button">Go!</button>
															</span>
														</div>
													</div>
												</div>
											</form>
											<br>
											<table class="table table-bordered table-hover table-sm table-responsive" id="table-list">
												<thead>
													<tr class="text-secondary">
														<th class="text-center">#</th>
														<th class="text-center">Nombres</th>
														<th class="text-center">DNI</th>
														<th class="text-center">Usuario</th>
														<th class="text-center">Nivel</th>
														<th class="text-center" style="min-width:57px"><i class="fa fa-list fa-fw fa-1x"></i></th>
													</tr>
												</thead>
												<tbody>
													
												</tbody>
											</table>
											<div class="text-center text-secondary " id="loading-data">
												<small>Loading...</small><img src="inc/theme/videocine/recursos/img/svg-loaders/puff.svg" width="20" alt="">
											</div>
											<div class="text-center text-secondary" id="sin-r" style="display: none;">
												<small>Sin registros a mostrar</small>
											</div>
											<nav aria-label="..." id="nav-paginacion">
												<ul class="pagination pagination-sm justify-content-end" >
												</ul>
											</nav>													
											<div id="alert-ajax-g"></div>
                						</fieldset>
                					</div>
								</div>
							</section>
						</aside>
					</section>
					
				</div>
			</div>
		</article>
	</main>

	<!-- Small modal  genero confimacion de eliminar -->
	<div class="modal fade bd-example-modal-sm"  
		tabindex="-1" 
		id="modal-personal-delete" 
		role="dialog" 
		aria-labelledby="Eliminar Nivel" 
		aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class='alert alert-danger'>
					<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Mensaje: <br> 							
					Está seguro que desea eliminar permanentemente: <b class="msg-modal" id="msg-modal" >*</b>
				</div>					
				<div class="modal-body text-center">
					<form name="md-form" id="mg-form">
						<input  type="text" name="md-id" id="md-id" class="form-control form-control-sm">		
						<input  type="text" name="md-cd" id="md-cd" class="form-control form-control-sm">		
						<button type="button" id="mg-btnCancel" class="btn btn-secondary"><i class="fa fa-close fa-fw fa-1x"></i> Cancelar</button>
						<button type="button" id="p-btnDelete" class="btn btn-danger"><i class="fa fa-check"></i> Confirmar</button>					
					</form>
				</div>

			</div>
		</div>
	</div>	
<?php
  include "inc/plantilla/footer.tpl.php";
?>

</body>

</html>
<?php 
	}else{
		echo '<script type="text/javascript">alert("Ud debe loguarse para ingresar a este contenido "); window.location="video.php";</script>';
	}
?>