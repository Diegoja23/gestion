<?php
            //Array que contiene las variables que se deben conservar en las cookies, actualmente se conserva solo el lenguaje  
            //TODO agregar logica pertinente al logout aqui
            if(@session_start())
            {

                $this->session->unset_userdata($_SESSION);  
                //$this->session->destroy();  
                redirect('', 'refresh');          
            }            
            
            
?>          