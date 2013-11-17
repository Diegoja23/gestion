<?php

    $Fachada = Fachada::getInstancia();
    
    $paramsCliente=array();
    $paramsCliente['nombre']='Martha';
    $paramsCliente['apellido']='Sobrero';
    $paramsCliente['ci']='3.809.322-7';
    $paramsCliente['email']='m.sobrero@gmail.com';
    $paramsCliente['telefono']='099227340';
    $paramsCliente['direccion']='Charrúa 3344';       
    

    if($Fachada->agregarCliente($paramsCliente))
        echo "El cliente ". $paramsCliente['nombre']." se ingresó con éxito<br>";
    else
        echo "El cliente ". $paramsCliente['nombre']." no pudo ser ingresado. Verifique los datos<br>";            


?>