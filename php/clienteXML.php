<?php
  include "conexionOracle.php";
  require_once "lib/nusoap.php"; //pongo la direccion de donde esta mi carpeta lib
  
  header("Content-Type: text/html;charset=utf-8");

  $sql = oci_parse($conn, 'SELECT album,categoria,year,nombre,duracion
                            FROM albums, songs
                            WHERE fkalbum=idalbum');
  oci_execute($sql,OCI_DEFAULT);

  $albums = array();

  while (($result = oci_fetch_assoc($sql)) != false) {
    $albums[] =  array('nombre' => $result["NOMBRE"],
                        'album' => $result["ALBUM"],
                        'categoria' => $result["CATEGORIA"],
                        'year' => $result["YEAR"],
                        'duracion' => $result["DURACION"]);
  }

  oci_free_statement($sql);
  oci_close($conn);

  $cliente = new nusoap_client('http://localhost/TEMPLATEXML/php/serverXML.php');
  //$cliente = new nusoap_client('http://hpc.izt.uam.mx/~fernando/ws/serverXML.php?wsdl');

  $error = $cliente->getError();
  if($error){
    echo "<h2>Constructor error</h2><pre>".$error."</pre>";
  }
 

  $datos_album_entrada = array("datos_album_entrada" => $albums);

  $resultado = $cliente->call('crear',$datos_album_entrada);
   
  print_r($resultado);

?>
