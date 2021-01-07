<?php
/**
 * Created by SyncroBit.
 * Author: George Partene
 * Version: 0.1
 */
header('Content-Type: application/json');
include ("includes/initd.inc.php");

$response = array();

if(!isset($_POST['action']) || empty($_POST['action'])){
    $response['status'] = "invalid";
    $response['message'] = "Action not set";
    die(json_encode($response));
}


switch($_POST['action']){
    case "LOGIN":
        $action = SB_AUTH::makeAuth($_POST['username'], $_POST['password']);
        $response = $action;
    break;

    case "REGISTER_USER":
        $action = SB_AUTH::registerUser($_POST['username'], $_POST['password'], $_POST['email'], $_POST['first_name'], $_POST['last_name']);
        $response['status'] = $action;
    break;

    case "CHECK_EMAIL":
        $action = SB_AUTH::checkIfEmailExists($_POST['email']);
        $response = ($action) ? "Email already exists!" : "true";
    break;

    case "CHECK_EMAIL_REVERSE":
        $action = SB_AUTH::checkIfEmailExists($_POST['email']);
        $response = (!$action) ? "Email not in our database!" : "true";
    break;

    case "CHECK_USERNAME":
        $action = SB_AUTH::checkIfUsernameExists($_POST['username']);
        $response = ($action) ? "Username already exists!" : "true";
    break;

    case "RESEND_EMAIL":
        $action = SB_AUTH::resendEmail($_POST['uID']);
        $response['status'] = $action;
    break;

    case "FORGOT_PASSWORD":
        $action = SB_AUTH::forgotPassword($_POST['email']);
        $response['status'] = $action;
    break;

    case "UPDATE_PASSWORD_FORGOT":
        $action = SB_USER::updatePasswordForgot($_POST['uID'], $_POST['password']);
        $response['status'] = ($action) ? "success" : "failed";
    break;

    case "CHECK_AUTH":
        $action = SB_AUTH::checkAuth(3);
        $response['status'] = ($action) ? "success" : "failed";
    break;

    case "CHECK_SESSION":
        $action = SB_AUTH::checkActiveTime();
        $response['status'] = ($action) ? "success" : "failed";
    break;

    case "SESSION_ADD_TIME":
        $action = SB_AUTH::incrementActiveTime();
        $response['status'] = ($action) ? "success" : "failed";
    break;    

    case "LOGOUT":
        $action = SB_AUTH::logOut();
        $response['status'] = ($action) ? "success" : "failed";
        break;
    
    case "GET_OVERVIEW":
        $action = SB_HELIUM::getOverViewSummary();
        $response['status'] = ($action) ? "success" : "failed";
        $response['data']   = $action;
    break;  
    
    case "GET_USER_SETTINGS":
        $action = SB_USER::getUserSettings($_SESSION['uID']);
        $response['status'] = ($action) ? "success" : "failed";
        $response['data']   = $action;
    break;
    
    case "UPDATE_USER_SETTINGS":
        $action = SB_USER::updateUserSettings($_SESSION['uID'], $_POST['time_zone'], 
                    $_POST['date_format'], $_POST['time_format'], $_POST['wallet_address']);
        $response['status'] = ($action) ? "success" : "failed";
    break;    

    case "GET_USER_DETAILS":
        $action = SB_USER::getUserDetails($_SESSION['uID']);
        $response['status'] = ($action) ? "success" : "failed";
        $response['data']   = $action;
    break;
    
    case "UPDATE_USER_DETAILS":
        $action = SB_USER::updateUserDetails($_SESSION['uID'], $_POST['first_name'], $_POST['last_name'],
                                    $_POST['address'], $_POST['city'], $_POST['state'],
                                    $_POST['country'], $_POST['zip']);
        $response['status'] = $action;
    break;

    case "CHANGE_EMAIL":
        $action = SB_USER::changeEmail($email);
        $response['status'] = $action;
    reak;    

    case "GET_STATES":
        $action                 = SB_CORE::getStates($_POST['iso']);
        $response['status']     = "success";
        $response['data']       = $action;
    break;    
    
    case "GET_CITY_STATE":
        $action                 = SB_CORE::getZipCode($_POST['iso'], $_POST['zipCode']);
        $response['status']     = "success";
        $response['data']       = $action;
    break;

    case "CHECK_CURRENT_PASSWORD":
        $action             = SB_USER::checkCurrentPass($_POST['password']);
        $response           = ($action) ? "true" : "Password does not match!";
    break;  

    case "CHECK_PASSWORD":
        $action             = SB_USER::checkCurrentPass($_POST['password']);
        $response['status'] = ($action) ? "success" : "false";
        break;
    
    case "UPDATE_PASSWORD":
        $action             = SB_USER::updatePassword($_SESSION['uID'], $_POST['password'], $_POST['current_pass']);
        $response['status'] = ($action) ? "success" : "failed";
    break;  
    
    case "UPDATE_PROFILE_IMG":
        $action = SB_USER::updateProfileImg($_SESSION['uID'], $_POST['img']);
        $response['status'] = ($action) ? "success" : "failed";
    break; 
    
    case "DESTORY_SESSION":
        $action = SB_USER::destroyActiveSession($_POST['sID']);
        $response['status'] = ($action) ? "success" : "failed";
    break;   
    
    case "CHECK_HELIUM_ADDRESS":
        $action = SB_HELIUM::checkIfValidAddress($_POST['w_address']);
        $response = ($action) ? "true" : "Invalid Helium Wallet Address";
    break;  
    
    case "ADD_WALLET_ADDRESS":
        $action = SB_USER::addWallet($_SESSION['uID'], $_POST['nickname'], $_POST['wAddr']);
        $response = $action;
    break;   
    
    case "GET_USER_WALLET_DETAILS":
        $action = SB_USER::getUserWallet($_SESSION['uID'], $_POST['wID']);
        $response = $action;
    break; 
    
    case "EDIT_USER_WALLET":
        $action = SB_USER::editUserWallet($_SESSION['uID'], $_POST['wID'], $_POST['nickname'], $_POST['wAddr']);
        $response['status'] = $action;
    break;

    case "DELETE_USER_WALLET":
        $action = SB_USER::deleteUserWallet($_SESSION['uID'], $_POST['wID']);
        $response = $action ;
    break;  
    
    case "GENERATE_NEW_KEY":
        $action = SB_API::generateKeys();
        $response['status'] = (!$action) ? "failed" : "success";
        $response['apiKey'] = $action;
    break;   
    
    case "ADD_API_KEY":
        $action     = SB_API::addKeys($_SESSION['uID'], $_POST['appName']);
        $response   = $action;
    break;  
    
    case "DELETE_KEY":
        $action = SB_API::deleteKey($_SESSION['uID'], $_POST['kID']);
        $response = $action;
    break;
    
    case "GET_API_KEY":
        $action = SB_API::getUserKey($_SESSION['uID'], $_POST['kID']);
        $response['status'] = (!$action) ? "failed" : "success";
        $response['apiKey'] = $action;
    break;
    
    case "GET_HISTORY":
        $action = SB_SUBSCRIPTION::getPaymentHistory($_SESSION['uID'], $_POST['range']);
        $response['status'] = (!$action) ? "failed" : "success";
        $response['history'] = $action;
    break;
    
    case "UPGRADE_PGK":
        $action = SB_SUBSCRIPTION::updateUserPkg($_SESSION['uID'], $_POST['pkg']);
        $response['status'] = ($action) ? "success" : "failed";
    break;
    
    case "CREATE_IP_MAP":
        $action = SB_WATCHDOG::createIPMap($_POST['ip']);
        $response = $action;
    break;    

    case "GET_ACCT_HISTORY":
        $action = SB_WATCHDOG::getUserActivity($_SESSION['uID'], $_POST['start'], $_POST['end']);
        $response['status'] = (!$action) ? "success" : "failed";
        $response['history'] = $action;
    break;    
}

echo json_encode($response);
