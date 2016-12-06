<?php
// Función que arroja una excepción
function checkNum($num) {
    if ($num > 1) {
    throw new Exception("Valor debe ser 1 o menor");
  }
  return true;
}

checkNum(2);
?>
