<?php

class Tramites extends CI_Model 
{
    
    function __construct()
    {
    }
    
            
            
    function get_tipos_tramite_by_gestion($id_tipos_gestion)
    {
        $sql = "SELECT * FROM tipos_tramite WHERE id_tipos_gestion = ".$id_tipos_gestion;                
        //die($sql);
        $query = $this->db->query($sql);                   
        return $query->result();        
    } 
                
}

?>