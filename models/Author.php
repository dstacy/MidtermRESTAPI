<?php

class Author {
    private $conn;
    private $table = 'authors';

    public $id;
    public $author;

    // Constructor
    public function __construct($db) {
        $this->conn = $db;
    }
        
    // method to get authors
    public function read() {
        // create query
        $query = 'SELECT 
            id,
            author
            FROM ' . $this->table;
                
        // prepare statement
        $stmt = $this->conn->prepare($query);

        try {
            // execute query
            $stmt->execute();
            return $stmt;
        } catch(Exception $e) {
            echo json_encode(
                array('message' => $e->getmessage())
            );
        }
    }

    // get single author
    public function read_single() {
        // create query
        $query = 'SELECT 
        id,
        author
        FROM ' . $this->table . 
        ' WHERE 
            id = ?
            LIMIT 0,1';

        // prepare statement
        $stmt = $this->conn->prepare($query);

        // bind ID
        $stmt->bindParam(1, $this->id);

        try {
            // execute query
            $stmt->execute();
            // fetch array
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
            if($row) {
                // set properties
                $this->id = $row['id'];
                $this->author = $row['author'];
        
                return true;
            }
            else {
                return false;
            }
        } catch (Exception $e) {
            echo json_encode(
                array('message' => $e->getmessage())
            );
        }
    }

    // Create Author
    public function create() {
        // create query
        $query = 'INSERT INTO ' . $this->table . '
            SET author = :author';

        // prepare statement
        $stmt = $this->conn->prepare($query);

        // clean data
        $this->author = htmlspecialchars(strip_tags($this->author));

        // bind data
        $stmt->bindParam(':author', $this->author);

        // execute
        try{
            $stmt->execute();    
        } catch(Exception $e) {
            echo json_encode(
                array('message' => $e->getmessage())
            );
        }

        /*
        if($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
        */
    }

    // Update author
    public function update() {
        // create query
        $query = 'UPDATE ' . $this->table . '
        SET
            author = :author 
        WHERE
            id = :id';

        // prepare statement
        $stmt = $this->conn->prepare($query);

        // clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->author = htmlspecialchars(strip_tags($this->author));

        // bind data

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':author', $this->author);
        
        try {
            // execute
            $stmt->execute();
        } catch(Exception $e) {
            echo json_encode(
                array('message' => $e->getmessage())
            );
        }

        if($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    // delete author
    public function delete() {
         // create query
        $query = 'DELETE FROM ' . $this->table . '
            WHERE id = :id';

        // prepare statement
        $stmt = $this->conn->prepare($query);

        // clean data
        $this->id = htmlspecialchars(strip_tags($this->id));

        // bind data
        $stmt->bindParam(':id', $this->id);

        try {
            // execute
            $stmt->execute(); 

        } catch(Exception $e) {
            echo json_encode(
                array('message' => $e->getmessage())
            );
        }

        if($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
