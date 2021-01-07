<?php
/**
 * Created by SyncroBit.
 * Author: George Partene
 * Version: 0.1
 */

class SB_SESSION {
  private $db;

  public function __construct(){
		// Instantiate new Database object
		$this->db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);

		// Set handler to overide SESSION
		session_set_save_handler(
		array($this, "_open"),
		array($this, "_close"),
		array($this, "_read"),
		array($this, "_write"),
		array($this, "_destroy"),
		array($this, "_gc")
		);

    //register_shutdown_function('session_write_close');
		// Start the session
		session_start();
  }

  public function _open(){
    $limit = time() - (3600 * 24);
    $sql = "DELETE FROM `sb_sessions` WHERE timestamp < :limit";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(":limit", $limit);
    $ret = $stmt->execute();

    return $ret;
  }
  
  public function _close(){
		$this->db = null;
		return true;
	}
  
  public function _read($id){
    $sql = "SELECT `data` FROM `sb_sessions` WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(":id", $id);
    $ret = $stmt->execute();
    $session = $stmt->fetch(PDO::FETCH_ASSOC);

    $ret = ' ';
    if($stmt->rowCount() > 0) {
      $ret = $session['data'];
    }

    return $ret;
  }
  
  public function _write($id, $data){
    $timestamp = time();
    $ua = $_SERVER['HTTP_USER_AGENT'];
    $ip = $this->getUserIPAddress();
    $uid = (isset($_SESSION['uID'])) ? $_SESSION['uID'] : 0;
    $hash = md5($id.$timestamp);

		$sql = "REPLACE INTO `sb_sessions` (`id`, `uid`, `data`, `timestamp`, `ua`, `ip`, hash) 
            VALUES (:id, :uid, :s_data, :time_stamp, :ua, :ip, :hash)";
    $stmt = $this->db->prepare($sql);  
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":uid", $uid);
    $stmt->bindParam(":s_data", $data); 
    $stmt->bindParam(":time_stamp", $timestamp);
    $stmt->bindParam(":ua", $ua);
    $stmt->bindParam(":ip", $ip);
    $stmt->bindParam(":hash", $hash);
    $ret = $stmt->execute();

    return $ret;

  }
  
  public function _destroy($id){
    $sql = "DELETE FROM `sb_sessions` WHERE `id`= :id";
		$stmt = $this->db->prepare($sql);  
    $stmt->bindParam(":id", $id);
    $ret = $stmt->execute();

    return $ret;
  } 
  
  public function _gc($max){
    $time = time() - intval($max);
    $sql = "DELETE FROM `sb_sessions` WHERE timestamp < :limit";
    $stmt->bindParam("limit", $time);
    $ret = $stmt->execute();

    return $ret;
  }
  
  public function getUserIPAddress(){
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP'])){
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    }else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else if(isset($_SERVER['HTTP_X_FORWARDED'])){
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    }else if(isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])){
        $ipaddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
    }else if(isset($_SERVER['HTTP_FORWARDED_FOR'])){
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    }else if(isset($_SERVER['HTTP_FORWARDED'])){
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    }else if(isset($_SERVER['REMOTE_ADDR'])){
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    }else{
        $ipaddress = 'UNKNOWN';
    }

    return $ipaddress;
  }

  public static function updateUID($uID){
    $sID = session_id();

    try {
      $sql = "UPDATE `sb_sessions` SET `uid` = :uID WHERE `id` = :sID";
      $db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);
      $statement = $db->prepare($sql);
      $statement->bindParam(":uID", $uID);
      $statement->bindParam(":sID", $sID);
      $statement->execute();

      return true;

    } catch (PDOException $e) {
      echo $e->getMessage();
    }

  return false;
  }

}
