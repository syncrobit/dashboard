<?php
/**
 * Created by SyncroBit.
 * Author: George Partene
 * Version: 0.1
 */

class SB_CORE{
    public static function getSetting($setting){
        try {
            $sql = "SELECT `setting_value` FROM `sb_settings` WHERE `setting_name` = :setting_name";
            $db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);
            $statement = $db->prepare($sql);
            $statement->bindParam(":setting_name", $setting);
            $statement->execute();
            $row = $statement->fetch(PDO::FETCH_ASSOC);

            return $row['setting_value'];

        } catch (PDOException $e) {
           echo $e->getMessage();
        }

        return false;
    }

    public static function getModal($modal){
        if(file_exists(SB_MODALS.$modal.".mod.php")){
            ob_start();
            require_once(SB_MODALS.$modal.".mod.php");
            $file = ob_get_contents();
            ob_end_clean();

            echo $file;
        }
    }

    public static function moneyFormat($amount, $decimals = 3){
        return number_format($amount / 100000000, $decimals);
    }

    function getPercentageChange($oldNumber, $newNumber){
        $decreaseValue = $oldNumber - $newNumber;
    
        return ($decreaseValue / $oldNumber) * 100;
    }

    public static function getCountryID($iso){
    
        try {
            $sql = "SELECT `id` FROM `sb_country_codes` WHERE `iso` = :iso";
            $db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);
            $statement = $db->prepare($sql);
            $statement->bindParam(":iso", $iso);
            $statement->execute();
            $row = $statement->fetch(PDO::FETCH_ASSOC);


            return $row['id'];
                
        } catch (PDOException $e) {
            echo  $e->getMessage();
        }

        return $return;
    }

    public static function getZipCode($iso, $zipCode){
        $zipCode = explode(" ", $zipCode);
        
        try {
            $sql = "SELECT `city_name`, `state_name` FROM `sb_postal_codes` WHERE `iso` = :iso AND `postal_code` LIKE :postal_code";
            $db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);
            $statement = $db->prepare($sql);
            $statement->bindParam(":iso", $iso);
            $statement->bindParam(":postal_code", $zipCode[0]);
            $statement->execute();

            $row = $statement->fetch(PDO::FETCH_ASSOC);
            
            return array("city" => $row['city_name'], "state" => $row['state_name']);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function getStates($selected){
        $selected = self::getCountryID($selected);

        try {
            $sql = "SELECT `state_name` FROM `sb_states` WHERE `country_id` = :country_id";
            $db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);
            $statement = $db->prepare($sql);
            $statement->bindParam(":country_id", $selected);
            $statement->execute();
            $return = array();
            $return[] = array("id" => "", "text" => "");

            if($statement->rowCount() > 0) {
                while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                    $return[] = array("id" => $row['state_name'], "text" => ucfirst(strtolower($row['state_name'])));
                }
            }else{
                $return[] = array("id" => "N/A", "text" => "Other");
            }
        
           return $return;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        
        return false;
    }
}