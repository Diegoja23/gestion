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
    
    // get clientes
    echo "Clientes sin limite (todos)<br>";
    $clientes = $Fachada->getClientes();
        
    foreach ($clientes as $c) 
    {        
        echo $c->getNombre()."<br>";
    }         

    echo "Clientes, los primeros dos<br>";
    
    $clientes = $Fachada->getClientes(2,0);
    
    foreach ($clientes as $c) 
    {
        echo $c->getNombre()."<br>";
        $clienteModificar = $c;
    }       
         
    $clienteModificar->setNombre('Adela');
    $Fachada->modificarCliente($clienteModificar);
    
?>