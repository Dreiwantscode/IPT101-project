function signup($data)
{
    $errors = array();
 
    // Validate first name
    if(empty($data['firstname'])){
        $errors[] = "Please enter your first name";
    }

    // Validate last name
    if(empty($data['lastname'])){
        $errors[] = "Please enter your last name";
    }

    // Validate middle name (optional)
    if(!empty($data['middlename']) && !preg_match('/^[a-zA-Z]+$/', $data['middlename'])){
        $errors[] = "Please enter a valid middle name";
    }

    // Validate username
    if(!preg_match('/^[a-zA-Z]+$/', $data['username'])){
        $errors[] = "Please enter a valid username";
    }

    // Validate email
    if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
        $errors[] = "Please enter a valid email";
    }

    // Validate password
    if(strlen(trim($data['password'])) < 4){
        $errors[] = "Password must be at least 4 characters long";
    }

    // Confirm password
    if($data['password'] != $data['password2']){
        $errors[] = "Passwords must match";
    }

    // Check terms and conditions checkbox
    if(!isset($data['terms']) || $data['terms'] !== 'on'){
        $errors[] = "Please agree to the Terms and Conditions";
    }

    // Check privacy policy checkbox
    if(!isset($data['privacy_policy']) || $data['privacy_policy'] !== 'on'){
        $errors[] = "Please agree to the Privacy Policy";
    }

    // Check if email already exists
    $check = database_run("SELECT * FROM users WHERE email = :email LIMIT 1", ['email' => $data['email']]);
    if(is_array($check)){
        $errors[] = "That email already exists";
    }

    // Save data if no errors
    if(count($errors) == 0){
        $arr['username'] = $data['username'];
        $arr['email'] = $data['email'];
        $arr['password'] = hash('sha256', $data['password']);
        $arr['date'] = date("Y-m-d H:i:s");

        $query = "INSERT INTO users (username, email, password, date) VALUES (:username, :email, :password, :date)";

        database_run($query, $arr);
    }

    return $errors;
}
