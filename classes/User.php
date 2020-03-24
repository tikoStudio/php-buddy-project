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
         * Get the value of email
         */ 
        public function getEmail()
        {
            return $this->email;
        }
            
        /**
         * Set the value of email
         *
         * @return  self
         */ 
        public function setEmail($email)
        {  
            $this->email = $email;

            return $this;
        }

         /**
         * Get the value of firstname
         */ 
        public function getFirstname()
        {
            return $this->firstname;
        }
            
        /**
         * Set the value of firstname
         *
         * @return  self
         */ 
        public function setFirstName($firstname)
        {  
            $this->firstname = $firstname;

            return $this;
        }

        /**
         * Get the value of lastname
         */ 
        public function getLastname()
        {
            return $this->lastname;
        }

        /**
         * Set the value of lastname
         *
         * @return  self
         */ 
        public function setLastname($lastname)
        {
            $this->lastname = $lastname;

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