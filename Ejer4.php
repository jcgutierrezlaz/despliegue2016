<?php

$nombre = 'Ozone';
$pobl = 'Tres Cantos';

try
{
  $con = new PDO('mysql:host=localhost;dbname=gesventa','dwes','dwes');
  $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
  // Preparación 
  $stmt = $con->prepare('UPDATE proveedores SET poblacion = :poblacion '
                                            . 'WHERE nom_emp = :nom');
  // Enlace de parámetros y ejecución
  $stmt->execute(array(':poblacion' => $pobl, ':nom' => $nombre));
                              
  if ( $stmt->rowCount() == 1 )
     echo 'Modificación correcta';
  
  $stmt->closeCursor();

} catch(PDOException $e) {
    print "¡Error!: " . $ex->getMessage() . "<br/>";
    exit;
}