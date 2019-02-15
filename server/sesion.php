<?php

  
  function login($usuario){
    session_start();
    $_SESSION["usuarioLogueado"] = $usuario;
  }

  
  function logout(){
    session_close();
  }

 
  function getUsuario(){
    session_start();
    return $_SESSION["usuarioLogueado"];
  }
 ?>
