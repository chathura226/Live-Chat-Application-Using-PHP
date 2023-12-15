<?php
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

    input[type=text], input[type=password], input[type=submit]{
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

    .saveImage{
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
    <img src="ui/images/male.jpg" style="width: 150px; height: 150px; margin:10px; "/>
    <input class="saveImage" type="button" value="Change Image" id="changeImageBtn"><br>
    </div>
    <form id="signupForm" >
        <label for="username">Username: </label>
        <input type="text" name="username" placeholder="Enter your username"><br>
        <label for="email">Email: </label>
        <input type="text" name="email" placeholder="Enter your email address"><br>
        <label for="gender">Gender: </label>
        <input type="radio" name="gender" value="male">Male
        <input type="radio" name="gender" value="female">Female<br>
        <label for="password">Password: </label>
        <input type="password" name="password" placeholder="Enter your password"><br>
        <label for="confirmPassword">Confirm Password: </label>
        <input type="password" name="confirmPassword" placeholder="Re-enter your password"><br>
        <input type="submit" value="Save Settings" id="signup-button"><br>

        <br>


    </form>
</div>


<script type="text/javascript">
    //fuction to return element when pass the ID. for make it easy. function name is underscore
    function _(element) {
        return document.getElementById(element);
    }

    let signup_button = _("signup-button");
    signup_button.addEventListener("click", collectData);

    function collectData(event) {
        //disabling button
        signup_button.disabled = true;
        signup_button.value = "Loading....";

        event.preventDefault();
        let signupForm = _("signupForm");
        let inputs = signupForm.getElementsByTagName("INPUT");

        let data = {};
        for (let i = inputs.length - 1; i >= 0; i--) {
            let key = inputs[i].name;

            switch (key) {
                case "username":
                    data.username = inputs[i].value;
                    break;
                case "email":
                    data.email = inputs[i].value;
                    break;
                case "password":
                    data.password = inputs[i].value;
                    break;
                case "confirmPassword":
                    data.confirmPassword = inputs[i].value;
                    break;
                case "gender":
                    if (inputs[i].checked) data.gender = inputs[i].value;
                    break;
            }
        }
        sendData(data, "signup");


    }

    //type - type of data. what to do with them eg: signup, login etc...
    function sendData(data, type) {
        let xml = new XMLHttpRequest();

        //listening
        xml.onload = function () {
            //readyState 4 means data got as a response successfully
            //200 means everything is good
            if (xml.readyState === 4 || xml.status === 200) {
                handleResults(xml.responseText);

                //re enabling button
                signup_button.disabled = false;
                signup_button.value = "Signup";
            }
        }

        data.dataType = type;
        let data_string = JSON.stringify(data);//converting to string
        //sending
        //true for asynchronous
        xml.open("POST", "api.php", true);
        xml.send(data_string);

    }

    function handleResults(results) {
        let data = JSON.parse(results);

        if (data.dataType == "info") {
            window.location = "index.php";
        } else {//not info, response is abt errors
            let error = _("error");
            error.innerHTML = data.message;
            error.style.display = "block";
        }

    }


</script>
';

$info->message = $mydata;
$info->dataType = "settings";
echo json_encode($info);

die;

$info->message = "No settings were found!";
$info->dataType = "error";
echo json_encode($info);
?>


