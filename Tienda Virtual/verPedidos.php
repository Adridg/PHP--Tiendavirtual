<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
	
</body>
</html>
<?php
session_cache_limiter();
session_name('cesta');
session_start();
include ("funciones.php");
cabecera('Descansalandia');
echo "<div id=\"contenido\">\n";

if ($_SESSION["tipo"]=="usuario" || $_SESSION["tipo"]=="admin")
{
	$conexion= mysqli_connect("localhost", "root", "", "tiendavirtual_descansalandia")or die("No se conecto a la base de datos");
	mysqli_set_charset($conexion,"utf8");

	if ($_SESSION["tipo"]=="admin")
	{
 		$select= "SELECT num_pedidos from pedidos"; 
	}
	else
	{
		$select= "SELECT p.num_pedidos from pedidos p, clientes c where p.dni= c.dni AND c.usuario='".$_SESSION["usuario"]."'";
	}

	$Consulta=mysqli_query($conexion,$select) or die ("Error al realizar la consulta");
	$totalFilas= mysqli_num_rows($Consulta);

	if ($totalFilas !=0)
	{
		echo'<form action="#" method="post">';
		echo '<table width="400"><tr>';
		echo '<td><select name="pedido">';
		while ($fila=mysqli_fetch_array($Consulta,MYSQL_NUM)) 
		{
			echo '<option value="'. $fila[0] .'">'.$fila[0].'</option>';
		}

		echo "</select></td></tr>";
		echo '<tr><td><input type="submit" name="enviar" value="¡Buscar Pedido!"/><td></tr>';
		echo "</table><form><br>";
	}
	else
	{
		echo '<td>No hay pedidos para mostrar</td>';
	}

	if (isset($_POST['enviar']))
	{
		$pedido= $_POST['pedido'];
		$select= "SELECT DISTINCT c.dni , c.nombre, c.direccion, c.telefono, c.email 
				  from pedidos p, clientes c, lineas l 
				  where  c.dni= p.dni and p.num_pedidos =l.num_pedidos and p.num_pedidos= $pedido"; 
		$Consulta=mysqli_query($conexion,$select) or die ("Error al realizar la consulta");
		echo "<p>Identificador del pedido: <strong> ". $pedido ."</strong></p>";
		
		while ($fila=mysqli_fetch_array($Consulta,MYSQL_NUM))
		{
			echo '<table id="tablaDatosUsuario">';
			echo "<caption>Datos del cliente </caption>";
			echo "<tr><th>Nombre</th><td>".$fila[1]."</td></tr>";
			echo "<tr><th>Dni</th><td>".$fila[0]."</td></tr>";
			echo "<tr><th>Dirección</th><td>".$fila[2]."</td></tr>";
			echo "<tr><th>Teléfono</th><td>".$fila[3]."</td></tr>";
			echo "<tr><th>E-mail</th><td>".$fila[4]."</td></tr>";
			echo '</table>';
		}

		echo '<table id="tablaPedidos">';
		echo  "<caption>Datos del pedido </caption>";
		echo "<tr><th>Articulo</th><th>Precio</th><th>Unidades</th><th>Subtotal</th></tr>";

		$select= "SELECT DISTINCT l.producto from pedidos p, lineas l where p.num_pedidos =l.num_pedidos and p.num_pedidos= $pedido"; 
		$Consulta=mysqli_query($conexion,$select) or die ("Error al realizar la consulta");
		$total=0;

		while ($prodLinea=mysqli_fetch_array($Consulta,MYSQL_NUM))
		{
			$selectProducto= "SELECT DISTINCT  p.nombre, p.pvp, l.cantidad from productos p, lineas l where p.cod = l.producto  and l.num_pedidos= $pedido and p.cod='".$prodLinea[0]."'"; 
			$ConsultaProducto=mysqli_query($conexion,$selectProducto) or die ("Error al realizar la consulta");
	
			while ($prod=mysqli_fetch_array($ConsultaProducto,MYSQL_NUM))
			{
				$total+=$prod[2]*$prod[1];
				echo "<tr><td>".$prod[0]."</td><td>".$prod[1]."</td><td>".$prod[2]."</td><td>".$prod[2]*$prod[1]."</td></tr>";
			}
			
		}
		echo '<tr><th colspan=3>Total</th><td>'.$total.'</td></tr>';
		echo "</table>";
 	 }	
 	mysqli_close($conexion);
}
else
{
    echo "Debes loguearte o registrarte primero, reediregiendo a la página inicial";
	header("refresh:2; url=index.php", true, 303);
}
echo "</div>";
pie();
?>
</body>
</html>