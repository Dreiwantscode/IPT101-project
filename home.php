<?php
session_start();
if(isset($_SESSION['user_id']) && isset($_SESSION['user_name'])){
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Welcome</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
  font-family: Arial, Helvetica, sans-serif;
  margin: 0;
  padding: 0;
  background-color: #f1f1f1;
}

.container {
  max-width: 800px;
  margin: 50px auto;
  padding: 20px;
  background: ##008000;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0,0,0,0.1);
  text-align: center;
}

.header {
  background: #1abc9c;
  color: white;
  padding: 20px;
  border-radius: 5px 5px 0 0;
}

.logout {
  display: inline-block;
  margin-top: 20px;
  padding: 10px 20px;
  background-color: #343;
  color: white;
  text-decoration: none;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.logout:hover {
  background-color: #333;
}
</style>
</head>
<body>

<div class="container">
  <div class="header">
    <h1>Welcome</h1>
  </div>
  
  <div class="user-info">
    <h2>Hello, <?php echo $_SESSION['last_name'] ?></h2>
    <h3>Your full name is: <?php echo $_SESSION['first_name']," ",$_SESSION['Middle_name'],". ", $_SESSION['last_name']?></h3>
    <h4>User ID : <?php echo $_SESSION['user_id'] ?></h4>
    <a href="logout.php" class="logout">Logout</a>
  </div>
</div>

</body>
</html>
<?php 
}else{
    header("Location:home.php");
    exit();
}
?>
