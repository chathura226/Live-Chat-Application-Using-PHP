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
        $messages="";
        if (!$refresh) {
            $messages .= '
<div id="messages_container_wrapper" >
    <div id="messages_container" >
        ';

        }
        //left and right msgs from db
        $query = "SELECT * FROM messages WHERE (sender= :sender && receiver=:receiver) || (sender= :receiver && receiver=:sender) ORDER BY id ASC";
        $msgFromDB = $DB->read($query, ['sender' => $user->userID, 'receiver' => $_SESSION['userID']]);
        if (is_array($msgFromDB)) {
            foreach ($msgFromDB as $data) {
                if ($data->sender == $_SESSION['userID']) {//when the msg was sent by the logged user
                    $messages .= message_right($data, $_SESSION['user']);//using user obj in session for user data of logged user
                } else {//when msg is sent by the chatting user
                    $messages .= message_left($data, $user);
                }
            }
        }

        if (!$refresh) {
            //controllers for message (send button input fields etc.)
            $messages .= messageControls();
        }

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
                WHERE messages.sender = :userID
                GROUP BY messages.receiver, user.userName, user.image, user.online, user.gender
                
                UNION
                
                SELECT messages.sender as userID, user.userName, user.image, user.online, user.gender
                FROM messages
                         JOIN user ON messages.sender = user.userID
                WHERE messages.receiver = :userID
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
    }

    $info->dataType = "chats";
    $info->messages = "";
    $info->user = $mydata;
    echo json_encode($info);
}


?>


