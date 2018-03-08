<?php
session_cache_limiter();
session_name('cesta');
session_start();
include ("funciones.php");
cabecera('Descansalandia');
echo "<div id=\"contenido\">\n";

if ($_SESSION["tipo"]=="usuario" || $_SESSION["tipo"]=="admin")
{
	if (isset($_SESSION["carrito"]))
	{
		if (!isset($_POST['enviar']))
		{
	    	if (!isset($_POST['volver']))
	    	{
		    	echo '<form name="#"  method="post">';
				echo "¿Estas seguro de querer realizar el pedidio?<br>";
				echo '<input type="submit" name="enviar" value="Confirmar pedido">';
				echo '<input type="submit" value="volver" name="volver">';
			}
			else
			{
		  		header('Location: index.php');
			}
		}
		else
		{
			//para evitar que las array hayan indices vacios
			foreach ($_SESSION['carrito']as $indice => $valor) 
			{
				$carritosArray[]=$valor;
			}

			foreach ($_SESSION['precio']as $indice => $valor) 
			{
				$preciosArray[]=$valor;
			}

			foreach ($_SESSION['unidades']as $indice => $valor) 
			{
				$unidadesArray[]=$valor;
			}

			$sinStock=false;
			$totalPedido=count($carritosArray);
			$conexion= mysqli_connect("localhost", "root", "", "tiendavirtual_descansalandia")or die("No se conecto a la base de datos");
	 		mysqli_set_charset($conexion,"utf8");
 
	 		for ($i=0; $i <$totalPedido; $i++) 
			{
				$selectStock="Select stock from  productos  where cod= '".$carritosArray[$i]."'";
		 		$ConsultaStock=mysqli_query($conexion,$selectStock) or die ("No se ejecuto la consulta para comprobrar stock");
		 		 
		 		while ($fila=mysqli_fetch_array($ConsultaStock,MYSQL_NUM))
				{
					if ($fila[0]< $unidadesArray[$i])
					{
						$sinStock=true;
					}
				}
			}

			if ($sinStock==false)
			{
				// insert en la tabla pedidios
		 		// total_pedido --> cantidad de productos pedidos
		 		$selectDNI="Select DNI from  clientes  where usuario= '".$_SESSION["usuario"]."'";
		 		$ConsultaDNI=mysqli_query($conexion,$selectDNI) or die ("No se ejecuto la consulta de los productos");

		 		while ($fila=mysqli_fetch_array($ConsultaDNI,MYSQL_NUM))
				{
					$dni=$fila[0];
				}

				$fecha= date("Y-m-d");
				$insert = "INSERT INTO pedidos (num_pedidos, dni, fecha, totalPedidos) VALUES ('', '$dni', '$fecha', '$totalPedido')"; 
				$insertarPedido=mysqli_query($conexion,$insert) or die ("se produjo un error al realizar el pedido");

				//obtener la id del pedido
				$selectUltimoID="Select LAST_INSERT_ID()";
		 		$ConsultaUltimoID=mysqli_query($conexion,$selectUltimoID) or die ("No se ejecuto la consulta de la ID del pedido");

		 		while ($fila=mysqli_fetch_array($ConsultaUltimoID,MYSQL_NUM))
				{
					$idPedido=$fila[0];

				}
				
				for ($i=0; $i <$totalPedido; $i++) 
				{
					//insert en las tabla de lineas
					$insertLineas= "INSERT INTO lineas (num_pedidos, num_linea, producto, precio, cantidad) VALUES ( $idPedido, $i,'". $carritosArray[$i]."',".$preciosArray[$i].",".$unidadesArray[$i].")";
					$realizarInsert=mysqli_query($conexion,$insertLineas) or die ("Error al realizar el pedido");
					//update de la tabla pedidos para restar el stock
					$update="UPDATE productos
					SET stock = stock - ".$unidadesArray[$i]."
					WHERE 
					cod = '".$carritosArray[$i]."'"; 
					$realizarUpdate=mysqli_query($conexion,$update) or die (mysqli_error($conexion));
				}
				//resetear el autonumérico del campo num_linea de la tabla linea ya que el pedido ha finalizado
				$resetearAutoNumerico= "ALTER TABLE lineas AUTO_INCREMENT = 1";
				$realizarReseteo=mysqli_query($conexion,$resetearAutoNumerico) or die ("Error al resetear el autonumérico");

				//resetea el carrito ya que el usuario ha realizado el pedido
				unset($_SESSION["contador"]);
				unset($_SESSION["carrito"]);
				unset($_SESSION["producto"]);
				unset($_SESSION["precio"]);
				unset($_SESSION["unidades"]);
				unset($_SESSION["total"]);
				echo "<h2>Pedido realizado</h2>";
				header("refresh:1; url=index.php", true, 303);
			}
			else
			{
				echo "Hay más cantidad de producto en la cesta que en el stock de la tienda, por favor revise el carrito";
				header("refresh:2; url=index.php", true, 303);
			}
	 		mysqli_close($conexion);
		}
	}
	else
	{
		echo "No puedes realizar pedidos con la cesta vacia";
		header("refresh:2; url=index.php", true, 303);
	}
}
else
{
	echo "Debes loguearte o registrarte primero, reediregiendo a la página inicial";
	header("refresh:2; url=index.php", true, 303);
}
pie();
?>
</body>
</html>