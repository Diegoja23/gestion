//var fileExtension = "";
var globalUrl = "http://"+document.domain;
var plantilla;
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
                    $("#div_listado_tramite").load(globalUrl+"/gestion/consultas/consultas_tramites.php",{consulta: "traer_todos"});
                    //$("#div_listado_cliente").load(globalUrl+"/gestion/consultas/consultas_clientes.php",{consulta: "traer_todos"});
                    $( ".datepicker" ).datepicker();  
                }    
                //agregarDivDatosTramite();
            }
        }
    }

}

/*asignar eventos CLIENTES*/
$(document).on("click","#btn_agregar_cliente",agregarDivDatosCliente);
$(document).on("click","#btn_mostrar_lista_clientes",agregarDivListaClientes);
$(document).on("click","#btn_guardar",guardarCliente);
$(document).on("click",".dato_mostrado",traerClienteElegido);
$(document).on("click",".btn_eliminar",eliminarClienteElegido);
$(document).on("click","#btn_agregar_form_subir_ci",mostrarFormularioSubirCI);
$(document).on("click",".subir_archivo",subirElArchivo);
$(document).on("change",":file",cambioElFile);

/*asignar eventos TRÁMITES*/
$(document).on("click","#btn_agregar_tramite",agregarDivDatosTramite);
$(document).on("click","#btn_mostrar_lista_tramites",agregarDivListaTramite);
$(document).on("click",".dato_mostrado_tramite",traerTramiteElegido);
$(document).on("click","#btn_guardar_tramite",guardarTramite);
$(document).on("click","#btn_finalizar_tramite",finalizarTramite);
$(document).on("click","#btn_agregar_adjunto",visibilidadFormularioSubirAdjunto);
$(document).on("click","#btn_mostrar_dialog_plantilla",mostrarDialogPlantilla);
$(document).on("change","#combo_tipo_tramite",cambioTipoTramite);
$(document).on("click",".subir_archivo_tramite",subirElArchivo_tramite);


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

function agregarDivListaClientes(){
    $("#div_listado_cliente").load(globalUrl+"/gestion/consultas/consultas_clientes.php",{consulta: "traer_todos"});
    $("#div_formulario_cliente").fadeOut(1500);
    $("#btn_mostrar_lista_clientes").fadeOut(1500);
    $("#btn_agregar_cliente").fadeIn(1500);
    $("#div_listado_cliente").fadeIn(1500);
    //$("#btn_agregar_cliente").html('Agregar <i class="fa fa-list"></i>');
    cargarFormularioCliente(-1);
}

function listar(){
    return $.isNumeric(($("#span_id_gestion").text()));
}

function guardarTramite(){
    var vdescripcion = $("#txt_descripcion_tramite").val();
    var vtipo_tramite = $("#combo_tipo_tramite option:selected").val();
    var vfecha_inicio = $("#txt_fecha_inicio").val();
    var vid_gestion = $.trim($("#span_id_gestion").text());
    var vid_tipo_gestion = $.trim($("#span_id_tipo_gestion").text());
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

function subirElArchivo_tramite(){
    
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
                            message = "<img src='data:image/jpeg;base64,"+data;+"' width='300' height='200' alt='embedded folder icon'>";
                            retornoSubirArchivo(message);			    
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
    var documento = $($(this).parent().children()[2]).text();
    $.post(globalUrl+"/gestion/consultas/consultas_clientes.php", {consulta: "traer_por_ci",ci: documento})
            .done(function(data) {            
                agregarDivDatosCliente();
                var un_cliente = jQuery.parseJSON(data);
                cargarFormularioCliente(un_cliente);
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

function cargarFormularioCliente(un_cliente){
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



/*---------------------------------------------------------------------------------------------------------------
  ---------------------------------------------------------------------------------------------------------------
  MÉTODOS DE TRÁMITES
  ---------------------------------------------------------------------------------------------------------------
  ---------------------------------------------------------------------------------------------------------------*/
function agregarDivDatosTramite(){
    //if($("#div_formulario_tramite").css("display") == "none"){      
    
    $("#btn_agregar_tramite").fadeOut(1500);
    $("#div_listado_tramite").fadeOut(1500);
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

function agregarDivListaTramite(){
    $("#btn_mostrar_lista_tramites").fadeOut(1500);
    
    $("#div_listado_tramite").load(globalUrl+"/gestion/consultas/consultas_tramites.php",{consulta: "traer_todos"});
    $("#div_formulario_tramite").fadeOut(1500);
    $("#btn_guardar_tramite").fadeOut(1500);    
    $("#div_listado_tramite").fadeIn(1500);
    $("#btn_agregar_tramite").fadeIn(1500);
    //$("#btn_agregar_tramite").text('Agregar <i class="fa fa-list"></i>');
}

function traerTramiteElegido(){
    var vid_tramite = $(this).parent().children()[1].id;
    $.post(globalUrl+"/gestion/consultas/consultas_tramites.php", {consulta: "traer_por_id",id_tramite: vid_tramite})
            .done(function(data) {            
                agregarDivDatosTramite();
                var un_tramite = jQuery.parseJSON(data);
                cargarFormularioTramite(un_tramite);
                //$('#div_ci_cliente').append(data);                
        }, "json");
        //$("input").prop('disable', true);
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
        $("#txt_descripcion_tramite").val(un_tramite.descripcion);
        $("#combo_tipo_tramite option:selected").val(un_tramite.id_tipo_tramite);
        $("#txt_fecha_inicio").val(un_tramite.fecha_inicio);
        if(un_tramite.fecha_fin != null){
            $(".fecha-fin").fadeIn(1500);
            $(".fecha-fin").val(un_tramite.fecha_fin);
        }
        if(un_tramite.estado == 1){
            $("#btn_finalizar_tramite").text("Re-abrir");
        }
        $("#span_id_gestion").text(un_tramite.id_gestion);
        $("#span_id_tipo_gestion").text(un_tramite.id_tipo_gestion);
        //$("#span_id_tramite").text(un_tramite.id_tramite);

        //$('#div_ci_cliente').html('<iframe id="iframe_ci_cliente" src="http://localhost/gestion/consultas/mostrar_archivo.php?mime=' + un_cliente.adjunto_tipo + '&id=' + un_cliente.adjunto_id + '&from=dato_complementario"></iframe>');
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

function cambioTipoTramite(){
    var tipo_tramite = $("#combo_tipo_tramite option:selected").text();
    //$("#dialog_plantilla").attr("title",tipo_tramite);
    $( "#dialog_plantilla" ).dialog( "option", "title", tipo_tramite );
    //alert(tipo_tramite);
}

function mostrarDialogPlantilla(){
    var vid_tipo_tramite = $("#combo_tipo_tramite option:selected").val();
    
    //$("#dialog_plantilla").load(globalUrl+"/gestion/consultas/consultas_tramites.php",{consulta:"get_plantilla_por_id_tipo_tramite", id_tipo_tramite:vid_tipo_tramite});
    
    $.post(globalUrl+"/gestion/consultas/consultas_tramites.php",{consulta:"get_plantilla_por_id_tipo_tramite", id_tipo_tramite:vid_tipo_tramite})
            .done(function(data) {
        plantilla = data;
        $("#dialog_plantilla").html(data);
            });
    
    $("#dialog_plantilla").dialog({width: 800,modal: true,
    buttons: {
                DelUser:{ 
                    class: 'leftButton',
                    text: 'Guardar',
                    click : function (){
                        var planilla_llena = extraerDatosPlanilla();
                        alert('delete here');
                        alert(plantilla);
                    }
                },
                Cerrar: function () {
                    $(this).dialog("close");
                }
            }
        });
}

function extraerDatosPlanilla(){
    
}