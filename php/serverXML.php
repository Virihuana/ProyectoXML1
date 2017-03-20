<?php
  require_once "lib/nusoap.php";
  header("Content-Type: text/html;charset=utf-8");

  //Para crear el archivo
  function crear($datos){
    $xml = new DomDocument('1.0', 'UTF-8');    

    //le agrego el estilo (XSLT) al xml
    $xslt = $xml->createProcessingInstruction(
                                              'xml-stylesheet',
                                              'type="text/xsl" href="file:///C:/wamp/www/TEMPLATEXML/php/music.xsl"'
                                              );
    $xml->appendChild($xslt);

    $music = $xml->createElement('musica');
    $music = $xml->appendChild($music);

    foreach($datos as $key=>$value){
      foreach($value as $key2=>$value2){
        if($key2=='nombre'){
            $id++;
            $song = $xml->createElement('cancion');
            $song = $music->appendChild($song);            
            $nombre_song = $xml->createElement('titulo', $value2);
            $nombre_song = $song->appendChild($nombre_song);
        }
        if($key2=='album'){     
            $album_nombre = $xml->createElement($key2,$value2);
            $album_nombre = $song->appendChild($album_nombre);
        }
        if($key2=='categoria'){
            $album_nombre->setAttribute($key2, $value2);
        }
        if($key2=='year'){
            $album_nombre->setAttribute($key2, $value2);
        }
        if($key2=='duracion'){
            $duracion = $xml->createElement($key2,$value2);
            $duracion = $song->appendChild($duracion);
        }
      }
    }
    $xml->formatOutput = true;
    $el_xml = $xml->saveXML();

         return $el_xml;
  }
  

  $server = new SOAP_Server;
  $server->soap_defencoding = "UTF-8";
  $server->configureWSDL("serverXML","urn:webservice1");


  // Parametros de entrada
  $server->wsdl->addComplexType(  'datos_album_entrada', 
                                  'complexType', 
                                  'struct', 
                                  'all', 
                                  '',
                                  array('nombre'     => array('name' => 'nombre','type' => 'xsd:string'),
                                        'album'      => array('name' => 'album','type' => 'xsd:string'),
                                        'categoria'  => array('name' => 'categoria','type' => 'xsd:string'),
                                        'year'       => array('name' => 'year','type' => 'xsd:string'),
                                        'duracion'   => array('name' => 'duracion','type' => 'xsd:string')
                                        )
  );

  $server->register('crear', // nombre del metodo o funcion
                    array('datos_album_entrada' => 'tns:datos_album_entrada'), // parametros de entrada
                    array('return' => "xsd:string"), // parametros de salida // parametros de salida
                    'urn:webservice1', // namespace
                    'urn:serverXML#crear', // soapaction debe ir asociado al nombre del metodo
                    'rpc', // style
                    'encoded', // use
                    'Crea el xml a partir de la informacion recibida' // documentation
  );


  $HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
  $server->service($HTTP_RAW_POST_DATA);

?>