<?php
require_once('Persona.php');
/**
 * class Cliente
 * autor: gestion
 * 
 */

class Participante extends Persona
{
    
    protected $direccion;
    protected $telefono;
    protected $ci;
    protected $es_cliente=false;
    
    /* Constructor */
    public function __construct($params = array())
    {
          parent::__construct($params);
    }
    
    
    /* Getters */
    public function getDireccion(){ return $this->direccion; }
                
    public function getTelefono(){return $this->telefono;}
    
    public function getCI(){return $this->ci;}
    
    /* Setters */
    
    public function validar()
    {
        //TODO -- aqui hay que validar los datos del participante, asi como asegurarnos de que no exista previamente
        return true;
    }
    
    public function add()
    {
        $object_vars=get_object_vars($this);
        //var_dump(get_object_vars($this));
        $fieldsParticipante = array();
        foreach($object_vars as $key => $value)        
            if($key != 'myci')
                $fieldsParticipante[$key] = $value;                    
              
        return $this->myci->p->insert_persona($fieldsParticipante);

    }
    
    /* Miembros estáticos, manejan funcionalidad de todos */
    public static function getAll($esCliente=false)
    {
        $arrayParticipantes = array();
        $paramsParticipante = array();
        $ci =& get_instance();                      
        $data = $ci->p->get_all_personas($esCliente);
        foreach($data as $p)
        {
            $paramsParticipante["id_persona"] = $p->id_persona;   
            $paramsParticipante["nombre"] = $p->nombre;    
            $paramsParticipante["apellido"] = $p->apellido;    
            $paramsParticipante["email"] = $p->email;    
            $paramsParticipante["direccion"] = $p->direccion;    
            $paramsParticipante["telefono"] = $p->telefono;    
            $paramsParticipante["ci"] = $p->ci;    
            
            $Participante = new Participante($paramsParticipante);   
            $arrayParticipantes[] = $Participante;
        }
        
        return $arrayParticipantes;
    }  
    
        
            
}


?>