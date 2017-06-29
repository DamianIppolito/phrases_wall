<?php
/**
 * Phras class
 * @package phrases_wall
 * @author Damian Ippolito <damian.ippolito@gmail.com>
 * @copyright Copyright (c) 2017, Damian Ippolito
 * @version 1.0 2017-06-26
 */
include_once('../class/connection.php');
class Phrase {

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
		$db = Db::getInstance();
    $stmt = $db->query('SELECT * FROM `phrases` ORDER BY `id` DESC');
    $results = $stmt->fetchAll(PDO::FETCH_CLASS, 'Phrase');
    return $results;

  }

  /**
  * Busqueda de un ususrio concreto por ID
  * @param int $ID ID del usuario
  * @return (obj) User
  * @version 1.0 2017-06-26
  */
  public static function getById($ID){

    $db = Db::getInstance();
    $stmt = $db->prepare('SELECT * FROM `phrases` WHERE `id` = :id LIMIT 1');
    $stmt->bindValue(':id', $ID, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
		$phrase = new Phrase();
		$phrase->setId($result['id']);
		$phrase->setIdUser($result['id_user']);
		$phrase->setText($result['text']);
		$phrase->setTimeStamp($result['time_stamp']);
    return $phrase;

  }

  /**
	* Guarda nueva nota
	* @version 1.0 2017-06-26
	*/
	public function save()	{
    $db = Db::getInstance();
    $stmt = $db->prepare('
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
    $db = Db::getInstance();
    $stmt = $db->prepare('
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
