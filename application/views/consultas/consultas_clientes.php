<?php
header('Content-Type: text/html; charset=UTF-8');
$Fachada = Fachada::getInstancia();
$consulta = $_POST['consulta'];

switch($consulta){
    case "traer_todos":
        echo traerTodos();
        //echo "traigo todos";
        break;

    case "agregar_cliente": 
        $un_cliente = cargarValores();
        if($Fachada->agregarCliente($un_cliente)){
            /*echo "El cliente ".$un_cliente['nombre']." se ingresó con éxito<br>";*/
            echo 1;
        }
        else{
            /*echo "El cliente ". $un_cliente['nombre']." no pudo ser ingresado. Verifique los datos<br>"; */
            echo 2;
        }
        break;
    
    case 2:
        echo "a es igual a 2";
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

function traerTodos(){
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
