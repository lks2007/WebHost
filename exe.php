<?php if($_GET['active'] === "on"){
    shell_exec('docker start '.$_GET['container']);
}elseif ($_GET['active'] === "off") {
    shell_exec('docker stop '.$_GET['container']); 
}else{
    require_once 'db.php';

    $query = "DELETE FROM server WHERE name = :name AND userid = :user";  
    $bdd = $pdo->prepare($query);  
    $bdd->execute(array(  
        'name' => $_GET["name"],
        'user' => $_GET["user"],
    ));
    shell_exec('docker stop '.$_GET['container']); 
    shell_exec('docker rm -f '.$_GET['container']); 

} ?>