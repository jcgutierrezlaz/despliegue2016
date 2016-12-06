<?php 

session_start();

if (!isset($_SESSION['usuario']))
   header('Location: Ejer7.php');  

// Inicializar variables a mostrar en formulario
$error = null;
$nombre = ''; $pvp = '';
$tabla = ''; 

// Tratamiento del formulario
if ( isset($_POST['Enviar']) ) { 

   $nombre = $_POST['nombre']; 
   $pvp = $_POST['pvp']; 
    
   $error = validar_datos($_POST);
   
   if ( $error['errNombre'] == "" && $error['errPvp'] == "" ) { // no hay errores
      $tabla = insertar_producto($_POST);
   }  
   
} 
else if ( isset($_POST['Limpiar']) ) {
    $error = null;  $tabla = '';  $nombre = '';  $pvp = '';
}
 

function validar_datos($datos) {
    
    $error = array('errNombre' => '', 'errPvp' => '');
    
    if ( $datos['nombre'] == "" )
       $error['errNombre'] = "Debe introducir el nombre del producto";

    if ( $datos['pvp'] == "" )
       $error['errPvp'] = "Debe introducir el precio del producto";

    if ( $datos['nombre'] != "" && $datos['pvp'] != "" ) {
       if ( !is_numeric($datos['pvp']) )
            $error['errPvp'] = 'Precio:<b>'.$datos['pvp'].'</b> Debe ser numérico <br/>';
       if ( !preg_match('/^[a-zñÑáéíóú\d_\s]{1,28}$/i', $datos['nombre']) )
            $error['errNombre'] = 'Nombre:<b>'.$datos['nombre'].'</b> Debe ser alfanumérico <br/>';
    }
    
    return $error;
}

/* Genera un control select simple con los cifs de los proveedores. Admite un 
   posible parámetro de entrada para indicar si alguno de los cifs está seleccionado.
 */
function lista_proveedores($selec='') {
    try
    {  
       $conn = new PDO('mysql:host=localhost;dbname=gesventa;charset=utf8','dwes','dwes');
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

/* Realiza la inserción en la BD de un producto indicado como parámetro.
 * Devuelve una cadena de caracteres en formato tabla con los datos de la 
 * fila insertada.
 */   
function insertar_producto($producto) {

    $nombre = $producto['nombre'];
    $precio = $producto['pvp'];
    $proveedor = $producto['selProveedor']; 
    
    $salida = '';
    
    try
      { 
        $con = new PDO('mysql:host=localhost;dbname=gesventa;charset=utf8','dwes','');
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = 'SELECT max(cod)+1 as cod FROM productos';
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $codigo = $stmt->fetch();

        $stmt = $con->prepare('INSERT INTO productos VALUES '
                                   . '(:cod, :nom_prod, :pvp, :proveedor)');
        $stmt->execute( array( ':cod' => $codigo['cod'],
                               ':nom_prod' => $nombre,
                               ':pvp' => $precio,
                               ':proveedor' => $proveedor) );

        if ( $stmt->rowCount() == 1 ) {
           $salida .= '<p class="text-center"><h4>Datos insertados</h4></p>'; 
           $salida .= '<table class=" table table-striped"><tr>';  
           $salida .= "<td>".$codigo['cod']."</td><td>".$nombre."</td><td>".
                             $precio."</td/><td>".$proveedor."</td>";
           $salida .= '</tr></table><br>';
        }
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
      <title>Ejercicio 8</title>
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
              <h3 class="panel-title"><strong>Insertar datos de producto.</strong>
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
                     value="<?php echo $nombre; ?>"  
                     placeholder="Nombre Producto"/>
                  <p class='text-danger'><?php echo $error['errNombre']; ?></p>
                </div>
            </div>
            <div class="form-group">
                <label for="precio" class="col-xs-2 control-label"> Precio:</label>
                <div class="col-xs-5">
                  <input type="text" class="form-control" name="pvp" id="precio" 
                     value="<?php echo $pvp; ?>"  
                     placeholder="Precio Producto"/>
                  <p class='text-danger'><?php echo $error['errPvp']; ?></p>
                </div>
            </div>                 
            <div class="form-group">
                <label for="proveedor" class="col-xs-2 control-label"> Proveedor:</label>
                <div class="col-xs-5">
                   <?php if (isset($_POST['selProveedor']))
                      echo lista_proveedores($_POST['selProveedor']); else echo lista_proveedores(); ?>
                </div>
            </div>
            
            <div class="col-lg-offset-2 col-lg-8">
                <button type="submit" class="btn btn-primary" name="Enviar" value="Enviar">Insertar</button>
                <button type="submit" class="btn btn-primary" name="Limpiar" value="Limpiar">Limpiar</button>
            </div>
            <br/>       
          </form>
        
       </article>
      
       <article class="col-xs-12 col-sm-8">  
           <?php echo $tabla; ?> 
       </article>  
         
     </div>
     <footer>
         <?php include_once 'pie.php'; ?>
     </footer>
  </body>
</html>           
         


