<?php
include_once(__DIR__ . "/Db.php");

class Post
{
    private $id;
    private $userId;
    private $post;
    private $pin;


    public function savePost()
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("insert into posts (userId, post) values (:userId, :post)");
        $userId = $this->getUserId();
        $post =  $this->getPost();
        $statement->bindValue(":userId", $userId);
        $statement->bindValue(":post", $post);

        $result = $statement->execute();
        return $result;
    }
    
    public function printPost()
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT * from posts ORDER BY date DESC");
        $result = $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function savePin()
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("update posts set pin = 1 where id= {$_GET['id']}");
        $id = $this->getId();
        $statement->bindParam(":id", $id);
        //return result
        $result = $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function showPins()
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("select * from posts inner join users on posts.userId = users.id where pin= 1");
        $result = $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
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
     * Get the value of userId
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set the value of userId
     *
     * @return  self
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get the value of post
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Set the value of post
     *
     * @return  self
     */
    public function setPost($post)
    {
        if (empty($post)) {
            throw new Exception("Invulveld mag niet leeg zijn!");
        }
        $this->post = $post;

        return $this;
    }

    /**
     * Get the value of pin
     */
    public function getPin()
    {
        return $this->pin;
    }

    /**
     * Set the value of pin
     *
     * @return  self
     */
    public function setPin($pin)
    {
        $this->pin = $pin;

        return $this;
    }
}
