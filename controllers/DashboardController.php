<?php 
namespace Controllers;

use MVC\Router;
use Model\Proyecto;
use Model\Usuario;

class DashboardController {
  public static function index( Router $router) {

    session_start();

    // protege la url verificando al usuario  
    isAuth();

    $id = $_SESSION["id"];

    $proyectos = Proyecto::belongsTo("propietarioId", $id);

    $router->render("dashboard/index", [
      "titulo" => "Proyectos",
      "proyectos" => $proyectos,
    ]);
  }
  public static function crearProyecto( Router $router) {
    
    session_start();

    // protege la url verificando al usuario  
    isAuth();

    $alertas = [];

    if($_SERVER["REQUEST_METHOD"] === "POST") {

      $proyecto = new Proyecto($_POST);
      
      // validacion 
      $alertas = $proyecto->validarProyecto();

      if(empty($alertas)) {
        // Generar un token/url unico 
        $hash = md5(uniqid());
        $proyecto->url = $hash;

        // Almacenar el creador del proyecto 
        $proyecto->propietarioId = $_SESSION["id"];

        // guardar el proyec to 
        $proyecto->guardar();

        // redireccionar 
        header("Location: /proyecto?id=" . $proyecto->url);  
      }
    }
    
    $router->render("dashboard/crear-proyecto", [
      "alertas" => $alertas,
      "titulo" => "Crear Proyecto"
    ]);
  }
  public static function perfil( Router $router) {
    
    session_start();
    isAuth();
    $alertas = [];

    $usuario = Usuario::find($_SESSION["id"]);

    if($_SERVER["REQUEST_METHOD"] === "POST")  {

      $usuario->sincronizar($_POST);

      $alertas = $usuario->validar_perfil();

      if(empty($alertas)) {
        $existeUsuario = Usuario::where("email", $usuario->email);

       if($existeUsuario && $existeUsuario->id !== $usuario->id) {
         Usuario::setAlerta("error", "El Usuario Ya existe");

       }else {
        // guardar usuario 
        $usuario->guardar();

        Usuario::setAlerta("exito", "Guardado Correctamente");
        $alertas = $usuario->getAlertas();

        // asignar nombre nuevo a la barra 
        $_SESSION["nombre"] = $usuario->nombre;
       }
    
      }
    }
 
    $router->render("dashboard/perfil", [
      "titulo" => "Perfil",
      "usuario" => $usuario,
      "alertas" => $alertas
    ]);
  }
  public static function proyecto( Router $router) {
    session_start();
    isAuth();
     
    $token = $_GET["id"];

    if(!$token) header("Location: /dashboard");
    
    // Revisar que la persona que visita el proyecto, sea quien lo creo 
    $proyecto = Proyecto::where("url", $token);
    
    if($proyecto->propietarioId != $_SESSION["id"]) {
      if(!$token) header("Location: /dashboard");
    }
    

    $router->render("dashboard/proyecto", [
      "titulo" => $proyecto->proyecto,
    ]);
  }
  public static function cambiarPassword( Router $router) {
    session_start();
    isAuth();

    $alertas = [];

    if($_SERVER["REQUEST_METHOD"] === "POST")  {

      $usuario = Usuario::find($_SESSION["id"]);

      // sincronizar con los datos insertados 
      $usuario->sincronizar($_POST);

      $alertas = $usuario->nuevo_password();

      if(empty($alertas)) {
        $resultado = $usuario->comprobarPassword();
      

        if($resultado) {
          // asignar nuevo password 
          unset($usuario->password_actual);
          $usuario->password = $usuario->password_nuevo;
          unset($usuario->password_nuevo);
      
          // hashear el password 
          $usuario->hashPassword();

          // actualizar el usuario

          $resultado = $usuario->guardar();

          if($resultado) {
            Usuario::setAlerta("exito", "Password cambiado Correctamente");
            $alertas = $usuario->getAlertas();
          }
          
        }else {
          Usuario::setAlerta("error", "Password Incorrecto");
          $alertas = $usuario->getAlertas();
        }

      }
    }
  
    $router->render("dashboard/cambiarPassword", [
      "titulo" => "Cambiar Password",
      "alertas" => $alertas
    ]);
  }

}