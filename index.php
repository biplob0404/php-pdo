<?php
    session_start();
    include "includes/db.php";

    $query = "SELECT * FROM users";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDO-Signup System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

        <div class="formOutline">
            <form action="includes/formcontroller.php" method="post">
                <h1>Add Member</h1>
                <div class="mb-3">
                    <label for="name" class="form-label">Username</label>
                    <input value="<?php
                        // for better user experience to-   
                       if(isset($_SESSION['errMsg'])){echo $_SESSION['name'];} unset($_SESSION['name']); 
                    
                    ?>" name="name" type="text" class="form-control" id="name">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input value="<?php
                        // for better user experience to-                            
                        if(isset($_SESSION['errMsg'])){echo $_SESSION['email'];} unset($_SESSION['email']); 

                    ?>" name="email" type="email" class="form-control" id="email">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input name="password" type="password" class="form-control" id="password">
                </div>

                <div class="mb-3">
                    <label for="rePassword" class="form-label">Confirm Password</label>
                    <input name="rePassword" type="password" class="form-control" id="rePassword">
                </div>


                <button type="submit" name="submitSignup" class="btn btn-primary">Submit</button>
            </form>


        <?php
            if(isset($_SESSION['errMsg'])){
        ?>
            <div class="alertBox">
                <div class="alert alert-danger" role="alert">
                 <?php echo $_SESSION['errMsg']; ?>
                </div>
            </div>

        <?php
            }
            unset ($_SESSION['errMsg']);
        ?>


        <?php
            if(isset($_SESSION['success'])){
        ?>
            <div class="alertBox">
                <div class="alert alert-success" role="alert">
                <?php echo $_SESSION['success']; ?>
                </div>
            </div>

        <?php
            }
            unset ($_SESSION['success']);
        ?>





        </div>
        <div id="tableArea" style="width: 650px; margin:10px auto">
            <h3 style="color: #fff; text-align:center;">All Member</h3>
            <table class="table table-dark table-striped" style="text-align: center;font-size:16px;">
                  <thead>
                        <tr>
                            <th scope="col">SL NO.</th>
                            <th scope="col">Username</th>
                            <th scope="col">Email</th>
                            <th scope="col">UID</th>
                            <th scope="col-2">Delete </th>
                        </tr>
                   </thead>
                   <tbody>
                        <?php
                            $countSl = 1;
                            foreach($result as $row):
                        ?>
                            <tr>
                                <th><?php echo $countSl++?></th>
                                <td><?php echo $row['username']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['id']; ?></td>
                                <td>
                                    <form action="delete.php" method="get">
                                        <button onclick="return confirm('Are you sure you want to delete this item?');" class="btn btn-danger" name="del" value="<?php echo $row['id'];?>">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php
                            endforeach;
                        ?>
                   </tbody>
            </table>
        </div>

        <script>
           
        </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>