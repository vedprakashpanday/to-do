<?php 
@include "config.php";
session_start();
$errorMessages = "";
if(isset($_POST['submit'])){
    $email=$_POST['email'];
    $password=md5($_POST['password']);

    $sql="SELECT * FROM signup WHERE email='$email' AND password='$password'";
    $result=mysqli_query($conn,$sql);
     
     while($row =mysqli_fetch_assoc($result)){
        if($email != $row['email'] && $password != $row['password']){
            $errorMessages = "Email OR Password Mismatch!!";
        }
        else{
            $_SESSION['name']= $row['name'];
            $_SESSION['email']= $row['email'];
            header("location:home.php");
        }
     }
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    
<div class="main">
    <h1>Login Here</h1>
    <?php if($errorMessages):?>
    <div class="error">
    <p><?php echo "$errorMessages"; ?></p>
    </div>
    <?php endif;?>
    
    <form action="" method="post">
    <div class="email">
        <label for="Email">Email:</label>
        <input type="email" placeholder="Enter Your Email Here" name="email" required>
    </div>
    
    <div class="password">
        <label for="password">Password:</label>
        <input type="password" placeholder="Enter Your Password Here" name="password" required>
    </div>
    <div class="submit">
        
        <input type="submit" value="Login" name="submit" >
        Don't Have Registered Yet? <a href="signup.php">SignUp Here</a>
    </div>
    </form>
  </div>
</body>
</html>