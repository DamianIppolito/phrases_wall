<?php
/**
 * User class
 * @package phrases_wall
 * @author Damian Ippolito <damian.ippolito@gmail.com>
 * @copyright Copyright (c) 2017, Damian Ippolito
 * @version 1.0 2017-06-26
 */
class PS_User {

	private $id = NULL;
  private $id_user;
  private $text;
	private $time_stamp;

	/**
	 * @return int $id
	 * @version 1.0 2017-06-26
	*/
	public function getId(){
		return intval($this->id);
	}
	/**
	 * @param int $id
	 * @version 1.0 2017-06-26
	*/
	public function setId($id){
		$this->id = intval($id);
	}

  /**
	 * @return int $id_user
	 * @version 1.0 2017-06-26
	*/
	public function getIdUser(){
		return intval($this->id_user);
	}
	/**
	 * @param int $id_user
	 * @version 1.0 2017-06-26
	*/
	public function setIdUser($id_user){
		$this->id_user = intval($id_user);
	}

  /**
	 * @return string $text
	 * @version 1.0 2017-06-26
	*/
	public function getText(){
		return $this->text;
	}
	/**
	 * @param string $text
	 * @version 1.0 2017-06-26
	*/
	public function setText($text){
		$this->text = $text;
	}

  /**
	 * @return string $time_stamp
	 * @version 1.0 2017-06-26
	*/
	public function getTimeStamp(){
		return $this->time_stamp;
	}
	/**
	 * @param string $time_stamp
	 * @version 1.0 2017-06-26
	*/
	public function setTimeStamp($time_stamp){
		$this->time_stamp = $time_stamp;
	}

  /**
  * Recoge los Users de tabla
  * @return array (obj) User
  * @version 1.0 2017-06-26
  */
  public function getPhrases(){

    $db = new PDO('mysql:host=localhost;dbname=testdb;charset=utf8mb4', 'username', 'password');
    $stmt = $db->query('SELECT * FROM `phrases` ORDER BY `id` DESC');
    $results = $stmt->fetchAll();
    return $results;

  }

  /**
  * Busqueda de un ususrio concreto por ID
  * @param int $ID ID del usuario
  * @return (obj) User
  * @version 1.0 2017-06-26
  */
  public static function getById($ID){

    $db = new PDO('mysql:host=localhost;dbname=testdb;charset=utf8mb4', 'username', 'password');
    $stmt = $db->query('SELECT * FROM `phrases` WHERE `id` = :id LIMIT 1');
    $stmt->bindValue(':id', $ID, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch();
    return $result;

  }

  /**
	* Guarda nueva nota
	* @version 1.0 2017-06-26
	*/
	public function save()	{
    $db = new PDO('mysql:host=localhost;dbname=testdb;charset=utf8mb4', 'username', 'password');
    $stmt = $db->query('
      INSERT INTO `phrases` (
        `id`,
        `id_user`,
        `text`,
        `time_stamp`
      )
      VALUES(
        :id,
        :id_user,
        :text,
        :time_stamp
      )
    ');
    $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
    $stmt->bindValue(':id_user', $this->id_user);
    $stmt->bindValue(':text', $this->text);
    $stmt->bindValue(':time_stamp', $this->time_stamp);
    $result = $stmt->execute();
    if($result){
      $this->id = $db->lastInsertId();
      return TRUE;
    }
    else{
      return FALSE;
    }
  }

  /**
	* marca la nota como favorita para el usuario pasado por variable
  * @param int $ID ID del usuario
	* @version 1.0 2017-06-26
	*/
  public function makeFavorite($id_user){
    $db = new PDO('mysql:host=localhost;dbname=testdb;charset=utf8mb4', 'username', 'password');
    $stmt = $db->query('
      INSERT INTO `user_favorites` (
        `id`,
        `id_user`,
        `id_phrase`
      )
      VALUES(
        :id,
        :id_user,
        :id_phrase,
      )
    ');
    $stmt->bindValue(':id', NULL, PDO::PARAM_INT);
    $stmt->bindValue(':id_user', $id_user);
    $stmt->bindValue(':id_phrase', $this->id);
    $result = $stmt->execute();
    if($result){
      return TRUE;
    }
    else{
      return FALSE;
    }
  }

//
//
// FIN DE LA CLASE
//
//
}
?>
