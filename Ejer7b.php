<?php
  
   session_start();
   
   if (!isset($_SESSION['usuario']))
       header('Location: Ejer7.php');  

?>

<!DOCTYPE html>
  
<html>   
   <head> 
      <meta charset="utf-8"/>
      <title>Ejercicio 7b</title>
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
                      <h3 class="panel-title">
                          <strong>Seleccione Operación.</strong>
                          Conectado como usuario: <b><?php echo $_SESSION['usuario']; ?></b>
                      </h3>
                  </div> 
              </div>    
          </article>    
      </div> 
      <footer>
          <?php include_once 'pie.php'; ?>
      </footer>

   </body>
</html>   
