//var fileExtension = "";
var globalUrl = "http://"+document.domain;
var plantilla;
var GLOBAL_id_gestion;
var GLOBAL_id_tipo_gestion;
var GLOBAL_id_tramite;
var GLOBAL_id_tipo_tramite;
var GLOBAL_documento_cliente;
var GLOBAL_id_cliente;
var GLOBAL_id_usuario;
var GLOBAL_tipo_tramite_desc;
$(document).ready(iniEventos);

function iniEventos() {
    var url = window.location.pathname;
    if(url == '/gestion/gestiones' || url == '/gestion/gestiones.php'){
				$urlVars = parseURLParams(window.location.href); 	
                if($urlVars.id_gestion > 0)
                {                    	
                	$id_gestion=parseInt($urlVars.id_gestion);
					$(document).ready(traerGestionPorIdUrl($id_gestion));						
                }
                else
                {
                	$("#div_listado_gestion").load(globalUrl+"/gestion/consultas/consultas_gestiones.php",{consulta: "traer_todos"}); 
                }				
            
            $( ".datepicker" ).datepicker({dateFormat:"dd/mm/yy"});
    }
    else{
        if(url == '/gestion/personas' || url == '/gestion/personas.php'){
                $("#div_listado_cliente").load(globalUrl+"/gestion/consultas/consultas_clientes.php",{consulta: "traer_todos"}); 
                //$(".subir_archivo").click(subirElArchivo);
                $(":file").change(cambioElFile);
        }
        else{
            if(url == '/gestion/tramites' || url == '/gestion/tramites.php'){            					             	 	                                       
                    $urlVars = parseURLParams(window.location.href);                 
                    if($urlVars.id_tramite > 0)
                    {                    	
                    	$id_tramite=parseInt($urlVars.id_tramite);
			//$(document).ready(traerTramitePorIdUrl($id_tramite));	
                        traerTramitePorIdUrl($id_tramite);
			GLOBAL_id_tramite = $id_tramite;
                        /*setTimeout(function(){
                        cargarPlantilla();
                }, 1000);*/
                    }
                    else if($urlVars.id_gestion > 0 && $urlVars.id_tipo_gestion > 0)
                    {                    	
						$id_gestion=parseInt($urlVars.id_gestion);
						getGestionByTramite($id_gestion);
                        $('#span_id_gestion').text($urlVars.id_gestion);
                        $('#span_id_tipo_gestion').text($urlVars.id_tipo_gestion);
                        agregarDivDatosTramite();
                        setTimeout(function(){           
                                cargarPlantilla();
                                //mostrarDialogPlantilla();
                        }, 1000);
                        
                    }            
                    else
                    {
                    	$("#div_listado_tramite").load(globalUrl+"/gestion/consultas/consultas_tramites.php",{consulta: "traer_todos"});	
                    }        	
                                        
                    $( ".datepicker" ).datepicker({dateFormat:"dd/mm/yy"});                  
                //agregarDivDatosTramite();
            }
            else{
                if(url == '/gestion/plantillas' || url == '/gestion/plantillas.php'){
                    var urlParams = getParamsPart(window.location.href);
				if (typeof urlParams === 'undefined') {
					urlParams='0';
				}
                    var urlVars = parseURLParams(window.location.href);                 
                    if(urlVars.id_tipo_tramite > 0){                    	
                    	var id_tipo_tramite =parseInt(urlVars.id_tipo_tramite);
                        traerTipoTramiteElegidoPorId(id_tipo_tramite);
						//$(document).ready(traerTramitePorIdUrl($id_tramite));						
                    }
                    else{
                        if(urlVars.id_tipo_gestion > 0){ 
                            var id_tipo_gestion =parseInt(urlVars.id_tipo_gestion);
                            agregarDivDatosPlantilla();                            
                            setTimeout(function(){            
                                seleccionarComboConValor("#combo_tipo_gestion_pl",id_tipo_gestion);
                            }, 1000);
                        }
                        else{
                            $("#div_listado_plantillas").load(globalUrl+"/gestion/consultas/consultas_plantillas.php",{consulta: "traer_todos"}); 
                        
                        }
                    }
                    
                    //$(".subir_archivo").click(subirElArchivo);
                    $(":file").change(cambioElFile);
                }
                else{
                    if(url == '/gestion/usuarios' || url == '/gestion/usuarios.php'){
                        $("#div_listado_usuarios").load(globalUrl+"/gestion/consultas/consultas_usuarios.php",{consulta: "traer_todos"}); 
                        $(":file").change(cambioElFile);
                    }
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
$(document).on("click","#combo_lista_personas_personas",cambiar_lista_a_opcion_seleccionada);


/*asignar eventos GESTIONES*/
$(document).on("click","#btn_agregar_gestion",agregarDivDatosGestionSinLista);
$(document).on("click","#btn_mostrar_lista_gestiones",agregarDivListaGestiones);
$(document).on("click","#btn_finalizar_gestion",finalizarGestion);
$(document).on("click","#btn_agregar_cliente_a_grupo",agregarClienteAGrupoSelector);
$(document).on("click","#btn_quitar_cliente_a_grupo",quitarClienteAGrupoSelector);
$(document).on("click","#btn_agregar_participante_a_grupo",agregarParticipanteAGrupoSelector);
$(document).on("click","#btn_guardar_participante",guardarParticipanteGestion);
$(document).on("click","#btn_quitar_participante_a_grupo",quitarParticipanteAGrupoSelector);
$(document).on("click","#btn_agregar_participante",agregarParticipanteALista);
$(document).on("click","#btn_guardar_gestion",guardarGestion);
$(document).on("click",".dato_mostrado_gestion",traerGestionElegidaClicNombre);
$(document).on("click",".btn_ver_gestion",traerGestionElegidaClicIcono);

/*asignar eventos TIPOS GESTIONES*/
$(document).on("click","#btn_agregar_div_tipo_gestion",agregarDivManejoTipoGestion);
$(document).on("click","#btn_ver_lista_tipos_gestion_manejo",agregarDivManejoTipoGestion);
$(document).on("click","#btn_volver_a_gestiones",volverAGestiones);
$(document).on("click","#btn_crear_tipo_gestion",agregarDivCrearTipoGestion);
$(document).on("click","#btn_guardar_tipo_gestion",agregarTipoGestionGestion);
$(document).on("click",".dato_mostrado_tipo_gestion",traerTipoGestionElegidaClicNombre);
$(document).on("click",".btn_ver_tipo_gestion",traerTipoGestionElegidaClicIcono);
$(document).on("click","#btn_nuevo_tipo_gestion_manejo",agregarDivDatosTipoGestion);
$(document).on("click","#btn_guardar_tipo_gestion2",agregarTipoGestion2);
$(document).on("click",".btn_eliminar_tipo_gestion",eliminarTipoGestion);
 

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

$(document).on("click",".btn_tramite_detail",goToTramite);
$(document).on("click",".btn_agregar_tramite_gestion",addNewTramiteByGestion);

/*asignar eventos PLANTILLAS*/
$(document).on("click","#btn_agregar_plantilla",agregarDivDatosPlantilla);
$(document).on("click","#btn_mostrar_lista_plantillas",agregarDivListaPlantillas);
$(document).on("click",".dato_mostrado_tipo_tramite",traerTipoTramiteElegido);
$(document).on("click",".btn_ver_tipo_tramite",traerTipoTramiteElegido); 
$(document).on("click",".btn_eliminar_tipo_tramite",eliminarTipoTramiteElegido); 
$(document).on("click","#btn_mostrar_dialog_plantilla_tt",mostrarDialogPlantilla_tt);
$(document).on("click","#btn_ver_plantilla_desde_lista",mostrarDialogPlantilla_tg);
$(document).on("click","#btn_guardar_plantilla",guardarTipoTramite);

$(document).on("click","#btn_agregar_tipo_tramite_tipo_gestion",addNewTipoTramiteByTipoGestion);
$(document).on("click",".dato_mostrado_tipo_tramite_TG",traerTipoTramiteByTipoGestion);
$(document).on("click",".btn_ver_tipo_tramite_TG",traerTipoTramiteByTipoGestion);
 
 
/*asignar eventos USUARIOS*/
$(document).on("click","#btn_agregar_usuario",agregarDivDatosUsuario);
$(document).on("click","#btn_mostrar_lista_usuarios",agregarDivListaUsuarios);
$(document).on("click","#btn_guardar_usuario",guardarUsuario);
$(document).on("click",".dato_mostrado_usuario",traerUsuarioElegidoClicNombre);
$(document).on("click",".btn_ver_usuario",traerUsuarioElegidoClicIcono);
$(document).on("click",".btn_eliminar_usuario",eliminarUsuarioElegido);


/*asignar eventos BUSCADOR*/
$(document).on("click","#btn_buscar_inicio",hacerBusqueda);

/*---------------------------------------------------------------------------------------------------------------
  ---------------------------------------------------------------------------------------------------------------
  MÉTODOS GENERALES
  ---------------------------------------------------------------------------------------------------------------
  ---------------------------------------------------------------------------------------------------------------*/
function getParamsPart(url)
{
	var queryParams = url.split('?');
	return queryParams[1];	
}

function parseURLParams(url) {
    var queryStart = url.indexOf("?") + 1,
        queryEnd   = url.indexOf("#") + 1 || url.length + 1,
        query = url.slice(queryStart, queryEnd - 1),
        pairs = query.replace(/\+/g, " ").split("&"),
        parms = {}, i, n, v, nv;

    if (query === url || query === "") {
        return false;
    }

    for (i = 0; i < pairs.length; i++) {
        nv = pairs[i].split("=");
        n = decodeURIComponent(nv[0]);
        v = decodeURIComponent(nv[1]);

        if (!parms.hasOwnProperty(n)) {
            parms[n] = [];
        }

        parms[n].push(nv.length === 2 ? v : null);
    }
    return parms;
}

function seleccionarComboConValor(id_elemento_dom,id_seleccionado){
    var elemento = id_elemento_dom + " option[value=" + id_seleccionado + "]";
    $(elemento).attr('selected','selected');   
}

/*---------------------------------------------------------------------------------------------------------------
  ---------------------------------------------------------------------------------------------------------------
  MÉTODOS DE CLIENTE
  ---------------------------------------------------------------------------------------------------------------
  ---------------------------------------------------------------------------------------------------------------*/
function agregarDivDatosCliente(){    
    //if($("#div_formulario_cliente").css("display") == "none"){        
        $("#div_listado_cliente").fadeOut(1500);        
        $("#btn_agregar_cliente").fadeOut(1500);
        $('#combo_lista_personas_personas').fadeOut(1500);
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
    GLOBAL_id_cliente = undefined;
    $("#div_listado_cliente").load(globalUrl+"/gestion/consultas/consultas_clientes.php",{consulta: "traer_todos"});
    $("#div_formulario_cliente").fadeOut(1500);
    $("#btn_mostrar_lista_clientes").fadeOut(1500);
    $("#div_formulario_adjuntos_cliente").fadeOut(1500);
    $('#combo_lista_personas_personas').fadeIn(1500);
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
    var documento = $.trim($($(this).parent().children()[2]).text());
    var id_cliente = $.trim($($(this).parent().children()[0]).text());    
    traerClienteElegido(documento, id_cliente);
}

function traerClienteElegidoClicIcono(){
    var documento = $.trim($($(this).parent().parent().parent().children()[2]).text());
    var id_cliente = $.trim($($(this).parent().parent().parent().children()[0]).text());    
    traerClienteElegido(documento,id_cliente);
}

function traerListaAdjuntosDeCliente(){
    var documento = $($(this).parent().parent().parent().children()[2]).text();
    var id_cliente = $($(this).parent().parent().parent().children()[0]).text();
    $('#combo_lista_personas_personas').fadeOut(1500);
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
                agregarAdjuntosAListaDeCliente(un_cliente.adjuntos);

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
    var confirmado = confirm("¿Seguro que desea eliminar esta persona?");
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
        if(typeof GLOBAL_id_cliente === 'undefined'){
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
            $.post(globalUrl+"/gestion/consultas/consultas_clientes.php", {consulta: "modificar_cliente",id_persona:GLOBAL_id_cliente,nombre: nombre_cli, apellido: apellido_cli, ci: ci_cli, email: email_cli, telefono: telefono_cli, direccion: direccion_cli, ci_escaneada: ci_escaneada_cli})
                .done(function(data) {
                if(parseInt(data) == 1){
                    $("#retorno_ajax").html("<strong style='color:green;'>La persona "+nombre_cli+" "+apellido_cli+" se modificó con éxito</strong>");
                    cargarFormularioCliente(-1);
                    agregarDivListaClientes();
                }
                else{
                    $("#retorno_ajax").append(data);
                    //$("#retorno_ajax").html("<strong style='color:red;'>¡El cliente "+nombre_cli+" "+apellido_cli+" no se pudo ingresar!</strong>");
                }
            });
        }
    }
    else{
        alert("Datos incorrectos. No se puedo guardar");
    }
    //$("#retorno_ajax").load("'+globalUrl+'/gestion/consultas/consultas_clientes.php",{consulta: "agregar_cliente",nombre: nombre_cli, apellido: apellido_cli, ci: ci_cli, email: email_cli, telefono: telefono_cli, direccion: direccion_cli, ci_escaneada: ci_escaneada_cli});
}
//$( document ).on( "change",".elegir_familia", cambiarElemento );

function validarDatosIngresados(nombre_cli,apellido_cli,ci_cli,email_cli,telefono_cli,direccion_cli){
    return nombre_cli !='' && apellido_cli !='' && ci_cli !='' && email_cli !='' && telefono_cli !='' && direccion_cli !='';
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
        if(un_cliente.adjuntos.length > 0){
            $('#div_ci_cliente').html('<iframe id="iframe_ci_cliente" src="'+globalUrl+'/gestion/consultas/mostrar_archivo.php?mime=' + un_cliente.adjunto_tipo + '&id=' + un_cliente.adjunto_id + '&nombre=poneraquinombrearchivo&from=dato_complementario"></iframe>');
            $('#div_ci_cliente').fadeIn(1500); 
        }
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
        $(this).parent().parent().parent().fadeOut(1500); 
    }
}

function cambiar_lista_a_opcion_seleccionada(){
    var opcion = $('#combo_lista_personas_personas').val();
    if(opcion == 1){
        $("#div_listado_cliente").load(globalUrl+"/gestion/consultas/consultas_clientes.php",{consulta: "traer_todos"}); 
    }
    else{
        if(opcion == 2){
            $("#div_listado_cliente").load(globalUrl+"/gestion/consultas/consultas_clientes.php",{consulta: "traer_clientes"}); 
        }
        else{
            $("#div_listado_cliente").load(globalUrl+"/gestion/consultas/consultas_clientes.php",{consulta: "traer_participantes"}); 
        }
    }
    //alert(opcion);
}

function agregarAdjuntoALosDelCliente(nombre_adjunto){
    var vdocumento_cliente = GLOBAL_documento_cliente;
    var vid_cliente = GLOBAL_id_cliente;
    $.post(globalUrl+"/gestion/consultas/consultas_clientes.php", {consulta: "agregar_adjunto_al_cliente",ci: vdocumento_cliente, id_cliente: GLOBAL_id_cliente})
            .done(function(data) {            
                //agregarDivDatosCliente();
                var retorno_adjunto = jQuery.parseJSON(data);
                //alert(retorno_adjunto.id_adjunto);
                if($('#div_archivos_adjuntos').css('display')=='none'){
                    $('#div_archivos_adjuntos').fadeIn(1500);
                    $('#div_no_hay_adjuntos_del_cliente').fadeOut(1500);
                }
                agregar_fila_adjunto_cliente(retorno_adjunto.id_adjunto,nombre_adjunto,retorno_adjunto.tipo);                
                //return retorno_adjunto;
        }, "json");
        
}



/*---------------------------------------------------------------------------------------------------------------
  ---------------------------------------------------------------------------------------------------------------
  MÉTODOS DE GESTION
  ---------------------------------------------------------------------------------------------------------------
  ---------------------------------------------------------------------------------------------------------------*/
 
function goToTramite() 
{
	$id_tramite = $(this).attr("id");
	window.location.href="tramites?id_tramite="+$id_tramite;
	//window.open(globalUrl+"/gestion/tramites?id_tramite="+$id_tramite,'_newtab');

}

function goToGestion($id_gestion)
{
	window.location.href="gestiones?id_gestion="+$id_gestion;
}

function addNewTramiteByGestion() 
{
	$idsBtn = $(this).attr("id");
	$ids = $idsBtn.split("|");
	$id_gestion=$ids[0];
	$id_tipo_gestion=$ids[1];
	window.location.href="tramites?id_gestion="+$id_gestion+"&id_tipo_gestion="+$id_tipo_gestion;
	//window.open(globalUrl+"/gestion/tramites?id_tramite="+$id_tramite,'_newtab');

}

function agregarDivDatosGestionSinLista(){
    $("#div_listado_tramites_de_gestion_contenedor").fadeOut(1500);
    $("#btn_agregar_tramite_gestion").fadeOut(1500);    
    agregarDivDatosGestion();
}

function agregarDivDatosGestion(){    
        $("#div_listado_gestion").fadeOut(1500);        
        $("#btn_agregar_gestion").fadeOut(1500);               
        $("#div_manejo_tipos_gestiones").fadeOut(1500);
        //$("#div_listado_tramites_de_gestion_contenedor").fadeOut(1500);
        $(".btn_agregar_tramite_gestion").fadeOut(1500);        
        $("#btn_mostrar_lista_gestiones").fadeIn(1500); 
        $("#btn_agregar_div_tipo_gestion").fadeIn(1500);
        $("#div_listado_tramites_de_gestion_vacio").fadeIn(1500); 
        $("#div_formulario_gestion").fadeIn(1500);
        $(".fecha-fin-gestion").css("display","none");
        var id_gestion = GLOBAL_id_gestion;
        if(id_gestion == undefined){
            var id_gestion = -1;
        }
     
        //$('#combo_tipo_gestion').load(globalUrl+"/gestion/consultas/consultas_gestiones.php",{consulta: "traer_tipos_gestion"});        
        cargarTipoGestion('#combo_tipo_gestion','combo');
        $('#combo_lista_personas').load(globalUrl+"/gestion/consultas/consultas_gestiones.php",{consulta: "traer_lista_clientes", id_gestion:id_gestion});
        $('#combo_lista_personas2').load(globalUrl+"/gestion/consultas/consultas_gestiones.php",{consulta: "traer_lista_personas", id_gestion:id_gestion});    
        cargarFormularioGestion(-1);
}
        
function agregarDivListaGestiones(){
    $("#div_listado_gestion").load(globalUrl+"/gestion/consultas/consultas_gestiones.php",{consulta: "traer_todos"});
    $("#div_formulario_gestion").fadeOut(1500);
    $("#div_manejo_tipos_gestiones").fadeOut(1500);    
    $("#btn_mostrar_lista_gestiones").fadeOut(1500);
    $("#div_formulario_adjuntos_gestion").fadeOut(1500);
    $("#btn_agregar_gestion").fadeIn(1500);
    $("#btn_agregar_div_tipo_gestion").fadeIn(1500);    
    $("#div_listado_gestion").fadeIn(1500);
    //cargarTipoGestion('#combo_tipo_gestion','combo');
    //$("#btn_agregar_cliente").html('Agregar <i class="fa fa-list"></i>');
    cargarFormularioGestion(-1);
}

function cargarFormularioGestion(una_gestion){    
    $("#retorno_gestion").html("");
    if(una_gestion != -1){
    	$("#txt_id_gestion").val(una_gestion.id_gestion);
        $("#txt_descripcion_gestion").val(una_gestion.descripcion);
        //cargarTipoGestion('#combo_tipo_gestion','combo');
        setTimeout(function(){            
            seleccionarComboConValor("#combo_tipo_gestion",una_gestion.id_tipo_gestion);
        }, 1000);

        $("#txt_fecha_inicio_gestion").val(una_gestion.fecha_inicio);

        if(una_gestion.fecha_fin != null){
            $(".fecha-fin-gestion").fadeIn(1500);
            $("#txt_fecha_fin_gestion").val(una_gestion.fecha_fin);
        }
        if(una_gestion.estado == 1){        	
        	$("#gestion_estado").html("<span style='color:red'><strong>Finalizado</strong></span>");
            $("#btn_finalizar_gestion").text("Re-abrir");
            $('.fecha-fin-gestion').css('display','block');           
        }else $("#gestion_estado").html("<span style='color:green'><strong>En curso</strong></span>");
        

        $(".btn_agregar_tramite_gestion").attr("id", una_gestion.id_gestion+"|"+una_gestion.id_tipo_gestion);
        $(".btn_agregar_tramite_gestion").fadeIn(1500); 

		$("#txt_id_grupo").val(una_gestion.grupo.id_grupo);
		
        cargarListaTramitesDeGestion(una_gestion.tramites);
        agregarGrupoClientes(una_gestion.grupo.clientes);
        agregarGrupoParticipantes(una_gestion.grupo.participantes);
       
    }
    else{
        $("#txt_descripcion_gestion").val("");
        $("#combo_lista_clientes_elegidos").html("");
        $("#combo_lista_participantes_elegidos").html("");        
        $("#txt_fecha_inicio_gestion").val("");
        $("#txt_fecha_fin-gestion").val("");
        $("#btn_finalizar_tramite").text("Finalizar");        
        $("#listado_tramites_de_gestion").html("");
        
        $("#span_id_gestion").text("");
        $("#span_id_tipo_gestion").text("");
        //$("#span_id_tramite").text("un_tramite.id_tramite");        
    }
}

function agregarGrupoClientes(lista_clientes){
    var lista_clientes_seleccionados = $('#combo_lista_clientes_elegidos')[0];
    borrarElementoDeSelector(-1,lista_clientes_seleccionados);
    var option_agregar = '';
    
    jQuery.each(lista_clientes,function(num,data){
        option_agregar += '<option value="' + data.id_persona + '">' + data.nombre + ' ' + data.apellido + ' - ' + data.ci + '</option>';
    });
    $('#combo_lista_clientes_elegidos').append(option_agregar);    
}

function agregarGrupoParticipantes(lista_participantes){    
    var lista_clientes_seleccionados = $('#combo_lista_participantes_elegidos')[0];
    borrarElementoDeSelector(-1,lista_clientes_seleccionados);
    var option_agregar = '';
    
    jQuery.each(lista_participantes,function(num,data){
        option_agregar += '<option value="' + data.id_persona + '">' + data.nombre + ' ' + data.apellido + ' - ' + data.ci + '</option>';
    });
    $('#combo_lista_participantes_elegidos').append(option_agregar);
}



function cargarListaTramitesDeGestion(tramites){
    if(tramites.lengt>0){
        $('#div_listado_tramites_de_gestion_vacio').css('display','block');
        $('#div_listado_tramites_de_gestion_contenedor').css('display','none');
    }
    else{
        $('#div_listado_tramites_de_gestion_vacio').css('display','none');
        $('#div_listado_tramites_de_gestion_contenedor').css('display','block');
    }
    var lista_tramites= '';
    jQuery.each(tramites,function(num,data){
        if(data.fecha_fin != null){
            lista_tramites += '<tr><td class="dato_mostrado_tramite">' + data.id_tramite + '</td><td id="' + data.id_tramite + '" class="dato_mostrado_tramite id_tramite">' + data.descripcion + '</td><td class="dato_mostrado_tramite">' + data.tipo_tramite.descripcion + '</td><td class="dato_mostrado_tramite">' + data.fecha_inicio + '</td><td class="dato_mostrado_tramite">' + data.fecha_fin + '</td><td><p><i class="btn_ver_tramite btn_tramite_detail fa fa-pencil-square-o fa-2x" id="'+ data.id_tramite +'"> </i><i class="btn_eliminar_tramite fa fa-ban fa-2x"></i></p></td></tr>';
        }
        else{
            lista_tramites += '<tr><td class="dato_mostrado_tramite">' + data.id_tramite + '</td><td id="' + data.id_tramite + '" class="dato_mostrado_tramite id_tramite">' + data.descripcion + '</td><td class="dato_mostrado_tramite">' + data.tipo_tramite.descripcion + '</td><td class="dato_mostrado_tramite">' + data.fecha_inicio + '</td><td class="dato_mostrado_tramite"></td><td><p><i class="btn_ver_tramite btn_tramite_detail fa fa-pencil-square-o fa-2x" id="'+ data.id_tramite +'"></i><i class="btn_eliminar_tramite fa fa-ban fa-2x"></i></p></td></tr>';
        }
    });
    $('#listado_tramites_de_gestion').append(lista_tramites);
}

function traerTramitesDeLaGestion(id_gestion){
    $("#div_listado_tramites_de_gestion").load(globalUrl+"/gestion/consultas/consultas_tramites.php",{consulta: "traer_tramites_por_id_gestion", id_gestion: id_gestion});
}

function finalizarGestion(){

        if($("#btn_finalizar_gestion").text()== "Finalizar"){              
            $("#btn_finalizar_gestion").text("Re-abrir");
            $(".fecha-fin-gestion").fadeIn(1500);
            var myDate = new Date();
            var prettyDate =(myDate.getDate() + '/' + myDate.getMonth()+1) + '/' + myDate.getFullYear();           	
           	$("#gestion_estado").html("<span style='color:red'><strong>Finalizado</strong></span>");
            $("#txt_fecha_fin_gestion").val(prettyDate);
        }
        else{
        	$("#gestion_estado").html("<span style='color:green'><strong>En curso</strong></span>");
            $("#btn_finalizar_gestion").text("Finalizar");
            $("#txt_fecha_fin_gestion").val(null);
            $(".fecha-fin-gestion").fadeOut(1500);
        }

}

function agregarClienteAGrupoSelector(){
    var lista_clientes_seleccionados = $('#combo_lista_clientes_elegidos')[0];
    var lista_personas = $('#combo_lista_personas')[0];
    var lista_personas_abajo = $('#combo_lista_personas2')[0];
    var lista_participantes_abajo = $('#combo_lista_participantes_elegidos')[0];    
    var persona_elegida_id = $('#combo_lista_personas').val();
    if(noEstaPersonaEnOtraLista(lista_participantes_abajo,persona_elegida_id)){
        var persona_elegida_contenido = $('#combo_lista_personas').find(":selected").text();
        var option_agregar = '<option value="' + persona_elegida_id + '">' + persona_elegida_contenido + '</option>'
        //var no_hay_clientes_elegidos = $('#combo_lista_clientes_elegidos')[0].selectedIndex;
        borrarElementoDeSelector(-1,lista_clientes_seleccionados);
        borrarElementoDeSelector(persona_elegida_id,lista_personas);
        borrarElementoDeSelector(persona_elegida_id,lista_personas_abajo);    
        if(persona_elegida_id == null){
            alert("Debe seleccionar a una persona para poder agregarla al grupo");
        }
        else{
            $('#combo_lista_clientes_elegidos').append(option_agregar);
        }
    }
    else{
        alert('Para agregar a esta persona, debe quitarla antes de la otra lista');
    }

}

function noEstaPersonaEnOtraLista(lista_participantes_abajo,persona_elegida_id){
    var retorno = true;
    jQuery.each(lista_participantes_abajo,function(num,data){
        if(data.value == persona_elegida_id){
            retorno = false;
        }
       }
    );
        return retorno;
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
        $('#combo_lista_personas2').append(option_agregar);
    }
    //var persona_elegida = $('#combo_lista_personas').find(":selected").text();
    //alert(persona_elegida);
}

function agregarParticipanteAGrupoSelector(){
    var lista_clientes_seleccionados = $('#combo_lista_participantes_elegidos')[0];
    var lista_personas = $('#combo_lista_personas2')[0];
    //var lista_personas_arriba = $('#combo_lista_personas')[0];
    var persona_elegida_id = $('#combo_lista_personas2').val();
    var persona_elegida_contenido = $('#combo_lista_personas2').find(":selected").text();
    var option_agregar = '<option value="' + persona_elegida_id + '">' + persona_elegida_contenido + '</option>'
    //var no_hay_clientes_elegidos = $('#combo_lista_clientes_elegidos')[0].selectedIndex;
    borrarElementoDeSelector(-1,lista_clientes_seleccionados);
    borrarElementoDeSelector(persona_elegida_id,lista_personas);
    //borrarElementoDeSelector(persona_elegida_id,lista_personas_arriba);    
    if(persona_elegida_id == null){
        alert("Debe seleccionar a una persona para poder agregarla al grupo");
    }
    else{
        $('#combo_lista_participantes_elegidos').append(option_agregar);
    }
}

function quitarParticipanteAGrupoSelector(){
    var lista_personas_seleccionadas = $('#combo_lista_participantes_elegidos')[0];
    //var lista_personas = $('#combo_lista_personas')[0];
    var persona_elegida_id = $('#combo_lista_participantes_elegidos').val();    
    var persona_elegida_contenido = $('#combo_lista_participantes_elegidos').find(":selected").text();
    var option_agregar = '<option value="' + persona_elegida_id + '">' + persona_elegida_contenido + '</option>'
    //var no_hay_clientes_elegidos = $('#combo_lista_clientes_elegidos')[0].selectedIndex;
    //borrarElementoDeSelector(-1,lista_clientes_seleccionados);
    borrarElementoDeSelector(persona_elegida_id,lista_personas_seleccionadas);
    if(persona_elegida_id == null){
        alert("Debe seleccionar a una persona para poder quitarla del grupo");
    }
    else{
        //combo_lista_clientes_elegidos
        
        //$('#combo_lista_personas').append(option_agregar);
        $('#combo_lista_personas2').append(option_agregar);
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
	//var vid_gestion = $("#txt_id_gestion").val();
    var vdescripcion = $("#txt_descripcion_gestion").val();
    var vtipo_gestion = $("#combo_tipo_gestion").val();
    var vfecha_inicio = $("#txt_fecha_inicio_gestion").val();    
    var vfecha_fin = $("#txt_fecha_fin_gestion").val();
   
    var vestado=0;
    if(vfecha_fin != ''){      
            vestado = 1;
    }
    
    var vid_grupo = $("#txt_id_grupo").val();
	var lista_id_clientes = new Array();
    var lista_id_participantes = new Array();
    
	  var cId=document.getElementById("combo_lista_clientes_elegidos");
	  for (var i = 0; i < cId.options.length; i++) {
	  		lista_id_clientes[i] = cId.options[i].value;		          
	  }    
    
	  var pId=document.getElementById("combo_lista_participantes_elegidos");
	  for (var i = 0; i < pId.options.length; i++) {
	  		lista_id_participantes[i] = pId.options[i].value;
	  }
   
    var vid_gestion = GLOBAL_id_gestion;
     
    if(vdescripcion != ''){
        if(vid_gestion > 0){           
            $.post(globalUrl+"/gestion/consultas/consultas_gestiones.php", {consulta: "modificar_gestion", id_gestion:vid_gestion, descripcion:vdescripcion, tipo_gestion:vtipo_gestion, fecha_inicio:vfecha_inicio, fecha_fin:vfecha_fin, estado:vestado, id_grupo:vid_grupo, lista_id_clientes:lista_id_clientes, lista_id_participantes:lista_id_participantes})
                    .done(function(data) {            
                        var retorno = parseInt(data);
                        if(retorno==1){
                            $("#retorno_gestion").html("<span style='color:green'><strong>La gestión fue modificada exitosamente!</strong></span>");
                            $("#btn_mostrar_lista_gestiones").trigger("click");
                        }
                        else{
                        	console.log(retorno);
                            $("#retorno_gestion").html("<span style='color:red'><strong>¡La gestión no fue modificada, revise los datos ingresados!</strong></span>");
                        }
            },"json");      	
        }
        else{
            $.post(globalUrl+"/gestion/consultas/consultas_gestiones.php", {consulta: "agregar_gestion", descripcion:vdescripcion, tipo_gestion:vtipo_gestion, fecha_inicio:vfecha_inicio, fecha_fin:vfecha_fin, estado:vestado, lista_id_clientes:lista_id_clientes, lista_id_participantes:lista_id_participantes})
                    .done(function(data) {            
                        var retorno = parseInt(data);
                        if(retorno>0){
                            $f("#retorno_gestion").html("<span style='color:green'><strong>La gestión fue agregada exitosamente!</strong></span>");
                            $("#btn_agregar_tramite_gestion").fadeIn(1500);                            
                            $("#btn_mostrar_lista_gestiones").trigger("click");
                        }
                        else{
                            $("#retorno_gestion").html("<span style='color:red'><strong>¡La gestión no fue agregada, revise los datos ingresados!</strong></span>");
                        }
            });    	
        }
    }
    else{
        alert('Debe llenar el campo Descripción para poder guardar esta Gestión');
    }

}

function agregarParticipanteALista(){
    if($('#formulario_agregar_participante').css('display')=='none'){
        $('#formulario_agregar_participante').fadeIn(1500);
    }
    else{
        $('#formulario_agregar_participante').fadeOut(1500);
    }
}

function guardarParticipanteGestion(){
    var nombre_par = $.trim($("#txt_nombre_participante_gestion").val());
    var apellido_par = $.trim($("#txt_apellido_participante_gestion").val());
    var ci_par = $.trim($("#txt_ci_participante_gestion").val());
    var email_par = $.trim($("#txt_email_participante_gestion").val());
    var telefono_par = $.trim($("#txt_telefono_participante_gestion").val());
    var direccion_par = $.trim($("#txt_direccion_participante_gestion").val());

    $.post(globalUrl+"/gestion/consultas/consultas_gestiones.php", {consulta: "agregar_participante",nombre: nombre_par, apellido: apellido_par, ci: ci_par, email: email_par, telefono: telefono_par, direccion: direccion_par})
        .done(function(data) {
        if(parseInt(data) > 0){       
		   $("#retorno_participante").html("<span style='color:green'></span>");
           $(".input-par").val("");
           $("#formulario_agregar_participante").css("display","none");
           $('#combo_lista_personas2').append($("<option />").val(parseInt(data)).text(nombre_par+" "+apellido_par+" - CI:"+ci_par));          
        }
        else{        	
			$("#retorno_participante").html("<span style='color:red'><strong>El participante no ha sido agregado, verifique los datos!</strong></span>");
        }
    });

}

function traerGestionPorIdUrl($id_gestion){   	  
    $.post(globalUrl+"/gestion/consultas/consultas_gestiones.php", {consulta: "traer_por_id",id_gestion: $id_gestion})
            .done(function(data) {        
                agregarDivDatosGestion();
                var una_gestion = jQuery.parseJSON(data);
                cargarFormularioGestion(una_gestion);        
        }, "json");  
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
    $.post(globalUrl+"/gestion/consultas/consultas_gestiones.php", {consulta: "matchear_por_id", id_gestion: id_gestion})
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
  MÉTODOS DE TIPO GESTION
  ---------------------------------------------------------------------------------------------------------------
  ---------------------------------------------------------------------------------------------------------------*/
function agregarDivCrearTipoGestion(){    
    if($('#formulario_agregar_tipo_gestion').css('display')=='none'){
        $('#formulario_agregar_tipo_gestion').fadeIn(1500);
    }
    else{
        $('#formulario_agregar_tipo_gestion').fadeOut(1500);
    }
}

function agregarDivManejoTipoGestion(){    
        $("#div_listado_gestion").fadeOut(1500);
        $("#btn_agregar_div_tipo_gestion").fadeOut(1500);        
        $("#div_formulario_gestion").fadeOut(1500);
        $("#btn_mostrar_lista_gestiones").fadeOut(1500); 
        $("#btn_agregar_gestion").fadeOut(1500);
        $("#formulario_agregar_tipo_gestion2").fadeOut(1500);
        $("#btn_ver_lista_tipos_gestion_manejo").fadeOut(1500);
        $("#div_lista_tipos_gestion").fadeIn(1500);
        $("#btn_nuevo_tipo_gestion_manejo").fadeIn(1500);        
        $("#btn_volver_a_gestiones").fadeIn(1500);        
        $("#div_manejo_tipos_gestiones").fadeIn(1500);        
        cargarTipoGestion('#listado_tipos_de_gestion','tabla');
        
        $("#listado_tipos_tramites_de_tipo_gestion").html('');
       
        //$('#combo_lista_personas').load(globalUrl+"/gestion/consultas/consultas_gestiones.php",{consulta: "traer_lista_clientes", id_gestion:id_gestion});
        //$('#combo_lista_personas2').load(globalUrl+"/gestion/consultas/consultas_gestiones.php",{consulta: "traer_lista_personas", id_gestion:id_gestion});
    
        //cargarFormularioGestion(-1);
}

function agregarDivDatosTipoGestion(){
        GLOBAL_id_tipo_gestion = -1;
        $("#formulario_agregar_tipo_gestion2").fadeIn(1500);
        $("#btn_ver_lista_tipos_gestion_manejo").fadeIn(1500);
        $("#btn_nuevo_tipo_gestion_manejo").fadeOut(1500);        
        $("#div_lista_tipos_gestion").fadeOut(1500);     
        cargarFormularioTipoGestion(-1);
}

function cargarFormularioTipoGestion(un_tipo_gestion){    
    if(un_tipo_gestion != -1){
        GLOBAL_id_tipo_gestion = un_tipo_gestion.id_tipos_gestion;
        $("#txt_descripcion_tipo_gestion2").val(un_tipo_gestion.descripcion);
        $("#btn_agregar_tipo_tramite_tipo_gestion").val(un_tipo_gestion.id_tipos_gestion);         
        $("#btn_agregar_tipo_tramite_tipo_gestion").css('display','block');
        var lista_tt = un_tipo_gestion.tipos_tramites;
        if(lista_tt.length > 0){
            $('#div_listado_tipos_tramites_de_tipo_gestion_contenedor').fadeIn(1500);
            llenarListaTiposTramiteDeTipoGestion(lista_tt);
        }
        else{
            $('#div_listado_tipos_tramites_de_tipo_gestion_contenedor').fadeOut(1500);
        }
    }
    else{
        $("#txt_descripcion_tipo_gestion2").val("");
        $("#btn_agregar_tipo_tramite_tipo_gestion").val(-1);
        $("#btn_agregar_tipo_tramite_tipo_gestion").css('display','none');
    }
}

function llenarListaTiposTramiteDeTipoGestion(lista_tt){
    var item='';
    jQuery.each(lista_tt,function(num,data){
             item = '<tr><td class="dato_mostrado_tipo_tramite_TG">' + data.id_tipo_tramite + '</td><td id="' + data.id_tipo_tramite + '" class="dato_mostrado_tipo_tramite_TG">' + data.descripcion + '</td><td><button id="btn_ver_plantilla_desde_lista" type="button" class="btn btn-success btn-xs" value="' + data.id_tipo_tramite + '">Ver</button></td><td><p><i class="btn_ver_tipo_tramite_TG fa fa-pencil-square-o fa-2x"></i><i class="btn_eliminar_tipo_tramite fa fa-ban fa-2x"></i></p></td></tr>';
             $('#listado_tipos_tramites_de_tipo_gestion').append(item);
        }
    );
}

function volverAGestiones(){
    $("#btn_volver_a_gestiones").fadeOut(1500);
    agregarDivListaGestiones();
}

function cargarTipoGestion(id_elemento_dom,tipo){
    $.post(globalUrl+"/gestion/consultas/consultas_tipos_gestiones.php", {consulta: "traer_tipos_gestion"})
                    .done(function(data) {            
                        
                     var lista_tipos_gestiones = jQuery.parseJSON(data);
                     if(tipo=='combo'){
                        cargarComboConLista(lista_tipos_gestiones,id_elemento_dom);
                     }
                     else{
                         cargarTablaConLista(lista_tipos_gestiones,id_elemento_dom);
                     }
            },"json");
}

function cargarComboConLista(lista_tipos_gestiones,id_elemento_dom){
    $(id_elemento_dom).html('');
    var item;
    jQuery.each(lista_tipos_gestiones,function(num,data){
             item = '<option value="'+ data.id_tipos_gestion +'">' + data.descripcion + '</option>';
             $(id_elemento_dom).append(item);
        }
    );
}

function cargarTablaConLista(lista_tipos_gestiones,id_elemento_dom){
    $(id_elemento_dom).html('');
    var item;
    jQuery.each(lista_tipos_gestiones,function(num,data){
             item = '<tr><td value="'+ data.id_tipos_gestion +'" class="dato_mostrado_tipo_gestion">'+ data.id_tipos_gestion +'</td><td class="dato_mostrado_tipo_gestion">' + data.descripcion + '</td><td><p><i title="Modificar" class="btn_modificar_tipo_gestion fa fa-pencil-square-o fa-2x"></i><i title="Eliminar" class="btn_eliminar_tipo_gestion fa fa-ban fa-2x"></i></p></td></tr>';
             $(id_elemento_dom).append(item);
        }
    );
}


function agregarTipoGestionGestion(){
	var descripcion_tipo_gestion = $.trim($("#txt_descripcion_tipo_gestion").val());
    $.post(globalUrl+"/gestion/consultas/consultas_gestiones.php", {consulta: "agregar_tipo_gestion",descripcion: descripcion_tipo_gestion})
        .done(function(data) {
        if(parseInt(data) > 0){       
		   $("#retorno_tipo_gestion").html("<span style='color:green'></span>");
           $("#txt_descripcion_tipo_gestion").val("");
           $("#formulario_agregar_tipo_gestion").fadeOut(1500);
           $('#combo_tipo_gestion').append($("<option />").val(parseInt(data)).text(descripcion_tipo_gestion));          
        }
        else{        	
			$("#retorno_tipo_gestion").html("<span style='color:red'><strong>Tipo no agregado, verifique los datos!</strong></span>");
        }
    });
}

function agregarTipoGestion2(){
    var descripcion_tipo_gestion = $.trim($("#txt_descripcion_tipo_gestion2").val());
    var vid_tipo_gestion = GLOBAL_id_tipo_gestion;
    if(vid_tipo_gestion > 0)
    {
        $.post(globalUrl+"/gestion/consultas/consultas_tipos_gestiones.php", {consulta: "modificar_tipo_gestion",descripcion: descripcion_tipo_gestion,id_tipo_gestion:vid_tipo_gestion})
            .done(function(data) {
            if(parseInt(data) > 0){       
                $("#retorno_tipo_gestion2").html("<span style='color:green'>Tipo Gestión modificado exitosamente</span>");
                agregarDivManejoTipoGestion();
            }
            else{
                $("#retorno_tipo_gestion2").html("<span style='color:red'><strong>Tipo no agregado, verifique los datos!</strong></span>");
            }
        });	
    }
    else
    {
        $.post(globalUrl+"/gestion/consultas/consultas_tipos_gestiones.php", {consulta: "agregar_tipo_gestion",descripcion: descripcion_tipo_gestion})
            .done(function(data) {
            if(parseInt(data) > 0){       
                $("#retorno_tipo_gestion2").html("<span style='color:green'>Tipo Gestión agregado exitosamente</span>");
                agregarDivManejoTipoGestion();
            }
            else{
                $("#retorno_tipo_gestion2").html("<span style='color:red'><strong>Tipo no agregado, verifique los datos!</strong></span>");
            }
        });    	
    }
}

function eliminarTipoGestion(){
    var confirmado = confirm("¿Seguro que desea eliminar el tipo de gestión? Recuerde que no podrá eliminar Tipos de Gestiones que tengan gestiones asociadas.");
    if(confirmado){
        var id_tipo_gestion = $($(this).parent().parent().parent().children()[0]).text();  
        $.post(globalUrl+"/gestion/consultas/consultas_tipos_gestiones.php", {consulta: "eliminar_por_id",id_tipo_gestion: id_tipo_gestion})
                .done(function(data) {
                    $("#retorno_tipo_gestion2").html(data);
            }, "json");
        $(this).parent().parent().parent().fadeOut(1500);       
    }
}

function traerTipoGestionElegidaClicNombre(){
    //var documento = $($(this).parent().children()[2]).text();
    var id_tipo_gestion = $($(this).parent().children()[0]).text();    
    traerTipoGestionElegido(id_tipo_gestion);
}


function traerTipoGestionElegidaClicIcono(){
    var id_tipo_gestion = $($(this).parent().parent().parent().children()[0]).text();    
    traerTipoGestionElegido(id_tipo_gestion);
}

function traerTipoGestionElegido(id_tipo_gestion){  
    //GLOBAL_id_tipo_gestion = id_tipo_gestion;
    $.post(globalUrl+"/gestion/consultas/consultas_tipos_gestiones.php", {consulta: "matchear_por_id", id_tipo_gestion: id_tipo_gestion})
            .done(function(data) {            
                agregarDivDatosTipoGestion();
                var un_tipo_gestion = jQuery.parseJSON(data);
                cargarFormularioTipoGestion(un_tipo_gestion);
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
        
    if(GLOBAL_id_tramite === undefined || GLOBAL_id_tramite <= 0)
    {
    	$("#btn_agregar_adjunto").css("display","none");
    	$("#info_adjuntos").html("<span style='color:grey'><strong>*Para agregar adjuntos al trámite, edite el mismo a posterori de agregarlo</strong></span>");
    } 
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
	    $.post(globalUrl+"/gestion/consultas/consultas_tramites.php", {consulta: "modificar_tramite", id_tramite:vid_tramite, descripcion:vdescripcion, id_tipo_tramite:vtipo_tramite, fecha_inicio:vfecha_inicio, fecha_fin:vfecha_fin, id_gestion:vid_gestion, id_tipo_gestion:vid_tipo_gestion, plantilla_modificada:vplantilla, estado:vestado})
	            .done(function(data) {            
	                var retorno = parseInt(data);
	                if(retorno==1){
	                    $("#retorno_borrado_tramite").html("<span style='color:green'><strong>Trámite modificado exitosamente! Ud. será redirigido a la gestión</strong></span>");
	                    setTimeout(function(){goToGestion(vid_gestion)},3000);	    
	                }
	                else{
	                    $("#retorno_borrado_tramite").html("<span style='color:red'><strong>Trámite no modificado ! Revise los datos</strong></span>");
	                }
	        });      	
    }
    else
    {
	    $.post(globalUrl+"/gestion/consultas/consultas_tramites.php", {consulta: "agregar_tramite", descripcion:vdescripcion, id_tipo_tramite:vtipo_tramite, fecha_inicio:vfecha_inicio, fecha_fin:vfecha_fin, id_gestion:vid_gestion, id_tipo_gestion:vid_tipo_gestion, plantilla_modificada:vplantilla, estado:vestado})
	            .done(function(data) {            
	                var retorno = parseInt(data);
	                if(retorno==1){
	                    $("#retorno_borrado_tramite").html("<span style='color:green'><strong>Trámite agregado exitosamente! Ud. será redirigido a la gestión</strong></span>");
	                    setTimeout(function(){goToGestion(vid_gestion)},3000);	                    
	                }
	                else{
	                    $("#retorno_borrado_tramite").html("<span style='color:red'><strong>Trámite no agregado ! Revise los datos</strong></span>");
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
    plantilla = undefined;
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

function traerTramitePorIdUrl(id_tramite){
    $.post(globalUrl+"/gestion/consultas/consultas_tramites.php", {consulta: "traer_por_id",id_tramite: id_tramite})
            .done(function(data) {            
                agregarDivDatosTramite();                
                var un_tramite = jQuery.parseJSON(data);
                cargarFormularioTramite(un_tramite);
                /*setTimeout(function(){
                    cargarPlantilla();
                }, 1000);*/
        }, "json");  
        setTimeout(function(){            
                    cargarPlantilla();
                }, 1000);
}

function traerTramitePorId(id_tramite){
    //$.post(globalUrl+"/gestion/consultas/consultas_tramites.php", {consulta: "matchear_por_id",id_tramite: id_tramite})
    $.post(globalUrl+"/gestion/consultas/consultas_tramites.php", {consulta: "traer_por_id",id_tramite: id_tramite})    
            .done(function(data) {            
                agregarDivDatosTramite();                
                var un_tramite = jQuery.parseJSON(data);
                cargarFormularioTramite(un_tramite);  
                //setTimeout(function(){            
                    //cargarPlantilla();
                //}, 1000);
                //cargarPlantilla();
        }, "json");  
        
}

function finalizarTramite(){
    if($.trim($("#span_id_tramite").text())!=""){
        
    }
    else{
        if($("#btn_finalizar_tramite").text()== "Finalizar"){   
        	$("#tramite_estado").html("<span style='color:red'><strong>Finalizado</strong></span>");   
            $("#btn_finalizar_tramite").text("Re-abrir");
            $(".fecha-fin").fadeIn(1500);
            var myDate = new Date();
            var prettyDate =(myDate.getDate() + '/' + myDate.getMonth()+1) + '/' + myDate.getFullYear();
            $( ".fecha-fin" ).val(prettyDate);
            $("#txt_fecha_fin").val(prettyDate);
            //$( ".fecha-fin" ).datepicker('setDate', 'today');
        }
        else{
        	$("#tramite_estado").html("<span style='color:green'><strong>En curso</strong></span>");
            $("#btn_finalizar_tramite").text("Finalizar");
            $(".fecha-fin").fadeOut(1500);
            $("#txt_fecha_fin").val(null);
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
    	var gestionDelTramite = getGestionByTramite(un_tramite.id_gestion);
    	
    	$("#txt_id_tramite").val(un_tramite.id_tramite);
        $("#txt_descripcion_tramite").val(un_tramite.descripcion);
        
        setTimeout(function(){            
            seleccionarComboConValor("#combo_tipo_tramite",un_tramite.id_tipo_tramite);
        }, 1000);
        
       // $("#combo_tipo_tramite option:selected").val(un_tramite.id_tipo_tramite);
        $("#txt_fecha_inicio").val(un_tramite.fecha_inicio);
        //plantilla = un_tramite.plantilla;
        
        if(un_tramite.fecha_fin != null){
            $(".fecha-fin").fadeIn(1500);
            $("#txt_fecha_fin").val(un_tramite.fecha_fin);
        }
        if(un_tramite.estado == 1){
            $("#btn_finalizar_tramite").text("Re-abrir");
            $('.fecha-fin').css('display','bock');
            $("#tramite_estado").html("<span style='color:red'><strong>Finalizado</strong></span>");
        }else $("#tramite_estado").html("<span style='color:green'><strong>En curso</strong></span>");
        
        $("#span_id_gestion").text(un_tramite.id_gestion);
        $("#span_id_tipo_gestion").text(un_tramite.id_tipo_gestion);
        $("#nombre_gestion_trammite").text("oola");
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
        cargarPlantilla();
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

function getGestionByTramite(id_gestion)
{
    $.post(globalUrl+"/gestion/consultas/consultas_tramites.php",{consulta:"gestion_por_tramite", id_gestion:id_gestion})
            .done(function(data) {    
            	var gestion = jQuery.parseJSON(data);        	         	
            	$("#nombre_gestion_trammite").html("<strong>"+gestion.descripcion+"</strong>");
        		
            }, "json");	
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
   // $( "#dialog_plantilla" ).dialog( "option", "title", tipo_tramite );
    //alert(tipo_tramite);
}

function cargarPlantilla(){
     if(typeof plantilla === 'undefined'){
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
    }
}

function mostrarDialogPlantilla(){    
    if(typeof plantilla === 'undefined'){
        cargarPlantilla();
    }
    else{
        var una_plantilla = '<textarea id="editor1" name="editor1">'+plantilla;
        una_plantilla += '</textarea><script type="text/javascript">CKEDITOR.replace( "editor1" );</script>';
        $("#dialog_plantilla").html(una_plantilla);
    }
    mostrarDialogPlantilla_mismo();
}

function mostrarDialogPlantilla_mismo(){
   
    $("#dialog_plantilla").dialog({width: 800,modal: true,
    buttons: {
    	
                Imprimir: 
                {
                	text: "Generar PDF a imprimir",
	                click : function () {
	                    plantilla = CKEDITOR.instances.editor1.getData();
	                    convertirAPdf(plantilla);
	                }                	
                },    	
                DelUser:{ 
                    class: 'leftButton',
                    text: 'Aceptar',
                    click : function (){
                        plantilla = CKEDITOR.instances.editor1.getData();
                        //guardarTramite();
                        //alert(planilla_llena);
                        $(this).dialog("close");
                    }
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
        
function addNewTipoTramiteByTipoGestion() 
{
    var id_tipo_gestion = $('#btn_agregar_tipo_tramite_tipo_gestion').val();
    window.location.href="plantillas?id_tipo_gestion="+id_tipo_gestion+"&id_tipo_tramite=-1";
}

function traerTipoTramiteByTipoGestion(){
    var id_tipo_tramite = $(this).parent().children()[1].id;
    //if(id_tipo_tramite !== ""){
    if(!id_tipo_tramite){
        id_tipo_tramite = $($(this).parent().parent().parent().children()[0]).text();
    }
    var id_tipo_gestion = $('#btn_agregar_tipo_tramite_tipo_gestion').val();
    window.location.href="plantillas?id_tipo_gestion="+id_tipo_gestion+"&id_tipo_tramite="+id_tipo_tramite;
}

function agregarDivDatosPlantilla(){
    plantilla = 'Agregue el texto de la plantilla aquí.';
    $("#div_listado_plantillas").fadeOut(1500);        
    $("#btn_agregar_plantilla").fadeOut(1500);
    $("#btn_mostrar_lista_plantillas").fadeIn(1500);        
    $("#div_formulario_plantilla").fadeIn(1500);
    //$('#combo_tipo_gestion_pl').load(globalUrl+"/gestion/consultas/consultas_plantillas.php",{consulta: "traer_tipos_gestion"});
    cargarTipoGestion('#combo_tipo_gestion_pl','combo')
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
            
            setTimeout(function(){            
                seleccionarComboConValor("#combo_tipo_gestion_pl",un_tipo_tramite.id_tipos_gestion);
            }, 1000);
            
            //$("#combo_tipo_gestion_pl").val(un_tipo_tramite.tipo_gestion);
            //$("#dialog_plantilla").val(un_tipo_tramite.plantilla);
            plantilla = un_tipo_tramite.plantilla;
            var una_plantilla = '<textarea id="editorTT" name="editorTT">'+un_tipo_tramite.plantilla;
            una_plantilla += '</textarea><script type="text/javascript">CKEDITOR.replace( "editorTT" );</script>';
            $("#dialog_plantilla_tt").html(una_plantilla);
            GLOBAL_tipo_tramite_desc = un_tipo_tramite.descripcion;
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
        GLOBAL_id_tipo_tramite = undefined;
    }
}

function traerTipoTramiteElegido(){
    var id_tipo_tramite = $(this).parent().children()[1].id;
    //if(id_tipo_tramite !== ""){
    if(!id_tipo_tramite){
        id_tipo_tramite = $($(this).parent().parent().parent().children()[0]).text();
    }
    GLOBAL_id_tipo_tramite = id_tipo_tramite;
    var solo_plantilla = false;
    traerTipoTramitePorId(id_tipo_tramite, solo_plantilla);
}

function traerTipoTramiteElegidoPorId(id_tipo_tramite){
    GLOBAL_id_tipo_tramite = id_tipo_tramite;
    var solo_plantilla = false;
    traerTipoTramitePorId(id_tipo_tramite, solo_plantilla);
}

function traerTipoTramitePorId(id_tipo_tramite,solo_plantilla){
    $.post(globalUrl+"/gestion/consultas/consultas_plantillas.php", {consulta: "matchear_por_id",id_tipo_tramite: id_tipo_tramite})
            .done(function(data) {     
                if(!solo_plantilla){
                    agregarDivDatosPlantilla();
                }
                var un_tipo_tramite = jQuery.parseJSON(data);
                cargarFormularioTipoTramite(un_tipo_tramite);      
        }, "json");  
}

function mostrarDialogPlantilla_tt(){
    var id_tipo_tramite = GLOBAL_id_tipo_tramite;
    if(id_tipo_tramite > 0){
        var solo_plantilla = false;
        traerTipoTramitePorId(id_tipo_tramite, solo_plantilla);
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
                Imprimir: 
                {
                	text: "Generar PDF a imprimir",
	                click : function () {
	                    plantilla = CKEDITOR.instances.editorTT.getData();
	                    convertirAPdf(plantilla);
	                }                	
                },
                Aceptar: function () {
                    plantilla = CKEDITOR.instances.editorTT.getData();
                    $(this).dialog("close");
                }
            }
        });
}

function mostrarDialogPlantilla_tg(){
    var id_tipo_tramite = $(this).val();
    //var id_tipo_tramite = GLOBAL_id_tipo_tramite;
    if(id_tipo_tramite > 0){
        var solo_plantilla = true;
        traerTipoTramitePorId(id_tipo_tramite,solo_plantilla);
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
                Imprimir: 
                {
                	text: "Generar PDF a imprimir",
	                click : function () {
	                    plantilla = CKEDITOR.instances.editorTT.getData();
	                    convertirAPdf(plantilla);
	                }                	
                },

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
    var confirmado = confirm("¿Seguro que desea eliminar este tipo de trámite? No se pueden eliminar tipos de trámite que estén asociados a trámites.");
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

function imprimirPlantilla(html) {
    //htmlParaVer = '<html><head><title>Imprimir Plantilla</title><link rel="stylesheet" href="../bootstrap/css/bootstrap.css" type="text/css"><!--link rel="stylesheet" href="./css/estiloEvimed.css" type="text/css"><script type="text/javascript" src="../bootstrap/js/bootstrap.js"></script><script type="text/javascript" src="../bootstrap/js/bootstrap-tooltip.js"></script> <script type="text/javascript" src="../bootstrap/js/bootstrap-popover.js"></script--></head><body><div id="container"><div id="plantilla">' + html + '</div></div></body></html>';
    var htmlParaVer = '<html><head><style>body {height: 842px;width: 595px;margin-left: auto;margin-right: auto;}</style><title>Imprimir Plantilla</title><link rel="stylesheet" href="../bootstrap/css/bootstrap.css" type="text/css"><!--link rel="stylesheet" href="./css/estiloEvimed.css" type="text/css"><script type="text/javascript" src="../bootstrap/js/bootstrap.js"></script><script type="text/javascript" src="../bootstrap/js/bootstrap-tooltip.js"></script> <script type="text/javascript" src="../bootstrap/js/bootstrap-popover.js"></script--></head><body><div id="container"><div id="plantilla">' + html + '</div></div></body></html>';
              
    var ventana = window.open("", "popup", "");
    ventana.document.open();
    ventana.document.write(htmlParaVer);
    ventana.document.close();
}

function convertirAPdf(html) {		
	$("#plantilla_nombre").val(GLOBAL_tipo_tramite_desc);
	$("#plantilla_value").val(html);
	$( "#form_plantilla" ).submit();
}



/*---------------------------------------------------------------------------------------------------------------
  ---------------------------------------------------------------------------------------------------------------
  MÉTODOS DE USUARIO
  ---------------------------------------------------------------------------------------------------------------
  ---------------------------------------------------------------------------------------------------------------*/
function agregarDivDatosUsuario(){    
    //if($("#div_formulario_cliente").css("display") == "none"){        
        $("#div_listado_usuarios").fadeOut(1500);        
        $("#btn_agregar_usuario").fadeOut(1500);
        $("#btn_mostrar_lista_usuarios").fadeIn(1500);        
        $("#div_formulario_usuario").fadeIn(1500);
        //$("#btn_agregar_cliente").text("Mostrar Lista"); 
        cargarFormularioUsuario(-1);

}


function agregarDivListaUsuarios(){
    GLOBAL_id_usuario = undefined;
    $("#div_listado_usuarios").load(globalUrl+"/gestion/consultas/consultas_usuarios.php",{consulta: "traer_todos"});
    $("#div_formulario_usuario").fadeOut(1500);
    $("#btn_mostrar_lista_usuarios").fadeOut(1500);
    $("#btn_agregar_usuario").fadeIn(1500);
    $("#div_listado_usuarios").fadeIn(1500);
    cargarFormularioUsuario(-1);
}

function cargarFormularioUsuario(un_usuario){
    if(un_usuario != -1){
        $("#txt_nombre_usuario").val(un_usuario.nombre);
        $("#txt_apellido_usuario").val(un_usuario.apellido);
        $("#txt_email_usuario").val(un_usuario.email);
        //$("#txt_pass_usuario").val(un_usuario.contraseña);        
    }
    else{
        $("#txt_nombre_usuario").val("");
        $("#txt_apellido_usuario").val("");
        $("#txt_email_usuario").val("");
        $("#txt_pass_usuario").val("");        
        
    }
    $('#retorno_borrado_usuario').html('');
}



function traerUsuarioElegidoClicNombre(){
    //var documento = $($(this).parent().children()[2]).text();
    var id_usuario = $($(this).parent().children()[0]).text();    
    traerUsuarioElegido(id_usuario);
}

function traerUsuarioElegidoClicIcono(){
    //var documento = $($(this).parent().parent().parent().children()[2]).text();
    var id_usuario = $($(this).parent().parent().parent().children()[0]).text();    
    traerUsuarioElegido(id_usuario);
}

function traerUsuarioElegido(id_usuario){ 
    $.post(globalUrl+"/gestion/consultas/consultas_usuarios.php", {consulta: "traer_por_id",id_usuario: id_usuario})
            .done(function(data) {            
                agregarDivDatosUsuario();
                var un_usuario = jQuery.parseJSON(data);
                cargarFormularioUsuario(un_usuario);             
        }, "json");
        GLOBAL_id_usuario = id_usuario;
}

function eliminarUsuarioElegido(){
    var confirmado = confirm("¿Seguro que desea eliminar a este usuario?");
    if(confirmado){
        //var documento = $($(this).parent().children()[2]).text();  
        var id_usuario = $($(this).parent().parent().parent().children()[0]).text();
        $.post(globalUrl+"/gestion/consultas/consultas_usuarios.php", {consulta: "eliminar_por_id",id_persona: id_usuario})
                .done(function(data) {
                    $("#retorno_borrado_usuario").html(data);
                    //$('#content').append(un_cliente);
            }, "json");
        //$("input").prop('disable', true);
        //ocultamos el borrado
        $(this).parent().parent().parent().fadeOut(1500);       
    }
}

function guardarUsuario(){
    var nombre_usuario = $.trim($("#txt_nombre_usuario").val());
    var apellido_usuario = $.trim($("#txt_apellido_usuario").val());
    var email_usuario = $.trim($("#txt_email_usuario").val());
    var pass_usuario = $.trim($("#txt_pass_usuario").val());
    
    var valido = validarDatosIngresadosUsuario(nombre_usuario,apellido_usuario,email_usuario,pass_usuario);
    if(valido == 1){
        if(typeof GLOBAL_id_usuario === 'undefined'){
            $.post(globalUrl+"/gestion/consultas/consultas_usuarios.php", {consulta: "agregar_usuario",nombre: nombre_usuario, apellido: apellido_usuario, email: email_usuario, pass: pass_usuario})
                .done(function(data) {
                if(parseInt(data) > 0){
                    $("#retorno_ajax_usuario").html("<strong style='color:green;'>El usuario "+nombre_usuario+" "+apellido_usuario+" se ingresó con éxito</strong>");
                    cargarFormularioCliente(-1);
                    agregarDivListaUsuarios();
                }
                else{
                    $("#retorno_ajax_usuario").append(data);
                }
            });
        }
        else{
            $.post(globalUrl+"/gestion/consultas/consultas_usuarios.php", {consulta: "modificar_usuario",id_persona:GLOBAL_id_usuario,nombre: nombre_usuario, apellido: apellido_usuario, email: email_usuario, pass: pass_usuario})
                .done(function(data) {
                if(parseInt(data) == 1){
                    $("#retorno_ajax_usuario").html("<strong style='color:green;'>El usuario "+nombre_usuario+" "+apellido_usuario+" se modificó con éxito</strong>");
                    cargarFormularioCliente(-1);
                    agregarDivListaUsuarios();
                }
                else{
                    $("#retorno_ajax_usuario").append(data);
                }
            });
        }
    }
    else{
        alert("Error. Llene todo el formulario para guardar!");
    }
    //$("#retorno_ajax").load("'+globalUrl+'/gestion/consultas/consultas_clientes.php",{consulta: "agregar_cliente",nombre: nombre_cli, apellido: apellido_cli, ci: ci_cli, email: email_cli, telefono: telefono_cli, direccion: direccion_cli, ci_escaneada: ci_escaneada_cli});
}

function validarDatosIngresadosUsuario(nombre_usuario,apellido_usuario,email_usuario,pass_usuario){
    return nombre_usuario != '' && apellido_usuario != '' && email_usuario != '' && pass_usuario !='';
}


/*---------------------------------------------------------------------------------------------------------------
  ---------------------------------------------------------------------------------------------------------------
  MÉTODOS DE BUSCADOR
  ---------------------------------------------------------------------------------------------------------------
  ---------------------------------------------------------------------------------------------------------------*/
function hacerBusqueda()
{
    var text_busqueda = $.trim($('#txt_campo_busqueda').val());
    var combo_tipo_busqueda = $('#combo_elemento_busqueda').val()
    
    if(text_busqueda == ''){
        if(combo_tipo_busqueda == 1){            
            $("#resultado_busqueda").load(globalUrl+"/gestion/consultas/consultas_clientes.php",{consulta: "traer_todos"}); 
        }
        else{
            if(combo_tipo_busqueda == 2){
                $("#resultado_busqueda").load(globalUrl+"/gestion/consultas/consultas_gestiones.php",{consulta: "traer_todos"}); 
            }
            else{
                if(combo_tipo_busqueda == 3){
                    $("#resultado_busqueda").load(globalUrl+"/gestion/consultas/consultas_tramites.php",{consulta: "traer_todos"}); 
                }
                else{

                }
            }
        }
    }
    else{
        if(combo_tipo_busqueda == 1){            
            $("#resultado_busqueda").load(globalUrl+"/gestion/consultas/consultas_clientes.php",{consulta: "buscar_por_nombre",text_busqueda:text_busqueda}); 
        }
        else{
            if(combo_tipo_busqueda == 2){
                $("#resultado_busqueda").load(globalUrl+"/gestion/consultas/consultas_gestiones.php",{consulta: "buscar_por_descripcion",text_busqueda:text_busqueda}); 
            }
            else{
                if(combo_tipo_busqueda == 3){
                    $("#resultado_busqueda").load(globalUrl+"/gestion/consultas/consultas_tramites.php",{consulta: "buscar_por_descripcion",text_busqueda:text_busqueda}); 
                }
                else{

                }
            }
        }
    }
}