<?php
 
  include('conexion.php');
  include('sesion.php');

 

  $titulo = $_POST["titulo"];
  $fecha_inicio = $_POST["start_date"];
  $dia_completo = $_POST["allDay"];
  $hora_inicio = $_POST["start_hour"];
  $fecha_fin = $_POST["end_date"];
  $hora_fin = $_POST["end_hour"];

  $usuario = getUsuario(); 
  if($usuario){
   
    $conector = new ConectorBD(
      "localhost",
      "agenda_crearEvento",
      "crea65evento912a"
    );

    $conexion = $conector->initConexion("agenda_db");

    if($conexion == "OK"){
     

      
      if($dia_completo === "false"){
        $sql = "INSERT into eventos(titulo, fecha_inicio, hora_inicio,".
          "fecha_finalizacion, hora_finalizacion, dia_completo, fk_usuario)".
          " VALUES('".$titulo."','".$fecha_inicio."','".$hora_inicio."','".$fecha_fin."','".
          $hora_fin."',FALSE,'".$usuario."');";
      } else {
        $sql = "INSERT into eventos(titulo, fecha_inicio, dia_completo, fk_usuario)".
        " VALUES('".$titulo."','".$fecha_inicio."',TRUE,'".$usuario."');";
      }

     
      $resQuery = $conector->ejecutarQuery($sql);

      if($resQuery){
          $respuesta["msg"] = "OK"; 
          
          $respuesta["idEvento"] = $conector->conexion->insert_id;
         
      } else {
          
          $respuesta["msg"] = "ERROR: La query SQL para insertar el nuevo evento '".$titulo."' no se realizó correctamente";

      }
    } else {
     
      $respuesta["msg"] = "ERROR: El servidor no se pudo conectar a la base de datos";
    }
  } else {
   
    $respuesta["msg"] = "ERROR: No hay una sesión abierta";
  }

  $conector->cerrarConexion();
  echo json_encode($respuesta);
 ?>
