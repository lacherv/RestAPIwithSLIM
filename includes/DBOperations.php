<?php

    class DbOperations
    {
        // The database connection variable
        private $con;

        //Inside the constructor, we are getting the connection link
        public function __construct()
        {
            require_once dirname(__FILE__) . '/DbConnect.php';
            $db = new DbConnect;
            $this->con = $db->connect();
        }

       /*
          The Creation Operation
          The method will insert a new user in our database
       */
        public function createUser($email, $password, $name, $school)
        {
            // Checking if the email already exists
            if(!$this->isEmailExist($email))
            {
                $stmt = $this->con->prepare("INSERT INTO users (email, password, name, school) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $email, $password, $name, $school);
                if($stmt->execute()) 
                {
                    return USER_CREATED;
                } else {
                    return USER_FAILURE;
                }
            }
            return USER_EXISTS;
        }

        
        public function userLogin($email, $password)
        {
            if($this->isEmailExist($email))
            {
                $hashed_password = $this->getUsersPasswordByEmail($email); 
                if(password_verify($password, $hashed_password))
                {
                    return USER_AUTHENTICATED;
                } else {
                    return USER_PASSWORD_DO_NOT_MATCH; 
                }
            } else {
                return USER_NOT_FOUND;    
            }
        }

        /*  
            The method is returning the password of a given user
            to verify the given password is correct or not
        */
        public function getUsersPasswordByEmail($email){
            $stmt = $this->con->prepare("SELECT password FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute(); 
            $stmt->bind_result($password);
            $stmt->fetch(); 
            return $password; 
        }

        public function getAllUsers()
        {
            $stmt = $this->con->prepare("SELECT id, email, name, school FROM users");
            $stmt->execute();
            $stmt->bind_result($id, $email, $name, $school);
            $users = array();
            while($stmt->fetch())
            {
                $user = array();
                $user['id'] = $id; 
                $user['email']=$email; 
                $user['name'] = $name; 
                $user['school'] = $school; 
                array_push($users, $user);
            }
            return $users;
        }

        /*
            The Read Operation
            This function reads a specified user from database
        */
        public function getUserByEmail($email){
            $stmt = $this->con->prepare("SELECT id, email, name, school FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute(); 
            $stmt->bind_result($id, $email, $name, $school);
            $stmt->fetch(); 
            $user = array(); 
            $user['id'] = $id; 
            $user['email']=$email; 
            $user['name'] = $name; 
            $user['school'] = $school; 
            return $user; 
        }
        
        /*
            The Read Operation
            The function is checking if the user exist in the database or not
        */
        private function isEmailExist($email)
        {
            $stmt = $this->con->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();
            return $stmt->num_rows > 0;
        }
    }