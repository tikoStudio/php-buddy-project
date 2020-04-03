<?php
    include_once(__DIR__ . "/User.php");
    include_once(__DIR__ . "./Db.php");

    class Buddy extends user {
        //userId1 not neccesary because it = $id from User class
        private $userAnswer1;
        private $userId2;
        private $userAnswer2;

        public function getUserAnswer1()
        {
                return $this->userAnswer1;
        }
 
        public function setUserAnswer1($userAnswer1)
        {
                $this->userAnswer1 = $userAnswer1;

                return $this;
        }

        public function getUserId2()
        {
                return $this->userId2;
        }
 
        public function setUserId2($userId2)
        {
                $this->userId2 = $userId2;

                return $this;
        }

        public function getUserAnswer2()
        {
                return $this->userAnswer2;
        }

        public function setUserAnswer2($userAnswer2)
        {
                $this->userAnswer2 = $userAnswer2;

                return $this;
        }

        public function searchMatch() {
            //db conn
            $conn = Db::getConnection();

            $class = $this->getClass();
            //check for searching user what class he is     
            $class1 = "1IMD";
            $class2 = "2IMD";
            $class3 = "3IMD";

            if($class == "1IMD") { //select 2IMD and 3IMD students
                $statement = $conn->prepare("select * from users where class = :class2 or class = :class3 and buddySearching = 1");
                $statement->bindParam(":class2", $class2);
                $statement->bindParam(":class3", $class3);
            }else {
                $statement = $conn->prepare("select * from users where class = :class1 and buddySearching = 1");
                $statement->bindParam(":class1", $class1);
            }
        
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }

        public function requestMatch() {
            //db conn
            $conn = Db::getConnection();
            //insert query
            $statement = $conn->prepare("insert into buddies (userId1, userAnswer1, userId2) values (:userId1, :userAnswer1, :userId2)");
            $userId1 = $this->getId();
            $userAnswer1 = 1;
            $userId2 = $this->getUserId2();
            $statement->bindParam(":userId1", $userId1);
            $statement->bindParam(":userId2", $userId2);
            $statement->bindParam(":userAnswer1", $userAnswer1);

            $statement->execute();

        }

        public function stopSearchingMatch($id) {
            //db conn
            $conn = Db::getConnection();
            //insert query
            $statement = $conn->prepare("update users set buddySearching= 0 where id= :id");
            $statement->bindParam(":id", $id);

            $statement->execute();
        }
    }