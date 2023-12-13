<?php

session_start();

$info=(object)[];
//check if logged in
if(!isset($_SESSION['userID'])){
    $info->logged_in=false;
    echo json_encode($info);
    die;
}

require_once("./classes/initialize.php");

$DB=new Database();

//retrieving data
$DATA_RAW=file_get_contents("php://input");
$DATA_OBJ=json_decode($DATA_RAW);//make object form stringified data

$error="";

//processing data
if(isset($DATA_OBJ->dataType) && $DATA_OBJ->dataType=="signup"){

    //signup
    include ("includes/signup.php");
}else if(isset($DATA_OBJ->dataType) && $DATA_OBJ->dataType=="user_info"){
    echo "user info";
}