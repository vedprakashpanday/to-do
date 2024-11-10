<?php 
@include 'config.php';
session_start();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
if(isset($_POST['submit'])){
    $text= $_POST['text'];
    $useremail = $_SESSION['email'];
   
   

 if(!empty($text)){
    $sql="INSERT INTO store(task,email) VALUES('$text','$useremail')";
    $result=mysqli_query($conn,$sql);
    header("Location: home.php");
    exit();
 }
 else{
    
    echo "<script>alert('You Must Write Something To ADD');</script>";
    echo "<script>window.location='home.php';</script>";
    exit();
 }

}
}




if (isset($_POST['submit1'])) {
    $id = $_POST['id'];
    $updatedText = $_POST['text'];

    if (!empty($id) && !empty($updatedText)) {
        $sql = "UPDATE store SET task='$updatedText' WHERE id='$id'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            header("Location: home.php"); // Redirect to home page after saving
            exit();
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }
}

if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    
    if (!empty($id) ) {
        $sql = " DELETE FROM store WHERE id='$id'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            header("Location: home.php"); // Redirect to home page after saving
            exit();
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomePage</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <div class="main">
        <header>
            <div class="left">
                <img src="./images/icon.png" alt="logo">
                <h4>To-DO</h4>
            </div>
            <div class="right">
                <p><?php echo $_SESSION['name']; ?></p>
                <a href="logout.php"><button name="logout" >Logout</button></a>
            </div>
        </header>
        <hr/>

        <div class="btm">
            <div class="write">
                <form action="" method="post">
                <input type="text" placeholder="Write Here..." name="text">
                <button name="submit">ADD</button>
                </form>
            </div>
           

          <div class="Content" style="gap:20px; width:85%; margin-top:7%; margin-left:15%; border:none;">
     
          <?php 
           $useremail = $_SESSION['email'];
       

             $sql="SELECT store.id,store.task,store.email
             FROM store 
             INNER JOIN signup ON store.email = signup.email
             WHERE store.email='$useremail'";
            



             $result=mysqli_query($conn,$sql);
            if(mysqli_num_rows($result)>0)
            {
                
                while($row=mysqli_fetch_assoc($result))
                {
                  
                    $checkedId =  "check".$row['id'];
                    $uncheckedId =  "uncheck".$row['id'];
                    $inputId = "input".$row['id'];
                  $updateId = $row['id'];




                echo '<div class="wrap1" style="display:flex;   width:100%; height:auto; gap:20px;">';
         echo "<div class='action1' style='display:flex; align-items:center; gap:10px; justify-content:center;'>";
           echo "<div id='$checkedId' onclick='change($row[id])' style='display:none;'> <img src='./images/checked.png' alt=''></div>";
            echo "<div id='$uncheckedId' onclick='change($row[id])' style='display:flex;'><img src='./images/unchecked.png' alt=''></div>";
        
            echo '<form  action="" method="post">';
        echo '<div class="Input1" >';
        echo "<input type='hidden'  name='id' value='" . $row['id'] . "'>"; // Hidden ID for identifying the row
                
       echo "<input type='text' id='$inputId'  name='text' value='".$row['task']."' readonly>";
               
        echo '</div>';
                        echo '</div>';
        echo "<div class='edit1'>";
                       
        echo "<button class='update1' id='$updateId' onclick='update(\"input" . $row['id'] . "\")' name='submit1'>";
        echo '<img src="./images/pencil.png" alt="edit">';
        echo '</button>';
        echo "<button type='submit' name='submit1' class='update1' id='save" . $row['id'] . "' style='display:none;'>Save</button>";
            
        echo '<button class="delete1" name="delete">';
        echo '<img src="./images/delete.png" alt="edit">';
        echo '</button>';
        echo '</form>';
         echo '</div>';
        echo "</div>";

        }
    }
    else{
        echo "No To-Do records found.";
    }
         
 ?>
          
           </div>
          
        </div>
    </div>

    <script>
        function change(id){
                 const checkedElement = document.getElementById("check"+id);
                    const uncheckedElement = document.getElementById( "uncheck"+id);
                    const inputId=document.getElementById( "input"+id);
                    

                    
     if (checkedElement.style.display === "none") {
        checkedElement.style.display = "flex";
        uncheckedElement.style.display = "none";
        inputId.classList.add("completed");
    } else {
        checkedElement.style.display = "none";
        uncheckedElement.style.display = "flex";
        inputId.classList.remove("completed");
    }
}

function update(inputId) {
    // Get the input element by its id
event.preventDefault();
    const inputElement = document.getElementById(inputId);
    const saveButton = document.getElementById("save" + + inputId.replace("input", ""));
   
        inputElement.removeAttribute("readonly"); // Make the input editable
        saveButton.style.display = "inline-block"; // Show the save button
        inputElement.focus(); // Focus on the input element for user convenience

       
}
    </script>
</body>
</html>