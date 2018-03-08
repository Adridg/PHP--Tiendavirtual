<?php
session_cache_limiter();
session_name('cesta');
session_start();
include ("funciones.php");
cabecera('Descansalandia');
echo "<div id=\"contenido\">\n";

if ($_SESSION['tipo'] == "admin")
{
    if (isset($_POST["idProducto"]))
    {
        //connect to MySQL 
        $conexion= mysqli_connect("localhost", "root", "", "tiendavirtual_descansalandia")or die("No se conecto a la base de datos");
        mysqli_set_charset($conexion,"utf8");
        //en esta ruta especificamos el directorio para las imágenes
        $dir="imagenes";
        //asegurarse que la transferencia del archivo cargado se ha efectuado correctamente
        
        if ($_FILES['uploadfile']['error'] != UPLOAD_ERR_OK)
        {
            switch ($_FILES['uploadfile']['error']) 
            {
                case UPLOAD_ERR_INI_SIZE:
                    die('El tamaño del archivo excede el permitido por la directiva  upload_max_filesize establecida en php.ini. ' );
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    die('El tamaño  del archivo cargado excede el permitido por la directiva  MAX_FILE_SIZE establecida en  el formulario HTML.');
                    break;
                case UPLOAD_ERR_PARTIAL:
                    die('El archivo se ha cargado parcialmente ');
                    break;
                case UPLOAD_ERR_NO_FILE:
                    die('No ha cargado ningún archivo');
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    die('No se encuentra el directorio temporal del servidor ');
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    die('El servidor ha fallado al intentar escribir el archivo en el disco');
                    break;
                case UPLOAD_ERR_EXTENSION:
                    die('Subida detenida por la extensión');
                    break;
            }
        }

        //obtener información de la id del producto
        $idProducto= $_POST["idProducto"];
        //obtener información de la imagen que se acaba de cargar
        $image_caption = $_POST['caption'];
        $image_username = $_POST['username'];
        $image_date = @date('Y-m-d');
        list($width, $height, $type, $attr) =
        getimagesize($_FILES['uploadfile']['tmp_name']);

        // asegurarse de que el archivo cargado es un tipo de imagen admitido
        $error = 'El archivo que vd. ha subido no es de un tipo soportado';
        switch ($type)
        {
            case IMAGETYPE_GIF:
                $image = imagecreatefromgif($_FILES['uploadfile']['tmp_name']) or die($error);
                break;
            case IMAGETYPE_JPEG:
                $image = imagecreatefromjpeg($_FILES['uploadfile']['tmp_name']) or die($error);
    			break;
            case IMAGETYPE_PNG:
                $image = imagecreatefrompng($_FILES['uploadfile']['tmp_name']) or die($error);
    		    break;
            default:
                die($error);
        }

        //para comprobar si ya existe la clave primaria que se usara para guardar la imagen, si existe, se actualiza la información, sino existe se inserta información
    	$selectFoto="SELECT *
    		       	from fotos 
    		       	where  num_ident = '".$idProducto."'";
    	$ConsultaFoto=mysqli_query($conexion,$selectFoto) or die ("Error al realizar la consulta a la base de datos"); 
    	$totalFotoEncontrada= mysqli_num_rows($ConsultaFoto);

    	if ($totalFotoEncontrada > 0) // update informacion de la foto 
    	{
    	   $query = "UPDATE fotos
    				 set image_caption = '".$image_caption."',
    				 image_username = '".$image_username."',
    				 image_date = '".$image_date."'
    				 where num_ident= '".$idProducto."'";			
    	}
    	else // insertar información en la tabla  image 
    	{
    	   $query = 'INSERT INTO fotos
            (num_ident, image_caption, image_username, image_date)VALUES
            ("' . $idProducto . '", "' . $image_caption . '", "' . $image_username . '", "' . $image_date .
            '")';
    	}

        if ($result = mysqli_query($conexion, $query))
        {
            // como  la id del producto es única, podemos usarla como nombre de imagen, así nos aseguramos de no sobrescribir la imagen que no debemos.
            imagejpeg($image, $dir . '/' . $idProducto  . '.jpg');
    	    echo "<h2>Imagen guardada, volviendo a la tienda</h2>";
        }
        else 
        { 
            mysqli_error($conexion);
            echo "<h2>No se ha podido guardar la imagen, volviendo a la tienda</h2>";
        } 
    }
    else
    {
        echo "Debes seleccionar primero un artículo";
    }
}
else
{
    echo "No tienes permiso para acceder a esta página, volviendo al inicio"; 
}

header("refresh:1; url=index.php", true, 303);
pie();
imagedestroy($image);

?>
</body>
</html>