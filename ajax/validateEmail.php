<?php
    include_once(__DIR__ . "/../classes/User.php");
    
    if(!empty($_POST['email'])) {
        $email = $_POST['email'];

        if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
            $error = "Email is al in gebruik";
        } 

        $response = [
            'status' => 'error',
            'message' => 'Email is al in gebruik'
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }


?>