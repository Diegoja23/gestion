$(document).ready(iniEventos);

function iniEventos() {
    $("#div_listado_cliente").load("http://localhost/gestion/consultas/consultas_clientes.php",{consulta: "traer_todos"}); 
}

$(document).on("click","#btn_agregar_cliente",agregarCliente);
$(document).on("click","#guardar_cliente",guardarCliente);
$(document).on("click","#btn_guardar",guardarCliente);


function agregarCliente(){
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

function guardarCliente(){
    var nombre_cli = $.trim($("#txt_nombre_cliente").val());
    var apellido_cli = $.trim($("#txt_apellido_cliente").val());
    var ci_cli = $.trim($("#txt_ci_cliente").val());
    var email_cli = $.trim($("#txt_email_cliente").val());
    var telefono_cli = $.trim($("#txt_telefono_cliente").val());
    var direccion_cli = $.trim($("#txt_direccion_cliente").val());
    var ci_escaneada_cli = $.trim($("#txt_ci_cliente").val()); 

    $("#retorno_ajax").load("http://localhost/gestion/consultas/consultas_clientes.php",{consulta: "agregar_cliente",nombre: nombre_cli, apellido: apellido_cli, ci: ci_cli, email: email_cli, telefono: telefono_cli, direccion: direccion_cli, ci_escaneada: ci_escaneada_cli});
}
//$( document ).on( "change",".elegir_familia", cambiarElemento );
