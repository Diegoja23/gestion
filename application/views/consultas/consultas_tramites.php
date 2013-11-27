<?php

$consulta = $_POST['consulta'];
    
switch($consulta){
    case "traer_todos":
        //echo crearListaClientes(traerTodos());
        break;
    
    case "traer_tipos_tramite":
        $id_tipo_gestion = cargarUnValor('id_tipo_gestion');          
        //echo Fachada::getInstancia()->getTiposTramiteByGestion($id_tipo_gestion);
        echo crearSelectTiposTramites(Fachada::getInstancia()->getTiposTramiteByGestion($id_tipo_gestion));
        break;

    case "agregar_cliente": 
        $un_cliente_array = cargarValores();
        $adjunto_array = cargarAdjunto();
        
        if($adjunto_array != -1){
            $retorno = Fachada::getInstancia()->agregarCliente($un_cliente_array,$adjunto_array);
        }
        else{
            $retorno = Fachada::getInstancia()->agregarCliente($un_cliente_array);
        }
        if($retorno){
            /*echo "El cliente ".$un_cliente['nombre']." se ingresó con éxito<br>";*/
            echo 1;
        }
        else{
            /*echo "El cliente ". $un_cliente['nombre']." no pudo ser ingresado. Verifique los datos<br>"; */
            echo 0;
        }
        break;
        
    case "traer_por_ci":
        $ci = cargarUnValor('ci');        
        $un_cliente = Fachada::getInstancia()->getByCI($ci);
        echo json_encode($un_cliente->convertirArray());
        break;
    
   case "subir_foto":
        $file = $_FILES['archivo']['name'];
        echo $file;
        break;   
    
   case "eliminar_por_ci":
        $ci = cargarUnValor('ci');
        $borrado = Fachada::getInstancia()->eliminarByCI($ci);
        if($borrado){
            echo "<strong style='color:green;'>El cliente de cédula ".$ci." fue exitosamente borrado!";
        }
        else{
            echo "<strong style='color:red;'>El cliente de cédula ".$ci." no se pudo borrar";
        }
        break;
    
    default:        
        break;
}

function cargarUnValor($variable){
    return $_POST[$variable];
}

function traerTodos(){
    //$Fachada = $GLOBALS['fachada'];
    $todos_los_clientes = Fachada::getInstancia()->getClientes();
    return $todos_los_clientes;
}

function crearSelectTiposTramites($lista){
    $retorno = '';
    //$numero = 0;    
    foreach ($lista as $tt) 
    {        
        $retorno .= '<option value="'.$tt->getIdTiposTramite().'">'.$tt->getDescripcion().'</option>';
    }
    return $retorno;
}

?>
