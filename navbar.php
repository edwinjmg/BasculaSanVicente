<?php
		if (isset($titulo))
		{
?>
<nav class="navbar navbar-default ">
  <div class="container-fluid">
    <!-- El logotipo y el icono que despliega el menú se agrupan
       para mostrarlos mejor en los dispositivos móviles -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Desplegar Navegacion</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Deposito La Fortuna</a>
    </div>
    <!-- Agrupar los enlaces de navegación, los formularios y cualquier
       otro elemento que se pueda ocultar al minimizar la barra -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">

        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"> Compras <b class="caret"></b>
        </a>
          <ul class="dropdown-menu">
            <li class="<?php echo $active_compras;?>"><a href="nueva_compra.php"><i class='glyphicon glyphicon-plus'></i> Nueva Compra</a></li>
            <li class="<?php echo $active_compras;?>"><a href="compras.php"><i class='glyphicon glyphicon-th-list'></i> Compras</a></li>
          </ul>
        </li>
        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"> Ventas <b class="caret"></b>
        </a>
          <ul class="dropdown-menu">
            <li class="<?php echo $active_ventas;?>"><a href="nueva_venta.php"><i class='glyphicon glyphicon-plus'></i> Nueva Venta</a></li>
            <li class="<?php echo $active_ventas;?>"><a href="ventas.php"><i class='glyphicon glyphicon-th-list'></i> Ventas</a></li>
          </ul>
        </li>
         <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"> Caja <b class="caret"></b>
        </a>
          <ul class="dropdown-menu">
            <li class="<?php echo $active_caja;?>"><a href="entradas.php"><i class='glyphicon glyphicon-save'></i> Entradas Caja</a></li>
            <li class="<?php echo $active_caja;?>"><a href="salidas.php"><i class='glyphicon glyphicon-open'></i> Salidas Caja</a></li>
            <li class="<?php echo $active_caja;?>"><a href="caja.php"><i class='glyphicon glyphicon-list-alt'></i> Ver Caja </a></li>
          </ul>
        </li>
        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"> Bancos <b class="caret"></b>
        </a>
          <ul class="dropdown-menu">
            <li class="<?php echo $active_bancos;?>"><a href="entradas_bancos.php"><i class='glyphicon glyphicon-save'></i> Entradas Bancos</a></li>
            <li class="<?php echo $active_bancos;?>"><a href="salidas_bancos.php"><i class='glyphicon glyphicon-open'></i> Salidas Bancos</a></li>
            <li class="<?php echo $active_bancos;?>"><a href="mov_bancos.php"><i class='glyphicon glyphicon-list-alt'></i> Movimiento Bancos </a></li>
            <li class="<?php echo $active_bancos;?>"><a href="bancos.php"><i class='glyphicon glyphicon-list-alt'></i> Ver Bancos </a></li>
          </ul>
        </li>

        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"> Clientes <b class="caret"></b>
        </a>
          <ul class="dropdown-menu">
            <li class="<?php echo $active_clientes;?>"><a href="clientes.php"><i class='glyphicon glyphicon-user'></i> Ver Clientes</a></li>
            <li class="<?php echo $active_clientes;?>"><a href="mov_clientes.php"><i class='glyphicon glyphicon-list'></i> Movimiento Cliente</a></li>
            <li class="<?php echo $active_clientes;?>"><a href="cartera.php"><i class='glyphicon glyphicon-list'></i> Ver Cartera</a></li>
          </ul>
        </li>               
        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"> Productos <b class="caret"></b>
        </a>
          <ul class="dropdown-menu">
            <li class="<?php echo $active_productos;?>"><a href="productos.php"><i class='glyphicon glyphicon-th-list'></i> Ver Productos</a></li>
            <li class="<?php echo $active_productos;?>"><a href="mov_productos.php"><i class='glyphicon glyphicon-list'></i> Movimiento Producto</a></li>
          </ul>
        </li>

		    <li class="<?php echo $active_usuarios;?>"><a href="usuarios.php"><i  class='glyphicon glyphicon-lock'></i> Usuarios</a></li>
		    <li class="<?php if(isset($active_perfil)){echo $active_perfil;}?>"><a href="perfil.php"><i  class='glyphicon glyphicon-cog'></i> Configuración</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
		    <li><a href="registro.php?logout"><i class='glyphicon glyphicon-off'></i> Salir</a></li>
      </ul>
    </div>
  </div>
</nav>
	<?php
		}
	?>