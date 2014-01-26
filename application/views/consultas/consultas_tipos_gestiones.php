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
    
    /*case "traer_tipos_tramite":
        $id_tipo_gestion = cargarUnValor('id_tipo_gestion');   
        //define('TIPOS_TRAMITE_BY_GESTION', Fachada::getInstancia()->getTiposTramiteByGestion($id_tipo_gestion)); 
        $listaTiposTramites = Fachada::getInstancia()->getTiposTramiteByGestion($id_tipo_gestion);
        echo crearSelectTiposTramites($listaTiposTramites);
        break;

    case "agregar_tipo_tramite": 
        $un_tipo_tramite_array = cargarValoresTipoTramite();         
        $retorno = Fachada::getInstancia()->agregarTipoTramite($un_tipo_tramite_array);
        if($retorno){
            echo 1;
        }
        else{
            echo 0;
        }
        break;
        
    case "modificar_tipo_tramite":        
        $un_tipo_tramite_array = cargarValoresTipoTramite(); 
        //$un_tramite_array['id_tramite']=$_POST['id_tipo_tramite'];
        $tipo_tramite = new TipoTramite(array
                                            (
                                                'id_tipo_tramite'=>$un_tipo_tramite_array['id_tipo_tramite'],
                                                'descripcion'=>$un_tipo_tramite_array['descripcion'],
                                                'id_tipos_gestion'=>$un_tipo_tramite_array['id_tipos_gestion'],
                                                'plantilla'=>$un_tipo_tramite_array['plantilla']
                                            )
                                        );
        $retorno = Fachada::getInstancia()->modificarTipoTramite($tipo_tramite);
        if($retorno){
            echo 1;
        }
        else{
            echo 0;
        }
        break;*/
        
    case "matchear_por_id":
        $id_tipo_gestion = cargarUnValor('id_tipo_gestion'); 
        $un_tipo_gestion = traerTipoGestionElegido($id_tipo_gestion);
        //$un_tramite = seleccionarPorID($id_tramite);
        if($un_tipo_gestion != false){
            $array_tipo_gestion = $un_tipo_gestion->convertirArray();            
            echo json_encode($array_tipo_gestion);
        }
        else{
            return -1;
        }
        //$un_tramite = Fachada::getInstancia()->getTramiteByID($id_tramite);
        //echo json_encode($un_tramite->convertirArray());
        break;
    
   /*case "get_plantilla_por_id_tipo_tramite":
       $id_tipo_tramite = cargarUnValor('id_tipo_tramite');
       $id_tipo_gestion = cargarUnValor('id_tipo_gestion');
       $id_tramite = cargarUnValor('id_tramite');
       if($id_tramite > 0){
           echo traerPlantillaTramite($id_tramite);
       }
       else{
           echo traerPlantillaDelTipoTraite($id_tipo_tramite,$id_tipo_gestion);
       }       
       //$file = $_FILES['archivo']['name'];
        //echo $file;
        break;*/
        
   case "modificar_tipo_gestion":        
        $un_tramite_array = cargarValoresTipoGestion();  
        $un_tramite_array['id_tramite']=$_POST['id_tramite'];
        $Tramite = new Tramite(array
                                    (
                                        'id_tramite'=>$un_tramite_array['id_tramite'],
                                        'descripcion'=>$un_tramite_array['descripcion'],
                                        'fecha_inicio'=>$un_tramite_array['fecha_inicio'],
                                        'fecha_fin'=>$un_tramite_array['fecha_fin'],
                                        'estado'=>$un_tramite_array['estado'],
                                        'id_tipo_tramite'=>$un_tramite_array['id_tipo_tramite'],
                                        'id_gestion'=>$un_tramite_array['id_gestion'],
                                        'documento'=>$un_tramite_array['documento'],
                                    )
                               );
        /*$Tramite->setDescripcion($un_tramite_array['descripcion']);
        $Tramite->setDocumento($un_tramite_array['documento']);*/
        $retorno = Fachada::getInstancia()->modificarTramite($Tramite);
        if($retorno){
            echo 1;
        }
        else{
            echo 0;
        }
        break;
        
   case "eliminar_por_id":
        $id_tipo_gestion = cargarUnValor('id_tipo_gestion');
        //este llamado a la función ya está pronto, solo hay que descomentarlo cuando esté lista.
        //$borrado = Fachada::getInstancia()->eliminarByID_tipo_tramite($id_tipo_tramite);
       $borrado = true;
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

function cargarValoresTipoGestion(){
    $paramsCliente=array();
    if(isset($_POST['id_tipo_tramite'])){
        $paramsCliente['id_tipo_tramite']=intval($_POST['id_tipo_tramite']);
    }
    $paramsCliente['descripcion']=$_POST['descripcion'];
    $paramsCliente['id_tipos_gestion']= $_POST['tipo_gestion'];
    $paramsCliente['plantilla']=$_POST['plantilla'];

    return $paramsCliente;
}

/*function crearSelectTiposTramites($lista){
    $retorno = '';
    //$numero = 0;    
    foreach ($lista as $tt) 
    {        
        $retorno .= '<option value="'.$tt->getIdTiposTramite().'">'.$tt->getDescripcion().'</option>';
    }
    return $retorno;
}

function traerPlantillaDelTipoTraite($id_tt,$id_tipo_gestion){
    $elTipoTramite = traerTipoTramitePorId($id_tt,$id_tipo_gestion);
    //$textarea = '<textarea id="editor1" name="editor1">'.$elTipoTramite->getPlantilla().'</textarea>';
    //$textarea .= '<script type="text/javascript">CKEDITOR.replace( "editor1" );</script>';
    //return $textarea;
    return $elTipoTramite->getPlantilla();
}

function traerPlantillaTramite($id_tramite){

    $el_tramite = traerTramiteElegido($id_tramite);
    return $el_tramite->getDocumento();


}*/

/*function traerTipoGestionPorId($id_tt,$id_tipo_gestion){
    $todos_los_tipo_tramtie = Fachada::getInstancia()->getTiposTramiteByGestion($id_tipo_gestion);;
    //var_dump($todos_los_tipo_tramtie); die();
    foreach($todos_los_tipo_tramtie as $un_tt){
        if($un_tt->getIdTiposTramite() == $id_tt){
            return $un_tt;
        }
    }
}*/


/*nuevos métodos*/

function crearSelectTiposGestion($lista){
    $retorno = '';
    foreach ($lista as $tg) 
    {        
        $retorno .= '<option value="'.$tg->getIdTiposGestion().'">'.$tg->getDescripcion().'</option>';
    }
    return $retorno;
}

/*function crearListaPlantillas($lista){
    $retorno= '<table class="table table-hover"><thead><tr><th>#</th><th>Descripción</th><th>Tipo de Gestión</th><th>Plantilla</th><th>Acciones</th></tr></thead><tbody>';
    $numero = 0; 
    foreach ($lista as $t)
    {        
        $retorno .= '<tr><td class="dato_mostrado_tipo_tramite">'.$t->getIdTiposTramite().'</td><td id="'.$t->getIdTiposTramite().'" class="dato_mostrado_tipo_tramite">'.$t->getDescripcion().'</td><td class="dato_mostrado_tipo_tramite">'.$t->getDescripcion().'</td><td class="dato_mostrado_tipo_tramite">'.'plantilla'.'</td><td><p><i class="btn_ver_tipo_tramite fa fa-pencil-square-o fa-2x"></i><i class="btn_eliminar_tipo_tramite fa fa-ban fa-2x"></i></p></td></tr>';
    }   

    return $retorno;
    
}*/

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

?>
