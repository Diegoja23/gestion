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
    
    case "traer_tipos_gestion":
        $listaTiposGestion = Fachada::getInstancia()->getTiposGestion();
        echo crearSelectTiposGestion($listaTiposGestion);
        break; 
    
    case "traer_tipos_tramite":
        $id_tipo_gestion = cargarUnValor('id_tipo_gestion');   
        //define('TIPOS_TRAMITE_BY_GESTION', Fachada::getInstancia()->getTiposTramiteByGestion($id_tipo_gestion)); 
        $listaTiposTramites = Fachada::getInstancia()->getTiposTramiteByGestion($id_tipo_gestion);
        echo crearSelectTiposTramites($listaTiposTramites);
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
        
    case "modificar_tramite":        
        $un_tramite_array = cargarValoresTramite();  
        $un_tramite_array['id_tramite']=$_POST['id_tramite'];
        $Tramite = new Tramite(array
                                    (
                                        'id_tramite'=>$un_tramite_array['id_tramite'],
                                        'descripcion'=>$un_tramite_array['descripcion'],
                                        'fecha_inicio'=>$un_tramite_array['fecha_inicio'],
                                        //'fecha_fin'=>$un_tramite_array['fecha_fin'],
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
        
    case "traer_por_id":
        $id_tramite = cargarUnValor('id_tramite'); 
        $un_tramite = traerTramiteElegido($id_tramite);
        //$un_tramite = seleccionarPorID($id_tramite);
        if($un_tramite != false){
            $array_tramite = $un_tramite->convertirArray();            
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

   
   case "agregar_adjunto_al_tramite":
       $id_tramite = cargarUnValor('id_tramite');
       /*tener en cuenta que cargarAdjuntos esta preparado para poder cargar un array de adjuntos en el caso de que se quieran 
        * subir varios. En este caso hay que llamar a la posición 0 del array porque queremos subir uno sólo. O sea,
        * esta funcion se llama con cada click del botón "Subir adjunto" por lo que, a nivel de UI, no permite subir varios a la vez
        * pero sí está soportado a nivel de dominio.
       */
       $posibles_adjuntos = cargarAdjuntos(); 
       
       /*echo json_encode(array('id_adjunto' => 34,'tipo' => $posibles_adjuntos[0]['tipo']));*/      
       
       $el_adjunto = $posibles_adjuntos[0];
       
       //esto ya está hecho, solo falta todo lo del dominio
       $id_adjunto = Fachada::getInstancia()->agregarAdjuntoAlTramite($id_tramite,$el_adjunto);
       if($id_adjunto > 0){
            echo json_encode(array('id_adjunto' => $id_adjunto,'tipo' => $el_adjunto['tipo']));
       }
       else{
           echo -1;
       }              
       break;
   
   case "modificar_tramite":
       /*$id_adjunto = cargarUnValor('adjunto_id');
       $retorno = Fachada::getInstancia()->eliminarAdjuntoTramite($id_adjunto);
       echo $retorno;*/
       break;
       
       
    case "eliminar_adjunto_por_id":
       $id_adjunto = cargarUnValor('adjunto_id');
       $retorno = Fachada::getInstancia()->eliminarAdjuntoTramite($id_adjunto);
       echo $retorno;
       break; 
       
   case "eliminar_por_id":
        $id_tramite = cargarUnValor('id_tramite');
        //este llamado a la función ya está pronto, solo hay que descomentarlo cuando esté lista.
        //$borrado = Fachada::getInstancia()->eliminarByID_tramite($id_tramite);
       $borrado = true;
        if($borrado){
            echo "<strong style='color:green;'>El cliente de cédula ".$id_tramite." fue exitosamente borrado!";
        }
        else{
            echo "<strong style='color:red;'>El cliente de cédula ".$id_tramite." no se pudo borrar";
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

function cargarValoresTramite(){
    $paramsCliente=array();
    $paramsCliente['descripcion']=$_POST['descripcion'];
    $paramsCliente['id_tipo_tramite']=intval($_POST['id_tipo_tramite']);
    $paramsCliente['documento']= $_POST['plantilla_modificada'];
    $paramsCliente['estado']=0;
    $paramsCliente['id_gestion']=intval($_POST['id_gestion']);
    
    $a= str_replace("/", "-", $_POST['fecha_inicio']);
    $paramsCliente['fecha_inicio'] = DateTime::createFromFormat('d-m-Y', $a)->format('Y-m-d');

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

function crearSelectTiposGestion($lista){
    $retorno = '';
    foreach ($lista as $tg) 
    {        
        $retorno .= '<option value="'.$tg->getIdTiposGestion().'">'.$tg->getDescripcion().'</option>';
    }
    return $retorno;
}

function crearListaPlantillas($lista){
    $retorno= '<table class="table table-hover"><thead><tr><th>#</th><th>Descripción</th><th>Tipo de Gestión</th><th>Plantilla</th><th>Acciones</th></tr></thead><tbody>';
    $numero = 0; 
    foreach ($lista as $t)
    {        
        $retorno .= '<tr><td class="dato_mostrado_tipo_tramite">'.$t->getIdTiposTramite().'</td><td id="'.$t->getIdTiposTramite().'" class="dato_mostrado_tipo_tramite">'.$t->getDescripcion().'</td><td class="dato_mostrado_tipo_tramite">'.$t->getDescripcion().'</td><td class="dato_mostrado_tipo_tramite">'.'plantilla'.'</td><td><p><i class="btn_ver_tipo_tramite fa fa-pencil-square-o fa-2x"></i><i class="btn_eliminar_tipo_tramite fa fa-ban fa-2x"></i></p></td></tr>';
    }   

    return $retorno;
    
}

?>
