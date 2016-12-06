<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
            $oper1 = isset($_POST['oper1']) ? $_POST['oper1'] : 0;
            $oper2 = isset($_POST['oper2']) ? $_POST['oper2'] : 0;
            $operacion = isset($_POST['operacion']) ? $_POST['operacion'] : "+";
            
            switch ($operacion) {
                case "+":
                    $res = $oper1 + $oper2;
                    break;
                case "-":
                    $res = $oper1 - $oper2;
                    break;
                case "*":
                    $res = $oper1 * $oper2;
                    break;
                 case ":":
                    $res = $oper1 / $oper2;
                    break;
                default:
                    echo "Operación no permitida.";
            }
            echo $oper1 . " " . $operacion . " " . $oper2 . " = " . $res;       
        ?>
    </body>
</html>