<?php
    class Database {

        private $url;
        private $conn;

        // Constructor
        public function __construct() {
            $this->conn = null;
            $this->url = getenv('JAWSDB_URL');
        }
    
        // connect to db
        public function connect() {

            $dbparts = parse_url($this->url);
            $host = $dbparts['host'];
            $username = $dbparts['user'];
            $password = $dbparts['pass'];
            $db_name = ltrim($dbparts['path'],'/');  

            try {
                $this->conn = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                }
            catch(PDOException $e)
                {
                echo "Connection failed: " . $e->getMessage();
                }

            return $this->conn;
        }
    }

