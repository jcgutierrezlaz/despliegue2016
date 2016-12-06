<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8' />
        <link rel='stylesheet' type='text/css' href='css/estilos_2.css' />
    </head>    
    <body>
      
        <h3>Relación de Proveedores</h3>
        <table border=1>
            <tr><th>Cif</th><th>Nombre</th><th>Dirección</th><th>Población</th></tr>    
<?php

    try {
       // Conexión y establecimiento modo de errores
       $conn = new PDO('mysql:host=localhost;dbname=gesventa;charset=utf8','dwes','dwes');
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
       // Preparación de la consulta y ejecución
       $stmt = $conn->prepare('SELECT * FROM proveedores');
       $stmt->execute();
       
       // Se recoge cada fila en modo asociativo
       while ( $fila = $stmt->fetch(PDO::FETCH_ASSOC) ) {
          echo "<tr>";
          foreach ( $fila as $v )
             echo "<td>".$v."</td>";
          echo "</tr>";
       }
       echo "</table>";
        
       echo "Número filas: <b>" . $stmt->rowCount() . "</b>";
        
       $stmt->closeCursor();
    }
    catch (PDOException $ex) {
       print "¡Error!: " . $ex->getMessage() . "<br/>";
       exit;
    }    
?>
      
    </body>
</html> 
