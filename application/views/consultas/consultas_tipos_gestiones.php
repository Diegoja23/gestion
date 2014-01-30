<?php

$consulta = $_POST['consulta'];


//if(!defined(TIPOS_TRAMITE_BY_GESTION)) define('TIPOS_TRAMITE_BY_GESTION', array());

//$allTiposTramiteByGestion = array();
/*
if(!isset($_GLOBALS['allTiposTramite']))
    $_GLOBALS['allTiposTramite'] = array();
  */  
switch($consulta){   
    case "traer_tipos_gestion":
        $listaTiposGestion = traerTodos();
        //echo crearSelectTiposGestion($listaTiposGestion);
        echo json_encode(convertirArrayLista($listaTiposGestion));
        break; 
        
    case "matchear_por_id":
        $id_tipo_gestion = cargarUnValor('id_tipo_gestion'); 
        $un_tipo_gestion = traerTipoGestionElegido($id_tipo_gestion);
        $lista_tipos_tramite = Fachada::getInstancia()->getTiposTramiteByTipoGestion($id_tipo_gestion);
        //$un_tramite = seleccionarPorID($id_tramite);
        $lista_tipos_tramite_array = convertirLaListaTTEnArray($lista_tipos_tramite);
        if($un_tipo_gestion != false){
            $array_tipo_gestion = $un_tipo_gestion->convertirArray();
            $array_tipo_gestion['tipos_tramites'] = $lista_tipos_tramite_array;
            echo json_encode($array_tipo_gestion);
        }
        else{
            return -1;
        }
        //$un_tramite = Fachada::getInstancia()->getTramiteByID($id_tramite);
        //echo json_encode($un_tramite->convertirArray());
        break;
   
   case "agregar_tipo_gestion":
        $un_TG_array = cargarValoresTipoGestion();                
        $retorno = Fachada::getInstancia()->agregarTipoGestion($un_TG_array);        
        if($retorno) echo $retorno; else echo 0;                 
        break;

  case "modificar_tipo_gestion":        
        $un_TG_array = cargarValoresTipoGestion(); 
        $un_tipo_gestion = new TipoGestion(array
                                    (
                                        'id_tipos_gestion'=>$un_TG_array['id_tipo_gestion'],
                                        'descripcion'=>$un_TG_array['descripcion']                                       
                                    )
                               );
                             //  var_dump($un_tipo_gestion);die();
        $retorno = Fachada::getInstancia()->modificarTipoGestion($un_tipo_gestion);
        if($retorno){
            echo 1;
        }
        else{
            echo 0;
        }
        break;
        
   case "eliminar_por_id":
        $id_tipo_gestion = cargarUnValor('id_tipo_gestion');
       $borrado = Fachada::getInstancia()->eliminarTipoGestion($id_tipo_gestion);
        if($borrado){
            echo "<strong style='color:green;'>El tipo de gestión número ".$id_tipo_gestion." fue exitosamente borrado!";
        }
        else{
            echo "<strong style='color:red;'>El típo de gestión número ".$id_tipo_gestion." no se pudo borrar";
        }
        break;
    
    default:        
        break;
}

function cargarUnValor($variable){
    return $_POST[$variable];
}

function traerTodos(){   
    return Fachada::getInstancia()->getTiposGestion();
}

/*function seleccionarPorID($id_tramite)
{
    return Fachada::getInstancia()->getTramiteById($id_tramite);
}*/

function cargarValoresTipoGestion()
{
    $paramsTG=array();
    if(isset($_POST['id_tipo_gestion'])){
        $paramsTG['id_tipo_gestion']=intval($_POST['id_tipo_gestion']);
    }
    $paramsTG['descripcion']=$_POST['descripcion'];    
    return $paramsTG;
}



function crearSelectTiposGestion($lista){
    $retorno = '';
    foreach ($lista as $tg) 
    {        
        $retorno .= '<option value="'.$tg->getIdTiposGestion().'">'.$tg->getDescripcion().'</option>';
    }
    return $retorno;
}


function traerTipoGestionElegido($id_tipo_gestion){
    $lista_tipos_gestion = traerTodos();
    foreach($lista_tipos_gestion as $un_tipo_gestion){
        if($un_tipo_gestion->getIdTiposGestion() == $id_tipo_gestion){
            return $un_tipo_gestion;
        }
    }
    return false;
}

function convertirArrayLista($listaTiposGestion){
     $lista_array = array();
    foreach($listaTiposGestion as $un_tipo_gestion){
        array_push($lista_array, $un_tipo_gestion->convertirArray());
    }
    return $lista_array;
}

function convertirLaListaTTEnArray($lista_tipos_tramite){
    $lista = array();    
    if(count($lista_tipos_tramite)>0){
        foreach($lista_tipos_tramite as $un_tipo_tramite){
            array_push($lista, $un_tipo_tramite->convertirArray());
        }
    }
    return $lista;
}

?>
