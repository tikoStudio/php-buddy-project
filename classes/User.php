<?php

    include_once(__DIR__ . "./Db.php");

    class User {
        protected $id;
        protected $email;
        protected $updateEmail;
        protected $password;
        protected $updatePassword;
        protected $firstname;
        protected $lastname;
        protected $description;
        protected $avatar;
        protected $class;
        protected $interests;
        protected $hobbies;
        protected $beverage;
        protected $pet;
        

        public function setFirstname($firstname) {
                if(empty($firstname)) {
                        throw new Exception("Voornaam mag niet leeg zijn!");
                }

                if(!preg_match("/^[a-zA-Z ]*$/", $firstname)) {
                        throw new Exception("Voornaam is niet geldig!");
                }

            $this->firstname = $firstname;
            return $this;
        }

        public function getFirstname() {
            return $this->firstname;
        }

        public function setLastname($lastname) {

                if(empty($lastname)) {
                        throw new Exception("Achternaam mag niet leeg zijn!");
                }

                if(!preg_match("/^[a-zA-Z ]*$/", $lastname)) {
                        throw new Exception("Achternaam is niet geldig!");
                }

                $this->lastname = $lastname;

                return $this;
        }

        public function getLastname() {
                return $this->lastname;
        }

        public function setEmail($email) {

                if(empty($email)) {
                        throw new Exception("Email mag niet leeg zijn!");
                }
                $this->email = $email;

                return $this;
        }

        public function getEmail() {
                return $this->email;
        }

        public function validEmail() {
                $email = $this->getEmail();
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
                        throw new Exception("Email is al in gebruik!");
                        return false;
                }
        }

        public function endsWith($target) {
                $email = $this->getEmail();
                $length = strlen($target);
                if ($length == 0) {
                        return true;
                }
 
                return (substr($email, -$length) === $target);
        }

        public function setPassword($password) {

                if(empty($password)) {
                        throw new Exception("Wachtwoord mag niet leeg zijn!");
                }

                $options = ['cost' => 12];
                $password = password_hash($password, PASSWORD_DEFAULT, $options);

                $this->password = $password;

                return $this;
        }

        public function getPassword() {
                return $this->password;
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

        public function getId()
        {
                return $this->id;
        }

        public function setId($id)
        {
                $this->id = $id;

                return $this;
        }
 
        public function getAvatar()
        {
            return $this->avatar;
        }
            
        public function setAvatar($avatar)
        {  
            $this->avatar = $avatar;

            return $this;
        }
 
        public function getClass()
        {
            return $this->class;
        }
             
        public function setClass($class)
        { 
            $this->class = $class;

            return $this;
        }
 
        public function getInterest()
        {
            return $this->interests;
        }
             
        public function setInterests($interests)
        {  
            $this->interests = $interests;

            return $this;
        }
        
        public function getHobbies()
        {
            return $this->hobbies;
        }
            
        public function setHobbies($hobbies)
        {  
            $this->hobbies = $hobbies;

            return $this;
        }

        public function getBeverage()
        {
            return $this->beverage;
        }
            
        public function setBeverage($beverage)
        {  
            $this->beverage = $beverage;

            return $this;
        }

        public function getPet()
        {
            return $this->pet;
        }
            
        public function setPet($pet)
        {  
            $this->pet = $pet;

            return $this;
        }

        public function checkLogin($email, $password) {
            //db conn
            $conn = Db::getConnection();
            //insert query
            $statement = $conn->prepare("select * from users where email = :email");
            $statement->bindParam(":email", $email);

            //return result
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            if(empty($result)) {
                return false;
            }
            $hash = $result["password"];
            if(password_verify($password, $hash)) {
                return true;
            }else {
                return false;
            }
        }

        public function allUserData() {
            //db conn
            $conn = Db::getConnection();
            //insert query
            $statement = $conn->prepare("select * from users where id = :id");
            $id = $this->getId();
            $statement->bindParam(":id", $id);

            //return result
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            
            return $result;
        }

        public function idFromSession($email) {
                //db conn
                $conn = Db::getConnection();
                //insert query
                $statement = $conn->prepare("select id from users where email = :email");
                $statement->bindParam(":email", $email);
    
                //return result
                $statement->execute();
                $result = $statement->fetch(PDO::FETCH_ASSOC);
                return $result;
            }

        public function completeProfile() {
            //db conn
            $conn = Db::getConnection();
            //insert query
            $statement = $conn->prepare("update users set firstname= :firstname, lastname= :lastname, description = :description, avatar= :avatar, class= :class, interests= :interests, hobbies= :hobbies, beverage= :beverage, pet= :pet where id= :id");
            $id = $this->getId();
            $firstname = $this->getFirstname();
            $lastname = $this->getLastname();
            $description = $this->getDescription();
            $avatar = $this->getAvatar();
            $class = $this->getClass();
            $interests = $this->getInterest();
            $hobbies = $this->getHobbies();
            $beverage = $this->getBeverage();
            $pet = $this->getPet();
            
            $statement->bindParam(":id", $id);
            $statement->bindParam(":firstname", $firstname);
            $statement->bindParam(":lastname", $lastname);
            $statement->bindParam(":description", $description);
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

        public function getDescription()
        {
                return $this->description;
        }

        public function setDescription($description)
        {
                $this->description = $description;

                return $this;
        }

        public function getUpdateEmail()
        {
                return $this->updateEmail;
        }

        public function setUpdateEmail($updateEmail)
        {
                $this->updateEmail = $updateEmail;

                return $this;
        }

        public function changeEmail() {
             //db conn
             $conn = Db::getConnection();
             //insert query
             $statement = $conn->prepare("update users set email = :updateEmail where email= :email");
             $email = $this->getEmail();
             $updateEmail = $this->getUpdateEmail();

             $statement->bindParam(":email", $email);
             $statement->bindParam(":updateEmail", $updateEmail);

            //return result
            $result = $statement->execute();
            $this->setEmail($updateEmail);
            return $result;
        }

        public function getUpdatePassword()
        {
                return $this->updatePassword;
        }

        public function setUpdatePassword($updatePassword)
        {
            if(empty($updatePassword)) {
                throw new Exception("Wachtwoord mag niet leeg zijn!");
            }

            $options = ['cost' => 12];
            $updatePassword = password_hash($updatePassword, PASSWORD_DEFAULT, $options);

            $this->updatePassword = $updatePassword;
            return $this;
        }

        public function changePassword() {
            //db conn
            $conn = Db::getConnection();
            //insert query
            $statement = $conn->prepare("update users set password = :updatePassword where email= :email");
            $email = $this->getEmail();
            $updatePassword = $this->getUpdatePassword();

            $statement->bindParam(":email", $email);
            $statement->bindParam(":updatePassword", $updatePassword);

             //return result
             $result = $statement->execute();
             return $result;
        }

        public function countUsers() {
                $conn = Db::getConnection();
                $statement = $conn->prepare("SELECT COUNT(*) FROM users");
                $result = $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                return $result;
        }

        public function countBuddies() {
                $conn = Db::getConnection();
                $statement = $conn->prepare("SELECT COUNT(*) FROM buddies WHERE userAnswer1 = 1 AND userAnswer2 = 1");
                $result = $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                return $result;
        }
}