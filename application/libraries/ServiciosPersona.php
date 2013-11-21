<?php
require_once('Cliente.php');
require_once('Adjunto.php');
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
    
    public function agregarCliente($paramsCliente, $paramsAdjuntos = array()) 
    {
        $paramsCliente['adjuntos'] = array();
        foreach ($paramsAdjuntos as $p) 
        {
            $attsAdjuntos = array('nombre' => $p['nombre'], 'archivo' => $p['archivo'], 'tipo' => $p['tipo']);
            $Adjunto = new Adjunto($attsAdjuntos);
            array_push($paramsCliente['adjuntos'], $Adjunto);  
           
        }
        $Cliente = new Cliente($paramsCliente);
        if($Cliente->validar()) 
            return $Cliente->add();            
        else 
            return false;        
    }
    
    public function modificarCliente(Cliente $Cliente)
    {
        return $Cliente->update(); 
    } 
    
    
    public function getClientes($limit = 0, $offset = -1) 
    {
        return Cliente::getAll($limit, $offset);
    }    
            
}


?>