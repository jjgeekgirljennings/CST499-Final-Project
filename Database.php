<?php

class Database
{
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "course_enrollment";

    public function connect()
    {
        $connection = new mysqli(
            $this->host,
            $this->username,
            $this->password,
            $this->database
        );

        if ($connection->connect_error) {
            die("Database connection failed: " .
                $connection->connect_error);
        }

        $connection->set_charset("utf8mb4");

        return $connection;
    }
}
?>