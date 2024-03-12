<?php  

require "functions.php";

$errors = array();

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    // Check if terms and conditions are agreed
    if(!isset($_POST['terms'])){
        $errors[] = "Please agree to the terms and conditions";
    } else {
        $errors = signup($_POST);
    }

    if(count($errors) == 0)
    {
        header("Location: login.php");
        die;
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Signup</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Adjust the width of the form elements */
        .form-control {
            width: 400px; /* Adjust as needed */
        }
        /* Center the form horizontally */
        .center {
            margin: auto;
            width: fit-content;
            margin-top: 200px; /* Adjust margin top as needed */
        }
    </style>
</head>
<body>
    <div class="center">
        <h1 class="mt-5">Signup</h1>

        <div>
            <?php if(count($errors) > 0):?>
                <div class="alert alert-danger">
                    <?php foreach ($errors as $error):?>
                        <?= $error?> <br>    
                    <?php endforeach;?>
                </div>
            <?php endif;?>
        </div>

        <form method="post">
            <div class="form-group">
                <label for="firstname">First Name</label>
                <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First Name">
            </div>
            <div class="form-group">
                <label for="lastname">Last Name</label>
                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last Name">
            </div>
            <div class="form-group">
                <label for="middlename">Middle Name</label>
                <input type="text" class="form-control" id="middlename" name="middlename" placeholder="Middle Name">
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Username">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            </div>
            <div class="form-group">
                <label for="password2">Retype Password</label>
                <input type="password" class="form-control" id="password2" name="password2" placeholder="Retype Password">
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="terms" name="terms">
                <label class="form-check-label" for="terms">I agree to the <a href="#">terms and conditions and private policy</a></label>
            </div>
            <button type="submit" class="btn btn-primary">Signup</button>
        </form>
        
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>

    <!-- Bootstrap JS (optional, if you need JavaScript features) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
