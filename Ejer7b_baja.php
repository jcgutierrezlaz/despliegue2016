<?php

session_start();

if (!isset($_SESSION['usuario']))
    header('Location: Ejer7.php');  

$tampag = 7;
$pag = $_GET['pag'];
$inicio = $pag * $tampag;

function mostrar_productos($inicio, $filas) {
 
 $salida = '';
 
 try {
    // Conexión y establecimiento modo de errores
    $conn = new PDO('mysql:host=localhost;dbname=gesventa;charset=utf8','dwes','dwes');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Preparación de la consulta y ejecución
    $sql = 'SELECT * FROM productos LIMIT ' . $inicio . ', ' . $filas;  
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Si hay filas, preparar la salida a presentar
    if ( $stmt->rowCount() > 0 ) {
    
        $salida .= '<table class="table table-striped">
                <tr><th>Código</th><th>Nombre</th><th>Precio</th>
                <th>Proveedor</th><th>Acciones</th></tr>';    

        foreach ( $datos as $fila ) {
            $salida .= "<tr>";
            foreach ( $fila as $v ) 
                $salida .= "<td>".$v."</td>";
       
             $salida .= '<td><a href="Ejer7b_confir_modif.php?cod='.$fila['cod'].'">Modificar<a/>';
             $salida .= '  <a href="Ejer7b_confir_baja.php?cod='.$fila['cod'].'">Borrar<a/></td>';
            $salida .= "</tr>";
        }
        $salida .= "</table>";
    }    
    $stmt->closeCursor();

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
        <title>Modificar/Eliminar Productos</title>
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
                    <h3 class="panel-title"><strong>Modificación/Baja de productos.</strong>
                        Conectado como usuario: <b><?php echo $_SESSION['usuario']; ?></b>
                    </h3>
                </div> 
            </div>    
            <?php $salida = mostrar_productos($inicio, $tampag);
                  if ($salida != "") echo $salida;
            ?> 
            
            <a href="<?php echo $_SERVER['PHP_SELF'].'?pag='; if ($pag>0) echo $pag-1; ?>">Anterior</a>   
            <a href="<?php echo $_SERVER['PHP_SELF'].'?pag='; if ($salida != "") echo $pag+1; ?>">Siguiente</a>
                            
          </article> 
        </div>
        <footer>
           <?php include_once 'pie.php'; ?>
        </footer>
        </div>     
    </body>
</html> 
