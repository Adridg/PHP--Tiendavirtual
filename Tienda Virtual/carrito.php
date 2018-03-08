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

	if (!isset($_GET["borrar"]))
  	{
  		if (isset($_GET["id"]))
  		{
  			if (isset($_SESSION["carrito"])) // si tengo productos en la cesta	
  			{
  				$dimension=COUNT($_SESSION["carrito"]);

  				if (!in_array($_GET["id"],$_SESSION["carrito"]))
				{
					$select= "SELECT nombre, pvp FROM productos WHERE cod='".$_GET["id"]."'";
					$Consulta=mysqli_query($conexion,$select) or die ("No se ejecuto la consulta de los productos");

					while ($fila=mysqli_fetch_array($Consulta,MYSQL_NUM))
					{
						$_SESSION["contador"]=$_SESSION["contador"]+1;
						$_SESSION["carrito"][]=$_GET["id"];
						$_SESSION["producto"][]= $fila[0];
						$_SESSION["precio"][]=$fila[1];
						$_SESSION["unidades"][]=1;
						$_SESSION["total"]=$_SESSION["total"]+$fila[1]; 
					}
				}
				else
				{
					$select= "SELECT pvp FROM productos WHERE cod='".$_GET["id"]."'";
					$Consulta=mysqli_query($conexion,$select) or die ("No se ejecuto la consulta de los productos");

					while ($fila=mysqli_fetch_array($Consulta,MYSQL_NUM))
					{	
						$indice=array_search($_GET["id"],$_SESSION["carrito"]);
						$_SESSION["unidades"][$indice]=$_SESSION["unidades"][$indice]+1;
						$_SESSION["total"]=$_SESSION["total"]+$fila[0];
					}
				}
  			}
  			else
  			{
			  	//si cesta vacia inicializo las variables de sesión
				$_SESSION["contador"]=1;
				$_SESSION["carrito"][0]=$_GET["id"];
				$select= "SELECT nombre, pvp FROM productos WHERE cod='".$_GET["id"]."'";
				$Consulta=mysqli_query($conexion,$select) or die ("No se ejecuto la consulta de los productos");

				while ($fila=mysqli_fetch_array($Consulta,MYSQL_NUM))
				{
					$_SESSION["producto"][0]= $fila[0];
					$_SESSION["precio"][0]=$fila[1];
					$_SESSION["unidades"][0]=1;
					$_SESSION["total"]=$fila[1];
				}
  			}
		}
		echo "</div>";
		mysqli_close($conexion);
  	}
  	else
  	{
		//borrar del carrito
		$borrarindice=$_GET["valor"];
		$_SESSION["total"]=$_SESSION["total"]-$_SESSION["precio"][$borrarindice]*$_SESSION["unidades"][$borrarindice];
		$_SESSION["contador"]=$_SESSION["contador"]-1;

		if ($_SESSION["contador"]==0)
		{
			unset($_SESSION["contador"]);
			unset($_SESSION["carrito"]);
			unset($_SESSION["producto"]);
			unset($_SESSION["precio"]);
			unset($_SESSION["unidades"]);
			unset($_SESSION["total"]);
		}
		else
		{
			unset($_SESSION["carrito"][$borrarindice]);
			unset($_SESSION["precio"][$borrarindice]);
			unset($_SESSION["producto"][$borrarindice]);
			unset($_SESSION["unidades"][$borrarindice]);
		}
  	}
 	mostrar();
}
else
{
	echo "Debes loguearte o registrarte primero, reediregiendo a la página inicial";
	header("refresh:2; url=index.php", true, 303);
}

function mostrar()
{
	if (isset($_SESSION["producto"]))
	{
		$cabecera='<table border="1" align="center"><caption>Estado de su cesta</caption>';
		$cabecera.= '<tr><th>Articulo</th><th>Unidades</th><th>Precio</th><th>Subtotal</th><th>Borrar?</td></tr>';
		$productos=$_SESSION["producto"];
		$precios=$_SESSION["precio"];
		$unidades=$_SESSION["unidades"];
		$dimension=COUNT($productos);
		echo $cabecera;

		foreach ($productos as $indice=>$valor)
		{
			$mostrar1="<tr><td>".$valor."</td><td>".$unidades[$indice];
			$mostrar1.="</td><td>".$precios[$indice]."</td>"."<td>".$unidades[$indice]*$precios[$indice];
			$mostrar1.="<td width=20><a href=carrito.php?borrar=S&valor=$indice>"."<img id='papelera' src='imagenes/papelera.png' width=\"70%\" heigth=\"70%\"
				 ></a></td></tr>";
		 	echo $mostrar1;
		}

		echo"<tfoot>
	    <tr>
	      <td colspan=3 align='center'>Suma</td>
	      <td>".$_SESSION['total']."</td>
	    </tr>
	  	</tfoot>
		</table>";
		echo "<table id='enlaces'align='center'><tr><td>";
		echo "<a href='index.php'>Seguir Comprando</a>";
		echo "</td><td>";
		echo "<a href='Anular.php'>Anular Compra</a>";
		echo "</td><td>";
		echo "<a href='realizar_Pedido.php'>Confirmar Pedido</a>";
		echo "</td></tr></table>";
	}
	else
	{
		echo "<h2>Cesta vacia</h2>";
	}
}

pie();
?>
</body>
</html>