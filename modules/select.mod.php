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
}