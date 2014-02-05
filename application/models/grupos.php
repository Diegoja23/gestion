<?php

class Grupos extends CI_Model 
{
    
    function __construct()
    {
    }
    
            
    function insert_grupo($paramsGrupo, $clientes, $partcipantes)
    {
        $id_grupo = 0;        
        $this->db->trans_begin();
        
        $this->db->insert('grupo', $paramsGrupo);   
        $id_grupo = $this->db->insert_id();
        
        foreach($clientes as $c)
        {
            $paramsPertenece = array('id_grupo' => $id_grupo, 'id_persona' => $c->getId(), 'rol' => 'c');
            $this->db->insert('pertenece', $paramsPertenece);   
        }
        foreach($partcipantes as $p)
        {
            $paramsPertenece = array('id_grupo' => $id_grupo, 'id_persona' => $p->getId(), 'rol' => 'p');
            $this->db->insert('pertenece', $paramsPertenece);   
        }        
        
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $retorno = 0;
        }
        else
        {
            $this->db->trans_commit();
            $retorno = $id_grupo;
        }   

        return $retorno;        
  
    }    
    
    public function get_grupo_by_id($id_grupo)
    {
        $query = $this->db->get_where('grupo', array('id_grupo' => $id_grupo));
        if ($query->num_rows > 0) return $query->result();
        return false;              
    }
    
    public function get_id_rol_personas_by_grupo($id_grupo)
    {
        $sql = "SELECT id_persona, rol FROM pertenece WHERE id_grupo=".$id_grupo;
        $query = $this->db->query($sql);                   
        return $query->result();              
    }    

    public function replace_grupo($paramsGrupo, $clientes, $partcipantes)
    {
        $retorno = false;
        $id_grupo = $paramsGrupo['id_grupo'];
        
        $this->db->trans_begin();        
    
        $this->db->where('id_grupo', $id_grupo);
        $this->db->update('grupo', $paramsGrupo);
                
        $this->delete_participantes($id_grupo);
                           
        foreach($clientes as $c)
        {
            $paramsPertenece = array('id_grupo' => $id_grupo, 'id_persona' => $c->getId(), 'rol' => 'c');
            $this->db->insert('pertenece', $paramsPertenece);   
        }
        foreach($partcipantes as $p)
        {
            $paramsPertenece = array('id_grupo' => $id_grupo, 'id_persona' => $p->getId(), 'rol' => 'p');
            $this->db->insert('pertenece', $paramsPertenece);   
        }        
        
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();            
        }
        else
        {
            $this->db->trans_commit();
            $retorno = true;
        }   

        return $retorno;         
    }
    
    function eliminar_grupo($id_grupo)
    {
        $this->db->delete('grupo', array('id_grupo' => $id_grupo));        
    }
    
    function delete_participantes($id_grupo)
    {
        $this->db->delete('pertenece', array('id_grupo' => $id_grupo));                 
    }       
                 
}

?>