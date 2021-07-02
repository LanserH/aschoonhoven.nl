<?php
//Verbinding maken met de database
$dbhost = "172.17.0.3";
$dbname = "aschoonhoven";
$user = "root";
$pass = "a3b6c9";
try {
    $verbinding = new PDO("mysql:host=$dbhost;dbname=$dbname",$user,$pass);
    $verbinding->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION );
    //echo "<br />Verbinding met database gemaakt";
}
catch(PDOException $e) {
    echo $e->getMessage();
    echo "<br />Verbinding NIET gemaakt";
    die;
}
///////
?>