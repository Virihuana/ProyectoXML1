<?php

include "conexionOracle.php";

/*if (!$conn) {    
    $m = oci_error();    
    echo $m['message'], "n";    
    exit; 
} else {  */  
    $sql = oci_parse($conn, 'SELECT album,categoria,year,rutaimagen,nombre,duracion
                              FROM albums, songs
                              WHERE fkalbum=idalbum');
    oci_execute($sql,OCI_DEFAULT);


    while (($result = oci_fetch_assoc($sql)) != false) {
      $arr[]=$result;
    }

    /*$result = oci_fetch_assoc($sql);
    $arr[]=$result;*/
    echo json_encode($arr, true);

    oci_free_statement($sql);
    oci_close($conn);
      /*  $tabla="<table><thead><tr>".
        "<th>Cancion</th>".
        "<th>Categoría</th>".
        "<th>Año</th>". 
        "<th>Album</th>".
        "<th>Image</th>".
        "</tr></thead>";
      
        while (($row = oci_fetch_assoc($sql)) != false) {
          //echo $row["MATRICULA"];
          $tabla .="<tbody><tr><td>"
                  .$row["NOMBRE"] ."</td><td>"
                  .$row["CATEGORIA"] ."</td><td>"
                  .$row["YEAR"] ."</td><td>"
                  .$row["ALBUM"] ."</td><td><img src=".$row["RUTAIMAGEN"]." width='100' height='100'></td>"
                  ."</tr></tbody>";
        }
        $tabla .="</table>";
        echo $tabla;*/
/*} 

oci_close($conn); */

?>
