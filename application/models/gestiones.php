<?php

class Gestiones extends CI_Model 
{
    
    function __construct()
    {
    }
    
            
            
    function get_tipos_gestion()
    {
        $sql = "SELECT * FROM  tipos_gestion";                
        //die($sql);
        $query = $this->db->query($sql);                   
        return $query->result();        
    } 
                
    function insert_gestion($gestionParams)
    {
        $id_gestion = 0;
        $this->db->insert('personas', $gestionParams);   
        $id_gestion = $this->db->insert_id();
        return ($id_gestion > 0);           
    }   
    
                 
}

?>