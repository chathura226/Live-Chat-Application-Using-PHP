<?php

if(isset($DATA_OBJ->find->userID)){
    $ChatUserID = $DATA_OBJ->find->userID;
}else{
    //user not found
    $info->user = "Contact was not found!";
    $info->dataType = "chats";
    echo json_encode($info);
    die;
}

$query = "SELECT userID,userName,image,gender FROM user WHERE userID= :userID limit 1";
$result = $DB->read($query, ['userID' => $ChatUserID]);

if (is_array($result)) {
    //user found
    $user = $result[0];

    //decision abt the image
    $image = "";
    if (!empty($user->image) && file_exists($user->image)) {//when image is set and exists
        $image = $user->image;
    }else{//when image is not set
        if($user->gender=='male'){//for male users with no image
            $image="ui/images/male.jpg";
        }else{//for female users with no image
            $image="ui/images/female.png";
        }
    }

    $mydata = 'Now chatting with:<br>   <div id="active_contact"  userID="'.$user->userID.'" >
            <img src="' . $image . '">
            ' . ucfirst($user->userName) . '</div>';

    $messages='
<div id="messages_container_wrapper" >
    <div id="messages_container" >
        <div id="message_left">
            <div></div><!--for dot near image-->
            <img src="' . $image . '">
            <b>' . ucfirst($user->userName) . '</b><br>
                skcuhsndewndiuwndkwihdiwdhiwhdwidi edwdwkndw<br>
                <span style="font-size: 11px;color: #999; position: absolute; bottom: 3px;right: 5px;">20 Jan 2023 10:00 am</span>
        </div>
        
        <div id="message_right">
            <div></div><!--for dot near image-->
            <img src="' . $image . '" style="float: right;">
            <b>' . ucfirst($user->userName) . '</b><br>
                skcuhsndewndiuwndkwihdiwdhiwhdwidi edwdwkndw<br>
                <span style="font-size: 11px;color: #999; position: absolute; bottom: 3px;left: 5px;">20 Jan 2023 10:00 am</span>
        </div>
        
        <div id="message_left">
            <div></div><!--for dot near image-->
            <img src="' . $image . '">
            <b>' . ucfirst($user->userName) . '</b><br>
                skcuhsndewndiuwndkwihdiwdhiwhdwidi edwdwkndw<br>
                <span style="font-size: 11px;color: #999; position: absolute; bottom: 3px;right: 5px;">20 Jan 2023 10:00 am</span>
        </div>
        
        <div id="message_right">
            <div></div><!--for dot near image-->
            <img src="' . $image . '" style="float: right;">
            <b>' . ucfirst($user->userName) . '</b><br>
                skcuhsndewndiuwndkwihdiwdhiwhdwidi edwdwkndw<br>
                <span style="font-size: 11px;color: #999; position: absolute; bottom: 3px;left: 5px;">20 Jan 2023 10:00 am</span>
        </div>
        
        <div id="message_left">
            <div></div><!--for dot near image-->
            <img src="' . $image . '">
            <b>' . ucfirst($user->userName) . '</b><br>
                skcuhsndewndiuwndkwihdiwdhiwhdwidi edwdwkndw<br>
                <span style="font-size: 11px;color: #999; position: absolute; bottom: 3px;right: 5px;">20 Jan 2023 10:00 am</span>
        </div>
        
        <div id="message_right">
            <div></div><!--for dot near image-->
            <img src="' . $image . '" style="float: right;">
            <b>' . ucfirst($user->userName) . '</b><br>
                skcuhsndewndiuwndkwihdiwdhiwhdwidi edwdwkndw<br>
                <span style="font-size: 11px;color: #999; position: absolute; bottom: 3px;left: 5px;">20 Jan 2023 10:00 am</span>
        </div>
        
                <div id="message_right">
            <div></div><!--for dot near image-->
            <img src="' . $image . '" style="float: right;">
            <b>' . ucfirst($user->userName) . '</b><br>
                skcuhsndewndiuwndkwihdiwdhiwhdwidi edwdwkndw<br>
                <span style="font-size: 11px;color: #999; position: absolute; bottom: 3px;left: 5px;">20 Jan 2023 10:00 am</span>
        </div>
        
        
                <div id="message_right">
            <div></div><!--for dot near image-->
            <img src="' . $image . '" style="float: right;">
            <b>' . ucfirst($user->userName) . '</b><br>
                skcuhsndewndiuwndkwihdiwdhiwhdwidi edwdwkndw<br>
                <span style="font-size: 11px;color: #999; position: absolute; bottom: 3px;left: 5px;">20 Jan 2023 10:00 am</span>
        </div>
        
                <div id="message_right">
            <div></div><!--for dot near image-->
            <img src="' . $image . '" style="float: right;">
            <b>' . ucfirst($user->userName) . '</b><br>
                skcuhsndewndiuwndkwihdiwdhiwhdwidi edwdwkndw<br>
                <span style="font-size: 11px;color: #999; position: absolute; bottom: 3px;left: 5px;">20 Jan 2023 10:00 am</span>
        </div>
    </div>
    <div style="display: flex; height: 50px;">
    <input style="flex:6" type="text" value=""  placeholder="Type your message"/>
    <input style="flex:1;cursor: pointer;" type="button" value="Send" />
    </div>
</div>
';


    $info->user = $mydata;
    $info->messages = $messages;
    $info->dataType = "chats";
    echo json_encode($info);

} else {
    //user not found
    $info->user = "Contact was not found!";
    $info->dataType = "chats";
    echo json_encode($info);
}


?>


