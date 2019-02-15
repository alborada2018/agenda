<?php
 
  include('conexion.php');
  include('sesion.php');

  
  $id_evento = $_POST["id"];
  $fecha_inicio = $_POST["start_date"];
  $hora_inicio = isset($_POST["start_hour"]) ? $_POST["start_hour"] : "";
  $fecha_fin = isset($_POST["end_date"]) ? $_POST["end_date"] : "";
  $hora_fin = isset($_POST["end_hour"]) ? $_POST["end_hour"] : "";

  $usuario = getUsuario(); 
  if($usuario){
   
    $conector = new ConectorBD(
      "localhost",
      "agenda_actualizarEvento",
      "actu343536"
    );

    $conexion = $conector->initConexion("agenda_db");

    if($conexion == "OK"){
     
      $sqlConsulta = "SELECT fk_usuario FROM eventos WHERE id=".$id_evento.";";
      $resConsulta = $conector->ejecutarQuery($sqlConsulta);
      if($resConsulta){
        
        $fila = $resConsulta->fetch_assoc();

        if($fila){
          
          if($fila["fk_usuario"] == $usuario){
           
            if($hora_inicio == ""){ 
              $sqlUpdate = "UPDATE eventos SET fecha_inicio='".$fecha_inicio."' WHERE id=".$id_evento.";";
            } else {
              
              $sqlUpdate = "UPDATE eventos SET ";
              $sqlUpdate .= "fecha_inicio='".$fecha_inicio."', ";
              $sqlUpdate .= "fecha_finalizacion='".$fecha_fin."', ";
              $sqlUpdate .= "hora_inicio='".$hora_inicio."', ";
              $sqlUpdate .= "hora_finalizacion='".$hora_fin."' ";
              $sqlUpdate .= "WHERE id=".$id_evento.";";
            }

            $resUpdate = $conector->ejecutarQuery($sqlUpdate);
            if($resUpdate){
              $respuesta["msg"] = "OK";
            } else {
              
              $respuesta["msg"] = "ERROR: La query SQL para actualizar el evento no se ejecutó correctamente.";
            }
          } else {
           
            $respuesta["msg"] = "El evento que se intenta eliminar no pertenece al usuario solicitante.";
          }
        } else {
          
          $respuesta["msg"] = "No se encontró el evento con la id especificada.";
        }
      } else {
        
        $respuesta["msg"] = "ERROR: La consulta SQL no se ejecutó correctamente.";
      }
    } else {
      
      $respuesta["msg"] = "ERROR: El servidor no se pudo conectar a la base de datos";
    }
  } else {
   
    $respuesta["msg"] = "ERROR: No hay una sesión abierta";
  }

  echo json_encode($respuesta);
 ?>
