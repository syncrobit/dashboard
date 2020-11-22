<?php
include "includes/initd.inc.php";

//SB_EMAILS::activationEmail('partene.george@gmail.com', 'test');

//echo SB_HELIUM::getLastWeekBalance();
//echo json_encode(SB_CORE::getStates('US'));

function clean($string) {
    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
 }


 function updateRecord($id, $state, $city){
    try {
        $sql = "UPDATE `sb_postal_codes` SET `state_name` = :s_name, `city_name` = :c_name WHERE `id` = :id";
        $db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);
        $statement = $db->prepare($sql);
        $statement->bindParam(":id", $id);
        $statement->bindParam(":s_name", $state);
        $statement->bindParam(":c_name", $city);
        $statement->execute();

        return true;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    
    return false;
 }

 function getRecords(){
    try {
        $sql = "SELECT `id`, `state_name`, `city_name` FROM `sb_postal_codes`";
        $db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);
        $statement = $db->prepare($sql);
        $statement->execute();

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $city = iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE', $row['city_name']);
            $state = iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE', $row['state_name']);
            updateRecord($row['id'], $state, $city);
            echo ".";
        }
        
       return true;

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    
    return false;
 }

 getRecords();
