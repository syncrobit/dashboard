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
        $response['status'] = ($action) ? "success" : "failed";
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

    case "LOGOUT":
        $action = SB_AUTH::logOut();
        $response['status'] = ($action) ? "success" : "failed";
        break;
    
    case "GET_OVERVIEW":
        $action = SB_HELIUM::getOverViewSummary();
        $response['status'] = ($action) ? "success" : "failed";
        $response['data']   = $action;
    break;    

}

echo json_encode($response);
