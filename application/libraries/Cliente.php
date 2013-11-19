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
    public static function getAll2($limit, $offset)
    {        
        return parent::getAll(true, $limit, $offset);
    }  
    
    public static function getAll($esCliente=true, $limit = 0, $offset = -1)
    {
        $arrayParticipantes = array();
        $paramsParticipante = array();
        $ci =& get_instance();                      
        $data = $ci->p->get_all_personas($esCliente, $limit, $offset);
        foreach($data as $p)
        {
            $paramsParticipante["id_persona"] = $p->id_persona;   
            $paramsParticipante["nombre"] = $p->nombre;    
            $paramsParticipante["apellido"] = $p->apellido;    
            $paramsParticipante["email"] = $p->email;    
            $paramsParticipante["direccion"] = $p->direccion;    
            $paramsParticipante["telefono"] = $p->telefono;    
            $paramsParticipante["ci"] = $p->ci;    
            
            $Participante = new Cliente($paramsParticipante);   
            $arrayParticipantes[] = $Participante;
        }

        return $arrayParticipantes;
    }      
    
    public function update()
    {
        die("d");
        var_dump(get_object_vars($this));
        return parent::update();
    }      
            
}


?>