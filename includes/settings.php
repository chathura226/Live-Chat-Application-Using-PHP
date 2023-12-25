<?php
$id = $_SESSION['userID'];
$sql="SELECT * FROM user WHERE userID=:userID limit 1";
$data = $DB->read($sql, ['userID' => $id]);

$mydata = "";
if (is_array($data)) {
    $data = $data[0];
    $image = "";
    if (!empty($data->image) && file_exists($data->image)) {//when image is set and exists
        $image = $data->image;
    }else{//when image is not set
        if($data->gender=='male'){//for male users with no image
            $image="ui/images/male.jpg";
        }else{//for female users with no image
            $image="ui/images/female.png";
        }
    }

    $mydata = '<style>
        form {
            text-align: left;
            margin: auto;
            padding: 10px;
            width: 100%;
            max-width: 400px;
            /*background-color: #383e48;*/
        }
    
        input[type=radio] {
            padding: 10px;
            margin: 10px;
            border: solid thin grey;
            transform: scale(1.1);
        }
    
        input[type=text], input[type=password], input[type=submit] {
            padding: 10px;
            margin: 10px;
            width: 100%;
            border-radius: 5px;
            border: solid thin grey;
        }
    
        input[type=submit] {
            width: 105%;
            cursor: pointer;
            background-color: #2b5488;
            color: white;
        }
    
        .saveImage {
            padding: 10px;
            margin: 10px;
            border-radius: 5px;
            border: solid thin grey;
            width: 70%;
            cursor: pointer;
            background-color: #9b9a80;
            color: white;
        }
    
        .alert {
            display: none;
            /*position: fixed;*/
            padding: 20px !important;
            margin: auto;
            width: fit-content;
            height: fit-content;
            min-width: 400px;
            background-color: transparent;
            /*left: 50vw;*/
            /*transform: translate(-50%, -50%);*/
            /*z-index: 999 ;*/
        }
    
        .alert-danger {
            background-color: #f2dede;
            border-color: #ebccd1;
            color: #a94442;
        }
    @keyframes appear {
        0%{
            opacity: 0;
            transform: translateX(-100px);
        }
        
        100%{
            opacity: 1;
            transform: translateX(0px);
        }
    }
    
    .dragging{
        border: dashed 2px #aaa;
    }
    </style>
    
    <div style="text-align: center;"><div id="chat_header">
<span style="font-size: 16px"><svg style="fill: #615EF0;"  xmlns="http://www.w3.org/2000/svg" height="18" width="20" viewBox="0 0 576 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm80 256h64c44.2 0 80 35.8 80 80c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16c0-44.2 35.8-80 80-80zm-32-96a64 64 0 1 1 128 0 64 64 0 1 1 -128 0zm256-32H496c8.8 0 16 7.2 16 16s-7.2 16-16 16H368c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64H496c8.8 0 16 7.2 16 16s-7.2 16-16 16H368c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64H496c8.8 0 16 7.2 16 16s-7.2 16-16 16H368c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/></svg>  <b>Settings</b></span>
</div>
    <div id="error" class="alert alert-danger"></div>
    <div style="display: grid;
      grid-template-columns: 1fr 3fr; /* Two columns with equal width */
      grid-gap: 10px;
      animation: appear 0.9s ease;">
        <div>
            Drag & Drop an image to change the profile picture<br>
            <img ondragover="handleDragAndDrop(event)" ondragleave="handleDragAndDrop(event)" ondrop="handleDragAndDrop(event)" src="'.$image.'" style="width: 150px; height: 150px; margin:10px; "/>
            <label for="changeImageBtn" class="saveImage" id="changeImageLbl">
            Change Image
            </label>
            <input onchange="upload_profile_image(this.files)" class="saveImage" type="file" value="Change Image" id="changeImageBtn" hidden><br>
        </div>
        <form id="signupForm">
            <label for="username">Username: </label>
            <input type="text" name="username" placeholder="Enter your username" value="'.$data->userName.'"><br>
            <label for="email">Email: </label>
            <input type="text" name="email" placeholder="Enter your email address" value="'.$data->email.'"><br>
            <label for="gender">Gender: </label>
            <input type="radio" name="gender" value="male"'.(($data->gender=='male')?'checked':'').'>Male
            <input type="radio" name="gender" value="female"'.(($data->gender=='female')?'checked':'').'>Female<br>
            <label for="password">Password: </label>
            <input type="password" name="password" placeholder="Enter your password"><br>
            <label for="confirmPassword">New Password: </label>
            <input type="password" name="newPassword" placeholder="Enter your new password (leave empty if not changing)"><br>
            <input type="submit" value="Save Settings" id="save-settings-button" onclick="collectData(event)"><br>
    
            <br>
    
    
        </form>
    </div>';


$info->message = $mydata;
$info->dataType = "settings";
echo json_encode($info);

}else {

    $info->message = "Error occured while fetching!";
    $info->dataType = "error";
    echo json_encode($info);
}

?>


