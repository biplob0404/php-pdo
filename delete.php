<?php



if($_SERVER['REQUEST_METHOD']==="GET"){
    if(isset($_GET['del'])){
        require_once "includes/db.php";
        $targetUser = $_GET["del"];
        
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt -> execute([$targetUser]);

        if($stmt){
            header("Location: index.php?message=User%Deleted");
            exit();             
        }else{
            header("Location: index.php?error=error");
            exit();
        }

    }
}
?>