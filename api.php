<?php
require_once("./classes/initialize.php");

$DB=new Database();

//retrieving data
$DATA_RAW=file_get_contents("php://input");
$DATA_OBJ=json_decode($DATA_RAW);//make object form stringified data

//processing data
if(isset($DATA_OBJ->dataType) && $DATA_OBJ->dataType=="signup"){

    //signup
    $data['userID']=$DB->generateID(20);
    $data['username']=$DATA_OBJ->username;
    $data['email']=$DATA_OBJ->email;
    $data['password']=$DATA_OBJ->password;
    $data['gender']=$DATA_OBJ->gender;
    $data['createdAt']=date("Y-m-d H:i:s");

    $query="INSERT INTO user (userID,username,email,password,createdAt,gender) values (:userID,:username,:email,:password,:createdAt,:gender) ";
    $result= $DB->write($query,$data);

    if($result){
        echo "Your profile was created successfully!";
    }else{
        echo "Error occurred while creating your account!";
    }
}