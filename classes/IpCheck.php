<?php
    include_once(__DIR__ . "./Db.php");

    class IpCheck
    {
        private $ip;
        private $t;
        private $diff;

        public function getIp()
        {
            return $this->ip;
        }

        public function setIp($ip)
        {
            $this->ip = $ip;

            return $this;
        }

        public function getT()
        {
            return $this->t;
        }

        public function setT($t)
        {
            $this->t = $t;

            return $this;
        }

        public function getDiff()
        {
            return $this->diff;
        }

        public function setDiff($diff)
        {
            $this->diff = $diff;

            return $this;
        }

        public function failedLogin()
        {
            //db conn
            $conn = Db::getConnection();
            //insert query
            $statement = $conn->prepare("insert into loginLimit (ipAddress, timeDiff) values (:ip, :t)");
            $ip = $this->getIp();
            $t = $this->getT();
            $statement->bindParam(":ip", $ip);
            $statement->bindParam(":t", $t);
            $statement->execute();
            $this->deleteFailedLogin();
        }

        public function deleteFailedLogin()
        {
            //db conn
            $conn = Db::getConnection();
            //insert query
            $statement = $conn->prepare("delete from loginLimit where ipAddress like :ip and timeDiff < :diff");
            $ip = $this->getIp();
            $diff = $this->getDiff();
            $statement->bindParam(":ip", $ip);
            $statement->bindParam(":diff", $diff);

            $statement->execute();
        }

        public function deleteAllFailedLogin()
        {
            //db conn
            $conn = Db::getConnection();
            //insert query
            $statement = $conn->prepare("delete from loginLimit where ipAddress like :ip");
            $ip = $this->getIp();
            $statement->bindParam(":ip", $ip);

            $statement->execute();
        }

        public function failedLoginAmount()
        {
            //db conn
            $conn = Db::getConnection();
            //insert query
            $statement = $conn->prepare("select COUNT(*) from loginLimit where ipAddress like :ip and timeDiff > :diff");
            $ip = $this->getIp();
            $diff = $this->getDiff();
            $statement->bindParam(":ip", $ip);
            $statement->bindParam(":diff", $diff);

            $statement->execute();
            $count = $statement->fetch(PDO::FETCH_ASSOC);
            $this->deleteFailedLogin();
            return $count;
        }
    }
