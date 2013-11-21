<?php
require_once('Persona.php');
require_once('Adjunto.php');
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
    
    public function getAdjuntos(){return $this->adjuntos;}
    
    /* Setters */
    
    public function validar()
    {
        //TODO -- aqui hay que validar los datos del participante, asi como asegurarnos de que no exista previamente
        return !$this->exists();
    }
    
    public function exists()
    {
        return $this->myci->personas->exists_persona($this->ci);    
    }
    
    public function add()
    {
        $object_vars=get_object_vars($this);
        //var_dump(get_object_vars($this));
        $fieldsParticipante = array();
        foreach($object_vars as $key => $value)        
            if($this->attNotDistinctToTable($key))
                $fieldsParticipante[$key] = $value; 
            
        $id_persona = $this->myci->personas->insert_persona($fieldsParticipante);             
        if(!empty($this->adjuntos) && $id_persona > 0)
            foreach($this->adjuntos as $adjunto)            
                if(!$this->myci->datos_complementarios->add($adjunto, $id_persona)) return false;            
                                                              
        return true;

    }
    
    public function update()
    {
        $object_vars=get_object_vars($this);
        $fieldsParticipante = array();
        foreach($object_vars as $key => $value)        
            if($this->attNotDistinctToTable($key))
                $fieldsParticipante[$key] = $value;                     
              
        return $this->myci->personas->update_persona($fieldsParticipante);

    }    
    
    public function attNotDistinctToTable($att)
    {
        return ($att != 'myci' && $att != 'adjuntos');
    }    
    /* Miembros estáticos, manejan funcionalidad de todos */
    public static function getAll($limit = 0, $offset = -1)
    {
        $arrayParticipantes = array();
        $paramsParticipante = array();
        $ci =& get_instance();                      
        $data = $ci->personas->get_all_personas(false, $limit, $offset);
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