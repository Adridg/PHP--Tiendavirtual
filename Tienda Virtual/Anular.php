<?php
session_cache_limiter();
session_name('cesta');
session_start();
include ("funciones.php");
cabecera('Descansalandia');
echo "<div id=\"contenido\">\n";

if ($_SESSION["tipo"]=="usuario" || $_SESSION["tipo"]=="admin")
{
	unset($_SESSION["contador"]);
	unset($_SESSION["carrito"]);
	unset($_SESSION["producto"]);
	unset($_SESSION["precio"]);
	unset($_SESSION["unidades"]);
	unset($_SESSION["total"]);
	echo "<h2>Compra Anulada</h2>";
}
else
{
	echo "acceso denegado, volviendo a inicio";
}
header("refresh:2; url=index.php", true, 303);

echo "</div>";
pie();
?>


