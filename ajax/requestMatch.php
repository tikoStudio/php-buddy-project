<?php
    include_once(__DIR__ . "../../classes/Buddy.php");
    include_once(__DIR__ . "../../functions.php");
    if(!empty($_POST['buddyEmail'])) {

        //new class object
        $requestMatch = new Buddy();
        $requestMatch->setId($_POST['userId1']);
        $requestMatch->setUserId2($_POST['userId2']);
       
        //request()
        $requestMatch->requestMatch();
        $requestMatch->stopSearchingMatch($_POST['userId1']);
        $requestMatch->stopSearchingMatch($_POST['userId2']);

       /* // mail user
        // get email adress
        $email = $_POST['buddyEmail'];
        // subject of mail
        $subject = 'Buddy verzoek';
        // message in mail
        $message = "Een ijverige imd student heeft je een buddy request gestuurd!\r\nLog nu in om te kijken wie er met je wil connecteren.\r\nVeel plezier met potentiele buddy!";
        // header with from which email
        $headers = 'From: IMD BUDDIES APP';
        mail($email, $subject, $message, $headers); 
        echo "heyhoy sendmail functie is hier geraakt";*/

        //return success
        $response = [
            'status' => 'success',
            'request' => 'buddy message send'
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }