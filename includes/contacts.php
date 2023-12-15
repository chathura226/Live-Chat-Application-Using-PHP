<?php
    $mydata='<div style="text-align: center;">

    <div id="contact">
        <img src="ui/images/user1.jpg">
        <br>Username
    </div>

</div>';

    $info->message = $mydata;
    $info->dataType = "contacts";
    echo json_encode($info);

    die;

    $info->message = "No contacts were found!";
    $info->dataType = "error";
    echo json_encode($info);
?>


