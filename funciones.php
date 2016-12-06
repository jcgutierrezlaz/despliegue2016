<?php

/*
  Función: generaBotonesRadio
  $nombreControl: valor del atributo name de los radios
  $arrayValoresYEtiquetas: array asociativo de pares (valor, etiqueta) para el atributo value de cada radio
  y para el label de cada radio
  $valorSeleccionado: valor del atributo value del elemento seleccionado, si es vacío
  no se selecciona ninguno
 */

function generaBotonesRadio($nombreControl, $arrayValoresYEtiquetas, $valorSeleccionado) {
    $salida = '';
    foreach ($arrayValoresYEtiquetas as $clave => $valor) {
        if ($valorSeleccionado == $clave) {
            $salida .= '<label>' . $valor . '</label><input type="radio" name="' . $nombreControl . '" value="' . $clave . '" checked="checked" />' . PHP_EOL;
        } else {
            $salida .= '<label>' . $valor . '</label><input type="radio" name="' . $nombreControl . '" value="' . $clave . '" />' . PHP_EOL;
        }
    }
    return $salida;
}

/*
  Función: generaSelectSimple
  $nombreControl: valor del atributo name del select
  $arrayValoresYTextos: array asociativo de pares (valor, texto) para el atributo value de cada option
  y para el texto de cada otion
  $valorSeleccionado: un valor del value del option seleccionado
 */

function generaSelectSimple($nombreControl, $arrayValoresYTextos, 
                            $valorSeleccionado) {
    $salida = '';
    $salida = "<select name=\"$nombreControl\">" . PHP_EOL;
    foreach ($arrayValoresYTextos as $clave => $valor) {
        if ($valorSeleccionado == $clave) {
            $salida .= "  <option value=\"$clave\" selected=\"selected\">$valor</option>" . PHP_EOL;
        } else {
            $salida .= "  <option value=\"$clave\">$valor</option>" . PHP_EOL;
        }
    }
    $salida .= '</select>' . PHP_EOL;
    return $salida;
}

/*
  Función: generaSelectMúltiple
  $nombreControl: valor del atributo name del select
  $arrayValoresYTextos: array asociativo de pares (valor, texto) para el atributo value de cada option
  y para el texto de cada otion
  $valoresSeleccionados: un array de valores de los value de los option seleccionados
  $opcionesVisibles: número de opciones visibles
 */

function generaSelectMultiple($nombreControl, $arrayValoresYTextos, $valoresSeleccionados, $opcionesVisibles) {
    $salida = '';
    $salida = "<select name=\"$nombreControl\" multiple=\"multiple\" size=\"$opcionesVisibles\">" . PHP_EOL;
    $contadorValoresSeleccionados = 0;  // cuántos valores seleccionados ya se han recorrido
    $numerovaloresSeleccionados = count($valoresSeleccionados);  // cuántos valores seleccionados se han recibido
    foreach ($arrayValoresYTextos as $clave => $valor) {
        if (($contadorValoresSeleccionados < $numerovaloresSeleccionados) &&
                ($valoresSeleccionados[$contadorValoresSeleccionados] == $clave)) {
            $salida .= "  <option value=\"$clave\" selected=\"selected\">$valor</option>" . PHP_EOL;
            $contadorValoresSeleccionados++;
        } else {
            $salida .= "  <option value=\"$clave\">$valor</option>" . PHP_EOL;
        }
    }
    $salida .= '</select>' . PHP_EOL;
    return $salida;
}

?>