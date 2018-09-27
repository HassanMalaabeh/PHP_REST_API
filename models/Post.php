<?php


class Post
{
    //DB Stuff
    private $conn;
    private $table = 'posts';

    //Post Properties
    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $body;
    public $author;
    public $createdAt;

    //Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //Get Posts
    public function read(){
        //Query
        $sql = 'SELECT c.name AS caterory_name, p.id, p.category_id, p.title, p.body, p.author, 
        p.created_at  FROM ' . $this->table . ' p  LEFT JOIN categories c ON 
        p.category_id = c.id  ORDER BY p.created_at DESC;';

        //Prepare Statement
        $stmt = $this->conn->prepare($sql);

        //Execute Query
        $stmt->execute();

        return $stmt;
    }

    //Get Single Post
    public function readSingle(){
        //Query
        $sql = 'SELECT c.name AS caterory_name, p.id, p.category_id, p.title, p.body, p.author, 
        p.created_at  FROM ' . $this->table . ' p  LEFT JOIN categories c ON 
        p.category_id = c.id  WHERE p.id = ? LIMIT 0,1;';

        //Prepare Statement
        $stmt = $this->conn->prepare($sql);

        //Bind ID
        $stmt->bindParam(1, $this->id);

        //Execute Query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this ->title = $row['title'];
        $this ->body = $row['body'];
        $this ->author = $row['author'];
        $this ->category_id = $row['category_id'];
        $this ->category_name = $row['category_name'];

        return $stmt;
    }

    //Create Post
    public function create(){
        $sql = 'INSERT INTO ' . $this->table . ' (title, body, author, category_id) VALUES (?, ?, ?, ?) ;';

        //Prepare Statement
        $stmt = $this->conn->prepare($sql);

        //Clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        //Bind ID
        $stmt->bindParam(1, $this->title);
        $stmt->bindParam(2, $this->body);
        $stmt->bindParam(3, $this->author);
        $stmt->bindParam(4, $this->category_id);

        //Execute Query
        if($stmt->execute()){
            return true;
        }

        //Print error if something goes wrong
        printf('Error: %s \n.', $stmt->error);

        return false;
    }

    //Update Post
    public function update(){
        $sql = 'UPDATE ' . $this->table . ' SET title = ?, body = ?, author = ?, category_id = ? WHERE id = ?;';

        //Prepare Statement
        $stmt = $this->conn->prepare($sql);

        //Clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        //Bind ID
        $stmt->bindParam(1, $this->title);
        $stmt->bindParam(2, $this->body);
        $stmt->bindParam(3, $this->author);
        $stmt->bindParam(4, $this->category_id);
        $stmt->bindParam(5, $this->id);

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

        //Clean dataa
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