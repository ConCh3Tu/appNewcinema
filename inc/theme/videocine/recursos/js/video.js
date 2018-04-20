	$(function () {

	//---------------------------------------------------------------------------
	//				click event impus and select
	//---------------------------------------------------------------------------
	$(".registro-form input").keypress(function( event ) {
		var value = $(this).val();
		var dataId = $(this).data('id');	
		if (!value) {
			$("#r"+dataId).removeClass("alert-input");						
		}	
	});
	$(".registro-form select").change(function( event ) {
		var value = $(this).val();
		var dataId = $(this).data('id');	
		if (value != 0) {
			$("#r"+dataId).removeClass("alert-input");						
		}	
	});

	//---------------------------------------------------------------------------
	//				generar codigo de r-genero
	//---------------------------------------------------------------------------
	var

	genero = $("#r-genero"),
	codigo = $("#hab-modal"),
	guardar= $("#r-btnSave"),
	codinpt= $("#r-codImg"),

	validar= function validar(d) {
		var
		dat = d,
		t = 2,
		data = new Array(),
		ar = ['r-titulo','','r-genero','','','','',''];
		for (var i = 0; i < dat.length; i++) {							
			if (dat[i].name == ar[i] && dat[i].value == '') {
				$("#r"+i).addClass("alert-input");
				t -= 1;
			}else{					
				var name = dat[i].name;
				data[name] = dat[i].value;
				$("#r"+i).removeClass("alert-input");	
			}
		}
		data['cont'] = t;
		return data		
	};

	genero.on("change",function () {
		var 
			ruta = "inc/data/interfazUtil.php",
			id   = $(this).val(),			
			id   = id == '' ? 0 : id;
			// ld   = $(this)[0].children.length,
			nm   = $("#r-genero")[0][id].label;				
			// console.log(ld);
		if (id != 0) {
			$("#loader-poster").removeClass("hid");
			setTimeout(function(){
	        $.ajax({
	            url: ruta,
	            type: "POST",
	            data: {id : id,nm:nm},
	            dataType:'json',           
	            success: function(datos) {
					$("#loader-poster").addClass("hid").delay(3).fadeOut();
					var 
						cod = datos.genero[0]['cod'];
						dig = parseInt(datos.genero[0]['nextCod']) + 1;

						if (dig < 10) {
							cod = cod.substring(0, 5)+dig;						
						}else if (dig<100) {
							cod = cod.substring(0, 4)+dig;						
						}else if (dig<1000) {
							cod = cod.substring(0, 3)+dig;						
						}else if (dig<10000) {
							cod = cod.substring(0, 2)+dig;						
						}else {
							cod = "error * limit";												
						}
					codigo.text(cod);
					codigo.attr("data-id",dig);
					codinpt.val(cod);
					
	            }
	        });				
	    	},300);		
		}

	});


	guardar.on("click", function () {		
		var 
		form  = $("#r-form").serializeArray(),
		// urlmg = $("#url-img").val(),
		cod   = $("#hab-modal").attr('data-id');
		urlmg = $("#load-img").attr("data-src");
		uri  = {name:'r-url', value:urlmg},
		dig  = {name:'r-cod', value:cod},

		form.push(uri);
		form.push(dig);			

		form = validar(form);	
		if (form['cont'] == 2) {		
			form = 
			'titulo='+form['r-titulo']+
			'&director='+form['r-director']+
			'&genero='+$("#r-genero")[0][form['r-genero']].id+
			// '&genero='+form['r-genero']+			
			'&anio='+form['r-anio']+
			'&actor='+form['r-actor']+
			'&sinopsis='+form['r-sinopsis']+
			'&url='+form['r-url']+
			'&cod='+form['r-cod'];
			
			$.ajax({
				type 	: 'post',
				url 	: 'inc/data/interfasRegistroVideo.php',
				data 	: form,
				dataType: 'json',				
				before	: function (respons) {
					console.log(respons);
				},
				success : function (respons) {							
					console.log(respons)					
				},
				fail	: function (err) {
					alert(err);
				}
			});			
		}
	});





	//---------------------------------------------------------------------------
	//				eventos modal config
	//---------------------------------------------------------------------------

	var 

	addGenero = $("#btn-add-genero"),
	addModalg = function (p) {

		var 
			otro = "",
			url = "?page="+p;
		$("#modal_genero").html("");							// contenedoe de carga 
		$("#modal-loading").addClass("modal-dialog-width");		// modifica el tamaño del modal a 42px
		$("#cont-loaging").removeClass("hid");					// muestra el icono loading 				
		
		setTimeout(function(){
			$("#modal_genero").load("inc/plantilla/modal_genero.tpl.php"+url, function (response, status, xhr) {				
				if (status == 'error') {
					var data = "<div class='alert alert-danger'>"
							 + "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Mensaje: <br> Error vuelva a intentarlo mas tarde X-Planet"
							 + "</div>"
							 + "<div class='modal-footer modal-footer-secundary'>"
							 + "<button type='button' data-dismiss='modal'  class='btn btn-warning'>Cerrar</button>"
							 + "</div> "
					$(this).html(data);		
				}          					
			});		
			$("#modal-loading").removeClass("modal-dialog-width");
			$("#cont-loaging").addClass("hid");			
		},500);
	};
	addGenero.on("click", function () {	
		addModalg(1);
	});

});