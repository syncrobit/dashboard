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

    public static function buildCountrySelect($selected = ''){

    }
}