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
			<tr><td><input type="submit" name="enviar" value="iniciar sesión"/></td><td><input type="reset" name="resetear"/></td>
			</table>
			</form>
		<?php
	}
	else
	{
		$usuario=$_POST["txtUsuario"];  
		$clave=$_POST["txtClave"];
		$conexion= mysqli_connect("localhost", "root", "", "tiendavirtual_descansalandia")or die("No se conecto a la base de datos");
		mysqli_set_charset($conexion,"utf8");
		$selectPass= "SELECT password from clientes 
		 				where usuario='".$usuario."'"; 
		$ConsultaPass=mysqli_query($conexion,$selectPass) or die ("No se ejecuto la consulta del password");
		while ($fila=mysqli_fetch_array($ConsultaPass,MYSQL_NUM)) 
		{
			$passBD=$fila[0];
		}
		$totalFilas= mysqli_num_rows($ConsultaPass);
		if ($totalFilas == 0)
		{
			echo "Ese usuario no existe";
			header("refresh:3; url=inicioSesion.php", true, 303);
		}
		else
		{
			$clave=crypt($clave, $passBD);
			if ($clave==$passBD) //si la clave que ha puesto el usuario es la misma que la que está en el servidor
			{
				$select= "SELECT dni, tipo, nombre, direccion, usuario, telefono, email from clientes 
						  where usuario='".$usuario."'
						  and  password='".$clave."'"; 
				//$Consulta=mysqli_query($conexion,$select) or die ("No se ejecuto la consulta del dni");
				if($ConsultaUsu=mysqli_query($conexion,$select))
				{
					//cargamos todos los datos del usuario como variables de sesión (menos usuario y password), para tener ya los datos del usuario y minimizar las consultas a la base de dato para saber los datos del usuario 
					while ($fila=mysqli_fetch_array($ConsultaUsu,MYSQL_NUM)) 
					{
						$_SESSION["dni"]=$fila[0];
						$_SESSION["tipo"]=$fila[1];
						$_SESSION["nombre"]=$fila[2];
						$_SESSION["direccion"]=$fila[3];
						$_SESSION["usuario"]=$fila[4];
						$_SESSION["telefono"]=$fila[5];
						$_SESSION["email"]=$fila[6];
					}
					echo "<h2>Iniciando sesión</h2>";
					header("refresh:2; url=index.php", true, 303);
				}
				else
				{
					echo "No se ejecuto la consulta a la base de datos";
				 	header("refresh:3; url=inicioSesion.php", true, 303);
				}	
		 	} 
			else
			{
				echo "Contraseña incorrecta";
				header("refresh:3; url=inicioSesion.php", true, 303);
			}

		}
		mysqli_close($conexion);
	}
}
else
{
	echo "ya tienes la sesión iniciada, volviendo a la tienda";
	header("refresh:2; url=index.php", true, 303);
}
pie();
?>
</body>
</html>