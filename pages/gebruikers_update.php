<?php  
if($_SESSION["ROL"]==0) {
    echo "<script>
    alert('U heeft geen toegang tot deze pagina.');
    location.href='/uitloggen';
    </script>"; 
}
$sql = "SELECT * FROM persoonlijk";
$stmt = $verbinding->prepare($sql);
$stmt->execute(array($_GET["id"]));
$gebruikers = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach($gebruikers as $gebruiker) {
    $idGebruiker = $gebruiker['ID'];
}
if(isset($_POST['submit'])) {
    $selectedRol = htmlspecialchars($_POST['rolOption']);
    $sql = "UPDATE persoonlijk SET rol = ? WHERE ID $idGebruiker";
    $stmt = $verbinding->prepare($sql);
    try {
        $stmt = $stmt->execute(array($selectedRol));
        echo "<script>
        location.href='/gebruikers';</script>";
    } catch(PDOException $e) {
        echo $e->getMessage();
    }
}
?>