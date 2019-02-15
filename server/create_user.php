<?php
  
  include('conexion.php');

  
  $conector = new ConectorBD(
    "localhost",
    "agenda_crearUsuario",
    "crsususu2224"
  );
  echo "Conectando... " . $conector->initConexion("agenda_db")."<br>";

 
  crearUsuario("'jose@hotmail.com'", "'Jose Antonio Ricaldi'", "123456", "'2019-02-19'", $conector);
  crearUsuario("'antonio@gmail.com'", "'Antonio Dominguez Casas'", "123456", "'2019-02-19'", $conector);
  crearUsuario("'ricaldi@gmail.com'", "'Jorge Ricaldi Perez'", "123456", "'2019-02-19'", $conector);
  $conector->cerrarConexion();

  
  function crearUsuario($email, $nombre, $contrasena, $fechaNacimiento, $conector){
    $contrasenaEncriptada = "'".password_hash($contrasena, PASSWORD_DEFAULT)."'";

    $sql = "INSERT INTO usuarios (email, nombre, contrasena, fecha_nacimiento) ";
    $sql .= "VALUES (".$email.", ".$nombre.", ".$contrasenaEncriptada.", ".$fechaNacimiento.");";

    $respuesta = $conector->ejecutarQuery($sql);
    if($respuesta){
      echo "<br> Usuario ".$nombre." insertado exitosamente.";
    } else {
      echo "<br> Error al insertar el usuario ".$nombre."...<br>";
      echo mysqli_error($conector->conexion)."<br>";
    };
  }



 ?>
