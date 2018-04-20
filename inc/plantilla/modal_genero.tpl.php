<?php
	require_once("../data/class/Conexion.php");	
	require_once("../data/class/Usuario.php"); 

	$page = $_GET['page'];
	$text = $_GET['text'];

	$objGenero = new Usuario();	
?>   
	<div class="modal-genero-loader hid" id="modal-genero-loader">		
		<i class="fa fa-refresh fa-spin fa-1x fa-fw"></i>
		<span class="sr-only">Loading...</span>		
	</div> 
    <div class="modal-header modal-header-primary">
        <h4 id="modal-header-primary-label" class="modal-title"> <i class="fa fa-ticket"></i>
        Agregar Genero</h4>
        <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
    </div>

    <div class="modal-body">
    	<div class="row" >                		                	
    		<div class="col-md-12">
				<form name="m-form" id="m-form">
					<div class="form-group registro-form" id="m0">
						<label for="m-detalle" >Descripcion</label>
						<input type="text" 
							name="m-detalle" 
							id="m-detalle" 
							data-id="0"
							class="form-control form-control-sm" 
							value="<?=$text?>"
							autofocus 
							>
						<input type="hidden" name="m-detalle-id" id="m-detalle-id" class="form-control form-control-sm">
						<input type="hidden" name="m-cod" id="m-cod" class="form-control form-control-sm" >
						<small id="aler_0"></small>
					</div>				
					<div class="form-group text-right">
						<button type="button" id="m-btnQuit" data-dismiss="modal"  class="btn btn-danger">Cerrar</button>
				        <button type="button" id="m-btnSave" class="btn btn-primary ">Guardar</button>
				        <button type="button" id="m-btnUpdate" class="btn btn-success hid">Modificar</button>
					</div>
			
				</form>
			</div>
			
    	</div>

    </div>
    <!-- <div class="modal-footer modal-footer-secundary"> -->
		<table class="table table-sm table-condensed table-hover table-bordereb"  style="height: 218px">
			<thead>
				<td class="text-center">ID</td>
				<td class="text-center">DETALLE</td>
				<td class="text-center" style="width: 100px" ><i class="fa fa-cog"></i></td>							
			</thead>
			<tbody>							
				<?php 

					
					$genero = $objGenero->getGeneroPaginacion($page);	

					// echo "<pre>";
					// print_r($genero);
					// echo "</pre>";
					
					$err = $genero['err']['success'];
					if (!$err) {
						echo "<tr><td colspan='3' class='text-center' > Sin registro mostrar.</td></tr>";
					}else {
						
						$i = 0;					
						for ($key=0; $key < count($genero)  - 2 ; $key++) { 
							$i++;
							echo "<tr data-id='$key'id='m-$i' >"
			     				."<td class='text-center'>$i</td>"
			     				."<td>".$genero[$key]['gro_detalle']."</td>"
			     				."<td class='text-center'>"
			     				."<a class='btn btn-sm update-m' href='javascript:void(0)' data-key='".$genero[$key]['gro_key']."' data-id='$i'"
			     				."data-detalle='".$genero[$key]['gro_detalle']."' data-ld='".$genero[$key]['gro_id']."' ><i class='fa fa-pencil-square-o fa-1x fa-fw text-success' aria-hidden='true' ></i></a> "
			     				."<a class='btn btn-sm' href='javascript:void(0)' data-id='".$genero[$key]['gro_id']."'"
			     				."data-detalle='".$genero[$key]['gro_detalle']."'  data-toggle='modal' data-target='#modal-genero-delete'><i class='fa fa-trash-o fa-1x fa-fw text-danger' aria-hidden='true'></i></a>"
			     				."</td>"
			     				."</tr>";	
						}
					}

		     		//  foreach ($genero as $key => $value) {
		     		//  	$key +=1;
		     		//  	if ($key == 5) {
		     		//  		break;
		     		//  	}
		     		// 	echo "<tr data-id='$key'id='t-$key' >"
		     		// 		."<td class='text-center'>$key</td>"
		     		// 		."<td>". $value['gro_detalle']	."</td>"
		     		// 		."<td class='text-center'>"
		     		// 		."<a class='btn btn-default btn-sm' href='javascript:void(0)' data-id='$key'"
		     		// 		."data-detalle='".$value['gro_detalle']	."'><i class='fa fa-edit'></i></a>"
		     		// 		."<a class='btn btn-secondary btn-sm' href='javascript:void(0)' data-id='$key'"
		     		// 		."data-detalle='".$value['gro_detalle']	."'  data-toggle='modal' data-target='.bd-example-modal-sm'><i class='fa fa-close'></i></a>"
		     		// 		."</td>"
		     		// 		."</tr>";
		     		// }
		     	?>								
			</tbody>
			<tfoot>
				<tr >
					<td colspan="3">
						<nav aria-label="...">
						<ul class="pagination pagination-sm justify-content-end" style="margin-bottom: 0rem;">
						<?php
						$previous = $genero['link']['gro_detalle']['previous'];
						$next = $genero['link']['gro_detalle']['next'];
						$link = $genero['link']['gro_detalle']['pag'];						
						$max  = count($link);
						?>
						<li class="page-item <?=$previous == 0 ? 'disabled': '' ?>">
							<a class="page-link" href="javascript:void(0)" 
								aria-label="Previous" 
								tabindex="-1"
								data="<?=$previous?>">
								<span aria-hidden="true">&laquo;</span>
								<span class="sr-only">Previous</span>
							</a>
						</li>						
						<?php
											
						for ($j=1; $j <= $max ; $j++) { 							
							if ($link[$j] != 0) {
							echo "<li class='page-item active'><span class='page-link'>".$j."<span class='sr-only'>(current)</span></span></li>";
							}else {
							echo "<li class='page-item'><a class='page-link' href='javascript:void(0)' data='$j'>$j</a></li>";
							}
						}
						?>

						<li class="page-item <?=$next == '' ? 'disabled': '' ?>">
							<a class="page-link" 
								href="javascript:void(0)" 
								aria-label="Next"
								data="<?=$next?>">
								<span aria-hidden="true">&raquo;</span>
								<span class="sr-only">Next</span>
							</a>
						</li>
						</ul>
						</nav>								
					</td>
				</tr>
				
			</tfoot>
		</table>



		<div class="modal fade bd-example-modal-sm"  
			tabindex="-1" 
			id="modal-genero-delete" 
			role="dialog" 
			aria-labelledby="Eliminar Genero" 
			aria-hidden="true">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
						<div class='alert alert-danger'>
							<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Mensaje:<br> 							
							Está seguro que desea eliminar permanentemente: <b class="msg-modal">*</b>
						</div>					
					<div class="modal-body text-center">
						<form name="md-form" id="md-form">
							<input  type="hidden" name="md-id" id="md-id" class="form-control form-control-sm">							
							<button type="button" id="btn-modal-delete-close" class="btn btn-secondary"  >Cancelar</button>
							<button type="button" id="btn-modal-delete-confirmar" class="btn btn-danger">Confirmar</button>					
						</form>
					</div>

				</div>
			</div>
		</div>		




<script type="text/javascript">

$(function () {
	"use stric";
	//---------------------------------------------------------------------------
	//				eventos paginacion  modal config
	//---------------------------------------------------------------------------

	var 
		paginacion = $(".page-item a"),
		addModalg = function (p,t) {
			var 
				otro = "",		
				url  = "?&page="+p+"&text="+t;		
			setTimeout(function(){
				$("#modal_genero").load("inc/plantilla/modal_genero.tpl.php"+url, function (response, status, xhr) {				
					if (status == 'error') {
						var 
							data = "<div class='alert alert-danger'>"
								 + "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Mensaje: <br> Error vuelva a intentarlo mas tarde X-Planet"
								 + "</div>"
								 + "<div class='modal-footer modal-footer-secundary'>"
								 + "<button type='button' data-dismiss='modal'  class='btn btn-warning'>Cerrar</button>"
								 + "</div> "
						$(this).html(data);	
					}          					
				});		
			
			},500);
		};
	paginacion.on("click", function (v) {		
		var
			page  = $(this).attr("data"),
			text = $("#m-detalle").val();
		$("#modal-genero-loader").removeClass("hid"),	
		addModalg(page,text);		
	});


	//---------------------------------------------------------------------------
	//				eventos modal guardar gemero
	//---------------------------------------------------------------------------

	var 

		btn  = $("#m-btnSave"),		
		save = function (d) {
			var 
				form = d+"&m-cod="+cod(21,null)+"=";
			$.ajax({
				type 	: 'post',
				url 	: 'inc/data/interfasRegistroGenero.php',
				data 	: form,
				dataType: 'json',				
				before	: function (respons) {
					console.log(respons);				
				},
				success : function (respons) {							
					if (respons.success == true) {
						addModalg(1,'');	
						var 
						idr  = $("#r-genero"),
						data = "<option value='"
							 +	idr[0].children.length 
							 + "' id='"
							 + (respons.data.gro_id == undefined ? '' : respons.data.gro_id)
							 + "' data-id='"
							 + (respons.data.gro_key == undefined ? '' : respons.data.gro_key)
							 + "' data-detalle='"
							 + (respons.data.gro_detalle == undefined ? '' : respons.data.gro_detalle) 
							 + "'>"
							 + (respons.data.gro_detalle == undefined ? '' : respons.data.gro_detalle) 
							 + "</option>";
						$("#r-genero").append(data);				
					}					
				},
				fail	: function (err) {
					alert(err);
				}
			});		
			return true;
		};

		btn.on("click", function () {
			var 
				detalle = $("#m-detalle").val(),
				form,
				success = 1;
			if (detalle.trim() == "") {
				$("#m0").addClass("alert-input");				
				success = 0;
			}	
			if (success) {
				form = $("#m-form").serialize();
				$("#modal-genero-loader").removeClass("hid"),
				save(form);				
				success = 0;
			}
		});

		//---------------------------------------------------------------------------
		//				eventos quitar la validacion con keypress
		//---------------------------------------------------------------------------		
		$("#m-detalle").keypress(function (event) {
			var 
				value = $(this).val(),
				dataId = $(this).data('id');	
			if (value.trim() != "") {
				$("#m"+dataId).removeClass("alert-input");						
			}	
		});


		//---------------------------------------------------------------------------
		//				eventos modificar .update-m genero
		//---------------------------------------------------------------------------	

		var 
			btnEditGenero = $("a.update-m"),
			btnModiGenero = $("#m-btnUpdate"),
			tableEditGnro = function (data) {
				var 
					field = data.data('detalle'),
					id    = data.data('key'),
					ld    = data.data('ld'),
					table = $("#modal-genero table tbody"),
					se    = "m-"+data.data('id'); 

				$("#m-detalle").val(field);
				$("#m-detalle-id").val(id);
				$("#m-cod").val(ld);
				$("#m-detalle").focus();	
				$("#m-btnSave").addClass('hid');
				$("#m-btnUpdate").removeClass('hid');			
				$.each(table,function () {
					$(this).children("tr").each(function (i) {														
						var me = $(this).attr('id');
						if (me == se) {
							$(this).css("background-color","#eae9e8"); 								
						}else{
							$(this).css("background-color","#ffffff"); 								
						}			
					});
				});		
			},
			update = function (u) {
				var 
					form = u;
				$.ajax({
					type 	: 'post',
					url 	: 'inc/data/interfasUpdateGenero.php',
					data 	: form,
					dataType: 'json',				
					before	: function (respons) {
						console.log(respons);				
					},
					success : function (respons) {							
						if (respons.success == true) {
							addModalg(1,'');								
						}					
					},
					fail	: function (err) {
						alert(err);
					}
				});		
				return true;				
			};

		btnEditGenero.on("click",function (e) {
			var 
				data = $(this);
			tableEditGnro(data);			
			e.preventDefault();
		});
		btnModiGenero.on("click", function () {
			var 
				detalle = $("#m-detalle").val(),
				form,
				success = 1;
			if (detalle.trim() == "") {
				$("#m0").addClass("alert-input");				
				success = 0;
			}	
			if (success) {
				form = $("#m-form").serialize();
				$("#modal-genero-loader").removeClass("hid"),				
				update(form);				
				success = 0;
				var 
					id = $("#m-cod").val(),
					vl = $("#m-detalle").val();
				$("#"+id).text(vl);
			}		
		});


		//---------------------------------------------------------------------------
		//				eventos eliminar a.btn-secondary  genero mediante modal
		//---------------------------------------------------------------------------			
		var 			
			btnConfirDetele = $("#btn-modal-delete-confirmar"),
			btnCancelDelete = $("#btn-modal-delete-close"),
			whateverLoadIdd = $('#modal-genero-delete'),
			eliminar = function (d){
				var 
					form = d;
					$.ajax({
					type 	: 'post',
					url 	: 'inc/data/interfasDeleteGenero.php',
					data 	: form,
					dataType: 'json',				
					before	: function (respons) {
						console.log(respons);				
					},
					success : function (respons) {							
						if (respons.success == true) {
							addModalg(1,'');								
						}					
					},
					fail	: function (err) {
						alert(err);
					}
				});		
				return true;				
			} ;	
		btnConfirDetele.on("click", function () {
			var 
				form = $("#md-form").serialize(),
				id   = $("#md-id").val(),
				x    = $("#"+id);
			eliminar(form);
			$("#modal-genero-delete").modal('hide');
			x.remove(x.selectedIndex);							
		});
		btnCancelDelete.on("click", function () {
			$("#modal-genero-delete").modal('hide');
		});
		whateverLoadIdd.on('show.bs.modal', function (event) {
			var 
				button = $(event.relatedTarget), 
				recipient = button.data('detalle'),
				idrecipient = button.data('id'), 				
				modal = $(this);
			modal.find('.msg-modal').text(recipient);
			modal.find('.modal-body input').val(idrecipient);
		});





	//---------------------------------------------------------------------------
	//				genera codigo 4756464123
	//---------------------------------------------------------------------------		
	function cod(val, special) {
		return getCod(val, special);
	}
	function getCod(val, special) {
	    var iteration = 0;
	    var codigo = "";
	    var randomCodigo;
	    if (special == undefined) {
	      var special = false;
	    }
	    while (iteration < val ) {
	      //randomCodigo = (Math.floor((Math.random() * 100)) % 94) + 33;
	      randomCodigo = (Math.floor((Math.random() * 9) + 1 ));

	      if (!special) {
	        if ((randomCodigo >=33 ) && (randomCodigo <=47 )) { continue; }
	        if ((randomCodigo >=58 ) && (randomCodigo <=64 )) { continue; }
	        if ((randomCodigo >=91 ) && (randomCodigo <=96 )) { continue; }
	        if ((randomCodigo >=123) && (randomCodigo <=126)) { continue; }
	      }
	      iteration++;
	      // codigo += String.fromCharCode(randomCodigo);	      
	      codigo += randomCodigo;
	    }
	    return codigo;
	}
});
</script>		




    


        
    
    