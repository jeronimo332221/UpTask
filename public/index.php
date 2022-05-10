<?php 

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\LoginController;
use Controllers\DashboardController;
use Controllers\TareaController;

$router = new Router();

// login
$router->get("/", [LoginController::class, "login"]);
$router->post("/", [LoginController::class, "login"]);
$router->get("/logout", [LoginController::class, "logout"]);

// Creacion de cuentas
$router->get("/crear", [LoginController::class, "crear"]);
$router->post("/crear", [LoginController::class, "crear"]);

// formulario de olvide mi password 
$router->get("/olvide", [LoginController::class, "olvide"]);
$router->post("/olvide", [LoginController::class, "olvide"]);

// colocar el nuevo password 
$router->get("/reestablecer", [LoginController::class, "reestablecer"]);
$router->post("/reestablecer", [LoginController::class, "reestablecer"]);

// mensaje de confirmacion 
$router->get("/mensaje", [LoginController::class, "mensaje"]);
$router->get("/confirmar", [LoginController::class, "confirmar"]);

// ZONA DE PORYECTOS 
$router->get("/dashboard", [DashboardController::class, "index"]);
$router->get("/crear-proyecto", [DashboardController::class, "crearProyecto"]);
$router->post("/crear-proyecto", [DashboardController::class, "crearProyecto"]);
$router->get("/proyecto", [DashboardController::class, "proyecto"]);
$router->get("/perfil", [DashboardController::class, "perfil"]);
$router->post("/perfil", [DashboardController::class, "perfil"]);
$router->get("/cambiarPassword", [DashboardController::class, "cambiarPassword"]);
$router->post("/cambiarPassword", [DashboardController::class, "cambiarPassword"]);


// API para las Tareas 
$router->get("/api/tareas", [TareaController::class, "index"]);
$router->post("/api/tareas", [TareaController::class, "index"]);
$router->post("/api/tareas", [TareaController::class, "crear"]);
$router->post("/api/tareas/actualizar", [TareaController::class, "actualizar"]);
$router->post("/api/tareas/eliminar", [TareaController::class, "eliminar"]);


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();