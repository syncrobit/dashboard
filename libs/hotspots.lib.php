<?php
/**
 * Created by SyncroBit.
 * Author: George Partene
 * Version: 0.1
 */

class SB_HOTSPOTS{
    public static function getUserHotspots(){
        global $msql_db;

        try {
            $sql = "SELECT `id` FROM `sb_hotspots` WHERE uid = :uID";
            $statement = $msql_db->prepare($sql);
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