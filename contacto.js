// JavaScript Document
 
// Función para recoger los datos de PHP según el navegador, se usa siempre.
function objetoAjax(){
	var xmlhttp=false;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
 
	try {
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	} catch (E) {
		xmlhttp = false;
	}
}
 
if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
	  xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}
 
//Función para recoger los datos del formulario y enviarlos por post  
function enviarFormulario(){
	var $captcha = $( '#recaptcha' ),
    response = grecaptcha.getResponse();
  
	if(response.length === 0) {
	    $( '.msg-error').text( "Debe validar el captcha" );
	    if( !$captcha.hasClass( "error" ) ){
	      $captcha.addClass( "error" );
	    }
	} 
	else 
	{
	    $( '.msg-error' ).text('');
	    $captcha.removeClass( "error" );
	
		divResultado = document.getElementById('resultado');

		nombre = document.form_contacto.nombre.value;
		telefono = document.form_contacto.telefono.value;
		mail = document.form_contacto.mail.value;
		mensaje = document.form_contacto.mensaje.value;

		var patron=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;

		if((nombre == "") || (telefono == "") || (mail == "") || (mensaje == ""))
		{
			$('#resultado').html('Por favor, complete todos los campos');
		}
		else
		{
			if(mail.search(patron)!=0)
			{
				$('#resultado').html('El correo tiene un formato incorrecto.');
			}
			else
			{
				if(telefono.length < 7)
				{
					$('#resultado').html('El tel&eacute;fono debe tener al menos 7 d&iacute;gitos.');
				}
				else
				{
				  	ajax=objetoAjax();

				  	ajax.open("POST", "contacto_envio.php",true);
				  	ajax.onreadystatechange=function() {
				  		if (ajax.readyState==4) {
				  			$('#resultado').css('color','green');
							divResultado.innerHTML = ajax.responseText
							LimpiarCampos();
						}
					}
					ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
					ajax.send("nombre="+nombre+"&telefono="+telefono+"&mail="+mail+"&mensaje="+mensaje)
				}
		}
	}
 }
}
 
//función para limpiar los campos
function LimpiarCampos(){
  document.form_contacto.nombre.value="";
  document.form_contacto.telefono.value="";
  document.form_contacto.mail.value="";
  document.form_contacto.mensaje.value="";
}