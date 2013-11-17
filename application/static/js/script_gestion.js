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
        $("#div_formulario_cliente").fadeIn(1500);
        //$("#div_formulario_cliente").css("display","block");
        $("#div_listado_cliente").fadeOut(1500);
        //$("#div_listado_cliente").css("display","none");        
    }
    else{
        $("#div_formulario_cliente").fadeOut(1500);
        //$("#div_formulario_cliente").css("display","none");
        $("#div_listado_cliente").fadeIn(1500);
        //$("#div_listado_cliente").css("display","block"); 
    }
}
//$( document ).on( "change",".elegir_familia", cambiarElemento );
