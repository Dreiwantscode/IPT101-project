<?php 

session_start();

function signup($data)
{
    $errors = array();
 
    // Validate username
    if(empty($data['username']) || !preg_match('/^[a-zA-Z]+$/', $data['username'])){
        $errors[] = "Please enter a valid username";
    }

    // Validate email
    if(empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
        $errors[] = "Please enter a valid email";
    }

    // Validate password length
    if(strlen(trim($data['password'])) < 4){
        $errors[] = "Password must be at least 4 characters long";
    }

    // Check if passwords match
    if($data['password'] !== $data['password2']){
        $errors[] = "Passwords must match";
    }

    // Check if terms and conditions are agreed
    if(empty($data['terms']) || $data['terms'] !== 'on'){
        $errors[] = "Please agree to the Terms and Conditions";
    }

    // Check if privacy policy is agreed
    if(empty($data['privacy_policy']) || $data['privacy_policy'] !== 'on'){
        $errors[] = "Please agree to the Privacy Policy";
    }

    // Check if email already exists
    $check = database_run("SELECT * FROM users WHERE email = :email LIMIT 1", ['email' => $data['email']]);
    if(is_array($check)){
        $errors[] = "That email already exists";
    }

    // Save user if no errors
    if(count($errors) == 0){

        $arr['username'] = $data['username'];
        $arr['email'] = $data['email'];
        $arr['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $arr['date'] = date("Y-m-d H:i:s");

        $query = "INSERT INTO users (username, email, password, date) VALUES (:username, :email, :password, :date)";

        database_run($query, $arr);
    }
    return $errors;
}

function login($data)
{
    $errors = array();
 
    // Validate email
    if(empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
        $errors[] = "Please enter a valid email";
    }

    // Validate password length
    if(strlen(trim($data['password'])) < 4){
        $errors[] = "Password must be at least 4 characters long";
    }
 
    // Check credentials
    if(count($errors) == 0){

        $arr['email'] = $data['email'];

        $query = "SELECT * FROM users WHERE email = :email LIMIT 1";

        $row = database_run($query, $arr);

        if(is_array($row)){
            $row = $row[0];

            // Verify password
            if(password_verify($data['password'], $row->password)){
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

function database_run($query, $vars = array())
{
    $string = "mysql:host=localhost;dbname=verify_db";
    $username = "your_username"; // Replace with your database username
    $password = "your_password"; // Replace with your database password

    try {
        $con = new PDO($string, $username, $password);

        $stm = $con->prepare($query);
        $check = $stm->execute($vars);

        if($check){
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }

        return false;
    } catch(PDOException $e) {
        // Handle database connection errors
        die("Connection failed: " . $e->getMessage());
    }
}

function check_login($redirect = true)
{
    if(isset($_SESSION['USER']) && isset($_SESSION['LOGGED_IN'])){
        return true;
    }

    if($redirect){
        header("Location: login.php");
        exit;
    }else{
        return false;
    }
}

function check_verified()
{
    if(isset($_SESSION['USER']) && isset($_SESSION['LOGGED_IN'])){
        $id = $_SESSION['USER']->id;
        $query = "SELECT * FROM users WHERE id = :id LIMIT 1";
        $row = database_run($query, ['id' => $id]);

        if(is_array($row)){
            $row = $row[0];

            if($row->email == $row->email_verified){
                return true;
            }
        }
    }
 
    return false;
}

?>
