<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Chat</title>
</head>
<style>
    @font-face {
        font-family: headerFont;
        src: url("ui/fonts/Summer-Vibes-OTF.otf");
    }

    @font-face {
        font-family: myFont;
        src: url("ui/fonts/OpenSans-Regular.ttf");
    }

    #wrapper {
        max-width: 900px;
        min-height: 500px;
        display: flex;
        margin: auto;
        color: white;
        font-family: myFont;
        font-size: 13px;
    }

    #left_panel {
        min-height: 500px;
        background-color: #27344b;
        flex: 1;
        text-align: center;

    }

    #profileImg {
        width: 50%;
        border: solid thin white;
        border-radius: 50%;
        margin: 10px;
    }

    #left_panel label{
        width: 100%;
        height: 20px;
        display: block;
        background-color: #404b56;
        border-bottom: solid thin #ffffff55;
        cursor: pointer;
        padding: 5px;
        transition: all 1s ease;
    }

    #left_panel label:hover{
        background-color: #778593;
    }

    #left_panel label img{
        float: right;
        width: 25px;
    }


    #right_panel {
        min-height: 400px;
        background-color: green;
        flex: 4;
        text-align: center;
    }

    #header {
        background-color: #485b6c;
        height: 70px;
        font-size: 40px;
        font-family: headerFont;
        text-align: center;
    }

    #container {
        display: flex;
    }

    #inner_left_panel {
        background-color: #383e48;
        flex: 1;
        min-height: 430px;
    }

    #inner_right_panel {
        background-color: #f2f7f8;
        flex: 2;
        min-height: 430px;
        transition: all 1.5s ease;
    }

    /*symbol ~ is for sibling*/
    #radio_chat:not(:checked) ~ #inner_right_panel{
        flex: 0;
    }
</style>
<body>
<div id="wrapper">
    <div id="left_panel">
        <div style="padding: 10px;">
            <img id="profileImg"src="ui/images/user3.jpg" alt="User Image">
            <br>
            Sophie Willis
            <br>
            <span style="font-size: 12px;opacity: 0.5;">sophiewillis@gmail.com</span>
            <br>
            <br>
            <br>
            <div>
                <label id="label_chat" for="radio_chat">Chat <img src="ui/icons/chat.png" alt="Chat"></label>
                <label id="label_contacts" for="radio_contacts">Contacts <img src="ui/icons/contacts.png" alt="Chat"></label>
                <label id="label_settings" for="radio_settings">Settings <img src="ui/icons/settings.png" alt="Chat"></label>
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