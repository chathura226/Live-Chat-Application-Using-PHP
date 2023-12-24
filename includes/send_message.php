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
    $messages .='
<div id="messages_container_wrapper" onclick="setSeen(event);">
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


