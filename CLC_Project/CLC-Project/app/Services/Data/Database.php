<?php

/*
 * CLC-Project-256
 * Version 0.7
 * Cameron Deao, Zachary Gardner, Mercedes Thigpen
 * 5/30/2021
 * The Database class works as a method of connecting to the database.
 */
namespace App\Services\Data;

class Database
{
    //Established variables for connection.
    private $server;
    private $username;
    private $password;
    private $database;
    
    //Constructor will initialize all the variables to the appropriate values.
    public function __construct()
    {
        //Credentials to connect to the database.
        $this->server = "localhost";
        $this->username = "root";
        $this->password = "root";
        $this->database = "256-clc";
    }
    
    //Get connection will connect to the database and return the connection.
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

