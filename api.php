<?php

session_start();

$info=(object)[];

require_once("./classes/initialize.php");

$DB=new Database();

//retrieving data
$DATA_RAW=file_get_contents("php://input");
$DATA_OBJ=json_decode($DATA_RAW);//make object form stringified data

//check if logged in
if(!isset($_SESSION['userID'])){
    if(isset($DATA_OBJ->dataType) && $DATA_OBJ->dataType!="login" && $DATA_OBJ->dataType!="signup") {
        $info->logged_in = false;
        echo json_encode($info);
        die;
    }
}

$error="";

//processing data
if(isset($DATA_OBJ->dataType) && $DATA_OBJ->dataType=="signup"){

    //signup
    include ("includes/signup.php");
}else if(isset($DATA_OBJ->dataType) && $DATA_OBJ->dataType=="login"){
    //login
    include ("includes/login.php");
}else if(isset($DATA_OBJ->dataType) && $DATA_OBJ->dataType=="logout"){
    //logout
    include ("includes/logout.php");
}else if(isset($DATA_OBJ->dataType) && $DATA_OBJ->dataType=="user_info"){
    //userInfo
    include("includes/userInfo.php");
}else if(isset($DATA_OBJ->dataType) && $DATA_OBJ->dataType=="contacts"){
    //contacts
    include("includes/contacts.php");
}else if(isset($DATA_OBJ->dataType) && $DATA_OBJ->dataType=="chats"){
    //chats
    include("includes/chats.php");
}else if(isset($DATA_OBJ->dataType) && $DATA_OBJ->dataType=="settings"){
    //settings
    include("includes/settings.php");
}