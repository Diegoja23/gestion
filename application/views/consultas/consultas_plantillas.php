<?php

$consulta = $_POST['consulta'];


//if(!defined(TIPOS_TRAMITE_BY_GESTION)) define('TIPOS_TRAMITE_BY_GESTION', array());

//$allTiposTramiteByGestion = array();
/*
if(!isset($_GLOBALS['allTiposTramite']))
    $_GLOBALS['allTiposTramite'] = array();
  */  
switch($consulta){
    case "traer_todos":
        echo crearListaPlantillas(traerTodos());
        break;
    
    /*case "traer_tipos_gestion":
        $listaTiposGestion = Fachada::getInstancia()->getTiposGestion();
        echo crearSelectTiposGestion($listaTiposGestion);
        break;*/ 
    
    case "traer_tipos_tramite":
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
        break;
        
    case "matchear_por_id":
        $id_tipo_tramite = cargarUnValor('id_tipo_tramite'); 
        $un_tipo_tramite = traerTipoTramiteElegido($id_tipo_tramite);
        //$un_tramite = seleccionarPorID($id_tramite);
        if($un_tipo_tramite != false){
            $array_tramite = $un_tipo_tramite->convertirArray();            
            echo json_encode($array_tramite);
        }
        else{
            return -1;
        }
        //$un_tramite = Fachada::getInstancia()->getTramiteByID($id_tramite);
        //echo json_encode($un_tramite->convertirArray());
        break;
    
   case "get_plantilla_por_id_tipo_tramite":
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
        break;
        
   case "eliminar_por_id":
        $id_tipo_tramite = cargarUnValor('id_tipo_tramite');
        //este llamado a la función ya está pronto, solo hay que descomentarlo cuando esté lista.
        //$borrado = Fachada::getInstancia()->eliminarByID_tipo_tramite($id_tipo_tramite);
       $borrado = true;
        if($borrado){
            echo "<strong style='color:green;'>El cliente de cédula ".$id_tipo_tramite." fue exitosamente borrado!";
        }
        else{
            echo "<strong style='color:red;'>El cliente de cédula ".$id_tipo_tramite." no se pudo borrar";
        }
        break;
    
    default:        
        break;
}

function cargarUnValor($variable){
    return $_POST[$variable];
}

function traerTodos(){   
    $listaTiposTramites=array();
    $listaTiposGestion = Fachada::getInstancia()->getTiposGestion();
    foreach ($listaTiposGestion as $tg) 
    {        
        //$retorno .= '<option value="'.$tg->getIdTiposGestion().'">'.$tg->getDescripcion().'</option>';
        $listaTiposTramites = array_merge($listaTiposTramites, Fachada::getInstancia()->getTiposTramiteByGestion($tg->getIdTiposGestion()));
        //$listaTiposTramites = Fachada::getInstancia()->getTiposTramiteByGestion($tg->getIdTiposGestion());
    }
    return $listaTiposTramites;
}

function seleccionarPorID($id_tramite)
{
    return Fachada::getInstancia()->getTramiteById($id_tramite);
}

function cargarValoresTipoTramite(){
    $paramsCliente=array();
    if(isset($_POST['id_tipo_tramite'])){
        $paramsCliente['id_tipo_tramite']=intval($_POST['id_tipo_tramite']);
    }
    $paramsCliente['descripcion']=$_POST['descripcion'];
    $paramsCliente['id_tipos_gestion']= $_POST['tipo_gestion'];
    $paramsCliente['plantilla']=$_POST['plantilla'];

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

function traerPlantillaDelTipoTraite($id_tt,$id_tipo_gestion){
    $elTipoTramite = traerTipoTramitePorId($id_tt,$id_tipo_gestion);
    //$textarea = '<textarea id="editor1" name="editor1">'.$elTipoTramite->getPlantilla().'</textarea>';
    //$textarea .= '<script type="text/javascript">CKEDITOR.replace( "editor1" );</script>';
    //return $textarea;
    return $elTipoTramite->getPlantilla();
}

function traerPlantillaTramite($id_tramite){

    $el_tramite = traerTramiteElegido($id_tramite);
    /*$textarea = '<textarea id="editor1" name="editor1">'.$el_tramite->getDocumento().'</textarea>';
    return $textarea .= '<script type="text/javascript">CKEDITOR.replace( "editor1" );</script>';*/
    return $el_tramite->getDocumento();
/*
    $el_tramite = traerTramiteElegido($id_tramite);
    //var_dump($el_tramite);    
    $textarea = '<textarea id="editor1" name="editor1">'.$el_tramite->getDocumento().'</textarea>';
    $textarea .= '<script type="text/javascript">CKEDITOR.replace( "editor1" );</script>';
    return $textarea;
    /*return '<h2>Boleto de reserva</h2><textarea id="editor1" name="editor1">&lt;p&gt;Initial value.&lt;/p&gt;</textarea>
<p>Este es un documento de boleto de reserva. [placeholder=Nombre del comprador||id=1] Sigue el doc, etc.
La otra parte del documento es [placeholder=Nombre del vendedor||id=2] que además bla bla bla.</p>';*/

}

function traerTipoTramitePorId($id_tt,$id_tipo_gestion){
    $todos_los_tipo_tramtie = Fachada::getInstancia()->getTiposTramiteByGestion($id_tipo_gestion);;
    //var_dump($todos_los_tipo_tramtie); die();
    foreach($todos_los_tipo_tramtie as $un_tt){
        if($un_tt->getIdTiposTramite() == $id_tt){
            return $un_tt;
        }
    }
}


/*nuevos métodos*/

/*function crearSelectTiposGestion($lista){
    $retorno = '';
    foreach ($lista as $tg) 
    {        
        $retorno .= '<option value="'.$tg->getIdTiposGestion().'">'.$tg->getDescripcion().'</option>';
    }
    return $retorno;
}*/

function crearListaPlantillas($lista){
    $retorno= '<table class="table table-hover"><thead><tr><th>#</th><th>Descripción</th><th>Tipo de Gestión</th><th>Plantilla</th><th>Acciones</th></tr></thead><tbody>';
    $numero = 0; 
    foreach ($lista as $t)
    {
        $tipo_gestion = new TipoGestion(array('id_tipos_gestion' => $t->getIdTipoGestion()));
        //$tipo_gestion->setIdTiposGestion();
        //$tipo_gestion->getById();
        $retorno .= '<tr><td class="dato_mostrado_tipo_tramite">'.$t->getIdTiposTramite().'</td><td id="'.$t->getIdTiposTramite().'" class="dato_mostrado_tipo_tramite">'.$t->getDescripcion().'</td><td class="dato_mostrado_tipo_tramite">'.$tipo_gestion->getDescripcion().'</td><td class="dato_mostrado_tipo_tramite">'.'plantilla'.'</td><td><p><i class="btn_ver_tipo_tramite fa fa-pencil-square-o fa-2x"></i><i class="btn_eliminar_tipo_tramite fa fa-ban fa-2x"></i></p></td></tr>';
    }   

    return $retorno;
    
}

function traerTipoTramiteElegido($id_tipo_tramite){
    $lista_tipos_tramites = traerTodos();
    foreach($lista_tipos_tramites as $un_tipo_tramite){
        if($un_tipo_tramite->getIdTiposTramite() == $id_tipo_tramite){
            return $un_tipo_tramite;
        }
    }
}

?>
