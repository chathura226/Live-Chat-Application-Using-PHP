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
    <form>
        <label for="username">Username: </label>
        <input type="text" name="username" placeholder="Enter your username"><br>
        <label for="gender">Gender: </label>
        <input type="radio" name="gender" value="male">Male
        <input type="radio" name="gender" value="female">Female<br>
        <label for="password">Password: </label>
        <input type="password" name="password" placeholder="Enter your password"><br>
        <label for="confirmPassword">Confirm Password: </label>
        <input type="password" name="confirmPassword" placeholder="Re-enter your password"><br>
        <input type="submit" value="Signup"><br>
    </form>
</div>
</body>
</html>

<script type="text/javascript">
    //fuction to return element when pass the ID. for make it easy. function name is underscore
    function _(element) {
        return document.getElementById(element);
    }


    let label = _("label_chat");
    label.addEventListener("click", () => {
        let inner_left_panel = _("inner_left_panel");

        //ajax object to read data from server without refreshing
        let ajax = new XMLHttpRequest();
        //when ajax load.
        ajax.onload = function () {
            //200->OK , readyState=4 -> data have been returned
            if (ajax.status == 200 || ajax.readyState == 4) {
                inner_left_panel.innerHTML = ajax.responseText;
            }

        }

        //true means read req asynchronously
        ajax.open("POST", "file.txt", true);
        ajax.send();
    })

</script>