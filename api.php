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
}else if(isset($DATA_OBJ->dataType) && $DATA_OBJ->dataType=="save_settings"){
    //save_settings
    include("includes/save_settings.php");
}else if(isset($DATA_OBJ->dataType) && $DATA_OBJ->dataType=="send_message"){
    //send_message
    include("includes/send_message.php");
}


//part for messages in left side
function message_left($data,$user){
    return '<div id="message_left">
            <div></div><!--for dot near image-->
            <img src="' . $user->image . '">
            <b>' . ucfirst($user->userName) . '</b><br>
                 '.$data->message.'<br><br>
                <span style="font-size: 11px;color: white; position: absolute; bottom: 3px;right: 5px;">'.$data->date.'</span>
        </div>';
}

//part for messages in right side
function message_right($data,$user)
{
    return '        <div id="message_right">
            <div></div><!--for dot near image-->
            <img src="' . $user->image . '" style="float: right;">
            <b>' . ucfirst($user->userName) . '</b><br>
                 '.$data->message.'<br><br>
                <span style="font-size: 11px;color: #999; position: absolute; bottom: 3px;left: 5px;">'.$data->date.'</span>
        </div>';
}


//update Session when something change to change user data in session
function updateSession(){

    $query = "SELECT * FROM user WHERE userID=:userID limit 1 ";
    $result = $DB->read($query, ['userID'=>$_SESSION['userID']]);
    if (is_array($result)) {
        $result = $result[0];
        //decision abt the image
        $image = "";
        if (!empty($result->image) && file_exists($result->image)) {//when image is set and exists
            $image = $result->image;
        } else {//when image is not set
            if ($result->gender == 'male') {//for male users with no image
                $image = "ui/images/male.jpg";
            } else {//for female users with no image
                $image = "ui/images/female.png";
            }
        }
        $result->image = $image;

        $user_data['image'] = $result->image;
        $user_data['userID'] = $result->userID;
        $user_data['gender'] = $result->gender;
        $user_data['email'] = $result->email;
        $user_data['userName'] = $result->userName;
        $_SESSION['user'] = (object)$user_data;//saving user data as an obj in session
    }
}
