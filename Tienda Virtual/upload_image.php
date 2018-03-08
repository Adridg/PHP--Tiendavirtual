
<?xml version="1.0" encoding="iso-8859-1">
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
       "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
session_cache_limiter();
session_name('cesta');
session_start();
include ("funciones.php");
cabecera('Descansalandia');
echo "<div id=\"contenido\">\n";

if ($_SESSION['tipo'] == "admin")
{
	if (isset($_GET["id"]))
 	{
		$idProducto= $_GET["id"];
		?>
	  		<title>Sube la foto del producto al sitio web!</title>
	 		</head>
	 		<body>
	  		<form action="check_imagenes.php" method="post" enctype="multipart/form-data">
	   		<table>
	    	<tr>
	     		<td>Nombre de la foto</td>
	     		<td><input type="text" name="username" /></td>
	    	</tr><tr>
	     		<td>Subir imagenes*</td>
	     		<td><input type="file" name="uploadfile" /></td>
	    	</tr><tr>
	     		<td colspan="2"><small><em>* Admite los formatos: GIF, JPG/JPEG and PNG.</em></small></td>
	    	</tr><tr>
	     		<td>Image Caption<br/></td>
	     		<td><input type="text" name="caption" /></td>
	    	</tr><tr>
	     		<td colspan="2" style="text-align: center">
	      			<input type="hidden" name="idProducto" value="<?php echo $idProducto ?>">
	      			<input type="submit" name="submit" value="Upload"/>
	     		</td>
	    	</tr>
	   		</table>
	  		</form>
		<?php
   }
   else
   {
   		echo "Antes de subir una imagen debes seleccionar el producto";
   		header("refresh:2; url=index.php", true, 303);
   }
}
else
{
	echo "No tienes permiso para acceder a esta página, volviendo al inicio";
	header("refresh:1; url=index.php", true, 303);
}
  pie();
?>
 </body>
</html>