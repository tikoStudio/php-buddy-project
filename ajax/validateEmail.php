<?php
    namespace src\Buddy;

    spl_autoload_register();
    
    if (!empty($_POST)) {
        $user = new User();
        $user->getEmail($_POST['email']);
        $emailCheck = $user->availableEmail($_POST['email']);

        if ($emailCheck) {
            $response = [
                'status' => 'succes',
                'body' => 'Email is bruikbaar',
                'message' => 'validate email'
            ];
        } else {
            $response = [
                'status' => 'succes',
                'body' => 'Email is al in gebruik',
                'message' => 'validate email'
            ];
        }

       

        header('Content-Type: application/json');
        echo json_encode($response);
    }
