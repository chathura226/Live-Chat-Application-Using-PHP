<?php
    $mydata=$DATA_OBJ->find->userID;

    $info->message = $mydata;
    $info->dataType = "chats";
    echo json_encode($info);

    die;

    $info->message = "No chats were found!";
    $info->dataType = "error";
    echo json_encode($info);
?>


