<?php

    include_once(__DIR__ . "./Db.php");

    class User {
        private $id;
        private $email;
        private $firstname;
        private $lastname;
        private $avatar;
        private $class;
        private $interests;
        private $hobbies;
        private $beverage;
        private $pet;
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

        /**
         * Get the value of id
         */ 
        public function getId()
        {
                return $this->id;
        }

        /**
         * Set the value of id
         *
         * @return  self
         */ 
        public function setId($id)
        {
                $this->id = $id;

                return $this;
        }

        /**
         * Get the value of avatar
         */ 
        public function getAvatar()
        {
            return $this->avatar;
        }
            
        /**
         * Set the value of avatar
         *
         * @return  self
         */ 
        public function setAvatar($avatar)
        {  
            $this->avatar = $avatar;

            return $this;
        }

        /**
         * Get the value of Class
         */ 
        public function getClass()
        {
            return $this->class;
        }
            
        /**
         * Set the value of class
         *
         * @return  self
         */ 
        public function setClass($class)
        {  
            $this->class = $class;

            return $this;
        }

        /**
         * Get the value of interests
         */ 
        public function getInterest()
        {
            return $this->interests;
        }
            
        /**
         * Set the value of interests
         *
         * @return  self
         */ 
        public function setInterests($interests)
        {  
            $this->interests = $interests;

            return $this;
        }
        
        /**
         * Get the value of hobbies
         */ 
        public function getHobbies()
        {
            return $this->hobbies;
        }
            
        /**
         * Set the value of hobbies
         *
         * @return  self
         */ 
        public function setHobbies($hobbies)
        {  
            $this->hobbies = $hobbies;

            return $this;
        }

        /**
         * Get the value of beverage
         */ 
        public function getBeverage()
        {
            return $this->beverage;
        }
            
        /**
         * Set the value of beverage
         *
         * @return  self
         */ 
        public function setBeverage($beverage)
        {  
            $this->beverage = $beverage;

            return $this;
        }

        /**
         * Get the value of pet
         */ 
        public function getPet()
        {
            return $this->pet;
        }
            
        /**
         * Set the value of pet
         *
         * @return  self
         */ 
        public function setPet($pet)
        {  
            $this->pet = $pet;

            return $this;
        }

        /*
         * checkLogin
         */
        public static function checkLogin($email, $password) {
            //db conn
            $conn = Db::getConnection();
            //insert query
            $statement = $conn->prepare("select * from users where email = :email");
            $statement->bindParam(":email", $email);

            //return result
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            if(empty($result)) {
                return false;
            }
            $hash = $result[0]["password"];
            var_dump($result);
            echo "<br>";
            echo $password . "<br>";
            echo $hash . "<br>";
            var_dump(password_get_info($hash));
            echo "<br>";
            if(password_verify($password, $hash)) {
                return true;
            }else {
                echo "fail";
                return false;
            }
        }

        /*
         * get all user data
         */
        public function allUserData() {
            //db conn
            $conn = Db::getConnection();
            //insert query
            $statement = $conn->prepare("select * from users where id = :id");
            $id = $this->getId();
            $statement->bindParam(":id", $id);

            //return result
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            
            return $result;
        }

        /*
         * send all data from completing profile to database
         */
        public function completeProfile() {
            //db conn
            $conn = Db::getConnection();
            //insert query
            $statement = $conn->prepare("update users set firstname= :firstname, lastname= :lastname, avatar= :avatar, class= :class, interests= :interests, hobbies= :hobbies, beverage= :beverage, pet= :pet where id= :id");
            $id = $this->getId();
            $firstname = $this->getFirstname();
            $lastname = $this->getLastname();
            $avatar = $this->getAvatar();
            $class = $this->getClass();
            $interests = $this->getInterest();
            $hobbies = $this->getHobbies();
            $beverage = $this->getBeverage();
            $pet = $this->getPet();
            
            $statement->bindParam(":id", $id);
            $statement->bindParam(":firstname", $firstname);
            $statement->bindParam(":lastname", $lastname);
            $statement->bindParam(":avatar", $avatar);
            $statement->bindParam(":class", $class);
            $statement->bindParam(":interests", $interests);
            $statement->bindParam(":hobbies", $hobbies);
            $statement->bindParam(":beverage", $beverage);
            $statement->bindParam(":pet", $pet);

            //return result
            $result = $statement->execute();
    
            return $result;
        }

}
