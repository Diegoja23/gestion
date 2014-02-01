<?php
header('Content-type: '.$_GET['mime']);
header("Content-Disposition: inline; filename=".$_GET['nombre'].".".$_GET['mime']);
$Fachada = Fachada::getInstancia();
$id_adjunto = $_GET['id'];
$from = $_GET['from']; 
switch($from)
{
    case "dato_complementario":
        $blob = $Fachada->getBlobDatoComplementario($id_adjunto);
        break;
    case "adjunto":
        $blob = $Fachada->getBlobAdjunto($id_adjunto);                
        break;        
}

header("Content-Length: ".strlen($blob)); 
echo $blob;