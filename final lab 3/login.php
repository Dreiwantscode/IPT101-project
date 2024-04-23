<?php  
    require "functions.php";

    // Initialize errors array
    $errors = [];

    // Check if the form is submitted
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        // Call the login function to validate user credentials
        $errors = login($_POST);

        // If there are no errors, redirect to profile.php
        if(count($errors) == 0)
        {
            // Start the session
            session_start();

            // Set session variables or any other required operations upon successful login
            $_SESSION['user_email'] = $_POST['email']; // Example: Set user email in session

            // Redirect to profile.php
            header("Location: profile.php");
            exit; // Terminate the script to ensure the redirect takes effect
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Add custom styles here if needed */
        .container {
            max-width: 400px;
            margin: auto;
            margin-top: 50px;
            background: linear-gradient(to bottom, #87CEEB, #FFFFFF); /* Gradient sky blue to white */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        body {
            background-color: #f8f9fa; /* Set background color */
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
        }
        .btn-primary {
            background-color: #007bff; /* Set button background color */
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3; /* Set button background color on hover */
            border-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Login</h1>

        <?php if(count($errors) > 0):?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error):?>
                    <?= $error?> <br>    
                <?php endforeach;?>
            </div>
        <?php endif;?>

        <form method="post">
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>

        <p class="mt-3">Don't have an account? <a href="signup.php">Sign up here</a></p>
        <p>Forgot your Password? <a href="forgot_password.php">Forgot Password?</a></p>
    </div>
</body>
</html>

                    
