<?php
header('Content-type: '.$_GET['mime']);
$Fachada = Fachada::getInstancia();
$id_adjunto = $_GET['id'];
$from = $_GET['from']; 
switch($from)
{
    case "dato_complementario":
        echo $Fachada->getBlobDatoComplementario($id_adjunto);
        break;
    case "adjunto":
        echo $Fachada->getBlobAdjunto($id_adjunto);
        break;        
}



