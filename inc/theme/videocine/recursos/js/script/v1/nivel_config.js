$(function () {
	

	var 	
		guardar  = $("#n-btnSave"),
		modifica = $("#n-btnUpdate"),
		eliminar = $("#n-btnDelete"),
		cancelar = $("#n-btnCancel"),
		decline  = $("#mg-btnCancel"),
		validar  = function (d) {
			var
				dat = d,
				t = 1,
				data = new Array(),
				ar = ['n-nivel','',''];
				for (var i = 0; i < dat.length; i++) {							
					if (dat[i].name == ar[i] && dat[i].value == '') {
						$("#n"+i).addClass("alert-input");
						t -= 1;
					}else{					
						var name = dat[i].name;
						data[name] = dat[i].value;
						$("#n"+i).removeClass("alert-input");	
					}
				}
				data['cont'] = t;
				return data				
		},
		save     = function (data,maxTd) {
			var 
				form = "",
				name = "";
			form = validar(data);
			name = form['n-nivel'];

			if (form['cont'] == 1) {
				form = 
					'm-detalle='+form['n-nivel']+
					'&m-defi='+form['n-detalle']+
					'&m-cod='+form['n-cod'];				
				$.ajax({
					type 	: 'post',
					url 	: 'inc/data/iNivel/iSaveNivel.php',
					data 	: form,
					dataType: 'json',				
					before	: function (respons) {
						console.log(respons);
					},
					success : function (respons) {							
						// console.log(respons);
						var 
							fila = respons.data;
						if (respons.success == true) {						
							var 
								table= $("#table-list tbody"),							
								div  = $("#alert-ajax-g"),
								dat = ""
									+ "<tr id='_"
										+ fila.niv_id
										+ "'>"		
									+ "<td>"+ fila.niv_id +"</td>"
									+ "<td>"+ fila.niv_detalle +"</td>"									
									+ "<td> <span class='d-inline-block text-truncate'  style='max-width: "+ maxTd +"px;' >"
									+ fila.niv_defi +" </span>"
									+"</td>"
									+ "<td class='text-right'>"							
									+ " <a href='javascript:void(0)' class='btn-mod-nivel' data-id='"
									+ fila.niv_id +"'  data-key='"
									+ fila.niv_key +"'>"
									+ "<i class='fa fa-pencil-square-o fa-1x fa-fw text-success disabled' aria-hidden='true'></i>"
									+ "</a> "
									+ "<a href='javascript:void(0)' class='btn-delet-nivel' data-id='"
									+ fila.niv_id
									+ "'>"
									+ "<i class='fa fa-trash-o fa-1x fa-fw text-danger' aria-hidden='true'></i>"
									+ "</a>"
									+"</td>"			
									+ "</tr>",
								data= "<div class='alert alert-success alert-dismissible fade show' role='alert'>"
									+ "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>"
									+ "<span aria-hidden='true'>&times;</span>"
									+ "</button>"
									+ "<h6 class='alert-heading'>"
									+ "<i class='fa fa-check-square-o fa-1x fa-fw ' aria-hidden='true'></i> Éxito:</h6>"
									+ "<strong>"
									+ (name == undefined ? '' : name)
									+ "</strong> Agregado Correctamente.";
									+ "</div>";								 												

							table.append(dat);		

							div.html("");			 																		 
							div.append(data);
						}else{
							var
								div = $("#alert-ajax-g"),
								data = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>"
									 + "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>"
									 + "<span aria-hidden='true'>&times;</span>"
									 + "</button>"
									 + "<h6 class='alert-heading'>"
									 + "<i class='fa fa-exclamation-triangle fa-1x fa-fw ' aria-hidden='true'></i> Error:</h6>"
									 + "Vuelva a intentarlo mas tarde.";
									 + "</div>";					
							div.html("");			 												
							div.append(data);							
						}


						$("a.btn-delet-nivel").on("click", function () {								
							modalShow($(this));
						});	
						//------------------------------------------------------------
						//				control icon edit de table 
						//------------------------------------------------------------
						$("a.btn-mod-nivel").on("click", function () {	
							var data = $(this),
								idg  = data.data('id'),
								kyg  = data.data('key'),
								nmg  = $("#_"+idg+" td:nth-child(2)").text(), 
								dfg  = $("#_"+idg+" td:nth-child(3) span").text();

							$("#n-nivel").val(nmg),
							$("#n-key").val(kyg);
							$("#n-detalle").val(dfg);
							
							guardar.fadeOut(300);
							setTimeout(function() {
								modifica.fadeIn("slow");
								cancelar.fadeIn("slow");
							}, 300);
						});										
					},
					fail	: function (err) {
						alert(err);
					}
				});
				return true;
			}		
		},
		update   = function (data) {
			var 
				form = "",
				name = "";
			form = validar(data);
			// console.log(form);
			name = form['n-nivel'];
			if (form['cont'] == 1) {
				form = 
					'm-detalle='+form['n-nivel']+
					'&m-defi='+form['n-detalle']+
					'&m-detalle-id='+form['n-key'];	
				$.ajax({
					type 	: 'post',
					url 	: 'inc/data/iNivel/iUpdateNivel.php',
					data 	: form,
					dataType: 'json',				
					before	: function (respons) {
						console.log(respons);
					},
					success : function (respons) {							
						console.log(respons);
						if (respons.success == true) {						
							var 
								td1  = "#_"+respons.data.niv_id+" td:nth-child(2)",
								td2  = "#_"+respons.data.niv_id+" td:nth-child(3) span",
								div  = $("#alert-ajax-g"),
								data = "<div class='alert alert-success alert-dismissible fade show' role='alert'>"
									 + "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>"
									 + "<span aria-hidden='true'>&times;</span>"
									 + "</button>"
									 + "<h6 class='alert-heading'>"
									 + "<i class='fa fa-check-square-o fa-1x fa-fw ' aria-hidden='true'></i> Éxito:</h6>"
									 + "<strong>"
									 + (name == undefined ? '' : name)
									 + "</strong> Modificado Correctamente.";
									 + "</div>";

							div.html("");	 
							div.append(data);			
							$(td1).text(respons.data.niv_detalle);		
							$(td2).text(respons.data.niv_defi);		
						}else{
							var
								div = $("#alert-ajax-g"),
								data = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>"
									 + "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>"
									 + "<span aria-hidden='true'>&times;</span>"
									 + "</button>"
									 + "<h6 class='alert-heading'>"
									 + "<i class='fa fa-exclamation-triangle fa-1x fa-fw ' aria-hidden='true'></i> Error:</h6>"
									 + "Vuelva a intentarlo mas tarde.";
									 + "</div>";					
							div.html("");			 												
							div.append(data);							
						}					
					},
					fail	: function (err) {
						alert(err);
					}
				});
				return true;
			}			

		},
		erase  = function (id) {
			var 
				form = id;
				$.ajax({
				type 	: 'post',
				url 	: 'inc/data/iNivel/iDeleteNivel.php',
				data 	: form,
				dataType: 'json',				
				before	: function (respons) {
					console.log(respons);				
				},
				success : function (respons) {							
						console.log(respons);	

					if (respons.success == true && respons.data.rs == true) {
						var
							id   = respons.data.id,
							x    = $("#_"+id),							
							div  = $("#alert-ajax-g"),
							data = "<div class='alert alert-success alert-dismissible fade show' role='alert'>"
								 + "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>"
								 + "<span aria-hidden='true'>&times;</span>"
								 + "</button>"
								 + "<h6 class='alert-heading'>"
								 + "<i class='fa fa-check-square-o fa-1x fa-fw ' aria-hidden='true'></i> Éxito:</h6>"
								 + "<strong>"
								 + (name == undefined ? '' : name)
								 + "</strong> Eliminado Correctamente.";
								 + "</div>";
						div.html("");
						div.append(data);			
						x.remove().fadeOut(3000);
					}else{
						var
							div  = $("#alert-ajax-g"),
							data = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>"
								 + "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>"
								 + "<span aria-hidden='true'>&times;</span>"
								 + "</button>"
								 + "<h6 class='alert-heading'>"
								 + "<i class='fa fa-check-square-o fa-1x fa-fw ' aria-hidden='true'></i> Error:</h6>"
								 + "Vuelva a intentarlo mas tarde.";
								 + "</div>";						 
						div.html("");
						div.append(data);									
					}					
				},
				fail	: function (err) {
					alert(err);
				}
			});		
			return true;
		}
		codigo   = function (val, special) {
			return getCod(val, special);
		},
		getCod   = function(val, special) {
		    var iteration = 0;
		    var codigo = "";
		    var randomCodigo;
		    if (special == undefined) {
		      var special = false;
		    }
		    while (iteration < val ) {
		      // randomCodigo = (Math.floor((Math.random() * 100)) % 94) + 33;
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
		};
	
	guardar.on("click",  function () {		
		var 				
			form  = $("#n-form"),			
			codg  = codigo(21,null)+"=",
			cod   = {name:'n-cod', value:codg},
			data  = form.serializeArray();  
			sccess= false;
		data.push(cod);	
		var widthTd =  $( "tr th:nth-child(3)").width();
		sccess = save(data,widthTd);
		if (sccess == true) {
			form[0].reset();
		}
	});
	modifica.on("click", function () {		
		var 				
			form  = $("#n-form"),			
			data  = form.serializeArray();  
			sccess= false;
		sccess = update(data);
		if (sccess == true) {
			form[0].reset();
			modifica.fadeOut(300);
			cancelar.fadeOut(300);
			setTimeout(function() {
				guardar.fadeIn("slow");				
			},300);
		}
	});
	eliminar.on("click", function () {
		var 
			form = $("#mg-form").serialize(),
			queryOk = false;
		queryOk = erase(form);
		if (queryOk) {
			$("#modal-nivel-delete").modal('hide');			
		}									
	});
	cancelar.on("click", function () {
		var 				
			form  = $("#n-form");
		form[0].reset();	
		modifica.fadeOut(300);			
		cancelar.fadeOut(300);
		setTimeout(function() {
			guardar.fadeIn("slow");				
		}, 300);
	});
	decline.on("click", function () {
		$("#modal-nivel-delete").modal('hide');		
	});









	//-------------------------------------------------------------------------
	//					listar table  + buscador
	//-------------------------------------------------------------------------
	var 
		buscar      = $("#n-btnSearch"),
		buscarEnter = $("#n-search"), 
		navegar     = $("#nav-paginacion"),
		paginacion  = function (page,data,maxTd) {
			var 
				form = data+"&page="+page;

			// console.log(form);
			$("#table-list tbody").html("");
			$("#sin-r").fadeOut(500);

			setTimeout(function() {
				$.ajax({
					type 	: 'post',
					url 	: 'inc/data/iNivel/iSelectNivel.php',
					data 	: form,
					dataType: 'json',				
					before	: function (respons) {
						console.log(respons);
					},
					success : function (respons) {							
						// console.log(respons);					
						if (respons.success == true && respons.data != null) {								
							$.each(respons.data, function( i,fila) {
								var 
									table = $("#table-list tbody"),
									str   = fila.niv_defi,
									dat = ""
										+ "<tr id='_"
										+ fila.niv_id
										+ "'>"		
										+ "<td>"+ parseInt(i+1) +"</td>"
										+ "<td>"+ (fila.niv_detalle == undefined ? '' : fila.niv_detalle) +"</td>"
										+ "<td><span class='d-inline-block text-truncate'  style='max-width: "+ maxTd +"px;' >"
										+ fila.niv_defi +" </span>"
										+"</td>"
										+ "<td class='text-center'>"									
										+ " <a href='javascript:void(0)' class='btn-mod-nivel' data-id='"
										+ fila.niv_id +"'  data-key='"
										+ fila.niv_key +"'>"
										+ "<i class='fa fa-pencil-square-o fa-1x fa-fw text-success' aria-hidden='true'></i>"
										+ "</a> "
										+ "<a href='javascript:void(0)' class='btn-delet-nivel' data-id='"
										+ fila.niv_id
										+ "'>"
										+ "<i class='fa fa-trash-o fa-1x fa-fw text-danger' aria-hidden='true'></i>"
										+ "</a>"
										+"</td>"												
										+ "</tr>";
								$("#loading-data").fadeOut("slow");
								table.append(dat);							

							});
							//------------------------------------------------------------
							//				llama a la funcion paginacion manda el total de resultdo + num pagina 
							//------------------------------------------------------------
							loadLinkPaginacion(respons.totalCount,respons.totalPagina,page);

							//------------------------------------------------------------
							//				control icon edit de table 
							//------------------------------------------------------------
							$("a.btn-mod-nivel").on("click", function () {								
								var data = $(this),
									idg  = data.data('id'),
									kyg  = data.data('key'),
									nmg  = $("#_"+idg+" td:nth-child(2)").text(), 
									dfg  = $("#_"+idg+" td:nth-child(3) span").text();

								$("#n-nivel").val(nmg),
								$("#n-key").val(kyg);
								$("#n-detalle").val(dfg);
								
								guardar.fadeOut(300);
								setTimeout(function() {
									modifica.fadeIn("slow");
									cancelar.fadeIn("slow");
								}, 300);
							});

							$("a.btn-delet-nivel").on("click", function () {								
								modalShow($(this));
							});

						}else {
							$("#nav-paginacion ul").html("");	
							$("#loading-data").fadeOut(300);
							$("#sin-r").fadeIn(1000);
						}
					},
					fail	: function (err) {
						alert(err);
					}
				});	
			},1000);
		},
		modalShow   = function (idGenero) {			
			var 
				data = idGenero,
				idg  = data.data('id'),
				name = $("#_"+idg+" td:nth-child(2)").text(),
				modal= $("#modal-nivel-delete");

			$(".msg-modal").text(name);
			$(".modal-body input").val(idg);
			modal.modal('show');			
		},
		loadLinkPaginacion = function (totalCont,totalPage,page) {		
			var 
				total = totalCont,
				total_paginas = totalPage,
				pagen = page;
			
			if (total_paginas > 0) {
				if (pagen != 0) {
					var 
						min = pagen == 1 ? 'disabled': '',
						a = ""
						+ "<li class='page-item "+min+"'>"							
						+ "<a class='page-link' href='' tabindex='-1' data='"+(pagen-1)+"'>Anterior</a>"	
						+ "</li>";
					for(var i = 1; i <= total_paginas; i++){
						if (pagen == i) {
							a += "<li class='page-item active'><span class='page-link'>"
							  + i
							  + "<span class='sr-only'>...</span></span></li>";							
						}else {
							a += "<li class='page-item'><a class='page-link' href='' data='"+i+"'>"
							  + i
							  + "</a></li>";
						}
					}
					if (pagen != total_paginas) {
						a 	+= "<li class='page-item'>"
							+  "<a class='page-link' href='' data='"
							+  (parseInt(pagen) + 1)
							+  "' >Siguiente</a>"
							+  "</li>";						
					}
				}    					
			}

			$("#nav-paginacion ul").html("");	
			$("#nav-paginacion ul").append(a);	
					
		};

	buscar.on("click", function () {
		var
			form = $("#form-search").serialize(),
			widthTd =  $( "tr th:nth-child(3)").width();		

		$("#loading-data").fadeIn(300);
		paginacion(1,form,widthTd-6);		
		
	});
	buscarEnter.on("keypress", function (e) {				
		if(e.which == 13) {
			var
				form = $("#form-search").serialize(),
				widthTd =  $( "tr th:nth-child(3)").width();		
			$("#loading-data").fadeIn(300);
		paginacion(1,form,widthTd-6);		
		e.preventDefault();
		}
	});
	
	
	//------------------------------------------------------------
	//				llama load paginacion y la vez manda page
	//------------------------------------------------------------
	navegar.on("click","a", function (e) {
		var 
			page = $(this).attr('data'),
			form = $("#form-search").serialize(),			
			widthTd =  $( "tr th:nth-child(3)").width();		
		$("#loading-data").fadeIn(300);			
		paginacion(page,form,widthTd-6);		
		e.preventDefault();
	});

	var widthTd =  $( "tr th:nth-child(3)").width();
	paginacion(1,'n-search=',widthTd+ 250);

	$( window ).resize(function() {
	  	var anchoTd = $("tr td:nth-child(3)").width(),
	  		maxTd   = anchoTd+"px",
	  		td      = $("tr td:nth-child(3) span");
		td.css("max-width", maxTd);
	});			
});