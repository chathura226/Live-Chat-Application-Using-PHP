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

    function collectData(event){
        // event.preventDefault();
        let signupForm=_("signupForm");
        let inputs=signupForm.getElementsByTagName("INPUT");

        let data={};
        for (let i=inputs.length-1;i>=0;i--){
            let key =inputs[i].name;

            switch (key){
                case "username":
                    data.username=inputs[i].value;
                    break;
                case "email":
                    data.email=inputs[i].value;
                    break;
                case "password":
                    data.password=inputs[i].value;
                    break;
                case "confirmPassword":
                    data.confirmPassword=inputs[i].value;
                    break;
                case "gender":
                    if(inputs[i].checked) data.gender=inputs[i].value;
                    break;
            }
        }

        alert(JSON.stringify(data));


    }

    let signup_button=_("signup-button");
    signup_button.addEventListener("click",collectData);
</script>