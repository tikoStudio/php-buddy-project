<?php 
    include_once(__DIR__ . "/User.php");
    include_once(__DIR__ . "/Db.php");

    class Buddy extends User {

        public function filterUser() {
            $conn = Db::getConnection();
            $statement = $conn->prepare("SELECT * FROM users WHERE class = :class and interests = :interests and hobbies = :hobbies and beverage = :beverage and pet = :pet");
            $class = $this->getClass();
            $interests = $this->getInterest();
            $hobbies = $this->getHobbies();
            $beverage = $this->getBeverage();
            $pet = $this->getPet();
            $statement->bindParam(":class", $class);
            $statement->bindParam(":interests", $interests);
            $statement->bindParam(":hobbies", $hobbies);
            $statement->bindParam(":beverage", $beverage);
            $statement->bindParam(":pet", $pet);

            $statement->execute();
            $users = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $users;
        }

    }