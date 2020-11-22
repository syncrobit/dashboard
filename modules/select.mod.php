<?php
/**
 * Created by SyncroBit.
 * Author: George Partene
 * Version: 0.1
 */
class SB_SELECT{
    public static function getTimeZoneSelect($selected = ''){
        $regions = array(
            'Africa'        => DateTimeZone::AFRICA,
            'America'       => DateTimeZone::AMERICA,
            'Antarctica'    => DateTimeZone::ANTARCTICA,
            'Asia'          => DateTimeZone::ASIA,
            'Atlantic'      => DateTimeZone::ATLANTIC,
            'Europe'        => DateTimeZone::EUROPE,
            'Indian'        => DateTimeZone::INDIAN,
            'Pacific'       => DateTimeZone::PACIFIC
        );

        $timezones = array();
        $select = '';

        foreach ($regions as $name => $mask) {
            $zones = DateTimeZone::listIdentifiers($mask);
            foreach($zones as $timezone) {

                $time = new DateTime(NULL, new DateTimeZone($timezone));
                $ampm =  ' ('. $time->format('g:i a'). ')';
                $timezones[$name][$timezone] = $timezone . ' - ' . $time->format('H:i') . $ampm;
            }
        }
        $placeholder = "Select Time Zone...";

        $select .= '<select data-placeholder="'.$placeholder.'" name="time_zone" id="time_zone" class="time_zone form-control select2noimg" style="width: 100%;">';
        foreach($timezones as $region => $list) {
            $select .= '<optgroup label="' . $region . '">';

            foreach($list as $timezone => $name) {
                $selected = ($selected == $timezone) ? 'selected' : '';
                $select .= '<option value="' . $timezone . '" '.$selected.'>' . str_replace("_", " ", $name) . '</option>';
            }

            $select .= '</optgroup>';
        }
        $select .= '</select>';

        return $select;
    }

    public static function getCountryCodesSelect($selected = ''){
        $placeholder = 'Select Country...';

        try {
            $sql = "SELECT `iso`, `name` FROM `sb_country_codes`";
            $db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);
            $statement = $db->prepare($sql);
            $statement->execute();

            $select = '<select data-placeholder="'.$placeholder.'" name="country" id="country" class="country form-control select2" style="width: 100%;">';
            $select .= '<option></option>';

            while($row = $statement->fetch(PDO::FETCH_ASSOC)){
                $flag = SB_THEME::getFlag($row['iso']);
                if(!empty($selected)){
                    $select_val = ($selected == $row['iso']) ? 'selected="selected"' : '';
                }else{
                    $select_val = (isset($_SESSION['country']) && strtoupper($_SESSION['country']) == $row['iso']) ? 'selected="selected"' : '';
                }
                $select .= '<option '.$select_val.' data-image="'.$flag.'" value="'.$row['iso'].'">'.ucfirst(strtolower($row['name'])).'</option>';
            }

            $select .= '</select>';

            return $select;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return false;
    }

    public static function getStateSelect($selected){
        $selected = SB_CORE::getCountryID($selected);
        $placeholder = 'Select State...';

        try {
            $sql = "SELECT `state_name` FROM `sb_states` WHERE `country_id` = :country_id";
            $db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);
            $statement = $db->prepare($sql);
            $statement->bindParam(":country_id", $selected);
            $statement->execute();

            $select = '<select data-placeholder="'.$placeholder.'" name="state" id="state" class="state form-control select2noimg" style="width: 100%;">';
            $select .= '<option></option>';

            if($statement->rowCount() > 0) {
                while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                    $select .= '<option value="' . $row['state_name'] . '">' . ucfirst(strtolower($row['state_name'])) . '</option>';
                }
            }else{
                $select .= '<option value="N/A">Other</option>';
            }
            $select .= '</select>';

           return $select;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        
        return false;
    }
    
}