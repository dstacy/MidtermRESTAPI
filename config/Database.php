<?php
    class Database {
        /* connection for Heroku deployment
        private $host = 'acw2033ndw0at1t7.cbetxkdyhwsb.us-east-1.rds.amazonaws.com';
        private $db_name = 'vkut027eqotv1gye';
        private $username = 'ohq3wp4ybf8y1sqf';
        private $conn;

        local connection for testing pre-deployment
        private $host = 'localhost';
        private $db_name = 'quotesdb';
        private $username = 'root';
        private $conn;
        */

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
               // $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db_name}", $this->username, $this->password); //getenv('JAWSDB_PASS'));
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

