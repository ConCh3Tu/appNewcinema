$(function() {

	// We can attach the `fileselect` event to all file inputs on the page
	$(document).on('change', ':file', function() {
		
		var input = $(this),
		numFiles = input.get(0).files ? input.get(0).files.length : 1,
		label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
		input.trigger('fileselect', [numFiles, label]);
	});

  // We can watch for our custom `fileselect` event like this
  $(document).ready( function() {
      $(':file').on('fileselect', function(event, numFiles, label) {
		var cod = $("#hab-modal").text();
		// var dd = {name:'cod',value:cod}
		var formData = new FormData($("#formulario")[0]);

		// console.log(formData);
		// formData.push(dd);


		var ruta = "ajax-imagen.php";

		var input = $(this).parents('.input-group').find(':text'),
		log = numFiles > 1 ? numFiles + ' archivos seleccionados' : label;		



		if( input.length ) {
			input.val(log);		
			$("#img-poster").html("no existen datos para mostrar.");
		} else {
			if(log) {			
				$("#url-img").val(log);
				$("#loader-poster").removeClass("hid");
				setTimeout(function(){
	            $.ajax({
	                url: ruta,
	                type: "POST",
	                data: formData,
	                contentType: false,
	                processData: false,
	                success: function(datos)
	                {

						$("#loader-poster").addClass("hid").delay(3).fadeOut();
	                    $("#img-poster").html(datos);

	                }
	            });				
	        	},300);
			}
		}

      });
  });
  
});