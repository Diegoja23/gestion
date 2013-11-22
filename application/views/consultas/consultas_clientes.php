<?php

header('Content-Type: text/html; charset=UTF-8');
//$GLOBALS['fachada'] = Fachada::getInstancia();

//$Fachada = Fachada::getInstancia();
$consulta = $_POST['consulta'];

    
switch($consulta){
    case "traer_todos":
        //echo crearListaClientes(traerTodos());
        echo crearListaClientes(traerTodos());
        /*echo "traigo todos";*/
        break;

    case "agregar_cliente": 
        $un_cliente = cargarValores();

        if(Fachada::getInstancia()->agregarCliente($un_cliente)){
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
    
   case "subir foto":
        $file = $_FILES['archivo']['name'];
        echo $file;
        break;   
    
    default:
        echo "a no es igual a ninguno de los valores esperados";
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

function cargarUnValor($variable){
    return $_POST[$variable];
}

function traerTodos(){
    //$Fachada = $GLOBALS['fachada'];
    $todos_los_clientes = Fachada::getInstancia()->getClientes();
    return $todos_los_clientes;
}

function crearListaClientes($lista){
    $retorno = '<table class="table table-hover"><thead><tr><th>#</th><th>Nombre</th><th>Documento</th><th>Acciones</th></tr></thead><tbody>';
    $numero = 0;    
    foreach ($lista as $c) 
    {        
        $retorno .= '<tr><td class="dato_mostrado">'.++$numero.'</td><td class="dato_mostrado">'.$c->getNombre()." ".$c->getApellido().'</td><td class="dato_mostrado">'.$c->getCI().'</td><td><p><i class="fa fa-pencil-square-o fa-2x"></i><i class="fa fa-ban fa-2x"></i></p></td></tr>';
    }
    return $retorno;
}

function traerTodos2(){
    $todos_los_clientes = traerTodosDP();
    return $todos_los_clientes;
}

function traerTodosDP(){
    $todos_los_clientes = '<table class="table table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Documento</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>Obdulio Varela</td>
            <td>4.444.444-4</td>
            <td><p><i class="fa fa-pencil-square-o fa-2x"><i class="fa fa-ban"></i></i></p></td>
          </tr>
          <tr>
            <td>2</td>
            <td>Jacob</td>
            <td>Thornton</td>
            <td>@fat</td>
          </tr>
          <tr>
            <td>3</td>
            <td colspan="2">Larry the Bird</td>
            <td>@twitter</td>
          </tr>
        </tbody>
      </table>';
    return $todos_los_clientes;
}

?>
