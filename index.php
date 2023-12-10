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
        <div style="padding: 10px;">
            <img id="profileImg" src="ui/images/user3.jpg" alt="User Image">
            <br>
            Sophie Willis
            <br>
            <span style="font-size: 12px;opacity: 0.5;">sophiewillis@gmail.com</span>
            <br>
            <br>
            <br>
            <div>
                <label id="label_chat" for="radio_chat">Chat <img src="ui/icons/chat.png" alt="Chat"></label>
                <label id="label_contacts" for="radio_contacts">Contacts <img src="ui/icons/contacts.png"
                                                                              alt="Chat"></label>
                <label id="label_settings" for="radio_settings">Settings <img src="ui/icons/settings.png"
                                                                              alt="Chat"></label>
            </div>
        </div>
    </div>
    <div id="right_panel">
        <div id="header">My Chat</div>
        <div id="container">


            <div id="inner_left_panel">

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
        ajax.open("POST","file.txt",true);
        ajax.send();
    })

</script>