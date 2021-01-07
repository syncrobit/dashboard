<?php
/**
 * Created by SyncroBit.
 * Author: George Partene
 * Version: 0.1
 */

class SB_HOTSPOTS{
    public static function getUserHotspots(){
        try {
            $sql = "SELECT `id` FROM `sb_hotspots` WHERE uid = :uID";
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

    public static function getHotspotList(){
        $address = '';
        
    }
}