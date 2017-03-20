<?php

include "conexionOracle.php";

$sql = oci_parse($conn, 'SELECT * FROM ALBUMS');
oci_execute($sql,OCI_DEFAULT);

    while (($row = oci_fetch_assoc($sql)) != false) {            
       $select .="<option value=".$row["IDALBUM"].">"
             .$row["ALBUM"].
             "</option>";
    }
    echo $select;

?>

