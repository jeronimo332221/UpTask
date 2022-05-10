<?php 
namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;


class LoginController{
  public static function login( Router $router) {

    $alertas = [];
    
    if($_SERVER["REQUEST_METHOD"] === "POST") {

      $usuario = new Usuario($_POST);

      $alertas = $usuario->validarLogin();

      if(empty($alertas)) {
        // verificar que el usuario exista 
        $usuario = Usuario::where("email", $usuario->email);

        if(!$usuario || !$usuario->confirmado) {
          Usuario::setAlerta("error", "El usuario No existe o No esta confirmado");  
        }else {
          // el usuario existe 
          if(password_verify($_POST["password"], $usuario->password)) {
            // iniciar secion 
            session_start();
            $_SESSION["id"]= $usuario->id;
            $_SESSION["nombre"] = $usuario->nombre;
            $_SESSION["email"] = $usuario->email;
            $_SESSION["login"] = true;

            // redireccionar 
            header("Location: /dashboard");

          }else {
            Usuario::setAlerta("error", "Password incorrecto");  
          }

          
        }
  
      }
    }
    $alertas = Usuario::getAlertas();
    // render a la vista 
    $router->render("auth/login", [
      "titulo" => "iniciar Sesion",
      "alertas" => $alertas,
    ]);
  }
  public static function logout() {
    session_start();
    $_SESSION = [];
    header("Location: /");
    
    if($_SERVER["REQUEST_METHOD"] === "POST") {

    }
  }
  public static function crear(Router $router) {

    $alertas = [];
    $usuario = new Usuario;

    if($_SERVER["REQUEST_METHOD"] === "POST") {

      $usuario->sincronizar($_POST);

      $alertas = $usuario->validarNuevaCuenta();


      if(empty($alertas)){
        $existeUsuario = Usuario::where("email", $usuario->email);

          if($existeUsuario){
        Usuario::setAlerta("error", "El usuario Ya existe");
        $alertas = Usuario::getAlertas();
      }else {
        
        // hashear el password 
        $usuario->hashPassword();
        
        // eliminar password 2 
        unset($usuario->password2);
        
        // Generar nuevo token 
        $usuario->crearToken();
        
        $usuario->confirmado = 0;

        // Crear nuevo usuario
        $resultado = $usuario->guardar();


        // enviar email 
        $email = new Email($usuario->email, $usuario->nombre, $usuario->token );
        $email->enviarConfirmacion();

        if($resultado) {
          header("Location: /mensaje");
        }

      }}

    }
    // render a la vista 
    $router->render("auth/crear", [
   "titulo" => "Crear Cuenta",
   "usuario" => $usuario,
   "alertas" => $alertas,
 ]);
  }
  public static function olvide(Router $router) {

    $alertas = [];

    if($_SERVER["REQUEST_METHOD"] === "POST") {
      $usuario = new Usuario($_POST);
      $alertas = $usuario->validarEmail();

      if(empty($alertas)){

        $usuario = Usuario::where("email", $usuario->email);

        if($usuario && $usuario->confirmado === "1") {

          // Generar nuevo token 
          $usuario->crearToken();

          // Actualizar el usuario
          $usuario->guardar();
          
          // enviar email 
          $email = new Email($usuario->email, $usuario->nombre, $usuario->token );
          $email->enviarInstrucciones();

          // Imprimir alerta
          Usuario::setAlerta("exito", "Revisa tu Email!!!!"); 
         

        }else {
          Usuario::setAlerta("error", "No Se Pudo encontrar el usuario");
        } 
      }
      
      $alertas = Usuario::getAlertas();
    }
        // render a la vista 
    $router->render("auth/olvide", [
   "titulo" => "Olvide Mi Password",
   "alertas" => $alertas,
 ]);
  }
  public static function reestablecer(Router $router) {

    $token = s($_GET["token"]);
    $mostrar = true;

    if(!$token) header("Location: /");

    // identificar el usuario con el token 
    $usuario = Usuario::where("token", $token);

    if(empty($usuario)) {
      Usuario::setAlerta("error", "Token no valido");
      $mostrar = false;
    }

    
    if($_SERVER["REQUEST_METHOD"] === "POST") {
      
      // añadir el nuevo password 
      $usuario->sincronizar($_POST);  
      
      // validar el password 
      $alertas = $usuario->validarPassword();

      if(empty($alertas))  {
        // hashear el nuevo password  
        $usuario->hashPassword();

        // eliminar token  
        unset($usuario->password2);
        $usuario->token = NULL;

        // Guardar usuario en la DB 
        $resultado = $usuario->guardar();
        if($resultado) {
          header("Location: /");
        }

        // Redireccionar 


      }

    }
    $alertas = Usuario::getAlertas();
     // render a la vista 
    $router->render("auth/reestablecer", [
   "titulo" => "Reestablecer Password",
   "alertas" => $alertas,
   "mostrar" => $mostrar,
      ]);
   }
  public static function mensaje(Router $router) {
                // render a la vista 
    $router->render("auth/mensaje", [
   "titulo" => "",
  ]);
}
public static function confirmar(Router $router) {

  $token  = s($_GET["token"]);
  
  if(!$token) header("Location: /");

  // encontrar al usuario 
  $usuario = Usuario::where("token", $token); 
  
  if(empty($usuario)) {
    Usuario::setAlerta("error", "Token no valido");
  }else {
    // confirmar la cuenta 
    $usuario->confirmado = 1;
    $usuario->token = NULL;
    unset($usuario->password2);
    
    // guardar en la db 
    $usuario->guardar();
    
    Usuario::setAlerta("exito", "Cuenta comprobada correctamente");
    
  }
  $alertas = Usuario::getAlertas();


  $router->render("auth/confirmar", [
    "titulo" => "",
    "alertas" => $alertas
    ]);
  
  }
}


?>