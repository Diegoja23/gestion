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
    
    function insert_tramite($tramiteParams)
    {
        $id_tramite = 0;
        $this->db->insert('tramites', $tramiteParams);   
        $id_tramite = $this->db->insert_id();
        return ($id_tramite > 0);   
    }    
                
    function get_tramites($id_gestion = 0)
    {
        $sql = "SELECT * FROM tramites";   
        if($id_gestion > 0)
            $sql .= " WHERE id_gestion = ".$id_gestion;             
        $query = $this->db->query($sql);                   
        return $query->result();         
    }   
                 
}

?>