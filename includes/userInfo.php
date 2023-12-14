<?php

$info=(object)[];


//getting userID from session
$data['userID']=$_SESSION['userID'];


if($error=="") {
    $query = "SELECT * FROM user WHERE userID=:userID limit 1 ";
    $result = $DB->read($query, $data);

    if (is_array($result)) {
        $result=$result[0];//since results will be an array of data
        $result->dataType="userInfo";
        echo json_encode($result);
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

