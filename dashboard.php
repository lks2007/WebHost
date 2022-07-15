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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/xterm/3.14.5/xterm.min.css" integrity="sha512-iLYuqv+v/P4u9erpk+KM83Ioe/l7SEmr7wB6g+Kg1qmEit8EShDKnKtLHlv2QXUp7GGJhmqDI+1PhJYLTsfb8w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>
<body>
    <?php require_once "nav2.php" ?>
    <div class="wrap-lg">
        <div class="left-flex">
            <div class="center">
                <button class='button'>
                    <i class="fa-solid fa-shopping-cart"></i> Buy
                </button>
            </div>
            <ul class="list">
                <li class="l-10 hosting"><i class="fa-solid fa-angle-right"></i><i class="fa-solid fa-globe"></i><p>Hosting</p></li>
                <div class="accordion" aria-label="1">
                    <?php
                        require_once 'db.php';

                        $query = "SELECT * FROM web WHERE userid = :id";  
                        $bdd = $pdo->prepare($query);  
                        $bdd->execute(array(  
                            'id' => $_SESSION["id"],
                        ));
        
                        $results = $bdd->fetchAll(PDO::FETCH_ASSOC);
        
                        foreach($results as $result){
                            echo "<a href='?web=".$result["name"]."'><div class='sm'><i class='fa-solid fa-cube ft'></i><p class='lf'>".$result["name"]."</p></div></a>";
                        }
                    ?>
                </div>
                <li class="l-10 server"><i class="fa-solid fa-angle-right"></i><i class="fa-solid fa-server"></i><p>Server</p></li>
                <div class="accordion" aria-label="2">
                <?php
                        require_once 'db.php';

                        $query = "SELECT * FROM server WHERE userid = :id";  
                        $bdd = $pdo->prepare($query);  
                        $bdd->execute(array(  
                            'id' => $_SESSION["id"],
                        ));
        
                        $results = $bdd->fetchAll(PDO::FETCH_ASSOC);
        
                        foreach($results as $result){
                            echo "<a href='?server=".$result["name"]."'><div class='sm'><i class='fa-solid fa-cube ft'></i><p class='lf'>".$result["name"]."</p></div></a>";
                        }
                    ?>
                </div>
            </ul>
        </div>
        <?php if(isset($_GET['box']))
        {
            echo '<div class="wrap-2">';
        }else{
            echo '<div class="wrap">';
        }
        ?>
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
                            ".ping("172.22.2.15", $result["port"])."
                            <p class='ac'>Address</p>
                            <a class='desc' href='http://172.22.2.15:".$result["port"]."' target='_blank'>0.0.0.0:".$result["port"]."</a>
                        </div>
                    </div>
                    <div class='left-25'>
                        <div class='right mg-2'>Actions <i class='fa-solid fa-chevron-down'></i></div>
                    </div>";

                    global $ok;
                    global $name;
                    global $realname;
                    global $user;
                    global $port_container;

                    $port_container = $result["port"];
                    $realname = $result["name"];
                    $user = $result["userid"];
                    $name = $result["container"];
                    $name = str_replace(array("\r", "\n"), '', $name);

                    if(ping("172.22.2.15", $result["port"]) === "<button class='inact'>Inactive</button>"){
                        $ok = 0; 
                    }else{
                        $ok = 1;
                    }
                    include('javascript.php');
                }
            }


            if(isset($_GET["server"])){
                require_once 'db.php';

                $query = "SELECT * FROM server WHERE name = :username";  
                $bdd = $pdo->prepare($query);  
                $bdd->execute(array(  
                    'username' => $_GET["server"],
                ));

                $results = $bdd->fetchAll(PDO::FETCH_ASSOC);

                function parse_timestamp($timestamp, $format = 'F Y')
                {
                    return date($format, strtotime($timestamp));
                }

                function pingAddress($ip) {
                    $pingresult = exec("/bin/ping -c2 -w2 $ip", $outcome, $status);
                    if($status == 1){
                        return "<button class='inact'>Inactive</button>";
                    }else{
                        return "<button class='act'>Active</button>";
                    }
                }

                foreach($results as $result){
                    echo "
                    <div class='left-25'>
                        <h2>".$result["name"]."</h2>
                        <p class='au'>Automatic Server created on <b>".parse_timestamp($result["created"])."</b></p>
                        <div class='bbox'>
                            <h3>General Information</h3>
                            <p class='ac'>Service status</p>
                            ".pingAddress($result["address"])."
                            <p class='ac'>Address</p>
                            <p class='desc'>".$result['address']."</p>
                        </div>
                    </div>
                    <div class='left-25'>
                        <div class='right mg-2'>Actions <i class='fa-solid fa-chevron-down'></i></div>
                    </div>";

                    global $ok;
                    global $name;
                    global $realname;
                    global $user;
                    global $ip;

                    $realname = $result["name"];
                    $user = $result["userid"];
                    $ip = $result['address'];
                    $ip = str_replace(array("\r", "\n"), '', $ip);
                    $name = $result["container"];
                    $name = str_replace(array("\r", "\n"), '', $name);

                    if(pingAddress($result['address']) === "<button class='inact'>Inactive</button>"){
                        $ok = 0; 
                    }else{
                        $ok = 1;
                    }
                    include('js.php');
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
                                $output = shell_exec("docker run -d -p 172.22.2.15:".$port.":80 --net wordpress_default -e WORDPRESS_DB_HOST='172.20.0.2:3306' -e WORDPRESS_DB_USER='wordpress' -e WORDPRESS_DB_PASSWORD='wordpress' -e WORDPRESS_DB_NAME='wordpress' -e WORDPRESS_TABLE_PREFIX='wp_".$port."' f070d750f79f");

                                $query = "INSERT INTO web(userid, name, container, port, created) VALUES (:id, :name, :container, :port, current_timestamp);";  
                                $bdd = $pdo->prepare($query);  
                                $bdd->execute(array(
                                    'id' => $_SESSION["id"],
                                    'name' => $_POST["app"],
                                    'container' => $output,
                                    'port' => $port,
                                ));

                                echo '<a href="http://172.22.2.15:'.$port.'" target="_blank">Go to the website</a>';
                            }
                        }
                    }elseif ($_POST["select"] == "alpine") {
                        require_once 'db.php';

                        $query = "SELECT * FROM server WHERE name = :username";  
                        $bdd = $pdo->prepare($query);  
                        $bdd->execute(array(  
                            'username' => $_POST["app"],
                        ));

                        $results = $bdd->rowCount();

                        if($results == 0){
                            $result = $bdd->rowCount();
                            if($result == 0){
                                $output = shell_exec("docker run -d alpine:latest sleep infinity");
                                $ip = shell_exec("docker inspect -f '{{range.NetworkSettings.Networks}}{{.IPAddress}}{{end}}' ".$output);

                                $query = "INSERT INTO server(userid, name, container, address, created) VALUES (:id, :name, :container, :address, current_timestamp);";  
                                $bdd = $pdo->prepare($query);  
                                $bdd->execute(array(
                                    'id' => $_SESSION["id"],
                                    'name' => $_POST["app"],
                                    'container' => $output,
                                    'address' => $ip,
                                ));

                                echo '<a href="http://172.22.2.15:'.$port.'" target="_blank">Go to the website</a>';
                            }
                    }
                }}
                }
            }
            if(empty($_GET["box"]) && empty($_GET["web"])){
                echo "";
            }
            ?>
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