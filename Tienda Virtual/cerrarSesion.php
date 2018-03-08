<?php
session_cache_limiter();
session_name('cesta');
session_start();
include ("funciones.php");
cabecera('Descansalandia');
echo "<div id=\"contenido\">\n";

if ($_SESSION["tipo"]=="usuario" || $_SESSION["tipo"]=="admin")
{
	$_SESSION["usuario"]="";
	$_SESSION["dni"]="";
	$_SESSION["tipo"]="invitado";
	$_SESSION["nombre"]="";
	$_SESSION["direccion"]="";
	$_SESSION["telefono"]="";
	$_SESSION["email"]="";

	//resetea el carrito  al cambiar de usuario
	unset($_SESSION["contador"]);
	unset($_SESSION["carrito"]);
	unset($_SESSION["producto"]);
	unset($_SESSION["precio"]);
	unset($_SESSION["unidades"]);
	unset($_SESSION["total"]);
	 
	echo "<h2>Cerrando sesión</h2>";
}
else
{
	echo "acceso denegado, volviendo a inicio";
}
header("refresh:2; url=index.php", true, 303);
pie();
?>
</body>
</html>