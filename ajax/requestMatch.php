<?php
    include_once(__DIR__ . "../../classes/Buddy.php");
    include_once(__DIR__ . "../../functions.php");
    if(!empty($_POST)) {

        //new class object
        $requestMatch = new Buddy();
        $requestMatch->setId($_POST['userId1']);
        $requestMatch->setUserId2($_POST['userId2']);
       
        //request()
        $requestMatch->requestMatch();
        $requestMatch->stopSearchingMatch($_POST['userId1']);
        $requestMatch->stopSearchingMatch($_POST['userId2']);

        // mail user
        //$requestMatch->sendMail($_POST['buddyEmail']);
        //$test = $_POST['buddyEmail'];

        //return success
        $response = [
            'status' => 'success',
            'request' => 'buddy message send'
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }