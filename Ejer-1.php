<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
            $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : "";
            $apellidos = isset($_GET['apell']) ? $_GET['apell'] : "";
            
            echo "<h2>Datos recibidos vía GET </h2>";           
            echo "Nombre: <b> $nombre </b><br/>";
            echo "Apellidos: <b> $apellidos </b><br/>";       
        ?>
    </body>
</html>