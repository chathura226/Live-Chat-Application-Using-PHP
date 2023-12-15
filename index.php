<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Chat</title>
    <link rel="stylesheet" href="main.styles.css">
</head>

<body>
<div id="wrapper">
    <div id="left_panel">
        <div id="user_info" style="padding: 10px;">
            <img id="profileImg" src="ui/images/user_image.png" alt="User Image">
            <br>
            <span id="username">Username </span>
            <br>
            <span id="useremail" style="font-size: 12px;opacity: 0.5;">Email</span>
            <br>
            <br>
            <br>
            <div>
                <label id="label_chat" for="radio_chat">Chat <img src="ui/icons/chat.png" alt="Chat"></label>
                <label id="label_contacts" for="radio_contacts">Contacts <img src="ui/icons/contacts.png"
                                                                              alt="Contacts"></label>
                <label id="label_settings" for="radio_settings">Settings <img src="ui/icons/settings.png"
                                                                              alt="Settings"></label>
                <label id="logout" for="radio_logout">Logout <img src="ui/icons/logout.png"
                                                                  alt="logout"></label>
            </div>
        </div>

    </div>
    <div id="right_panel">
        <div id="header">My Chat</div>
        <div id="container">


            <div id="inner_left_panel">

                <!-- to add contact info that get by ajax-->
            </div>

            <input type="radio" id="radio_chat" name="radios_for_panels" style="display: none;">
            <input type="radio" id="radio_contacts" name="radios_for_panels" style="display: none;">
            <input type="radio" id="radio_settings" name="radios_for_panels" style="display: none;">

            <div id="inner_right_panel"></div>
        </div>
    </div>
</div>
</body>
</html>

<script type="text/javascript">
    //fuction to return element when pass the ID. for make it easy. function name is underscore
    function _(element) {
        return document.getElementById(element);
    }

    function capitalizeFirstLetter(str) {
        return `${str.charAt(0).toUpperCase()}${str.slice(1)}`;
    }


    //logout functionality
    let logout = _("logout");
    logout.addEventListener("click", () => {
        let ans = confirm("Are you sure you want to logout?");
        if (ans) {
            get_data({}, "logout");
        }
    })


    //get user data on loading the page
    get_data({}, "user_info");

    //find - object describing data that we want to find
    //type - type of data
    function get_data(find, type) {
        let xml = new XMLHttpRequest();

        xml.onload = function () {
            if (xml.readyState == 4 || xml.status == 200) {
                handleResult(xml.responseText, type);
            }
        }

        let data = {};
        data.find = find;
        data.dataType = type;
        data = JSON.stringify(data)
        xml.open("POST", "api.php", true);
        xml.send(data);
    }

    function handleResult(result, type) {
        if (result.trim() != "") {
            // alert(result);
            let obj = JSON.parse(result);
            if (typeof (obj.logged_in) != "undefined" && !obj.logged_in) {
                // alert(result);
                window.location = "login.php";
            } else {
                switch (obj.dataType) {
                    case "userInfo":
                        let username = _("username");
                        let email = _("useremail");
                        username.innerHTML = capitalizeFirstLetter(obj.userName);
                        email.innerHTML = obj.email;
                        break;
                    case "contacts":
                        let inner_left_panel = _("inner_left_panel");
                        inner_left_panel.innerHTML=obj.message;
                        break;
                }
            }
        }
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


    //to get contact data
    let contactLabel=_("label_contacts");
    contactLabel.addEventListener("click",(e)=>{
        get_data({},'contacts');
    })
</script>