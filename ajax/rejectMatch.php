<?php
    include_once(__DIR__ . "../../classes/Buddy.php");
    if(!empty($_POST)) {

        //new class object
        $requestMatch = new Buddy();
        $requestMatch->setId($_POST['userId1']);
        $requestMatch->setUserId2($_POST['userId2']);
       
        //request()
        
        $requestMatch->rejectMatch();
        $requestMatch->startSearchingMatch($_POST['userId1']);
        $requestMatch->startSearchingMatch($_POST['userId2']);

        //return success
        $response = [
            'status' => 'success',
            'request' => 'buddy was accepted'
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }