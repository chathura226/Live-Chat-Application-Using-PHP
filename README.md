# Nexus Chat
## Live-Chat-Application-Using-PHP
Nexus Chat is a real-time messaging application built using PHP as the server-side scripting language and AJAX (Asynchronous JavaScript and XML) for handling asynchronous requests between the client and server.

## Main Features
- Real-time chat updates.
- Shows whether the receiver has seen the message or the message has been delivered.
- Shows the number of unread new messages
- Dockerized for easier deployment
- Sound effects for sending messages and receiving messages.
- Signup and Login system with authentication and validations.
- Change password and other profile settings
- File uploading capabilities
- Drag and Drop uploading
- Error handling with an alert system
- Message deletion and thread deletion

## Steps to run
- Move inside of docker folder
- In terminal run the command below.
  ```
  ./livechat.sh up
  ```
- Above command will use "docker-compose up" and chat application will run on localhost:80 and phpMyAdmin on localhost:8001
- To stop and dump the database for saving, run the command below.
   ```
  ./livechat.sh down
  ```
- This will dump the database into the 'db' folder which will be used when you run the app again.

## Some Screenshots
Main chat area
![Screenshot from 2023-12-25 22-24-25](https://github.com/chathura226/Live-Chat-Application-Using-PHP/assets/85506006/577c42cf-6fe9-4368-93e3-79644f606e72)
Login
![Screenshot from 2023-12-25 22-21-08](https://github.com/chathura226/Live-Chat-Application-Using-PHP/assets/85506006/c25bfee0-eece-4875-9325-f75b5856281a)
Signup
![Screenshot from 2023-12-25 22-21-13](https://github.com/chathura226/Live-Chat-Application-Using-PHP/assets/85506006/0ead8a4c-6ba0-4f1e-a99b-1f1c4facc06c)
Contacts with unread message count
![Screenshot from 2023-12-25 22-25-13](https://github.com/chathura226/Live-Chat-Application-Using-PHP/assets/85506006/8c5edaac-af95-4403-a617-c1d1e0d7fe65)
Changing settings
![Screenshot from 2023-12-25 22-46-23](https://github.com/chathura226/Live-Chat-Application-Using-PHP/assets/85506006/b545e1b2-0cdb-48d2-8630-e30fe42c6fc6)
