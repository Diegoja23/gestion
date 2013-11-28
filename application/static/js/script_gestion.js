//var fileExtension = "";
var globalUrl = "http://"+document.domain;
$(document).ready(iniEventos);

function iniEventos() {
    var url = window.location.pathname;
    if(url == '/gestion/gestiones' || url == '/gestion/gestiones.php'){
            $("#div_listado_cliente").load(globalUrl+"/gestion/consultas/consultas_gestiones.php",{consulta: "traer_todos"}); 
            $( ".datepicker" ).datepicker();
    }
    else{
        if(url == '/gestion/clientes' || url == '/gestion/clientes.php'){
                $("#div_listado_cliente").load(globalUrl+"/gestion/consultas/consultas_clientes.php",{consulta: "traer_todos"}); 
                //$(".subir_archivo").click(subirElArchivo);
                $(":file").change(cambioElFile);
        }
        else{
            if(url == '/gestion/tramites' || url == '/gestion/tramites.php'){
                if(listar()){
                    $("#div_listado_cliente").load(globalUrl+"/gestion/consultas/consultas_tramites.php",{consulta: "traer_todos"});                    
                    $( ".datepicker" ).datepicker();  
                }                
                agregarDivDatosTramite();
            }
        }
    }

}

$(document).on("click","#btn_agregar_cliente",agregarDivDatosCliente);
$(document).on("click","#btn_agregar_tramite",agregarDivDatosTramite);
//$(document).on("click","#guardar_cliente",guardarCliente);
$(document).on("click","#btn_guardar",guardarCliente);
$(document).on("click",".dato_mostrado",traerClienteElegido);
$(document).on("click",".btn_eliminar",eliminarClienteElegido);
$(document).on("click","#btn_agregar_form_subir_ci",mostrarFormularioSubirCI);
$(document).on("click",".subir_archivo",subirElArchivo);
$(document).on("change",":file",cambioElFile);
$(document).on("click","#btn_guardar_tramite",guardarTramite);

function agregarDivDatosCliente(){    
    if($("#div_formulario_cliente").css("display") == "none"){        
        $("#div_listado_cliente").fadeOut(1500);
        $("#div_formulario_cliente").fadeIn(1500);
        $("#btn_agregar_cliente").text("Mostrar Lista"); 
        cargarFormulario(-1);
        //$("input").prop('disable', false);
    }
    else{        
        
        $("#div_listado_cliente").load(globalUrl+"/gestion/consultas/consultas_clientes.php",{consulta: "traer_todos"});
        $("#div_formulario_cliente").fadeOut(1500);
        $("#div_listado_cliente").fadeIn(1500);
        $("#btn_agregar_cliente").text("Agregar");
        cargarFormulario(-1);
    }
}

function agregarDivDatosTramite(){
    if($("#div_formulario_tramite").css("display") == "none"){        
        $("#div_listado_tramite").fadeOut(1500);
        $("#div_formulario_tramite").fadeIn(1500);
        $("#btn_agregar_tramite").text("Mostrar Lista");
        
        //$("#combo_estado_tramite").css("display","none");
        $(".fecha-fin").css("display","none");
        
        
        var vid_tipo_gestion = $("#div_id_tipo_gestion").text();
        $("#combo_tipo_tramite").load(globalUrl+"/gestion/consultas/consultas_tramites.php",{consulta: "traer_tipos_tramite", id_tipo_gestion: vid_tipo_gestion});
        //cargarFormulario(-1);
        //$("input").prop('disable', false);
    }
    else{
        $("#div_listado_tramite").load(globalUrl+"/gestion/consultas/consultas_tramites.php",{consulta: "traer_todos"});
        $("#div_formulario_tramite").fadeOut(1500);
        $("#div_listado_tramite").fadeIn(1500);
        $("#btn_agregar_tramite").text("Agregar");
    }
}

function listar(){
    return $.isNumeric(($("#div_id_gestion").text()));
}

function guardarTramite(){
    var vdescripcion = $("#txt_descripcion_tramite").val();
    var vtipo_tramite = $("#combo_tipo_tramite option:selected").val();
    var vfecha_inicio = $("#txt_fecha_inicio").val();
    var vid_gestion = $.trim($("#div_id_gestion").text());
    var vid_tipo_gestion = $.trim($("#div_id_tipo_gestion").text());
    $.post(globalUrl+"/gestion/consultas/consultas_tramites.php", {consulta: "agregar_tramite", descripcion:vdescripcion, id_tipo_tramite:vtipo_tramite, fecha_inicio:vfecha_inicio, id_gestion:vid_gestion, id_tipo_gestion:vid_tipo_gestion})
            .done(function(data) {            
                //alert(data);
                //var un_cliente = jQuery.parseJSON(data);
                //cargarFormulario(un_cliente);
                var retorno = parseInt(data);
                if(retorno==1){
                    $("#retorno_borrado").html("<span style='color:green'><strong>Trámite agregado exitosamente!</strong></span>");
                }
                else{
                    $("#retorno_borrado").html("<span style='color:red'><strong>Trámite agregado exitosamente!</strong></span>");
                }
                //$('#content').append(data);
        });
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
			url: globalUrl+"/gestion/consultas/subir_ci.php",  
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
         message = "<img src='data:image/jpeg;base64,"+data;+"' width='300' height='200' alt='embedded folder icon'>";
                            //message =  data;

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
    $.post(globalUrl+"/gestion/consultas/consultas_clientes.php", {consulta: "traer_por_ci",ci: documento})
            .done(function(data) {            
                agregarDivDatosCliente();
                var un_cliente = jQuery.parseJSON(data);
                cargarFormulario(un_cliente);
                //$('#div_ci_cliente').append(data);                
        }, "json");
        //$("input").prop('disable', true);
}

function eliminarClienteElegido(){
    var confirmado = confirm("¿Seguro que desea eliminar este cliente?");
    if(confirmado){
        //var documento = $($(this).parent().children()[2]).text();  
        var documento = $($(this).parent().parent().parent().children()[2]).text();  
        $.post(globalUrl+"/gestion/consultas/consultas_clientes.php", {consulta: "eliminar_por_ci",ci: documento})
                .done(function(data) {
                    $("#retorno_borrado").html(data);
                    //$('#content').append(un_cliente);
            }, "json");
        //$("input").prop('disable', true);
        //ocultamos el borrado
        $(this).parent().parent().parent().fadeOut(1500);       
    }
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
        $.post(globalUrl+"/gestion/consultas/consultas_clientes.php", {consulta: "agregar_cliente",nombre: nombre_cli, apellido: apellido_cli, ci: ci_cli, email: email_cli, telefono: telefono_cli, direccion: direccion_cli, ci_escaneada: ci_escaneada_cli})
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
        $('#div_ci_cliente').html('<iframe id="iframe_ci_cliente" src="http://localhost/gestion/consultas/mostrar_archivo.php?mime=' + un_cliente.adjunto_tipo + '&id=' + un_cliente.adjunto_id + '&from=dato_complementario"></iframe>');
        $('#div_ci_cliente').fadeIn(1500);         
    }
    else{
        $("#txt_nombre_cliente").val("");
        $("#txt_apellido_cliente").val("");
        $("#txt_ci_cliente").val("");
        $("#txt_email_cliente").val("");
        $("#txt_telefono_cliente").val("");
        $("#txt_direccion_cliente").val("");
        $("#txt_ci_cliente").val(""); 
        $('#div_ci_cliente').fadeOut(1500);
    }
}

function retornoSubirArchivo(txt){
    $(".retorno_del_file_agregar_elemento").html(txt);
}
