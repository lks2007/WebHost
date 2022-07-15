<?php if($_GET['active'] === "on"){
    shell_exec('docker start '.$_GET['container']);
}elseif ($_GET['active'] === "off") {
    shell_exec('docker stop '.$_GET['container']); 
}else{
    require_once 'db.php';

    $query = "DELETE FROM web WHERE name = :name AND userid = :user";  
    $bdd = $pdo->prepare($query);  
    $bdd->execute(array(  
        'name' => $_GET["name"],
        'user' => $_GET["user"],
    ));
    shell_exec('docker stop '.$_GET['container']); 
    shell_exec('docker rm -f '.$_GET['container']); 

    require_once 'db-mysql.php';

    $query = 'SHOW TABLES LIKE "wp\_'.$_GET["port"].'%";';
    $bdd = $pdo->prepare($query);  
    $bdd->execute();

    $request = $bdd->fetchAll(PDO::FETCH_ASSOC);

    foreach($request as $response){
        $query = 'DROP TABLE '.$response['Tables_in_wordpress (wp\_'.$_GET["port"].'%)'].';';
        $bdd = $pdo->prepare($query);  
        $bdd->execute();
    }

} ?>