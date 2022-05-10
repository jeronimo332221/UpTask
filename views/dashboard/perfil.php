<?php include_once __DIR__ . "/header-dashboard.php"; ?>


<div class="contenedor-sm"> 
  <?php include_once __DIR__ . "../../templates/alertas.php"; ?>
  <a href="/cambiarPassword" class="enlace">Cambiar Password</a>
  <form action="/perfil" class="formulario" method="POST">
    <div class="campo"> 
      <label for="nombre">nombre</label>
      <input type="text" name="nombre" id="nombre" value="<?php echo $usuario->nombre ?>" placeholder="Tu Nombre">
    </div>
    <div class="campo"> 
      <label for="email">E-mail</label>
      <input type="text" name="email" id="email" value="<?php echo $usuario->email ?>" placeholder="Tu email">
    </div>

    <input type="submit" name="" id="" value="Guardar Cambios">
  </form>
</div>
<?php include_once __DIR__ . "/footer-dashboard.php"; ?>