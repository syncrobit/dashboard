<?php
/**
 * Created by SyncroBit.
 * Author: George Partene
 * Version: 0.1
 */

class SB_CORE{
    public static function getSetting($setting){
        global $msql_db;

        try {
            $sql = "SELECT `setting_value` FROM `sb_settings` WHERE `setting_name` = :setting_name";
            $statement = $msql_db->prepare($sql);
            $statement->bindParam(":setting_name", $setting);
            $statement->execute();
            $row = $statement->fetch(PDO::FETCH_ASSOC);

            return $row['setting_value'];

        } catch (PDOException $e) {
            error_log($e->getMessage());
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

    public static function moneyFormat($amount, $decimals = 3, $no_format = 0){
        if(empty($amount)){
            return "0.00";
        }
        return ($no_format == 0) ? number_format($amount / 100000000, $decimals) : ($amount / 100000000);
    }

    public static function getCountryID($iso){
        global $msql_db;

        try {
            $sql = "SELECT `id` FROM `sb_country_codes` WHERE `iso` = :iso";
            $statement = $msql_db->prepare($sql);
            $statement->bindParam(":iso", $iso);
            $statement->execute();
            $row = $statement->fetch(PDO::FETCH_ASSOC);


            return $row['id'];
                
        } catch (PDOException $e) {
            error_log($e->getMessage());
        }

        return $return;
    }

    public static function getZipCode($iso, $zipCode){
        $zipCode = explode(" ", $zipCode);
        global $msql_db;

        try {
            $sql = "SELECT `city_name`, `state_name` FROM `sb_postal_codes` WHERE `iso` = :iso AND `postal_code` LIKE :postal_code";
            $statement = $msql_db->prepare($sql);
            $statement->bindParam(":iso", $iso);
            $statement->bindParam(":postal_code", $zipCode[0]);
            $statement->execute();

            $row = $statement->fetch(PDO::FETCH_ASSOC);
            
            return array("city" => $row['city_name'], "state" => $row['state_name']);

        } catch (PDOException $e) {
            error_log($e->getMessage());
        }
    }

    public static function getStates($selected){
        $selected = self::getCountryID($selected);
        global $msql_db;

        try {
            $sql = "SELECT `state_name` FROM `sb_states` WHERE `country_id` = :country_id";
            $statement = $msql_db->prepare($sql);
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
            error_log($e->getMessage());
        }
        
        return false;
    }

    /**
     * Maintenance functions
     */

    public static function getMaintenanceState(){
        global $msql_db;

        try {
            $sql = "SELECT `setting_value` FROM `sb_settings` WHERE `setting_name` = :setting_name";
            $statement = $msql_db->prepare($sql);
            $statement->bindValue(":setting_name", "maintenance");
            $statement->execute();
            $row = $statement->fetch(PDO::FETCH_ASSOC);

            return ($row['setting_value'] == 1);

        } catch (PDOException $e) {
            error_log($e->getMessage());
        }

        return true;
    } 

    public static function getMaintenanceDate(){
        global $msql_db;

        try {
            $sql = "SELECT `setting_value` FROM `sb_settings` WHERE `setting_name` = :setting_name";
            $statement = $msql_db->prepare($sql);
            $statement->bindValue(":setting_name", "maintenance_time");
            $statement->execute();
            $row = $statement->fetch(PDO::FETCH_ASSOC);

            $m_date = explode("-", date("Y-m-d-H-i", $row['setting_value']));
            $return  = '<script type="text/javascript">';
            $return .= "window.onload = function () {;\r\n";
            $return .= "$('#count-down').countDown({\r\n";
            $return .= "targetDate: {\r\n";
            $return .= "'day': ".$m_date[2].",\r\n";
            $return .= "'month': ".$m_date[1].",\r\n";
            $return .= "'year': ".$m_date[0].",\r\n";
            $return .= "'hour': ".$m_date[3].",\r\n";
            $return .= "'min': ".$m_date[4].",\r\n";
            $return .= "'sec': 0\r\n";
            $return .= "},\r\n";
            $return .= "omitWeeks: true\r\n";
            $return .= "});\r\n";
            $return .= "};";
            $return .= '</script>';

            return $return;

        } catch (PDOException $e) {
            error_log($e->getMessage());
        }

        return false;
    }

    public static function getMaitenanceAllowed(){
        global $msql_db;

        try {
            $sql = "SELECT `setting_value` FROM `sb_settings` WHERE `setting_name` = :setting_name";
            $statement = $msql_db->prepare($sql);
            $statement->bindValue(":setting_name", "maintenance_allow");
            $statement->execute();
            $row = $statement->fetch(PDO::FETCH_ASSOC);

            $allow_ip = explode(";", $row['setting_value']);
            $u_ip = self::getUserIPAddress();
            
            return (in_array($u_ip, $allow_ip));

        } catch (PDOException $e) {
            error_log($e->getMessage());
        }

        return false;
    }
    /**
     * End Maitenance Functions
     */

    public static function getUserIPAddress(){
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

    public static function formatTimePeriod($uID, $period){
        $time = time();
        switch($period){
            case "30d":
                $range = array(
                    "start" => strtotime("-30 days", $time),
                    "end"   => $time
                );
            break; 
            case "60d":
                $range = array(
                    "start" => strtotime("-60 days", $time),
                    "end"   => $time
                );
            break;
            case "90d":
                $range = array(
                    "start" => strtotime("-90 days", $time),
                    "end"   => $time
                );
            break; 
            case "6m":
                $range = array(
                    "start" => strtotime("-6 Months", $time),
                    "end"   => $time
                );
            break; 
            case "12m":
                $range = array(
                    "start" => strtotime("-1 Year", $time),
                    "end"   => $time
                );
            break;
            case "-1":
                $range = array(
                    "start" => SB_USER::memberSince($uID, 1),
                    "end"   => $time
                );
            break;      
        }

        return $range;
    }

    public static function makeRequest($uri){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $uri);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_FAILONERROR, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 50);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    public static function setIpCache($ip, $cache){
        global $msql_db;

        try {
            $sql = "INSERT INTO `sb_ip_cache` (`ip`, `cache`) VALUES (:ip, :cache)";
            $statement = $msql_db->prepare($sql);
            $statement->bindParam(":ip", $ip);
            $statement->bindParam(":cache", $cache);

            return ($statement->execute());
            
        } catch (PDOException $e) {
            error_log($e->getMessage());
        }

        return false;
    }

    public static function getIpCache($ip){
        global $msql_db;

        try {
            $sql = "SELECT `cache` FROM `sb_ip_cache` WHERE `ip` = :ip";
            $statement = $msql_db->prepare($sql);
            $statement->bindParam(":ip", $ip);
            $statement->execute();

            if($statement->rowCount() > 0){
                $row = $statement->fetch(PDO::FETCH_ASSOC);
                return $row['cache'];
            }
            
        } catch (PDOException $e) {
            error_log($e->getMessage());
        }

        return false;
    }

    public static function loadModules(){
        $files = glob(SB_MODULES."*.mod.php");

        foreach($files as $file){
            require($file);
        }

    }

    public static function millionType($value){
        return ($value / 1000000)."M";
    }

    public static function addMemcache($key, $value, $time){
        $memcache = new Memcache;
        $memcache->connect(SB_MEMCACHED, 11211) or die ("Could not connect");
        $memcache->set('key', $value, false, $time);

        return $value;
    }

    public static function getMemcache($key){
        $memcache = new Memcache;
        $memcache->connect(SB_MEMCACHED, 11211) or die ("Could not connect");

        return $memcache->get('key');
    }
}