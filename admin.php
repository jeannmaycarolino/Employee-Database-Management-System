<?php
include('./config/db.php');
session_start();

if (isset($_POST['submit_button'])) {

    
    $pass = $_POST['password'];
    $email= $_POST['email'];
    print($pass);
    print($email);
    if ($email == 'admin@gmail.com'){
        
        if ($pass == 'admin'){

            header('Location: ./index.php');
            exit();
        } else {
            header('Location: ./login.php?error=Incorrect Password!');
            exit();
        }

    }
    if ($email == 'manager@gmail.com'){
        if ($pass == 'manager123'){
            
            header('Location: ./manager/index.php');
            exit();
        } else {
            header('Location: ./login.php?error=Incorrect Password!');
            exit();
        }

    }
    $checkQuery = "SELECT * FROM account WHERE Email = '$email'";
        $result = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($result) == 0) {
            // Account does not exists
            header("Location:login.php?error=Account does not exist!");
            exit();
        } else {
            // Account exists
            $row = mysqli_fetch_assoc($result);
            if ($row['Password'] == $pass) {
                print('Successfully Logged In');
                header("Location: ./employee/index.php");
                exit();
                
            } else {
                header("Location:login.php?error=Incorrect Password!");
                exit();
            }
        }
        // Close the result set
        mysqli_free_result($result);
    
}

?>