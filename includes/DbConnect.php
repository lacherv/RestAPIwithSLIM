<?php

    class DbConnect 
    {
        // Variable to store database link
        private $con;

        // Class construstor
        function connect()
        {
            // Include the Constants.php file to get the database constants
            include_once dirname(__FILE__) . '/Constants.php';
            
            // Connecting to MySQL database
            $this->con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

            // Checking if any any error occurred while connecting
            if(mysqli_connect_errno())
            {
                echo "Failed to connect " . mysqli_connect_error();
                return null;
            }

            // Finally returning the connection link
            return $this->con;
        }
    }