<?php
    include_once(__DIR__ . "/../classes/User.php");
    
    if(!empty($_POST)) {
        $user = new User();
        $user->getEmail($_POST['email']);
        $user->availableEmail($_POST['email']);

        $response = [
            'status' => 'succes',
            'body' => 'Email is al in gebruik',
            'message' => 'validate email'
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }


?>