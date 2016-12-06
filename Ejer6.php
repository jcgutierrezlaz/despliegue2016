           <?php

$datos = array('cif' => 'B0041567I', 'nom_emp' => 'Toshiba España', 
    'direccion' => 'Carretera Fuencarral, 46', 'poblacion' => 'Alcobendas');

try
{
   $con = new PDO('mysql:host=localhost;dbname=gesventa;charset=utf8','dwes','dwes');
   $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
   $stmt = $con->prepare('INSERT INTO proveedores (cif, nom_emp, direccion, poblacion) '
          . 'VALUES (:cif, :nom_emp, :direccion, :poblacion)');
   $stmt->execute($datos);
  
   if ( $stmt->rowCount() == 1 )
      echo 'Inserción correcta';
  
   $stmt->closeCursor();
  
} catch(PDOException $e) {
     print "¡Error!: " . $e->getMessage() . "<br/>";
     exit;
}