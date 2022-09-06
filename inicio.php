<?php
  session_start();
  if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: registro.php");
    exit;
        }
  $active_inicio="active";
  $active_clientes="";
  $active_caja="";
  $active_compras="";
  $active_ventas="";
  $active_productos="";
  $active_usuarios="";
  $titulo="Sistema de Informacion | Deposito La Fortuna";
?>

<!DOCTYPE html>
<html lang="es">
  <head>
  <?php 
    include("encabezado.php");
  ?>
  </head>
  <body>
  <?php
    include("navbar.php");
  ?>
    <div class="container">
      <div class="texto">
        Sistema de informacion Deposito La Fortuna
      </div>
    </div>
  <?php
  include("pie_pagina.php");
  ?>
  <script type="text/javascript" src="js/VentanaCentrada.js"></script>
  </body>
</html>