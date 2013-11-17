<?php

$consulta = $_POST['consulta'];

switch($consulta){
    case "traer_todos":
        echo traerTodos();
        //echo "traigo todos";
        break;

    case "agregar_cliente": 
        $un_cliente = cargarValores();
        if($Fachada->agregarCliente($paramsCliente)){
            echo "El cliente ". $paramsCliente['nombre']." se ingresó con éxito<br>";
        }
        else{
            echo "El cliente ". $paramsCliente['nombre']." no pudo ser ingresado. Verifique los datos<br>";   
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
    return $paramsCliente;
}
function traerTodos(){
    $todos_los_clientes = '<table class="table table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Username</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
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
