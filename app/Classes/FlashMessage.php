<?php

class FlashMessage {

  /**
   * Variable para guardar mensajes de error de validacion.
   * @var array
   */
  private $errors  = [];

  /**
   * Variable para guardar un mensaje de error general.
   * @var string
   */
  private $message = '';

  /**
   * Variable para guardar algun mensaje de exito.
   * @var string
   */
  private $successMessage = '';

  /**
   * Campos que quieres mostrar
   * @var array
   */
  private $inputs = [];

  function __construct() {
    $this->startSessionIfNotExists();

    // Guardando la informacion de la sesion
    if (!empty($_SESSION['messages'])) {
      $session = $_SESSION['messages'];

      if (array_key_exists('message', $session) && !empty($session['message'])) {
        $this->message = $session['message'];
      }

      if (array_key_exists('success_message', $session) && !empty($session['success_message'])) {
        $this->successMessage = $session['success_message'];
      }

      if (array_key_exists('errors', $session) && !empty($session['errors'])) {
        $this->errors = $session['errors'];
      }

      if (array_key_exists('inputs', $session) && !empty($session['inputs'])) {
        $this->inputs = $session['inputs'];
      }
      unset($_SESSION['messages']);
    }
  }

  /**
   * Funcionacion para iniciar la sesion si no existe.
   */
  private function startSessionIfNotExists() {
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
  }

  /**
   * Funcion para guardar el mensaje genearl
   * @param string $message
   */
  public function setMessage($message) {
      $this->message = $message;
  }

  /**
   * Funcion para obtener el mensaje
   * @return string
   */
  public function getMessage() {
    return $this->message;
  }


  /**
   * Funcion para guardar el mensaje de exito
   * @param string $message
   */
  public function setSuccessMessage($message) {
      $this->successMessage = $message;
  }

  /**
   * Funcion para obtener el mensaje de exito
   * @return string
   */
  public function getSuccessMessage() {
    return $this->successMessage;
  }

  /**
   * Funcion para obtener los campos del formulario
   * @param array $inputs [description]
   */
  public function setInputs($inputs) {
    $this->inputs = $inputs;
  }

  /**
   * Agrega un mensaje de validacion para un
   * campo del formulario
   * @param string $key
   * @param string $error
   */
  public function addError($key, $error) {
    if (!array_key_exists($key, $this->errors)) {
      $this->errors[$key] = [];
    }
    $this->errors[$key][] = $error;
  }

  /**
   * Guardar la informacion en la sesion
   */
  public function save() {
    $this->startSessionIfNotExists();
    $_SESSION['messages'] = [
      'message' => $this->message,
      'errors' => $this->errors,
      'success_message' => $this->successMessage,
      'inputs' => $this->inputs
    ];
    session_write_close();
  }

  /**
   * Funcion para verificar si existe algun mensaje
   * @return bool [description]
   */
  public function hasMessage() {
    return $this->message !== '';
  }

  /**
   * Funcion para verificar si existe algun mensaje de exito
   * @return bool [description]
   */
  public function hasSuccessMessage() {
    return $this->successMessage !== '';
  }

  /**
   * Funcion para verificar si existe mensajes de error
   * @return bool [description]
   */
  public function hasErrors() {
    return count($this->errors) > 0;
  }

  /**
   * Funcion para obtener el campo de formulario
   * @return bool [description]
   */
  public function getInput($key) {
    return (array_key_exists($key, $this->inputs)) ? $this->inputs[$key] : '';
  }

  /**
   * Funcion para verificar si existen mensajes de error para
   * un campo del formulario especifco
   * @param  string $key [description]
   * @return bool        [description]
   */
  public function hasError($key) {
    return array_key_exists($key, $this->errors);
  }

  /**
   * Funcion para obtener los mensajes de error para un
   * campo especifico
   * @param  string $key [description]
   * @return array       [description]
   */
  public function getError($key) {
    if ($this->hasError($key)) {
      return $this->errors[$key];
    } else {
      return [];
    }
  }

  /**
   * Retornar La Lista de errors
   * @return array
   */
  public function all() {
    return $this->errors;
  }
}
