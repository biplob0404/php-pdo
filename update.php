<?php
session_start();

if ($_SERVER['REQUEST_METHOD']==='GET') {
    if(isset($_GET['update'])){
        $id = $_GET['update'];
        require_once 'includes/db.php';

        $fetchQuery = "SELECT * FROM users WHERE id = ?";
        $fetchStmt = $conn->prepare($fetchQuery);
        $fetchStmt -> execute([$id]);
        $result = $fetchStmt->fetch(PDO::FETCH_ASSOC);

        $_SESSION['userInfo'] = ['username' => $result['username'], 'email' => $result['email']];
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UPDATE - PDO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    

    <div class="formOutline">
            <form action="" method="post">
                <h1>Update Member</h1>
                
                    <?php
                        if(isset($_SESSION['errUp'])){
                    ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $_SESSION['errUp']; ?>
                            </div>
                    <?php
                        }
                        unset($_SESSION['errUp']);
                    ?>

                <div class="mb-3">
                    <label for="name" class="form-label">Username</label>
                    <input value="<?php echo $_SESSION['userInfo']['username'] ?>" name="name" type="text" class="form-control" id="name">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input value="<?php echo $_SESSION['userInfo']['email'] ?>" name="email" type="email" class="form-control" id="email">
                </div>


                <button type="submit" name="submitSignup" class="btn btn-primary">Submit</button>
            </form>
            <div style="text-align: center;">
                <a href="index.php">Go Back</a>
            </div>
            
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>

<?php

    if(isset($_POST['submitSignup'])){
        require_once 'includes/db.php';
        $id = $_GET['update'];
        $updateName = $_POST['name'];
        $updateEmail = $_POST['email'];

        if(empty($updateEmail) || empty($updateName)){
            $_SESSION['errUp'] = "Empty Input";
            exit();
        }
        if(!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $updateName)){
            $_SESSION['errUp'] = "Invalid Username";
            exit();           
        }
        if(!filter_var($updateEmail, FILTER_VALIDATE_EMAIL)){
            $_SESSION['errUp'] = "Invalid Email";
            exit();
        }

        if($updateEmail== $_SESSION['userInfo']['email'] && $updateName==$_SESSION['userInfo']['username']){
            $_SESSION['errUp'] = "Nothing Changed";
            exit();
        }


        $checkDuplicateStmt = $conn -> prepare("SELECT username , email FROM users WHERE (username = ? OR email = ?) AND id !=? ;");
        $checkDuplicateStmt -> execute([$updateName, $updateEmail, $id]);
        $checkResult = $checkDuplicateStmt->fetch(PDO::FETCH_ASSOC);

        if($checkResult){
            $_SESSION['errUp'] = "Username or Email already exists";
            exit();            
        }
   
        else{
        $stmt = $conn->prepare("UPDATE users SET username = ? , email = ? WHERE id = $id;");
        $stmt -> execute([$updateName, $updateEmail]);
        $_SESSION['successUpdate'] = "Updated Successfully";
        header("Location: index.php?update=success");
        }


    }

?>