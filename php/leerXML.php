 <?php
    echo "<p><b>El XML consta con los siguientes elementos:</b></p>";  
    $xml = simplexml_load_file('catalogo.xml');
    $salida ="";
  
    foreach($xml->cancion as $item){
      $salida .=
        "<b>Canción:</b> " . $item->titulo . "<br/>".
        "<b>Album:</b> " . $item->album . "<br/>".
        "<b>Duración:</b> " . $item->duracion . "<br/>"."<hr/>";
    }
    echo $salida;
?>