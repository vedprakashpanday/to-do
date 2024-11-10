<?php 
@include 'config.php';

session_start();
$count=0;
$count1=0;
$errorMessages = [];
if(isset($_POST['submit']))
{

    $name=$_POST['name'];
    $email=$_POST['email'];
    $mobile=$_POST['mobile'];
    $password =md5($_POST['password']);

    if(strlen($name)<3 || !(preg_match("/^[a-zA-Z\s]+$/",$name)))
    {
  $errorMessages[] = "Invalid name. More than 2 letters, spaces, hyphens, and apostrophes are allowed.";
  $count++;
   }

   if(strlen($mobile)!=10){
    $errorMessages[] = "Invalid Mobile Number.only 10 digits are allowed.";
    $count++;
   }

   if(strlen($password)<6 || (preg_match('/^(?=.*[A-Z])(?=.*\W)(?=.*[a-zA-Z]{3,}).{5,}$/', $password))){
    $errorMessages[] = "Password must contain at least 3 letters, 1 special character, and 1 uppercase letter.";
    $count++;
}

if($count==0){
        $sql="SELECT * FROM signup WHERE email='$email'";
        $result = mysqli_query($conn,$sql);
        $row=mysqli_fetch_assoc($result);
        if($email==$row['email']){
            $errorMessages[] = "User Already Exists!!";
        }
    else{
    $sql = "INSERT INTO signup(name,email,mobile,password) VALUES('$name','$email','$mobile','$password')";
    $result = mysqli_query($conn,$sql);
    if($result){
        header("Location:login.php");
        exit();
    }
    else {
        echo "Error: " . mysqli_error($conn); // Print error if insert fails
    }
}
}

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>

  <div class="main">
  <h1>Let's Register</h1> 
  <?php if($errorMessages) :?>
  
    <div class="error">
        <?php foreach($errorMessages as $messages):?>
    <p>
        <?php 
        $count1++;
        echo "$count1"."."."$messages";
        ?>
    </p>
    <hr>
    <?php endforeach;?>
    </div>
  <?php  endif;?>
      
  <form action="" method="post">
    <div class="name">
        <label for="name">Name:</label>
        <input type="text" placeholder="Enter Your Name Here" name="name" required>
    </div>
    <div class="email">
        <label for="Email">Email:</label>
        <input type="email" placeholder="Enter Your Email Here" name="email" required>
    </div>
    <div class="mobile">
        <label for="mobile">Mobile-Number:</label>
        <input type="number" placeholder="Enter Your Mobile Number Here" name="mobile" required>
    </div>
    <div class="password">
        <label for="password">Password:</label>
        <input type="password" placeholder="Enter Your Password Here" name="password" required>
    </div>
    <div class="submit"> 
        <input type="submit" value="Register" name="submit" >
        Already Registered? <a href="login.php">Login Here</a>
    </div>
    </form>
   
  </div>
</body>
</html>