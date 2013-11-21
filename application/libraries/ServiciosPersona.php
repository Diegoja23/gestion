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
    
    public function getByCI($ci){
        //var_dump($ci);die();
        return Cliente::getByCI($ci);
    }
    
    
    public function getClientes($limit = 0, $offset = -1) 
    {
        return Cliente::getAll($limit, $offset);
        /*$arrayClientes = array();
        $paramsCliente = array();
        $ci =& get_instance();
        $data = $ci->personas->get_all_personas(true, $limit, $offset);
        foreach($data as $p)
        {
            $paramsCliente["id_persona"] = $p->id_persona;   
            $paramsCliente["nombre"] = $p->nombre;    
            $paramsCliente["apellido"] = $p->apellido;    
            $paramsCliente["email"] = $p->email;    
            $paramsCliente["direccion"] = $p->direccion;    
            $paramsCliente["telefono"] = $p->telefono;    
            $paramsCliente["ci"] = $p->ci;    
            
            $Cliente = new Cliente($paramsCliente);   
            $arrayClientes[] = $Cliente;
        }
        return $arrayClientes;    */
    }
    
    /*public function getPersonas($limit = 0, $offset = -1) 
    {
        //return Cliente::getAll($limit, $offset);
        $arrayClientes = array();
        $paramsCliente = array();
        $ci =& get_instance();
        $data = $ci->personas->get_all_personas(true, $limit, $offset);
        foreach($data as $p)
        {
            $paramsCliente["id_persona"] = $p->id_persona;   
            $paramsCliente["nombre"] = $p->nombre;    
            $paramsCliente["apellido"] = $p->apellido;    
            $paramsCliente["email"] = $p->email;    
            $paramsCliente["direccion"] = $p->direccion;    
            $paramsCliente["telefono"] = $p->telefono;    
            $paramsCliente["ci"] = $p->ci;    
            
            $Cliente = new Cliente($paramsCliente);   
            $arrayClientes[] = $Cliente;
        }
        return $arrayClientes;    
    }*/
    
    
            
}


?>