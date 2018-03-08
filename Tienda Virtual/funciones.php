<?php
function cabecera($texto) 
{

    print "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"
       \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
  <meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />
  <title>Menú - $texto</title>
  <link href=\"css/miestilo.css\" rel=\"stylesheet\" type=\"text/css\" />
  
</head>

<body>
<div id='envoltorio'>
<div id='cabecera'>
		<div id='titulo'>
			$texto
		</div>
	</div>


<div id=\"menu\">
<ul>
   <font size=1>";
   
  
 if (isset($_SESSION["tipo"]))
 {
  if ($_SESSION["tipo"]=="usuario" || $_SESSION["tipo"]=="admin" )
  {
    print "<li><a href=\"index.php\">Tienda</a></li>";
    print "<li><a href=\"carrito.php\">Ver carrito</a></li>";
    print "<li><a href=\"verPedidos.php\">Pedidos</a></li>"; 
    print "<li><a href=\"datosUsuario.php\">Mis datos</a></li>"; 
    print "<li><a href=\"cerrarSesion.php\">Cerrar sesión</a></li>"; 
  }
  else
 {
   menuInvitado();
 }
}
else
{//este else tiene la finalidad de que el usuario nada más abrir la web vea los menus de inicio de sesión y registro, ya que la variable de sesión hasta que no cambiara de página o refrescara no se crearia
  menuInvitado();
}
print "</font></ul> </div> </div>";
}

function menuInvitado()
{
  print "<li><a href=\"inicioSesion.php\">Iniciar sesión</a></li>";
  print "<li><a href=\"registro.php\">Regístrate</a></li>"; 
  print "<li><a href=\"index.php\">Tienda</a></li>";
}


function pie() 
{
    print '</div>

<div id="pie">
<address>
2º D.A.W. 
</address>

</div>
</body>
</html>';
}


