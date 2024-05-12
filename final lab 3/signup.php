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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom CSS styles */
        .container-box {
            background-color: #CFB284; /* Cream background */
            color: #000000; /* Black text color */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.08);
            margin-top: 200px; /* Adjust margin top as needed */
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }
        .form-group {
            margin-bottom: 20px;
        }
        body {
            background-color: #f8f9fa; /* Set background color */
        }
        .btn-primary {
            background-color: #007bff; /* Set button background color */
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3; /* Set button background color on hover */
            border-color: #0056b3;
        }
        .form-check-label a {
            color: #007bff; /* Set link color */
            text-decoration: none; /* Remove underline */
        }
        .form-check-label a:hover {
            text-decoration: underline; /* Add underline on hover */
        }
    </style>
</head>
<body>
    <div class="container-box">
        <h1 class="mt-5">Signup</h1>

        <?php if(count($errors) > 0):?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error):?>
                    <?= $error?> <br>    
                <?php endforeach;?>
            </div>
        <?php endif;?>

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
                <label class="form-check-label" for="terms">I agree to the <a href="#" class="text-primary">terms and conditions and private policy</a></label>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Signup</button>
        </form>
        
        <p class="mt-3">Already have an account? <a href="login.php" class="text-primary">Login here</a></p>
    </div>

    <!-- Bootstrap JS (optional, if you need JavaScript features) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
