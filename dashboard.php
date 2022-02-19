<?php session_start();

if(empty($_SESSION['id'])){
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webhost | Dashboard</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" integrity="sha512-wnea99uKIC3TJF7v4eKk4Y+lMz2Mklv18+r4na2Gn1abDRPPOeef95xTzdwGD9e6zXJBteMIhZ1+68QC5byJZw==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <link rel="stylesheet" href="material-design-iconic-font/css/material-design-iconic-font.min.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php require_once "nav2.php" ?>
    <div class="wrap-lg">
        <div class="left-flex">
            <div class="center">
                <button class='button'>
                    <i class="fas fa-shopping-cart"></i> Buy
                </button>
            </div>
            <ul class="list">
                <li class="l-10"><i class="fas fa-angle-right"></i><i class="fas fa-globe"></i><p>Hosting</p></li>
                <div class="accordion">
                    <?php
                        require_once 'db.php';

                        $query = "SELECT * FROM web WHERE userid = :id";  
                        $bdd = $pdo->prepare($query);  
                        $bdd->execute(array(  
                            'id' => $_SESSION["id"],
                        ));
        
                        $results = $bdd->fetchAll(PDO::FETCH_ASSOC);
        
                        foreach($results as $result){
                            echo "<a href='?web=".$result["name"]."'><div class='sm'><i class='fas fa-globe ft'></i><p class='lf'>".$result["name"]."</p></div></a>";
                        }
                    ?>
                </div>
                <li class="l-10"><i class="fas fa-angle-right"></i><i class="fas fa-server"></i><p>Server</p></li>
            </ul>
        </div>
        <div class="wrap">
            <?php if(isset($_GET["web"])){
                require_once 'db.php';

                $query = "SELECT * FROM web WHERE name = :username";  
                $bdd = $pdo->prepare($query);  
                $bdd->execute(array(  
                    'username' => $_GET["web"],
                ));

                $results = $bdd->fetchAll(PDO::FETCH_ASSOC);

                function parse_timestamp($timestamp, $format = 'F Y')
                {
                    return date($format, strtotime($timestamp));
                }

                function ping($host, $port_int){
                    $fp = fsockopen($host, $port_int, $errorCode, $errorCode, 5);
                    if($fp === false){
                        return "<button class='inact'>Inactive</button>";
                    }else{
                        return "<button class='act'>Active</button>";
                    }
                    fclose($fp);
                }

                foreach($results as $result){
                    echo "
                    <div class='left-25'>
                        <h2>".$result["name"]."</h2>
                        <p class='au'>Automatic Website created on <b>".parse_timestamp($result["created"])."</b></p>
                        <div class='bbox'>
                            <h3>General Information</h3>
                            <p class='ac'>Service status</p>
                            ".ping("localhost", $result["port"])."
                            <p class='ac'>Address</p>
                            <p class='desc'>0.0.0.0:".$result["port"]."</p>
                        </div>
                        <div class='right'>Actions <i class='fa-solid fa-chevron-down'></i></div>
                    </div>";
                }
            }
            
            if(isset($_GET["box"])){
            if($_GET["box"] == "buy"){
                require_once "buy.php";

                if(isset($_POST["app"]) AND isset($_POST["select"])){
                    if($_POST["select"] == "wordpress"){
                        require_once 'db.php';

                        $query = "SELECT * FROM web WHERE name = :username";  
                        $bdd = $pdo->prepare($query);  
                        $bdd->execute(array(  
                            'username' => $_POST["app"],
                        ));

                        $results = $bdd->rowCount();

                        if($results == 0){
                            $port = rand(1024, 65535);

                            $query = "SELECT * FROM web WHERE port = :port";  
                            $bdd = $pdo->prepare($query);  
                            $bdd->execute(array(  
                                'port' => $port,
                            ));

                            $result = $bdd->rowCount();
                            if($result == 0){
                                $output = shell_exec("docker run -d -p ".$port.":80 --net wordpress_default -e WORDPRESS_DB_HOST='172.20.0.2:3306' -e WORDPRESS_DB_USER='wordpress' -e WORDPRESS_DB_PASSWORD='wordpress' -e WORDPRESS_DB_NAME='wordpress' -e WORDPRESS_TABLE_PREFIX='wp_".$port."' f070d750f79f");

                                $query = "INSERT INTO web(userid, name, container, port, created) VALUES (:id, :name, :container, :port, current_timestamp);";  
                                $bdd = $pdo->prepare($query);  
                                $bdd->execute(array(
                                    'id' => $_SESSION["id"],
                                    'name' => $_POST["app"],
                                    'container' => $output,
                                    'port' => $port,
                                ));

                                echo '<script>$("form").append(`<a href="http://localhost:'.$port.'" target="_blank">Go to the website</a>`)</script>';
                            }
                        }
                    }}
                }
            } ?>
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    var email = "<?= $_SESSION['email'] ?>",
    name = "<?= $_SESSION['name'] ?>";
</script>
<script src="js/main.js"></script>
<script src="js/dashboard.js"></script>
</html>