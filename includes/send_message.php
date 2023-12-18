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
    $query = "SELECT * FROM messages WHERE sender= :sender && receiver=:receiver limit 1";
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

    $messages='
<div id="messages_container_wrapper" >
    <div id="messages_container" >
        ';
    //left and right chats

    //reading from db
    $msgID=$arr['msgID'];
    $query = "SELECT * FROM messages WHERE msgID=:msgID";
    $msgFromDB = $DB->read($query,['msgID'=>$msgID]);
    if(is_array($msgFromDB)){
        foreach ($msgFromDB as $data){
            $messages.=message_right($data,$_SESSION['user']);//using user obj in session for user data of logged user
        }
    }



    $messages.='
    </div>
    <div style="display: flex; height: 50px;">
    <label for="file"><img src="ui/icons/clip.png" style="opacity: 0.;width: 30px;margin: 5px;cursor: pointer;"></label>
    <input name="file" id="message_file" type="file" style="display: none;"/>
    <input id="message_text" style="flex:6;border: solid thin #ccc; border-bottom: none;" type="text" value=""  placeholder="Type your message"/>
    <input style="flex:1;cursor: pointer;" type="button" value="Send" onclick="send_message(event);" />
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


