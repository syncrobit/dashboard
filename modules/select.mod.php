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

    public static function billingFilterSelect(){

        $select  = '<select data-placeholder="" name="billing_filter" id="billing_filter" class="billing_filter form-control select2noimgsearch" style="width: 100%;">';
        $select .= '<option value="30d">30 Days</option>';
        $select .= '<option value="60d">60 Days</option>';
        $select .= '<option value="90d">90 Days</option>';
        $select .= '<option value="6m" selected="selected">6 Months</option>';
        $select .= '<option value="12m">12 Months</option>';
        $select .= '<option value="-1">All time</option>';
        $select .= '</select>';
        return $select;
    }

    public static function buildUserWalletSelect(){
        try {
            $sql = "SELECT `nickname`, `w_address`, `primary` FROM `sb_user_wallets` WHERE `uid` = :uID";
            $db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);
            $statement = $db->prepare($sql);
            $statement->bindParam(":uID", $_SESSION['uID']);
            $statement->execute();

            $select = '<select name="u_wallet_select" id="u_wallet_select" class="u_wallet_select form-control select2noimg" style="width: 150px;">';
            
            
            if($statement->rowCount() > 0) {
                while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                    if($row['primary'] == 1){
                        $select .= '<option value="' . $row['w_address'] . '" selected>' . $row['nickname'] . '</option>';
                    }else{
                        $select .= '<option value="' . $row['w_address'] . '">' . $row['nickname'] . '</option>';
                    }
                    
                }
            }else{
                $select .= '<option value="N/A">No Wallets</option>';
            }
            $select .= '</select>';

           return $select;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        
        return false;
    }
    
}