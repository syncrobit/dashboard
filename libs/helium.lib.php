<?php
/**
 * Created by SyncroBit.
 * Author: George Partene
 * Version: 0.1
 */

class SB_HELIUM{

    public static function checkIfValidAddress($address){
        return (strlen($address) == 51 && substr($address, 0, 1) == 1);
    }

    public static function getBlockHeight($format = 0){
        
        try{
            $db = new PDO("pgsql:host=".SB_PG_HOST.";port=5432;dbname=".SB_PG_DATABASE.";user=".SB_PG_USER.";password=".SB_PG_PASSWORD);
            $sql = "select max(height) from blocks";
            $statement = $db->prepare($sql);
            $statement->execute();

            $row = $statement->fetch(PDO::FETCH_ASSOC);
            
            return ($format == 0) ? $row['max'] : number_format($row['max']);

           }catch (PDOException $e){
            echo $e->getMessage();
           }
    }

    public static function getBalance($wallet_addr, $format = 0){
        global $apiCall;
        $balance = $apiCall->requestEntity('accounts/'.$wallet_addr);
        
        return ($format == 0) ? $balance['data']['balance'] : SB_CORE::moneyFormat($balance['data']['balance'], 3);
    }

    public static function getOraclePrice(){
        try{
            $db = new PDO("pgsql:host=".SB_PG_HOST.";port=5432;dbname=".SB_PG_DATABASE.";user=".SB_PG_USER.";password=".SB_PG_PASSWORD);
            $sql = "SELECT price FROM oracle_prices p INNER JOIN blocks b ON p.block = b.height 
                    ORDER BY p.block DESC LIMIT 2";
            $statement = $db->prepare($sql);
            $statement->execute();

            $row = $statement->fetchAll(PDO::FETCH_ASSOC);
            return array(
                "current" => SB_CORE::moneyFormat($row[0]['price'], 2),
                "diff"    => self::calculateDifference($row[0]['price'], $row[1]['price']), 
            );
    
        }catch (PDOException $e){
            echo $e->getMessage();
        }
   
    }

    public static function calculateDifference($current, $last){
        $per = ($current - $last)/$last*100;
        $arrow = ($current > $last) ? "fas fa-arrow-circle-up" : "fas fa-arrow-circle-down";

        return '<i class="fas '.$arrow.' text-white"></i><span class="text-white op-7"> '.number_format($per, 2,'.','').'%</span>';
    }

    public static function getOraclePrices(){
        try{
            $db = new PDO("pgsql:host=".SB_PG_HOST.";port=5432;dbname=".SB_PG_DATABASE.";user=".SB_PG_USER.";password=".SB_PG_PASSWORD);
            $sql = "SELECT price FROM oracle_prices p INNER JOIN blocks b ON p.block = b.height 
                    WHERE to_timestamp(b.time) > (now() - '1 day'::interval)";
            $statement = $db->prepare($sql);
            $statement->execute();

            $prices = array();
            while($row = $statement->fetch(PDO::FETCH_ASSOC)){
                $prices[] = $row['price'];
            }

            return implode(",", $prices);
            
    
        }catch (PDOException $e){
            echo $e->getMessage();
        }
    }

    public static function convertUSD2HNT($amount){
        $oracle = self::getOraclePrice();
        $amount = $amount / $oracle['current'];
        return number_format($amount, 2, '.', '');
    }

    public static function getBlockTime(){
        try{
            $db = new PDO("pgsql:host=".SB_PG_HOST.";port=5432;dbname=".SB_PG_DATABASE.";user=".SB_PG_USER.";password=".SB_PG_PASSWORD);
            $sql = "WITH day_interval as (
                SELECT to_timestamp(time) AS timestamp,
                       time - (lead(time) OVER (order by height desc)) AS diff_time
                FROM blocks
                WHERE to_timestamp(time) > (now() - '1 day'::interval)
            )
            SELECT
                (SELECT avg(diff_time) FROM day_interval)::float AS last_day_avg";
            $statement = $db->prepare($sql);
            $statement->execute();

            $row = $statement->fetch(PDO::FETCH_ASSOC);
            return number_format($row['last_day_avg'],0);

        }catch (PDOException $e){
            echo $e->getMessage();
        }
    }

    public static function getBlockTimes(){
        try{
            $db = new PDO("pgsql:host=".SB_PG_HOST.";port=5432;dbname=".SB_PG_DATABASE.";user=".SB_PG_USER.";password=".SB_PG_PASSWORD);
            $sql = "SELECT time - (lead(time) OVER (ORDER BY height DESC)) AS diff_time FROM blocks 
                    WHERE to_timestamp(time) > (now() - '1 hour'::interval)";
            $statement = $db->prepare($sql);
            $statement->execute();

            $times = array();
            while($row = $statement->fetch(PDO::FETCH_ASSOC)){
                $times[] = $row['diff_time'];
            }

            return implode(",", $times);
            

           }catch (PDOException $e){
            echo $e->getMessage();
           }
    }

    /*Blocks Time Widget */
    public static function getBlockWidgetInfo(){
        return array(
            "chain_height" => self::getBlockHeight(1),
            "block_time"   => self::getBlockTime(),
            "block_chart"  => self::getBlockTimes()
        );
    }

    /* Oracle Prices Widget */
    public static function getOraclePricesWidget(){
        $price = self::getOraclePrice();
        return array(
            "price" => $price['current'],
            "diff"  => $price['diff'],
            "graph" => self::getOraclePrices()
        );
    }

    /* Daily Earnings Widget */
    public static function dailyEarningsWidget(){
        return array(
            "total_rewards" => self::getTodayRewards(),
            "graph"         => self::getYesterdayGraph()
        );
    }

    /* Total Earnings Widget */
    public static function totalEarningsWidget(){
        return array(
            "total_rewards" => self::getAccountTotalRewards(),
            "graph" => self::getWeeklyGraphRewards()
        );
    }

    public static function getAccountTotalRewards(){
        $wallet = SB_USER::getUserPrimaryWallet($_SESSION['uID']);

        if(!$wallet){
            return "0.00";
        }

        try{
            $db = new PDO("pgsql:host=".SB_PG_HOST.";port=5432;dbname=".SB_PG_DATABASE.";user=".SB_PG_USER.";password=".SB_PG_PASSWORD);
            $sql = "SELECT sum(amount) FROM rewards WHERE account = '".$wallet."'";
            $statement = $db->prepare($sql);
            $statement->execute();
            
            $row = $statement->fetch(PDO::FETCH_ASSOC);
            return SB_CORE::moneyFormat($row['sum'], 2); 

           }catch (PDOException $e){
            echo $e->getMessage();
           }

    }

    public static function getTodayRewards(){
        $wallet = SB_USER::getUserPrimaryWallet($_SESSION['uID']);

        if(!$wallet){
            return "0.00";
        }

        try{
            $db = new PDO("pgsql:host=".SB_PG_HOST.";port=5432;dbname=".SB_PG_DATABASE.";user=".SB_PG_USER.";password=".SB_PG_PASSWORD);
            $sql = "SELECT sum(amount) FROM rewards WHERE account = '".$wallet."' 
                    AND DATE(to_timestamp(time)) >= DATE((now() - '1 day'::interval))";

            $statement = $db->prepare($sql);
            $statement->execute();
            
            $row = $statement->fetch(PDO::FETCH_ASSOC);
            return SB_CORE::moneyFormat($row['sum'], 2); 

           }catch (PDOException $e){
            echo $e->getMessage();
           }
    }

    public static function getYesterdayGraph(){
        $wallet = SB_USER::getUserPrimaryWallet($_SESSION['uID']);
        if(!$wallet){
            return false;
        }

        try{
            $db = new PDO("pgsql:host=".SB_PG_HOST.";port=5432;dbname=".SB_PG_DATABASE.";user=".SB_PG_USER.";password=".SB_PG_PASSWORD);
            $sql = "SELECT amount FROM rewards WHERE account = '".$wallet."' 
                    AND DATE(to_timestamp(time)) BETWEEN DATE((now() - '2 day'::interval)) 
                    AND DATE((now() - '1 day'::interval))";

            $statement = $db->prepare($sql);
            $statement->execute();
            
            $rewards = array();
            while($row = $statement->fetch(PDO::FETCH_ASSOC)){
                $rewards[] = SB_CORE::moneyFormat($row['amount'], 2);
            }
            return implode(',', $rewards);  

           }catch (PDOException $e){
            echo $e->getMessage();
           }
    }

    public static function getWeeklyGraphRewards(){
        $wallet = SB_USER::getUserPrimaryWallet($_SESSION['uID']);
        if(!$wallet){
            return false;
        }

        try{
            $db = new PDO("pgsql:host=".SB_PG_HOST.";port=5432;dbname=".SB_PG_DATABASE.";user=".SB_PG_USER.";password=".SB_PG_PASSWORD);
            $sql = "SELECT amount FROM rewards WHERE account = '".$wallet."' 
                    AND DATE(to_timestamp(time)) >= DATE((now() - '7 day'::interval))";

            $statement = $db->prepare($sql);
            $statement->execute();
            
            $rewards = array();
            while($row = $statement->fetch(PDO::FETCH_ASSOC)){
                $rewards[] = SB_CORE::moneyFormat($row['amount'], 2);
            }
            return implode(',', $rewards);  

           }catch (PDOException $e){
            echo $e->getMessage();
           }
    }

    public static function getWeeklyRewardsSum(){
        $wallet = SB_USER::getUserPrimaryWallet($_SESSION['uID']);
        if(!$wallet){
            return false;
        }

        try{
            $db = new PDO("pgsql:host=".SB_PG_HOST.";port=5432;dbname=".SB_PG_DATABASE.";user=".SB_PG_USER.";password=".SB_PG_PASSWORD);
            $sql = "SELECT sum(amount) FROM rewards WHERE account = '".$wallet."' 
                    AND DATE(to_timestamp(time)) BETWEEN DATE((now() - '7 day'::interval)) AND DATE((now() - '1 day'::interval))";

            $statement = $db->prepare($sql);
            $statement->execute();
        
            $row = $statement->fetch(PDO::FETCH_ASSOC);
            return SB_CORE::moneyFormat($row['sum'], 2);

           }catch (PDOException $e){
            echo $e->getMessage();
           }
    }

    public static function getMonthlyRewardsSum(){
            $wallet = SB_USER::getUserPrimaryWallet($_SESSION['uID']);
            if(!$wallet){
                return false;
            }
    
            try{
                $db = new PDO("pgsql:host=".SB_PG_HOST.";port=5432;dbname=".SB_PG_DATABASE.";user=".SB_PG_USER.";password=".SB_PG_PASSWORD);
                $sql = "SELECT sum(amount) FROM rewards WHERE account = '".$wallet."' 
                        AND DATE(to_timestamp(time)) BETWEEN DATE((now() - '30 day'::interval)) AND DATE((now() - '1 day'::interval))";

                $statement = $db->prepare($sql);
                $statement->execute();
                  
                $row = $statement->fetch(PDO::FETCH_ASSOC);
                return SB_CORE::moneyFormat($row['sum'], 2);
    
               }catch (PDOException $e){
                echo $e->getMessage();
               }
    }

    public static function getWeeklyRewards(){
        $wallet = SB_USER::getUserPrimaryWallet($_SESSION['uID']);
        $date_format = str_replace(array(", Y", "-Y", "Y-"),"", SB_USER::getUserDateFormat($_SESSION['uID']));

        if(!$wallet){
            return false;
        }

        try{
            $db = new PDO("pgsql:host=".SB_PG_HOST.";port=5432;dbname=".SB_PG_DATABASE.";user=".SB_PG_USER.";password=".SB_PG_PASSWORD);
            $sql = "SELECT DATE(to_timestamp(time)) as rdate, SUM(amount) FROM rewards WHERE account = '".$wallet."' 
                    AND DATE(to_timestamp(time)) BETWEEN DATE((now() - '7 day'::interval)) AND DATE((now() - '1 day'::interval)) 
                    GROUP BY DATE(to_timestamp(time)) ORDER BY DATE(to_timestamp(time)) ASC";

            $statement = $db->prepare($sql);
            $statement->execute();
            
            $earnings = array();
            $cats = array();
            while($row = $statement->fetch(PDO::FETCH_ASSOC)){
                $earnings[] = SB_CORE::moneyFormat($row['sum'], 2);
                $cats[] = date($date_format, strtotime($row['rdate']));
            }
            return array("series" => $earnings, "categories" => $cats);

           }catch (PDOException $e){
            echo $e->getMessage();
           }
    }

    public static function getMonthlyRewards(){
        $wallet = SB_USER::getUserPrimaryWallet($_SESSION['uID']);
        $date_format = str_replace(array(", Y", "-Y", "Y-"), "", SB_USER::getUserDateFormat($_SESSION['uID']));

        if(!$wallet){
            return false;
        }

        try{
            $db = new PDO("pgsql:host=".SB_PG_HOST.";port=5432;dbname=".SB_PG_DATABASE.";user=".SB_PG_USER.";password=".SB_PG_PASSWORD);
            $sql = "SELECT DATE(to_timestamp(time)) as rdate, SUM(amount) FROM rewards WHERE account = '".$wallet."' 
                    AND DATE(to_timestamp(time)) BETWEEN DATE((now() - '30 day'::interval)) AND DATE((now() - '1 day'::interval)) 
                    GROUP BY DATE(to_timestamp(time)) ORDER BY DATE(to_timestamp(time)) ASC";

            $statement = $db->prepare($sql);
            $statement->execute();
            
            $earnings = array();
            $e_dates = array();
            while($row = $statement->fetch(PDO::FETCH_ASSOC)){
                $e_dates[]  = date($date_format, strtotime($row['rdate']));
                $earnings[] = SB_CORE::moneyFormat($row['sum'], 2); 
            }
            return array(
                "series"       => $earnings,
                "categories"   => $e_dates
            );

           }catch (PDOException $e){
            echo $e->getMessage();
           }
    }

    public static function getWeeklyRewardsGraphWidget(){
        return array(
            "graph"         => self::getWeeklyRewards(),
            "weekly_sum"    => self::getWeeklyRewardsSum()
        );
    }

    public static function getMonthlyRewardsWidget(){
        return array(
            "graph"         => self::getMonthlyRewards(),
            "monthly_sum"    => self::getMonthlyRewardsSum()
        );
    }

    public static function getHotSpots(){
        $return  = '<div class="table-responsive table-wrapper hotspots-wrapper">';
        $return .= '<table class="table table-striped mg-b-0 text-md-nowrap wallets-table">';
        $return .= '<thead>';
        $return .= '<tr>';
        $return .= '<th>Hotspot name</th>';
        $return .= '<th>Location</th>';
        $return .= '<th>Status</th>';
        $return .= '<th>Height</th>';
        $return .= '<th class="text-center">Rewards</th>';
        $return .= '</tr>';
        $return .= '</thead>';
        $return .= '<tbody>';

        $return .= '<tr>';
        $return .= '<td colspan="5" class="text-center">No Hotspots available...</td>';
        $return .= '</tr>';

        $return .= '</tbody>';
        $return .= '</table>';
        $return .= '</div>';

        return $return;
    }

    public static function getNetowrkTotalHotspots($format = 0){
        try{
            $db = new PDO("pgsql:host=".SB_PG_HOST.";port=5432;dbname=".SB_PG_DATABASE.";user=".SB_PG_USER.";password=".SB_PG_PASSWORD);
            $sql = "SELECT value FROM stats_inventory WHERE name = :vname";

            $statement = $db->prepare($sql);
            $statement->bindValue("vname", "hotspots");
            $statement->execute();
              
            $row = $statement->fetch(PDO::FETCH_ASSOC);
            return ($format == 0) ? number_format($row['value'], 0) : $row['value'];

           }catch (PDOException $e){
            echo $e->getMessage();
           }
    }

    public static function getActiveHotspots(){
        try{
            $db = new PDO("pgsql:host=".SB_PG_HOST.";port=5432;dbname=".SB_PG_DATABASE.";user=".SB_PG_USER.";password=".SB_PG_PASSWORD);
            $sql = "SELECT COUNT(*) FROM gateway_status WHERE online = :status";

            $statement = $db->prepare($sql);
            $statement->bindValue(":status", "online");
            $statement->execute();
              
            $row = $statement->fetch(PDO::FETCH_ASSOC);
            return ($format == 0) ? number_format($row['count'], 0) : $row['count'];

           }catch (PDOException $e){
            echo $e->getMessage();
           }
    }

    public static function getHotSpotsWidget(){
        return array(
            "total_hs"      => self::getNetowrkTotalHotspots(),
            "available_hs"  => self::getActiveHotspots()
        );
    }

    public static function getChainVar($var){
        try{
            $db = new PDO("pgsql:host=".SB_PG_HOST.";port=5432;dbname=".SB_PG_DATABASE.";user=".SB_PG_USER.";password=".SB_PG_PASSWORD);
            $sql = "SELECT value FROM vars_inventory WHERE name=:var_name";

            $statement = $db->prepare($sql);
            $statement->bindParam(":var_name", $var);
            $statement->execute();
              
            $row = $statement->fetch(PDO::FETCH_ASSOC);
            return $row['value'];

           }catch (PDOException $e){
            echo $e->getMessage();
           }
    }

    public static function getLastElectionBlock($format = 0){
        try{
            $db = new PDO("pgsql:host=".SB_PG_HOST.";port=5432;dbname=".SB_PG_DATABASE.";user=".SB_PG_USER.";password=".SB_PG_PASSWORD);
            $sql = "SELECT to_timestamp(time), block FROM transactions WHERE type = 'consensus_group_v1' 
                    AND to_timestamp(time) BETWEEN (now() - '6 hour'::interval) AND now() ORDER by block desc limit 1";

            $statement = $db->prepare($sql);
            $statement->bindParam(":var_name", $var);
            $statement->execute();
              
            $row = $statement->fetch(PDO::FETCH_ASSOC);
            return ($format == 0)? number_format($row['block'], 0) : $row['block'];

           }catch (PDOException $e){
            echo $e->getMessage();
           }
    }

    public static function getElectionTimes(){
        try{
            $db = new PDO("pgsql:host=".SB_PG_HOST.";port=5432;dbname=".SB_PG_DATABASE.";user=".SB_PG_USER.";password=".SB_PG_PASSWORD);
            $sql = "SELECT to_timestamp(time), time - lag(time, 1) over (order by time) AS times 
                    FROM transactions WHERE type = 'consensus_group_v1' AND to_timestamp(time) BETWEEN (now() - '6 hour'::interval) AND now() 
                    ORDER BY time DESC LIMIT 10";

            $statement = $db->prepare($sql);
            $statement->bindParam(":var_name", $var);
            $statement->execute();
            
            $times = array();
            while($row = $statement->fetch(PDO::FETCH_ASSOC)){
                $times[] = floor(($row['times'] / 60) % 60);
            }
            
            return array("time" => $times[0], "times" => implode(",",$times));
           }catch (PDOException $e){
            echo $e->getMessage();
           }
    }

    public static function CGElectionWidget(){
        return array(
            "election_time" => self::getLastElectionBlock(),
            "graph"         => self::getElectionTimes()
        );
    }

    public static function getTokenSupply($format = 0){
        try{
            $db = new PDO("pgsql:host=".SB_PG_HOST.";port=5432;dbname=".SB_PG_DATABASE.";user=".SB_PG_USER.";password=".SB_PG_PASSWORD);
            $sql = "SELECT (sum(balance) / 100000000)::float as token_supply FROM account_inventory";

            $statement = $db->prepare($sql);
            $statement->execute();
              
            $row = $statement->fetch(PDO::FETCH_ASSOC);
            return ($format == 0)? number_format($row['token_supply'], 2) : $row['token_supply'];

           }catch (PDOException $e){
            echo $e->getMessage();
           }
    }

    public static function getTokenSupplyWidget(){
        $m_reward = SB_HELIUM::getChainVar('monthly_reward');
        $m_reward = SB_CORE::moneyFormat($m_reward, 0, 1);
        $m_reward = SB_CORE::millionType($m_reward);

        return array("m_supply" => $m_reward, "total_supply" => self::getTokenSupply());
    }

    public static function getUsage7Day(){
        $wallet = SB_USER::getUserPrimaryWallet($_SESSION['uID']);
        $date_format = str_replace(array(", Y", "-Y", "Y-"), "", SB_USER::getUserDateFormat($_SESSION['uID']));

        try{
            $db = new PDO("pgsql:host=".SB_PG_HOST.";port=5432;dbname=".SB_PG_DATABASE.";user=".SB_PG_USER.";password=".SB_PG_PASSWORD);
            $sql = "SELECT DATE(to_timestamp(time)), SUM(num_packets) AS pkts, SUM(num_dcs) AS dcs 
                    FROM public.packets WHERE DATE(to_timestamp(time)) 
                    BETWEEN DATE((now() - '7 day'::interval)) AND DATE((now() - '1 day'::interval)) 
                    GROUP BY DATE(to_timestamp(time)) ORDER BY DATE(to_timestamp(time)) ASC";

            $statement = $db->prepare($sql);
            $statement->execute();
            
            $dcs = array();
            $pkts = array();
            $date = array();
            while($row = $statement->fetch(PDO::FETCH_ASSOC)){
                $dcs[]  = $row['dcs'];
                $pkts[] = $row['pkts'];
                $date[] = date($date_format, strtotime($row['date']));
            }
            
            return array(
                "dcs"               => $dcs, 
                "dcs_sum"           => array_sum($dcs),
                "dcs_sum_formatted" => number_format(array_sum($dcs), 0),
                "pkts"              => $pkts, 
                "pkts_sum"          => array_sum($pkts),
                "pkts_sum_formatted"=> number_format(array_sum($pkts), 0),
                "dates"             => $date,
            );

           }catch (PDOException $e){
            echo $e->getMessage();
           }
    }

    public static function getDCUsageInUSD7Days(){
        $wallet = SB_USER::getUserPrimaryWallet($_SESSION['uID']);
        $date_format = str_replace(array(", Y", "-Y", "Y-"), "", SB_USER::getUserDateFormat($_SESSION['uID']));

        try{
            $db = new PDO("pgsql:host=".SB_PG_HOST.";port=5432;dbname=".SB_PG_DATABASE.";user=".SB_PG_USER.";password=".SB_PG_PASSWORD);
            $sql = "SELECT DATE(to_timestamp(time)), SUM(num_dcs) AS dcs, (SUM(num_dcs) * 1.0E-5) AS USD
                    FROM public.packets WHERE DATE(to_timestamp(time)) 
                    BETWEEN DATE((now() - '7 day'::interval)) AND DATE((now() - '1 day'::interval)) 
                    GROUP BY DATE(to_timestamp(time)) ORDER BY DATE(to_timestamp(time)) ASC";

            $statement = $db->prepare($sql);
            $statement->execute();
            
            $dcs = array();
            $date = array();
            $dollar = array();
            $dollar_from = array();
            while($row = $statement->fetch(PDO::FETCH_ASSOC)){
                $dcs[]  = $row['dcs'];
                $date[] = date($date_format, strtotime($row['date']));
                $dollar[] = $row['usd'];
                $dollar_from[] = number_format($row['usd'], 2);
            }
            
            return array(
                "dcs"               => $dcs, 
                "dcs_sum"           => array_sum($dcs),
                "dcs_sum_formatted" => number_format(array_sum($dcs), 0),
                "dates"             => $date,
                "usd_sum"           => array_sum($dollar),
                "usd_sum_formatted" => number_format(array_sum($dollar), 2),
                "usd"               => $dollar,
                "usd_formatted"     => $dollar_from
            );

           }catch (PDOException $e){
            echo $e->getMessage();
           }
    }

    public static function getBlockAverageTimes(){
        $wallet = SB_USER::getUserPrimaryWallet($_SESSION['uID']);
        $date_format = str_replace(array(", Y", "-Y", "Y-"), "", SB_USER::getUserDateFormat($_SESSION['uID']));

        try{
            $db = new PDO("pgsql:host=".SB_PG_HOST.";port=5432;dbname=".SB_PG_DATABASE.";user=".SB_PG_USER.";password=".SB_PG_PASSWORD);
            //Average 15 mins
            $sql_avg15 = "SELECT timestamp AS time, avg(duration) AS avg_15_min FROM 
            (SELECT timestamp, (time - lag(time, 1) over (ORDER BY time)) AS duration FROM blocks ORDER BY height DESC) 
            AS durations WHERE timestamp BETWEEN (now() - '6 hours'::interval) AND now() 
            GROUP BY (now() - '15 minutes'::interval), timestamp ORDER BY time DESC LIMIT 20";

            //Average 30 mins
            $sql_avg30 = "SELECT timestamp AS time, avg(duration) AS avg_30_min FROM 
            (SELECT timestamp, (time - lag(time, 1) over (ORDER BY time)) AS duration FROM blocks ORDER BY height DESC) 
            AS durations WHERE timestamp BETWEEN (now() - '6 hours'::interval) AND now() 
            GROUP BY (now() - '30 minutes'::interval), timestamp ORDER BY time DESC LIMIT 20";

            //Average 1 mins
            $sql_avg1 = "SELECT timestamp AS time, avg(duration) AS avg_1_min FROM 
            (SELECT timestamp, (time - lag(time, 1) over (ORDER BY time)) AS duration FROM blocks ORDER BY height DESC) 
            AS durations WHERE timestamp BETWEEN (now() - '6 hours'::interval) AND now() 
            GROUP BY (now() - '1 minute'::interval), timestamp ORDER BY time DESC LIMIT 20";

            $avg15 = $db->prepare($sql_avg15);
            $avg15->execute();

            $avg30 = $db->prepare($sql_avg30);
            $avg30->execute();

            $avg1 = $db->prepare($sql_avg1);
            $avg1->execute();

            $date = array();
            $res_15 = array();
            $res_30 = array();
            $res_1 = array();

            $row15 = $avg15->fetchAll(PDO::FETCH_ASSOC);
            $row30 = $avg30->fetchAll(PDO::FETCH_ASSOC);
            $row1 = $avg1->fetchAll(PDO::FETCH_ASSOC);

            for($i = 0; sizeof($row15) > $i ; $i++){
                $date[]     = date($date_format, strtotime($row15[$i]['time']));
                $res_15[]   = $row15[$i]['avg_15_min'];
                $res_30[]   = $row30[$i]['avg_30_min'];
                $res_1[]    = $row1[$i]['avg_1_min'];
            }
                
            return array(
                "dates" => $date, 
                "avg_15" => $res_15, 
                "avg_30" => $res_30, 
                "avg_1" => $res_1);

        }catch (PDOException $e){
            echo $e->getMessage();
           }
    }
}
