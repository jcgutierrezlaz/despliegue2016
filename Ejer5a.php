<?php

  include_once 'class.Ejer6.php';
    
  echo "<html>";
  echo "<head><meta charset='utf-8' /></head><body>";
  echo "<link rel='stylesheet' type='text/css' href='css/estilos_2.css' />";  
    
  $bd = new BD('localhost','gesventa','dwes','dwes');  
  $bd->conectar();
  $con = $bd->getConexion();
  
  echo 'Conexión realizada.';
 
  $bd->cosultar("select * from proveedores");
  
  $prov = $bd->capturar($bd->getSentencia());
    
  echo "<h3>Relación de Proveedores</h3>";
  echo "<table border=1>";
  echo "<tr><th>Cif</th><th>Nombre</th><th>Dirección</th><th>Población</th></tr>";
  foreach ($prov as $item) {
      echo "<tr>";
      echo "<td>".$item['cif']."</td><td>".$item['nom_emp']."</td><td>".$item['direccion'].
                   "</td><td>".$item['poblacion']."</td>";
      echo "</tr>";
  }
   
  echo "</table>";

  echo "</body></html>"; 
      
  $bd->cerrar();
  
  
?>

