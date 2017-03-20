  //Para crear el archivo
  function crear($datos){
    $xml = new DomDocument('1.0', 'UTF-8');
    $catalogo = $xml->createElement('catalogo');
    $catalogo = $xml->appendChild($catalogo);

    foreach($datos as $key=>$value){
      foreach($value as $key2=>$value2){
        if($key2=='album'){
            $album = $xml->createElement($key2);
            $album->setAttribute('nombre',$value2);
            $album = $catalogo->appendChild($album);           
            /*$album_nombre = $xml->createElement('nombal',$value2);
            $album_nombre = $album->appendChild($album_nombre);*/
        }
        if($key2=='categoria'){
            $nodo_categoria = $xml->createElement($key2, $value2);
            $nodo_categoria = $album->appendChild($nodo_categoria);
        }
        if($key2=='year'){
            $nodo_anio = $xml->createElement($key2, $value2);
            $nodo_anio = $album->appendChild($nodo_anio);
        }
        if($key2=='nombre'){
            $nodo_cancion = $xml->createElement($key2, $value2);
            $nodo_cancion = $album->appendChild($nodo_cancion);
            $nodo_cancion2 = $xml->createElement($key2, 'hola');
            $nodo_cancion2 = $album->appendChild($nodo_cancion2);
        }
      }
    }



      function crear($datos){
    $xml = new DomDocument('1.0', 'UTF-8');
    $catalogo = $xml->createElement('catalogo');
    $catalogo = $xml->appendChild($catalogo);
    $id=0;

    $nomAlbumAux="";
    foreach($datos as $key=>$value){
      foreach($value as $key2=>$value2){
        if($key2=='album'){



          
            $id++;
            $album = $xml->createElement($key2);
            $album = $catalogo->appendChild($album);
            $album->setAttribute('id',$id);
            $album = $catalogo->appendChild($album);         
            $album_nombre = $xml->createElement('nomalbum',$value2);
            $album_nombre = $album->appendChild($album_nombre);
        }
        if($key2=='categoria'){
            $nodo_categoria = $xml->createElement($key2, $value2);
            $nodo_categoria = $album->appendChild($nodo_categoria);
        }
        if($key2=='year'){
            $nodo_anio = $xml->createElement($key2, $value2);
            $nodo_anio = $album->appendChild($nodo_anio);
        }
        if($key2=='nombre'){
            $nodo_cancion = $xml->createElement($key2, $value2);
            $nodo_cancion = $album->appendChild($nodo_cancion);
            $nodo_cancion->setAttribute('duracion','1:10');
            $nodo_cancion2 = $xml->createElement($key2, 'hola');
            $nodo_cancion2 = $album->appendChild($nodo_cancion2);
        }
      }
    }

    $xml->formatOutput = true;
    $el_xml = $xml->saveXML();
    $xml->save('catalogoNew.xml');
    /*return "<p><b>El XML ha sido creado.... Mostrando en texto plano:</b></p>".
         htmlentities($el_xml)."<br/><hr>";*/
         return $el_xml;
  }