<?php

    // Import PHPMailer classes into the global namespace
    // These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    // Load Composer's autoloader
    require 'vendor/autoload.php';

    // UPLOAD IMAGE
    function uploadImage($image) {
        if(!empty($_POST)) {
            $folder = "uploads/";
            $target_file = $folder . basename($image);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
            // Check if image file is correct
            if(isset($_POST["submit"])) {
                $check = getimagesize($image);
                if($check == false) {
                    throw new Exception('Het geuploade bestand is geen foto.');
                    $uploadOk = 0;
                }
            }
            // Check if file already exists
            if (file_exists($target_file)) { // no exception because we Do want to change users picture but not upload it again
                $uploadOk = 0;
            }
            // Check file size
            if ($_FILES["avatar"]["size"] > 2097152) { // file max size is 2mb
                throw new Exception('Je bestand is te groot.');
                $uploadOk = 0;
            }
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                throw new Exception('Alleen JPG, JPEG, PNG & GIF bestanden zijn toegelaten.');
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk != 0) {
                if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
                    return true;
                } else {
                    throw new Exception('Er is iets misgelopen met het uploaden van je foto');
                }
            }
        }
    }
    //END UPLOAD IMAGE

    //SEND MAIL
    function sendMail($email) {
        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);
        
        try {
            //Server settings 
            //$mail->SMTPDebug = 1; debugging
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.sendgrid.net';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'apikey';                               // SMTP username
            $mail->Password   = 'SG.7WNAmuPET1u7IEe7yI7qiw.hoMTSPosxtT3h-zKwGTLTOcOPwOYkfCJTlL-oCTTTFI';                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        
            //Recipients
            $mail->setFrom('buddyproject@mail.com', 'IMD Buddy App');
            $mail->addAddress($email);       
        
            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Buddy verzoek';
            $mail->Body    = 'Je hebt een <b>buddy verzoek!</b> log snel in om te kijken wie met jou wil connecteren';
            $mail->AltBody = 'Je hebt een buddy verzoek! log snel in om te kijken wie met jou wil connecteren';
        
            $mail->send();
        } catch (Exception $e) {
            $error = $mail->ErrorInfo;
        }
    }
    // END SEND MAIL

    //SEND ACTIVATION MAIL
    function sendActivationMail($email, $activationToken) {
        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);
        $fullUri = $_SERVER['REQUEST_URI'];
        $correctUri = str_replace( "register.php", '', $fullUri );
        $link = "http://$_SERVER[HTTP_HOST]$correctUri"."activate.php?u=" . $activationToken;
        try {
            //Server settings 
            //$mail->SMTPDebug = 1; debugging
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.sendgrid.net';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'apikey';                               // SMTP username
            $mail->Password   = 'SG.7WNAmuPET1u7IEe7yI7qiw.hoMTSPosxtT3h-zKwGTLTOcOPwOYkfCJTlL-oCTTTFI';                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        
            //Recipients
            $mail->setFrom('buddyproject@mail.com', 'IMD Buddy App');
            $mail->addAddress($email);       
        
            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'account activatie';
            $mail->Body    = 'Klik op de link om je account te activeren en start met het zoeken van IMD Buddies via ons matchingsysteem! <a href="' . $link . '"> klik hier </a>';
            $mail->AltBody = 'Je hebt een buddy verzoek! log snel in om te kijken wie met jou wil connecteren';
        
            $mail->send();
        } catch (Exception $e) {
            $error = $mail->ErrorInfo;
        }
    }
    
    
?> 