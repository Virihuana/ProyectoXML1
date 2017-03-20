<?php

include "conexionOracle.php";


if( isset($_POST['get']) ){
    $album=$_POST["album"];

    $sql = oci_parse($conn, 'SELECT NOMBRE FROM SONGS WHERE FKALBUM='.$album);
    
    $r=oci_execute($sql,OCI_DEFAULT);

    $tabla="<table><thead><tr>".
            "<th>CANCION</th>".                    
            "</tr></thead>";

    while (($row = oci_fetch_assoc($sql)) != false) {
         $tabla .="<tbody><tr><td>"
                .$row["NOMBRE"] ."</td><td>"                 
                ."</tr></tbody>";
    }
    $tabla .="</table>";
      echo $tabla;

    oci_free_statement($sql); // Libera todos los recursos asociados con una sentencia o cursor
    oci_close($conn); // Cierra una conexión a Oracle
}else{
  echo "ERROR EN INSERT RESPONSABLES";
}

?>
