<?php
    require "functions.php";
    check_login();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

    <h1 class="text-center mt-5">Profile</h1>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php if(check_login(false)): ?>
                    <p class="text-center">Hi, <?= $_SESSION['USER']->username ?>;</p>

                    <?php if(!check_verified()): ?>
                        <div class="text-center">
                            <a href="verify.php" class="btn btn-primary">Verify Profile</a>
                        </div>
                    <?php endif; ?>

                    <!-- Logout Link -->
                    <div class="text-center mt-3">
                        <a href="logout.php" class="btn btn-danger">Logout</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
