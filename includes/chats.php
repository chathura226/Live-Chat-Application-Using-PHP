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
        ';
    $messages.=message_left($user);
    $messages.=message_right($user);
    $messages.=message_left($user);
    $messages.=message_left($user);
    $messages.=message_right($user);
    $messages.='
    </div>
    <div style="display: flex; height: 50px;">
    <label for="file"><img src="ui/icons/clip.png" style="opacity: 0.;width: 30px;margin: 5px;cursor: pointer;"></label>
    <input name="file" id="file" type="file" style="display: none;"/>
    <input style="flex:6;border: solid thin #ccc; border-bottom: none;" type="text" value=""  placeholder="Type your message"/>
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


