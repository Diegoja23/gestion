<?php

class Cliente extends CI_Model 
{
    
    private $myci;
    
    function __construct()
    {
        $this->myci = &get_instance();
        $this->myci->load->model('personas', 'p');              
    }
    
     
            
}

?>