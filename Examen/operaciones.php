<?php
  session_start();  
?>  

<!DOCTYPE html>

<html> 
    <head>
        <meta charset="utf-8"/>
        <title>Examen A</title>
        <!-- <link rel='stylesheet' type='text/css' href='css/estilos_3.css'> -->
    </head>
     
    <body bgcolor="lightgreen">
  
      <h3>Bienvenido usuario <?php echo $_SESSION['usuario']; ?> </h3>
      <h4>Nº visitas del usuario: <?php echo $_COOKIE['usuario']; ?>  </h4>       
 
      <ul>
        <li><a href='consulta.php'>Consulta</a></li>
        <li><a href='#alta.php'>Alta</a></li>
        <li><a href='#baja.php'>Baja</a></li>
        <li><a href='#modificacion.php'>Modificación</a></li>
        <hr/>
        <li><a href='ExamenA.php'>Ir a Inicio</a></li>
      </ul>
 
    </body>
</html>
    	



