<?php

$usuario = isset($_POST['usuario']) ? $_POST['usuario'] : null;
$clave = isset($_POST['clave']) ? $_POST['clave'] : null;

$encontrado = comprobar_credenciales($usuario, $clave); 

if ( $encontrado == true ) {   
   echo "BIENVENIDO<br/>";    
   echo "<a href='Ejer-5a.php'>Retornar</a>";
}	
else  {
   header('Location:Ejer-5.html'); 	
}

   

function comprobar_credenciales($usuario, $clave) {

    $credenciales = array(
    'ana' => array('nombre' => 'Ana', 'apell' => 'García', 'clave' => 'a4a97ffc170ec7ab32b85b2129c69c50'),
    'jose' => array('nombre' => 'Jose', 'apell' => 'González', 'clave' => '10dea63031376352d413a8e530654b8b'),
    'marga' => array('nombre' => 'Margarita', 'apell' => 'Ayuso', 'clave' => '35559e8b5732fbd5029bef54aeab7a21'),
    'anton' => array('nombre' => 'Antonio', 'apell' => 'Merino', 'clave' => 'C707dce7b5a990e349c873268cf5a968')
    );
       
      $enc = false;
      foreach ($credenciales as $item => $valor) {
         if ( $usuario == $item  && md5($clave) == $valor['clave'] ) {
             $enc = true; 
             break;
         }           
      }
      
      return $enc;
  }

