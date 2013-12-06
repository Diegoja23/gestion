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
            echo 1;
        }
        else{
            echo 0;
        }
        break;
        
    case "traer_por_id":
        $id_tramite = cargarUnValor('id_tramite'); 
        $lista_tramites = traerTodos();
        $un_tramite = seleccionarPorID($id_tramite);
        if($un_tramite != false){
            echo json_encode($un_tramite->convertirArray());
        }
        else{
            return -1;
        }
        //$un_tramite = Fachada::getInstancia()->getTramiteByID($id_tramite);
        //echo json_encode($un_tramite->convertirArray());
        break;
    
   case "get_plantilla_por_id_tipo_tramite":
       $id_tipo_tramite = cargarUnValor('id_tipo_tramite');
       echo traerPlantillaDelTipoTraite($id_tipo_tramite);
       //$file = $_FILES['archivo']['name'];
        //echo $file;
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
        $retorno .= '<tr><td class="dato_mostrado_tramite">'.++$numero.'</td><td id="'.$t->getId().'" class="dato_mostrado_tramite">'.$t->getDescripcion().'</td><td class="dato_mostrado_tramite">'.$t->getDescripcion().'</td><td class="dato_mostrado_tramite">'.$t->getFechaInicio().'</td><td class="dato_mostrado_tramite">'.$t->getFechaFin().'</td><td><p><i class="fa fa-pencil-square-o fa-2x"></i><i class="btn_eliminar fa fa-ban fa-2x"></i></p></td></tr>';
    }   

    return $retorno;
    
}

function seleccionarPorID($id_tramite)
{
    return Fachada::getInstancia()->getTramiteById($id_tramite);
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

function traerPlantillaDelTipoTraite($id_tt){
    return '<h2>Boleto de reserva</h2>
<p>Este es un documento de boleto de reserva. <input type="text" class="form-control input_plantilla" id="txt_elemento" placeholder="Nombre del comprador"> Sigue el doc, etc.
La otra parte del documento es <input type="text" class="form-control input_plantilla" id="txt_elemento" placeholder="Nombre del vendedor"> que además bla bla bla.</p>';
}

?>
