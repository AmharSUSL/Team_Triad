<?php
    $uname = $_POST["uname"];
    $password = $_POST["password"];
    $repassword = $_POST["repassword"];

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $errors = array();

    if (empty($uname) || empty($password) || empty($repassword)) {
        array_push($errors, "All fields are required");
    }

    if (strlen($password) < 8) {
        array_push($errors, "Password must be 8 characters long");
    }

    if ($password != $repassword) { 
        array_push($errors, "Passwords do not match");
    }

    if (count($errors) > 0) {
        foreach ($errors as $error) {  
            echo "<div class='alert alert-danger'>$error</div>";
        }
    } else {
        require_once "db_conn.php";
        $sql = "INSERT INTO users (user_name,password)VALUES(?,?)";
        $stmt = mysqli_stmt_init($conn);
        $preparestmt = mysqli_stmt_prepare($stmt,$sql);
        if($preparestmt){
            mysqli_stmt_bind_param($stmt,"ss",$uname,$passwordHash);
            mysqli_stmt_execute($stmt);
            echo "<div class='alert alert-success'>You are registered successfully.</div>";
        }else{
            die("Something went wrong");
        }
    }
?>