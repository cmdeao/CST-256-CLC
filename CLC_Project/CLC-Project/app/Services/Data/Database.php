<?php
namespace App\Services\Data;

class Database
{
    private $server;
    private $username;
    private $password;
    private $database;
    
    public function __construct()
    {
        //CAMERON'S CREDENTIALS
        $this->server = "localhost";
        $this->username = "root";
        $this->password = "root";
        $this->database = "256-clc";
    }
    
    public function getConnection()
    {
        $database = mysqli_connect($this->server, $this->username, $this->password, $this->database);
        if($database === false)
        {
            die("ERROR: Connection failed: " . mysqli_connect_error());
        }
        return $database;
    }
}

