<?php
require_once('Participante.php');
/**
 * class Cliente
 * autor: gestion
 * 
 */

class Cliente extends Participante
{
    
    protected $es_cliente=true;
    
    /* Constructor */
    public function __construct($params = array())
    {
        parent::__construct($params);
    }
    

    /* Miembros estáticos, manejan funcionalidad de todos */
    
    public static function getAll($limit = 0, $offset = -1)
    {
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
    }      
    
    public function update()
    {
        return parent::update();
    }      
            
}


?>