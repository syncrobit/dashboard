<?php
/**
 * Created by SyncroBit.
 * Author: George Partene
 * Version: 0.1
 */

class SB_WATCHDOG{
    public static function checkFieldEmpty($args){
        foreach($args as $arg){
            if(empty($arg) || $arg == ""){
                return true;
            }
        }

        return false;
    }

    public static function parseUA($ua, $ip){
        $parser = new parseUserAgentStringClass();
        $parser->includeAndroidName = true;
        $parser->includeWindowsName = true;
        $parser->includeMacOSName   = true;
        $parser->parseUserAgentString($ua);
        
        if($parser->type == "PC"){
            $icon = '<i class="fas fa-desktop"></i>';
        }else if($parser->type == "mobile"){
            $icon = '<i class="fas fa-mobile-alt"></i>';
        }else{
            $icon = '<i class="fas fa-robot"></i>';
        }

        $return  = '<div class="ua-wrapper">';
        $return .= '<div class="ua-icon">'.$icon.'</div>';
        $return .= '<div class="ua-info">';
        $return .= '<span class="ua-device-os">'.$parser->osname.'</span>';
        $return .= '<span class="ua-browser-name">'.$parser->browsername.'</span>';
        $return .= '<span class="ua-ip">'.$ip.'</span>';
        $return .= '</div>';
        $return .= '<span style="clear:both"></span>';
        $return .= '</div>';

        return $return;
    }

    public static function insertUserActivity($uID, $title, $description){
        global $msql_db;
        $date   = time();
        $ip     = SB_CORE::getUserIPAddress();

        if(self::checkFieldEmpty(array($uID, $title, $description))){
            return false;
        }

        $uID         = sanitize_sql_string($uID);
        $title       = sanitize_sql_string($title);
        $description = sanitize_sql_string($description);


        try {
            $sql = "INSERT INTO `sb_account_history` (`uid`, `title`, `description`, `date`, `ip`) VALUES (:uID, :h_title, :h_desc, :h_date, :h_ip)";
            $statement = $msql_db->prepare($sql);
            $statement->bindParam(":uID", $uID);
            $statement->bindParam(":h_title", $title);
            $statement->bindParam(":h_desc", $description);
            $statement->bindParam(":h_date", $date);
            $statement->bindParam(":h_ip", $ip);
            
            return ($statement->execute());

        } catch (PDOException $e) {
            error_log($e->getMessage());
        }
        return false;
    }

    public static function getUserActivity($uID, $start = '', $end = ''){
        global $msql_db;
        $start  = sanitize_sql_string($start);
        $end    = sanitize_sql_string($end);

        $now    = time();
        $start  = (empty($start)) ? strtotime("-1 week", $now) : strtotime($start);
        $end    = (empty($end)) ? $now : strtotime("+1 days", strtotime($end));
        $uID    = sanitize_sql_string($uID);

        try {
            $sql = "SELECT `id`, `title`, `description`, `date`, `ip` FROM `sb_account_history` WHERE `uid` = :uID";
            $sql .= " AND `date` BETWEEN :start AND :end ORDER BY `date` DESC";
            $statement = $msql_db->prepare($sql);
            $statement->bindParam(":uID", $uID);
            $statement->bindParam(":start", $start);
            $statement->bindParam(":end", $end);
            $statement->execute();
            
            $return  = '<table class="table table-striped mg-b-0 text-md-nowrap history-table">';
            $return .= '<thead>';
            $return .= '<tr>';
            $return .= '<th>Date</th>';
            $return .= '<th>Title</th>';
            $return .= '<th>Description</th>';
            $return .= '<th>IP Address</th>';
            $return .= '<th></th>';
            $return .= '</tr>'; 
            $return .= '</thead>'; 
            $return .= '<tbody>';

            if($statement->rowCount() > 0){
                while($row = $statement->fetch(PDO::FETCH_ASSOC)){
                    $return .= '<tr>';
                    $return .= '<td scope="row">'.SB_USER::formatUserDate($uID, $row['date']).'</td>';
                    $return .= '<td class="align-middle">'.$row['title'].'</td>';
                    $return .= '<td class="align-middle">'.$row['description'].'</td>';
                    $return .= '<td class="align-middle">';
                    $return .= '<a href="javascript:void(0);" class="show-ip-details" data-ip="'.$row['ip'].'">'.$row['ip'].'</a></td>';
                    $return .= '<td class="text-center align-middle">';
                    $return .= '<a href="javascript:void(0);" class="btn btn-sm btn-danger report" data-id="'.$row['id'].'">Report</a>';
                    $return .= '</td>';
                    $return .= '</tr>';
                }
            }else{
                $return .= '<tr class="no_transactions">';
                $return .= '<th scope="row" colspan="5" class="text-center">No history available...</th>';
                $return .= '</tr>';
            }

            $return .= '</tbody>';
            $return .= '</table>'; 

            return $return;
        } catch (PDOException $e) {
            error_log($e->getMessage());
        }
        return false;
    }

    public static function getIPGeoLocation($ip){
        $response = SB_CORE::getIpCache($ip);
        if(!$respons){
            $uri = SB_CORE::getSetting('geoip_api');
            $key = SB_CORE::getSetting('geoip_api_key'); 
            $req = $uri.$ip."?access_key=".$key;
            $response = SB_CORE::makeRequest($req);
            SB_CORE::setIpCache($ip, $response);
        }

        return json_decode($response, true);
    }

    public static function createIPMap($ip){
        $ip_info = self::getIPGeoLocation($ip);

        $return  = '<script type="text/javascript">';
        $return .= "mapboxgl.accessToken = '".SB_CORE::getSetting('mapbox_key')."'\r\n";
        $return .= "var map = new mapboxgl.Map({\r\n";
        $return .= "container: 'map',\r\n";
        $return .= "style: 'mapbox://styles/petermain/cjyzlw0av4grj1ck97d8r0yrk',\r\n";
        $return .= "center: [".$ip_info['longitude'].", ".$ip_info['latitude']."],\r\n";
        $return .= "zoom: 8\r\n";
        $return .= "});";

        $return .= "var marker = new mapboxgl.Marker()\r\n";
        $return .= ".setLngLat([".$ip_info['longitude'].", ".$ip_info['latitude']."])\r\n";
        $return .= ".addTo(map);\r\n";

        $return .= "map.resize()\r\n";

        $return .= "</script>";
        
        return array(
            "map"       => $return,
            "city"      => $ip_info['city'],
            "state"     => $ip_info['region_name'],
            "country"   => $ip_info['country_name']
        );
    }
}