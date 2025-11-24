<?php
    session_start();

if ($_SERVER['REQUEST_METHOD']==='POST') {
    if(isset($_POST['submitSignup'])){
        
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $pass = htmlspecialchars($_POST['password']);
        $rePass = htmlspecialchars($_POST['rePassword']);

        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;

        //db
        require_once "db.php";

        //err handling start
        if(empty($name) || empty($email) || empty($pass) || empty($rePass)){
            header("Location: ../index.php");
            $_SESSION['errMsg'] = "All input fields must be filled in.";
            exit();
            
        }

        if(!preg_match("/^[a-zA-Z0-9_]{3,20}$/",$name)){
            header("Location: ../index.php");
            $_SESSION['errMsg'] = "Invalid Username";
            exit();
        }
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            header("Location: ../index.php");
            $_SESSION['errMsg']= "Invalid Email";
            exit();          
        }
        if($pass !==$rePass){
            header("Location: ../index.php");
            $_SESSION["errMsg"] = "Password didn't mathched";
            exit();           
        }

            $checkExist = "SELECT username , email FROM users WHERE username = ? OR email = ?";
            $checkStmt = $conn->prepare($checkExist);
            $checkStmt -> execute([$name, $email]);
            $result = $checkStmt->fetch(PDO::FETCH_ASSOC);
        if($result){
            header("Location: ../index.php");
            $_SESSION['errMsg'] = "Username or email already exist";
            exit();            
        }

        // err handling end

        else{
            $query = "INSERT INTO users (username, email, pass) VALUES (?,?,?);";
            $stmt = $conn->prepare($query);
            $hashedPass = password_hash($pass,PASSWORD_DEFAULT);
            $stmt->execute([$name,$email,$hashedPass]);
            header("Location: ../index.php");
            $_SESSION['success'] = 'User added Successfully';
            exit();
        }


        

    }
} else {

}
