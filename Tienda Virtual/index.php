<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<META HTTP-EQUIV="expires" CONTENT="Sun, 28 Dec 1997 09:32:45 GMT">
	<title></title>
</head>
<body>
<?php
session_cache_limiter();
session_name('cesta');
session_start();
include ("funciones.php");
cabecera('Descansalandia');
echo "<div id=\"contenido\">\n";

if (!isset($_SESSION["tipo"]))
{
	$_SESSION["tipo"]="invitado";
}

if ($_SESSION["tipo"] != "invitado")
{
	echo '<h3> Bienvenido '. $_SESSION["nombre"].'</h3><br>';
}
else
{
	echo "<h3> Bienvenido invitado </h3><br>";
}

$conexion= mysqli_connect("localhost", "root", "", "tiendavirtual_descansalandia")or die("No se conecto a la base de datos");
mysqli_set_charset($conexion,"utf8");
$select= "SELECT cod, nombre from familia"; 
$ConsultaTipo=mysqli_query($conexion,$select) or die ("Error al realizar la consulta al servidor");
$totalFilasTipos= mysqli_num_rows($ConsultaTipo);
$select= "SELECT id, nombre_marca from marcas"; 
$ConsultaMarca=mysqli_query($conexion,$select) or die ("Error al realizar la consulta al servidor");
$totalFilasMarcas= mysqli_num_rows($ConsultaMarca);
echo '<div id="capaBuscador">';
echo '<form action="#" method="post">';
echo '<table width="400"><tr>';
echo "<td>Tipo:</td>";
echo '<td><select name="tipo">';
echo '<option value="todos">Mostrar Todos</option>';

if ($totalFilasTipos !=0)
{
	while ($fila=mysqli_fetch_array($ConsultaTipo,MYSQL_NUM)) 
	{
		echo '<option value="'. $fila[0] .'">'.$fila[1].'</option>';
	}
}

echo "</select></td>";
echo "<td>Marca:</td>";
echo '<td><select name="marca">';
echo '<option value="todos">Mostrar Todos</option>';

if ($totalFilasMarcas !=0)
{
	while ($fila=mysqli_fetch_array($ConsultaMarca,MYSQL_NUM)) 
	{
		echo '<option value="'. $fila[0] .'">'.$fila[1].'</option>';
	}
}

echo "</select></td>";
echo "<td>Precio: </td>";
echo '<td><select name="precio">';
echo '<option value="todos">Mostrar Todos</option>';
echo '<option value="1 AND 500">1-500</option>';
echo '<option value="500 AND 1000">500-1000</option>';
echo '<option value="1000 AND 1500">1000-1500</option>';
echo "</select></td>";
echo "</tr><tr>";
echo "<td>Ordenar por: </td>";
echo '<td><select name="orden">';
echo '<option value="p.nombre">Artículo</option>';
echo '<option value="m.nombre_marca">Marca</option>';
echo '<option value="p.pvp">Precio</option>';
echo '<option value="p.stock">Stock</option>';
echo '<option value="f.nombre">Tipo</option>';
echo "</select></td>";
echo "<td> Sentido: </td>";
echo '<td><select name="sentido">';
echo '<option value="asc">Ascendente</option>';
echo '<option value="desc">Descendente</option>';
echo "</select></td>";
echo "<td> Buscar artículo: </td>";
echo '<td><input type="seach" name="buscador"/><th>';
echo "</tr><tr>";
echo '<td><input type="submit" name="enviar" value="¡Buscar!"/><th>';
echo "</tr></table>";
echo '</form> ';
echo '</div>';
 
if (isset($_POST["enviar"]))
{
	$tipo=$_POST["tipo"];
 	$marca=$_POST["marca"];
 	$precio=$_POST["precio"];
 	$orden=$_POST["orden"];
 	$sentido=$_POST["sentido"];
 	$buscaArti=trim($_POST["buscador"]);
 	$condicion1="";
 	$condicion2="";
 	$condicion3="";

	if ($buscaArti =="")
	{
   		if ($tipo!="todos")
   		{
   			$condicion1= " AND f.cod= '".$tipo."'";
   		}

   		if ($marca!="todos")
   		{
   	  		$condicion2= " AND m.id= '".$marca."'";
   		}

   		if ($precio!="todos")
   		{
   	 		$condicion3= " AND p.pvp between $precio";
   		}
	}
	else
	{
    	$condicion1= " AND p.nombre like '%".$buscaArti."%'";
	}

   	$selectBusqueda= "SELECT p.nombre, f.nombre, m.nombre_marca, p.descripcion, p.pvp, p.stock, p.cod
   					  from productos p, familia f, marcas m
   	 				  where p.familia= f.cod and p.marca= m.id
   	 				  $condicion1 
   	 				  $condicion2
   	 				  $condicion3
   	 				  order by  $orden $sentido";
	$ConsultaBusqueda=mysqli_query($conexion,$selectBusqueda) or die ("Error al realizar la consulta a la base de datos");
	$totalFilasEncontradas= mysqli_num_rows($ConsultaBusqueda);

	if ($totalFilasEncontradas > 0)
	{
		echo '<table cellspacing="50px">';
		while ($fila=mysqli_fetch_array($ConsultaBusqueda,MYSQL_NUM)) 
		{
			//comprobar si la tabla foto tiene la imagen, en caso de que si
		    //se usara la id para la foto, sino se pondra el archivo de no tiene foto
		    $selectFoto="SELECT *
		       			  from fotos 
		       			  where  num_ident = '".$fila[6]."'";
		    $ConsultaFoto=mysqli_query($conexion,$selectFoto) or die ("Error al realizar la consulta a la base de datos"); 
		    $totalFotoEncontrada= mysqli_num_rows($ConsultaFoto);
		 

			if ($totalFotoEncontrada > 0)
			{
				echo '<tr><td><img src="imagenes/'.$fila[6].'.jpg?'.rand().'"/></td>';
				//rand() solo sirve para que el navegador tenga que cargar la imagen nueva y no use la que está en caché guardada
			}
			else
			{
				echo '<tr><td><img src="imagenes/nula.jpg"/></td>';
			}
			
			echo "<td>";
			echo '<table cellspacing="25px">';
			echo "<tr><th>Nombre</th><th>Marca</th><th> Familia </th></tr>";
			echo "<tr><td>".$fila[0]."</td><td>".$fila[2]."</td><td>".$fila[1]."</td><td></td></tr>";
			echo '<tr><th colspan="1">Precio</th><th>Stock</th></tr>';
			echo '<tr><th colspan="1">'.$fila[4]." € </th><th>".$fila[5]."</th></tr>";
			echo '<tr><th>Descripcion</th><td colspan="3">'.$fila[3]."</td></tr>";

			if ($_SESSION["tipo"]=="admin")
			{
				echo '<tr><td> <a href="upload_image.php?id='.$fila[6].'"><img src="imagenes\addFoto.jpg"/></a> </td>';
			}

			if ($_SESSION["tipo"]=="usuario" || $_SESSION["tipo"]=="admin")
			{
				if ($fila[5]>0)
			   	{
			   		echo '<td><a href="carrito.php?id='.$fila[6].'"><img src="imagenes\carrito.png"/></td></tr>';
			    }
			    else
			    {
			    	echo '<td><img src="imagenes\agotado.png"/></td></tr>';
			    }
			}
			echo '</table></td></tr>';
		 }
		echo '</table>';
	}
	else
	{
		echo "No se encontró ningún artículo con esas características";
	}
}
mysqli_close($conexion);
pie();
?>
</body>

</html>