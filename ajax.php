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

if($_SESSION['id'] == session_id()){
    $response['status'] = "invalid";
    $response['message'] = "Invalid Session";
    die(json_encode($response));
}


switch($_POST['action']){
    case "LOGIN":
        $action = SB_AUTH::makeAuth(htmlspecialchars($_POST['username']), htmlspecialchars($_POST['password']));
        $response = $action;
    break;

    case "REGISTER_USER":
        $action = SB_AUTH::registerUser(htmlspecialchars($_POST['username']), htmlspecialchars($_POST['password']), 
                                        htmlspecialchars($_POST['email']), htmlspecialchars($_POST['first_name']), 
                                        htmlspecialchars($_POST['last_name']));
        $response['status'] = $action;
    break;

    case "CHECK_EMAIL":
        $action = SB_AUTH::checkIfEmailExists(htmlspecialchars($_POST['email']));
        $response = ($action) ? "Email already exists!" : "true";
    break;

    case "CHECK_EMAIL_REVERSE":
        $action = SB_AUTH::checkIfEmailExists(htmlspecialchars($_POST['email']));
        $response = (!$action) ? "Email not in our database!" : "true";
    break;

    case "CHECK_USERNAME":
        $action = SB_AUTH::checkIfUsernameExists(htmlspecialchars($_POST['username']));
        $response = ($action) ? "Username already exists!" : "true";
    break;

    case "RESEND_EMAIL":
        $action = SB_AUTH::resendEmail(htmlspecialchars($_POST['uID']));
        $response['status'] = $action;
    break;

    case "FORGOT_PASSWORD":
        $action = SB_AUTH::forgotPassword(htmlspecialchars($_POST['email']));
        $response['status'] = $action;
    break;

    case "UPDATE_PASSWORD_FORGOT":
        $action = SB_USER::updatePasswordForgot(htmlspecialchars($_POST['uID']), htmlspecialchars($_POST['password']));
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
        $action = SB_USER::updateUserSettings($_SESSION['uID'], htmlspecialchars($_POST['time_zone']), 
                                              htmlspecialchars($_POST['date_format']), htmlspecialchars($_POST['time_format']), 
                                              htmlspecialchars($_POST['wallet_address']));
        $response['status'] = ($action) ? "success" : "failed";
    break;    

    case "GET_USER_DETAILS":
        $action = SB_USER::getUserDetails($_SESSION['uID']);
        $response['status'] = ($action) ? "success" : "failed";
        $response['data']   = $action;
    break;
    
    case "UPDATE_USER_DETAILS":
        $action = SB_USER::updateUserDetails($_SESSION['uID'], htmlspecialchars($_POST['first_name']), htmlspecialchars($_POST['last_name']),
                                            htmlspecialchars($_POST['address']), htmlspecialchars($_POST['city']), htmlspecialchars($_POST['state']),
                                            htmlspecialchars($_POST['country']), htmlspecialchars($_POST['zip']));
        $response['status'] = $action;
    break;

    case "CHANGE_EMAIL":
        $action = SB_USER::changeEmail($email);
        $response['status'] = $action;
    break;    

    case "GET_STATES":
        $action                 = SB_CORE::getStates(htmlspecialchars($_POST['iso']));
        $response['status']     = "success";
        $response['data']       = $action;
    break;    
    
    case "GET_CITY_STATE":
        $action                 = SB_CORE::getZipCode(htmlspecialchars($_POST['iso']), htmlspecialchars($_POST['zipCode']));
        $response['status']     = "success";
        $response['data']       = $action;
    break;

    case "CHECK_CURRENT_PASSWORD":
        $action             = SB_USER::checkCurrentPass(htmlspecialchars($_POST['password']));
        $response           = ($action) ? "true" : "Password does not match!";
    break;  

    case "CHECK_PASSWORD":
        $action             = SB_USER::checkCurrentPass(htmlspecialchars($_POST['password']));
        $response['status'] = ($action) ? "success" : "false";
        break;
    
    case "UPDATE_PASSWORD":
        $action             = SB_USER::updatePassword($_SESSION['uID'], htmlspecialchars($_POST['password']), htmlspecialchars($_POST['current_pass']));
        $response['status'] = ($action) ? "success" : "failed";
    break;  
    
    case "UPDATE_PROFILE_IMG":
        $action = SB_USER::updateProfileImg($_SESSION['uID'], htmlspecialchars($_POST['img']));
        $response['status'] = ($action) ? "success" : "failed";
    break; 
    
    case "DESTORY_SESSION":
        $action = SB_USER::destroyActiveSession(htmlspecialchars($_POST['sID']));
        $response['status'] = ($action) ? "success" : "failed";
    break;   
    
    case "CHECK_HELIUM_ADDRESS":
        $action = SB_HELIUM::checkIfValidAddress(htmlspecialchars($_POST['w_address']));
        $response = ($action) ? "true" : "Invalid Helium Wallet Address";
    break;  
    
    case "ADD_WALLET_ADDRESS":
        $action = SB_USER::addWallet($_SESSION['uID'], htmlspecialchars($_POST['nickname']), htmlspecialchars($_POST['wAddr']), htmlspecialchars($_POST['primary']));
        $response = $action;
    break;   
    
    case "GET_USER_WALLET_DETAILS":
        $action = SB_USER::getUserWallet($_SESSION['uID'], htmlspecialchars($_POST['wID']));
        $response = $action;
    break; 
    
    case "EDIT_USER_WALLET":
        $action = SB_USER::editUserWallet($_SESSION['uID'], htmlspecialchars($_POST['wID']), htmlspecialchars($_POST['nickname']), 
                                        htmlspecialchars($_POST['wAddr']), htmlspecialchars($_POST['primary']));
        $response['status'] = $action;
    break;

    case "DELETE_USER_WALLET":
        $action = SB_USER::deleteUserWallet($_SESSION['uID'], htmlspecialchars($_POST['wID']));
        $response = $action ;
    break; 
    
    case "GET_USER_PRIMARY_WALLET":
        $action = SB_USER::getUserPrimaryWallet($_SESSION['uID']);
        $response['status'] = (!$action) ? "failed" : "success";
        $response['wallet'] = $action;
    break;    
    
    case "GENERATE_NEW_KEY":
        $action = SB_API::generateKeys();
        $response['status'] = (!$action) ? "failed" : "success";
        $response['apiKey'] = $action;
    break;   
    
    case "ADD_API_KEY":
        $action     = SB_API::addKeys($_SESSION['uID'], htmlspecialchars($_POST['appName']));
        $response   = $action;
    break;  
    
    case "DELETE_KEY":
        $action = SB_API::deleteKey($_SESSION['uID'], htmlspecialchars($_POST['kID']));
        $response = $action;
    break;
    
    case "GET_API_KEY":
        $action = SB_API::getUserKey($_SESSION['uID'], htmlspecialchars($_POST['kID']));
        $response['status'] = (!$action) ? "failed" : "success";
        $response['apiKey'] = $action;
    break;
    
    case "GET_HISTORY":
        $action = SB_SUBSCRIPTION::getPaymentHistory($_SESSION['uID'], htmlspecialchars($_POST['range']));
        $response['status'] = (!$action) ? "failed" : "success";
        $response['history'] = $action;
    break;
    
    case "UPGRADE_PGK":
        $action = SB_SUBSCRIPTION::updateUserPkg($_SESSION['uID'], htmlspecialchars($_POST['pkg']));
        $response['status'] = ($action) ? "success" : "failed";
    break;
    
    case "CREATE_IP_MAP":
        $action = SB_WATCHDOG::createIPMap(htmlspecialchars($_POST['ip']));
        $response = $action;
    break;    

    case "GET_ACCT_HISTORY":
        $action = SB_WATCHDOG::getUserActivity($_SESSION['uID'], htmlspecialchars($_POST['start']), htmlspecialchars($_POST['end']));
        $response['status'] = (!$action) ? "success" : "failed";
        $response['history'] = $action;
    break;
    
    /** Overview Data */
    case "GET_BLOCK_TIMES":
        $action = SB_HELIUM::getBlockWidgetInfo();
        $response['data'] = $action;
    break;
    
    /** Oracle Data */
    case "GET_ORACLE_PRICE":
        $action = SB_HELIUM::getOraclePricesWidget();
        $response['data'] = $action;
    break;

    case "GET_DAILY_EARNINGS":
        $action = SB_HELIUM::dailyEarningsWidget();
        $response['data'] = $action;
    break;

    case "GET_TOTAL_REWARDS":
        $action = SB_HELIUM::totalEarningsWidget();
        $response['data'] = $action;
    break;

    case "GET_WEEKLY_GRAPH":
        $action = SB_HELIUM::getWeeklyRewardsGraphWidget();
        $response['data'] = $action;
    break; 
    
    case "GET_MONTHLY_GRAPH":
        $action = SB_HELIUM::getMonthlyRewardsWidget();
        $response['data'] = $action;
    break; 

    case "NETWORK_HOTSPOTS":
        $action = SB_HELIUM::getHotSpotsWidget();
        $response['data'] = $action;
    break;

    case "CG_ELECTION_TIME":
        $action = SB_HELIUM::CGElectionWidget();
        $response['data'] = $action;
    break;

    case "TOKEN_SUPPLY":
        $action = SB_HELIUM::getTokenSupplyWidget();
        $response['data'] = $action;
    break;

    case "GET_DC_USAGE_7DAYS":
        $action = SB_HELIUM::getUsage7Day();
        $response['data'] = $action;
    break;

    case "GET_DC_USD_7DAYS":
        $action = SB_HELIUM::getDCUsageInUSD7Days();
        $response['data'] = $action;
    break;

    case "GET_BLOCK_AVG_TIME":
        $action = SB_HELIUM::getBlockAverageTimes();
        $response['data'] = $action;
    break;
}

echo json_encode($response);
