<?php

class BD
{
    private $host;
    private $db;
    private $usuario;
    private $pwd;
    
    private $conexion;
    private $sentencia;
 
 function __construct($host, $db, $usuario, $pwd) {
     $this->host = $host;
     $this->db = $db;
     $this->usuario = $usuario;
     $this->pwd = $pwd;
 }      
    
 public function conectar() {
  
    $sql = "mysql:host=";
    $sql .= $this->host;
    $sql .= ";dbname=".$this->db;
    $sql .= ";charset=utf8";
 
    try {
        $this->conexion = new PDO($sql, $this->usuario, $this->pwd);
        $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
    }  catch(PDOException $e) {
      print "¡Error!: " . $e->getMessage() . "<br/>";
      exit;
    }
    
  }
  
  public function cosultar($sql) {
 
    try {  
        $this->sentencia = $this->conexion->prepare($sql);
        $this->sentencia->execute();
        $this->sentencia->setFetchMode(PDO::FETCH_ASSOC);
        
     }  catch(PDOException $e) {
      print "¡Error!: " . $e->getMessage() . "<br/>";
      exit;
    }
  }
  
  public function capturar() {
 
    try { 
        $datos = $this->sentencia->fetchAll();
        
     }  catch(PDOException $e) {
      print "¡Error!: " . $e->getMessage() . "<br/>";
      exit;
    } 
    
    return $datos;
  }
  
  public function cerrar() {
      $this->sentencia->closeCursor();
  }
  
  public function getConexion() {
      return $this->conexion;
  }
  
   public function getSentencia() {
      return $this->sentencia;
  }
  
}