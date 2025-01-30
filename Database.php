<?php

class Database {
    private $username;
    private $password;
    private $host;
    private $database;

    public function __construct()
    {
        $this->username = 'user';
        $this->password = 'password';
        $this->host = 'postgres';
        $this->database = 'teamit';
    }

    public function connect()
    {
        try {
            $conn = new PDO("pgsql:host={$this->host};dbname={$this->database}", $this->username, $this->password);

            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        }
        catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
}