<?php

class Personas extends CI_Model 
{
    
    private $myci;
    
    function __construct()
    {
        $this->myci = &get_instance();

    }
    
    function get_all_personas($esCliente = false, $limit = 0, $offset = -1)
    {
        $sql = "SELECT * FROM personas AS p where p.es_cliente=".$esCliente;                
        
        if ($limit > 0) $sql .= "LIMIT ".$offset;
        //$this->db->limit($limit);
        if ($offset >= 0) $sql .= ",".$limit;
        //die($sql);
        $query = $this->db->query($sql);                   
        return $query->result();
        
    }     
            
}

?>