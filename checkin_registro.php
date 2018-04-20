<?php
	$page_title = "Check In Registro";	
	require_once("inc/data/class/Usuario.php");
	if ($_SESSION['user'] AND $_SESSION['nivel']) {
		$objUser = new Usuario();
		$nivel = $objUser->nivel();

	    $fecha = isset($_GET['fecha']) ? base64_decode($_GET['fecha']) : date('Y-m-d');
		// $fecha =  date('Y-m-d'); //"2015-06-30 10:59:59 06/02/2017";
    	$fecha_next = date('Y-m-d', strtotime($fecha .' +1 day'));		
    	


    	$datetime1 = new DateTime($fecha);
	    $datetime2 = new DateTime($fecha_next);
	    $interval = $datetime1->diff($datetime2);
    	$contDay = $interval->format('%a');
	    


    	// print_r ($_GET);
    	// echo "<br> hash ";
    	// echo (base64_decode($_GET['hash']));
    	// echo "<br> habitacion ";
    	// echo (base64_decode($_GET['hab']));
    	// echo "<br> tipo hab ";
    	// echo (base64_decode($_GET['tipo']));
    	// echo "<br> num hab ";
    	// echo (base64_decode($_GET['numh']));
    	// echo "<br> cont --- ";
    	// echo (base64_decode($_GET['cont']));
    	// echo "<br> detalle ";
    	// echo (base64_decode($_GET['deta']));
    	// echo "<br> prec pen";
    	// echo (base64_decode($_GET['prip']));
    	// echo "<br> prec usd ";
    	// echo (base64_decode($_GET['priu']));
    	// echo "<br> cama ";
    	// echo (base64_decode($_GET['cama']));
    	// echo "<br> modo ";
    	// echo (base64_decode($_GET['modo']));


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
				<div class="col col-md-2">
					<section class="menu-left ">
						<div class="menu-head ">
							<i class="fa fa-home"></i>
							<span>Menu</span>
						</div>
						<div class="menu-body">
							<nav>
								<ul>
									<li data-id="_1"><a class="article-me" data-name="ajax-nav" href="checkin.php" id="l_1"><i class="fa fa-book"></i> <span>Check - In </span></a></li>
									<li data-id="_2"><a data-name="ajax-nav" href="reporte.php" id="l_2"><i class="fa fa-bar-chart-o"></i> <span>Reportes</span></a></li>
									<li data-id="_3"><a data-name="ajax-nav" href="usuario.php" id="l_3"><i class="fa fa-group"></i> <span>Usuaios</span></a></li>
									<li data-id="_4"><a data-name="ajax-nav" href="configs.php" id="l_4"><i class="fa fa-cogs"></i> <span>Admin</span></a></li>
								</ul>
							</nav>
						</div>
					</section>									
				</div>					
				<!-- init ajax content -->
				<div class="col-5 col-md-10">
					<section class="panel" id="panel_1">
						<aside class="panel-head">
							<div class="row no-gutters wrap-header" >
							    <div class="col">
									<h4>Registro Check In</h4>		
							    </div>
							    <div class="col-12 col-md-auto"></div>
							    <div class="col col-lg-8 col-min">
									<div class="panel-sub-head">
										<i class="fa fa-th"></i> <span>libre</span>  					
										<i class="fa fa-th"></i> <span>Ocupado</span>					
										<i class="fa fa-th"></i> <span>Reserva</span>
									</div>
							    </div>							    
							</div>
						</aside>					
						<aside class="panel-body">
							<section class="panel-default">
								<div class="row ">
									<div class="col-md-8">
										<form name="r-form" id="r-form" class="form-control">
											<div class="text-right">
                    							<button type="button" 
                    								id="r-estado" 
                    								name="r-estado"
                    								class="btn btn-warning btn-sm"
                    								<?=(base64_decode($_GET['cama']) == '' ? '': disabled)?>
                    							><?=(base64_decode($_GET['modo']) > 0) ? 'Privado':'Compartido'?>
                    							</button>
											</div>			
											<style type="text/css">
												.alert-input > input {
													border-bottom-width: 2px;
													border-bottom-color: red; 													
												}
												.alert-input > .alert {
													display: block;
													overflow: visible;
												}
											</style>																	
											<div class="form-group registro-form" id="r0" >
												<label for="r-nombre">Nombres y Apellidos <b class="text-danger">*</b></label>
												<input type="text" name="r-nombre" id="r-nombre" data-id="0" class="form-control" autofocus="true" value="<?=$_GET['name']?>">
												<input type="hidden" name="r-numhabitacion" id="r-numhabitacion" value="<?=base64_decode($_GET['hab'])?>">
											</div>														
											<div class="row">
					                            <div class="col-md-4">
					                                <div class="form-group">
					                                	<label for="r-tipodoc">Tipo Doc.</label>
														<select name="r-tipodoc" id="r-tipodoc" class="form-control">
															<option value="1">DNI</option>	
															<option value="2">PASAPORTE</option>	
															<option value="3">OTROS</option>	
														</select>                                   
					                                </div>
					                            </div>
					                            <div class="col-md-8">
					                                <div class="form-group">
					                                	<label for="r-nummero">Número de Documento</label>
					                                	<input type="text" id="r-nummero" name="r-nummero" class="form-control">
					                                </div>
					                            </div>
					                        </div>
					                        <div class="row">
					                        	<div class="col-md-4">
					                        		<div class="form-group">
					                                	<label for="p-tipohabitacion">Tipo Hab.</label>
														<select name="p-tipohabitacion" id="p-tipohabitacion" class="form-control">
															<!-- <option value="0">Seleccionar</option>	 -->
															<option value="1" <?=(base64_decode($_GET['tipo']) == 1) ? 'selected': '' ?>>Simple</option>	
															<option value="2" <?=(base64_decode($_GET['tipo']) == 2) ? 'selected': '' ?>>Doble / Matrimonial</option>	
															<option value="3" <?=(base64_decode($_GET['tipo']) == 3) ? 'selected': '' ?>>Triple</option>	
															<option value="4" <?=(base64_decode($_GET['tipo']) == 4) ? 'selected': '' ?>>Compartida x 4</option>	
															<option value="8" <?=(base64_decode($_GET['tipo']) == 5) ? 'selected': '' ?>>Compartida x 8</option>			
														</select>
					                                </div>                				
					                        	</div>
					                        	<div class="col-md-2">
					                        		<div class="form-group registro-form" id="r5">                                
					                                	<label for="p-nunpersonas">nro. Personas <b class="text-danger">*</b></label>
														<input type="number" name="p-nunpersonas" id="p-numpersonas" data-id="5" class="form-control" min="0"  value="<?=(base64_decode($_GET['tipo'])==5) ? 8 : base64_decode($_GET['tipo'])?>">
													</div>
					                        	</div>
				                        	
					                        	<div class="col-md-3">
					                                <label for="p-precio" id="l-precio">Precio Soles <b class="text-danger">*</b></label>
					                        		<div class="input-group registro-form" data-toggle="buttons" id="r7">
					                        			<span class="input-group-btn">
															<input type="checkbox" checked 
																name="p-moneda" 
																id="p-moneda" 
																data-toggle="toggle" 
																data-width="60" 
																data-on="<i class='fa fa-scribd'></i><b class='changemoneda' data-usd='<?=base64_decode($_GET['priu'])?>'>Precio USD *</b>"
																data-off="<i class='fa fa-usd'></i><b class='changemoneda' data-usd='<?=base64_decode($_GET['prip'])?>' >Precio Soles *</b>" 
																data-onstyle="default" 
																class="moneda"
															>
													    </span>
														<input type="number" name="p-precio" id="p-precio" class="form-control" min="0" data-id="7" value="<?=base64_decode($_GET['prip'])?>">
													</div>
					                        	</div>

					                        	<div class="col-md-2 pading-col-md-2">					                        		
					                        		<div class="form-group">
					                                	<label for="p-descuento">Descuento</label>
					                                	<input type="number" min="0" name="p-descuento" id="p-descuento" class="form-control" value="0.00">
					                                </div>                				
					                        	</div>					                        	
					                        </div>
											<div class="row">
											    <div class='col-md-4'>
													<div class="form-group">
														<label for="r-check-in">Check-In <b class="text-danger">*</b></label>
														<div class="input-group" id="r9">
															<span class="input-group-addon">
																<i class="fa fa-calendar"></i>
															</span>
															<input type="text" 
															name="r-check-in" 
															id="r-check-in"  
															data-id="9"
															data-plugin-datepicker class="form-control" 
															value="<?=$fecha?>"
															data-date-language="es"
															data-date-title="Check-In"
															data-date-today-highlight="true"
															data-date-autoclose="true"				
															data-date-start-date='0d'
															>

														</div>
															<!-- data-date-end-date="0d" -->
													</div>	
											    </div>
											    <div class='col-md-5'>
											        <div class="form-group">
														<label for="r-check-out">Check-Out <b class="text-danger">*</b></label>
														<div class="input-group" id="r10">
															<span class="input-group-addon">
																<i class="fa fa-calendar"></i>
															</span>
															<input type="text" name="r-check-out" id="r-check-out" data-id="0" data-plugin-datepicker 
															class="form-control" 
															value="<?=$fecha_next?>"
															data-date-language="es"
															data-date-title="Check-Out"
															data-date-autoclose="true"											
															data-date-start-date='+1d'>
														</div>
													</div>
											    </div>
											    <div class='col-md-3 registro-form' id="r11">
													<label for="r-dias">nro. Días <b class="text-danger">*</b></label>
													<input type="text" name="r-dias" id="r-dias" data-id="11" class="form-control " readonly="readonly" value="<?=$contDay?>" min="0">
											    </div>
											</div>					                        					



											<div class="form-group">
												<label for="r-ticket">Reserva</label>

												<div class="row">
												  <div class="col-lg-12">
												    <div class="input-group" >
												      <select name="r-ticket" id="r-ticket" class="form-control" >
												     	<?php 
												     		$getTicket = $objUser->getTicket();
												     		foreach ($getTicket as $key => $value) {
												     		$key +=1;
												     		echo "<option value='$key'>". $value['detalle']	."</option>";
												     		}
												     	?>
													  </select>
												      <span class="input-group-btn">
												        <button class="btn btn-secondary" type="button" data-target="#modal-ticket" data-toggle="modal">+</button>
												      </span>
												    </div>
												  </div>
												</div>	
												

												<!-- <input type="text"  id="r-ticket" name="r-ticket" class="form-control"> -->
											</div>

											<div class="form-group">								
												<div class="form-check form-check-inline">
													<label class="form-check-label">
														<input class="form-check-input" type="radio" name="h-estado" id="r-ocupado-2" value="1" checked> Asignar Habitación
													</label>
												</div>
												<div class="form-check form-check-inline">
													<label class="form-check-label">
														<input class="form-check-input" type="radio" name="h-estado" id="r-ocupado-2" value="2"> Ocupar Habitación
													</label>
												</div>
											</div>											







											<div class="form-group">
												<label for="r-detalle">Detalle</label>
												<textarea rows="5" class="form-control" name="r-detalle" id="r-detalle" placeholder="..."></textarea>
											</div>
											<div class="modal-footer modal-footer-secundary">
                    							<button type="button" id="r-btnSave" class="btn btn-primary">Guardar</button>
											</div>																			
										</form>
									</div>									
                					<div class="col-md-4">
                						<fieldset class="form-control ">
											<div class="num-habitacion">
			                					<h1 id="hab-modal"><?=base64_decode($_GET['numh'])?></h1>

			                					<div class="panel-hab-extra text-right pading-4 <?=(base64_decode($_GET['modo']) > 0) ? 'hid': ''?>" id="r-cama-add" >
				                					<a href="javascript:void(0)" class="btn btn-secondary btn-block"><i class="demo-icon icon-loadplus"></i></a>			                					
			                					</div>
			                				</div>        
			                				<label for="r-numhabitacion">Cama disponible <b class="text-danger">*</b></label>
			                				
			                				<div class="form-group registro-form" id="r17">			                				<div class="alert alert-danger hid" data-id="17" id="r18">
			                						<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Seleccione un casillero
			                					</div>	
			                					<input type="hidden" name="rd-deta" id="rd-deta" value="<?=base64_decode($_GET['deta'])?>">
			                					<input type="hidden" name="rd-cont" id="rd-cont" value="<?=base64_decode($_GET['cont'])?>">
			                					<input type="hidden" name="rd-modo" id="rd-modo" value="<?=base64_decode($_GET['modo'])?>">
			                					<div class="loader-cama gif-cama text-center color-cozy hid" id="loader-cama">
			                						<i class="demo-icon icon-loadspin3 animate-spin fa-2x"></i>
													<span class="sr-only">Refreshing...</span>
			                					</div>
			                					<div class="" id="panel-hcama">Sin resultados de busqueda...</div>
				                				
			                				</div>

			                				<div class="form-group">
			                					<label for="r-fecha">Fecha de Registro</label>			                		
			                					<input type="text" name="p-fecha" id="r-fecha" class="form-control form-control-sm" disabled="true" >
			                				</div>
			                				<div class="form-group">
			                					<label for="r-camalibre">Camas Libres</label>
			                					<input type="text" name="p-camalibre" id="r-camalibre" class="form-control form-control-sm" disabled="true" >
			                				</div>
                						</fieldset>										
									</div>
								</div>
							</section>
						</aside>
					</section>				
				</div>  <!-- .end ajax content -->				

			</div>
		</article>
	</main>

	

<?php
  include "inc/plantilla/footer.tpl.php";

?>
	<script src="inc/theme/cozy/recursos/js/cozyhCama.js"></script>


	<!-- [open add ticket modal] -->
	<!--Modal add ticket btn-->
	<!-- data-target="#modal-ticket" data-toggle="modal" -->
    <div id="modal-ticket" tabindex="-1" role="dialog" aria-labelledby="modal-header-primary-label" aria-hidden="true" class="modal fade ">
        <div class="modal-dialog">
            <div class="modal-content">
    		<div class="placeholder hid"></div>
    		<div class="mensaje-alert"></div>
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title"> <i class="fa fa-ticket"></i>
                    Agregar Ticket</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                </div>
                <div class="modal-body">
                	<div class="row">                		                	
                		<div class="col-md-12">
							<form name="t-form" id="t-form">
								<div class="form-group">
									<label for="t-detalle" >Descripcion</label>
									<input type="text" name="t-detalle" id="t-detalle" class="form-control form-control-sm">
									<input type="hidden" name="t-detalle-id" id="t-detalle-id" class="form-control form-control-sm">
									<input type="hidden" name="cod" id="t-cod" class="form-control form-control-sm" value="1">
									<small id="aler_0"></small>
								</div>				
							</form>
						</div>
						<table class="table table-sm table-condensed table-hover table-bordereb">
							<thead>
								<td class="text-center">ID</td>
								<td class="text-center">DETALLE</td>
								<td class="text-center" style="width: 80px" ><i class="fa fa-circle"></i></td>							
							</thead>
							<tbody>							
								<?php 

						     		// $getTicket = $objUser->getTicket();
						     		 foreach ($getTicket as $key => $value) {
						     		 	$key +=1;
						     			echo "<tr data-id='$key'id='t-$key' >"
						     				."<td class='text-center'>$key</td>"
						     				."<td>". $value['detalle']	."</td>"
						     				."<td class='text-center'>"
						     				."<a class='btn btn-default btn-sm' href='javascript:void(0)' data-id='$key'"
						     				."data-detalle='".$value['detalle']	."'><i class='fa fa-edit'></i></a>"
						     				."<a class='btn btn-secondary btn-sm' href='javascript:void(0)' data-id='$key'"
						     				."data-detalle='".$value['detalle']	."'  data-toggle='modal' data-target='.bd-example-modal-sm'><i class='fa fa-close'></i></a>"
						     				."</td>"
						     				."</tr>";
						     		}
						     	?>								
							</tbody>


		
						</table>
                	</div>

                </div>
                <div class="modal-footer modal-footer-secundary">
                    <button type="button" id="t-btnQuit" data-dismiss="modal"  class="btn btn-warning">Cerrar</button>
                    <button type="button" id="t-btnSave" class="btn btn-warning ">Guardar</button>
                    <button type="button" id="t-btnUpdate" class="btn btn-success hid">Modificar</button>
                </div>
            </div>
        </div>
    </div>


<!-- Small modal  ticket confimacion de eliminar -->

	<div class="modal fade bd-example-modal-sm " tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  		<div class="modal-dialog modal-sm">
    		<div class="modal-content">
                <div class="modal-header modal-header-secondary">
                	¿Seguro que quieres eliminar?
    			</div>
                <div class="modal-body text-center">
                	<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                	<button type="button" class="btn btn-danger">Confirmar</button>
    			</div>

    		</div>
  		</div>
	</div>



</body>
</html>
<?php 
	}else{
		echo "<script type='text/javascript'>alert('Ud debe loguarse para ingresar a este contenido'); window.location='cozy.php';</script>";
	}
?>