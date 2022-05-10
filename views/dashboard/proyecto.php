<?php include_once __DIR__ . "/header-dashboard.php"; ?>

<div class="contenedor-sm">
  <div class="contenedor-nueva-tarea">
    <button
    type="button" class="agregar-tarea" id="agregar-tarea" 
    >&#43; Nueva Tarea </button>
  </div>
</div>
<div class="filtros" id="filtros">
  <div class="filtro">
    <h2>Filtros</h2>
    <div class="campo">
      <label for="todas">Todas</label>
      <input type="radio" id="todas",  name="filtro", value="", checked>
    </div>
    <div class="campo">
      <label for="completadas">completadas</label>
      <input type="radio" id="completadas",  name="filtro", value="1", >
    </div>
    <div class="campo">
      <label for="pendientes">pendientes</label>
      <input type="radio" id="pendientes",  name="filtro", value="0", >
    </div>
  </div>
</div>
<ul class="listado-tareas" id="listado-tareas"></ul>
<?php include_once __DIR__ . "/footer-dashboard.php"; ?>

<?php 
$script .= '
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="build/js/tareas.js"></script>
'; ?>