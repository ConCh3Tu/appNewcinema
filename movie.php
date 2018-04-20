<?php
	$page_title = "Panel Movie";	
	$script_name= "video.js";
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
										<a class="article-me" data-name="ajax-nav" href="movie.php" id="l_1">
											<i class="fa fa-film"></i> <span>Registro de Peliculas</span>
										</a>
									</li>
									<li data-id="_2"><a data-name="ajax-nav" href="personal.php" id="l_2"><i class="fa fa-bar-chart-o"></i> <span>Registro Usuarios</span></a></li>
									<li data-id="_3"><a data-name="ajax-nav" href="genero.php" id="l_3"><i class="fa fa-group"></i> <span>Genero</span></a></li>
									<li data-id="_4"><a data-name="ajax-nav" href="nivel.php" id="l_4"><i class="fa fa-cogs"></i> <span>Nivel</span></a></li>
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
									<h4>Registro Movie</h4>		
							    </div>
							</div>
						</aside>
						<aside class="panel-body">
							<section class="panel-default">
								<div class="row ">
									<div class="col-md-8">
										<form name="r-form" id="r-form" class="form-control h-100 d-inline-block">
											<div class="form-group registro-form" id="r0" >
												<label for="r-nombre" class="col-form-label-sm">Titulo de pelicula <b class="text-danger">*</b></label>
												<input type="text" name="r-titulo" id="r-titulo" data-id="0" class="form-control" autofocus="true">
											</div>		
											<div class="form-group registro-form"  >
												<label for="r-nombre" class="col-form-label-sm">Director</label>
												<input type="text" name="r-director" id="r-director"  class="form-control">
											</div>	
											<div class="form-group">
												<div class="row">
													<div class="col-lg-8">
														<label for="r-ticket" class="col-form-label-sm">Genero <b class="text-danger">*</b></label>
														<div class="input-group registro-form" id="r2" >
															<select name="r-genero" id="r-genero" class="form-control" data-id="2">
																<option value="">Select</option>
																<?php 
																$getGenero = $objUser->getGenero();
																foreach ($getGenero as $key => $value) {
																	$key +=1;
																	$detalle = $value['gro_detalle'];
																	$id_gro = $value['gro_id'];
																	$key_gro = $value['gro_key'];
																	echo "<option value='$key' id='$id_gro' data-id='$key_gro' data-detalle='$detalle'>".$detalle."</option>
																	";}?></select>
															<span class="input-group-btn">
															<button class="btn btn-primary" id="btn-add-genero"
																type="button" 
																data-target="#modal-genero" 
																data-toggle="modal">+</button>
															</span>
														</div>
													</div>
													<div class="col-lg-4">
														<div class="form-group">
															<label for="r-check-in" class="col-form-label-sm">Año</label>
															<div class="input-group" id="r9">
																<span class="input-group-addon">
																	<i class="fa fa-calendar"></i>
																</span>
																<input type="text" 
																name="r-anio" 
																id="r-anio"  
																class="form-control"
																data-plugin-datepicker >
																<!-- data-date-start-view="decade"
																data-date-clear-btn="true"
																value="<?=$fecha?>" 
																data-date-language="es"
																data-date-autoclose="true"
																data-date-format="yyyy"
																data-date-min-view-mode="year"
																data-date-max-view-mode="decade" -->
															</div>
														</div>																	
													</div>
												</div>
											</div>
											<div class="form-group registro-form" >
												<label for="r-nombre" class="col-form-label-sm">Actor</label>
												<input type="text" name="r-actor" id="r-actor" data-id="2" class="form-control">
											</div>					
											<div class="form-group">
												<label for="r-detalle" class="col-form-label-sm">Sinopsis</label>
												<textarea rows="3" class="form-control" name="r-sinopsis" id="r-sinopsis" placeholder="..."></textarea>
											</div>
											<div class="modal-footer modal-footer-secundary">
                    							<button type="button" id="r-btnSave" class="btn btn-primary">Guardar</button>
											</div>
										</form>
									</div>
									<div class="col-md-4">
                						<fieldset class="form-control h-100 d-inline-block">
											<label for="r-detalle" class="col-form-label-sm">Poster</label>											
                							<div class="num-habitacion">
			                					<h1 id="hab-modal" data-id="0" class="lead">CODIGO</h1>
			                				</div>
                							<div class="poster-movie">
                								<div class="text-center padin-top hid" id="loader-poster">
	                								<i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
													<span class="sr-only">Loading...</span>
                								</div>
                								<div class="image-load" id="img-poster"></div>	
                							</div>
 											<form method="post" id="formulario" enctype="multipart/form-data">
												<div class="form-group">
													<label class="btn btn-primary btn-block">+
														<input type="file" name="file" id="file-img" style="display: none;">
														<input type="hidden" name="url-img" id="url-img">
														<input type="hidden" name="r-codImg" id="r-codImg">
													</label>
												</div>
											</form>
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
    <div id="modal-genero" 
    	tabindex="-1" 
    	role="dialog" 
    	aria-labelledby="modal-header-primary-label" 
    	aria-hidden="true" 
    	class="modal fade ">
  		<div class="modal-dialog " id="modal-loading">
    		<div class="modal-content" >
    			<div class="cont-loaging hid" id="cont-loaging">
					<i class="fa fa-circle-o-notch fa-spin fa-2x fa-fw"></i>
					<span class="sr-only">Loading...</span>
				</div>
				<div id="modal_genero"></div>    			    			              
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
		echo "<script type='text/javascript'>alert('Ud debe loguarse para ingresar a este contenido'); window.location='video.php';</script>";
	}
?>