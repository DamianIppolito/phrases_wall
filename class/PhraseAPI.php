<?php
require_once 'API.class.php';
require_once '../Models/User.php';
require_once '../Models/Phrase.php';


class PhraseAPI extends API
{
  protected $respone;
  public function __construct($request, $origin) {
      parent::__construct($request);

      $response = new stdClass();
      $response->result = 'ko';
      $response->debug = 'Error al procesar la petición. ';

      $this->response = $response;
  }

  /**
   * Endpoint para obeter todos los empleados
  */
  protected function all() {
      if ($this->method == 'GET') {
        $phrases = Phrase::getPhrases();
        if(count($phrases) > 0){
          $this->presponse->phrases = $phrases;
          $this->response->result = 'ok';
        }
      } else {
          $this->response->errors = "Solo acepta GET como metodo";
      }
      return json_encode($this->response);
   }

   /**
    * Endpoint para obeter los datos de un empleado
    */
    protected function get() {
       if ($this->method == 'GET') {
         $id_phrase = $this->args[0];
         if($id_phrase && (int)$id_phrase > 0){
          $phrase = Phrase::getById($id_phrase);
          if($prhase){
            $this->response->result = 'ok';
            $this->response->phrase = $prhase;
          }
        }
       } else {
           $this->response->errors = "Solo acepta GET como metodo";
       }
       return json_encode($this->response);
    }

    /**
     * Endpoint para crear empleado nuevo
     */
     protected function new() {
        //ini_set('display_errors',1);
        if ($this->method == 'POST') {
          parse_str($this->verb, $new_phrase);
          $phrase = new Phrase();
      		$phrase->setId(NULL);
      		$phrase->setIdUser($new_phrase['id_user']);
      		$phrase->setText($new_phrase['text']);
      		$phrase->setTimeStamp(date('Y-m-d H:i:s'));
          if($phrase->save()){
            $this->response->result = 'ok';
            $this->response->debug = 'Frase creada correctamente. ';
          }else{
            $this->response->errors = "Error al crear nueva frase";
          }
        } else {
            $this->response->errors = "Solo acepta POST como metodo";
        }
        return json_encode($this->response);
     }

     /**
      * Endpoint para obeter los ids de las frases favoritas de un usuario
      */
      protected function get_favorites() {
         if ($this->method == 'GET') {
           $id_user = $this->args[0];
           if($id_user && (int)$id_user > 0){
            $user = User::getById($id_user);
            if($user){
              $this->response->result = 'ok';
              $this->response->user_favorite_phrases = $user->getFavoritePhrases();
            }
          }
         } else {
             $this->response->errors = "Solo acepta GET como metodo";
         }
         return json_encode($this->response);
      }

      /**
       * Endpoint para crear empleado nuevo
       */
       protected function set_favorite() {
          //ini_set('display_errors',1);
          if ($this->method == 'POST') {
            parse_str($this->verb, $new_favorite_phrase);
            $id_user = $new_favorite_phrase['id_user'];
            $id_phrase = $new_favorite_phrase['id_phrase'];

            $phrase = Phrase::getById($id_phrase);
            $user = User::getById($id_user);
            if($phrase && $user){
              if($phrase->makeFavorite($user->getId())){
                $this->response->result = 'ok';
                $this->response->debug = 'Frase marcada como favorita par a el usuario '.$user->getId().'. ';
              }else{
                $this->response->errors = "Error al marcar la frase como favorita";
              }
            }

          } else {
              $this->response->errors = "Solo acepta POST como metodo";
          }
          return json_encode($this->response);
       }
 }
?>
