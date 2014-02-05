<?php

$consulta = $_POST['consulta'];
    
switch($consulta){
    case "traer_todos":
        echo crearListaGestiones(traerTodos());
        //echo crearSelectTiposTramites($listaTiposTramites);
        break;

    case "agregar_gestion": 
        $paramsGestion = cargarValoresGestion();      

        $lista_id_clientes=$_POST['lista_id_clientes'];
        $lista_id_participantes = (isset($_POST['lista_id_participantes'])) ? $_POST['lista_id_participantes'] : array();        

        $clientes =array();
        $participantes=array();

        foreach($lista_id_clientes as $id_persona)    
            array_push($clientes, new Cliente(array('id_persona' => $id_persona)));     
        foreach($lista_id_participantes as $id_persona)    
            array_push($participantes, new Participante(array('id_persona' => $id_persona)));     

        $grupo = new Grupo(array('descripcion' => "Descripcion de grupo es opcional",
                                 'clientes' => $clientes,
                                 'participantes' => $participantes));

        $agregar = Fachada::getInstancia()->agregarGestion($paramsGestion, $grupo);
        if($agregar) echo $agregar;
        else echo "0";            

    break;
    
    case "modificar_gestion":
        $paramsGestion = cargarValoresGestion();          
        $id_grupo=$_POST['id_grupo'];              
        $lista_id_clientes=$_POST['lista_id_clientes'];
        $lista_id_participantes = (isset($_POST['lista_id_participantes'])) ? $_POST['lista_id_participantes'] : array();     
       
        $clientes =array();
        $participantes=array();
        
        foreach($lista_id_clientes as $id_persona)    
            array_push($clientes, new Cliente(array('id_persona' => $id_persona)));  
        foreach($lista_id_participantes as $id_persona)    
            array_push($participantes, new Participante(array('id_persona' => $id_persona)));     
    
        $grupo = new Grupo(array('id_grupo' => $id_grupo,
                                 'descripcion' => "Descripcion de grupo es opcional",
                                 'clientes' => $clientes,
                                 'participantes' => $participantes));               
    $modificar = Fachada::getInstancia()->modificarGestion($paramsGestion, $grupo);
    if($modificar) echo $modificar;
    else echo "0";                                         
        
    break;
        
    case "matchear_por_id":
        
        $id_gestion = cargarUnValor('id_gestion');        
        $una_gestion = traerGestionPorID($id_gestion);
        //var_dump($una_gestion);die();
        echo json_encode($una_gestion->convertirArray());
        break;
        
    case "traer_por_id":
        $id_gestion = cargarUnValor('id_gestion'); 
        $una_gestion = traerPorId($id_gestion);
        if($una_gestion != false){
            $array_gestion = $una_gestion->convertirArray();                        
            echo json_encode($array_gestion);
        }
        else{
            return -1;
        }         
        break;        
    
   case "traer_tipos_gestion":
        $listaTiposGestion = Fachada::getInstancia()->getTiposGestion();
        echo crearSelectTiposGestion($listaTiposGestion);
        break;   
   
   case "traer_lista_clientes":
        $id_gestion = cargarUnValor('id_gestion'); 
        if($id_gestion > 0){
            $una_gestion = traerGestionPorID($id_gestion);
            $listaClientes = Fachada::getInstancia()->getClientes();
            $lista = crearSelectPersonas($listaClientes,$una_gestion->getGrupo()->getClientes());         
        }
        else{
            $lista_vacia=array();
            $listaClientes = Fachada::getInstancia()->getClientes();
            $lista = crearSelectPersonas($listaClientes,$lista_vacia); 
        }
        echo $lista;
        break; 
    
   case "traer_lista_personas":
        $id_gestion = cargarUnValor('id_gestion'); 
        if($id_gestion > 0){
            $una_gestion = traerGestionPorID($id_gestion);
            $listaParticipantes = Fachada::getInstancia()->getParticipantes();
            $listaClientes = Fachada::getInstancia()->getClientes();
            $lista_total = array_merge($listaParticipantes,$listaClientes);
            $lista_excluidos = array_merge($una_gestion->getGrupo()->getClientes(),$una_gestion->getGrupo()->getParticipantes());
            $lista = crearSelectPersonas($lista_total,$lista_excluidos);
        }
        else{
            $lista_vacia=array();
            $listaParticipantes = Fachada::getInstancia()->getParticipantes();
            $listaClientes = Fachada::getInstancia()->getClientes();
            $lista_total = array_merge($listaParticipantes,$listaClientes);
            $lista = crearSelectPersonas($lista_total,$lista_vacia);
        }
        echo $lista;
        break;
    
   case "traer_busqueda_nombre":
        $text_busqueda = cargarUnValor('text_busqueda');
        $fecha_inicio = cargarUnValor('fecha_inicio');
        $fecha_final = cargarUnValor('fecha_final');
        $tipo_fecha = cargarUnValor('combo_tipo_fecha');
        $lista_filtrada = traerGestionesFiltradas($fecha_inicio,$fecha_final,$tipo_fecha);
        $lista_ret = traerGestionesBuscadas($lista_filtrada,strtolower($text_busqueda));
        if(count($lista_ret)>0){
            echo crearListaGestiones_buscador($lista_ret);
        }
        else{
            echo '<h3 style="margin:30px;"><strong>No hay resultados para la búsqueda:</strong> <em>'.$text_busqueda.'</em></h3>';
        }        
        break;
    
        
    case "traer_busqueda":
        /*$fecha_inicio = $_POST['fecha_inicio'];
        $fecha_final = $_POST['fecha_final'];
        $tipo_fecha = $_POST['combo_tipo_fecha'];*/
        $fecha_inicio = cargarUnValor('fecha_inicio');
        $fecha_final = cargarUnValor('fecha_final');
        $tipo_fecha = cargarUnValor('combo_tipo_fecha');
        $lista_filtrada = traerGestionesFiltradas($fecha_inicio,$fecha_final,$tipo_fecha);
        if(count($lista_filtrada)>0){
            echo crearListaGestiones_buscador($lista_filtrada);
        }
        else{
            echo '<h3 style="margin:30px;"><strong>No hay resultados para la búsqueda:</strong> <em>fechas</em></h3>';
        }   
        break;
        
    case "eliminar_por_id":
        $id_gestion = cargarUnValor('id_gestion');
        echo Fachada::getInstancia()->eliminarGestion(traerPorId($id_gestion));
        //echo $id_gestion;
        /*if(count($lista_ret)>0){
            echo crearListaGestiones($lista_ret);
        }
        else{
            echo '<h3 style="margin:30px;"><strong>No hay resultados para la búsqueda:</strong> <em>'.$text_busqueda.'</em></h3>';
        }     */   
        break;        
        
    case "agregar_participante": 
        $un_participante_array = cargarValoresParticipante();                
        $retorno = Fachada::getInstancia()->agregarParticipante($un_participante_array);        
        if($retorno) echo $retorno; else echo 0;             

        break;    
    default:        
        break;
}

function traerPorId($id_gestion)
{
    return Fachada::getInstancia()->getGestionById($id_gestion);
}

function cargarValoresGestion()
{
    $paramsVG=array();
    $paramsVG['id_gestion'] = (isset($_POST['id_gestion'])) ? $_POST['id_gestion'] : null;     
    $paramsVG['descripcion']=$_POST['descripcion'];
    $paramsVG['id_tipo_gestion']=$_POST['tipo_gestion'];
    $paramsVG['fecha_inicio']= Common::fromUsrToSqlDate($_POST['fecha_inicio']);
    $paramsVG['fecha_fin']=Common::fromUsrToSqlDate($_POST['fecha_fin']);
    $paramsVG['estado']=$_POST['estado'];
    $paramsVG['id_usuario']=$_SESSION["id_usuario"];
    $paramsVG['id_grupo']=(isset($_POST['id_grupo'])) ? $_POST['id_grupo'] : null;  
    return $paramsVG;
}

function cargarValoresParticipante(){ 
    $paramsParticipante=array();
    $paramsParticipante['nombre']=$_POST['nombre'];
    $paramsParticipante['apellido']=$_POST['apellido'];
    $paramsParticipante['ci']=$_POST['ci'];
    $paramsParticipante['email']=$_POST['email'];
    $paramsParticipante['telefono']=$_POST['telefono'];
    $paramsParticipante['direccion']=$_POST['direccion']; 
    //$paramsCliente['ci_escaneada']=$_POST['ci_escaneada'];
    return $paramsParticipante;
}

function cargarUnValor($variable){
    return $_POST[$variable];
}

function traerTodos(){
    
    /*$todas_las_gestiones = Fachada::getInstancia()->getGestiones();
    return $todas_las_gestiones;*/
    
    $todas_las_gestiones = Fachada::getInstancia()->getGestiones();
    return $todas_las_gestiones;
}

function crearListaClientes($lista){
    $retorno = '<table class="table table-hover"><thead><tr><th>#</th><th>Nombre</th><th>Documento</th><th>Acciones</th></tr></thead><tbody>';
    $numero = 0;    
    foreach ($lista as $c) 
    {        
        $retorno .= '<tr><td class="dato_mostrado">'.++$numero.'</td><td class="dato_mostrado">'.$c->getNombre()." ".$c->getApellido().'</td><td class="dato_mostrado">'.$c->getCI().'</td><td><p><i class="fa fa-pencil-square-o fa-2x"></i><i class="btn_eliminar fa fa-ban fa-2x"></i></p></td></tr>';
    }
    return $retorno;
}

function crearListaGestiones($lista){
    $retorno= '<table class="table table-hover"><thead><tr><th>#</th><th>Descripcion</th><th>Tipo de Gestión</th><th>Fecha Inicio</th><th>Fecha Finalizado</th><th>Estado</th><th>Acciones</th></tr></thead><tbody>';
    //$numero = 0; 
    foreach ($lista as $g)
    {
        $estado="En curso";
        if($g->getEstado()==1)$estado="Finalizado";
        $TipoGestion = $g->getTipoGestion();                
        $retorno .= '<tr><td class="dato_mostrado_gestion">'.$g->getId().'</td><td id="'.$g->getId().'" class="dato_mostrado_gestion">'.$g->getDescripcion().'</td><td class="dato_mostrado_gestion"><em>Tipo</em>: '.$TipoGestion->getDescripcion().'</td><td class="dato_mostrado_gestion">'.$g->getFechaInicio().'</td><td class="dato_mostrado_gestion">'.$g->getFechaFin().'</td><td class="dato_mostrado_gestion">'.$estado.'</td><td><p><i title="Modificar" class="btn_ver_gestion fa fa-pencil-square-o fa-2x"></i><i title="Eliminar" class="btn_eliminar_gestion fa fa-ban fa-2x"></i></p></td></tr>';
    }
    return $retorno;
}

function crearListaGestiones_buscador($lista){
    $retorno= '<table class="table table-hover"><thead><tr><th>#</th><th>Descripcion</th><th>Tipo de Gestión</th><th>Fecha Inicio</th><th>Fecha Finalizado</th><th>Estado</th><th>Acciones</th></tr></thead><tbody>';
    //$numero = 0; 
    foreach ($lista as $g)
    {
        $estado="En curso";
        if($g->getEstado()==1)$estado="Finalizado";
        $TipoGestion = $g->getTipoGestion();                
        $retorno .= '<tr><td class="dato_mostrado_gestion_buscador">'.$g->getId().'</td><td id="'.$g->getId().'" class="dato_mostrado_gestion_buscador">'.$g->getDescripcion().'</td><td class="dato_mostrado_gestion_buscador"><em>Tipo</em>: '.$TipoGestion->getDescripcion().'</td><td class="dato_mostrado_gestion_buscador">'.$g->getFechaInicio().'</td><td class="dato_mostrado_gestion_buscador">'.$g->getFechaFin().'</td><td class="dato_mostrado_gestion_buscador">'.$estado.'</td><td><p><i title="Modificar" class="btn_ver_gestion_buscador fa fa-pencil-square-o fa-2x"></i><i title="Eliminar" class="btn_eliminar_gestion_buscador fa fa-ban fa-2x"></i></p></td></tr>';
    }
    return $retorno;
}

function crearSelectTiposGestion($lista){
    $retorno = '';
    foreach ($lista as $tg) 
    {        
        $retorno .= '<option value="'.$tg->getIdTiposGestion().'">'.$tg->getDescripcion().'</option>';
    }
    return $retorno;
}

function crearSelectPersonas($listaPersonas,$lista_personas_excluidas){
    $retorno = '';
    foreach ($listaPersonas as $c){      
        if(personaSirve($c,$lista_personas_excluidas)){
            $retorno .= '<option value="'.$c->getId().'">'.$c->getNombre().' '.$c->getApellido().' - CI:'.$c->getCI().'</option>';
        }
    }
    return $retorno;
}

function personaSirve($c,$lista_clientes){
    if(count($lista_clientes)>0){
        foreach($lista_clientes as $un_cliente){
            if($c->getId()==$un_cliente->getId()){
                return false;
            }
        }
    }
    return true;
}

function traerGestionPorID($id_gestion){
    $lista_gestiones = traerTodos();
    $retorno = null;
    foreach($lista_gestiones as $una_gestion){
        if($una_gestion->getId() == $id_gestion){
            return $una_gestion;
        }
    }
    return $retorno;
}

function traerGestionesBuscadas($lista_gestiones,$text_busqueda){
    $retorno = array();    
    foreach($lista_gestiones as $una_gestion){
        if(strpos( strtolower($una_gestion->getDescripcion()), $text_busqueda ) !== false){
            array_push($retorno, $una_gestion);
        }
    }
    return $retorno;
}

function traerGestionesFiltradas($fecha_inicio,$fecha_final,$tipo_busqueda){
    $retorno = array();
    $lista_gestiones = traerTodos();
    foreach($lista_gestiones as $una_gestion){
        if($fecha_inicio != -1 && $fecha_final != -1){
            if(compararFechasPorTipoBusqueda($una_gestion,$fecha_inicio,$fecha_final,$tipo_busqueda)){
                    array_push($retorno, $una_gestion);
             }    
        }        
        else{
            if($fecha_inicio != -1){
                if(compararFechasPorTipoBusqueda_sin_fecha_fin($una_gestion,$fecha_inicio,$tipo_busqueda)){
                        array_push($retorno, $una_gestion);
                 }    
            }        
            else{
                if($fecha_final != -1){
                    if(compararFechasPorTipoBusqueda_sin_fecha_inicio($una_gestion,$fecha_fin,$tipo_busqueda)){
                            array_push($retorno, $una_gestion);
                     } 
                }        
                else{
                    array_push($retorno, $una_gestion);
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

function compararFechasPorTipoBusqueda($una_gestion,$fecha_inicio,$fecha_final,$tipo_busqueda){    
    if($tipo_busqueda == 1){
        return primeraFechaEsMayorOIgual($una_gestion->getFechaInicio(),$fecha_inicio) && primeraFechaEsMayorOIgual($fecha_final,$una_gestion->getFechaInicio());
    }
    if($tipo_busqueda == 2){
        return primeraFechaEsMayorOIgual($una_gestion->getFechaFin(),$fecha_inicio) && primeraFechaEsMayorOIgual($fecha_final,$una_gestion->getFechaFin());
    }
    if($tipo_busqueda == 3){
        return primeraFechaEsMayorOIgual($una_gestion->getFechaInicio(),$fecha_inicio) && primeraFechaEsMayorOIgual($fecha_final,$una_gestion->getFechaFin());
    }
    return false;
}

function compararFechasPorTipoBusqueda_sin_fecha_fin($una_gestion,$fecha_inicio,$tipo_busqueda){
    if($tipo_busqueda == 1){
        return primeraFechaEsMayorOIgual($una_gestion->getFechaInicio(),$fecha_inicio);
    }
    if($tipo_busqueda == 2){
        return primeraFechaEsMayorOIgual($una_gestion->getFechaFin(),$fecha_inicio);
    }
    if($tipo_busqueda == 3){
        return primeraFechaEsMayorOIgual($una_gestion->getFechaInicio(),$fecha_inicio) || primeraFechaEsMayorOIgual($una_gestion->getFechaFin(),$fecha_inicio);
    }
    return false;
}

function compararFechasPorTipoBusqueda_sin_fecha_inicio($una_gestion,$fecha_fin,$tipo_busqueda){
    if($tipo_busqueda == 1){
        return primeraFechaEsMayorOIgual($fecha_fin,$una_gestion->getFechaInicio());
    }
    if($tipo_busqueda == 2){
        return primeraFechaEsMayorOIgual($fecha_fin,$una_gestion->getFechaFin());
    }
    if($tipo_busqueda == 3){
        return primeraFechaEsMayorOIgual($fecha_fin,$una_gestion->getFechaInicio()) || primeraFechaEsMayorOIgual($fecha_fin,$una_gestion->getFechaFin());
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
