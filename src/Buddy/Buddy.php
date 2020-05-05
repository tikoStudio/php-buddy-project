<?php

    namespace src\Buddy;

    include_once('../../functions.php');

    class Buddy extends user
    {
        //userId1 not neccesary because it = $id from User class
        private $userAnswer1;
        private $userId2;
        private $userAnswer2;
        private $reasonAnswer;
        private $activationToken;

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

        public function getReasonAnswer()
        {
            return $this->reasonAnswer;
        }

        public function setReasonAnswer($reasonAnswer)
        {
            $this->reasonAnswer = $reasonAnswer;

            return $this;
        }

        public function getActivationToken()
        {
            return $this->activationToken;
        }

        public function setActivationToken($activationToken)
        {
            $this->activationToken = $activationToken;

            return $this;
        }

        public function filterUser()
        {
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
            $users = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $users;
        }


        public function searchMatch()
        {
            //db conn
            $conn = Db::getConnection();

            $class = $this->getClass();
            //check for searching user what class he is
            $class1 = "1IMD";
            $class2 = "2IMD";
            $class3 = "3IMD";

            if ($class == "1IMD") { //select 2IMD and 3IMD students
                $statement = $conn->prepare("select * from users where class = :class2 or class = :class3 and buddySearching = 1");
                $statement->bindParam(":class2", $class2);
                $statement->bindParam(":class3", $class3);
            } else {
                $statement = $conn->prepare("select * from users where class = :class1 and buddySearching = 1");
                $statement->bindParam(":class1", $class1);
            }
        
            $statement->execute();
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        }

        public function requestMatch()
        {
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

        public function pendingMatch()
        {
            //db conn
            $conn = Db::getConnection();
            //insert query
            $statement = $conn->prepare("SELECT * FROM buddies WHERE userAnswer1 = 1 AND userAnswer2 IS NULL AND userId2 = :id");
            $id = $this->getId();
            $statement->bindParam(":id", $id);
            $test = $statement->execute();
            $result = $statement->fetch(\PDO::FETCH_ASSOC);
            return $result;
        }

        public function searchPendingMatch($pendingMatch)
        {
            $conn = Db::getConnection();
            $statement = $conn->prepare("SELECT u1.firstname AS firstname1, u1.lastname AS lastname1, u1.avatar AS avatar1, u1.id AS id1, u2.id as id2, u1.interests as interests1, u2.interests as interests2, u1.hobbies as hobbies1, u2.hobbies as hobbies2, u1.beverage as beverage1, u2.beverage as beverage2, u1.pet as pet1, u2.pet as pet2
            FROM users AS u1, buddies, users AS u2
            WHERE buddies.userId1 = u1.id AND buddies.userId2 = u2.id AND u1.id = :pendingId1 AND u2.id = :pendingId2");
            $statement->bindParam(":pendingId1", $pendingMatch['userId1']);
            $statement->bindParam(":pendingId2", $pendingMatch['userId2']);
            $statement->execute();
            $result = $statement->fetch(\PDO::FETCH_ASSOC);
            return $result;
        }

        public function stopSearchingMatch($id)
        {
            //db conn
            $conn = Db::getConnection();
            //insert query
            $statement = $conn->prepare("update users set buddySearching= 0 where id= :id");
            $statement->bindParam(":id", $id);

            $statement->execute();
        }

        public function startSearchingMatch($id)
        {
            //db conn
            $conn = Db::getConnection();
            //insert query
            $statement = $conn->prepare("update users set buddySearching= 1 where id= :id");
            $statement->bindParam(":id", $id);

            $statement->execute();
        }

        public function searchFriends()
        {
            //db conn
            $conn = Db::getConnection();
            //insert query
            $statement = $conn->prepare("SELECT u1.firstname AS firstname1, u1.lastname AS lastname1, u1.avatar AS avatar1, u2.firstname AS firstname2, u2.lastname AS lastname2, u2.avatar AS avatar2
            FROM users AS u1, buddies, users AS u2
            WHERE buddies.userId1 = u1.id AND buddies.userId2 = u2.id AND buddies.userAnswer1 = 1 AND buddies.userAnswer2 = 1");

            $statement->execute();
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        }

        public function acceptMatch()
        {
            //db conn
            $conn = Db::getConnection();
            //insert query
            $statement = $conn->prepare("update buddies set userAnswer2= 1 where userId1 = :id1 and userId2 = :id2 order by id desc limit 1");
            $id1= $this->getId();
            $id2 = $this->getUserId2();
            $statement->bindParam(":id1", $id1);
            $statement->bindParam(":id2", $id2);
            $statement->execute();
        }

        public function rejectMatch()
        {
            //db conn
            $conn = Db::getConnection();
            //insert query
            $statement = $conn->prepare("update buddies set userAnswer2= 0, reasonAnswer2= :reason where userId1 = :id1 and userId2 = :id2");
            $id1= $this->getId();
            $id2 = $this->getUserId2();
            $reasonAnswer = $this->getReasonAnswer();
            $statement->bindParam(":id1", $id1);
            $statement->bindParam(":id2", $id2);
            if (empty($reasonAnswer)) {
                $reasonAnswer = "Geen reden gegeven";
            }
            $statement->bindParam(":reason", $reasonAnswer);
            $statement->execute();
        }

        public function sendMail()
        {
            //db conn
            $conn = Db::getConnection();
            //insert query
            $statement = $conn->prepare("select email from users where id= :id");
            $userId2 = $this->getUserId2();
            $statement->bindParam(":id", $userId2);

            $statement->execute();
            $result = $statement->fetch(\PDO::FETCH_ASSOC);

            $mailingAdress = $result['email'];
            sendMail($mailingAdress);
        }

        public function sendActivationMail()
        {
            //db conn
            $conn = Db::getConnection();
            //insert query
            $statement = $conn->prepare("select activationToken from users where email= :email");
            $email = $this->getEmail();
            $statement->bindParam(":email", $email);

            $statement->execute();
            $result = $statement->fetch(\PDO::FETCH_ASSOC);

            $activationToken = $result['activationToken'];
            sendActivationMail($email, $activationToken);
        }

        public function activateAccount()
        {
            //db conn
            $conn = Db::getConnection();
            //insert query
            $statement = $conn->prepare("update users set active = 1 where activationtoken= :activationToken");
            $activationToken = $this->getActivationToken();
            $statement->bindParam(":activationToken", $activationToken);

            $statement->execute();
        }
    }
