<?php
/**
 * Created by SyncroBit.
 * Author: George Partene
 * Version: 0.1
 */

class SB_HELIUM{

    public static function getBlockHeight($format = 0){
        global $apiCall;
        $height = $apiCall->requestEntity('blocks/height');
        return ($format == 0) ? $height['data']['height'] : number_format($height['data']['height']);
    }

    public static function getBalance($format = 0){
        global $apiCall;
        $wallet_addr = SB_USER::getUserWalletAddress($_SESSION['uID']);
        $balance = $apiCall->requestEntity('accounts/'.$wallet_addr);
        
        return ($format == 0) ? $balance['data']['balance'] : SB_CORE::moneyFormat($balance['data']['balance'], 3);
    }

    public static function getOraclePrice(){
        global $apiCall;
        $price = $apiCall->requestEntity('oracle/prices/current');
        return SB_CORE::moneyFormat($price['data']['price'], 2);
    }

    public static function getOraclePriceWHistory($format = 0){
        global $apiCall;
        $price_h = $apiCall->requestEntity('oracle/prices');
        $compare = ($price_h['data'][0]['price'] > $price_h['data'][1]['price']) ? "mdi-arrow-up text-success" : "mdi-arrow-down text-danger";
        $percentage = SB_CORE::getPercentageChange($price_h['data'][0]['price'], $price_h['data'][1]['price']);

        return array("current"      => SB_CORE::moneyFormat($price_h['data'][0]['price'], 2),
                     "icon"         => $compare,
                     "percentage"   => number_format($percentage, 2));
    }

    public static function getBlockTime(){
        global $apiCall;
        $block_time = $apiCall->requestEntity('stats');

        return number_format($block_time['data']['block_times']['last_day']['avg'],0);
    }

    public static function getLastWeekBalance(){
        global $apiCall;
        $wallet_addr = SB_USER::getUserWalletAddress($_SESSION['uID']);
    
        $start_week_lw = strtotime("last sunday midnight", strtotime("-1 week"));
        $start_week_tw = strtotime("last sunday midnight", time());

        $end_week_lw = strtotime("next saturday", $start_week_lw);
        $end_week_tw = strtotime("next saturday", $start_week_tw);

        $start_week_lw = date("Y-m-d\TH:i:s", $start_week_lw)."Z";
        $start_week_tw = date("Y-m-d\TH:i:s", $start_week_tw)."Z";
        
        $end_week_lw = date("Y-m-d\TH:i:s", $end_week_lw)."Z";
        $end_week_tw = date("Y-m-d\TH:i:s", $end_week_tw)."Z";

        $balance_tw  = $apiCall->requestEntity('accounts/'.$wallet_addr.'/rewards/sum?min_time='.$start_week_tw.'&max_time='.$end_week_tw);
        $balance_lw = $apiCall->requestEntity('accounts/'.$wallet_addr.'/rewards/sum?min_time='.$start_week_lw.'&max_time='.$end_week_lw);
        $percentage = SB_CORE::getPercentageChange($balance_tw['data']['sum'], $balance_lw['data']['sum']);
        
        return number_format($percentage, 2);
    }

    public static function getOverViewSummary(){
        return array("block_height"     => self::getBlockHeight(1),
                     "block_time"       => self::getBlockTime(),
                     "balance"          => self::getBalance(1),
                     "balance_trend"    => self::getLastWeekBalance(),
                     "price_history"    => self::getOraclePriceWHistory()
                    );
    }

    public static function getDataUsage(){
        $host = SB_CORE::getSetting('etl_db_host');
        $user = SB_CORE::getSetting('etl_username');
        $pass = SB_CORE::getSetting('etl_password');
        $db   = SB_CORE::getSetting('etl_db');

        try{
            // create a PostgreSQL database connection
            $conn = new PDO("pgsql:host=$host;port=5432;dbname=$db;user=$user;password=$pass");
            
            // display a message if connected to the PostgreSQL successfully
            if($conn){
                
            }
           }catch (PDOException $e){
            // report error message
            echo $e->getMessage();
           }
    }
}
