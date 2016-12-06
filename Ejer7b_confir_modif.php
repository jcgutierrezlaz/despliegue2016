<?php 

session_start();

if (!isset($_SESSION['usuario']))
    header('Location: Ejer7.php');  

// Inicializar variables a mostrar en formulario
$codigo = '';
$datos = null;
$errUsuario = '';  $errClave = '';
$error = null;
$mensaje ='';

// Tratamiento del formulario
if ( isset($_GET['cod']) ) { 
   $codigo = $_GET['cod']; 
   $datos = obtener_producto($codigo);   
}

if ( isset($_POST['Modificar']) ) {  
   $mensaje = modificar_producto($codigo, $_POST);
   
   // Después de modificar, actualizar nuevos datos a mostrar en formulario
   $datos['nom_prod'] = $_POST['nombre'];
   $datos['pvp'] = $_POST['pvp'];
   $datos['prov'] = $_POST['selProveedor'];
}   
else if ( isset($_POST['Cancelar']) )
   $mensaje = 'Operación cancelada'; 


// Obtiene los datos de un producto para un cierto código recibido como parámetro.   
function obtener_producto($codigo) {

    try
      { 
        $con = new PDO('mysql:host=localhost;dbname=gesventa;charset=utf8','dwes','dwes');
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = 'SELECT * FROM productos where cod = :cod';
        $stmt = $con->prepare($sql);
        $stmt->execute(array(':cod' => $codigo));
        
        $datos = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt->closeCursor();

        return $datos;
        
      } catch(PDOException $e) {
           print "¡Error!: " . $e->getMessage() . "<br/>";
           exit;
      }
}  

function modificar_producto($cod, $prod) {

    $mensaje = '';
    
    try
    { 
        $con = new PDO('mysql:host=localhost;dbname=gesventa;charset=utf8','dwes','');
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $con->prepare('UPDATE productos SET '
                                    . 'nom_prod = :nom_prod, '
                                    . 'pvp = :pvp, '
                                    . 'prov = :prov '
                                    . 'WHERE cod = :cod');
        
        $stmt->execute(array(':nom_prod' => $prod['nombre'], 
                             ':pvp' => $prod['pvp'],
                             ':prov' => $prod['selProveedor'],
                             ':cod' => $cod));
        
        if ( $stmt->rowCount() == 1 )
           $mensaje = 'Modificación correcta.';
        else
           $mensaje = 'Modificación no realizada.';
  
        $stmt->closeCursor();

        return $mensaje;
        
      } catch(PDOException $e) {
           print "¡Error!: " . $e->getMessage() . "<br/>";
           exit;
      }

}  

/* Genera un control select simple con los cifs de los proveedores. Admite un 
   posible parámetro de entrada para indicar si alguno de los cifs está seleccionado.
 */
function lista_proveedores($selec='') {
    
    try
    {  
       $conn = new PDO('mysql:host=localhost;dbname=gesventa;charset=utf8','dwes','');
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

       $sql = 'SELECT cif FROM proveedores';
       $stmt = $conn->prepare($sql);
       $stmt->execute();
       $stmt->setFetchMode(PDO::FETCH_ASSOC);

       // Empezar a generar el control 
       $salida = '';
       $salida .= "<select class=\"form-control\" name='selProveedor'><br/>";
       while ( $prov = $stmt->fetch() ) {
          if ( $prov['cif'] == $selec )
             $salida .= "  <option value='". $prov['cif'] . "' selected=\"selected\">" . $prov['cif']. "</option><br/>"; 
          else    
             $salida .= "  <option value='" . $prov['cif'] ."'>" . $prov['cif']."</option><br/>";
       }
       $salida .= '</select><br/>';

       $stmt->closeCursor();

       return $salida;   

    } catch(PDOException $e) {
         print "¡Error!: " . $e->getMessage() . "<br/>";
         exit;
    }      
}
  

?>

<!-- Parte cliente del script PHP.

     Presenta un formulario de entrada con el nombre y precio del producto, así
     como un control simple para seleccionar el CIF del proveedor.
     En caso de errores de validación después de pulsar el botón Enviar se 
     mantienen los datos introducidos.
     Presenta mensajes de error justo debajo de cada campo del formulario.
     En caso de inserción en BD correcta muestra los datos en forma de tabla. 
-->     

<!DOCTYPE html>

<html>
   <head> 
      <meta charset="utf-8"/>
      <title>Confirmar Modificación</title>
      <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
      <link href="css/estilos.css" rel="stylesheet" media="screen">
   </head> 
   <body> 
      <!--  <script src="http://code.jquery.com/jquery.js"></script>  -->
     <script src="js/bootstrap.min.js"></script> 
     
     <header>
        <?php include_once 'cabecera.php'; ?>
     </header>
     <div class="row" id="principal">    
       <?php include_once 'navegacion.php'; ?> 
        
       <article class="col-xs-12 col-sm-8">
         <div class="panel panel-success">    
           <div class="panel-heading">
              <h3 class="panel-title"><strong>Modificar datos del producto nº <?php echo $codigo; ?></strong>
                Conectado como usuario: <b><?php echo $_SESSION['usuario']; ?></b>
             </h3>
          </div>  
         </div>    
         <br/>  
         <form class="form-horizontal" role="form" action="" method="post">
            
            <div class="form-group">
                <label for="nombre" class="col-xs-2 control-label"> Nombre:</label>
                <div class="col-xs-7">
                <input type="text" class="form-control" name="nombre" id="nombre" 
                     value="<?php echo $datos['nom_prod']; ?>"  
                     placeholder="Nombre Producto"/>
                <p class='text-danger'><?php echo $error['errNombre']; ?></p>
                </div>
            </div>
            <div class="form-group">
                <label for="precio" class="col-xs-2 control-label"> Precio:</label>
                <div class="col-xs-4">
                <input type="text" class="form-control" name="pvp" id="precio" 
                     value="<?php echo $datos['pvp']; ?>"  
                     placeholder="Precio Producto"/>
                <p class='text-danger'><?php echo $error['errPvp']; ?></p>
                </div>
            </div>
            <div class="form-group">
                <label for="proveedor" class="col-xs-2 control-label"> Proveedor:</label>
                 <div class="col-xs-5">
                     <?php echo lista_proveedores($datos['prov']); ?>
                 </div>
            </div>
            
            <div class="col-lg-offset-2 col-lg-10">
                <button type="submit" class="btn btn-primary" name="Modificar" value="Modificar">Modificar</button>
                <button type="submit" class="btn btn-primary" name="Cancelar" value="Cancelar">Cancelar</button>
            </div>
            <br/>       
         </form>
        
       </article>
     
       <article class="col-xs-12 col-sm-8">
           <p class='text-warning'><?php echo $mensaje; ?></p> 
       </article>  
                
     </div>
     <footer>
         <?php include_once 'pie.php'; ?>
     </footer>
    </body>
</html>           