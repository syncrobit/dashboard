<?php
/**
 * Created by SyncroBit.
 * Author: George Partene
 * Version: 0.1
 */

class SB_USER{
    public static function uID2Email($uID){
        try {
            $sql = "SELECT email FROM `sb_users` WHERE `id` = :uID";
            $db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);
            $statement = $db->prepare($sql);
            $statement->bindParam(":uID", $uID);
            $statement->execute();

            $row = $statement->fetch(PDO::FETCH_ASSOC);

            return $row['email'];

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return false;
    }

    public static function email2uID($email){
        try {
            $sql = "SELECT id FROM `sb_users` WHERE `email` = :email";
            $db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);
            $statement = $db->prepare($sql);
            $statement->bindParam(":email", $email);
            $statement->execute();

            $row = $statement->fetch(PDO::FETCH_ASSOC);

            return $row['id'];

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return false;
    }

    public static function checkIfAccountActive($uID){
        try {
            $sql = "SELECT id FROM `sb_users` WHERE `active` = :active AND `id` = :uID";
            $db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);
            $statement = $db->prepare($sql);
            $statement->bindValue(":active", 1);
            $statement->bindParam(":uID", $uID);
            $statement->execute();

            return $statement->rowCount() > 0;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return false;
    }

    public static function updatePasswordForgot($uID, $password){
        if(empty($uID) && empty($password)){
            return false;
        }

        try {
            $sql = "UPDATE `sb_users` SET `password` = MD5(:pwd) WHERE `id` = :uID";
            $db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);
            $statement = $db->prepare($sql);
            $statement->bindParam(":pwd", $password);
            $statement->bindParam(":uID", $uID);

            if($statement->execute() && SB_AUTH::deleteForgotPwdHash(self::uID2Email($uID))){
                session_destroy();
                return true;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return false;
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

        try {
            $sql = "SELECT `avatar` FROM `sb_users_settings` WHERE `uid` = :uID";
            
            $db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);
            $statement = $db->prepare($sql);
            $statement->bindParam(":uID", $uID);
            $statement->execute();
            $row = $statement->fetch(PDO::FETCH_ASSOC);

            return $avatar_uri.$row['avatar'];

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return false;
    }

    public static function getUserWalletAddress($uID){
        try {
            $sql = "SELECT `wallet_address` FROM `sb_users_settings` WHERE `uid` = :uID";

            $db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);
            $statement = $db->prepare($sql);
            $statement->bindParam(":uID", $uID);
            $statement->execute();
            $row = $statement->fetch(PDO::FETCH_ASSOC);

            return $row['wallet_address'];
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return false;
    }

    public static function getUserDetails($uID){
        try {
            $sql = "SELECT `first_name`, `last_name`, `email`, `address`, `city`, `state`, `country`, `zip_code` FROM `sb_users` WHERE `id` = :uID";

            $db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);
            $statement = $db->prepare($sql);
            $statement->bindParam(":uID", $uID);
            $statement->execute();
            $row = $statement->fetch(PDO::FETCH_ASSOC);

            return $row;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return false;
    }

    public static function updateUserDetails($uID, $first_name, $last_name, $email, 
                                             $address, $city, $state, $country, $zip_code){
        try {
            $sql = "UPDATE `sb_users` SET `first_name` = :first_name, `last_name`= :last_name, 
                    `email` = :email, `address` = :addr, `city` = :city, `state` = :state, 
                    `country` = :country, `zip_code` = :zip WHERE `id` = :uID";

            $db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);
            $statement = $db->prepare($sql);
            $statement->bindParam(":uID", $uID);
            $statement->bindParam(":first_name", $first_name);
            $statement->bindParam(":last_name", $last_name);
            $statement->bindParam(":email", $email);
            $statement->bindParam(":addr", $address);
            $statement->bindParam(":city", $city);
            $statement->bindParam(":state", $state);
            $statement->bindParam(":country", $country);
            $statement->bindParam(":zip", $zip_code);
            
            return $statement->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return false;
    }

}