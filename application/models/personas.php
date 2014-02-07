<?php

class Personas extends CI_Model 
{
    
    function __construct()
    {
    }
    
    function get_all_personas($esCliente = 0, $limit = 0, $offset = -1)
    {
        $sql = "SELECT * FROM personas AS p where p.es_cliente=".$esCliente;                
        
        if ($limit > 0) $sql .= " LIMIT ".$offset;
        //$this->db->limit($limit);
        if ($offset >= 0) $sql .= ",".$limit;
        //die($sql);
        $query = $this->db->query($sql);                   
        return $query->result();        
    }     
    
    function insert_persona($personParams)
    {
        $id_persona = 0;
        $this->db->insert('personas', $personParams);   
        $id_persona = $this->db->insert_id();
        return $id_persona;   
    }
    
    function exists_persona($ci)
    {
        $query = $this->db->get_where('personas', array('ci' => $ci));
        if ($query->num_rows > 0) return true;
        return false;
    }
    
    public function getById($id_persona)
    {
        $query = $this->db->get_where('personas', array('id_persona' => $id_persona));
        if ($query->num_rows > 0) return $query->result();
        return false;        
    }
    
    public function getByCI($ci){        
        $query = $this->db->get_where('personas', array('ci' => $ci));
        //echo "res ";
        //var_dump($query->result());
        if ($query->num_rows > 0) return $query->result();
        return false;
    }
        
    public function eliminarByCI($ci){  
        return $this->db->delete('personas', array('ci' => $ci));        
    }
    
    public function eliminarById($id_persona){  
        return $this->db->delete('personas', array('id_persona' => $id_persona));        
    }        
    
    function update_persona($personParams)
    {        
        $id_persona = $personParams['id_persona'];
        
        $this->db->where('id_persona', $id_persona);
        $this->db->update('personas', $personParams);    
        //$query = $this->db->update('personas', $personParams);    
        //var_dump($query);
        return true;
    }
    
 
        
            
}

?>