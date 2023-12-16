<?php

session_start();

$info=(object)[];

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

$dataType="";
if(isset($_POST['dataType'])){
    $dataType=$_POST['dataType'];
}

require_once("./classes/initialize.php");

$DB=new Database();

//upload file anyway aand then check whether to put into db
$destination="";
if(isset($_FILES['file']) && $_FILES['file']['name']!="" ){

    if($_FILES['file']['error']==0){
        //uploading the file
        $fileName=$_FILES['file']['tmp_name'];
        $folder="uploads/";
        if(!file_exists($folder)){
            mkdir($folder,077,true);
        }
        $destination=$folder.time()."_".$_FILES['file']['name'];
        move_uploaded_file($fileName,$destination);
        $info->message="Image Uploaded Successfully!";
        $info->dataType=$dataType;
        echo json_encode($info);
    }
}



if($dataType=="change_profile_image"){
    if($destination!=""){//save to db
        $updateData['image']=$destination;
        $updateData['userID']=$_SESSION['userID'];
        $query="UPDATE user SET image= :image WHERE userID= :userID LIMIT 1";
        $DB->write($query,$updateData);
    }
}