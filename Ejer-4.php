<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
            $importe = isset($_POST['importe']) ? $_POST['importe'] : 0;
            $moneda = isset($_POST['moneda']) ? $_POST['moneda'] : "";
            $factor = 1.1;
            $monedas = array('euro' => 'euros', 'dolar' => 'dólares');
                      
            echo "Convertir $importe $monedas[$moneda] a ";
            if ( $moneda ==  'euro' ) {
               echo 'dólares  --> ';
               $res = $importe * 1.1;
               echo $res . " dólares";
            }
            else {
               echo 'euros  --> ';
               $res = $importe / 1.1;
               echo $res . " euros";
            }
           
        ?>
        
    </body>
</html>