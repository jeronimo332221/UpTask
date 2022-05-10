<div class="contenedor reestablecer">
  <?php include_once __DIR__ . "/../templates/nombre-sitio.php"  ;?>
  
  <div class="contenedor-sm">
    <p class="descripcion-pagina">Coloca Tu nuevo Password</p>
    <?php include_once __DIR__ . "/../templates/alertas.php"  ;?>
    <?php if($mostrar) {?>
      
      <form method="POST" class="formulario">
        
        <div class="campo">
          <label for="password">Password</label>
          <input type="password" name="password" id="password" placeholder="Tu Password" name="password">
        </div>
        
        <input type="submit" class="boton" value="Guardar Password">
      </form>
      <?php } ?>
      <div class="acciones">
        <a href="/crear">Aún no tienes una cuenta¡? crea una</a>
        <a href="/olvide">Olvidaste tu password?</a>
    </div>
  </div>
</div>