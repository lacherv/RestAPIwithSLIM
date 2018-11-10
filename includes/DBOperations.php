<?php

    class DbOperations
    {
        private $con;

        public function __construct()
        {
            require_once dirname(__FILE__) . '/DbConnect.php';

            $db = new DbConnect;
            $this->con = $db->connect();
        }

        public function createUser($email, $password, $name, $school)
        {
            if($this->isEmailExist($email))
            {
                $stmt = $this->con->prepare("INSERT INTO users (email, password, name, school) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $email, $password, $name, $school);
                if($stmt->execute()) 
                {

                }
                else
                {

                }
                return $stmt;
            }
        }

        private function isEmailExist($email)
        {
            $stmt = $this->con->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            return $stmt->num_rows > 0;
        }
    }