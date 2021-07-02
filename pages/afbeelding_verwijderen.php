<?php
if($_SESSION["ROL"]==0) {
    echo "<script>
    alert('U heeft geen toegang tot deze pagina.');
    location.href='/uitloggen';
    </script>"; 
}
//afbeelding_verwijderen&id=60&$artikelID=232
$artikelId = $_GET["artikelID"];
//echo $artikelId;
$sql = "DELETE FROM galerij WHERE ID = ?";
$stmt = $verbinding->prepare($sql);
try {
    $stmt->execute(array($_GET['id']));
    echo "<script>alert('Afbeelding is verwijderd.');
        location.href='/artikel_bewerken&id=$artikelId';</script>";
} catch(PDOException $e) {
    echo $e->getMessage();
}
?>