<div class="contenedor olvide">
  <?php include_once __DIR__ . "/../templates/nombre-sitio.php"  ;?>

  <div class="contenedor-sm">
    <p class="descripcion-pagina">Olvide Mi Password</p>

      <?php include_once __DIR__ . "/../templates/alertas.php"  ;?>
    <form action="/olvide" method="POST" class="formulario">
      <div class="campo">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="Tu Email" name="email" novalidate>
      </div>
      <input type="submit" class="boton" value="Enviar Mensaje">
    </form>
    <div class="acciones">
      <a href="/crear">Aún no tienes una cuenta¡? crea una</a>
      <a href="/olvide">Olvidaste tu password?</a>
    </div>
  </div>
</div>