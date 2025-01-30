<?php

require_once __DIR__. '/../../database.php';

class Repository {

    protected $db;

    public function __construct(){
        $this->db = new Database();
    }
}