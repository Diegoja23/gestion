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
                                 
    echo Fachada::getInstancia()->agregarGestion($paramsGestion, $grupo);        

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
        echo Fachada::getInstancia()->modificarGestion($paramsGestion, $grupo);                                    
        
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
    
   case "buscar_por_descripcion":
        $text_busqueda = cargarUnValor('text_busqueda');
        $lista_ret = traerGestionesBuscadas(strtolower($text_busqueda));
        if(count($lista_ret)>0){
            echo crearListaGestiones($lista_ret);
        }
        else{
            echo '<h3 style="margin:30px;"><strong>No hay resultados para la búsqueda:</strong> <em>'.$text_busqueda.'</em></h3>';
        }        
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
        $retorno .= '<tr><td class="dato_mostrado_gestion">'.$g->getId().'</td><td id="'.$g->getId().'" class="dato_mostrado_gestion">'.$g->getDescripcion().'</td><td class="dato_mostrado_gestion"><em>Tipo</em>: '.$TipoGestion->getDescripcion().'</td><td class="dato_mostrado_gestion">'.$g->getFechaInicio().'</td><td class="dato_mostrado_gestion">'.$g->getFechaFin().'</td><td class="dato_mostrado_gestion">'.$estado.'</td><td><p><i class="btn_ver_gestion fa fa-pencil-square-o fa-2x"></i><i class="btn_eliminar_gestion fa fa-ban fa-2x"></i></p></td></tr>';
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

function traerGestionesBuscadas($text_busqueda){
    $retorno = array();
    $lista_gestiones = traerTodos();
    foreach($lista_gestiones as $una_gestion){
        if(strpos( strtolower($una_gestion->getDescripcion()), $text_busqueda ) !== false){
            array_push($retorno, $una_gestion);
        }
    }
    return $retorno;
}

?>
