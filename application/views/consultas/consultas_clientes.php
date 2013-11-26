<?php

$consulta = $_POST['consulta'];
    
switch($consulta){
    case "traer_todos":
        echo crearListaClientes(traerTodos());
        break;

    case "agregar_cliente": 
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
        
    case "traer_por_ci":
        $ci = cargarUnValor('ci');        
        $un_cliente = Fachada::getInstancia()->getByCI($ci);
        echo json_encode($un_cliente->convertirArray());
        break;
    
   case "subir_foto":
        $file = $_FILES['archivo']['name'];
        echo $file;
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
    //$paramsCliente['ci_escaneada']=$_POST['ci_escaneada'];
    return $paramsCliente;
}

function cargarAdjunto(){
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
    session_start();
    if(isset($_SESSION['ci'])){
        return $arrayDatosAdjuntos = $_SESSION['ci'];
    }
    else{
        return -1;
    }
        //echo '<img src="data:image/jpeg;base64,' . base64_encode( $archivo ) . '" />';
}

function cargarUnValor($variable){
    return $_POST[$variable];
}

function traerTodos(){
    //$Fachada = $GLOBALS['fachada'];
    $todas_las_gestiones = Fachada::getInstancia()->getClientes();
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
    $retorno = '<table class="table table-hover"><thead><tr><th>#</th><th>Nombre</th><th>Documento</th><th>Acciones</th></tr></thead><tbody>';
    $numero = 0;    
    foreach ($lista as $c) 
    {        
        $retorno .= '<tr><td class="dato_mostrado">'.++$numero.'</td><td class="dato_mostrado">'.$c->getNombre()." ".$c->getApellido().'</td><td class="dato_mostrado">'.$c->getCI().'</td><td><p><i class="fa fa-pencil-square-o fa-2x"></i><i class="btn_eliminar fa fa-ban fa-2x"></i></p></td></tr>';
    }
    return $retorno;
}


?>
