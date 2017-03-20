<?php
include "conexionOracle.php";

$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp'); // valid extensions
$path = '../uploads/'; // upload directory

if(isset($_FILES['image'])){
	 $img = $_FILES['image']['name'];
	 $tmp = $_FILES['image']['tmp_name'];
	  
	 // get uploaded file's extensions
	 $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
	 
	 // can upload same image using rand function
	 $final_image = rand(1000,1000000).$img;
	 
	 // check's valid format
	 if(in_array($ext, $valid_extensions)){     
		  $path = $path.strtolower($final_image); 

	$sql = oci_parse($conn,"INSERT INTO albums
		    						 VALUES (sec_albums.nextval,:album,:categoria,:year,:ruta)");
		 $album=$_POST["album"];
	 	 $categoria=$_POST["category"];	  
	 	 $year=$_POST["year"];

	 	$cadena = substr($path, 3);
		oci_bind_by_name($sql, ":album", $album);		
		oci_bind_by_name($sql, ":categoria", $categoria);
		oci_bind_by_name($sql, ":year", $year);
		oci_bind_by_name($sql, ":ruta", $cadena);

		$r=oci_execute($sql);

		/*if(*/move_uploaded_file($tmp,$path);/*){*/
			/*$cadena = substr($path, 3);  // devuelve "cde"
			echo "<img src='$cadena' width='100' height='100' />";
		}*/

		oci_commit($conn); // Consigna la transacción pendiente de la base de datos
		oci_free_statement($sql); // Libera todos los recursos asociados con una sentencia o cursor
		oci_close($conn); // Cierra una conexión a Oracle



	 }else{
	  	echo 'invalid file';
	 }
}