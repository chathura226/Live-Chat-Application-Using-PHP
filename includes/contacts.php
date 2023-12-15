<?php

$query = "SELECT userName,image,gender FROM user ";
$result = $DB->read($query, []);

if (is_array($result)) {
    $mydata = '<div style="text-align: center;">';

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

        $mydata .= '    <div id="contact">
        <img src="' . $image . '">
        <br>' . ucfirst($user->userName) . '</div>';
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


