<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Errors extends CI_Controller {              
            
        public function __construct()
        {            
            parent::__construct();            
            $this->load->database();
        }
                        
        public function index($page = 'home', $id = -1)
        {
                                                            
        }
        

         public function not_found()
        {
            $this->load->view('error_404');
        }  
               
}