<?php
session_start();
include "db_conn.php";

if (isset($_POST['uname']) && isset($_POST['password'])) {
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $username = validate($_POST['uname']);
    $password = validate($_POST['password']);

    if (empty($username)) {
        header("Location: Loginform.php?error=Username is required");
        exit();
    } elseif (empty($password)) {
        header("Location: Loginform.php?error=Password is required");
        exit();
    } else {
        $sql = "SELECT * FROM user WHERE username='$username' AND password='$password'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if ($row['username'] === $username && $row['password'] === $password) {
                echo "Logged in!";
                $_SESSION['user_name'] = $row['username'];
                $_SESSION['last_name'] = $row['Lastname'];
                $_SESSION['first_name'] = $row['First_name'];
                $_SESSION['Middle_name'] = $row['Middle_name'];
                $_SESSION['user_id'] = $row['user_id'];
                header("Location: home.php");
                exit();
            } else {
                header("Location: Loginform.php?error=Incorrect username or password");
                exit();
            }
        } else {
            header("Location: Loginform.php?error=Incorrect username or password");
            exit();
        }
    }  
} else {
    header("Location: Loginform.php");
    exit();
}
?>
