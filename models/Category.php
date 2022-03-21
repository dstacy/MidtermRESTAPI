<?php
    class Category {
        private $conn;
        private $table = 'categories';

        public $id;
        public $category;
        

        // Constructor
        public function __construct($db) {
            $this->conn = $db;
        }

        // method to get categories
        public function read() {
            // create query
            $query = 'SELECT 
                id,
                category
                FROM ' . $this->table;
                
            // prepared statement
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

    // get single category

    public function read_single() {
        $query = 'SELECT 
        id,
        category
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
            $this->category = $row['category'];
            return true;
        } else {
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
     
        $query = 'INSERT INTO ' . $this->table . '
            SET category = :category';

        // prepare statement
        $stmt = $this->conn->prepare($query);

        // clean data
        $this->category = htmlspecialchars(strip_tags($this->category));

        // bind data
        $stmt->bindParam(':category', $this->category);

        // execute
        try{
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

    // Update category
    public function update() {
        $query = 'UPDATE ' . $this->table . '
        SET
            category = :category 
        WHERE
            id = :id';

        // prepare statement
        $stmt = $this->conn->prepare($query);

        // clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->category = htmlspecialchars(strip_tags($this->category));

        // bind data

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':category', $this->category);
        
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

    // delete category

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

        } catch(PDOException $e) {
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
