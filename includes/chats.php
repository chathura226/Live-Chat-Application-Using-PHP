<?php
$ChatUserID = $DATA_OBJ->find->userID;
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
    $info->message = $mydata;
    $info->dataType = "chats";
    echo json_encode($info);

} else {
    //user not found
    $info->message = "Contact was not found!";
    $info->dataType = "error";
    echo json_encode($info);
}


?>


