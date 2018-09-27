<?php

class Category
{
    //DB Stuff
    private $conn;
    private $table = 'categories';

    //Category Properties
    public $id;
    public $name;
    public $createdAt;

    //Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //Get Categories
    public function read(){
        //Query
        $sql = 'SELECT `id`, `name`, `created_at` FROM ' . $this->table . ' ORDER BY `created_at` DESC;';

        //Prepare Statement
        $stmt = $this->conn->prepare($sql);

        //Execute Query
        $stmt->execute();

        return $stmt;
    }

    //Get Single Category
    public function readSingle(){
        //Query
        $sql = 'SELECT `id`, `name`, `created_at` FROM ' . $this->table . ' WHERE `id` = ? LIMIT 0,1;';

        //Prepare Statement
        $stmt = $this->conn->prepare($sql);

        //Bind ID
        $stmt->bindParam(1, $this->id);

        //Execute Query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this ->name = $row['name'];
        $this ->createdAt = $row['created_at'];

        return $stmt;
    }

    //Create Category
    public function create(){
        $sql = 'INSERT INTO ' . $this->table . ' (`name`) VALUES (?) ;';

        //Prepare Statement
        $stmt = $this->conn->prepare($sql);

        //Clean data
        $this->name = htmlspecialchars(strip_tags($this->name));


        //Bind ID
        $stmt->bindParam(1, $this->name);


        //Execute Query
        if($stmt->execute()){
            return true;
        }

        //Print error if something goes wrong
        printf('Error: %s \n.', $stmt->error);

        return false;
    }

    //Update Category
    public function update(){
        $sql = 'UPDATE ' . $this->table . ' SET name = ? WHERE id = ?;';

        //Prepare Statement
        $stmt = $this->conn->prepare($sql);

        //Clean data
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->id = htmlspecialchars(strip_tags($this->id));

        //Bind ID
        $stmt->bindParam(1, $this->name);
        $stmt->bindParam(2, $this->id);

        //Execute Query
        if($stmt->execute()){
            return true;
        }

        //Print error if something goes wrong
        printf('Error: %s \n.', $stmt->error);

        return false;
    }

    //Delete Post
    public function delete(){
        $sql = 'DELETE FROM ' . $this->table . ' WHERE id = ?;';

        //Prepare Statement
        $stmt = $this->conn->prepare($sql);

        //Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));

        //Bind ID
        $stmt->bindParam(1, $this->id);

        //Execute Query
        if($stmt->execute()){
            return true;
        }

        //Print error if something goes wrong
        printf('Error: %s \n.', $stmt->error);

        return false;
    }

}