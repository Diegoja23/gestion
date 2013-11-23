//var fileExtension = "";
$(document).ready(iniEventos);

function iniEventos() {
    $("#div_listado_cliente").load("http://localhost/gestion/consultas/consultas_clientes.php",{consulta: "traer_todos"}); 
    //$(".subir_archivo").click(subirElArchivo);
    $(":file").change(cambioElFile);
}

$(document).on("click","#btn_agregar_cliente",agregarDivDatosCliente);
//$(document).on("click","#guardar_cliente",guardarCliente);
$(document).on("click","#btn_guardar",guardarCliente);
$(document).on("click",".dato_mostrado",traerClienteElegido);
$(document).on("click","#btn_agregar_form_subir_ci",mostrarFormularioSubirCI);
$(document).on("click",".subir_archivo",subirElArchivo);
$(document).on("change",":file",cambioElFile);

function agregarDivDatosCliente(){
    if($("#div_formulario_cliente").css("display") == "none"){         
        $("#div_listado_cliente").fadeOut(1500);
        $("#div_formulario_cliente").fadeIn(1500);
        $("#btn_agregar_cliente").text("Mostrar Lista"); 
        cargarFormulario(-1);
    }
    else{        
        $("#div_listado_cliente").load("http://localhost/gestion/consultas/consultas_clientes.php",{consulta: "traer_todos"});
        $("#div_formulario_cliente").fadeOut(1500);
        $("#div_listado_cliente").fadeIn(1500);
        $("#btn_agregar_cliente").text("Agregar");
    }
}

function subirElArchivo(){
    
		//información del formulario
		var formData = new FormData($(".formulario_archivo")[0]);
                /*var datos_para_mandar = new Array();
                datos_para_mandar['consulta'] = "subir_foto";
                datos_para_mandar['foto'] = formData;*/
		var message = "";	
		//hacemos la petición ajax  
                //$(".retorno_del_file_agregar_elemento").load("http://localhost/gestion/consultas/subir_ci.php",{data: formData});
                //var asdfasdf;
                //var ñkljñlk;
		$.ajax({
			url: "http://localhost/gestion/consultas/subir_ci.php",  
			type: 'POST',
			// Form data
			//datos del formulario
			data: formData,
			//necesario para subir archivos via ajax
			cache: false,
                        //contentType: 'image/jpeg',
                        contentType: false,
			processData: false,
                        
			//mientras enviamos el archivo
			beforeSend: function(){
			    message = $("<span class='before'>Subiendo archivo, por favor espere...</span>");
			    retornoSubirArchivo(message)     	
			},
			//una vez finalizado correctamente
			success: function(data){
			    //message = "<span class='success'>Archivo '" + data + "'ha subido correctamente.</span>";
                            //message = "<img src='" + data:image/jpeg;base64 + "' />";
                            //if (data.IsImage)
                              //  {
       
                            //message = "<img src='"+ data + "' />";
         
                            message =  data;

                            //    }
                            
                            //var lolo = data.post.attachments[0]['images'].full.url
                            //message = ('<div id="nimg" style="background-image: url(' + data.post.attachments[0]['images'].full.url + ')"></div><div id="newstext"><div id="newstitle">' + data.post.title + '</div><div>' + data.post.content + '</div></div>');
			    retornoSubirArchivo(message);
			    //if(isImage(fileExtension))
			    //{
			        //$(".mostrarCI").html(data);
			    //}
			},
			//si ha ocurrido un error
			error: function(){
			    message = $("<span class='error'>Ha ocurrido un error.</span>");
			    retornoSubirArchivo(message);
			}
		});

}

function cambioElFile(){
    //obtenemos un array con los datos del archivo
    var file = $(".archivo")[0].files[0];
    //obtenemos el nombre del archivo
    var fileName = file.name;
    //obtenemos la extensión del archivo
    //var fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
    //obtenemos el tamaño del archivo
    var fileSize = file.size;
    //obtenemos el tipo de archivo image/png ejemplo
    var fileType = file.type;
    //mensaje con la información del archivo
    retornoSubirArchivo("<em>Archivo para subir: "+fileName+", peso total: "+fileSize+" bytes.</em>");
}

function mostrarFormularioSubirCI(){
    if($("#div_formulario_subir_ci").css("display") == "none"){ 
        $("#div_formulario_subir_ci").fadeIn(1500);
    }
    else{
        $("#div_formulario_subir_ci").fadeOut(1500);
        $("#input_file_cedula").val("");
        retornoSubirArchivo("");
    }    
}

function traerClienteElegido(){
    /*var padre = $(this).parent();
    var hijo = padre.children()[2];
    var documento = $(hijo).text();*/
    var documento = $($(this).parent().children()[2]).text();
    $.post("http://localhost/gestion/consultas/consultas_clientes.php", {consulta: "traer_por_ci",ci: documento})
            .done(function(data) {            
                agregarDivDatosCliente();
                var un_cliente = jQuery.parseJSON(data);
                cargarFormulario(un_cliente);
                //$('#content').append(un_cliente);
        }, "json");
}

function guardarCliente(){
    var nombre_cli = $.trim($("#txt_nombre_cliente").val());
    var apellido_cli = $.trim($("#txt_apellido_cliente").val());
    var ci_cli = $.trim($("#txt_ci_cliente").val());
    var email_cli = $.trim($("#txt_email_cliente").val());
    var telefono_cli = $.trim($("#txt_telefono_cliente").val());
    var direccion_cli = $.trim($("#txt_direccion_cliente").val());
    //var archivo = $(".archivo")[0].files[0];
    var ci_escaneada_cli = -1;
    //if(archivo != undefined){
      //  ci_escaneada_cli = new FormData($(".formulario_archivo")[0]);
    //}
    
    var valido = validarDatosIngresados(nombre_cli,apellido_cli,ci_cli,email_cli,telefono_cli,direccion_cli);
    if(valido == 1){
        $.post("http://localhost/gestion/consultas/consultas_clientes.php", {consulta: "agregar_cliente",nombre: nombre_cli, apellido: apellido_cli, ci: ci_cli, email: email_cli, telefono: telefono_cli, direccion: direccion_cli, ci_escaneada: ci_escaneada_cli})
            .done(function(data) {
            if(parseInt(data) == 1){
                $("#retorno_ajax").html("<strong style='color:green;'>El cliente "+nombre_cli+" "+apellido_cli+" se ingresó con éxito</strong>");
                cargarFormulario(-1);
            }
            else{
                $("#retorno_ajax").append(data);
                //$("#retorno_ajax").html("<strong style='color:red;'>¡El cliente "+nombre_cli+" "+apellido_cli+" no se pudo ingresar!</strong>");
            }
        });
    }
    else{
        alert("Datos incorrectos. No se puedo guardar");
    }
    //$("#retorno_ajax").load("http://localhost/gestion/consultas/consultas_clientes.php",{consulta: "agregar_cliente",nombre: nombre_cli, apellido: apellido_cli, ci: ci_cli, email: email_cli, telefono: telefono_cli, direccion: direccion_cli, ci_escaneada: ci_escaneada_cli});
}
//$( document ).on( "change",".elegir_familia", cambiarElemento );

function validarDatosIngresados(nombre_cli,apellido_cli,ci_cli,email_cli,telefono_cli,direccion_cli){
    if(nombre_cli != ""){
        return 1;
    }
    else{
        return -1;
    }
}

function cargarFormulario(un_cliente){
    if(un_cliente != -1){
        $("#txt_nombre_cliente").val(un_cliente.nombre);
        $("#txt_apellido_cliente").val(un_cliente.apellido);
        $("#txt_ci_cliente").val(un_cliente.ci);
        $("#txt_email_cliente").val(un_cliente.email);
        $("#txt_telefono_cliente").val(un_cliente.telefono);
        $("#txt_direccion_cliente").val(un_cliente.direccion);
        $("#txt_direccion_cliente").attr("locked","true");
        //$("#txt_ci_cliente").val(""); 
    }
    else{
        $("#txt_nombre_cliente").val("");
        $("#txt_apellido_cliente").val("");
        $("#txt_ci_cliente").val("");
        $("#txt_email_cliente").val("");
        $("#txt_telefono_cliente").val("");
        $("#txt_direccion_cliente").val("");
        $("#txt_ci_cliente").val(""); 
    }
}

function retornoSubirArchivo(txt){
    $(".retorno_del_file_agregar_elemento").html(txt);
}
