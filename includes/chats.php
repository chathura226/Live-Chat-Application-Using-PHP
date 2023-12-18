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
    $user->image=$image;



    $mydata = 'Now chatting with:<br>   <div id="active_contact"  userID="'.$user->userID.'" >
            <img src="' . $user->image . '">
            ' . ucfirst($user->userName) . '</div>';

    $messages='
<div id="messages_container_wrapper" >
    <div id="messages_container" >
        ';
   //left and right msgs from db
    $query = "SELECT * FROM messages WHERE (sender= :sender && receiver=:receiver) || (sender= :receiver && receiver=:sender) ORDER BY id ASC";
    $msgFromDB = $DB->read($query,['sender'=>$user->userID,'receiver'=>$_SESSION['userID']]);
    if(is_array($msgFromDB)){
        foreach ($msgFromDB as $data){
            if($data->sender==$_SESSION['userID']){//when the msg was sent by the logged user
                $messages.=message_right($data,$_SESSION['user']);//using user obj in session for user data of logged user
            }else{//when msg is sent by the chatting user
                $messages.=message_left($data,$user);
            }
        }
    }


    //controllers for message (send button input fields etc.)
    $messages.=messageControls();


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


