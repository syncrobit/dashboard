<?php
/**
 * Created by SyncroBit.
 * Author: George Partene
 * Version: 0.1
 */

class SB_SUBSCRIPTION{
    public static function getUserSubType($uID){
        try {
            $sql = "SELECT sb_packages.package_name AS `name` FROM `sb_subscriptions`
            INNER JOIN `sb_packages` ON sb_subscriptions.type = sb_packages.id WHERE sb_subscriptions.uid = :uID";
            $db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);
            $statement = $db->prepare($sql);
            $statement->bindParam(":uID", $uID);
            $statement->execute();

            $row = $statement->fetch(PDO::FETCH_ASSOC);
            return $row['name']." User";

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return false;
    }

    public static function insertBasicSub($uID){
        $time = time();
        try {
            $sql = "INSERT INTO `sb_subscriptions` (`uid`, `created_on`, `expires_on`, `type`, `renewed_on`) 
                    VALUES (:uID, :created_on, -1, 1, :renewed_on)";
            $db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);
            $statement = $db->prepare($sql);
            $statement->bindParam(":uID", $uID);
            $statement->bindParam(":created_on", $time);
            $statement->bindParam(":renewed_on", $time);
            $statement->execute();

            return true;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return false;
    }

    public static function getAllPackages(){
        try {
            $sql = "SELECT `id`, `package_name`, `package_description`, `package_price` FROM `sb_packages`";
            $db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);
            $statement = $db->prepare($sql);
            $statement->execute();

            $pkgs = array();
            while($row = $statement->fetch(PDO::FETCH_ASSOC)){
                $pkg = '<div class="card pricing-card" style="background: #141b2d !important;">'; 
                $pkg .= '<div class="card-body text-center">'; 
                $pkg .= '<div class="card-category">'.$row['package_name'].'</div>'; 
                $pkg .= '<div class="display-5 my-4">';
                $pkg .= ($row['package_price'] == 0) ? "FREE" : SB_HELIUM::convertUSD2HNT($row['package_price']).' HNT';
                $pkg .= '<span class="tx-20 d-block">Month</span>';
                $pkg .= '</div>'; 
                $pkg .= $row['package_description'];
                $pkg .= '<div class="text-center mt-6">';

                if(SB_USER::getUserPlanID($_SESSION['uID']) == $row['id']){
                    $pkg .= '<a href="#" class="btn btn-secondary btn-block disabled" disabled>';
                    $pkg .= 'Current Plan';
                    $pkg .= '</a>';
                }else{
                    $pkg .= '<a href="#" class="btn btn-primary btn-block select-plan" data-id="'.$row['id'].'">';
                    $pkg .= 'Choose plan';
                    $pkg .= '</a>';
                }
                 
                $pkg .= '</div>'; 
                $pkg .= '</div>'; 
                $pkg .= '</div>';

                $pkgs[] = $pkg;
            }

            return $pkgs;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return false;

    }

    public static function getProgressBar($no, $total, $allowed, $bar){
        $percentage = $no/$total*100;

        $return  = '<div class="progress progress-sm mt-2">';
        if($allowed == -1){
            $return .= '<div aria-valuemax="100" aria-valuemin="0" aria-valuenow="0" class="progress-bar '.$bar.'" role="progressbar"></div>';
        }else{
            $return .= '<div aria-valuemax="100" aria-valuemin="0" aria-valuenow="'.$percentage.'" class="progress-bar '.$bar.'" role="progressbar" style="width: '.$percentage.'%"></div>';
        }
        $return .= '</div>';

        return $return;
    }

    public static function getUserSubInfo($uID){
        
        try {
            $sql = "SELECT `created_on`, `expires_on`, `renewed_on`, `type` FROM `sb_subscriptions` WHERE `uid` = :uID";
            $db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);
            $statement = $db->prepare($sql);
            $statement->bindParam(":uID", $uID);
            $statement->execute();

            $row = $statement->fetch(PDO::FETCH_ASSOC);

            $no_hs = SB_HOTSPOTS::getUserHotspots($uID);
            $allowed_hs = self::getAllowedHotspots($uID);
            $now = time();
            $datediff = $now - $row['expires_on'];
            $days = round($datediff / (60 * 60 * 24));
            $expiration = ($row['expires_on'] == -1) ? "&#8734;" : $days;

            $return = '<div class="card" style="background: #141b2d !important;">';
            $return .= '<div class="card-body iconfont text-left">';  
            $return .= '<div class="d-flex mb-0">';
            $return .= '<div class="">';
            $return .= '<h4 class="mb-1 font-weight-bold">';
            $return .= self::getUserSubType($uID);
            $return .= '</h4>';
            $return .= '<p class="mb-2 tx-12 text-muted">';
            $return .= 'Created on: '.SB_USER::formatUserDate($uID, $row['created_on'], 1);
            $return .= '</p>';
            $return .= '</div>';
            $return .= '<div class="card-chart bg-primary-transparent brround ml-auto mt-0 wd-150">';
            $return .= '<button class="btn btn-primary-gradient btn-block upgrade-mod">Change Plan</button>';
            $return .= '</div>';
            $return .= '</div>'; 
            $return .= self::getProgressBar($no_hs, $allowed_hs, $allowed_hs, 'bg-primary');
            $return .= '<small class="mb-0  text-muted">Hotspots Allowed'; 
            $return .= '<span class="float-right text-muted">'.$no_hs."/".$allowed_hs.' hotspots</span>';
            $return .= '</small>';
            $return .= self::getProgressBar($now, $days, $row['expires_on'], 'bg-pink');
            $return .= '<small class="mb-0  text-muted">Renews in';
            $return .= '<span class="float-right text-muted">'.$expiration.' days</span>';
            $return .= '</small>';
            $return .= '</div>';
            $return .= '</div>';

            return $return;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return false;
    }

    public static function getAllowedHotspots($uID){
        try {
            $sql = "SELECT sb_packages.allowed_hs AS `all_hs` FROM `sb_subscriptions`
            INNER JOIN `sb_packages` ON sb_subscriptions.type = sb_packages.id WHERE sb_subscriptions.uid = :uID";
            $db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);
            $statement = $db->prepare($sql);
            $statement->bindParam(":uID", $uID);
            $statement->execute();

            $row = $statement->fetch(PDO::FETCH_ASSOC);
            return ($row['all_hs'] == -1) ? "&#8734;" : $row['all_hs'];

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return false;
    }


    public static function getPaymentHistory($uID, $period = "6m"){
        $range = SB_CORE::formatTimePeriod($uID, $period);

        try {
            $sql = "SELECT `id`, `amount`, `created_on`, `paid_on`, `transaction_id` FROM `sb_payments` WHERE `uid` = :uID";
            $sql .= " AND `created_on` BETWEEN :start AND :end";
            $db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);
            $statement = $db->prepare($sql);
            $statement->bindParam(":uID", $uID);
            $statement->bindParam(":start", $range['start']);
            $statement->bindParam(":end", $range['end']);
            $statement->execute();
            
            $return  = '<table class="table table-striped mg-b-0 text-md-nowrap wallets-table">';
            $return .= '<thead>';
            $return .= '<tr>';
            $return .= '<th>Date</th>';
            $return .= '<th>Amount</th>';
            $return .= '<th>Transaction ID</th>';
            $return .= '<th class="text-center"></th>';
            $return .= '</tr>'; 
            $return .= '</thead>'; 
            $return .= '<tbody>';

            if($statement->rowCount() > 0){
                while($row = $statement->fetch(PDO::FETCH_ASSOC)){
                    $return .= '<tr data-id="'.$row['id'].'">';
                    $return .= '<th scope="row">'.SB_USER::formatUserDate($uID, $row['created_on'], 1).'</th>';
                    $return .= '<td class="align-middle">'.$row['amount'].' HNT</td>';
                    $return .= '<td class="align-middle">'.$row['transaction_id'].'</td>';
                    $return .= '<td class="text-center align-middle">';
                    if(empty($row['paid_on'])){
                        $return .= '<a href="javascript:void(0);" class="btn btn-sm btn-primary pay-bill">Pay</a>';
                    }else{
                        $return .= '<span class="text-success">Paid</span>';
                    }
                    $return .= '</td>';
                    $return .= '</tr>';
                }
            }else{
                $return .= '<tr class="no_transactions">';
                $return .= '<th scope="row" colspan="4" class="text-center">No history available...</th>';
                $return .= '</tr>';
            }

            $return .= '</tbody>';
            $return .= '</table>'; 

            return $return;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return false;
    }

    public static function updateUserPkg($uID, $pkg){
        $time = time();
        $exp  = strtotime("+1 Month", $time);

        try {
            $sql = "UPDATE `sb_subscriptions` SET `created_on` = :created_on, `expires_on` = :exp_on WHERE `uid` = :uID";
            $db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);
            $statement = $db->prepare($sql);
            $statement->bindParam(":uID", $uID);
            $statement->bindParam(":created_on", $time);
            $statement->bindParam(":exp_on", $exp);

            if($statement->execute()){
                SB_WATCHDOG::insertUserActivity($uID, 'PLAN UPDATED', 'Subscription plan successfully updated.');
                return true;
            }

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return false;
    }

}