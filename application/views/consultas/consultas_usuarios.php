<?php
$consulta = $_POST['consulta'];
    
switch($consulta){
    case "traer_todos":
        $listaUsuarios = Fachada::getInstancia()->getUsuarios();
        echo crearListaParaPersonas($listaUsuarios);
        break;
    
    case "agregar_usuario": 
        $un_usuario_array = cargarValores();
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
            
    case "traer_por_id":
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
    $paramsCliente['email']=$_POST['email'];
    $paramsCliente['password']=$_POST['password'];
    return $paramsCliente;
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
    $retorno = '<table class="table table-hover"><thead><tr><th>#</th><th>Nombre</th><th>E-mail</th><th>Acciones</th></tr></thead><tbody>';
    $numero = 0;    
    foreach ($lista as $c) 
    {        
        $retorno .= '<tr><td class="dato_mostrado_usuario">'.$c->getId().'</td><td class="dato_mostrado_usuario">'.$c->getNombre()." ".$c->getApellido().'</td><td class="dato_mostrado_usuario">'.$c->getMail().'</td><td><p><i class="btn_ver_usuario fa fa-pencil-square-o fa-2x"></i>&nbsp;<i class="btn_eliminar_usuario fa fa-ban fa-2x"></i></p></td></tr>';
    }
    return $retorno;
}

/*function crearListaGestiones($lista){
    $retorno = '<table class="table table-hover"><thead><tr><th>#</th><th>Nombre</th><th>Documento</th><th>Acciones</th></tr></thead><tbody>';
    $numero = 0;    
    foreach ($lista as $c) 
    {        
        $retorno .= '<tr><td class="dato_mostrado_cliente">'.++$numero.'</td><td class="dato_mostrado_cliente">'.$c->getNombre()." ".$c->getApellido().'</td><td class="dato_mostrado_cliente">'.$c->getCI().'</td><td><p><i class="fa fa-pencil-square-o fa-2x"></i><i class="btn_eliminar fa fa-ban fa-2x"></i></p></td></tr>';
    }
    return $retorno;
}*/

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


?>
