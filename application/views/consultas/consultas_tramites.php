<?php

$consulta = $_POST['consulta'];

switch($consulta){
    case "traer_todos":        
        echo crearListaTramites(traerTodos());
        break;
    
    case "traer_tipos_tramite":
        $id_tipo_gestion = cargarUnValor('id_tipo_gestion');   
        $listaTiposTramites = Fachada::getInstancia()->getTiposTramiteByTipoGestion($id_tipo_gestion);
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
                                        'fecha_fin'=>$un_tramite_array['fecha_fin'],
                                        'estado'=>$un_tramite_array['estado'],
                                        'id_tipo_tramite'=>$un_tramite_array['id_tipo_tramite'],
                                        'id_gestion'=>$un_tramite_array['id_gestion'],
                                        'documento'=>$un_tramite_array['documento'],
                                    )
                               );
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
        $un_tramite = traerPorId($id_tramite);
        if($un_tramite != false){
            $array_tramite = $un_tramite->convertirArray();            
            echo json_encode($array_tramite);
        }
        else{
            return -1;
        }                
        break; 
    
    case "matchear_por_id":
        $id_tramite = cargarUnValor('id_tramite'); 
        $un_tramite = traerTramiteElegido($id_tramite);        
        if($un_tramite != false){
            $array_tramite = $un_tramite->convertirArray();
            $array_tramite['plantilla'] = traerPlantillaTramite($id_tramite);
            echo json_encode($array_tramite);
        }
        else{
            return -1;
        }
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
       break;

   
   case "agregar_adjunto_al_tramite":
       $id_tramite = cargarUnValor('id_tramite');
       $posibles_adjuntos = cargarAdjuntos(); 
       $el_adjunto = $posibles_adjuntos[0];
       $id_adjunto = Fachada::getInstancia()->agregarAdjuntoAlTramite($id_tramite,$el_adjunto);
       if($id_adjunto > 0){
            echo json_encode(array('id_adjunto' => $id_adjunto,'tipo' => $el_adjunto['tipo']));
       }
       else{
           echo -1;
       }              
       break;
   
      
    case "eliminar_adjunto_por_id":
       $id_adjunto = cargarUnValor('adjunto_id');
       $retorno = Fachada::getInstancia()->eliminarAdjuntoTramite($id_adjunto);
       echo $retorno;
       break; 
       
   case "eliminar_por_id":
        $id_tramite = cargarUnValor('id_tramite');
        $borrado = Fachada::getInstancia()->eliminarTramite($id_tramite);
        if($borrado){
            echo "<strong style='color:green;'>El cliente de cédula ".$id_tramite." fue exitosamente borrado!";
        }
        else{
            echo "<strong style='color:red;'>El cliente de cédula ".$id_tramite." no se pudo borrar";
        }
        break;
        
   case "traer_busqueda_nombre":
        $text_busqueda = cargarUnValor('text_busqueda');
        $fecha_inicio = cargarUnValor('fecha_inicio');
        $fecha_final = cargarUnValor('fecha_final');
        $tipo_fecha = cargarUnValor('combo_tipo_fecha');
        $lista_filtrada = traerTramitesFiltrados($fecha_inicio,$fecha_final,$tipo_fecha);
        $lista_ret = traerTramitesBuscados($lista_filtrada,strtolower($text_busqueda));
        if(count($lista_ret)>0){
            echo crearListaTramites_buscador($lista_ret);
        }
        else{
            echo '<h3 style="margin:30px;"><strong>No hay resultados para la búsqueda:</strong> <em>'.$text_busqueda.'</em></h3>';
        }        
        break;
        
   case "traer_busqueda":
        $fecha_inicio = cargarUnValor('fecha_inicio');
        $fecha_final = cargarUnValor('fecha_final');
        $tipo_fecha = cargarUnValor('combo_tipo_fecha');
        $lista_filtrada = traerTramitesFiltrados($fecha_inicio,$fecha_final,$tipo_fecha);
        if(count($lista_filtrada)>0){
            echo crearListaTramites_buscador($lista_filtrada);
        }
        else{
            echo '<h3 style="margin:30px;"><strong>No hay resultados para la búsqueda:</strong> <em>fechas</em></h3>';
        }   
        break;
        
   case "gestion_por_tramite":
       $id_gestion = cargarUnValor('id_gestion');
       echo json_encode(getGestionByTramite($id_gestion,true));
       break;
    
    default:        
        break;
}

function traerPorId($id_tramite)
{
    return Fachada::getInstancia()->getTramiteById($id_tramite);
}

function cargarUnValor($variable){
    return $_POST[$variable];
}

function traerTodos(){   
    $todos_los_tramites = Fachada::getInstancia()->getTramites();
    return $todos_los_tramites;
}

function traerTramiteElegido($id_tramite){
    $lista_tramites = traerTodos();
    foreach($lista_tramites as $un_tramite){
        if($un_tramite->getId() == $id_tramite){
            return $un_tramite;
        }
    }
}

function crearListaTramites($lista){
    $retorno= '<table class="table table-hover"><thead><tr><th>#</th><th>Descripcion</th><th>Tipo de Trámite</th><th>Gestion</th><th>Tipo Gestion</th><th>Fecha Inicio</th><th>Fecha Finalizado</th><th>Acciones</th></tr></thead><tbody>';
    //$numero = 0; 
    foreach ($lista as $t)
    {
        $Gestion=getGestionByTramite($t->getIdGestion());
        $retorno .= '<tr><td class="dato_mostrado_tramite">'.$t->getId().'</td><td id="'.$t->getId().'" class="dato_mostrado_tramite">'.$t->getDescripcion().'</td><td class="dato_mostrado_tramite">'.$t->getTipoTramite()->getDescripcion().'</td><td class="dato_mostrado_tramite">'.$Gestion->getDescripcion().'</td><td class="dato_mostrado_tramite">'.$Gestion->getTipoGestion()->getDescripcion().'</td><td class="dato_mostrado_tramite">'.$t->getFechaInicio().'</td><td class="dato_mostrado_tramite">'.$t->getFechaFin().'</td><td><p><i title="Modificar" class="btn_ver_tramite fa fa-pencil-square-o fa-2x"></i><i title="Eliminar" class="btn_eliminar_tramite fa fa-ban fa-2x"></i></p></td></tr>';
    }   
    return $retorno;
}

function crearListaTramites_buscador($lista){
    $retorno= '<table class="table table-hover"><thead><tr><th>#</th><th>Descripcion</th><th>Tipo de Trámite</th><th>Gestion</th><th>Tipo Gestion</th><th>Fecha Inicio</th><th>Fecha Finalizado</th><th>Acciones</th></tr></thead><tbody>';
    //$numero = 0; 
    foreach ($lista as $t)
    {
        $Gestion=getGestionByTramite($t->getIdGestion());
        $retorno .= '<tr><td class="dato_mostrado_tramite_buscador">'.$t->getId().'</td><td id="'.$t->getId().'" class="dato_mostrado_tramite_buscador">'.$t->getDescripcion().'</td><td class="dato_mostrado_tramite_buscador">'.$t->getTipoTramite()->getDescripcion().'</td><td class="dato_mostrado_tramite_buscador">'.$Gestion->getDescripcion().'</td><td class="dato_mostrado_tramite_buscador">'.$Gestion->getTipoGestion()->getDescripcion().'</td><td class="dato_mostrado_tramite_buscador">'.$t->getFechaInicio().'</td><td class="dato_mostrado_tramite_buscador">'.$t->getFechaFin().'</td><td><p><i title="Modificar" class="btn_ver_tramite_buscador fa fa-pencil-square-o fa-2x"></i><i title="Eliminar" class="btn_eliminar_tramite_buscador fa fa-ban fa-2x"></i></p></td></tr>';
    }   
    return $retorno;
}

function getGestionByTramite($id_gestion,$array=false)
{
    $Gestion = Fachada::getInstancia()->getGestionById($id_gestion);
    if($array)
        return $Gestion->convertirArray();
    return $Gestion;
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
    $paramsCliente['estado']=$_POST['estado'];
    
    $paramsCliente['id_gestion']=intval($_POST['id_gestion']);
    
    $a= str_replace("/", "-", $_POST['fecha_inicio']);
    $paramsCliente['fecha_inicio'] = DateTime::createFromFormat('d-m-Y', $a)->format('Y-m-d');
    if($_POST['estado'] == 1){ 
        if($_POST['fecha_fin'] != -1){
            $b= str_replace("/", "-", $_POST['fecha_fin']);
            $paramsCliente['fecha_fin'] = DateTime::createFromFormat('d-m-Y', $b)->format('Y-m-d');
        }
        else{
            $paramsCliente['fecha_fin'] = date('Y-m-d');
        }
    }
    else{
        $paramsCliente['fecha_fin'] = null;
    }
    return $paramsCliente;
}

function crearSelectTiposTramites($lista){
    $retorno = '';
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

function traerPlantillaTramiteO($el_tramite){

    return $el_tramite->getDocumento();

}
function traerPlantillaTramite($id_tramite){
    $el_tramite = traerTramiteElegido($id_tramite);
    return $el_tramite->getDocumento();
}

function traerTipoTramitePorId($id_tt,$id_tipo_gestion){
    $todos_los_tipo_tramtie = Fachada::getInstancia()->getTiposTramiteByTipoGestion($id_tipo_gestion);;
    //var_dump($todos_los_tipo_tramtie); die();
    foreach($todos_los_tipo_tramtie as $un_tt){
        if($un_tt->getIdTiposTramite() == $id_tt){
            return $un_tt;
        }
    }
}

function cargarAdjuntos(){
    if(isset($_SESSION['adjunto'])){        
        return $arrayDatosAdjuntos = $_SESSION['adjunto'];
    }
    else{
        return -1;
    }
}

function traerTramitesPorGestion($id_gestion){
    $lista_retorno = array();
    $lista_tramites = traerTodos();
    foreach($lista_tramites as $un_tramite){
        if($un_tramite->getIdGestion() == $id_gestion){
            array_push($lista_retorno,$un_tramite);
        }
    }
    return $lista_retorno;
}

function traerTramitesBuscados($lista_tramites,$text_busqueda){
    $retorno = array();
    foreach($lista_tramites as $un_tramite){
        if(strpos( strtolower($un_tramite->getDescripcion()), $text_busqueda ) !== false){
            array_push($retorno, $un_tramite);
        }
    }
    return $retorno;
}



function traerTramitesFiltrados($fecha_inicio,$fecha_final,$tipo_busqueda){
    $retorno = array();
    $lista_tramitess = traerTodos();
    foreach($lista_tramitess as $un_tramite){
        if($fecha_inicio != -1 && $fecha_final != -1){
            if(compararFechasPorTipoBusqueda($un_tramite,$fecha_inicio,$fecha_final,$tipo_busqueda)){
                    array_push($retorno, $un_tramite);
             }    
        }        
        else{
            if($fecha_inicio != -1){
                if(compararFechasPorTipoBusqueda_sin_fecha_fin($un_tramite,$fecha_inicio,$tipo_busqueda)){
                        array_push($retorno, $un_tramite);
                 }    
            }        
            else{
                if($fecha_final != -1){
                    if(compararFechasPorTipoBusqueda_sin_fecha_inicio($un_tramite,$fecha_fin,$tipo_busqueda)){
                            array_push($retorno, $un_tramite);
                     } 
                }        
                else{
                    array_push($retorno, $un_tramite);
                }
            }
        }
    }
    return $retorno;
}

function primeraFechaEsMayorOIgual($primera_fecha,$segunda_fecha){    
    if($primera_fecha == null || $segunda_fecha == null){
        return false;
    }
    return compararFechas($primera_fecha,$segunda_fecha)>=0;
}

function compararFechasPorTipoBusqueda($un_tramite,$fecha_inicio,$fecha_final,$tipo_busqueda){    
    if($tipo_busqueda == 1){
        return primeraFechaEsMayorOIgual($un_tramite->getFechaInicio(),$fecha_inicio) && primeraFechaEsMayorOIgual($fecha_final,$un_tramite->getFechaInicio());
    }
    if($tipo_busqueda == 2){
        return primeraFechaEsMayorOIgual($un_tramite->getFechaFin(),$fecha_inicio) && primeraFechaEsMayorOIgual($fecha_final,$un_tramite->getFechaFin());
    }
    if($tipo_busqueda == 3){
        return primeraFechaEsMayorOIgual($un_tramite->getFechaInicio(),$fecha_inicio) && primeraFechaEsMayorOIgual($fecha_final,$un_tramite->getFechaFin());
    }
    return false;
}

function compararFechasPorTipoBusqueda_sin_fecha_fin($un_tramite,$fecha_inicio,$tipo_busqueda){
    if($tipo_busqueda == 1){
        return primeraFechaEsMayorOIgual($un_tramite->getFechaInicio(),$fecha_inicio);
    }
    if($tipo_busqueda == 2){
        return primeraFechaEsMayorOIgual($un_tramite->getFechaFin(),$fecha_inicio);
    }
    if($tipo_busqueda == 3){
        return primeraFechaEsMayorOIgual($un_tramite->getFechaInicio(),$fecha_inicio) || primeraFechaEsMayorOIgual($un_tramite->getFechaFin(),$fecha_inicio);
    }
    return false;
}

function compararFechasPorTipoBusqueda_sin_fecha_inicio($un_tramite,$fecha_fin,$tipo_busqueda){
    if($tipo_busqueda == 1){
        return primeraFechaEsMayorOIgual($fecha_fin,$un_tramite->getFechaInicio());
    }
    if($tipo_busqueda == 2){
        return primeraFechaEsMayorOIgual($fecha_fin,$un_tramite->getFechaFin());
    }
    if($tipo_busqueda == 3){
        return primeraFechaEsMayorOIgual($fecha_fin,$un_tramite->getFechaInicio()) || primeraFechaEsMayorOIgual($fecha_fin,$un_tramite->getFechaFin());
    }
    return false;
}

function compararFechas($primera, $segunda)
{
  $valoresPrimera = explode ("/", $primera);   
  $valoresSegunda = explode ("/", $segunda); 

  $diaPrimera    = $valoresPrimera[0];  
  $mesPrimera  = $valoresPrimera[1];  
  $anyoPrimera   = $valoresPrimera[2]; 

  $diaSegunda   = $valoresSegunda[0];  
  $mesSegunda = $valoresSegunda[1];  
  $anyoSegunda  = $valoresSegunda[2];

  $diasPrimeraJuliano = gregoriantojd($mesPrimera, $diaPrimera, $anyoPrimera);  
  $diasSegundaJuliano = gregoriantojd($mesSegunda, $diaSegunda, $anyoSegunda);     

  if(!checkdate($mesPrimera, $diaPrimera, $anyoPrimera)){
    // "La fecha ".$primera." no es v&aacute;lida";
    return 0;
  }elseif(!checkdate($mesSegunda, $diaSegunda, $anyoSegunda)){
    // "La fecha ".$segunda." no es v&aacute;lida";
    return 0;
  }else{
    return  $diasPrimeraJuliano - $diasSegundaJuliano;
  } 

}

?>
