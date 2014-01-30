<?php

     require_once(DOMPDFPATH."dompdf_config.inc.php");
     
     if(!isset($_POST['plantilla_value']) || $_POST['plantilla_value'] == '')
        die("No se obtuvo información para generar el Pdf");
     
      $html= $_POST['plantilla_value'];
      $nombre= ($_POST['plantilla_nombre'] != '') ? $_POST['plantilla_nombre'] : "nuevo_archivo";
      if ( get_magic_quotes_gpc() )
        $html = stripslashes($html);
      
      $dompdf = new DOMPDF();
      $dompdf->load_html($html);
      $dompdf->set_paper("a4", "portrait");
      $dompdf->render();
    
      $dompdf->stream($nombre.".pdf", array("Attachment" => false));
    
      exit(0);   
      
      
?>      