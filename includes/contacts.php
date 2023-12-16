<?php

$query = "SELECT userName,image,gender FROM user ";
$result = $DB->read($query, []);

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
</style>
    <div style="text-align: center; animation: appear 0.9s ease;">';

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


