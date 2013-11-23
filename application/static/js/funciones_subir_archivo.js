$(document).ready(function(){

	$(".span_respuestas_archivos").hide();
	//queremos que esta variable sea global
	var fileExtension = "";
	//función que observa los cambios del campo file y obtiene información
	$(':file').change(function()
	{
		//obtenemos un array con los datos del archivo
		var file = $(".archivo")[0].files[0];
		//obtenemos el nombre del archivo
		var fileName = file.name;
		//obtenemos la extensión del archivo
		fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
		//obtenemos el tamaño del archivo
		var fileSize = file.size;
		//obtenemos el tipo de archivo image/png ejemplo
		var fileType = file.type;
		//mensaje con la información del archivo
		showMessage("<span class='info'>Archivo para subir: "+fileName+", peso total: "+fileSize+" bytes.</span>");
	});

	//al enviar el formulario
	$('.subir_archivo_generico').click(function(){
		//información del formulario
		var formData = new FormData($(".formulario_archivo")[0]);
                var datos_para_mandar = new Array();
                datos_para_mandar['consulta'] = "subir_foto";
                datos_para_mandar['foto'] = formData;
		var message = "";	
		//hacemos la petición ajax  
		$.ajax({
			url: "http://localhost/gestion/consultas/consultas_clientes.php",  
			type: 'POST',
			// Form data
			//datos del formulario
			data: formData,
			//necesario para subir archivos via ajax
			cache: false,
			contentType: false,
			processData: false,
			//mientras enviamos el archivo
			beforeSend: function(){
			    message = $("<span class='before'>Subiendo archivo, por favor espere...</span>");
			    showMessage(message)     	
			},
			//una vez finalizado correctamente
			success: function(data){
			    message = $("<span class='success'>Archivo ha subido correctamente.</span>");
			    showMessage(message);
			    if(isImage(fileExtension))
			    {
			        $(".mostrarCI").html(data);
			    }
			},
			//si ha ocurrido un error
			error: function(){
			    message = $("<span class='error'>Ha ocurrido un error.</span>");
			    showMessage(message);
			}
		});
	});
})

//como la utilizamos demasiadas veces, creamos una función para 
//evitar repetición de código
function showMessage(message){
	$(".span_respuestas_archivos").html("").show();
	$(".span_respuestas_archivos").html(message);
}

//comprobamos si el archivo a subir es una imagen
//para visualizarla una vez haya subido
function isImage(extension)
{
	switch(extension.toLowerCase()) 
	{
	    case 'jpg': case 'gif': case 'png': case 'jpeg':
	        return true;
	    break;
	    default:
	        return false;
	    break;
    }
}