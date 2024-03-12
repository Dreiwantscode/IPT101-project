<?php 

session_start();

function signup($data)
{
    $errors = array();
 
    // Validate 
    if(!preg_match('/^[a-zA-Z]+$/', $data['username'])){
        $errors[] = "Please enter a valid username";
    }

    if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
        $errors[] = "Please enter a valid email";
    }

    if(strlen(trim($data['password'])) < 4){
        $errors[] = "Password must be at least 4 characters long";
    }

    if($data['password'] != $data['password2']){
        $errors[] = "Passwords must match";
    }

    // Additional validations for first name, last name, and middle name
    if(empty($data['firstname'])){
        $errors[] = "First name is required";
    }

    if(empty($data['lastname'])){
        $errors[] = "Last name is required";
    }

    // Check if email already exists
    $check = database_run("SELECT * FROM users WHERE email = :email LIMIT 1", ['email' => $data['email']]);
    if(is_array($check)){
        $errors[] = "That email already exists";
    }

    // Terms and Conditions validation
    if(empty($data['terms'])){
        $errors[] = "You must agree to the terms and conditions";
    }

    // If no errors, save the user
    if(count($errors) == 0){

        $arr['username'] = $data['username'];
        $arr['email'] = $data['email'];
        $arr['password'] = hash('sha256', $data['password']);
        $arr['firstname'] = $data['firstname'];
        $arr['lastname'] = $data['lastname'];
        $arr['middlename'] = $data['middlename'];
        $arr['date'] = date("Y-m-d H:i:s");

        $query = "INSERT INTO users (username, email, password, firstname, lastname, middlename, date) VALUES 
        (:username, :email, :password, :firstname, :lastname, :middlename, :date)";

        database_run($query, $arr);
    }
    return $errors;
}

function login($data)
{
    $errors = array();
 
    //validate 
    if(!filter_var($data['email'],FILTER_VALIDATE_EMAIL)){
        $errors[] = "Please enter a valid email";
    }

    if(strlen(trim($data['password'])) < 4){
        $errors[] = "Password must be at least 4 characters long";
    }
 
    //check
    if(count($errors) == 0){

        $arr['email'] = $data['email'];
        $password = hash('sha256', $data['password']);

        $query = "SELECT * FROM users WHERE email = :email LIMIT 1";

        $row = database_run($query, $arr);

        if(is_array($row)){
            $row = $row[0];

            if($password === $row->password){
                
                $_SESSION['USER'] = $row;
                $_SESSION['LOGGED_IN'] = true;
            }else{
                $errors[] = "Wrong email or password";
            }

        }else{
            $errors[] = "Wrong email or password";
        }
    }
    return $errors;
}

function database_run($query,$vars = array())
{
    $string = "mysql:host=localhost;dbname=ipt101";
    $con = new PDO($string,'root','');

    if(!$con){
        return false;
    }

    $stm = $con->prepare($query);
    $check = $stm->execute($vars);

    if($check){
        
        $data = $stm->fetchAll(PDO::FETCH_OBJ);
        
        if(count($data) > 0){
            return $data;
        }
    }

    return false;
}

function check_login($redirect = true){

    if(isset($_SESSION['USER']) && isset($_SESSION['LOGGED_IN'])){

        return true;
    }

    if($redirect){
        header("Location: login.php");
        die;
    }else{
        return false;
    }
    
}

function check_verified(){

    $id = $_SESSION['USER']->id;
    $query = "SELECT * FROM users WHERE id = '$id' LIMIT 1";
    $row = database_run($query);

    if(is_array($row)){
        $row = $row[0];

        if($row->email == $row->email_verified){

            return true;
        }
    }
 
    return false;
    
}

?>
