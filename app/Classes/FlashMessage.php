<?php

class FlashMessage {

    /**
      * Variable para guardar mensajes de error de validacion.
      * @var array
      */
    private $errors = [];

    /**
    * Variable para guardar un mensaje de error general.
    * @var string
    */
   private $message = '';

   private $successMessage = '';

   private $inputs = [];

   function __construct() {
       $this->startSessionIfNotExists();

       if (!empty($_SESSION['messages'])) {
           $session = $_SESSION['messages'];

           $this->message = $session;

           if (array_key_exist('success_message', $session)) {
               $this->$successMessage = $_SESSION['sucess_message'];
           }

           if (array_key_exist('errors', $session)) {
               $this->errors = $_SESSION['errors'];
           }

           if (array_key_exist('inputs', $session)) {
               $this->inputs = $_SESSION['inputs'];
           }
           unset($_SESSION['messages']);
       }

   }

   private function startSessionIfNotExists() {
       if (session_status()  == PHP_SESSION_NONE) {
           session_start();
       }
   }

   public function setMessage(string $message) {
       $this->message = $message;
   }

  public function getMessage() {
      return $this->message;
  }

  public function setSuccessMessage(string $message) {
      $this->successMessage = $message;
  }

  public function getSuccessMessage() {
      return $this->successMessage;
  }

  public function setInputs(array $inputs) {
      $this->inputs = $inputs;
  }

  public function addError(string $input, string $error) {
      if (!array_key_exist($input, $this->errors)) {
          $this->errors[$input] = [];
      }
      $this->errors[$input][] = $error;
  }


  public function hasMessage() {
      return $this->message !== '';
  }

  public function hasSuccessMessage() {
      return $this->successMessage !== '';
  }

  public function hasErrors() {
      return count($this->errors) > 0;
  }

  public function hasError(string $input) {
      return array_key_exist($input, $this->errors);
  }

  public function getError(string $input) {
      if ($this->hasError($input)) {
          return $this->errors[$input];
      } else {
          return [];
      }
  }

  public function all() {
      return $this->errors;
  }

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


}
