<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
            $nota = isset($_POST['nota']) ? $_POST['nota'] : 0;
            
            echo $nota . " --> <b>";
            if ($nota < 5)
                echo "SUSPENSO";
            else if ($nota < 6.1)
                echo "APROBADO";
            else if ($nota < 7.1)
                echo "BIEN";
            else if ($nota < 8.5)
                echo "NOTABLE";
            else 
                echo "SOBRESALIENTE";       
        
           echo "</b>"; 
        ?>
        
    </body>
</html>