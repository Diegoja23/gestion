<?php

$consulta = $_POST['consulta'];
    
switch($consulta){
    case "traer_todos":
        echo crearListaGestiones(traerTodos());
        //echo crearSelectTiposTramites($listaTiposTramites);
        break;

    case "agregar_gestion": 
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
        
    case "traer_por_id":
        
        $id_gestion = cargarUnValor('id_gestion');        
        $una_gestion = traerGestionPorID($id_gestion);
        //var_dump($una_gestion);die();
        echo json_encode($una_gestion->convertirArray());
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
        $TipoGestion = $g->getTipoGestion();                
        $retorno .= '<tr><td class="dato_mostrado_gestion">'.$g->getId().'</td><td id="'.$g->getId().'" class="dato_mostrado_gestion">'.$g->getDescripcion().'</td><td class="dato_mostrado_gestion"><em>Tipo</em>: '.$TipoGestion->getDescripcion().'</td><td class="dato_mostrado_gestion">'.$g->getFechaInicio().'</td><td class="dato_mostrado_gestion">'.$g->getFechaFin().'</td><td class="dato_mostrado_gestion">'.$g->getEstado().'</td><td><p><i class="btn_ver_gestion fa fa-pencil-square-o fa-2x"></i><i class="btn_eliminar_gestion fa fa-ban fa-2x"></i></p></td></tr>';
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

?>
