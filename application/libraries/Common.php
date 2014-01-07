<?php 
/**
 * class Common
 * autor: gestion
 * Manejador genérico
 * 
 */
// ------------------------------------------------------------------------

/**
 * Common static library class
 *
 * @category Libraries
 * @author   Yowi
 */

    
class Common
{
    
    private $myci;
                                                    
    public function __construct($params = array())
    {
      $this->myci =& get_instance();
      
      foreach ($params as $att => $key)
          $this->$att = $key;   
    }
    
   public static function fromSqlToUsrDate($date, $delimiter = "/")
   {
       if($date != NULL)
       {
           $dateSqlExp = explode("-", $date);
           return $dateSqlExp[2].$delimiter.$dateSqlExp[1].$delimiter.$dateSqlExp[0];           
       }
       return NULL;

   }


    public static function shortenText(&$source_text, $word_count) 
    { 
        $word_count++; 
        $long_enough = TRUE; 
        if ((trim($source_text) != "") && ($word_count > 0)) 
        { 
            $split_text = explode(" ", $source_text, $word_count); 
            if (sizeof($split_text) < $word_count) 
            { 
                $long_enough = FALSE; 
            } 
            else 
            { 
                array_pop($split_text); 
                $source_text = implode(" ", $split_text); 
            } 
        } 
        return $long_enough; 
    }            
 
    public static function sendMail($to, $subject, $content, $send=true)
    {
        /*$headers   = array();
        $headers[] = "MIME-Version: 1.0";
        $headers[] = "Content-type: text/html; charset=utf-8";
        //$headers[] = "From: Global Movie <no-reply@globalmovie.com>";
        //$headers[] = "Reply-To: Global Movie <no-reply@globalmovie.com>";
        $headers[] = "From: Global Movie <yohanaparodi@gmail.com>";
        $headers[] = "Reply-To: Global Movie <yohanaparodi@gmail.com>";     
        $headers[] = "Subject: {$subject}";
        $headers[] = "X-Mailer: PHP/".phpversion();
        
        if($send)
        return @mail($to, $subject, $content, implode("\r\n", $headers));
        else
            echo "To: ".$to."<br>Subject: ".$subject."<br>Content: ".$content;               
         */
        $ci =& get_instance();
        $ci->load->library('email');
        
        $config['smtp_host'] = 'localhost';
        $config['smtp_user'] = 'yparodi';
        $config['smtp_pass'] = 'PaSSwd2013';
        
        $ci->email->initialize($config);        
    
        $ci->email->from('<no-reply@globalmovieb .com>', 'GlobalMovie');

        $ci->email->to($to);    
            
        $ci->email->subject($subject);
        
        $ci->email->message($content);
        
        $ci->email->set_mailtype('html');
        
        //$ci->email->send();
        
        echo $ci->email->print_debugger();
                
    }   
}
