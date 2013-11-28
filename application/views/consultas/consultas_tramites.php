<?php

$consulta = $_POST['consulta'];
    
switch($consulta){
    case "traer_todos":
        echo crearListaTramites(traerTodos());
        break;
    
    case "traer_tipos_tramite":
        $id_tipo_gestion = cargarUnValor('id_tipo_gestion');          
        echo crearSelectTiposTramites(Fachada::getInstancia()->getTiposTramiteByGestion($id_tipo_gestion));
        break;

    case "agregar_tramite": 
        $un_tramite_array = cargarValoresTramite();  
        
        $retorno = Fachada::getInstancia()->agregarTramite($un_tramite_array);
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
    $todos_los_tramites = Fachada::getInstancia()->getTramites();
    return $todos_los_tramites;
}

function crearListaTramites($lista){
    $retorno= '<table class="table table-hover"><thead><tr><th>#</th><th>Descripcion</th><th>Tipo de Trámite</th><th>Fecha Inicio</th><th>Fecha Finalizado</th><th>Acciones</th></tr></thead><tbody>';
    $numero = 0; 
    foreach ($lista as $t)
    {        
        $retorno .= '<tr><td class="dato_mostrado">'.++$numero.'</td><td class="dato_mostrado">'.$t->getDescripcion().'</td><td class="dato_mostrado">'.$t->getDescripcion().'</td><td class="dato_mostrado">'.$t->getFechaInicio().'</td><td class="dato_mostrado">'.$t->getFechaFin().'</td><td><p><i class="fa fa-pencil-square-o fa-2x"></i><i class="btn_eliminar fa fa-ban fa-2x"></i></p></td></tr>';
     }   

    return $retorno;
    
}

function cargarValoresTramite(){
    $paramsCliente=array();
    $paramsCliente['descripcion']=$_POST['descripcion'];
    $paramsCliente['id_tipo_tramite']=intval($_POST['id_tipo_tramite']);

    $paramsCliente['estado']=0;
    $paramsCliente['id_gestion']=intval($_POST['id_gestion']);
    
    $a= str_replace("/", "-", $_POST['fecha_inicio']);
    $paramsCliente['fecha_inicio'] = DateTime::createFromFormat('m-d-Y', $a)->format('Y-m-d');

    return $paramsCliente;
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
