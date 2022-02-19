<?php session_start() ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webhost | Login</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
</head>
<body>
    <form action="/login.php" method="post">
        <i class="fas fa-sign-in-alt"></i>
        <h3>Welcome!</h3>
        <h4>Sign in to your account</h4>
        <input type="text" placeholder="User or Email" name="username" />
        <input type="password" placeholder="Password" name="password" />
        <input type="submit" value="Login ➡">
    </form>
    <?php 
    if(isset($_POST["username"]) AND isset($_POST["password"])){
        require_once 'db.php';

        $query = "SELECT * FROM users WHERE username = :username OR email = :username";  
        $bdd = $pdo->prepare($query);  
        $bdd->execute(array(  
            'username' => $_POST["username"],
        ));

        $results = $bdd->fetchAll(PDO::FETCH_ASSOC);

        foreach($results as $result){
            if(password_verify($_POST["password"], $result["password"])){
                $_SESSION['id'] = $result['id'];
                $_SESSION['name'] = $result['username'];
                $_SESSION['email'] = $result['email'];
                header("Location: /");
            }else{
                echo "Wrong password or email";
            }
        }
    }
?>
</body>
</html>