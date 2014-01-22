//var fileExtension = "";
var globalUrl = "http://"+document.domain;
var plantilla;
var GLOBAL_id_gestion;
var GLOBAL_id_tramite;
var GLOBAL_id_tipo_tramite;
var GLOBAL_documento_cliente;
var GLOBAL_id_cliente;
$(document).ready(iniEventos);

function iniEventos() {
    var url = window.location.pathname;
    if(url == '/gestion/gestiones' || url == '/gestion/gestiones.php'){
            $("#div_listado_gestion").load(globalUrl+"/gestion/consultas/consultas_gestiones.php",{consulta: "traer_todos"}); 
            $( ".datepicker" ).datepicker({dateFormat:"dd/mm/yy"});
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
                    $("#div_listado_tramite").load(globalUrl+"/gestion/consultas/consultas_tramites.php",{consulta: "traer_todos"});
                    //$("#div_listado_cliente").load(globalUrl+"/gestion/consultas/consultas_clientes.php",{consulta: "traer_todos"});
                    $( ".datepicker" ).datepicker({dateFormat:"dd/mm/yy"});  
                }    
                //agregarDivDatosTramite();
            }
            else{
                if(url == '/gestion/plantillas' || url == '/gestion/plantillas.php'){
                    $("#div_listado_plantillas").load(globalUrl+"/gestion/consultas/consultas_plantillas.php",{consulta: "traer_todos"}); 
                    //$(".subir_archivo").click(subirElArchivo);
                    $(":file").change(cambioElFile);
                }
            }
        }
    }

}


/*asignar eventos CLIENTES*/
$(document).on("click","#btn_agregar_cliente",agregarDivDatosCliente);
$(document).on("click","#btn_mostrar_lista_clientes",agregarDivListaClientes);
$(document).on("click","#btn_guardar",guardarCliente);
$(document).on("click",".dato_mostrado_cliente",traerClienteElegidoClicNombre);
$(document).on("click",".btn_ver_cliente",traerClienteElegidoClicIcono);
$(document).on("click",".adjunto_cliente",traerListaAdjuntosDeCliente);
$(document).on("click",".btn_eliminar_cliente",eliminarClienteElegido);
$(document).on("click","#btn_agregar_form_subir_ci",mostrarFormularioSubirCI);
$(document).on("click",".subir_archivo",subirElArchivo);
$(document).on("click",".subir_archivo_adjunto_cliente",subirElArchivoAdjuntoParaCliente);
$(document).on("change",":file",cambioElFile);
$(document).on("click",".btn_ver_adjunto_de_un_cliente",ver_adjunto_seleccionado_del_cliente);
$(document).on("click",".btn_eliminar_adjunto_de_un_cliente",eliminar_adjunto_seleccionado_del_cliente);

/*asignar eventos GESTIONES*/
$(document).on("click","#btn_agregar_gestion",agregarDivDatosGestion);
$(document).on("click","#btn_mostrar_lista_gestiones",agregarDivListaGestiones);
$(document).on("click","#btn_finalizar_gestion",finalizarGestion);
$(document).on("click","#btn_agregar_cliente_a_grupo",agregarClienteAGrupoSelector);
$(document).on("click","#btn_quitar_cliente_a_grupo",quitarClienteAGrupoSelector);
$(document).on("click","#btn_guardar_gestion",guardarGestion);
$(document).on("click",".dato_mostrado_gestion",traerGestionElegidaClicNombre);
$(document).on("click",".btn_ver_gestion",traerGestionElegidaClicIcono);

/*asignar eventos TRÁMITES*/
$(document).on("click","#btn_agregar_tramite",agregarDivDatosTramite);
$(document).on("click","#btn_mostrar_lista_tramites",agregarDivListaTramite);
$(document).on("click",".dato_mostrado_tramite",traerTramiteElegido);
$(document).on("click",".btn_ver_tramite",traerTramiteElegido); 
$(document).on("click","#btn_guardar_tramite",guardarTramite);
$(document).on("click","#btn_finalizar_tramite",finalizarTramite);
$(document).on("click","#btn_agregar_adjunto",visibilidadFormularioSubirAdjunto);
$(document).on("click","#btn_mostrar_dialog_plantilla",mostrarDialogPlantilla);
$(document).on("change","#combo_tipo_tramite",cambioTipoTramite);
$(document).on("click",".subir_archivo_tramite",subirElArchivo_tramite);
$(document).on("click",".btn_eliminar_tramite",eliminarTramiteElegido);
$(document).on("click",".btn_ver_adjunto",ver_adjunto_seleccionado);
$(document).on("click",".btn_eliminar_adjunto",eliminar_adjunto_seleccionado);

/*asignar eventos PLANTILLAS*/
$(document).on("click","#btn_agregar_plantilla",agregarDivDatosPlantilla);
$(document).on("click","#btn_mostrar_lista_plantillas",agregarDivListaPlantillas);
$(document).on("click",".dato_mostrado_tipo_tramite",traerTipoTramiteElegido);
$(document).on("click",".btn_ver_tipo_tramite",traerTipoTramiteElegido); 
$(document).on("click",".btn_eliminar_tipo_tramite",eliminarTipoTramiteElegido); 
$(document).on("click","#btn_mostrar_dialog_plantilla_tt",mostrarDialogPlantilla_tt);
$(document).on("click","#btn_guardar_plantilla",guardarTipoTramite);



/*---------------------------------------------------------------------------------------------------------------
  ---------------------------------------------------------------------------------------------------------------
  MÉTODOS DE CLIENTE
  ---------------------------------------------------------------------------------------------------------------
  ---------------------------------------------------------------------------------------------------------------*/
function agregarDivDatosCliente(){    
    //if($("#div_formulario_cliente").css("display") == "none"){        
        $("#div_listado_cliente").fadeOut(1500);        
        $("#btn_agregar_cliente").fadeOut(1500);
        $("#btn_mostrar_lista_clientes").fadeIn(1500);        
        $("#div_formulario_cliente").fadeIn(1500);
        //$("#btn_agregar_cliente").text("Mostrar Lista"); 
        cargarFormularioCliente(-1);
        //$("input").prop('disable', false);
    //}
    //else{        
        
        
    //}
}

function agregarDivAdjuntosCliente(){        
        $("#div_listado_cliente").fadeOut(1500);        
        $("#btn_agregar_cliente").fadeOut(1500);                
        $("#div_formulario_cliente").fadeOut(1500);
        $("#btn_mostrar_lista_clientes").fadeIn(1500);
        $("#div_formulario_adjuntos_cliente").fadeIn(1500);        
        cargarFormularioCliente(-1);
}

function agregarDivListaClientes(){
    $("#div_listado_cliente").load(globalUrl+"/gestion/consultas/consultas_clientes.php",{consulta: "traer_todos"});
    $("#div_formulario_cliente").fadeOut(1500);
    $("#btn_mostrar_lista_clientes").fadeOut(1500);
    $("#div_formulario_adjuntos_cliente").fadeOut(1500);
    $("#btn_agregar_cliente").fadeIn(1500);
    $("#div_listado_cliente").fadeIn(1500);
    //$("#btn_agregar_cliente").html('Agregar <i class="fa fa-list"></i>');
    cargarFormularioCliente(-1);
}

function listar(){
    return $.isNumeric(($("#span_id_gestion").text()));
}

function subirElArchivo(){      
		//información del formulario
		var formData = new FormData($(".formulario_archivo")[0]);
                /*var datos_para_mandar = new Array();
                datos_para_mandar['consulta'] = "subir_foto";
                datos_para_mandar['foto'] = formData;*/
		var message = "";	
		//hacemos la petición ajax  
                //$(".retorno_del_file_agregar_elemento").load("'+globalUrl+'/gestion/consultas/subir_ci.php",{data: formData});
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

function subirElArchivoAdjuntoParaCliente(){     
    //chequea nombre del archivo
    if($('#txt_nombre_adjunto').val() != ''){
    //información del formulario
		var formData = new FormData($(".formulario_archivo_para_adjunto")[0]);
		var message = "";	
		$.ajax({
			url: globalUrl+"/gestion/consultas/subir_adjunto.php",  
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
                            //message = "<img src='data:image/jpeg;base64,"+data;+"' width='300' height='200' alt='embedded folder icon'>";
                            //retornoSubirArchivo(message);
                            retornoSubirArchivo('<span>El archivo <strong>'+data+'</strong> fue subido exitosamente</span>');
                            agregarAdjuntoALosDelCliente(data);
                            //var id_adjunto = datos_adjunto.id_adjunto;
                            
                            $(".formulario_archivo_tramite").fadeOut(1500);
			},
			//si ha ocurrido un error
			error: function(){
			    message = $("<span class='error'>Ha ocurrido un error.</span>");
			    retornoSubirArchivo(message);
			}
		});
    }
    else{
        alert('Debe agregarle un nombre al adjunto');
    }

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

function traerClienteElegidoClicNombre(){
    var documento = $($(this).parent().children()[2]).text();
    var id_cliente = $($(this).parent().children()[0]).text();    
    traerClienteElegido(documento, id_cliente);
}

function traerClienteElegidoClicIcono(){
    var documento = $($(this).parent().parent().parent().children()[2]).text();
    var id_cliente = $($(this).parent().parent().parent().children()[0]).text();    
    traerClienteElegido(documento,id_cliente);
}

function traerListaAdjuntosDeCliente(){
    var documento = $($(this).parent().parent().parent().children()[2]).text();
    var id_cliente = $($(this).parent().parent().parent().children()[0]).text();
    traerDatosComplementariosDeClienteElegido(documento,id_cliente);
}

function traerClienteElegido(documento, id_cliente){  
    GLOBAL_documento_cliente = documento;
    GLOBAL_id_cliente = id_cliente;
    $.post(globalUrl+"/gestion/consultas/consultas_clientes.php", {consulta: "traer_por_ci",ci: documento})
            .done(function(data) {            
                agregarDivDatosCliente();
                var un_cliente = jQuery.parseJSON(data);
                cargarFormularioCliente(un_cliente);
                //$('#div_ci_cliente').append(data);                
        }, "json");
        //$("input").prop('disable', true);
}

function traerDatosComplementariosDeClienteElegido(documento, id_cliente){ 
    GLOBAL_documento_cliente = documento;
    GLOBAL_id_cliente = id_cliente;
    $.post(globalUrl+"/gestion/consultas/consultas_clientes.php", {consulta: "traer_por_ci",ci: documento, id_cliente: id_cliente})
            .done(function(data) {            
                //agregarDivDatosCliente();
                agregarDivAdjuntosCliente();
                var un_cliente = jQuery.parseJSON(data);
                $('#nombre_cliente_adjunto').text(un_cliente.nombre + ' ' + un_cliente.apellido);
                if(un_cliente.adjuntos.length > 0){
                    $('#div_no_hay_adjuntos_del_cliente').fadeOut(1500);
                    $('#div_archivos_adjuntos').fadeIn(1500);     
                    agregarAdjuntosAListaDeCliente(un_cliente.adjuntos);
                }
                else{
                    $('#div_no_hay_adjuntos_del_cliente').fadeIn(1500);
                    $('#div_archivos_adjuntos').fadeOut(1500);                    
                }
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
                cargarFormularioCliente(-1);
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
    //$("#retorno_ajax").load("'+globalUrl+'/gestion/consultas/consultas_clientes.php",{consulta: "agregar_cliente",nombre: nombre_cli, apellido: apellido_cli, ci: ci_cli, email: email_cli, telefono: telefono_cli, direccion: direccion_cli, ci_escaneada: ci_escaneada_cli});
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

function cargarFormularioCliente(un_cliente){
    if(un_cliente != -1){
        $("#txt_nombre_cliente").val(un_cliente.nombre);
        $("#txt_apellido_cliente").val(un_cliente.apellido);
        $("#txt_ci_cliente").val(un_cliente.ci);
        $("#txt_email_cliente").val(un_cliente.email);
        $("#txt_telefono_cliente").val(un_cliente.telefono);
        $("#txt_direccion_cliente").val(un_cliente.direccion);
        $("#txt_direccion_cliente").attr("locked","true");
        //var accion_para_tipo_de_adjunto = traerAccionParaTipoDeAdjunto(un_cliente.adjunto_tipo);
        //$('#div_ci_cliente').html('<iframe id="iframe_ci_cliente" src="'+globalUrl+'/gestion/consultas/mostrar_archivo.php?mime=' + un_cliente.adjunto_tipo + '&id=' + un_cliente.adjunto_id + '&nombre=poneraquinombrearchivo&from=' + accion_para_tipo_de_adjunto + '"></iframe>');
        $('#div_ci_cliente').html('<iframe id="iframe_ci_cliente" src="'+globalUrl+'/gestion/consultas/mostrar_archivo.php?mime=' + un_cliente.adjunto_tipo + '&id=' + un_cliente.adjunto_id + '&nombre=poneraquinombrearchivo&from=dato_complementario"></iframe>');
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

function agregarAdjuntosAListaDeCliente(lista_adjuntos){
    $('#div_listado_adjuntos_de_un_cliente').html('');
    jQuery.each(lista_adjuntos,function(num,data){
            agregar_fila_adjunto_cliente(data.id,data.nombre,data.tipo)
        }
    );
}

function agregar_fila_adjunto_cliente(id_adjunto,nombre_adjunto,tipo){
    var fila = '<tr id="' + id_adjunto + '" tipo=' + tipo + '><td class="adjunto_mostrado_tramite"><i class="adjunto_tramite fa fa-paperclip fa-lg"></i></td><td class="adjunto_mostrado_tramite">' + nombre_adjunto + '</td><td><p><i class="btn_ver_adjunto_de_un_cliente fa fa-eye fa-lg"></i>&nbsp;&nbsp;<i class="btn_eliminar_adjunto_de_un_cliente fa fa-ban fa-lg"></i></p></td></tr>';
    $('#div_listado_adjuntos_de_un_cliente').append(fila);
}

function ver_adjunto_seleccionado_del_cliente(){
    var padre = $(this).parent().parent().parent()[0];
    var adjunto_id = padre.id;
    var adjunto_tipo = $('#'+adjunto_id).attr('tipo');
    //var accion_para_tipo_de_adjunto = traerAccionParaTipoDeAdjunto(adjunto_tipo);
    //$('#dialog_adjunto_del_cliente').html('<iframe id="iframe_adjunto_tramite" src="'+globalUrl+'/gestion/consultas/mostrar_archivo.php?mime=' + adjunto_tipo + '&id=' + adjunto_id + '&nombre=poneraquinombrearchivo&from=' + accion_para_tipo_de_adjunto + '"></iframe>');
    $('#dialog_adjunto_del_cliente').html('<iframe id="iframe_adjunto_tramite" src="'+globalUrl+'/gestion/consultas/mostrar_archivo.php?mime=' + adjunto_tipo + '&id=' + adjunto_id + '&nombre=poneraquinombrearchivo&from=dato_complementario"></iframe>');
    $("#dialog_adjunto_del_cliente").dialog({width: 800,modal: true,
    buttons: {
                
                Cerrar: function () {
                    $(this).dialog("close");
                }
            }
        });
}

function traerAccionParaTipoDeAdjunto(adjunto_tipo){
    if (/pdf/i.test(adjunto_tipo)){
         return 'adjunto';
    }
    else{
        return 'dato_complementario';
    }
}

function eliminar_adjunto_seleccionado_del_cliente(){
    var confirmado = confirm("¿Seguro que desea eliminar este adjunto del cliente?");
    if(confirmado){
        var documento = GLOBAL_documento_cliente;
        var padre = $(this).parent().parent().parent()[0];
        var vdato_complementario_id = padre.id;
        $.post(globalUrl+"/gestion/consultas/consultas_clientes.php", {consulta: "eliminar_dato_complementario_por_id",adjunto_id: vdato_complementario_id})
                .done(function(data) {  
                var ret = parseInt(data);
                if(ret == 1){
                    alert('Adjunto eliminado');
                    traerDatosComplementariosDeClienteElegido(documento);
                    //traerTramitePorId(id_tramite);
                }             
            }, "json");
    }
}


function agregarAdjuntoALosDelCliente(nombre_adjunto){
    var vdocumento_cliente = GLOBAL_documento_cliente;
    var vid_cliente = GLOBAL_id_cliente;
    $.post(globalUrl+"/gestion/consultas/consultas_clientes.php", {consulta: "agregar_adjunto_al_cliente",ci: vdocumento_cliente, id_cliente: GLOBAL_id_cliente})
            .done(function(data) {            
                //agregarDivDatosCliente();
                var retorno_adjunto = jQuery.parseJSON(data);
                //alert(retorno_adjunto.id_adjunto);
                agregar_fila_adjunto_cliente(retorno_adjunto.id_adjunto,nombre_adjunto,retorno_adjunto.tipo);
                //return retorno_adjunto;
        }, "json");

}



/*---------------------------------------------------------------------------------------------------------------
  ---------------------------------------------------------------------------------------------------------------
  MÉTODOS DE GESTION
  ---------------------------------------------------------------------------------------------------------------
  ---------------------------------------------------------------------------------------------------------------*/
function agregarDivDatosGestion(){    
        $("#div_listado_gestion").fadeOut(1500);        
        $("#btn_agregar_gestion").fadeOut(1500);
        $("#btn_mostrar_lista_gestiones").fadeIn(1500);        
        $("#div_formulario_gestion").fadeIn(1500);
        $(".fecha-fin-gestion").css("display","none");
        $('#combo_tipo_gestion').load(globalUrl+"/gestion/consultas/consultas_gestiones.php",{consulta: "traer_tipos_gestion"});
        $('#combo_lista_personas').load(globalUrl+"/gestion/consultas/consultas_gestiones.php",{consulta: "traer_lista_personas"});
    
        cargarFormularioGestion(-1);
}
        
function agregarDivListaGestiones(){
    $("#div_listado_gestion").load(globalUrl+"/gestion/consultas/consultas_gestiones.php",{consulta: "traer_todos"});
    $("#div_formulario_gestion").fadeOut(1500);
    $("#btn_mostrar_lista_gestiones").fadeOut(1500);
    $("#div_formulario_adjuntos_gestion").fadeOut(1500);
    $("#btn_agregar_gestion").fadeIn(1500);
    $("#div_listado_gestion").fadeIn(1500);
    //$("#btn_agregar_cliente").html('Agregar <i class="fa fa-list"></i>');
    cargarFormularioGestion(-1);
}

function cargarFormularioGestion(una_gestion){
    if(una_gestion != -1){
    	//$("#txt_id_tramite").val(un_tramite.id_tramite);
        $("#txt_descripcion_gestion").val(una_gestion.descripcion);
        $("#combo_tipo_tramite option:selected").val(un_tramite.id_tipo_tramite);
        $("#txt_fecha_inicio").val(un_tramite.fecha_inicio);
        plantilla = un_tramite.plantilla;
        if(un_tramite.fecha_fin != null){
            $(".fecha-fin").fadeIn(1500);
            $("#txt_fecha_fin").val(un_tramite.fecha_fin);
        }
        if(un_tramite.estado == 1){
            $("#btn_finalizar_tramite").text("Re-abrir");
            $('.fecha-fin').css('display','bock');
        }
        $("#span_id_gestion").text(un_tramite.id_gestion);
        $("#span_id_tipo_gestion").text(un_tramite.id_tipo_gestion);
        $("#span_id_tramite").text(un_tramite.id_tramite);        
        
        if(un_tramite.adjuntos.length > 0){
            $("#div_no_hay_adjuntos_tramite").fadeOut(1500);
            $("#div_archivos_adjuntos").fadeIn(1500);            
            agregarAdjuntosAlTramiteCargado(un_tramite.adjuntos);
        }
        else{
            $("#div_no_hay_adjuntos_tramite").fadeIn(1500);
            $("#div_archivos_adjuntos").fadeOut(1500);
        }
        //$('#div_ci_cliente').html('<iframe id="iframe_ci_cliente" src="'+globalUrl+'/gestion/consultas/mostrar_archivo.php?mime=' + un_cliente.adjunto_tipo + '&id=' + un_cliente.adjunto_id + '&nombre=poneraquinombrearchivo&from=dato_complementario"></iframe>');
        //$('#div_ci_cliente').fadeIn(1500);         
    }
    else{
        $("#txt_descripcion_tramite").val("");
        $("#combo_tipo_tramite option:selected").val("");
        $("#txt_fecha_inicio").val();
        $("#span_id_gestion").text("");
        $("#span_id_tipo_gestion").text("");
        $("#span_id_tramite").text("un_tramite.id_tramite");
    }
}

function finalizarGestion(){
    //if($.trim($("#span_id_gestion").text())!=""){
        
    //}
    //else{
        if($("#btn_finalizar_gestion").text()== "Finalizar"){              
            $("#btn_finalizar_gestion").text("Re-abrir");
            $(".fecha-fin-gestion").fadeIn(1500);
            var myDate = new Date();
            var prettyDate =(myDate.getDate() + '/' + myDate.getMonth()+1) + '/' + myDate.getFullYear();
            $( ".fecha-fin-gestion" ).val(prettyDate);
            //$( ".fecha-fin" ).datepicker('setDate', 'today');
        }
        else{
            $("#btn_finalizar_gestion").text("Finalizar");
            $(".fecha-fin-gestion").fadeOut(1500);
        }
         
    //}
}

function agregarClienteAGrupoSelector(){
    var lista_clientes_seleccionados = $('#combo_lista_clientes_elegidos')[0];
    var lista_personas = $('#combo_lista_personas')[0];
    var persona_elegida_id = $('#combo_lista_personas').val();
    var persona_elegida_contenido = $('#combo_lista_personas').find(":selected").text();
    var option_agregar = '<option value="' + persona_elegida_id + '">' + persona_elegida_contenido + '</option>'
    //var no_hay_clientes_elegidos = $('#combo_lista_clientes_elegidos')[0].selectedIndex;
    borrarElementoDeSelector(-1,lista_clientes_seleccionados);
    borrarElementoDeSelector(persona_elegida_id,lista_personas);
    if(persona_elegida_id == null){
        alert("Debe seleccionar a una persona para poder agregarla al grupo");
    }
    else{
        //combo_lista_clientes_elegidos
        
        $('#combo_lista_clientes_elegidos').append(option_agregar);
    }
    //var persona_elegida = $('#combo_lista_personas').find(":selected").text();
    //alert(persona_elegida);
}

function quitarClienteAGrupoSelector(){
    var lista_clientes_seleccionados = $('#combo_lista_clientes_elegidos')[0];
    //var lista_personas = $('#combo_lista_personas')[0];
    var persona_elegida_id = $('#combo_lista_clientes_elegidos').val();
    var persona_elegida_contenido = $('#combo_lista_clientes_elegidos').find(":selected").text();
    var option_agregar = '<option value="' + persona_elegida_id + '">' + persona_elegida_contenido + '</option>'
    //var no_hay_clientes_elegidos = $('#combo_lista_clientes_elegidos')[0].selectedIndex;
    //borrarElementoDeSelector(-1,lista_clientes_seleccionados);
    borrarElementoDeSelector(persona_elegida_id,lista_clientes_seleccionados);
    if(persona_elegida_id == null){
        alert("Debe seleccionar a una persona para poder quitarla del grupo");
    }
    else{
        //combo_lista_clientes_elegidos
        
        $('#combo_lista_personas').append(option_agregar);
    }
    //var persona_elegida = $('#combo_lista_personas').find(":selected").text();
    //alert(persona_elegida);
}

function borrarElementoDeSelector(id_elemento, lista){
    //var lista_clientes_elegidos = $('#combo_lista_clientes_elegidos')[0];
    for(var x=0; x<lista.length;x++){
        if(lista[x].value == id_elemento){
            lista[x].remove();
        }        
    }
}

function guardarGestion(){
    var vdescripcion = $("#txt_descripcion_gestion").val();
    var vtipo_gestion = $("#combo_tipo_gestion").val();
    var vfecha_inicio = $("#txt_fecha_inicio_gestion").val();    
    var vfecha_fin = -1;
    if($("#btn_finalizar_gestion").text()== "Re-abrir"){      
            vfecha_fin = $("#txt_fecha_fin_gestion").val();
    }
    var lista_clientes_seleccionados = $('#combo_lista_clientes_elegidos')[0];
    
    var vid_gestion = GLOBAL_id_gestion;
    if(vdescripcion != ''){
        if(vid_gestion > 0){
            console.log("aquí se modifica la gestión");
            $.post(globalUrl+"/gestion/consultas/consultas_gestiones.php", {consulta: "modificar_gestion", id_gestion:vid_gestion, descripcion:vdescripcion, tipo_gestion:vtipo_gestion, fecha_inicio:vfecha_inicio, fecha_fin:vfecha_fin, lista_clientes_seleccionados:lista_clientes_seleccionados})
                    .done(function(data) {            
                        var retorno = parseInt(data);
                        if(retorno==1){
                            $("#retorno_ajax_plantillas").html("<span style='color:green'><strong>La gestión fue modificada exitosamente!</strong></span>");
                        }
                        else{
                            $("#retorno_ajax_plantillas").html("<span style='color:red'><strong>¡La gestión no fue modificada!</strong></span>");
                        }
            },"json");      	
        }
        else{
            $.post(globalUrl+"/gestion/consultas/consultas_gestiones.php", {consulta: "agregar_gestion", descripcion:vdescripcion, tipo_gestion:vtipo_gestion, fecha_inicio:vfecha_inicio, fecha_fin:vfecha_fin, lista_clientes_seleccionados:lista_clientes_seleccionados})
                    .done(function(data) {            
                        var retorno = parseInt(data);
                        if(retorno==1){
                            $("#retorno_ajax_plantillas").html("<span style='color:green'><strong>La gestión fue agregada exitosamente!</strong></span>");
                        }
                        else{
                            $("#retorno_ajax_plantillas").html("<span style='color:red'><strong>¡La gestión no fue agregada!</strong></span>");
                        }
            });    	
        }
    }
    else{
        alert('Debe llenar el campo Descripción para poder guardar esta Gestión');
    }

}

function traerGestionElegidaClicNombre(){
    //var documento = $($(this).parent().children()[2]).text();
    var id_gestion = $($(this).parent().children()[0]).text();    
    traerGestionElegida(id_gestion);
}

function traerGestionElegidaClicIcono(){
    var id_gestion = $($(this).parent().parent().parent().children()[0]).text();    
    traerGestionElegida(id_gestion);
}

function traerGestionElegida(id_gestion){  
    GLOBAL_id_gestion = id_gestion;
    $.post(globalUrl+"/gestion/consultas/consultas_gestiones.php", {consulta: "traer_por_id", id_gestion: id_gestion})
            .done(function(data) {            
                agregarDivDatosGestion();
                var una_gestion = jQuery.parseJSON(data);
                cargarFormularioGestion(una_gestion);
                //$('#div_ci_cliente').append(data);                
        }, "json");
        //$("input").prop('disable', true);
}

/*---------------------------------------------------------------------------------------------------------------
  ---------------------------------------------------------------------------------------------------------------
  MÉTODOS DE TRÁMITES
  ---------------------------------------------------------------------------------------------------------------
  ---------------------------------------------------------------------------------------------------------------*/
function agregarDivDatosTramite(){
    //if($("#div_formulario_tramite").css("display") == "none"){
    $("#btn_agregar_tramite").fadeOut(1500);
    $("#div_listado_tramite").fadeOut(1500);
    $("#div_archivos_adjuntos").fadeOut(1500);
    $("#div_no_hay_adjuntos_tramite").fadeOut(1500);    
    $("#btn_mostrar_lista_tramites").fadeIn(1500);
    $("#div_formulario_tramite").fadeIn(1500);
    $("#btn_guardar_tramite").fadeIn(1500);  
    //$("#btn_agregar_tramite").text("Mostrar Lista");
        
    //$("#combo_estado_tramite").css("display","none");
    $(".fecha-fin").css("display","none");
        
        
        var vid_tipo_gestion = $("#span_id_tipo_gestion").text();
        $("#combo_tipo_tramite").load(globalUrl+"/gestion/consultas/consultas_tramites.php",{consulta: "traer_tipos_tramite", id_tipo_gestion: vid_tipo_gestion});
        //cargarFormulario(-1);
        //$("input").prop('disable', false);
    //}
    //else{

    //}
}

/*function guardarTramite(){
    var vdescripcion = $("#txt_descripcion_tramite").val();
    var vtipo_tramite = $("#combo_tipo_tramite option:selected").val();
    var vfecha_inicio = $("#txt_fecha_inicio").val();
    var vfecha_fin = $("#txt_fecha_fin").val();
    var vid_gestion = $.trim($("#span_id_gestion").text());
    var vid_tipo_gestion = $.trim($("#span_id_tipo_gestion").text());
    var vplantilla = plantilla;
    $.post(globalUrl+"/gestion/consultas/consultas_tramites.php", {consulta: "agregar_tramite", descripcion:vdescripcion, id_tipo_tramite:vtipo_tramite, fecha_inicio:vfecha_inicio, fecha_fin:vfecha_fin, id_gestion:vid_gestion, id_tipo_gestion:vid_tipo_gestion, plantilla_modificada:vplantilla})
            .done(function(data) {            
                //alert(data);
                //var un_cliente = jQuery.parseJSON(data);
                //cargarFormulario(un_cliente);
                var retorno = parseInt(data);
                if(retorno==1){
                    $("#retorno_borrado").html("<span style='color:green'><strong>Trámite agregado exitosamente!</strong></span>");
                    agregarDivListaTramite();
                }
                else{
                    $("#retorno_borrado").html("<span style='color:red'><strong>Trámite agregado exitosamente!</strong></span>");
                }
                //$('#content').append(data);
        });
}*/


function guardarTramite(){
    var vid_tramite = $("#txt_id_tramite").val();
    var vdescripcion = $("#txt_descripcion_tramite").val();
    var vtipo_tramite = $("#combo_tipo_tramite option:selected").val();
    var vfecha_inicio = $("#txt_fecha_inicio").val();
    var vestado = 0;
    var vfecha_fin = -1;
    //var a =$("#btn_finalizar_gestion").text();
    if($("#btn_finalizar_tramite").text() != "Finalizar"){
        vestado = 1;
        if($("#txt_fecha_fin").val() != ''){
            vfecha_fin = $("#txt_fecha_fin").val();
        }
    }
    
    var vid_gestion = $.trim($("#span_id_gestion").text());
    var vid_tipo_gestion = $.trim($("#span_id_tipo_gestion").text());
    var vplantilla = plantilla;
    if(vid_tramite > 0)
    {
    	console.log("aqui se modifica el tramite");
	    $.post(globalUrl+"/gestion/consultas/consultas_tramites.php", {consulta: "modificar_tramite", id_tramite:vid_tramite, descripcion:vdescripcion, id_tipo_tramite:vtipo_tramite, fecha_inicio:vfecha_inicio, fecha_fin:vfecha_fin, id_gestion:vid_gestion, id_tipo_gestion:vid_tipo_gestion, plantilla_modificada:vplantilla, estado:vestado})
	            .done(function(data) {            
	                var retorno = parseInt(data);
	                if(retorno==1){
	                    $("#retorno_borrado_tramite").html("<span style='color:green'><strong>Trámite modificado exitosamente!</strong></span>");
	                }
	                else{
	                    $("#retorno_borrado_tramite").html("<span style='color:red'><strong>Trámite no modificado !</strong></span>");
	                }
	        });      	
    }
    else
    {
	    $.post(globalUrl+"/gestion/consultas/consultas_tramites.php", {consulta: "agregar_tramite", descripcion:vdescripcion, id_tipo_tramite:vtipo_tramite, fecha_inicio:vfecha_inicio, fecha_fin:vfecha_fin, id_gestion:vid_gestion, id_tipo_gestion:vid_tipo_gestion, plantilla_modificada:vplantilla, estado:vestado})
	            .done(function(data) {            
	                var retorno = parseInt(data);
	                if(retorno==1){
	                    $("#retorno_borrado_tramite").html("<span style='color:green'><strong>Trámite agregado exitosamente!</strong></span>");
	                }
	                else{
	                    $("#retorno_borrado_tramite").html("<span style='color:red'><strong>Trámite agregado exitosamente!</strong></span>");
	                }
	        });    	
    }
}


function agregarDivListaTramite(){
    $("#btn_mostrar_lista_tramites").fadeOut(1500);
    $("#retorno_borrado_tramite").html("");
    $("#div_listado_tramite").load(globalUrl+"/gestion/consultas/consultas_tramites.php",{consulta: "traer_todos"});
    $("#div_formulario_tramite").fadeOut(1500);
    $("#btn_guardar_tramite").fadeOut(1500);    
    $("#div_listado_tramite").fadeIn(1500);
    $("#btn_agregar_tramite").fadeIn(1500);
    limpiarFormularioAgregarTramite();
}

function limpiarFormularioAgregarTramite(){
    GLOBAL_id_tramite = -1;
    plantilla = '';
    $("#txt_descripcion_tramite").val('');
    $("#txt_fecha_inicio").val('');
    $("#txt_fecha_fin").val('');
    $("#span_id_gestion").text('');
    $("#span_id_tipo_gestion").text('');
}

function traerTramiteElegido(){
    var id_tramite = $(this).parent().children()[1].id;
    if(id_tramite == ''){
        id_tramite = $($(this).parent().parent().parent().children()[0]).text(); 
    }
    GLOBAL_id_tramite = id_tramite;
    traerTramitePorId(id_tramite);
}

function traerTramitePorId(id_tramite){
    $.post(globalUrl+"/gestion/consultas/consultas_tramites.php", {consulta: "traer_por_id",id_tramite: id_tramite})
            .done(function(data) {            
                agregarDivDatosTramite();                
                var un_tramite = jQuery.parseJSON(data);
                cargarFormularioTramite(un_tramite);      
        }, "json");  
}

function finalizarTramite(){
    if($.trim($("#span_id_tramite").text())!=""){
        
    }
    else{
        if($("#btn_finalizar_tramite").text()== "Finalizar"){      
            $("#btn_finalizar_tramite").text("Re-abrir");
            $(".fecha-fin").fadeIn(1500);
            var myDate = new Date();
            var prettyDate =(myDate.getDate() + '/' + myDate.getMonth()+1) + '/' + myDate.getFullYear();
            $( ".fecha-fin" ).val(prettyDate);
            //$( ".fecha-fin" ).datepicker('setDate', 'today');
        }
        else{
            $("#btn_finalizar_tramite").text("Finalizar");
            $(".fecha-fin").fadeOut(1500);
        }
         
    }
}

function visibilidadFormularioSubirAdjunto(){
    if($(".formulario_archivo_tramite").css('display')=='none'){
        $(".formulario_archivo_tramite").fadeIn(1500);
    }
    else{
        $(".formulario_archivo_tramite").fadeOut(1500);
    }
}

function cargarFormularioTramite(un_tramite){
    if(un_tramite != -1){
    	$("#txt_id_tramite").val(un_tramite.id_tramite);
        $("#txt_descripcion_tramite").val(un_tramite.descripcion);
        $("#combo_tipo_tramite option:selected").val(un_tramite.id_tipo_tramite);
        $("#txt_fecha_inicio").val(un_tramite.fecha_inicio);
        plantilla = un_tramite.plantilla;
        if(un_tramite.fecha_fin != null){
            $(".fecha-fin").fadeIn(1500);
            $("#txt_fecha_fin").val(un_tramite.fecha_fin);
        }
        if(un_tramite.estado == 1){
            $("#btn_finalizar_tramite").text("Re-abrir");
            $('.fecha-fin').css('display','bock');
        }
        $("#span_id_gestion").text(un_tramite.id_gestion);
        $("#span_id_tipo_gestion").text(un_tramite.id_tipo_gestion);
        $("#span_id_tramite").text(un_tramite.id_tramite);        
        
        if(un_tramite.adjuntos.length > 0){
            $("#div_no_hay_adjuntos_tramite").fadeOut(1500);
            $("#div_archivos_adjuntos").fadeIn(1500);            
            agregarAdjuntosAlTramiteCargado(un_tramite.adjuntos);
        }
        else{
            $("#div_no_hay_adjuntos_tramite").fadeIn(1500);
            $("#div_archivos_adjuntos").fadeOut(1500);
        }
        //$('#div_ci_cliente').html('<iframe id="iframe_ci_cliente" src="'+globalUrl+'/gestion/consultas/mostrar_archivo.php?mime=' + un_cliente.adjunto_tipo + '&id=' + un_cliente.adjunto_id + '&nombre=poneraquinombrearchivo&from=dato_complementario"></iframe>');
        //$('#div_ci_cliente').fadeIn(1500);         
    }
    else{
        $("#txt_descripcion_tramite").val("");
        $("#combo_tipo_tramite option:selected").val("");
        $("#txt_fecha_inicio").val();
        $("#span_id_gestion").text("");
        $("#span_id_tipo_gestion").text("");
        $("#span_id_tramite").text("un_tramite.id_tramite");
    }
}

function agregarAdjuntosAlTramiteCargado(lista_adjuntos){
    $('#div_listado_adjuntos').html('');
    jQuery.each(lista_adjuntos,function(num,data){
            agregar_fila_adjunto_tramite(data.id,data.nombre,data.tipo)
        }
    );
}

function cambioTipoTramite(){
    var tipo_tramite = $("#combo_tipo_tramite option:selected").text();
    //$("#dialog_plantilla").attr("title",tipo_tramite);
    $( "#dialog_plantilla" ).dialog( "option", "title", tipo_tramite );
    //alert(tipo_tramite);
}

function mostrarDialogPlantilla(){
    var vid_tipo_tramite = $("#combo_tipo_tramite option:selected").val();
    
    //$("#dialog_plantilla").load(globalUrl+"/gestion/consultas/consultas_tramites.php",{consulta:"get_plantilla_por_id_tipo_tramite", id_tipo_tramite:vid_tipo_tramite});
    var vid_tipo_gestion = parseInt($("#span_id_tipo_gestion").text());
    var vid_tramite = GLOBAL_id_tramite;
    if(typeof vid_tramite === 'undefined'){
        vid_tramite = -1;
    } 
    
    $.post(globalUrl+"/gestion/consultas/consultas_tramites.php",{consulta:"get_plantilla_por_id_tipo_tramite", id_tipo_tramite:vid_tipo_tramite, id_tipo_gestion: vid_tipo_gestion, id_tramite:vid_tramite})
            .done(function(data) {
        plantilla = data;
        var una_plantilla = '<textarea id="editor1" name="editor1">'+data;
        una_plantilla += '</textarea><script type="text/javascript">CKEDITOR.replace( "editor1" );</script>';
        $("#dialog_plantilla").html(una_plantilla);
            });
    
    $("#dialog_plantilla").dialog({width: 800,modal: true,
    buttons: {
                DelUser:{ 
                    class: 'leftButton',
                    text: 'Guardar',
                    click : function (){
                        plantilla = CKEDITOR.instances.editor1.getData();
                        guardarTramite();
                        //alert(planilla_llena);
                        $(this).dialog("close");
                    }
                },
                Cerrar: function () {
                    $(this).dialog("close");
                }
            }
        });
}

function eliminarTramiteElegido(){
    var confirmado = confirm("¿Seguro que desea eliminar este trámite?");
    if(confirmado){
        //var documento = $($(this).parent().children()[2]).text();  
        var id_tramite = $($(this).parent().parent().parent().children()[0]).text();  
        $.post(globalUrl+"/gestion/consultas/consultas_tramites.php", {consulta: "eliminar_por_id",id_tramite: id_tramite})
                .done(function(data) {
                    $("#retorno_borrado_tramite").html(data);
                    //$('#content').append(un_cliente);
            }, "json");
        //$("input").prop('disable', true);
        //ocultamos el borrado
        $(this).parent().parent().parent().fadeOut(1500);       
    }
}

function subirElArchivo_tramite(){
    if($('#txt_nombre_adjunto').val() != ''){
		//información del formulario
		var formData = new FormData($(".formulario_archivo_tramite")[0]);
		var message = "";	
		$.ajax({
			url: globalUrl+"/gestion/consultas/subir_adjunto.php",  
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
                            //message = "<img src='data:image/jpeg;base64,"+data;+"' width='300' height='200' alt='embedded folder icon'>";
                            //retornoSubirArchivo(message);
                            retornoSubirArchivo('<span>El archivo <strong>'+data+'</strong> fue subido exitosamente</span>');
                            agregarAdjuntoAlTramite(data);
                            //var id_adjunto = datos_adjunto.id_adjunto;
                            
                            $(".formulario_archivo_tramite").fadeOut(1500);
			},
			//si ha ocurrido un error
			error: function(){
			    message = $("<span class='error'>Ha ocurrido un error.</span>");
			    retornoSubirArchivo(message);
			}
		});
    }
    else{
        alert('Debe agregarle un nombre al adjunto');
    }

}

function agregarAdjuntoAlTramite(nombre_adjunto){
    var vid_tramite = GLOBAL_id_tramite;
    $.post(globalUrl+"/gestion/consultas/consultas_tramites.php", {consulta: "agregar_adjunto_al_tramite",id_tramite: vid_tramite})
            .done(function(data) {            
                //agregarDivDatosCliente();
                var retorno_adjunto = jQuery.parseJSON(data);
                //alert(retorno_adjunto.id_adjunto);
                agregar_fila_adjunto_tramite(retorno_adjunto.id_adjunto,nombre_adjunto,retorno_adjunto.tipo);
                //return retorno_adjunto;
        }, "json");

}

function agregar_fila_adjunto_tramite(id_adjunto,nombre_adjunto,tipo){
    var fila = '<tr id="' + id_adjunto + '" tipo=' + tipo + '><td class="adjunto_mostrado_tramite"><i class="adjunto_tramite fa fa-paperclip fa-lg"></i></td><td class="adjunto_mostrado_tramite">' + nombre_adjunto + '</td><td><p><i class="btn_ver_adjunto fa fa-eye fa-lg"></i>&nbsp;&nbsp;<i class="btn_eliminar_adjunto fa fa-ban fa-lg"></i></p></td></tr>';
    $('#div_listado_adjuntos').append(fila);
}

function ver_adjunto_seleccionado(){
    var padre = $(this).parent().parent().parent()[0];
    var adjunto_id = padre.id;
    var adjunto_tipo = $('#'+adjunto_id).attr('tipo');
    //var accion_para_tipo_de_adjunto = traerAccionParaTipoDeAdjunto(adjunto_tipo);
    //var frame = '<iframe id="iframe_adjunto_tramite" src="'+globalUrl+'/gestion/consultas/mostrar_archivo.php?mime=' + adjunto_tipo + '&id=' + adjunto_id + '&&nombre=poneraquinombrearchivo&from=' + accion_para_tipo_de_adjunto + '"></iframe>';
    var frame = '<iframe id="iframe_adjunto_tramite" src="'+globalUrl+'/gestion/consultas/mostrar_archivo.php?mime=' + adjunto_tipo + '&id=' + adjunto_id + '&&nombre=poneraquinombrearchivo&from=adjunto"></iframe>';
    $('#dialog_adjunto').html(frame);
    $("#dialog_adjunto").dialog({width: 800,modal: true,
    buttons: {
                
                Cerrar: function () {
                    $(this).dialog("close");
                }
            }
        });
}

function eliminar_adjunto_seleccionado(){
    var confirmado = confirm("¿Seguro que desea eliminar este adjunto del trámite?");
    if(confirmado){
        var id_tramite = GLOBAL_id_tramite;
        var padre = $(this).parent().parent().parent()[0];
        var vadjunto_id = padre.id;
        $.post(globalUrl+"/gestion/consultas/consultas_tramites.php", {consulta: "eliminar_adjunto_por_id",adjunto_id: vadjunto_id})
                .done(function(data) {  
                var ret = parseInt(data);
                if(ret == 1){
                    alert('Adjunto eliminado');
                    traerTramitePorId(id_tramite);
                }             
            }, "json");
    }
}


/*---------------------------------------------------------------------------------------------------------------
  ---------------------------------------------------------------------------------------------------------------
  MÉTODOS DE PLANTILLAS
  ---------------------------------------------------------------------------------------------------------------
  ---------------------------------------------------------------------------------------------------------------*/
function agregarDivDatosPlantilla(){
    plantilla = 'Agregue el texto de la plantilla aquí.';
    $("#div_listado_plantillas").fadeOut(1500);        
    $("#btn_agregar_plantilla").fadeOut(1500);
    $("#btn_mostrar_lista_plantillas").fadeIn(1500);        
    $("#div_formulario_plantilla").fadeIn(1500);
    $('#combo_tipo_gestion_pl').load(globalUrl+"/gestion/consultas/consultas_plantillas.php",{consulta: "traer_tipos_gestion"});
        //$('#combo_lista_personas').load(globalUrl+"/gestion/consultas/consultas_gestiones.php",{consulta: "traer_lista_personas"});
    cargarFormularioTipoTramite(-1);
        
}
        
function agregarDivListaPlantillas(){
    $("#div_listado_plantillas").load(globalUrl+"/gestion/consultas/consultas_plantillas.php",{consulta: "traer_todos"}); 
    $("#div_formulario_plantilla").fadeOut(1500);
    $("#btn_mostrar_lista_plantillas").fadeOut(1500);
    //$("#div_formulario_adjuntos_gestion").fadeOut(1500);
    $("#btn_agregar_plantilla").fadeIn(1500);
    $("#div_listado_plantillas").fadeIn(1500);
    //$("#btn_agregar_cliente").html('Agregar <i class="fa fa-list"></i>');
    cargarFormularioTipoTramite(-1);
}

function cargarFormularioTipoTramite(un_tipo_tramite){
    if(un_tipo_tramite !== -1){
        if(un_tipo_tramite !== -2){
            $("#txt_descripcion_plantilla").val(un_tipo_tramite.descripcion);
            $("#combo_tipo_gestion_pl").val(un_tipo_tramite.tipo_gestion);
            //$("#dialog_plantilla").val(un_tipo_tramite.plantilla);
            plantilla = un_tipo_tramite.plantilla;
            var una_plantilla = '<textarea id="editorTT" name="editorTT">'+un_tipo_tramite.plantilla;
            una_plantilla += '</textarea><script type="text/javascript">CKEDITOR.replace( "editorTT" );</script>';
            $("#dialog_plantilla_tt").html(una_plantilla);
        }
        else{
            var una_plantilla_nueva = '<textarea id="editorTT" name="editorTT">'+plantilla+'</textarea><script type="text/javascript">CKEDITOR.replace( "editorTT" );</script>';
            $("#dialog_plantilla_tt").html(una_plantilla_nueva);
        }
    }
    else{
        $("#txt_descripcion_plantilla").val("");
        var una_plantilla_nueva = '<textarea id="editorTT" name="editorTT">Agregue el texto de la plantilla aquí.</textarea><script type="text/javascript">CKEDITOR.replace( "editorTT" );</script>';
        $("#dialog_plantilla_tt").html(una_plantilla_nueva);
    }
}

function traerTipoTramiteElegido(){
    var id_tipo_tramite = $(this).parent().children()[1].id;
    //if(id_tipo_tramite !== ""){
    if(!id_tipo_tramite){
        id_tipo_tramite = $($(this).parent().parent().parent().children()[0]).text();
    }
    GLOBAL_id_tipo_tramite = id_tipo_tramite;
    traerTipoTramitePorId(id_tipo_tramite);
}

function traerTipoTramitePorId(id_tipo_tramite){
    $.post(globalUrl+"/gestion/consultas/consultas_plantillas.php", {consulta: "traer_por_id",id_tipo_tramite: id_tipo_tramite})
            .done(function(data) {            
                agregarDivDatosPlantilla();                
                var un_tipo_tramite = jQuery.parseJSON(data);
                cargarFormularioTipoTramite(un_tipo_tramite);      
        }, "json");  
}

function mostrarDialogPlantilla_tt(){
    var id_tipo_tramite = GLOBAL_id_tipo_tramite;
    if(id_tipo_tramite > 0){
        traerTipoTramitePorId(id_tipo_tramite);
    }
    else{
        cargarFormularioTipoTramite(-2);
    }
    $("#dialog_plantilla_tt").dialog({width: 800,modal: true,
    buttons: {
                /*DelUser:{ 
                    class: 'leftButton',
                    text: 'Guardar',
                    click : function (){
                        plantilla = CKEDITOR.instances.editorTT.getData();
                        guardarTipoTramite();
                        //alert(planilla_llena);
                        $(this).dialog("close");
                    }
                },*/
                Aceptar: function () {
                    plantilla = CKEDITOR.instances.editorTT.getData();
                    $(this).dialog("close");
                }
            }
        });
}

function guardarTipoTramite(){
    var vdescripcion = $("#txt_descripcion_plantilla").val();
    var vtipo_gestion = $("#combo_tipo_gestion_pl").val();
    var vplantilla = plantilla;
    var vid_tipo_tramite = GLOBAL_id_tipo_tramite;
    if(vdescripcion != ''){
        if(vid_tipo_tramite > 0){
            console.log("aquí se modifica el tipo tramite");
            $.post(globalUrl+"/gestion/consultas/consultas_plantillas.php", {consulta: "modificar_tipo_tramite", id_tipo_tramite:vid_tipo_tramite, descripcion:vdescripcion, tipo_gestion:vtipo_gestion, plantilla:vplantilla})
                    .done(function(data) {            
                        var retorno = parseInt(data);
                        if(retorno==1){
                            $("#retorno_ajax_plantillas").html("<span style='color:green'><strong>La plantilla y tipo trámite fueron modificados exitosamente!</strong></span>");
                        }
                        else{
                            $("#retorno_ajax_plantillas").html("<span style='color:red'><strong>¡La plantilla y tipo trámite fueron no modificados!</strong></span>");
                        }
            });      	
        }
        else{
            $.post(globalUrl+"/gestion/consultas/consultas_plantillas.php", {consulta: "agregar_tipo_tramite", descripcion:vdescripcion, tipo_gestion:vtipo_gestion, plantilla:vplantilla})
                    .done(function(data) {            
                        var retorno = parseInt(data);
                        if(retorno==1){
                            $("#retorno_ajax_plantillas").html("<span style='color:green'><strong>La plantilla y tipo trámite fueron agregados exitosamente</strong></span>");
                        }
                        else{
                            $("#retorno_ajax_plantillas").html("<span style='color:red'><strong>La plantilla y tipo trámite no fueron agregados</strong></span>");
                        }
            });    	
        }
    }
    else{
        alert('Debe llenar el campo Descripción para poder guardar esta Plantilla y Tipo de Trámite');
    }
}

function eliminarTipoTramiteElegido(){
    var confirmado = confirm("¿Seguro que desea eliminar este tipo de trámite?");
    if(confirmado){
        //var documento = $($(this).parent().children()[2]).text(); 
        //var id_tipo_tramite = GLOBAL_id_tipo_tramite;
        var id_tipo_tramite = $($(this).parent().parent().parent().children()[0]).text();  
        $.post(globalUrl+"/gestion/consultas/consultas_plantillas.php", {consulta: "eliminar_por_id",id_tipo_tramite: id_tipo_tramite})
                .done(function(data) {
                    $("#retorno_ajax_plantillas").html(data);
                    //$('#content').append(un_cliente);
            }, "json");
        //$("input").prop('disable', true);
        //ocultamos el borrado
        $(this).parent().parent().parent().fadeOut(1500);       
    }
}