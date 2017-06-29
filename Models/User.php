<?php
/**
 * User class
 * @package phrases_wall
 * @author Damian Ippolito <damian.ippolito@gmail.com>
 * @copyright Copyright (c) 2017, Damian Ippolito
 * @version 1.0 2017-06-26
 */
include_once('connection.php');

class User {

	private $id = NULL;
	private $alias;
	private $first_name;
	private $last_name;
	private $email;
	private $password;
	private $token;
	private $rememberMe;
	private $active;
	private $time_stamp;
  private $favorite_phrases;

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
	 * @return string $alias
	 * @version 1.0 2017-06-26
	*/
	public function getAlias(){
		return $this->alias;
	}
	/**
	 * @param string $Alias
	 * @version 1.0 2017-06-26
	*/
	public function setAlias($alias){
		$this->alias = $alias;
	}

	/**
	 * @return string $first_name
	 * @version 1.0 2017-06-26
	*/
	public function getFirstName(){
		return $this->first_name;
	}
	/**
	 * @param string $first_name
	 * @version 1.0 2017-06-26
	*/
	public function setFirstName($first_name){
		$this->first_name = $first_name;
	}

	/**
	 * @return string $last_name
	 * @version 1.0 2017-06-26
	*/
	public function getLastName(){
		return $this->last_name;
	}
	/**
	 * @param string $last_name
	 * @version 1.0 2017-06-26
	*/
	public function setLastName($last_name){
		$this->last_name = $last_name;
	}

	/**
	 * @return string $email
	 * @version 1.0 2017-06-26
	*/
	public function getEmail(){
		return $this->email;
	}
	/**
	 * @param string $email
	 * @version 1.0 2017-06-26
	*/
	public function setEmail($email){
		$this->email = $email;
	}

	/**
	 * @return string $password
	 * @version 1.0 2017-06-26
	*/
	public function getPassword(){
		return $this->password;
	}
	/**
	 * @param string $password
	 * @version 1.0 2017-06-26
	*/
	public function setPassword($password){
		$this->password = $password;
	}

	/**
	 * @return string $token
	 * @version 1.0 2017-06-26
	*/
	public function getToken(){
		return $this->token;
	}
	/**
	 * @param string $token
	 * @version 1.0 2017-06-26
	*/
	public function setToken($token){
		$this->token = $token;
	}

	/**
	 * @return int $rememberMe
	 * @version 1.0 2017-06-26
	*/
	public function getRememberMe(){
		return intval($this->rememberMe);
	}
	/**
	 * @param int $rememberMe
	 * @version 1.0 2017-06-26
	*/
	public function setRememberMe($rememberMe){
		$this->rememberMe = intval($rememberMe);
	}

	/**
	 * @return int $active
	 * @version 1.0 2017-06-26
	*/
	public function getActive(){
		return intval($this->active);
	}
	/**
	 * @param int $active
	 * @version 1.0 2017-06-26
	*/
	public function setActive($active){
		$this->active = intval($active);
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
   * @return array $favorite_phrases
   * @version 1.0 2017-06-26
  */
  public function getFavoritePhrases(){
    return $this->favorite_phrases;
  }
  /**
   * @param array $favorite_phrases
   * @version 1.0 2017-06-26
  */
  public function setFavoritePhrases($favorite_phrases){
    $this->favorite_phrases = $favorite_phrases;
  }

	/**
	* Recoge los Users de tabla
	* @return array (obj) User
	* @version 1.0 2017-06-26
	*/
	public function getUsers($order = 1, $only_active = TRUE){
		switch($order){
			case 1:
				$SQL_order = " ORDER BY `id` DESC";
				break;
			case 2:
				$SQL_order = " ORDER BY `id` ASC";
				break;
			case 3:
				$SQL_order = " ORDER BY `name` ASC";
				break;
			case 4:
				$SQL_order = " ORDER BY `name` DESC";
				break;
			case 5:
				$SQL_order = " ORDER BY `timestamp` ASC";
				break;
			case 6:
				$SQL_order = " ORDER BY `timestamp` DESC";
				break;
		}

		if($only_active){
			$SQL_onlyactive = " AND `active` = 1";
		}

    $db = Db::getInstance();
    $stmt = $db->query('SELECT * FROM `users` WHERE 1'.$SQL_onlyactive.$SQL_order);
    $results = $stmt->fetchAll(PDO::FETCH_CLASS, 'User');
    return $results;

	}

  /**
	* Busqueda de un ususrio concreto por ID
	* @param int $id ID del usuario
  * @return (obj) User
	* @version 1.0 2017-06-26
	*/
	public static function getById($id){
    $db = Db::getInstance();
    $stmt = $db->prepare('SELECT * FROM `users` WHERE `id` = :id AND `active` = '1' LIMIT 1');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
		$user = new User();
		$user->setId($result['id']);
		$user->setAlias($result['alias']);
		$user->setFirstName($result['first_name']);
		$user->setLastName($result['last_name']);
		$user->setEmail($result['email']);
		$user->setPassword($result['password']);
		$user->setToken($result['token']);
		$user->setActive($result['active']);
		$user->setRememberMe($result['rememberme']);
		$user->setTimeStamp($result['time_stamp']);
		$user->setFavoritePhrases($this->retrieveFavoritePhrases());
    return $user;

	}

	/**
	* Intenta hacer login del usuario
	* @param string $email Email de acceso del usuario
	* @param string $pass Contraseña de acceso del usuario
	* @return bool True si pudo hacer login o False si no lo consiguió
	* @version 1.0 2017-06-26
	*/
	public function login($email, $pass, $remember){
    $db = Db::getInstance();
    $stmt = $db->prepare('SELECT * FROM `users` WHERE `email` = :email AND `password` = :password AND `active` = 1 LIMIT 1');
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':password', 'AES_ENCRYPT("'. $pass .'", "'. substr($pass, 0, 2) .'")');
    $stmt->execute();
    $result = $stmt->fetch();
    if($result)	{
      $token = '';
      $possible = '0123456789bcdfghjkmnpqrstvwxyz';
      $i = 0;
      if($possible < $length && $noRepeat) {
        $noRepeat = false;
      }
      while ($i < $length) {
        $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
        if($noRepeat) {
          if (!strstr($token, $char)) {
            $token .= $char;
            $i++;
          }
        } else {
          $token .= $char;
          $i++;
        }
      }

      $stmt = $db->prepare('UPDATE `users` SET `token` = :token AND `rememberme` = :rememberme WHERE `id` = :id');
      $stmt->bindValue(':token', $token);
      $stmt->bindValue(':id', $result['id'], PDO::PARAM_INT);
      $stmt->bindValue(':rememberme', $remember, PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetch();

			if($remember == 1){
				setcookie("User", $token, time() + 3600*24*30, "/");
			}
			else{
				setcookie("User", $token, time() + 3600, "/");
			}

			return TRUE;
 		}
		else{
			return FALSE;
		}
	}


	/**
	* Hace logout del usuario activo
	* @return bool True si el logout fue satisfactorio o False en caso contrario
	* @version 1.0 2017-06-26
	*/
	public function logout(){
    $db = Db::getInstance();
    $stmt = $db->preprare('UPDATE `users` SET `token` = '' WHERE `id` = :id');
    $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch();

		setcookie("User", "", time() - 3600, "/");
	}


	/**
	* Guarda los datos de un User si lo llevamos cargado, si no tenemos ID cargado, inserta uno nuevo
	* @version 1.0 2017-06-26
	*/
	public function save($savepass = FALSE)	{
		if ($savepass){
			$SQL_savepass = "AES_ENCRYPT('". $this->password ."', '". substr($this->password,0,2) ."')";
		}
		else{
			$SQL_savepass = "UNHEX('".bin2hex($this->password)."')";
		}


		if($this->id == "")	{

      $db = Db::getInstance();
      $stmt = $db->preprare('
        INSERT INTO `users` (
          `id`,
          `alias`,
          `name`,
          `last_name`,
          `email`,
          `password`,
          `token`,
          `rememberme`,
          `active`,
          `time_stamp`
				)
        VALUES
				(
          :id,
          :alias,
          :name,
          :last_name,
          :email,
          :password,
          :token,
          :rememberme,
          :active,
          :time_stamp
        )
      ');
      $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
      $stmt->bindValue(':alias', $this->alias);
      $stmt->bindValue(':name', $this->name);
      $stmt->bindValue(':last_name', $this->last_name;
      $stmt->bindValue(':email', $this->email);
      $stmt->bindValue(':password', $SQL_savepass);
      $stmt->bindValue(':token', $this->token);
      $stmt->bindValue(':rememberme', $this->rememberme, PDO::PARAM_INT);
      $stmt->bindValue(':active', $this->active, PDO::PARAM_INT);
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
		else{
      $db = Db::getInstance();
      $stmt = $db->prepare('
        UPDATE `users` set
        `alias` = :alias,
        `name` = :name,
        `last_name` = :last_name,
        `email` = :email,
        `password` = :password,
        `token` = :token,
        `rememberme` = :rememberme,
				`active` = :active,
        `time_stamp` = :time_stamp
      WHERE `id` = :id;');

      $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
      $stmt->bindValue(':alias', $this->alias);
      $stmt->bindValue(':name', $this->name);
      $stmt->bindValue(':last_name', $this->last_name;
      $stmt->bindValue(':email', $this->email);
      $stmt->bindValue(':password', $SQL_savepass);
      $stmt->bindValue(':token', $this->token);
      $stmt->bindValue(':rememberme', $this->rememberme, PDO::PARAM_INT);
      $stmt->bindValue(':active', $this->active, PDO::PARAM_INT);
      $stmt->bindValue(':time_stamp', $this->time_stamp);
      $result = $stmt->execute();

			if($result){
				return TRUE;
			}
			else{
				return FALSE;
			}
		}
	}


	/**
	* Comprueba si un email ya existe en tabla
	* @return mixed Si existe devuelve la id del usuario, si no existe devuelve FALSE
	* @version 1.0 2017-06-26
	*/
	public function exists(){
  	$db = Db::getInstance();
    $stmt = $db->prepare('SELECT * FROM `users` WHERE `email` = :email AND `active` = '1' LIMIT 1');
    $stmt->bindValue(':email', $email);
    $stmt->execute();
    $result = $stmt->fetch();

		if(count($result) > 0){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}


	/**
	* login de usuario en base a token grabado en cookie
	* @version 1.0 2017-06-26
	*/
	public static function getByToken(){
		$token = $_COOKIE("User");

		if ($token != ""){
      $db = Db::getInstance();
      $stmt = $db->prepare('"SELECT * FROM `users` WHERE `token` = :token AND `active` = '1' LIMIT 1');
      $stmt->bindValue(':token', $token);
      $stmt->execute();
      $result = $stmt->fetch();

			if($result['remember'] == "1")	{
				setcookie("User", $token, time() + 3600 * 24 * 30, "/");
			}
			else{
				setcookie("User", $token, time() + 3600, "/");
			}

			return $ret;
		}
		else{
			setcookie("User", "", time() - 90000, "/");
			return FALSE;
		}
	}

  private function retrieveFavoritePhrases(){
    $db = Db::getInstance();
    $stmt = $db->query('SELECT `id` FROM `user_favorites` WHERE `id_user` = :id_user');
    $stmt->bindValue(':id_user', $this->id, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll();
    return $results;
  }
//
//
// FIN DE LA CLASE
//
//
}
?>
