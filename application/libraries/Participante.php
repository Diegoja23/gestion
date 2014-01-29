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
    protected $adjuntos = array();
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
        return ($this->nombre!='' && $this->apellido!='' && $this->email!='' && $this->direccion!='' && $this->ci!='' && !$this->exists());      
    }
    
    public function exists()
    {
        return $this->myci->personas->exists_persona($this->ci);    
    }
    
    public function esCliente()
    {
        return $this->es_cliente;
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
                                                              
        return $id_persona;

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

    public function fillById(){
        $array_con_datos_cliente = $this->myci->personas->getById($this->id_persona);        
        $this->materializar($array_con_datos_cliente[0]);
    }
        
    public function getByCI(){
        $array_con_datos_cliente = $this->myci->personas->getByCI($this->getCI());        
        $this->materializar($array_con_datos_cliente[0]);
    }
    
    public function eliminarByCI(){        
        return $this->myci->personas->eliminarByCI($this->getCI());       
    }
    
        
    /* Miembros estáticos, manejan funcionalidad de todos */
    public static function getAll($limit = 0, $offset = -1)
    {
        $arrayParticipantes = array();
        $paramsParticipante = array();
        $ci =& get_instance();                      
        $data = $ci->personas->get_all_personas(0, $limit, $offset);
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
    
    public function convertirArray($conAdjuntos=true){
        $object_vars=get_object_vars($this);
        $fieldsParticipante = array();
        foreach($object_vars as $key => $value){                   
            if($key != 'myci'){
                if($key == 'adjuntos' && $conAdjuntos){                    
                    $value = $this->traerAdjuntosDelArray($value);
                }
                $fieldsParticipante[$key] = $value;   
            } 
        }
        return $fieldsParticipante;
    }    
    
    function traerAdjuntosDelArray($lista_de_adjuntos)
    {
        $retorno = array();
        foreach($lista_de_adjuntos as $un_adjuntos){
            foreach($un_adjuntos as $un_adjunto){            
            array_push($retorno, $un_adjunto->convertirArray());
            }            
        }
        return $retorno;
    }    
    
    public function addAdjunto($Adjunto)
    {
        return ($this->myci->datos_complementarios->add($Adjunto, $this->id_persona));     
    }
            
}


?>