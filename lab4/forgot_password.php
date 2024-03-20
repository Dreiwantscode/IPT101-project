<?php
// Include necessary files and initialize session if needed
require "functions.php";

// Initialize errors array
$errors = [];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Validate the email address
    $email = $_POST['email'];

    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    // If no errors, process the request
    if (empty($errors)) {
        // Add logic to handle forgot password functionality here
        // For example, you might generate a reset token, send it to the user's email, and update the database with the token
        // Once done, you can redirect the user to a confirmation page or display a success message

        // For demonstration purposes, we'll simply display a success message
        $successMessage = "Password reset instructions have been sent to your email address.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Forgot Password</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Add custom styles here if needed */
        .container {
            max-width: 400px;
            margin: auto;
            margin-top: 50px;
        }
        .form-group {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Forgot Password</h1>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <?= $error ?><br>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($successMessage)): ?>
            <div class="alert alert-success">
                <?= $successMessage ?>
            </div>
        <?php else: ?>
            <form method="post">
                <div class="form-group">
                    <input type="email" class="form-control" name="email" placeholder="Email">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        <?php endif; ?>

        <p class="mt-3">Remember your password? <a href="login.php">Log in here</a></p>
    </div>
</body>
</html>
