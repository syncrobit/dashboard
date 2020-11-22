<?php
/**
 * Created by SyncroBit.
 * Author: George Partene
 * Version: 0.1
 */
class SB_THEME{
    public static function replaceWithFunction($file){
        ob_start();
        require_once($file);

        $file = ob_get_contents();

        ob_end_clean();

        preg_match_all("/\{{(.*?)}}/", $file, $output, PREG_PATTERN_ORDER);

        foreach($output[1] as $value){
            preg_match_all("#\((.*?)\)#", $value, $out);

            if(sizeof($out[1]) > 0) {
                foreach ($out[1] as $o) {
                    $val = str_replace("(" . $o . ")", "", $value);
                    $out = explode(",", $o);

                    $file = str_replace("{{" . $value . "}}", call_user_func_array($val, $out), $file);
                }
            }else{
                $file = str_replace("{{".$value."}}", call_user_func($value), $file);
            }
        }

        return $file;
    }

    public static function getResourcesImage($img){
        $resource_uri = SB_CORE::getSetting('resource_uri');
        return $resource_uri."images/".$img;
    }

    public static function getResourceCSS($css){
        $resource_uri = SB_CORE::getSetting('resource_uri');
        return $resource_uri."css/".$css;
    }

    public static function getResourceJs($js){
        $resource_uri = SB_CORE::getSetting('resource_uri');
        return $resource_uri."js/".$js;
    }

    public static function getResourcePlugins($js){
        $resource_uri = SB_CORE::getSetting('resource_uri');
        return $resource_uri."plugins/".$js;
    }

    public static function getResourceDynamicJS(){
        if(file_exists(SB_RESOURCES."pages/".$_GET['page'].".js")){
            $resource_uri = SB_CORE::getSetting('resource_uri');
            return '<script src="'.$resource_uri.'pages/'.$_GET['page'].'.js"></script>';
        }
        return false;
    }

    public static function getFlagImage($flag){
        $resource  = SB_CORE::getSetting('resource_uri');
        return $resource.'images/flags/'.$flag;
    }

    public static function getFlag($flag){
        $resource = SB_CORE::getSetting('resource_uri');
        $flag = $resource."images/flags/".$flag.".png";

        return $flag;
    }

    public static function getUserMenu($menu){
        try {
            $sql = "SELECT `sb_link_name`, `sb_link_uri`, `sb_link_icon` FROM `sb_menu` WHERE `sb_menu_name` = :menu_name";
            $db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);
            $statement = $db->prepare($sql);
            $statement->bindParam(":menu_name", $menu);
            $statement->execute();

            $return = '<ul class="dropdown-menu dropdown-menu-right">';

            while($row = $statement->fetch(PDO::FETCH_ASSOC)){
                $return .= '<li>';
                $return .= '<a href="'.$row['sb_link_uri'].'" class="dropdown-item">';
                $return .= '<i class="'.$row['sb_link_icon'].'"></i> '.$row['sb_link_name'];
                $return .= '</a>';
                $return .= '</li>';
            }

            $return .= '<li class="dropdown-divider"></li>';
            $return .= '<li>';
            $return .= '<a href="javascript:void(0)" class="dropdown-item logout">';
            $return .= '<i class="mdi mdi-logout"></i> Logout';
            $return .= '</a>';
            $return .= '</li>';
            $return .= '</ul>';

            return $return;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return false;
    }

    public static function getMenu($menu){

        try {
            $sql = "SELECT p.id AS parent_id, p.sb_cat_name AS cat_name, c.id AS child_id, c.sb_link_name AS link_name, c.sb_link_uri AS link_uri, c.sb_link_icon AS link_icon FROM sb_menu_cats AS p LEFT JOIN sb_menu AS c ON c.category_id = p.id WHERE p.menu_name = :menu_name";
            $db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);
            $statement = $db->prepare($sql);
            $statement->bindParam(":menu_name", $menu);
            $statement->execute();

            $return = '<ul>';
            $last_parent_id = 0;
            while($row = $statement->fetch(PDO::FETCH_ASSOC)){
                if ( $row['parent_id'] != $last_parent_id ) {
                    $return .= '<li class="menu-title">'.$row['cat_name'].'</li>';
                    $last_parent_id = $row['parent_id'];
                }

                if($row['child_id']){
                    $return .= '<li>';
                    $return .= '<a href="'.$row['link_uri'].'" class="waves-effect">';
                    $return .= '<i class="'.$row['link_icon'].'"></i>';
                    $return .= '<span> '.$row['link_name'].'</span>';
                    $return .= '</a>';
                    $return .= '</li>';
                }

            }

            $return .= '</ul>';
            return $return;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return false;
    }

    public static function checkIfPageSecure($page){
        $page = "/".$page."/";

        try {
            $sql = "SELECT sb_link_secure FROM `sb_menu` WHERE `sb_link_uri` = :uri";
            $db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);
            $statement = $db->prepare($sql);
            $statement->bindParam(":uri", $page);
            $statement->execute();
            $row = $statement->fetch(PDO::FETCH_ASSOC);

            return ($row['sb_link_secure'] == 0 || $row['sb_link_secure'] == 1 && SB_AUTH::checkAuth(2));

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return false;
    }

    public static function getPageTitle($page){
        $page = "/".$page."/";

        try {
            $sql = "SELECT sb_link_name FROM `sb_menu` WHERE `sb_link_uri` = :uri";
            $db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);
            $statement = $db->prepare($sql);
            $statement->bindParam(":uri", $page);
            $statement->execute();
            $row = $statement->fetch(PDO::FETCH_ASSOC);

            return $row['sb_link_name'];

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return false;
    }

    public static function switchPage($page){
        $is_auth = SB_AUTH::checkAuth(2);
        if(empty($page) && $is_auth){
            header("Location: /overview/", true, 302);
            exit();
        }elseif(empty($page) && !$is_auth || !self::checkIfPageSecure($page)){
            header("Location: /login/", true, 302);
            exit();
        }

        if(file_exists(SB_THEMES.SB_THEME."/".$page.".tpl.php")) {
            echo self::replaceWithFunction(SB_THEMES . SB_THEME . "/head.tpl.php");

            if($is_auth){
                echo self::replaceWithFunction(SB_THEMES . SB_THEME . "/header.tpl.php");
            }

            echo self::replaceWithFunction(SB_THEMES . SB_THEME . "/" . $page . ".tpl.php");
            echo self::replaceWithFunction(SB_THEMES . SB_THEME . "/footer.tpl.php");
        }else{
            echo self::replaceWithFunction(SB_THEMES . SB_THEME . "/404.tpl.php");
        }
    }

    public static function getDynmaicCSS($page){
        $page = "/".$page."/";

        try {
            $sql = "SELECT `css` FROM `sb_menu` WHERE `sb_link_uri` = :uri";
            $db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);
            $statement = $db->prepare($sql);
            $statement->bindParam(":uri", $page);
            $statement->execute();
            $row = $statement->fetch(PDO::FETCH_ASSOC);
            
            if(!empty($row['css'])){
                $css          = explode(";", $row['css']);
                $resource_uri = SB_CORE::getSetting('resource_uri');
                $return       = '';
                
                foreach($css as $c){
                    $return .= '<link href="'.$resource_uri.$c.'" rel="stylesheet" type="text/css" />';
                }

                return $return;
            }

            return false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return false;
    }

    public static function getDynamicJS($page){
        $page = "/".$page."/";

        try {
            $sql = "SELECT `js` FROM `sb_menu` WHERE `sb_link_uri` = :uri";
            $db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);
            $statement = $db->prepare($sql);
            $statement->bindParam(":uri", $page);
            $statement->execute();
            $row = $statement->fetch(PDO::FETCH_ASSOC);
            
            if(!empty($row['js'])){
                $js           = explode(";", $row['js']);
                $resource_uri = SB_CORE::getSetting('resource_uri');
                $return       = '';

                foreach($js as $j){
                    $return .= '<script src="'.$resource_uri.$j.'"></script>';
                }

                return $return;
            }
            
            return false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return false;
    }
}