<?php

        include_once(__DIR__ . "/Db.php");

    class User {
        private $firstname;
        private $lastname;
        private $email;
        private $password;
        private $passwordconfirmation;

        public function setFirstname($firstname) {
                if(empty($firstname)) {
                        throw new Exception("Voornaam mag niet leeg zijn!");
                }

                if(!preg_match("/^[a-zA-Z ]*$/", $_POST['firstname'])) {
                        throw new Exception("Voornaam is niet geldig!");
                }

            $this->firstname = $firstname;
            return $this;
        }

        public function getFirstname() {
            return $this->firstname;
        }

        public function getLastname() {
                return $this->lastname;
        }


        public function setLastname($lastname) {

                if(empty($lastname)) {
                        throw new Exception("Achternaam mag niet leeg zijn!");
                }

                if(!preg_match("/^[a-zA-Z ]*$/", $_POST['lastname'])) {
                        throw new Exception("Achternaam is niet geldig!");
                }

                $this->lastname = $lastname;

                return $this;
        }

        public function getEmail() {
                return $this->email;
        }

        public function setEmail($email) {

                if(empty($email)) {
                        throw new Exception("Email mag niet leeg zijn!");
                }
/*
                // hier moet je er nog voor zorgen dat het email adres moet eindigen op @student.thomasmore.be
                if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                        throw new Exception("Email is not valid!");
                }
*/
                $this->email = $email;

                return $this;
        }

        public function getPassword() {
                return $this->password;
        }

        public function setPassword($password) {

                if(empty($password)) {
                        throw new Exception("Wachtwoord mag niet leeg zijn!");
                }

                $options = ['cost' => 15];
                $password = password_hash($this->password, PASSWORD_DEFAULT, $options);

                $this->password = $password;

                return $this;
        }

        public function getPasswordconfirmation() {
                return $this->passwordconfirmation;
        }

        public function setPasswordconfirmation($passwordconfirmation) {

                if(empty($passwordconfirmation)) {
                        throw new Exception("Wachtwoord mag niet leeg zijn!");
                }

                $options = ['cost' => 15];
                $passwordconfirmation = password_hash($this->passwordconfirmation, PASSWORD_DEFAULT, $options);

                $this->passwordconfirmation = $passwordconfirmation;

                return $this;
        }

        public function save() {
                // connectie
                $conn = Db::getConnection();

                // query
                $statement = $conn->prepare("insert into users (firstname, lastname, email, password) values (:firstname, :lastname, :email, :password)");
                
                // variabelen klaarzetten om te binden
                $firstname = $this->getFirstname();
                $lastname = $this->getLastname();
                $email = $this->getEmail();
                $password = $this->getPassword();
                
                // uitlezen wat er in de variabele zit en die zal op een veilige manier gekleefd worden
                $statement->bindParam(":firstname", $firstname);
                $statement->bindParam(":lastname", $lastname);
                $statement->bindParam(":email", $email);
                $statement->bindParam(":password", $password);

                // als je geen execute doet dan wordt die query niet uitgevoerd
                $result = $statement->execute();

                return $result;
        }

        public function validEmail($email) {
                $email = $_POST['email'];
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        return true;
                    } else {
                        return false;
                    }
        }

        public function availableEmail($email) {
                $conn = Db::getConnection();
                $statement = $conn->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
                $statement->bindParam(":email", $email);
                $statement->execute();
                $result = $statement->fetch(PDO::FETCH_ASSOC);

                if ($result == false) {
                        // Email available
                        return true;
                } else {
                        // Email not available
                        return false;
                }
        }

        public function endsWith($email, $target) {
                $length = strlen($target);
                if ($length == 0) {
                return true;
    }
 
                return (substr($email, -$length) === $target);
        }
        
    }