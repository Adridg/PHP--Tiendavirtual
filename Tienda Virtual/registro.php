<?php
session_cache_limiter();
session_name('cesta');
session_start();
include ("funciones.php");
cabecera('Descansalandia');
echo "<div id=\"contenido\">\n";

if ($_SESSION["tipo"]!="usuario" && $_SESSION["tipo"]!="admin")
{
	if (!isset($_POST["enviar"]))
	{
		?>
			<form action="#" method="post">
			<table>
			<tr><th>Usuario</th><td><input type="text" name="txtUsuario"/></td></tr>
			<tr><th>Password</th><td><input type="password" name="txtClave"/></td></tr>
			<tr><th>DNI</th><td><input type="text" name="txtDni"/></td></tr>
			<tr><th>Nombre</th><td><input type="text" name="txtNombre"/></td></tr>
			<tr><th>Dirección</th><td><input type="text" name="txtDireccion"/></td></tr>
			<tr><th>Telefono</th><td><input type="text" name="txtTelefono"/></td></tr>
			<tr><th>E-mail</th><td><input type="text" name="txtEmail"/></td></tr>

			<tr><td><input type="submit" name="enviar" value="Registrar"/></td><td><input type="reset" name="resetear"/></td>
			<table>
			</form>
		<?php
	}
	else
	{
		 $dni=$_POST["txtDni"];
		 $nombre=$_POST["txtNombre"];
		 $direccion=$_POST["txtDireccion"];
		 $usuario=$_POST["txtUsuario"];
		 $clave=$_POST["txtClave"];
		 $telefono=$_POST["txtTelefono"];
		 $email=$_POST["txtEmail"];

		//mirar en el servidor si el dni y el usuario ya existen, en caso de que no esten
		//se realizará un insert en la tabla cliente, sino mostrará un mensaje con el error
		if (is_numeric($telefono))
		{
			if ($dni != "" && $nombre !="" && $direccion !=""  && $usuario !="" && $clave !="" && $email !="" )
			{
				$conexion= mysqli_connect("localhost", "root", "", "tiendavirtual_descansalandia")or die("No se conecto a la base de datos");
				mysqli_set_charset($conexion,"utf8");
				$select= "SELECT dni from clientes where dni='".$dni."'"; 
				$ConsultaDNI=mysqli_query($conexion,$select) or die ("No se ejecuto la consulta del dni");
				$totalFilas= mysqli_num_rows($ConsultaDNI);

				if ($totalFilas != 0)
				{
					echo "Ese DNI ya se encuentra en la base de datos";
					header("refresh:2; url=registro.php", true, 303);
				}
				else
				{
					$selectUsu= "SELECT usuario from clientes where usuario='".$usuario."'"; 
					$ConsultaUsu=mysqli_query($conexion,$selectUsu) or die ("No se ejecuto la consulta de usuario");
					$totalFilas2= mysqli_num_rows($ConsultaUsu);

					if ($totalFilas2 != 0)
				 	{
				 		echo "Ese usuario ya existe, por favor vuelva a intentarlo de nuevo";
				 		header("refresh:2; url=registro.php", true, 303);
				 	}
				 	else
				 	{
				 			
				 		$clave= crypt($clave,""); /*El parámetro salt es opcional. Sin embargo, crypt() crea una contraseña débil sin salt. PHP 5.6 o posterior emiten un error de nivel E_NOTICE sin él. Asegúrese de especificar una sal lo suficientemente fuerte para mayor seguridad.*/
				 			
				 		$insert= "INSERT into clientes values ('$dni', '$nombre', '$direccion', '$telefono', '$email', '$usuario', '$clave', 'usuario')";
				 		if($insertBD=mysqli_query($conexion,$insert))
				 		{
				 			echo "<h2>Registro realizado con éxito.</h2><br>";
				 			header("refresh:2; url=index.php", true, 303);		
				 		}
				 		else
				 		{
				 			echo "Fallo en el proceso de registro";
				 			header("refresh:2; url=registro.php", true, 303);
				 		}	
				 	}
			 	}
				mysqli_close($conexion);
		 	}
		 	else
		 	{
		 		echo "No puede haber campos en blanco";
		 		header("refresh:2; url=registro.php", true, 303);
		 	}
		}
		else
		{
			echo "El teléfono debe ser numérico y tener 9 dígito";
			header("refresh:2; url=registro.php", true, 303);
		}
	}
}
else
{
	echo "ya esta registrado en la web";
	header("refresh:2; url=index.php", true, 303);
}
pie();
?>
</body>
</html>