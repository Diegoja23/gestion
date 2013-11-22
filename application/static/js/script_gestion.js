$(document).ready(iniEventos);

function iniEventos() {
    $("#div_listado_cliente").load("http://localhost/gestion/consultas/consultas_clientes.php",{consulta: "traer_todos"}); 
}

$(document).on("click","#btn_agregar_cliente",agregarDivDatosCliente);
//$(document).on("click","#guardar_cliente",guardarCliente);
$(document).on("click","#btn_guardar",guardarCliente);
$(document).on("click",".dato_mostrado",traerClienteElegido);
$(document).on("click","#btn_agregar_form_subir_ci",mostrarFormularioSubirCI);

function agregarDivDatosCliente(){
    if($("#div_formulario_cliente").css("display") == "none"){         
        $("#div_listado_cliente").fadeOut(1500);
        $("#div_formulario_cliente").fadeIn(1500);
        $("#btn_agregar_cliente").text("Mostrar Lista");   
    }
    else{        
        $("#div_listado_cliente").load("http://localhost/gestion/consultas/consultas_clientes.php",{consulta: "traer_todos"});
        $("#div_formulario_cliente").fadeOut(1500);
        $("#div_listado_cliente").fadeIn(1500);
        $("#btn_agregar_cliente").text("Agregar");
    }
}

function mostrarFormularioSubirCI(){
    if($("#div_formulario_subir_ci").css("display") == "none"){ 
        $("#div_formulario_subir_ci").fadeIn(1500);
    }
    else{
        $("#div_formulario_subir_ci").fadeOut(1500);
        $("#input_file_cedula").val("");
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
    var ci_escaneada_cli = $.trim($("#txt_ci_cliente").val()); 
    var valido = validarDatosIngresados(nombre_cli,apellido_cli,ci_cli,email_cli,telefono_cli,direccion_cli);
    if(valido == 1){
        $.post("http://localhost/gestion/consultas/consultas_clientes.php", {consulta: "agregar_cliente",nombre: nombre_cli, apellido: apellido_cli, ci: ci_cli, email: email_cli, telefono: telefono_cli, direccion: direccion_cli, ci_escaneada: ci_escaneada_cli})
            .done(function(data) {
            if(parseInt(data) == 1){
                $("#retorno_ajax").html("<strong style='color:green;'>El cliente "+nombre_cli+" "+apellido_cli+" se ingresó con éxito</strong>");
                cargarFormulario(-1);
            }
            else{
                $("#retorno_ajax").html("<strong style='color:red;'>¡El cliente "+nombre_cli+" "+apellido_cli+" no se pudo ingresar!</strong>");
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
