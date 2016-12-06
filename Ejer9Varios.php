<?php

session_start();

$poblacion = '';

if ( isset($_POST['Buscar']) ) {
    $poblacion = $_POST['poblacion'];
} 

function mostrar_proveedores($poblacion) {
     
 $salida = '';  
 
 try {
    // Conexión y establecimiento modo de errores
    $conn = new PDO('mysql:host=localhost;dbname=gesventa;charset=utf8','dwes','dwes');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Preparación de la consulta y ejecución 
    $stmt = $conn->prepare('SELECT * FROM proveedores WHERE poblacion = :poblacion');
    $stmt->execute(array(':poblacion' => $poblacion));
    $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Si hay filas, preparar la salida a presentar
    if ( $stmt->rowCount() > 0 ) {
    
        $salida .= '<table class="table table-striped">
             <tr><th>Cif</th><th>Empresa</th><th>Dirección</th><th>Población</th></tr>';    

        foreach ( $datos as $fila ) {
           $salida .= "<tr>";
           foreach ( $fila as $v )
               $salida .= "<td>".$v."</td>";
               $salida .= "</tr>";
        }
        $stmt->closeCursor();

        $salida .= "</table>";
    }
   
    return $salida;
 }
 catch (PDOException $ex) {
    print "¡Error!: " . $ex->getMessage() . "<br/>";
    exit;
 }    

}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8' />
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
                        <h3 class="panel-title"><strong>Relación de productos.</strong>
                         Conectado como usuario: <b><?php echo $_SESSION['usuario']; ?></b>
                        </h3>
                    </div> 
                </div>
            
                <form action="" method="post">
                    Población: <input type="text" name="poblacion" value="" />
                    <input type="submit" name="Buscar" value="Buscar" /> 
                </form>
                <br/>
                <?php $salida = mostrar_proveedores($poblacion);
                  if ($salida != "") echo $salida;
                ?> 
             
            </article>    
        </div>
        <footer>
            <?php include_once 'pie.php'; ?>
        </footer>
             
    </body>
</html> 


