<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Chat</title>
    <link rel="stylesheet" href="signup.styles.css">
</head>

<body>
<div id="wrapper">
    <div class="header">
        My Chat
        <div style="font-size: 20px; font-family: myFont;">Signup <br><br></div>
    </div>
    <form id="signupForm">
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
        <input type="submit" value="Signup" id="signup-button"><br>
    </form>
</div>
</body>
</html>

<script type="text/javascript">
    //fuction to return element when pass the ID. for make it easy. function name is underscore
    function _(element) {
        return document.getElementById(element);
    }

    function collectData(event) {
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
                alert(xml.responseText);
            }
        }

        data.dataType=type;
        let data_string=JSON.stringify(data);//converting to string
        //sending
        //true for asynchronous
        xml.open("POST","api.php",true);
        xml.send(data_string);

    }

    let signup_button = _("signup-button");
    signup_button.addEventListener("click", collectData);
</script>