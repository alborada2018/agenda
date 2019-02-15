<?php
  
  include('conexion.php');
  include('sesion.php');

   
  $idevento = $_POST["id"];

  $usuario = getUsuario(); 
  if($usuario){
    
    $conector = new ConectorBD(
      "localhost",
      "agenda_eliminarEvento",
      "elim8787879a"
    );

    $conexion = $conector->initConexion("agenda_db");

    if($conexion == "OK"){
      
      $sqlConsulta = "SELECT fk_usuario FROM eventos WHERE id=".$idevento.";";
      $resConsulta = $conector->ejecutarQuery($sqlConsulta);
      if($resConsulta){
        
        $fila = $resConsulta->fetch_assoc();
        if($fila){
          
          if($fila["fk_usuario"] == $usuario){
            
            $sqlDelete = "DELETE FROM eventos WHERE id=".$idevento.";";
            $resDelete = $conector->ejecutarQuery($sqlDelete);
            if($resDelete){
              $respuesta["msg"] = "OK"; 
            } else {
              
              $respuesta["msg"] = "ERROR: La query SQL para eliminar el evento no se ejecutó correctamente.";
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

  $conector->cerrarConexion();
  echo json_encode($respuesta);
 ?>
