<?php
    $mydata='Settings says hi';

    $info->message = $mydata;
    $info->dataType = "settings";
    echo json_encode($info);

    die;

    $info->message = "No settings were found!";
    $info->dataType = "error";
    echo json_encode($info);
?>


