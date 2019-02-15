<?php
  $email = $_POST["username"];
  $contrasena = $_POST["password"];

  
  include('conexion.php');
  include('sesion.php');

  
  $conector = new ConectorBD(
    "localhost",
    "agenda_login",
    "contrausuanon341"
  );
  $conexion = $conector->initConexion("agenda_db");

  if($conexion == "OK"){
    
    $sql = "SELECT contrasena FROM usuarios WHERE email='".$email."';";
    $resQuery = $conector->ejecutarQuery($sql);

    if($resQuery){
      
      $fila = $resQuery->fetch_assoc();
      if($fila){
       
        $hash = $fila["contrasena"];
        if(password_verify($contrasena, $hash)){
          
          login($email); 
          $respuesta["msg"] = "OK"; 
        } else {
         
          $respuesta["msg"] = "Contraseña incorrecta";
        }
      } else {
        
        $respuesta["msg"] = "No se encontró al usuario ".$email." en la base de datos";
      };
    } else {
      
      $respuesta["msg"] = "ERROR: La consulta SQL para el usuario '.$email.' no se realizó correctamente";
    }
  } else {
    
    $respuesta["msg"] = "ERROR: El servidor no se pudo conectar a la base de datos";
  }
  $conector->cerrarConexion();
  echo json_encode($respuesta);
 ?>
