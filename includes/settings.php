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
    </style>
    
    
    <div id="error" class="alert alert-danger"></div>
    <div style="display: grid;
      grid-template-columns: 1fr 3fr; /* Two columns with equal width */
      grid-gap: 10px;">
        <div>
            <img src="'.$image.'" style="width: 150px; height: 150px; margin:10px; "/>
            <input class="saveImage" type="button" value="Change Image" id="changeImageBtn"><br>
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
            <label for="confirmPassword">Confirm Password: </label>
            <input type="password" name="newPassword" placeholder="Enter your new password (leave empty if not changing)"><br>
            <input type="submit" value="Save Settings" id="save-settings-button" onclick="collectData(event)"><br>
    
            <br>
    
    
        </form>
    </div>';
}

$info->message = $mydata;
$info->dataType = "settings";
echo json_encode($info);

die;

$info->message = "Error occured while fetching!";
$info->dataType = "error";
echo json_encode($info);


?>


