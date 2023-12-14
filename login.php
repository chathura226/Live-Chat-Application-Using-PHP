
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
<div style="font-size: 20px; font-family: myFont;">Login <br><br></div>
    </div>
    <div id="error" class="alert alert-danger">
dxdc
    </div>
    <form id="loginForm">
        <label for="email">Email: </label>
        <input type="text" name="email" placeholder="Enter your email address"><br>
        <label for="password">Password: </label>
        <input type="password" name="password" placeholder="Enter your password"><br>
        <input type="submit" value="Login" id="login-button"><br>
    </form>
</div>
</body>
</html>

<script type="text/javascript">
    //fuction to return element when pass the ID. for make it easy. function name is underscore
    function _(element) {
        return document.getElementById(element);
    }

    let login_button = _("login-button");
    login_button.addEventListener("click", collectData);

    function collectData(event) {
        //disabling button
        login_button.disabled = true;
        login_button.value = "Loading....";

        event.preventDefault();
        let loginForm = _("loginForm");
        let inputs = loginForm.getElementsByTagName("INPUT");

        let data = {};
        for (let i = inputs.length - 1; i >= 0; i--) {
            let key = inputs[i].name;

            switch (key) {

                case "email":
                    data.email = inputs[i].value;
                    break;
                case "password":
                    data.password = inputs[i].value;
                    break;

            }
        }
        sendData(data, "login");


    }

    //type - type of data. what to do with them eg: signup, login etc...
    function sendData(data, type) {
        let xml = new XMLHttpRequest();

        //listening
        xml.onload = function () {
            //readyState 4 means data got as a response successfully
            //200 means everything is good
            if (xml.readyState === 4 || xml.status === 200) {
                console.log(xml.responseText);
                handleResults(xml.responseText);

                //re enabling button
                login_button.disabled = false;
                login_button.value = "Login";
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
        let data=JSON.parse(results);

        if(data.dataType=="info"){
            window.location="index.php";
        }else{//not info, response is abt errors
            let error=_("error");
            error.innerHTML=data.message;
            error.style.display="block";
        }

    }


</script>