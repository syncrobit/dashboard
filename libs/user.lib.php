<?php
/**
 * Created by SyncroBit.
 * Author: George Partene
 * Version: 0.1
 */

class SB_USER{
    public static function uID2Email($uID){
        $uID = sanitize_sql_string($uID);
        global $msql_db;

        try {
            $sql = "SELECT email FROM `sb_users` WHERE `id` = :uID";
            $statement = $msql_db->prepare($sql);
            $statement->bindParam(":uID", $uID);
            $statement->execute();

            $row = $statement->fetch(PDO::FETCH_ASSOC);

            return $row['email'];

        } catch (PDOException $e) {
            error_log($e->getMessage());
        }
        return false;
    }

    public static function email2uID($email){
        $email = sanitize_sql_string($email);
        global $msql_db;

        try {
            $sql = "SELECT id FROM `sb_users` WHERE `email` = :email";
            $statement = $msql_db->prepare($sql);
            $statement->bindParam(":email", $email);
            $statement->execute();

            $row = $statement->fetch(PDO::FETCH_ASSOC);

            return $row['id'];

        } catch (PDOException $e) {
            error_log($e->getMessage());
        }
        return false;
    }

    public static function userName2uID($username){
        $username = sanitize_sql_string($username);
        global $msql_db;

        try {
            $sql = "SELECT id FROM `sb_users` WHERE `username` = :username";
            $statement = $msql_db->prepare($sql);
            $statement->bindParam(":username", $username);
            $statement->execute();

            $row = $statement->fetch(PDO::FETCH_ASSOC);

            return $row['id'];

        } catch (PDOException $e) {
            error_log($e->getMessage());
        }
        return false;
    }

    public static function checkIfAccountActive($uID){
        $uID = sanitize_sql_string($uID);
        global $msql_db;

        try {
            $sql = "SELECT id FROM `sb_users` WHERE `active` = :active AND `id` = :uID";
            $statement = $msql_db->prepare($sql);
            $statement->bindValue(":active", 1);
            $statement->bindParam(":uID", $uID);
            $statement->execute();

            return $statement->rowCount() > 0;
        } catch (PDOException $e) {
            error_log($e->getMessage());
        }

        return false;
    }

    public static function updatePasswordForgot($uID, $password){
        if(SB_WATCHDOG::checkFieldEmpty(array($uID, $password))){
            return false;
        }

        global $msql_db;
        $password   = sanitize_sql_string($password);
        $uID        = sanitize_sql_string($uID);

        try {
            $sql = "UPDATE `sb_users` SET `password` = MD5(:pwd) WHERE `id` = :uID";
            $statement = $msql_db->prepare($sql);
            $statement->bindParam(":pwd", $password);
            $statement->bindParam(":uID", $uID);

            if($statement->execute() && SB_AUTH::deleteForgotPwdHash(self::uID2Email($uID))){
                SB_WATCHDOG::insertUserActivity($uID, 'PASSWORD CHANGED', 'Password successfully changed.');
                session_destroy();
                return true;
            }
        } catch (PDOException $e) {
            error_log($e->getMessage());
        }

        return false;
    }

    public static function updatePassword($uID, $password, $current_pass){
        if(SB_WATCHDOG::checkFieldEmpty(array($uID, $password, $current_pass))){
            return "failed";
        }
        
        if(!self::checkCurrentPass($current_pass)){
            return "pass_not_match";
        }

        global $msql_db;
        $password   = sanitize_sql_string($password);
        $uID        = sanitize_sql_string($uID);

        try {
            $sql = "UPDATE `sb_users` SET `password` = MD5(:pwd) WHERE `id` = :uID";
            $statement = $msql_db->prepare($sql);
            $statement->bindParam(":pwd", $password);
            $statement->bindParam(":uID", $uID);

            if($statement->execute()){
                SB_WATCHDOG::insertUserActivity($uID, 'PASSWORD CHANGED', 'Password successfully changed.');
                session_destroy();
                return "success";
            }
        } catch (PDOException $e) {
            error_log($e->getMessage());
        }

        return "failed";

    }

    public static function getRandomAvatar(){
        $avatars = array("001-cat", "002-horse", "003-gorilla", "004-snake", "005-toucan", "006-jaguar", "007-frog",
                         "008-lion", "009-antilope", "010-elephant", "011-giraffe", "012-dog", "013-zebra", "014-koala",
                         "015-coyote", "016-ostrich", "017-duck", "018-tasmanian_devil", "019-shark", "020-fish", "021-octopus",
                         "022-sea_star", "023-goldfish", "024-medusa", "025-crocodile", "026-turtle", "027-snake", "028-lizard",
                         "029-chameleon", "030-bug", "031-bee", "032-butterfly", "033-ant", "034-parrot", "035-caterpillar",
                         "036-spider", "037-stingray", "038-scorpion", "040-crab", "041-reindeer", "042-bear", "043-wolf",
                         "044-owl", "045-rabbit", "046-bunny", "047-cow", "048-pig", "049-rooster", "050-sheep");

        $rand = array_rand($avatars, 1);
        return "default/".$avatars[$rand].".png";
    }

    public static function getUserAvatar($uID){
        $avatar_uri = SB_CORE::getSetting('avatar_uri');
        $uID = sanitize_sql_string($uID);
        global $msql_db;

        try {
            $sql = "SELECT `avatar` FROM `sb_users_settings` WHERE `uid` = :uID";
            $statement = $msql_db->prepare($sql);
            $statement->bindParam(":uID", $uID);
            $statement->execute();
            $row = $statement->fetch(PDO::FETCH_ASSOC);

            return $avatar_uri.$row['avatar'];

        } catch (PDOException $e) {
            error_log($e->getMessage());
        }

        return false;
    }

    public static function getUserName($uID){
        $uID = sanitize_sql_string($uID);
        global $msql_db;

        try {
            $sql = "SELECT `first_name`, `last_name` FROM `sb_users` WHERE `id` = :uID";
            $statement = $msql_db->prepare($sql);
            $statement->bindParam(":uID", $uID);
            $statement->execute();
            $row = $statement->fetch(PDO::FETCH_ASSOC);

            return $row['first_name']." ".substr($row['last_name'], 0, 1).".";

        } catch (PDOException $e) {
            error_log($e->getMessage());
        }

        return false;
    }

    public static function getUserFirstName($uID){
        $uID = sanitize_sql_string($uID);
        global $msql_db;

        try {
            $sql = "SELECT `first_name` FROM `sb_users` WHERE `id` = :uID";
            $statement = $msql_db->prepare($sql);
            $statement->bindParam(":uID", $uID);
            $statement->execute();
            $row = $statement->fetch(PDO::FETCH_ASSOC);

            return $row['first_name'];

        } catch (PDOException $e) {
            error_log($e->getMessage());
        }

        return false;
    }

    public static function getUserDetails($uID){
        $uID = sanitize_sql_string($uID);
        global $msql_db;

        try {
            $sql = "SELECT `first_name`, `last_name`, `email`, `address`, `city`, `state`, `country`, `zip_code` FROM `sb_users` WHERE `id` = :uID";
            $statement = $msql_db->prepare($sql);
            $statement->bindParam(":uID", $uID);
            $statement->execute();
            $row = $statement->fetch(PDO::FETCH_ASSOC);

            return $row;
        } catch (PDOException $e) {
            error_log($e->getMessage());
        }

        return false;
    }

    public static function updateUserDetails($uID, $first_name, $last_name,
                                             $address, $city, $state, $country, $zip_code){

        if(SB_WATCHDOG::checkFieldEmpty(array($first_name, $last_name))){
            return "failed";
        }
        global $msql_db;

        $uID        = sanitize_sql_string($uID);
        $first_name = sanitize_sql_string($first_name);
        $last_name  = sanitize_sql_string($last_name);
        $address    = sanitize_sql_string($address);
        $city       = sanitize_sql_string($city);
        $state      = sanitize_sql_string($state);
        $country    = sanitize_sql_string($country);
        $zip_code   = sanitize_sql_string($zip_code);

        try {
            $sql = "UPDATE `sb_users` SET `first_name` = :first_name, `last_name`= :last_name, 
                    `address` = :addr, `city` = :city, `state` = :state, 
                    `country` = :country, `zip_code` = :zip WHERE `id` = :uID";

            $statement = $msql_db->prepare($sql);
            $statement->bindParam(":uID", $uID);
            $statement->bindParam(":first_name", $first_name);
            $statement->bindParam(":last_name", $last_name);
            $statement->bindParam(":addr", $address);
            $statement->bindParam(":city", $city);
            $statement->bindParam(":state", $state);
            $statement->bindParam(":country", $country);
            $statement->bindParam(":zip", $zip_code);
            
            if($statement->execute()){
                SB_WATCHDOG::insertUserActivity($uID, 'ACCOUNT DETAILS', 'Account details successfully updated.');
                return "success";
            }
            
        } catch (PDOException $e) {
            error_log($e->getMessage());
        }

        return "failed";
    }

    public static function changeEmail($email){
        global $msql_db;

        if(SB_WATCHDOG::checkFieldEmpty(array($email))){
            return "failed";
        }

        //Do hard check on email                                        
        if(SB_AUTH::checkEmailExists($email)){
                return "email_exits";
        }

        $hash   = md5(rand(0, 1000));

        $uID    = sanitize_sql_string($uID);
        $email  = sanitize_sql_string($email);

        try {
            $sql = "UPDATE `sb_users` SET `email` = :email, `active`= 0, `hash` = :hash WHERE `id` = :uID";
            $statement = $msql_db->prepare($sql);
            $statement->bindParam(":uID", $uID);
            $statement->bindParam(":email", $email);
            $statement->bindParam(":hash", $hash);
            
            if($statement->execute()){
                SB_WATCHDOG::insertUserActivity($uID, 'EMAIL CHANGE', 'Email chnage request sent.');
                SB_EMAILS::activationEmail($email, $hash);
                return "success";
            }

            return "failed";
        } catch (PDOException $e) {
            error_log($e->getMessage());
        }

        return "failed";

    }

    public static function getUserSettings($uID){
        $uID = sanitize_sql_string($uID);
        global $msql_db;

        try {
            $sql = "SELECT `time_zone`, `date_format`, `time_format` FROM `sb_users_settings` WHERE `uid` = :uID";
            $statement = $msql_db->prepare($sql);
            $statement->bindParam(":uID", $uID);
            $statement->execute();
            $row = $statement->fetch(PDO::FETCH_ASSOC);

            return $row;
        } catch (PDOException $e) {
            error_log($e->getMessage());
        }

        return false;
    }

    public static function updateUserSettings($uID, $time_zone, $date_format, $time_format, $wallet_address){
        global $msql_db;
        $uID            = sanitize_sql_string($uID);
        $time_zone      = sanitize_sql_string($time_zone);
        $date_format    = sanitize_sql_string($date_format);
        $time_format    = sanitize_sql_string($time_format);

        try {
            $sql = "UPDATE `sb_users_settings` SET `time_zone` = :t_zone, `date_format` = :d_format, 
                            `time_format` = :t_format WHERE `uid` = :uID";
            $statement = $msql_db->prepare($sql);
            $statement->bindParam(":uID", $uID);
            $statement->bindParam(":t_zone", $time_zone);
            $statement->bindParam(":d_format", $date_format);
            $statement->bindParam(":t_format", $time_format);
            
            if($statement->execute()){
                SB_WATCHDOG::insertUserActivity($uID, 'ACCOUNT SETTINGS', 'Account settings successfully changed.');
                return true;
            }
        } catch (PDOException $e) {
            error_log($e->getMessage());
        }

        return false;
    }

    public static function checkCurrentPass($password){
        $password = sanitize_sql_string($password);
        global $msql_db;

        try {
            $sql = "SELECT `id` FROM `sb_users` WHERE `id` = :uID AND `password` = MD5(:password)";
            $statement = $msql_db->prepare($sql);
            $statement->bindParam(":uID", $_SESSION['uID']);
            $statement->bindParam(":password", $password);
            $statement->execute();

            return $statement->rowCount() > 0;

        } catch (PDOException $e) {
            error_log($e->getMessage());
        }

        return false;
    }

    public static function memberSince($uID, $nf = 0){
        $uID = sanitize_sql_string($uID);
        global $msql_db;

        try {
            $sql = "SELECT `member_since` FROM `sb_users` WHERE `id` = :uID";
            $statement = $msql_db->prepare($sql);
            $statement->bindParam(":uID", $uID);
            $statement->execute();
            $row = $statement->fetch(PDO::FETCH_ASSOC);

            return ($nf == 1) ? $row['member_since'] : self::formatUserDate($uID, $row['member_since'], 1);

        } catch (PDOException $e) {
            error_log($e->getMessage());
        }

        return false;
    }

    public static function updateProfileImg($uID, $data){
        global $msql_db;
        $filename = uniqid(rand());

        if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
            $data = substr($data, strpos($data, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif
        
            if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
                throw new \Exception('invalid image type');
            }
            $data = str_replace( ' ', '+', $data );
            $data = base64_decode($data);
        
            if ($data === false) {
                return false;
            }
        } else {
            return false;
        }
        
        file_put_contents(SB_AVATARS.$filename.".".$type, $data);
        $filename = $filename.".".$type;

        try {
            $sql = "UPDATE `sb_users_settings`  SET `avatar` = :img WHERE `uid` = :uID";
            $statement = $msql_db->prepare($sql);
            $statement->bindParam(":uID", $_SESSION['uID']);
            $statement->bindParam(":img", sanitize_sql_string($filename));
            
            if($statement->execute()){
                SB_WATCHDOG::insertUserActivity($_SESSION['uID'], 'ACCOUNT DETAILS', 'Account profile image successfully changed.');
                return true;
            }

        } catch (PDOException $e) {
            error_log($e->getMessage());
        }

        return false;
    }

    public static function getUserSessions($uID){
        $uID = sanitize_sql_string($uID);
        global $msql_db;

        try {
            $sql = "SELECT `id`, `timestamp`, `ua`, `ip` FROM `sb_sessions` WHERE `uid` = :uID ORDER BY `timestamp` DESC";
            $statement = $msql_db->prepare($sql);
            $statement->bindParam(":uID", $uID);
            $statement->execute();

            $return  = '<div class="table-responsive table-wrapper">';
            $return .= '<table class="table table-striped mg-b-0 text-md-nowrap session-table">';
            $return .= '<thead>';
            $return .= '<tr>';
            $return .= '<th>Device</th>';
            $return .= '<th>Date</th>';
            $return .= '<th class="text-center">Actions</th>';
            $return .= '</tr>'; 
            $return .= '</thead>'; 
            $return .= '<tbody>';

            while($row = $statement->fetch(PDO::FETCH_ASSOC)){
                $ua = SB_WATCHDOG::parseUA($row['ua'], $row['ip']);
                $current_seesion = ($row['id'] == session_id()) ? 'class="text-success"' : '';

                $return .= '<tr data-id="'.md5($row['id'].$row['timestamp']).'" '.$current_seesion.'>';
                $return .= '<th scope="row">'.$ua.'</th>';
                $return .= '<td class="align-middle">';
                $return .= self::formatUserDate($_SESSION['uID'], $row['timestamp']);
                $return .= '</td>';
                $return .= '<td class="text-center align-middle">';
                $return .= '<a href="javascript:void(0);" class="btn btn-sm btn-danger destory-session" data-toggle="tooltip-primary" data-placement="top" title="Logout">';
                $return .= '<i class="fas fa-sign-out"></i>';
                $return .= '</a>';
                $return .= '</td>';
                $return .= '</tr>';
            }
            
            $return .= '</tbody>';
            $return .= '</table>'; 
            $return .= '</div>';
            
            return $return;
        } catch (PDOException $e) {
            error_log($e->getMessage());
        }

        return false;
    }

    public static function formatUserDate($uID, $date, $jd = 0){
        $uID = sanitize_sql_string($uID);
        global $msql_db;

        try {
            $sql = "SELECT `time_zone`, `date_format`, `time_format` FROM `sb_users_settings` WHERE `uid` = :uID";
            $statement = $msql_db->prepare($sql);
            $statement->bindParam(":uID", $uID);
            $statement->execute();
            $row = $statement->fetch(PDO::FETCH_ASSOC);

            $datetime       = new DateTime("@".$date);
            $userTimezone   = new DateTimeZone($row['time_zone']);
            $datetime->setTimezone($userTimezone);

            return $datetime->format(($jd == 1) ? $row['date_format'] : $row['date_format'].' '.$row['time_format']);

        } catch (PDOException $e) {
            error_log($e->getMessage());
        }

        return false;
    }

    public static function destroyActiveSession($sID){
        $sID = sanitize_sql_string($sID);
        global $msql_db;

        try {
            $sql = "DELETE FROM `sb_sessions` WHERE `hash` = :sID AND `uid` = :uID";
            $statement = $msql_db->prepare($sql);
            $statement->bindParam(":sID", $sID);
            $statement->bindParam(":uID", $_SESSION['uID']);
            
            if($statement->execute()){
                SB_WATCHDOG::insertUserActivity($_SESSION['uID'], 'ACCOUNT SESSIONS', 'Account session successfully removed.');
                return true;
            }
            

        } catch (PDOException $e) {
            error_log($e->getMessage());
        }

        return false;
    }


    public static function getUserWallets($uID){
        $uID = sanitize_sql_string($uID);
        global $msql_db;

        try {
            $sql = "SELECT `id`, `nickname`, `w_address`, `primary` FROM `sb_user_wallets` WHERE `uid` = :uID";
            $statement = $msql_db->prepare($sql);
            $statement->bindParam(":uID", $uID);
            $statement->execute();

            $return  = '<div class="table-responsive wallets-wrapper">';
            $return .= '<table class="table table-striped mg-b-0 text-md-nowrap wallets-table">';
            $return .= '<thead>';
            $return .= '<tr>';
            $return .= '<th>Nickname</th>';
            $return .= '<th>Balance</th>';
            $return .= '<th class="text-center">Actions</th>';
            $return .= '</tr>'; 
            $return .= '</thead>'; 
            $return .= '<tbody>';

            if($statement->rowCount() > 0){
                while($row = $statement->fetch(PDO::FETCH_ASSOC)){
                    $return .= '<tr data-id="'.$row['id'].'">';
                    $return .= '<td class="d-felx align-items-center">'.$row['nickname']." ";
                    $return .= ($row['primary'] == 1) ? ' <span class="badge badge-primary primary-wallet-badge" style="vertical-align: text-top;">Primary Wallet</span>' : '';
                    $return .= '</td>';
                    $return .= '<td class="align-middle">'.SB_HELIUM::getBalance($row['w_address'], 1).' HNT</td>';
                    $return .= '<td class="text-center align-middle">';
                    $return .= '<a href="javascript:void(0);" class="btn btn-sm btn-primary edit-wallet mr-2" title="Edit">';
                    $return .= '<i class="fas fa-edit"></i>';
                    $return .= '</a>';
                    $return .= '<a href="javascript:void(0);" class="btn btn-sm btn-danger delete-wallet" title="Delete">';
                    $return .= '<i class="fas fa-trash"></i>';
                    $return .= '</a>';
                    $return .= '</td>';
                    $return .= '</tr>';
                }
            }else{
                $return .= '<tr class="no_wallets">';
                $return .= '<th scope="row" colspan="3" class="text-center">You have no wallets. Add a wallet to track</th>';
                $return .= '</tr>';
            }

            $return .= '</tbody>';
            $return .= '</table>'; 
            $return .= '</div>';

            return $return;
        } catch (PDOException $e) {
            error_log($e->getMessage());
        }

        return false;
    }

    public static function checkIfWalletAlreadyAdded($uID, $wAddr){
        $uID    = sanitize_sql_string($uID);
        $wAddr  = sanitize_sql_string($wAddr);
        global $msql_db;

        try {
            $sql = "SELECT id FROM `sb_user_wallets` WHERE `uid` = :uID AND `w_address` = :wAddr";
            $statement = $msql_db->prepare($sql);
            $statement->bindParam(":uID", $uID);
            $statement->bindParam(":wAddr", $wAddr);
            $statement->execute();
            $row = $statement->fetch(PDO::FETCH_ASSOC);

            return ($statement->rowCount() > 0) ? true : false;

        } catch (PDOException $e) {
            error_log($e->getMessage());
        }

        return false;
    }

    public static function uncheckPrimaryWallets($uID){
        $uID = sanitize_sql_string($uID);
        global $msql_db;

        try {
            $sql = "UPDATE `sb_user_wallets` SET `primary` = 0 WHERE `uid` = :uID AND `primary` = 1";
            $statement = $msql_db->prepare($sql);
            $statement->bindParam(":uID", $uID);
            
            return ($statement->execute());
            

        } catch (PDOException $e) {
            error_log($e->getMessage());
        }

        return false;
    }

    public static function checkifPrimaryWallet($uID, $wAddr = ''){
        $uID    = sanitize_sql_string($uID);
        $wAddr  = sanitize_sql_string($wAddr);
        global $msql_db;

        try {
            $sql = "SELECT id FROM `sb_user_wallets` WHERE `uid` = :uID AND `primary` = 1";
            (!empty($wAddr)) ? $sql .= " AND (`w_address` = :wAddr OR `id` = :wAddr)" : "";
            $statement = $msql_db->prepare($sql);
            $statement->bindParam(":uID", $uID);
            (!empty($wAddr)) ? $statement->bindParam(":wAddr", $wAddr) : "";
            $statement->execute();
            $row = $statement->fetch(PDO::FETCH_ASSOC);

            return ($statement->rowCount() > 0) ? true : false;

        } catch (PDOException $e) {
            error_log($e->getMessage());
        }

        return false;
    }

    public static function addWallet($uID, $wNickname, $wAddress, $primary){
        if(!SB_HELIUM::checkIfValidAddress($wAddress)){
            return array("status" => "address_invalid");
        }

        if(self::checkIfWalletAlreadyAdded($uID, $wAddress)){
            return array("status" => "wallet_exists");
        }

        if($primary == 1){
            self::uncheckPrimaryWallets($uID);
        }

        $uID        = sanitize_sql_string($uID);
        $wNickname  = sanitize_sql_string($wNickname);
        $wAddress   = sanitize_sql_string($wAddress);
        $primary    = sanitize_sql_string($primary);
        global $msql_db;

        try {
            $sql = "INSERT INTO `sb_user_wallets` (`uid`, `nickname`, `w_address`, `primary`) VALUES (:uID, :nickname, :w_address, :primary)";
            $statement = $msql_db->prepare($sql);
            $statement->bindParam(":uID", $uID);
            $statement->bindParam(":nickname", $wNickname);
            $statement->bindParam(":w_address", $wAddress);
            $statement->bindParam(":primary", $primary);
            
            if($statement->execute()){
                $wID = $db->lastInsertId();
                SB_WATCHDOG::insertUserActivity($uID, 'WALLET ADDED', 'Wallet successfully added.');

                return array("status"         => "success", 
                             "walletID"       => $wID,
                             "walletNickname" => $wNickname,
                             "walletBalance"  => SB_HELIUM::getBalance($wAddress, 1));
            }else{
                return array("status" => "failed");
            }

        } catch (PDOException $e) {
            error_log($e->getMessage());
        }

        return false;
    } 

    public static function getUserWallet($uID, $wID){
        $uID = sanitize_sql_string($uID);
        $wID = sanitize_sql_string($wID);
        global $msql_db;

        try {
            $sql = "SELECT `nickname`, `w_address`, `primary` FROM `sb_user_wallets` WHERE `uid` = :uID AND `id` = :wID";
            $statement = $msql_db->prepare($sql);
            $statement->bindParam(":uID", $uID);
            $statement->bindParam(":wID", $wID);
            $statement->execute();
            $row = $statement->fetch(PDO::FETCH_ASSOC);

            return array(
                "status" => "success",
                "wallet" => $row
            );

        } catch (PDOException $e) {
            error_log($e->getMessage());
        }

        return array("status" => "failed");
    }

    public static function getUserPrimaryWallet($uID){
        $uID = sanitize_sql_string($uID);
        global $msql_db;

        try {
            $sql = "SELECT `w_address` FROM `sb_user_wallets` WHERE `uid` = :uID AND `primary` = 1";
            $statement = $msql_db->prepare($sql);
            $statement->bindParam(":uID", $uID);
            $statement->execute();
            $row = $statement->fetch(PDO::FETCH_ASSOC);

            return ($statement->rowCount() > 0) ? $row['w_address'] : false;

        } catch (PDOException $e) {
            error_log($e->getMessage());
        }

        return false;
    }


    public static function editUserWallet($uID, $wID, $wNickname, $wAddress, $primary){
        if(!SB_HELIUM::checkIfValidAddress($wAddress)){
            return "address_invalid";
        }

        if($primary == 1){
            self::uncheckPrimaryWallets($uID);
        }else if($primary == 0 && self::checkifPrimaryWallet($uID, $wAddr)){
            return "cannot_unset_primary";
        }

        $uID        = sanitize_sql_string($uID);
        $wID        = sanitize_sql_string($wID);
        $wNickname  = sanitize_sql_string($wNickname);
        $wAddress   = sanitize_sql_string($wAddress);
        $primary    = sanitize_sql_string($primary);
        global $msql_db;

        try {
            $sql = "UPDATE `sb_user_wallets` SET `nickname` = :nickname, `w_address` = :wAddr, `primary` = :primary WHERE `uid` = :uID AND `id` = :wID";
            $statement = $msql_db->prepare($sql);
            $statement->bindParam(":uID", $uID);
            $statement->bindParam(":wID", $wID);
            $statement->bindParam(":nickname", $wNickname);
            $statement->bindParam(":wAddr", $wAddress);
            $statement->bindParam(":primary", $primary);
            
            return ($statement->execute()) ? "success" : "failed";

        } catch (PDOException $e) {
            error_log($e->getMessage());
        }

        return false;
    }

    public static function countUserWallets($uID){
        $uID = sanitize_sql_string($uID);
        global $msql_db;

        try {
            $sql = "SELECT `id` FROM `sb_user_wallets` WHERE `uid` = :uID";
            $statement = $msql_db->prepare($sql);
            $statement->bindParam(":uID", $uID);
            $statement->execute();

            return $statement->rowCount();
        } catch (PDOException $e) {
            error_log($e->getMessage());
        }

        return false;    
    }

    public static function deleteUserWallet($uID, $wID){
        $uID = sanitize_sql_string($uID);
        $wID = sanitize_sql_string($wID);
        global $msql_db;

        if(self::checkifPrimaryWallet($uID, $wID)){
            return array("status" => "cannot_del_primary");
        }

        try {
            $sql = "DELETE FROM `sb_user_wallets` WHERE `uid` = :uID AND `id` = :wID";
            $statement = $msql_db->prepare($sql);
            $statement->bindParam(":uID", $uID);
            $statement->bindParam(":wID", $wID);
            
            if($statement->execute()){
                $count = self::countUserWallets($uID);
                SB_WATCHDOG::insertUserActivity($uID, 'WALLET REMOVED', 'Wallet successfully removed.');

                return array(
                    "status" => "success",
                    "count"  => $count
                );
            }

            return array("status" => "failed");
            

        } catch (PDOException $e) {
            error_log($e->getMessage());
        }

        return false;
    }

    public static function getUserPlanID($uID){
        $uID = sanitize_sql_string($uID);
        global $msql_db;

        try {
            $sql = "SELECT `type` FROM `sb_subscriptions` WHERE `uid` = :uID";
            $statement = $msql_db->prepare($sql);
            $statement->bindParam(":uID", $uID);
            $statement->execute();

            $row = $statement->fetch(PDO::FETCH_ASSOC);
            return $row['type'];

        } catch (PDOException $e) {
            error_log($e->getMessage());
        }

        return false;
    }

    public static function getUserDateFormat($uID){
        $uID = sanitize_sql_string($uID);
        global $msql_db;

        try {
            $sql = "SELECT `date_format` FROM `sb_users_settings` WHERE `uid` = :uID";
            $statement = $msql_db->prepare($sql);
            $statement->bindParam(":uID", $uID);
            $statement->execute();

            $row = $statement->fetch(PDO::FETCH_ASSOC);
            return $row['date_format'];

        } catch (PDOException $e) {
            error_log($e->getMessage());
        }

        return false;
    }


}