<aside class="sidebar">
  <div class="contenedor-sidebar">

    <h2>UpTask</h2>
    <div class="cerrar-menu">
    <svg id="cerrar-menu" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#fff" fill="none" stroke-linecap="round" stroke-linejoin="round">
  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
  <line x1="18" y1="6" x2="6" y2="18" />
  <line x1="6" y1="6" x2="18" y2="18" />
</svg>
  </div>
  </div>

  <nav class="side-nav">
    <a class="<?php echo ($titulo === 'Proyectos' ? 'activo' : '') ;?>" href="/dashboard">Proyectos</a>
    <a class="<?php echo ($titulo === 'Crear Proyecto' ? 'activo' : '') ;?>" href="/crear-proyecto">Crear Proyecto</a>
    <a class="<?php echo ($titulo === 'Perfil' ? 'activo' : '') ;?>" href="/perfil">Prefil</a>
  </nav>

  <div class="cerrar-sesion-mobile">
    <a href="/logout" class="cerrar-sesion">Cerrar Sesion</a>
  </div>
</aside>