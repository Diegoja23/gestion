<?php
$consulta = $_POST['consulta'];
    
switch($consulta){
    case "traer_todos":        
        $lista_total = traerTodasLasPersonas();
        echo crearListaParaPersonas($lista_total);
        break;
    
    case "traer_clientes":
        $listaClientes = Fachada::getInstancia()->getClientes();
        echo crearListaParaPersonas($listaClientes);
        break;
    
    case "traer_participantes":
        $listaParticipantes = Fachada::getInstancia()->getParticipantes();
        echo crearListaParaPersonas($listaParticipantes);
        break;

    case "agregar_cliente": 
        $un_cliente_array = cargarValores();
        $adjunto_array = cargarCiDelCliente();
        
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
        
    case "modificar_cliente":         
        $un_cliente_array = cargarValores();        
        $un_cliente_array['id_persona'] = trim($un_cliente_array['id_persona']);
        $es_cli = laPersonaEsCliente($un_cliente_array['id_persona']);
        if($es_cli){
            $un_cliente = new Cliente($un_cliente_array);
            $retorno = Fachada::getInstancia()->modificarCliente($un_cliente);
        }
        else{
            $un_participante = new Participante($un_cliente_array);
            $retorno = Fachada::getInstancia()->modificarParticipante($un_participante);
        }   
        echo $retorno;
        break;
        
    case "agregar_adjunto_al_cliente": 
        $ci = cargarUnValor('ci');
        $id_cliente = cargarUnValor('id_cliente');
        $posibles_adjuntos = cargarTodosLosAdjuntos(); 
        $el_adjunto = $posibles_adjuntos[0];                
        //$adjunto_array = cargarCiDelCliente();
        $id_adjunto = Fachada::getInstancia()->agregarAdjuntoAlParticipante($id_cliente,$el_adjunto);
        //$id_adjunto = 12;
        if($id_adjunto > 0){
             echo json_encode(array('id_adjunto' => $id_adjunto,'tipo' => $el_adjunto['tipo']));
        }
        else{
            echo -1;
        }
        break;    
    
    case "eliminar_dato_complementario_por_id":
       $id_adjunto = cargarUnValor('adjunto_id');
       $retorno = Fachada::getInstancia()->eliminarAdjuntoParticipante($id_adjunto);
       echo $id_adjunto;
       break; 
        
    case "traer_por_ci":
        $ci = cargarUnValor('ci'); 
        $un_cliente = Fachada::getInstancia()->getByCI($ci);
        //var_dump($un_cliente);die();
        $a = traerPrimerAdjunto($un_cliente);
        $array = $un_cliente->convertirArray();
        if($a != null){
            $array['adjunto_tipo'] = $a->getTipo();
                //'<iframe src="http://localhost/gestion/consultas/mostrar_archivo.php?mime='.$a->getTipo().'&id='.$a->getId().'&nombre=poneraquinombrearchivo&from=dato_complementario"></iframe>'; 
            $array['adjunto_id'] = $a->getId();
        }
        /*else{
            
        }*/
        echo json_encode($array);
        break;
    
   case "subir_foto":
        $file = $_FILES['archivo']['name'];
        echo $file;
        break;
   
   case "buscar_por_nombre":
        $text_busqueda = cargarUnValor('text_busqueda');
        $lista_ret = traerPersonasBuscadas(strtolower($text_busqueda));
        if(count($lista_ret)>0){
            echo crearListaParaPersonas($lista_ret);
        }
        else{
            echo '<h3 style="margin:30px;"><strong>No hay resultados para la búsqueda:</strong> <em>'.$text_busqueda.'</em></h3>';
        }        
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


function cargarValores(){ 
    $paramsCliente=array();
    $paramsCliente['nombre']=$_POST['nombre'];
    $paramsCliente['apellido']=$_POST['apellido'];
    $paramsCliente['ci']=$_POST['ci'];
    $paramsCliente['email']=$_POST['email'];
    $paramsCliente['telefono']=$_POST['telefono'];
    $paramsCliente['direccion']=$_POST['direccion']; 
    if(isset($_POST['id_persona'])){
        $paramsCliente['id_persona']=$_POST['id_persona']; 
    }
    //$paramsCliente['ci_escaneada']=$_POST['ci_escaneada'];
    return $paramsCliente;
}

function traerTodasLasPersonas(){
        $listaParticipantes = Fachada::getInstancia()->getParticipantes();
        $listaClientes = Fachada::getInstancia()->getClientes();
        $return = array_merge($listaParticipantes,$listaClientes);        
        return $return;
}

function cargarCiDelCliente(){
    /*$archivo = $_FILES["input_file_cedula"]["tmp_name"];    
    $tamanio = $_FILES["input_file_cedula"]["size"];
    $tipo    = $_FILES["input_file_cedula"]["type"];
    $nombre  = $_FILES["input_file_cedula"]["name"];    
         
    if ( $archivo != "none" )
    {
        $fp = fopen($archivo, "rb");
        $contenido = fread($fp, $tamanio);
        $contenido = addslashes($contenido);
        fclose($fp);     
    }
    else{
        return -1;
    }
         
    $arrayDatosAdjuntos = array(
                                array(  'nombre' => 'cedula',
                                        'archivo' => $contenido,
                                        'tipo' => $tipo)
                               );   */
    //session_start();
    if(!isset($_SESSION)){
        session_start();
    }
    if(isset($_SESSION['ci'])){
        return $arrayDatosAdjuntos = $_SESSION['ci'];
    }
    else{
        return -1;
    }
        //echo '<img src="data:image/jpeg;base64,' . base64_encode( $archivo ) . '" />';
}

function traerPrimerAdjunto($un_cliente){
    $listaAdjuntos = $un_cliente->getAdjuntos();
    $listaSola = $listaAdjuntos['adjuntos'];
    if(count($listaSola)>0){
        return $listaSola[0];
    }
    else{
        return null;
    }
}

function cargarUnValor($variable){
    return $_POST[$variable];
}

function traerTodos(){
    //$Fachada = $GLOBALS['fachada'];
    $todas_las_gestiones = Fachada::getInstancia()->getClientes();
    return $todas_las_gestiones;
}

function crearListaParaPersonas($lista){
    $retorno = '<p style="margin-top:20px;margin-bottom:-10px !important;">Las personas con <i style="color:red;" class="fa fa-check"></i> son clientes</p><table class="table table-hover"><thead><tr><th>#</th><th>Nombre</th><th>Documento</th><th>Acciones</th></tr></thead><tbody>';
    $numero = 0;    
    foreach ($lista as $c) 
    { 
        if($c->esCliente()){
            $retorno .= '<tr><td class="dato_mostrado_cliente">'.$c->getId().' <i style="color:red;" class="fa fa-check"></i></td><td class="dato_mostrado_cliente">'.$c->getNombre()." ".$c->getApellido().'</td><td class="dato_mostrado_cliente">'.$c->getCI().'</td><td><p><i title="Modificar" class="btn_ver_cliente fa fa-pencil-square-o fa-2x"></i>&nbsp;<i title="Eliminar" class="btn_eliminar_cliente fa fa-ban fa-2x"></i>&nbsp;<i title="Adjuntos" class="adjunto_cliente fa fa-paperclip fa-2x"></i></p></td></tr>';
    
        }
        else{
            $retorno .= '<tr><td class="dato_mostrado_cliente">'.$c->getId().'</td><td class="dato_mostrado_cliente">'.$c->getNombre()." ".$c->getApellido().'</td><td class="dato_mostrado_cliente">'.$c->getCI().'</td><td><p><i title="Modificar" class="btn_ver_cliente fa fa-pencil-square-o fa-2x"></i>&nbsp;<i title="Eliminar" class="btn_eliminar_cliente fa fa-ban fa-2x"></i>&nbsp;<i title="Adjuntos" class="adjunto_cliente fa fa-paperclip fa-2x"></i></p></td></tr>';
        }
        
    }
    return $retorno;
}

function cargarTodosLosAdjuntos(){
    //session_start();
    if(!isset($_SESSION)){
        session_start();
    }
    if(isset($_SESSION['adjunto'])){        
        $arrayDatosAdjuntos = $_SESSION['adjunto'];        
        return $arrayDatosAdjuntos;
    }
    else{
        return -1;
    }
}

function laPersonaEsCliente($id_persona){
    $lista = traerTodasLasPersonas();
    foreach($lista as $una_persona){        
        if($una_persona->getId()==$id_persona){         
            return $una_persona->esCliente();
        }
    }
    return false;
}

function traerPersonasBuscadas($text_busqueda){
    $retorno = array();
    $lista_personas = traerTodasLasPersonas();
    foreach($lista_personas as $una_persona){
        if(strpos( strtolower($una_persona->getNombre()), $text_busqueda ) !== false || strpos(strtolower($una_persona->getApellido()), $text_busqueda ) !== false){
            array_push($retorno, $una_persona);
        }
    }
    return $retorno;
}


?>
