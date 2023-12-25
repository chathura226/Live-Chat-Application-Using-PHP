<?php
$myID=$_SESSION['userID'];
$query = "SELECT u.userID, u.userName, u.image, u.gender, COUNT(m.id) AS unread_count
FROM user u
LEFT JOIN (
    SELECT *
    FROM messages
    WHERE received IS NULL AND receiver=:userID
) AS m ON u.userID = m.sender
WHERE u.userID != :userID
GROUP BY u.userID, u.userName, u.image, u.gender;
";


$result = $DB->read($query, ['userID'=>$myID]);

if (is_array($result)) {
    $mydata = '
    <style>
    @keyframes appear {
        0%{
            opacity: 0;
            transform: translateX(50px);
        }
        
        100%{
            opacity: 1;
            transform: translateX(0px);
        }
    }
    
    #contact{
        cursor: pointer;
        transition: all 0.5s cubic-bezier(.78,.11,.42,.85);
    }
    
    #contact:hover{
        transform: scale(1.1);
    }
</style>
    <div style="text-align: center;">';

    foreach ($result as $user) {
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

        $mydata .= '    <div id="contact" style="position:relative;" userID="'.$user->userID.'" onclick="startChat(event)">
        <img src="' . $image . '">
        <br>' . ucfirst($user->userName);

        if($user->unread_count>0) {
            $mydata .= '<div style="width: 20px;height: 20px;border-radius: 50%;background-color: orange;color: white;position: absolute;left: -5px;top: -5px;">'.$user->unread_count.'</div>';
        }
        $mydata.='</div>';
    }

    $mydata .= '</div>';


    $info->message = $mydata;
    $info->dataType = "contacts";
    echo json_encode($info);

} else {
    $info->message = "No contacts were found!";
    $info->dataType = "error";
    echo json_encode($info);
}
?>


