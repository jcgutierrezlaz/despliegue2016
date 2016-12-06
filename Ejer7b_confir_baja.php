<?php 

session_start();

if (!isset($_SESSION['usuario']))
    header('Location: Ejer7.php');  

// Inicializar variables a mostrar en formulario
$codigo = '';
$datos = null;
$mensaje ='';

// Tratamiento del formulario
if ( isset($_GET['cod']) ) { 
   $codigo = $_GET['cod']; 
   $datos = obtener_producto($codigo);   
}

if ( isset($_POST['Confirmar']) )   
   $mensaje = modificar_producto($codigo);
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

function eliminar_producto($codigo) {

    $mensaje = '';
    
    try
      { 
        $con = new PDO('mysql:host=localhost;dbname=gesventa;charset=utf8','dwes','');
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $con->prepare('DELETE FROM productos WHERE cod = :cod');
        $stmt->execute(array(':cod' => $codigo));
                              
        $mensaje = 'Eliminación correcta.';
  
        $stmt->closeCursor();

        return $mensaje;
        
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
              <h3 class="panel-title"><strong>Eliminar el producto nº <?php echo $codigo; ?></strong>
                Conectado como usuario: <b><?php echo $_SESSION['usuario']; ?></b>
             </h3>
         </div>  
        </div>    
        <br/>  
        <form class="form-horizontal" role="form" action="" method="post">
            
           <p class="text-center"><h4>Datos a eliminar</h4></p>
           <table class=" table table-striped">
               <tr>  
                  <td><?php echo $datos['cod']; ?></td>
                  <td><?php echo $datos['nom_prod']; ?></td>
                  <td><?php echo $datos['pvp']; ?></td>
                  <td><?php echo $datos['prov']; ?></td>
               </tr> 
           </table>
           <br>
           <div class="col-lg-offset-2 col-lg-10">
               <button type="submit" class="btn btn-primary" name="Confirmar" value="Confirmar">Confirmar</button>
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
