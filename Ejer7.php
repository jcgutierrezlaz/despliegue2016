 <?php 

 session_start();
 
 // Incializar variables
 $errUsuario = '';  $errClave = '';
 $error = '';
 $usuario = ''; $clave = '';
      
/* Tratamiento del formulario. 
 * 
 * Se comprueba que los datos se hayan introducido. Posteriormente, se comprueba
 * si existen en la BD. En caso afirmativo, se crea una cookie con el nombre del
 * usuario y se entra en la aplicación de operaciones.
 */
if ( isset($_POST['Enviar']) ) { 

   $usuario = $_POST['usuario'];
   $clave = $_POST['clave']; 
    
   if ( $usuario == "" ) {
      $errUsuario = 'Por favor, introduzca usuario';
   }
   if ( $clave == "" ) {
      $errClave = 'Por favor, introduzca contraseña';
   }

   if ( $usuario != ""  &&  $clave != "" ) {
      $errUsuario = '';  $errClave = ''; 

      $error = validar_credenciales($usuario, $clave);
      if ( $error == "" )  // Todo OK. Ir a la aplicación de operaciones
      {   
         $_SESSION['usuario'] = $usuario;
         header('Location:Ejer7b.php');
      }   
   }

}

// Accede a la BD para comprobar si los datos introducidos existen.
// Devuelve blanco en caso de éxito. Mensaje de error, en caso contrario.
function validar_credenciales($usuario, $clave) {

    $error = '';
    
    try { 
        $conn = new PDO('mysql:host=localhost;dbname=gesventa;charset=utf8','dwes','dwes');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("select * from usuarios WHERE usr = :usr AND pass = :pass");
        $stmt->execute(array(':usr' => $usuario, ':pass' => $clave));

        $rows = $stmt->fetchAll();    
        $stmt->closeCursor();

        if ( sizeof($rows) == 0 ) 
           $error = "El usuario o la contraseña no son válidos";
        
        return $error;

    } catch(PDOException $e) {
        print "¡Error!: " . $e->getMessage() . "<br/>";
        exit;
    }
    
}
    
?>     

<!-- Parte cliente del script PHP.

     Presenta un formulario de entrada con el usuario y contraseña.
     En caso de errores de validación después de pulsar el botón Enviar, se 
     mantienen los datos introducidos.
     Presenta mensajes de error justo debajo de cada campo del formulario.
-->     

<!DOCTYPE html>
 
<html>
   <head> 
      <meta charset="utf-8"/>
      <title>Ejercicio 7</title>
     <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
   </head> 
   <body> 
    <!--  <script src="http://code.jquery.com/jquery.js"></script>  -->
      <script src="js/bootstrap.min.js"></script> 
      
      <header>
          <?php include_once 'cabecera.php'; ?>
      </header>
      
      <div class="panel panel-success">    
        <div class="panel-heading">
            <h3 class="panel-title">Login</h3>
        </div>  
        <div class="panel-body">    
        <br/>  
      
        <form class="form-horizontal" action="" method="post">
         
          <div class="form-group">
             <label for="usuario" class="col-xs-2 control-label"> Usuario:</label>
             <div class="col-xs-3">
                <input type="text" class="form-control" name="usuario" id="usuario" 
                       value="<?php echo $usuario; ?>"
                       placeholder="Usuario"/>  
                <p class='text-danger'><?php echo $errUsuario; ?></p>
             </div>
          </div>    
          <div class="form-group">
             <label for="clave" class="col-xs-2 control-label"> Contraseña:</label>
             <div class="col-xs-3">
                <input type="password" class="form-control" name="clave" id="clave" 
                        value="<?php echo $clave; ?>"
                        placeholder="Contraseña"/>
                <p class='text-danger'><?php echo $errClave; ?></p>
             </div>
          </div>    
              
          <br/>
          <div class="col-lg-offset-2 col-lg-10">
              <button type="submit" class="btn btn-primary" name="Enviar" value="Enviar">Entrar</button>
          </div>      
          
          <br/>
          <p class='text-danger'><?php echo $error; ?></p>
          
        </form>
        <br/>
       </div>   
      </div>
      
      <br/>
     
      <footer>
          <?php include_once 'pie.php'; ?>
      </footer>
      
   </body> 
</html>      