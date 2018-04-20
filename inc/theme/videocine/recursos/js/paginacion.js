	$(function () {


	//---------------------------------------------------------------------------
	//				eventos modal config
	//---------------------------------------------------------------------------

	var 

	// addGenero  = $("#btn-add-genero"),
	paginacion = $(".page-item a");
	// addModalg = function (d) {
	// 	var otro = "";
	// 	$("#modal_genero").html("");							// contenedoe de carga 
	// 	$("#modal-loading").addClass("modal-dialog-width");		// modifica el tamaño del modal a 42px
	// 	$("#cont-loaging").removeClass("hid");					// muestra el icono loading 
	// 	setTimeout(function(){
	// 		$("#modal_genero").load("inc/plantilla/modal_genero.tpl.php", function (response, status, xhr) {				
	// 			if (status == 'error') {
	// 				var data = "<div class='alert alert-danger'>"
	// 						 + "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Mensaje: <br> Error vuelva a intentarlo mas tarde X-Planet"
	// 						 + "</div>"
	// 						 + "<div class='modal-footer modal-footer-secundary'>"
	// 						 + "<button type='button' data-dismiss='modal'  class='btn btn-warning'>Cerrar</button>"
	// 						 + "</div> "
	// 				$(this).html(data);	
	// 			}          					
	// 		});		
	// 		$("#modal-loading").removeClass("modal-dialog-width");
	// 		$("#cont-loaging").addClass("hid");			
	// 	},500);
	// };
	// addGenero.on("click", function () {	
	// 	addModalg();
	// });


	paginacion.on("click", function (v) {
		console.log($(this));
	});





});