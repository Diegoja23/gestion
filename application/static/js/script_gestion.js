$(document).ready(iniEventos);

function iniEventos() {
     /*$('#btn_acceso').on('click',validarRegistro);
     $('#btn_crear').on('click',crearCopia);
     $('#btn_agregar_sinonimo').on('click',agregarSinonimo);  
     $('#btn_mostrar_agregar_sinonimo').on('click',mostrarAgregarSinonimo); */
    //alert("asdfasdf");
     
     //cargar();
}

$(document).on("click","#agregar_cliente",agregarCliente);

function agregarCliente(){
    if($("#div_formulario_cliente").css("display") == "none"){
        $("#div_formulario_cliente").css("display","block");
    }
    else{
        $("#div_formulario_cliente").css("display","none");
    }
}
//$( document ).on( "change",".elegir_familia", cambiarElemento );
