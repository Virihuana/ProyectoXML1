<?php
include "conexionOracle.php";


if(isset($_POST['insert'])){

	    $sql = oci_parse($conn,"INSERT INTO songs VALUES (sec_songs.nextval,:nombre,:duracion,:album)");
	    $nombre=$_POST["song"];
	    $duracion=$_POST["duracion"];
	    $album=$_POST["album"];	    
	 	 
	    oci_bind_by_name($sql, ":nombre", $nombre);
	    oci_bind_by_name($sql, ":duracion", $duracion);
	    oci_bind_by_name($sql, ":album", $album);	

	    $r1=oci_execute($sql);
		
		oci_commit($conn); // Consigna la transacción pendiente de la base de datos
		oci_free_statement($sql); // Libera todos los recursos asociados con una sentencia o cursor
		oci_close($conn); // Cierra una conexión a Oracle

}