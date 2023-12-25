<?php

//getting the current chatting user ( who we chat with)
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

    //arr array to store data for prepared statement
    $arr['message']=$DATA_OBJ->find->message;
    $arr['date']=date("Y-m-d H:i:s");
    $arr['sender']=$_SESSION['userID'];
    $arr['receiver']=$DATA_OBJ->find->userID;
    $arr['msgID']=getRandomStringMax(60);

    //if msgID exist, get that as the msgID (unique for a chat between a sender and reciever)
    $query = "SELECT * FROM messages WHERE (sender= :sender && receiver=:receiver) || (sender= :receiver && receiver=:sender) limit 1";
    $resultNew = $DB->read($query,['sender'=>$arr['sender'],'receiver'=>$arr['receiver']]);
    if(is_array($resultNew)){
        $arr['msgID']=$resultNew[0]->msgID;
    }

    $query="INSERT INTO messages (sender,receiver,message,date,msgID) values (:sender,:receiver,:message,:date,:msgID)";
    $DB->write($query, $arr);

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
            <img src="' . $image . '">
            ' . ucfirst($user->userName) . '</div>';

    $messages="";
    $messages .= '
<div id="messages_container_wrapper" onclick="setSeen(event);" >
<div id="chat_header">
<img class="profilePic" src="' . $user->image . '">
<span><b>'.ucfirst($user->userName).'</b></span>
<span class="delete_thread" style="cursor: pointer;" onclick="deleteThread(event);"><small style="color: grey;">Delete this thread</small>  <svg style="fill: #615EF0;" xmlns="http://www.w3.org/2000/svg" height="20" width="18" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M128 0c17.7 0 32 14.3 32 32V64H288V32c0-17.7 14.3-32 32-32s32 14.3 32 32V64h48c26.5 0 48 21.5 48 48v48H0V112C0 85.5 21.5 64 48 64H96V32c0-17.7 14.3-32 32-32zM0 192H448V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V192zM305 305c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-47 47-47-47c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l47 47-47 47c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l47-47 47 47c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-47-47 47-47z"/></svg></span>
</div>
    <div id="messages_container" >
        ';
    //left and right chats

    //reading from db
    $msgID=$arr['msgID'];
    $query = "SELECT * FROM messages WHERE (msgID=:msgID && receiver=:userID && deleted_receiver=0) || (msgID=:msgID && sender=:userID && deleted_sender=0) ORDER BY id ASC";
    $msgFromDB = $DB->read($query,['msgID'=>$msgID,'userID'=>$_SESSION['userID']]);
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
    $info->dataType = "send_message";
    echo json_encode($info);

} else {
    //user not found
    $info->user = "Contact was not found!";
    $info->dataType = "chats";
    echo json_encode($info);
}


//to generate random character string
function getRandomStringMax($length)
{
    $array=array(0,1,2,3,4,5,6,7,8,9,'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z','A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
    $text="";
    $length=rand(4,$length);

    for($i=0;$i<$length;$i++){
        $random=rand(0,61);
        $text.=$array[$random];
    }

    return $text;
}
?>


