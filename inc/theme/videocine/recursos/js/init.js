$( function () {
	//------------------------------------------------------------------------
	//  			Validadcions 
	//------------------------------------------------------------------------

	$("#btn-login").on("click", function () {
		var data = $("#data-login"),
			url   = 'inc/data/login.php';
		proxy(data,url);
	});
	var 

	login = function login(d) {
		var dat = d.serializeArray();		
		var aler;
		var data = [];
		var x = 0;
		for (var i = 0; i < dat.length; i++) {			
			if (dat[i].value == '') {
				aler = "el campo "+ dat[i].name + " est&aacute; vac&iacute;o"; 
				$("#aler_"+i).html(aler);							
			} else {
				var name = dat[i].name;
				data[name] = dat[i].value;
				$("#aler_"+i).html("");				
				x++;
			}
		}
		data['cont'] = x;
		return data;			
	},
	proxy = function proxy(data,url) {		
		var dat = login(data);					
		if (dat['cont'] > 1) {
			$.ajax({
				type 	: 'post',
				url 	: url,				
				data 	: {login:dat['login'],clave:dat['clave']},
				dataType: 'json',				
				before	: function () {
					console.log(respons);
				},
				success : function (respons) {
					if (respons.success == true) {
						if (respons.op == 1) {
							document.location=respons.self;							
						}
					}else{
						$("#aler_3").html(respons.error);								
					}
				},
				fail	: function (err) {
					alert(err);
				}
			});		
		}
	}	
});