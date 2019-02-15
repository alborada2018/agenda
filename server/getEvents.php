<?php

 
  include('conexion.php');
  include('sesion.php');


  $usuario = getUsuario(); 
  if($usuario){
   
    $conector = new ConectorBD(
      "localhost",
      "agenda_getEventosUsuario",
      "getev01294u"
    );

    $conexion = $conector->initConexion("agenda_db");
    if($conexion == "OK"){
     
      $sql = "SELECT id, titulo, fecha_inicio, hora_inicio,
        fecha_finalizacion, hora_finalizacion, dia_completo, fk_usuario
        FROM eventos WHERE fk_usuario='".$usuario."'";

      $resQuery = $conector->ejecutarQuery($sql);

      if($resQuery){
       

        while($fila = $resQuery->fetch_assoc()){
         
          $evento = array(); 
          $evento['id'] = $fila['id'];
          $evento['title'] = $fila['titulo'];
          $evento['start'] = $fila['fecha_inicio'];


          if($fila['hora_inicio']){
            $evento['start'] .= "T".$fila['hora_inicio'];
          }

          if($fila['fecha_finalizacion']){
            $evento['end'] = $fila['fecha_finalizacion'];
            if($fila['hora_finalizacion']){
              $evento['end'] .= "T".$fila['hora_finalizacion'];
            }
          }

          $evento['allDay'] = $fila['dia_completo'] == 0 ? false : true;
          $respuesta["eventos"][] = $evento;
        }
        $respuesta['msg'] = "OK"; 

      } else {
        
        $respuesta["msg"] = "ERROR: La consulta SQL para el usuario '.$email.' no se realizó correctamente";
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
