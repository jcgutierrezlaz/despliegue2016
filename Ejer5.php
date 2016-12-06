<?php

$pobl = 'Madrid';

try
{
  $con = new PDO('mysql:host=localhost;dbname=gesventa','dwes','dwes');
  $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
  // Preparación, ejecución y enlace
  $stmt = $con->prepare('DELETE FROM proveedores WHERE poblacion = :poblacion');
  $stmt->execute(array(':poblacion' => $pobl));
                              
  echo 'Eliminadas ' . $stmt->rowCount() . ' filas';
  
  $stmt->closeCursor();

} catch(PDOException $ex) {
    print "¡Error!: " . $ex->getMessage() . "<br/>";
    exit;
}