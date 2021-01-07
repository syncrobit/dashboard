<?php
/**
 * Created by SyncroBit.
 * Author: George Partene
 * Version: 0.1
 */

class SB_AUTH{

    public static function checkAuth($rev = 0){
        if($rev == 0){
            if(isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] == 1){
                return true;
            }else{
                $_SESSION['isLoggedIn'] = 0;
                header("Location: /login/", true, 302);
                exit();
            }
        }elseif($rev == 1){
            if(isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] == 1){
                header("Location: /overview/", true, 302);
                exit();
            }
        }elseif($rev == 4){
            if(SB_THEME::checkIfPageSecure($_GET['page'])){
                return true;  
            }
            
            return (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] == 1);
            
        }else{
            return (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] == 1);
        }
    }

    public static function makeAuth($username, $password){
        if(SB_WATCHDOG::checkFieldEmpty(array($username, $password))){
            return array(
                "status"    => "empty_fields",
                "redirect"  => ""
            );
        }

        try {
            $sql = "SELECT id, active FROM `sb_users` WHERE `username` = :username AND `password` = MD5(:password)";
            $db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);
            $statement = $db->prepare($sql);
            $statement->bindParam(":username", $username);
            $statement->bindParam(":password", $password);
            $statement->execute();

            if($statement->rowCount() > 0){
                $row = $statement->fetch(PDO::FETCH_ASSOC);
                SB_WATCHDOG::insertUserActivity($row['id'], 'LOGIN', 'Login successful.');

                $_SESSION['isLoggedIn']     = 1;
                $_SESSION['uID']            = $row['id'];
                $_SESSION['last_activity']  = time();
                SB_SESSION::updateUID($row['id']);

                if($row['active'] == 0){
                    $_SESSION['isInactive'] = 1;
                    return array(
                        "status"    => "success",
                        "redirect"  => "/inactive/"
                    );
                }

                return array(
                    "status"    => "success",
                    "redirect"  => "/overview/"
                );
            }

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        SB_WATCHDOG::insertUserActivity(SB_USER::userName2uID($username), 'LOGIN', 'Login failed.');
        return array(
            "status"    => "failed",
            "redirect"  => ""
        );
    }

    public static function registerUser($username, $password, $email, $first_name, $last_name){

        if(SB_WATCHDOG::checkFieldEmpty(array($username, $password, $email, $first_name, $last_name))){
            return "empty_fields";
        }

        if(self::checkIfEmailExists($email)){
            return "email_exits";
        }

        if(self::checkIfUsernameExists($username)){
            return "username_exists";
        }

        $hash = md5(rand(0, 1000));

        try {
            $sql = "INSERT INTO `sb_users` 
                        (`username`, `password`, `email`, `first_name`, `last_name`, `address`, `city`, `state`, `country`, `zip_code`, `hash`, `active`, `pwd_hash`, `member_since`)
                    VALUES (:username, MD5(:password), :email, :first_name, :last_name, NULL, NULL, NULL, NULL, NULL, :hash, 0, NULL, NOW())";
            $db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);
            $statement = $db->prepare($sql);
            $statement->bindParam(":username", $username);
            $statement->bindParam(":password", $password);
            $statement->bindParam(":email", $email);
            $statement->bindParam(":first_name", $first_name);
            $statement->bindParam(":last_name", $last_name);
            $statement->bindParam(":hash", $hash);

            if($statement->execute()){
                $uid = $db->lastInsertId();
                if(self::addUserSettings($uid) && SB_SUBSCRIPTION::insertBasicSub($uid)) {
                    SB_EMAILS::activationEmail($email, $hash);
                    SB_SESSION::updateUID();

                    $_SESSION['isLoggedIn']     = 1;
                    $_SESSION['uID']            = $uid;
                    $_SESSION['isInactive']     = 1;
                    $_SESSION['last_activity']  = time();

                    return "success";
                }
            }
            return "failed";
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return "failed";
    }

    public static function checkInactive(){
        if(!isset($_SESSION['isInactive']) || $_SESSION['isInactive'] != 1){
            header("Location: /login/", true, 302);
            exit();
        }
    }

    public static function incrementActiveTime(){
        $_SESSION['last_activity'] = time();
    }

    public static function checkActiveTime(){
        if(time() >= ($_SESSION['last_activity'] + 60*60)){
            self::logOut();

            return true;
        }

        return false;
    }

    public static function checkIfEmailExists($email){
        try {
            $sql = "SELECT id FROM `sb_users` WHERE `email` = :email";
            $db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);
            $statement = $db->prepare($sql);
            $statement->bindParam(":email", $email);
            $statement->execute();

            return $statement->rowCount() > 0;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return false;
    }

    public static function checkIfUsernameExists($username){
        try {
            $sql = "SELECT id FROM `sb_users` WHERE `username` = :username";
            $db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);
            $statement = $db->prepare($sql);
            $statement->bindParam(":username", $username);
            $statement->execute();

            return $statement->rowCount() > 0;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return false;
    }

    public static function addUserSettings($id){
        $default_tz = SB_CORE::getSetting('default_tz');
        $default_df = SB_CORE::getSetting('default_df');
        $default_tf = SB_CORE::getSetting('default_tf');
        $avatar = SB_USER::getRandomAvatar();

        try {
            $sql = "INSERT INTO `sb_users_settings` (`uid`, `time_zone`, `date_format`, `time_format`, `avatar`)
                    VALUES (:uid, :time_zone, :date_format, :time_format, :avatar)";
            $db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);
            $statement = $db->prepare($sql);
            $statement->bindParam(":uid", $id);
            $statement->bindParam(":time_zone", $default_tz);
            $statement->bindParam(":date_format", $default_df);
            $statement->bindParam(":time_format", $default_tf);
            $statement->bindParam(":avatar", $avatar);

            return $statement->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return false;
    }

    public static function resendEmail($uID){
        $uID = empty($uID) ? $_SESSION['uID'] : $uID;

        if(empty($uID)){
            return "failed";
        }

        if(SB_USER::checkIfAccountActive($uID)){
            return "active";
        }

        $hash = md5(rand(0,1000));
        $email = SB_USER::uID2Email($uID);

        try {
            $sql = "UPDATE `sb_users` SET `hash` = :hash, `active` = 0 WHERE `id` = :uid";
            $db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);
            $statement = $db->prepare($sql);
            $statement->bindParam(":hash", $hash);
            $statement->bindParam(":uid", $uID);

            if($statement->execute()){
                SB_EMAILS::activationEmail($email, $hash);
                return "success";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return "failed";
    }

    public static function checkActivationHash($email, $hash){
        if(SB_WATCHDOG::checkFieldEmpty(array($email, $hash))){
            return false;
        }

        try {
            $sql = "SELECT id FROM `sb_users` WHERE `email` = :email AND `hash` = :hash";
            $db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);
            $statement = $db->prepare($sql);
            $statement->bindParam(":email", $email);
            $statement->bindParam(":hash", $hash);
            $statement->execute();

            return $statement->rowCount() > 0;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return false;
    }

    public static function updateActivationStatus($email){
        if(SB_WATCHDOG::checkFieldEmpty(array($email))){
            return false;
        }

        try {
            $sql = "UPDATE `sb_users` SET `hash` = :hash, `active` = :status WHERE `email` = :email";
            $db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);
            $statement = $db->prepare($sql);
            $statement->bindValue(":hash", NULL);
            $statement->bindValue(":status", 1);
            $statement->bindParam(":email", $email);

            return $statement->execute();

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return false;
    }

    public static function forgotPassword($email){
        if(!self::checkIfEmailExists($email)){
            return "email_not_exist";
        }

        $hash = md5(rand(0,1000));

        try {
            $sql = "UPDATE `sb_users` SET `pwd_hash` = :hash WHERE `email` = :email";
            $db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);
            $statement = $db->prepare($sql);
            $statement->bindParam(":hash", $hash);
            $statement->bindParam(":email", $email);

            if($statement->execute()){
                SB_WATCHDOG::insertUserActivity(SB_USER::email2uID($email), 'FORGOT PASS', 'Forgot password request sent.');
                SB_EMAILS::sendForgotPwdEmail($email, $hash);
                return "success";
            }

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return "failed";
    }

    public static function checkForgotPwdHash($email, $hash){
        if(SB_WATCHDOG::checkFieldEmpty(array($email, $hash))){
            return false;
        }

        try {
            $sql = "SELECT id FROM `sb_users` WHERE `email` = :email AND `pwd_hash` = :hash";
            $db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);
            $statement = $db->prepare($sql);
            $statement->bindParam(":email", $email);
            $statement->bindParam(":hash", $hash);
            $statement->execute();

            return $statement->rowCount() > 0;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return false;
    }

    public static function deleteForgotPwdHash($email){
        try {
            $sql = "UPDATE `sb_users` SET `pwd_hash` = :hash WHERE `email` = :email";
            $db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);
            $statement = $db->prepare($sql);
            $statement->bindParam(":email", $email);
            $statement->bindValue(":hash", NULL);

            return $statement->execute();

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return false;
    }

    public static function logOut(){
        SB_WATCHDOG::insertUserActivity($_SESSION['uID'], 'LOGOUT', 'Logout successful.');
        session_destroy();
        session_write_close();
        session_unset();
        $_SESSION = array();

        return true;
    }



}
