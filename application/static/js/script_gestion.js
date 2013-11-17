$(document).ready(iniEventos);

function iniEventos() {
    $("#div_listado_cliente").load("http://localhost/gestion/consultas/consultas_clientes.php",{consulta: "traer_todos"}); 
}

$(document).on("click","#agregar_cliente",agregarCliente);
$(document).on("click","#guardar_cliente",guardarCliente);

function agregarCliente(){
    if($("#div_formulario_cliente").css("display") == "none"){ 
        $("#div_listado_cliente").fadeOut(1500);
        $("#div_formulario_cliente").fadeIn(1500);
   
    }
    else{
        $("#div_formulario_cliente").fadeOut(1500);
        $("#div_listado_cliente").fadeIn(1500);
    }
}

function guardarCliente(){
    $("#div_formulario_cliente").load("http://localhost/gestion/consultas/consultas_clientes.php",{consulta: "agregar_cliente"});
}
//$( document ).on( "change",".elegir_familia", cambiarElemento );
