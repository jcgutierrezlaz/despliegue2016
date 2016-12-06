<?php
    session_start();   
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Examen A</title>
        <link rel='stylesheet' type='text/css' href='css/estilos_2.css' />
    </head>  
        
    <body>
        <h3>Usuario conectado: <?php echo $_SESSION['usuario']; ?></h3>      
        <h4>Nº visitas del usuario: <?php echo $_COOKIE['usuario']; ?></h4>
    
        <h3>Relación de empleados</h3>
        <table border=1>
            <tr><th>ID</th><th>Nombre</th><th>Teléfono</th></tr>
            <?php echo mostrar_filas(); ?>
        </table>
        <br/>
    
        <a href='<?php echo $_SERVER['HTTP_REFERER']; ?>'>Regresar menú anterior</a>
        <br/><br/>
        <a href='ExamenA.php'>Ir a Inicio</a>
    </body>
</html>

<?php

    function mostrar_filas() {
      
      $salida = '';  

      try {   
        $conn = new PDO('mysql:host=localhost;dbname=examen;charset=utf8','dwes','');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              
        $stmt = $conn->prepare('SELECT * FROM empleados');
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();  
        
        while ( $empl = $stmt->fetch() ) {
           $salida .= "<tr>";
           $salida .= "<td>".$empl['id']."</td><td>".$empl['nombre'].
                      "</td><td>".$empl['telefono']."</td>";
           $salida .= "</tr>";
        }
        
        $stmt->closeCursor();
        
        return $salida;

      } catch (PDOException $ex) {
          print "¡Error!: " . $ex->getMessage() . "<br/>";
          exit;
      }
  }   
?>
