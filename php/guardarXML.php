<?php
  //Para crear el archivo
  if(isset($_POST['insert'])){
        $xml=$_POST["xml"]; 
        $xmlArchivo = simplexml_load_string($xml);
        echo $xmlArchivo->asXML('catalogo.xml');
  }
?>


