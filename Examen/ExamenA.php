<?php
 session_start();
 
 $email = isset($_POST['email']) ? $_POST['email'] : "";
 $clave = isset($_POST['clave']) ? $_POST['clave'] : "";

?>

<!DOCTYPE html>
<html> 
   <head> 
      <meta charset="utf-8"/>
      <title>Examen A</title>
      <!--   <link rel='stylesheet' type='text/css' href='css/estilos_3.css'> -->
   </head> 
   <body bgcolor="lightblue"> 
      <h3>Login</h3> 
      <form action="" method="post">          
          <label>Correo Electrónico: </label><input type="text" name="email"  
                value="<?php echo $email; ?>"/><br/>  
          <label>Contraseña: </label><input type="password" name="clave"  
                value="<?php echo $clave; ?>"/>  
          <input type="submit" name="Enviar" value="Entrar"/>
      </form>
      <br/>
   </body> 
</html>

<?php
   
if ( isset($_POST['Enviar']) ) { 

    $email = $_POST['email'];
    $clave = $_POST['clave'];
    
    $error = validar_datos($_POST); 
    
    if ( $error == "" ) {   // Validación datos OK
    
       $user = comprobar_credenciales($email, $clave); 
        
       // Si credenciales OK, crear sesión y cookie e invocar siguiente página
       if ( isset($user['usuario']) ) {  
          $_SESSION['usuario'] = $user['usuario'];  // Guardar nombre usuario, no email
          
          // Establecer inicialmente a 1 la cookie nº visitas. Caso contrario, incrementar
          if ( isset($_COOKIE['usuario']) ) 
             setcookie('usuario', $_COOKIE['usuario']+1, time()+3600);
          else
             setcookie('usuario', 1, time()+3600);            
          
          header('Location: operaciones.php');
       }	
       else
          echo "<font color='red'>Usuario/Contraseña no válidos</font></b>";   
         
    } 
    else
       echo "<font color='red'>".$error."</font></b>";    

} // Fin isset($_POST['Enviar'])

// Retorna blanco si se supera la validación. Caso contrario, distinto de blanco 
function validar_datos($datos) {

    $mensaje = "";

    if ( $datos['email'] == "" )
       $mensaje .= "Debe introducir el correo electrónico <br/>";

    if ( $datos['clave'] == "" )
       $mensaje .= "Debe introducir la contraseña <br/>";

    return $mensaje;
}

// Retorna toda la fila encontradoa en la tabla de usuarios o null en caso contrario
function comprobar_credenciales($email, $clave) {

   try {

     $conn = new PDO('mysql:host=localhost;dbname=examen;charset=utf8','dwes','');
     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  

     $stmt = $conn->prepare('SELECT * FROM usuarios WHERE email=:email and password=:clave');
     $stmt->execute(array(':email' => $email, ':clave' => $clave));
     $fila = $stmt->fetch(PDO::FETCH_ASSOC); 

     $stmt->closeCursor();

   } catch (PDOException $ex) {
        print "¡Error!: " . $ex->getMessage() . "<br/>";
        exit;
   }

   return $fila; 
} 
   
?>


