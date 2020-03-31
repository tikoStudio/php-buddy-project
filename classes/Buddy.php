<?php
    include_once(__DIR__ . "/User.php");
    include_once(__DIR__ . "./Db.php");

    class Buddy extends user {
        //userId1 not neccesary because it = $id from User class
        private $userAnswer1;
        private $user2Id;
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

        public function getUser2Id()
        {
                return $this->user2Id;
        }
 
        public function setUser2Id($user2Id)
        {
                $this->user2Id = $user2Id;

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
    }