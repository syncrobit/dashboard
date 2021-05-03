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
        return $resource_uri."img/".$img;
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
        if(isset($_GET['item'])){
            if(file_exists(SB_RESOURCES."js/subitems/".$_GET['item'].".js")){
                $resource_uri = SB_CORE::getSetting('resource_uri');
                return '<script src="'.$resource_uri.'js/subitems/'.$_GET['item'].'.js"></script>';
            }
        }else{
            if(file_exists(SB_RESOURCES."js/pages/".$_GET['page'].".js")){
                $resource_uri = SB_CORE::getSetting('resource_uri');
                return '<script src="'.$resource_uri.'js/pages/'.$_GET['page'].'.js"></script>';
            }
        }
        return false;
    }

    public static function getFlagImage($flag){
        $resource  = SB_CORE::getSetting('resource_uri');
        return $resource.'img/flags/'.$flag;
    }

    public static function getFlag($flag){
        $resource = SB_CORE::getSetting('resource_uri');
        $flag = $resource."img/flags/".$flag.".png";

        return $flag;
    }

    public static function getUserMenu($menu){
        $menu   = sanitize_sql_string($menu);
        global $msql_db;

        try {
            $sql = "SELECT `sb_link_name`, `sb_link_uri`, `sb_link_icon` FROM `sb_menu` WHERE `sb_menu_name` = :menu_name";
            $statement = $msql_db->prepare($sql);
            $statement->bindParam(":menu_name", $menu);
            $statement->execute();

            $return  = '<div class="dropdown-menu">';
            $return .= '<div class="main-header-profile bg-primary p-3">';
            $return .= '<div class="d-flex wd-100p">';
            $return .= '<div class="main-img-user">';
            $return .= '<img src="'.SB_USER::getUserAvatar($_SESSION['uID']).'" alt="profile image" />';
            $return .= '</div>';
            $return .= '<div class="ml-3 my-auto">';
            $return .= '<h6>'.SB_USER::getUserName($_SESSION['uID']).'</h6>';
            $return .= '<span>'.SB_SUBSCRIPTION::getUserSubType($_SESSION['uID']).'</span>';
            $return .= '</div>';
            $return .= '</div>';
            $return .= '</div>';

            while($row = $statement->fetch(PDO::FETCH_ASSOC)){
                $return .= '<a class="dropdown-item" href="'.$row['sb_link_uri'].'">';
                $return .= '<i class="'.$row['sb_link_icon'].'"></i> '.$row['sb_link_name'];
                $return .= '</a>';
            }

            $return .= '<a class="dropdown-item logout" href="javascript:void(0)">';
            $return .= '<i class="fas fa-sign-out"></i> Sign Out';
            $return .= '</a>';
            $return .= '</div>';

            return $return;
        } catch (PDOException $e) {
            error_log($e->getMessage());
        }

        return false;
    }

    public static function getMenuChildren($menu, $pID){
        $menu = sanitize_sql_string($menu);
        global $msql_db;

        try {
            $sql = "SELECT `id`, `sb_link_name`, `sb_link_uri`, `sb_link_icon` FROM `sb_menu` WHERE `sb_menu_name` = :menu_name AND `category_id` = :cat_id";
            $statement = $msql_db->prepare($sql);
            $statement->bindParam(":menu_name", $menu);
            $statement->bindParam(":cat_id", $pID);
            $statement->execute();

            $row = $statement->fetchAll(PDO::FETCH_ASSOC);

            return $row;
        } catch (PDOException $e) {
            error_log($e->getMessage());
        }

        return false;
    }

    public static function getMenu($menu){
        $menu = sanitize_sql_string($menu);
        global $msql_db;

        try {
            $sql = "SELECT `id`, `sb_cat_name` FROM `sb_menu_cats` WHERE `menu_name` = :menu_name";
            $statement = $msql_db->prepare($sql);
            $statement->bindParam(":menu_name", $menu);
            $statement->execute();

            $return = '<ul class="side-menu">';
            
            while($row = $statement->fetch(PDO::FETCH_ASSOC)){
                $return .= '<li class="side-item side-item-category">'.$row['sb_cat_name'].'</li>';
                $children = self::getMenuChildren($menu, $row['id']);
                    
                if($children != false){
                    foreach($children as $child){
                        $return .= '<li class="slide">';
                        $return .= '<a href="'.$child['sb_link_uri'].'" class="side-menu__item">';
                        $return .= '<i class="'.$child['sb_link_icon'].'"></i>';
                        $return .= '<span class="side-menu__label"> '.$child['sb_link_name'].'</span>';
                        $return .= '</a>';
                        $return .= '</li>';
                    }
                }

            }

            $return .= '</ul>';

            return $return;
        } catch (PDOException $e) {
            error_log($e->getMessage());
        }

        return false;
    }

    public static function checkIfPageSecure($page){
        $page = sanitize_sql_string($page);
        $page = "/".$page."/";
        global $msql_db;

        try {
            $sql = "SELECT sb_link_secure FROM `sb_menu` WHERE `sb_link_uri` = :uri";
            $statement = $msql_db->prepare($sql);
            $statement->bindParam(":uri", $page);
            $statement->execute();
            $row = $statement->fetch(PDO::FETCH_ASSOC);

            return ($row['sb_link_secure'] == 1) ? true : false;

        } catch (PDOException $e) {
            error_log($e->getMessage());
        }

        return false;
    }

    public static function getPageTitle($page){
        $page = sanitize_sql_string($page);
        $page = "/".$page."/";
        global $msql_db;
        
        try {
            $sql = "SELECT sb_link_name FROM `sb_menu` WHERE `sb_link_uri` = :uri";
            $statement = $msql_db->prepare($sql);
            $statement->bindParam(":uri", $page);
            $statement->execute();
            $row = $statement->fetch(PDO::FETCH_ASSOC);

            return $row['sb_link_name'];

        } catch (PDOException $e) {
            error_log($e->getMessage());
        }

        return false;
    }

    public static function switchPage($page){
        $page = sanitize_sql_string($page);
        
        //Check Maintenance
        if(SB_CORE::getMaintenanceState() && $page != "maintenance" && !SB_CORE::getMaitenanceAllowed()){
            header("Location: /maintenance/", true, 302);
            exit();
        }

        $is_auth = SB_AUTH::checkAuth(2);
        if(empty($page) && $is_auth){
            header("Location: /overview/", true, 302);
            exit();
        }elseif(empty($page) && !$is_auth || !$is_auth && self::checkIfPageSecure($page)){
            header("Location: /login/", true, 302);
            exit();
        }

        if(isset($_GET['page']) && isset($_GET['item'])){
            if(file_exists(SB_THEMES. SB_THEME."/subitems/".$_GET['item'].".tpl.php")) {
                echo self::replaceWithFunction(SB_THEMES . SB_THEME . "/head.tpl.php");
    
                if($is_auth && self::checkIfPageSecure($page."/".$_GET['item'])){
                    echo self::replaceWithFunction(SB_THEMES . SB_THEME . "/header.tpl.php");
                }
    
                echo self::replaceWithFunction(SB_THEMES . SB_THEME . "/subitems/" . $_GET['item'] . ".tpl.php");
                echo self::replaceWithFunction(SB_THEMES . SB_THEME . "/footer.tpl.php");
            }else{
                echo self::replaceWithFunction(SB_THEMES . SB_THEME . "/404.tpl.php");
            }
        }else{
            if(file_exists(SB_THEMES.SB_THEME."/".$page.".tpl.php")) {
                echo self::replaceWithFunction(SB_THEMES . SB_THEME . "/head.tpl.php");
    
                if($is_auth && self::checkIfPageSecure($page)){
                    echo self::replaceWithFunction(SB_THEMES . SB_THEME . "/header.tpl.php");
                }
    
                echo self::replaceWithFunction(SB_THEMES . SB_THEME . "/" . $page . ".tpl.php");
                echo self::replaceWithFunction(SB_THEMES . SB_THEME . "/footer.tpl.php");
            }else{
                echo self::replaceWithFunction(SB_THEMES . SB_THEME . "/404.tpl.php");
            }
        }
        
    }

    public static function getDynmaicCSS($page){
        $page = sanitize_sql_string($page);
        $page = "/".$page."/";
        global $msql_db;

        try {
            $sql = "SELECT `css` FROM `sb_menu` WHERE `sb_link_uri` = :uri";
            $statement = $msql_db->prepare($sql);
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
            error_log($e->getMessage());
        }

        return false;
    }

    public static function getDynamicJS($page){
        global $msql_db;
        $page = sanitize_sql_string($page);
        $page = "/".$page."/";

        try {
            $sql = "SELECT `js` FROM `sb_menu` WHERE `sb_link_uri` = :uri";
            $db = new PDO("mysql:host=".SB_DB_HOST.";dbname=".SB_DB_DATABASE, SB_DB_USER, SB_DB_PASSWORD);
            $statement = $msql_db->prepare($sql);
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
            error_log($e->getMessage());
        }

        return false;
    }
}