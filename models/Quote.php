<?php

class Quote {
    private $conn;
    private $table = 'quotes';

    public $id;
    public $quote;
    public $authorId;
    public $categoryId;

    // Constructor
    public function __construct($db) {
        $this->conn = $db;
    }

    // method to get posts
    public function read() {
        // create query
        $query = 'SELECT 
            c.category AS category, 
            q.id, 
            q.categoryId, 
            a.author AS author, 
            q.authorId,
            q.quote
            FROM 
                ' . $this->table . ' q
            LEFT JOIN 
                categories c ON q.categoryId = c.id
            LEFT JOIN 
                authors a ON q.authorId = a.id
            ORDER BY 
                q.id';
                
            // prepared statement
            $stmt = $this->conn->prepare($query);

            try {
                // execute query
                $stmt->execute();
                return $stmt;
            } catch(PDOException $e) {
                echo json_encode(
                    array('message' => $e->getmessage())
                );
            }
    }

    // get single quote from quote id
    public function read_single() {
        // create query
        $query = 'SELECT 
                c.category AS category, 
                q.id, 
                q.categoryId, 
                a.author AS author, 
                q.authorId,
                q.quote
                FROM 
                    ' . $this->table . ' q
                LEFT JOIN 
                    categories c ON q.categoryId = c.id
                LEFT JOIN 
                    authors a ON q.authorId = a.id
                WHERE 
                q.id = ?
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
            $this->quote = $row['quote'];
            $this->author = $row['author'];
            $this->category = $row['category'];

            return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo json_encode(
                array('message' => $e->getmessage())
            );
        }
    }

    // get quotes from authorId
    public function read_author() {
        // create query
        $query = 'SELECT 
                c.category AS category, 
                q.id, 
                q.categoryId, 
                a.author AS author, 
                q.authorId,
                q.quote
                FROM 
                    ' . $this->table . ' q
                LEFT JOIN 
                    categories c ON q.categoryId = c.id
                LEFT JOIN 
                    authors a ON q.authorId = a.id
                WHERE 
                q.authorId = ?';

        // prepare statement
        $stmt = $this->conn->prepare($query);
       
        // bind ID
        $stmt->bindParam(1, $this->authorId);
        
        try{
            // execute query
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            echo json_encode(
                array('message' => $e->getmessage())
            );
        }
    }
    

// get quotes from cagtegoryId
public function read_category() {
    // create query
    $query = 'SELECT 
            c.category AS category, 
            q.id, 
            q.categoryId, 
            a.author AS author, 
            q.authorId,
            q.quote
            FROM 
                ' . $this->table . ' q
            LEFT JOIN 
                categories c ON q.categoryId = c.id
            LEFT JOIN 
                authors a ON q.authorId = a.id
            WHERE 
            q.categoryId = ?';

    // prepare statement
    $stmt = $this->conn->prepare($query);

    // bind ID
    $stmt->bindParam(1, $this->categoryId);
    
    try{
        // execute query
        $stmt->execute();
        return $stmt;
    } catch (PDOException $e) {
        echo json_encode(
            array('message' => $e->getmessage())
        );
    }
}

// get quotes from combination of authorId and cagtegoryId
public function read_authorAndCategory() {
    // create query
    $query = 'SELECT 
            c.category AS category, 
            q.id, 
            q.categoryId, 
            a.author AS author, 
            q.authorId,
            q.quote
            FROM 
                ' . $this->table . ' q
            LEFT JOIN 
                categories c ON q.categoryId = c.id
            LEFT JOIN 
                authors a ON q.authorId = a.id
            WHERE 
            q.authorId = ? AND q.categoryId = ?';

    // prepare statement
    $stmt = $this->conn->prepare($query);

    // bind ID
    $stmt->bindParam(1, $this->authorId);
    $stmt->bindParam(2, $this->categoryId);
    
    try{
        // execute query
        $stmt->execute();
        return $stmt;
    } catch (PDOException $e) {
        echo json_encode(
            array('message' => $e->getmessage())
        );
    }
}
    // Create quote
    public function create() {
        // create query
        $query = 'INSERT INTO ' . $this->table . '
        SET
            quote = :quote,
            authorId = :authorId,
            categoryId = :categoryId';

        // prepare statement
        $stmt = $this->conn->prepare($query);

        // clean data
        $this->quote = htmlspecialchars(strip_tags($this->quote));
        // $this->author = htmlspecialchars(strip_tags($this->author));
        $this->authorId = htmlspecialchars(strip_tags($this->authorId));
        $this->categoryId = htmlspecialchars(strip_tags($this->categoryId));

        // bind data
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':authorId', $this->authorId);
        $stmt->bindParam(':categoryId', $this->categoryId);

        // execute
        try{
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

    // Update quote
    public function update() {
        $query = 'UPDATE ' . $this->table . '
        SET
            quote = :quote,
            authorId = :authorId,
            categoryId = :categoryId
            WHERE
                id = :id';

        // prepare statement
        $stmt = $this->conn->prepare($query);

        // clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->quote = htmlspecialchars(strip_tags($this->quote));
        $this->authorId = htmlspecialchars(strip_tags($this->authorId));
        $this->categoryId = htmlspecialchars(strip_tags($this->categoryId));
       
        // bind data
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':authorId', $this->authorId);
        $stmt->bindParam(':categoryId', $this->categoryId);
       
        try {
            // execute
            $stmt->execute();
        } catch(PDOException $e) {
            $message = json_encode(
                array('message' => $e->getmessage())
            );

            return $message;
        }
    
        if($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    // delete 
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
    }
}
