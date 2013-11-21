$(document).ready(iniEventos);

function iniEventos() {
    $("#div_listado_cliente").load("http://localhost/gestion/consultas/consultas_clientes.php",{consulta: "traer_todos"}); 
}

$(document).on("click","#btn_agregar_cliente",agregarDivDatosCliente);
//$(document).on("click","#guardar_cliente",guardarCliente);
$(document).on("click","#btn_guardar",guardarCliente);
$(document).on("click",".dato_mostrado",traerClienteElegido);

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

function traerClienteElegido(){
    var documento = $(this).parent().children()[2].innerText;
    $.post("http://localhost/gestion/consultas/consultas_clientes.php", {consulta: "traer_por_ci",ci: documento})
            .done(function(data) {
            /*if(parseInt(data) == 1){
                $("#retorno_ajax").html("<strong style='color:green;'>El cliente "+nombre_cli+" "+apellido_cli+" se ingresó con éxito</strong>");
                limpiarFormularioAgregarCliente();
            }
            else{
                $("#retorno_ajax").html("<strong style='color:red;'>¡El cliente "+nombre_cli+" "+apellido_cli+" no se pudo ingresar!</strong>");
            }*/
                //alert(data);
                var valor = desSerializar(data);
                var lolo = $.unserialize(data);
                alert(valor);
                $('#content').append(valor);
        });
    //alert(documento);
}
(function($){
	$.unserialize = function(serializedString){
		var str = decodeURI(serializedString);
		var pairs = str.split('&');
		var obj = {}, p, idx, val;
		for (var i=0, n=pairs.length; i < n; i++) {
			p = pairs[i].split('=');
			idx = p[0];
 
			if (idx.indexOf("[]") == (idx.length - 2)) {
				// Eh um vetor
				var ind = idx.substring(0, idx.length-2)
				if (obj[ind] === undefined) {
					obj[ind] = [];
				}
				obj[ind].push(p[1]);
			}
			else {
				obj[idx] = p[1];
			}
		}
		return obj;
	};
})(jQuery);

function desSerializar (serializedString){
		var str = decodeURI(serializedString);
		var pairs = str.split('&');
		var obj = {}, p, idx, val;
		for (var i=0, n=pairs.length; i < n; i++) {
			p = pairs[i].split('=');
			idx = p[0];
 
			if (idx.indexOf("[]") == (idx.length - 2)) {
				// Eh um vetor
				var ind = idx.substring(0, idx.length-2)
				if (obj[ind] === undefined) {
					obj[ind] = [];
				}
				obj[ind].push(p[1]);
			}
			else {
				obj[idx] = p[1];
			}
		}
		return obj;
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
                limpiarFormularioAgregarCliente();
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

function limpiarFormularioAgregarCliente(){
    $("#txt_nombre_cliente").val("");
    $("#txt_apellido_cliente").val("");
    $("#txt_ci_cliente").val("");
    $("#txt_email_cliente").val("");
    $("#txt_telefono_cliente").val("");
    $("#txt_direccion_cliente").val("");
    $("#txt_ci_cliente").val(""); 
}
