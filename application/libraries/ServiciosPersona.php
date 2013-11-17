<?php
require_once('cliente.php');
/**
 * class ServiciosPersona
 * autor: gestion
 * 
 */

class ServiciosPersona 
{
    

    /* Constructor */
    public function __construct()
    {

    }
    
    public function agregarCliente($paramsCliente) 
    {
        $Cliente = new Cliente($paramsCliente);
        if($Cliente->validar()) 
            return $Cliente->add();            
        else 
            return false;
        
    }
    
            
}


?>