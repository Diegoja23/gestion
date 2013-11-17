<?php
header('Content-Type: text/html; charset=UTF-8');

        $CI = &get_instance();
        //$CI->load->library('form_validation');
        $CI->load->library('cliente');


        $params = $_REQUEST;
        
        //var_dump($params);
        if(!empty($params) && isset($params['nombre']))
        {
            $Cliente = new Cliente($params);
    
            if($Cliente->add())
                echo "El cliente ". $Cliente->getNombre()." se ingresó con éxito<br>";
            else
                echo "El cliente ". $Cliente->getNombre()." no pudo ser ingresado. Verifique los datos<br>";            
        }

        
        
        $allClients = Cliente::getAll();
        
        if(count($allClients) > 0)
        {
            echo "Lista de clientes: <hr>";
            foreach($allClients as $c)
            {
                echo $c->getNombre()." ".$c->getApellido()."<br>";
            }            
        }
        else 
        {
            echo "No se han ingresado clientes. Intente ingresarlos con sus parámetros por url como en el siguiente ejemplo:<br>";
            echo "http://localhost/gestion/cliente?nombre=Jose&apellido=Perez&ci=4.409.256-2&email=joseperez@gmail.com&telefono=095134437&direccion=8 de octubre 4327";    
        }

        

?>