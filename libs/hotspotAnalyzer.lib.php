<?php
/**
 * Created by SyncroBit.
 * Author: George Partene
 * Version: 0.1
 */

 class SB_HS_ANALYZER{

     public static function loadChallenges($hs_addr, $num_chlgs = 500){
        global $apiCall;
        $chlgs = array();
        $cursor = '';

        if ($num_chlgs > 5000){
            return "Invalid number of challenges to load";
        }

        while(sizeof($chlgs) < $num_chlgs){
            $path = "hotspots/".$hs_addr."/challenges";

            if(!empty($cursor)){
                $path .= "?cursor=".$cursor;
            }
            
            $result = $apiCall->requestEntity($path);
            $cursor = $result['cursor'];
            array_merge($chlgs, $result['data']);
            echo $path;
        }

        for($i=0; $i < sizeof($chlgs); $i++){
            if($chlgs[$i]['height'] < 430000){
                $chlgs = $chlgs[$i];
            }
        }

        return $chlgs;
     }

     public static function loadHotspots($force = false){

     }

     public static function haversineKm($lat1, $lon1, $lat2, $lon2, $return_heading = false){
        /*
        Calculate the great circle distance between two points
        on the earth (specified in decimal degrees)
        */
        array_map($radians, $lon1, $lat1, $lon2, $lat2);

        $dlon = $lon2 - $lon1;
        $dlat = $lat2 - $lat1;

        $a = sin($dlat/2)**2 + cos($lat1) * cos($lat2) * sin($dlon/2)**2;
        $c = 2 * asin(sqrt($a));
        $r = 6371;  # Radius of earth in kilometers. Use 3956 for miles

        $X = cos($lat2) * sin($dlon);
        $Y = cos($lat1) * sin($lat2) - sin($lat1) * cos($lat2) * cos($dlon);
        $b_rad = atan2($X, $Y);
        $b = (degrees($b_rad) + 360) % 360;

        if ($return_heading){
            return $c * $r.",".$b;
        }
            
        return $c * $r;

     }

     public static function maxRSSI($distKM){
     
        if ($distKM < 0.001){
            return "-1000";
        }
        
        return 28 + 1.8*2 - (20 * log10($distKM) + 20*log10(915) + 32.44);

     }

     public static function SnrMinRSSI($snr){
        /*
        retuns the minimum rssi valid at given snr
        :param snr:
        :return:
        */

        $snr = int(ceil(snr));

        $snr_table = array(
           12  => array(-90, -35),
            4   => array(-115, -112),
           -4   => array(-125, -125),
           16   => array(-90, -35),
          -15   => array(-124, -124),
           -6   => array(-124, -124),
           -1   => array(-125, -125),
           -2   => array(-125, -125),
            5   => array(-115, -100),
           14   => array(-90, -35),
          -11   => array(-125, -125),
            9   => array(-95, -45),
           10   => array(-90, -40),
          -12   => array(-125, -125),
           -7   => array(-123, -123),
          -10   => array(-125, -125),
          -14   => array(-125, -125),
            2   => array(-117, -112),
            6   => array(-113, -100),
           -5   => array(-125, -125),
            3   => array(-115, -112),
           -3   => array(-125, -125),
            1   => array(-120, -117),
            7   => array(-108, -45),
            8   => array(-105, -45),
           -8   => array(-125, -125),
            0   => array(-125, -125),
           13   => array(-90, -35),
          -16   => array(-123, -123),
          -17   => array(-123, -123),
          -18   => array(-123, -123),
          -19   => array(-123, -123),
          -20   => array(-123, -123),
           15   => array(-90, -35),
           -9   => array(-125, -125),
          -13   => array(-125, -125),
           11   => array(-90, -35)
        );

        if(in_array($snr, $snr_table)){
            return $snr_table[$snr][0];
        }

        return "1000";
     }

 }
?>