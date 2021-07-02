<?php
if($_SESSION["ROL"]==0) {
    echo "<script>
    alert('U heeft geen toegang tot deze pagina.');
    location.href='/uitloggen';
    </script>"; 
}

$sql = "DELETE FROM persoonlijk WHERE ID = ?";
$stmt = $verbinding->prepare($sql);
try {
    $stmt->execute(array($_GET['id']));
    echo "<script>alert('Gebruiker is verwijderd.');
        location.href='/gebruikers';</script>";
} catch(PDOException $e) {
    echo $e->getMessage();
}
?>