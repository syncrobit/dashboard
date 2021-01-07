<?php
 /**
 * Created by SyncroBit.
 * Author: George Partene
 * Version: 0.1
 */

 class SB_API{
    public static function generateKeys(){
        $key = md5(microtime().rand(1000, 9999));
        $key = substr(strtolower($key), 0, 30);
        $key = implode('-', str_split($key, 6));

        $_SESSION['new_api_key'] = $key;
        return $key;
    }

    public static function addKeys($uID, $appName){
        $time = time();

        try {
            $sql = "INSERT INTO `sb_api_keys` (`uid`, `app_name`, `key`, `created`) 
            VALUES (:uID, :app_name, :akey, :created)";
            $db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);
            $statement = $db->prepare($sql);
            $statement->bindParam(":uID", $uID);
            $statement->bindParam(":app_name", $appName);
            $statement->bindParam(":akey", $_SESSION['new_api_key']);
            $statement->bindParam(":created", $time);
            
            if($statement->execute()){
                $kID = $db->lastInsertId();
                SB_WATCHDOG::insertUserActivity($uID, 'API KEY ADDED', 'API Key successfully added.');
                
                return array(
                    "status"    => "success",
                    "id"        => $kID,
                    "appName"   => $appName,
                    "createdOn" => SB_USER::formatUserDate($uID, $time)
                );
            }

            return array("status" => "failed"); 

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return false;

    }

    public static function getKeysCount($uID){
        try {
            $sql = "SELECT id FROM `sb_api_keys` WHERE `uid` = :uID";
            $db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);
            $statement = $db->prepare($sql);
            $statement->bindParam(":uID", $uID);
            $statement->execute();

            return $statement->rowCount();

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return false;
    }

    public static function deleteKey($uID, $kID){
        try {
            $sql = "DELETE FROM `sb_api_keys` WHERE `uid` = :uID AND `id` = :kID";
            $db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);
            $statement = $db->prepare($sql);
            $statement->bindParam(":uID", $uID);
            $statement->bindParam(":kID", $kID);
            
            if($statement->execute()){
                SB_WATCHDOG::insertUserActivity($uID, 'API KEY REMOVED', 'API Key successfully removed.');
                return array(
                    "status" => "success",
                    "count"  => self::getKeysCount($uID)
                );
            }

            return array("status" => "failed");

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return false;
    }

    public static function getUserKeys($uID){
        try {
            $sql = "SELECT `id`, `app_name`, `key`, `created` FROM `sb_api_keys` WHERE `uid` = :uID";
            $db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);
            $statement = $db->prepare($sql);
            $statement->bindParam(":uID", $uID);
            $statement->execute();

            $return  = '<div class="table-responsive keys-wrapper">';
            $return .= '<table class="table table-striped mg-b-0 text-md-nowrap api-keys-table">';
            $return .= '<thead>';
            $return .= '<tr>';
            $return .= '<th>App Name</th>';
            $return .= '<th>Created on</th>';
            $return .= '<th class="text-center">Actions</th>';
            $return .= '</tr>'; 
            $return .= '</thead>'; 
            $return .= '<tbody>';

            if($statement->rowCount() > 0){
                while($row = $statement->fetch(PDO::FETCH_ASSOC)){
                    $return .= '<tr data-id="'.$row['id'].'">';
                    $return .= '<th scope="row">'.$row['app_name'].'</th>';
                    $return .= '<td class="align-middle">'.SB_USER::formatUserDate($uID, $row['created']).'</td>';
                    $return .= '<td class="text-center align-middle">';
                    $return .= '<a href="javascript:void(0);" class="btn btn-sm btn-primary view-akey mr-2" title="View">';
                    $return .= '<i class="fas fa-eye"></i>';
                    $return .= '</a>';
                    $return .= '<a href="javascript:void(0);" class="btn btn-sm btn-danger delete-akey" title="Delete">';
                    $return .= '<i class="fas fa-trash"></i>';
                    $return .= '</a>';
                    $return .= '</td>';
                    $return .= '</tr>';
                }
            }else{
                $return .= '<tr class="no-apiKeys">';
                $return .= '<th scope="row" colspan="3" class="text-center">You have no API keys. Add a key...</th>';
                $return .= '</tr>';
            }
            
            $return .= '</tbody>';
            $return .= '</table>'; 
            $return .= '</div>';

            return $return;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return false;
    }

    public static function getUserKey($uID, $kID){
        try {
            $sql = "SELECT `key` FROM `sb_api_keys` WHERE `uid` = :uID AND `id` = :kID";
            $db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);
            $statement = $db->prepare($sql);
            $statement->bindParam(":uID", $uID);
            $statement->bindParam(":kID", $kID);
            $statement->execute();

            $row = $statement->fetch(PDO::FETCH_ASSOC);
            return $row['key'];

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return false;
    }
 }