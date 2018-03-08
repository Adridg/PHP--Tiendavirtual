<?php
session_cache_limiter();
session_name('cesta');
session_start();
include ("funciones.php");
cabecera('Descansalandia');
echo "<div id=\"contenido\">\n";

if ($_SESSION["tipo"]=="usuario" || $_SESSION["tipo"]=="admin")
{
	if (!isset($_POST["enviar"]))
	{
		?>
			<h2>Mis Datos</h2><br>
			<form action="#" method="post">
			<table>
			<tr><th>Usuario</th><td><input type="text" name="txtUsuario" value="<?php echo $_SESSION['usuario'] ?>"/></td></tr>
			<tr><th>Password</th><td><input type="password" name="txtClave"/></td></tr> <!--por tema de seguridad no aparecera la clave del usuario-->
			<tr><th>Dirección</th><td><input type="text" name="txtDireccion" value="<?php echo $_SESSION["direccion"] ?>"/></td></tr>
			<tr><th>Telefono</th><td><input type="text" name="txtTelefono" value="<?php echo $_SESSION["telefono"] ?>"/></td></tr>
			<tr><th>E-mail</th><td><input type="text" name="txtEmail" value="<?php echo $_SESSION["email"] ?>" /></td></tr>
			<tr><td><input type="submit" name="enviar" value="Modificar"/></td><td><input type="reset" name="resetear"/></td>
			<table>
			</form>
		<?php
	}
	else
	{
		/*antes de hacer el update mirar si el usuario ya existe, si existe dar un error, si no existe efectuar el update*/
		$conexion= mysqli_connect("localhost", "root", "", "tiendavirtual_descansalandia")or die("No se conecto a la base de datos");
		mysqli_set_charset($conexion,"utf8");
		$select= "SELECT usuario from clientes 
				  where usuario='".$_POST["txtUsuario"]."'"; 
		$Consulta=mysqli_query($conexion,$select) or die ("No se ejecuto la consulta del dni");
		$totalFilas= mysqli_num_rows($Consulta);
		if ($totalFilas != 0 && $_SESSION["usuario"] != $_POST["txtUsuario"])
		{
			echo "Ese usuario ya existe, por favor elige otro nombre de usuario";
			header("refresh:2; url=datosUsuario.php", true, 303);
		}
	  	else
	  	{
			if ($_POST["txtDireccion"] !="" && is_numeric($_POST["txtTelefono"]) && $_POST["txtEmail"] !="" &&  $_POST["txtUsuario"] !="" )
		 	{
				//hacemos el update
		    	if ($_POST ["txtClave"]=="")
		    	{
					$update= "UPDATE clientes
							  set direccion='".$_POST["txtDireccion"]."',
			 				  telefono='".$_POST["txtTelefono"]."',
			 				  email='".$_POST["txtEmail"]."',
			 				  usuario='".$_POST["txtUsuario"]."'
			 				  where dni='".$_SESSION["dni"]."'";
			  	}
			  	else
			  	{
			  		$clave= crypt($_POST["txtClave"],"");
			  		$update= "UPDATE clientes
			 				  set direccion='".$_POST["txtDireccion"]."',
			 				  telefono='".$_POST["txtTelefono"]."',
			 				  email='".$_POST["txtEmail"]."',
			 				  usuario='".$_POST["txtUsuario"]."',
			 				  password='".$clave."'
			 				  where dni='".$_SESSION["dni"]."'";
				}

				if ($updateBD=mysqli_query($conexion,$update))
				{
					//una vez realizado la modi´ficación, actualizamos las variables de sesión con los nuevos datos
					echo "<h2>Modificación realizada con éxito</h2>";
			 		$_SESSION["direccion"]=$_POST["txtDireccion"];
			 		$_SESSION["usuario"]=$_POST["txtUsuario"];
			 		$_SESSION["telefono"]=$_POST["txtTelefono"];
			 		$_SESSION["email"]=$_POST["txtEmail"];
			 		header("refresh:2; url=index.php", true, 303);
			 	}
			  	else
			  	{
					echo "Fallo en la modificación";
					header("refresh:2; url=datosUsuario.php", true, 303);
				}	
	  		}
			else
			{
	 	 		echo "No puedes dejar los campos: usuario, email, telefono y dirección en blanco, y el campo teléfono debe ser numérico";
	 	 		header("refresh:2; url=datosUsuario.php", true, 303);
			}
	 	}
		mysqli_close($conexion);
	}
}
else
{
	echo "acceso denegado, volviendo a inicio";
	header("refresh:2; url=index.php", true, 303);
}
pie();
?>
</body>
</html>