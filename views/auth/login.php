<div class="contenedor login">
  <?php include_once __DIR__ . "/../templates/nombre-sitio.php"  ;?>
  
  <div class="contenedor-sm">
    <p class="descripcion-pagina">Iniciar Sesion</p>
    <?php include_once __DIR__ . "/../templates/alertas.php"  ;?>
    
    <form action="/" method="POST" class="formulario" >
      <div class="campo">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="Tu Email" name="email">
      </div>
      <div class="campo">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Tu Password" name="password">
      </div>

      <input type="submit" class="boton" value="Iniciar Sesion">
    </form>
    <div class="acciones">
      <a href="/crear">Aún no tienes una cuenta¡? crea una</a>
      <a href="/olvide">Olvidaste tu password?</a>
    </div>
  </div>
</div>