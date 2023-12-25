<?php

if (isset($DATA_OBJ->find->userID)) {
    $ChatUserID = $DATA_OBJ->find->userID;


    $query = "SELECT userID,userName,image,gender FROM user WHERE userID= :userID limit 1";
    $result = $DB->read($query, ['userID' => $ChatUserID]);


    if (is_array($result)) {
        //user found
        $user = $result[0];

        $user->image = decision_about_image($user);


//when its not a request to refresh chat part only
        if (!$refresh) {
            $mydata = 'Now chatting with:<br>   <div id="active_contact"  userID="' . $user->userID . '" >
            <img src="' . $user->image . '">
            ' . ucfirst($user->userName) . '</div>';
        }
        $newMessage=false;
        $messages="";
        if (!$refresh) {
            $messages .= '
<div id="messages_container_wrapper" onclick="setSeen(event);" >
<div id="chat_header">
<img class="profilePic" src="' . $user->image . '">
<span><b>'.ucfirst($user->userName).'</b></span>
<span class="delete_thread" style="cursor: pointer;" onclick="deleteThread(event);"><small style="color: grey;">Delete this thread</small>  <svg style="fill: #615EF0;" xmlns="http://www.w3.org/2000/svg" height="20" width="18" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M128 0c17.7 0 32 14.3 32 32V64H288V32c0-17.7 14.3-32 32-32s32 14.3 32 32V64h48c26.5 0 48 21.5 48 48v48H0V112C0 85.5 21.5 64 48 64H96V32c0-17.7 14.3-32 32-32zM0 192H448V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V192zM305 305c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-47 47-47-47c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l47 47-47 47c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l47-47 47 47c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-47-47 47-47z"/></svg></span>
</div>
    <div id="messages_container" >
        ';

        }
        //left and right msgs from db
        $query = "SELECT * FROM messages WHERE (sender= :sender && receiver=:receiver && deleted_receiver=0) || (sender= :receiver && receiver=:sender && deleted_sender=0) ORDER BY id ASC";
        $msgFromDB = $DB->read($query, ['sender' => $user->userID, 'receiver' => $_SESSION['userID']]);
        if (is_array($msgFromDB)) {
            foreach ($msgFromDB as $data) {



                if ($data->sender == $_SESSION['userID']) {//when the msg was sent by the logged user
                    $messages .= message_right($data, $_SESSION['user']);//using user obj in session for user data of logged user
                } else {//when msg is sent by the chatting user
                    //since the logged in user now recieving the message if havent updated seen
                    if(empty($data->received)) {
                        $newMessage=true;
                        $DB->write("UPDATE messages SET received=:received WHERE id=:id limit 1;", ['received' => date("Y-m-d H:i:s"), 'id' => $data->id]);
                    }


                    if($seen && empty($data->seen) &&  !empty($data->received) ) {

                        $DB->write("UPDATE messages SET seen=:seen WHERE id=:id limit 1;", ['seen' => date("Y-m-d H:i:s"), 'id' => $data->id]);
                    }
                    $messages .= message_left($data, $user);
                }
            }
        }

        if (!$refresh) {
            //controllers for message (send button input fields etc.)
            $messages .= messageControls();
        }

        $info->newMessage=$newMessage;
        $info->dataType = "chats_refresh";
        if (!$refresh) {
            $info->dataType = "chats";
            $info->user = $mydata;
        }
        $info->messages = $messages;
        echo json_encode($info);

    } else {
        //user not found
        $info->user = "Contact was not found!";
        $info->dataType = "chats";
        echo json_encode($info);
    }


} else {//if no user is selected=>get all chats
    //left and right msgs from db
    $query = "SELECT messages.receiver as userID, user.userName, user.image, user.online, user.gender
                FROM messages
                         JOIN user ON messages.receiver = user.userID
                WHERE messages.sender = :userID AND messages.deleted_sender=0
                GROUP BY messages.receiver, user.userName, user.image, user.online, user.gender
                
                UNION
                
                SELECT messages.sender as userID, user.userName, user.image, user.online, user.gender
                FROM messages
                         JOIN user ON messages.sender = user.userID
                WHERE messages.receiver = :userID AND messages.deleted_receiver=0
                GROUP BY messages.sender, user.userName, user.image, user.online, user.gender;
                ";
    $msgFromDB = $DB->read($query, ['userID' => $_SESSION['userID']]);
    if (is_array($msgFromDB)) {
        $mydata='Previous Chats:<br>';
        foreach ($msgFromDB as $data) {
            $data->image = decision_about_image($data);
            $mydata .= '<div id="active_contact"  userID="' . $data->userID . '" onclick="startChat(event)" >
            <img src="' . $data->image . '">
            ' . ucfirst($data->userName) . '</div>';
        }
    }else{
        $mydata='You have no previous chats!';
    }

    $info->dataType = "chats";
    $info->messages = "";
    $info->user = $mydata;
    echo json_encode($info);
}


?>


