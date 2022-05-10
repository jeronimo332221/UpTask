<?php

namespace Model;

class Usuario extends ActiveRecord {
  protected static $tabla = "usuarios";
  protected static $columnasDB = ["id", "nombre", "email", "password", "token", "confirmado"];

  public function __construct($args = [])
  {
    $this->id = $args["id"] ?? NULL;
    $this->nombre = $args["nombre"] ?? "";
    $this->email = $args["email"] ?? "";
    $this->password = $args["password"] ?? "";
    $this->password2 = $args["password2"] ?? "";
    $this->password_actual = $args["password_actual"] ?? "";  
    $this->password_nuevo = $args["password_nuevo"] ??"";  
    $this->token = $args["token"] ?? "";
    $this->confirmado = $args["confirmado"] ?? 0;
  }
  public function validarLogin() {
    if(!$this->email) {
      self::$alertas["error"][] = "El e-mail del usuario es obligatorio";
    }
    if(!$this->password) {
      self::$alertas["error"][] = "El Password del usuario es obligatorio";
    }
    if(filter_var(!$this->email, FILTER_VALIDATE_EMAIL)) {
      self::$alertas["error"][] = "El E-mail No es valido";
    }
    return self::$alertas;
  }

  // validacion para crear cuentas nuevas 
  public function validarNuevaCuenta() {

    if(!$this->nombre) {
      self::$alertas["error"][] = "El nombre del usuario es obligatorio";
    }
    if(!$this->email) {
      self::$alertas["error"][] = "El e-mail del usuario es obligatorio";
    }
    if(!$this->password) {
      self::$alertas["error"][] = "El Password del usuario es obligatorio";
    }
    if(strlen($this->password) < 6) {
      self::$alertas["error"][] = "El Password debe contener al menos 6 caracteres";
    }
    if($this->password !== $this->password2) {
      self::$alertas["error"][] = "El Password no coincide";
    }

    return self::$alertas;
  }

  // valida el email 
  public function validarEmail() {
    if(!$this->email) {
      self::$alertas["error"][] = "El E-mail es obligatorio";
    }
    if(filter_var(!$this->email, FILTER_VALIDATE_EMAIL)) {
      self::$alertas["error"][] = "El E-mail No es valido";
    }
    return self::$alertas;
  }
  // Comprobar el password 
  public function comprobarPassword() {
    return password_verify($this->password_actual, $this->password);
  }

  // hashea el password 
  public function hashPassword() {
    $this->password = password_hash($this->password, PASSWORD_BCRYPT);
  }
  public function crearToken(){
    $this->token = uniqid();
  }

  // validar password 
  public function validarPassword() {
    if(!$this->password) {
      self::$alertas["error"][] = "El Password del usuario es obligatorio";
    }
    if(strlen($this->password) < 6) {
      self::$alertas["error"][] = "El Password debe contener al menos 6 caracteres";
    }
    return self::$alertas;
  }
  public function validar_perfil() {
    if(!$this->nombre ) {
      self::$alertas["error"][] = "El nombre es obligatorio";
    }
    if(!$this->email ) {
      self::$alertas["error"][] = "El email es obligatorio";
    }
    return self::$alertas;
  }
  public function nuevo_password() {
    if(!$this->password_actual) {
      self::$alertas["error"][] = "El password No puede ir vacio";
      
    }
    if(!$this->password_nuevo) {
      self::$alertas["error"][] = "El password nuevo No puede ir vacio";
      
    }
    if(strlen($this->password_nuevo) < 6 ) {
      self::$alertas["error"][] = "El password Es muy corto";
      
    }
    return self::$alertas;
  }

}