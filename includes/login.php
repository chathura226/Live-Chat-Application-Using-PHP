<?php

$info=(object)[];


//validating info
$data['email']=$DATA_OBJ->email;
if(empty($DATA_OBJ->email)){
    $error .= "Please enter a valid email! <br>";
}
if(empty($DATA_OBJ->password)){
    $error .= "Please enter a valid password! <br>";
}
if($error=="") {
    $query = "SELECT * FROM user WHERE email=:email limit 1 ";
    $result = $DB->read($query, $data);

    if (is_array($result)) {
        $result=$result[0];//since results will be an array of data
        if($result->password==$DATA_OBJ->password){
            $_SESSION['userID']=$result->userID;
            $info->message="You are successfully logged in!";
            $info->dataType="info";
            echo json_encode($info);
        }else{
            $info->message="Incorrect Credentials!";
            $info->dataType="error";
            echo json_encode($info);
        }

    } else {
        $info->message="Incorrect Credentials!";
        $info->dataType="error";
        echo json_encode($info);
    }
}else{
    $info->message=$error;
    $info->dataType="error";
    echo json_encode($info);
}

