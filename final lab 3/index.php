<?php
session_start();
include "db_conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if (isset($_POST['uname']) && isset($_POST['password'])) {
        $username = validate($_POST['uname']);
        $password = validate($_POST['password']);

        if (empty($username)) {
            header("Location: login.php?error=Username is required");
            exit();
        } elseif (empty($password)) {
            header("Location: login.php?error=Password is required");
            exit();
        } else {
            $stmt = $conn->prepare("SELECT * FROM user WHERE username=?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                if (password_verify($password, $row['password'])) {
                    session_regenerate_id();
                    $_SESSION['user_name'] = $row['username'];
                    $_SESSION['last_name'] = $row['Lastname'];
                    $_SESSION['first_name'] = $row['First_name'];
                    $_SESSION['Middle_name'] = $row['Middle_name'];
                    $_SESSION['user_id'] = $row['user_id'];
                    header("Location: home.php");
                    exit();
                } else {
                    header("Location: login.php?error=Incorrect username or password");
                    exit();
                }
            } else {
                header("Location: login.php?error=Incorrect username or password");
                exit();
            }
        }
    } elseif (isset($_POST['email']) && isset($_POST['request'])) {
        $email = validate($_POST['email']);
        $request = validate($_POST['request']);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: login.php?error=Invalid email format");
            exit();
        }

        if ($request === "password") {
            // Logic for forgot password
            // Example: Send password reset link to the user's email
            // $token = generateUniqueToken(); // Your function to generate a unique token
            // saveTokenInDatabase($email, $token); // Your function to save the token in a database
            // sendResetEmail($email, $token); // Your function to send the reset email

            // Provide feedback to the user
            header("Location: password_reset_confirmation.php");
            exit();
        } elseif ($request === "username") {
            // Logic for forgot username
            // Example: Retrieve username associated with the email address
            // $username = getUsernameFromDatabase($email); // Your function to retrieve the username from a database

            // Provide feedback to the user
            header("Location: username_retrieval_confirmation.php");
            exit();
        }
    } else {
        header("Location: loginform.php");
        exit();
    }
} else {
    header("Location: loginform.php");
    exit();
}
?>
