<?php
if($_SESSION["ROL"]==0) {
    echo "<script>
    alert('U heeft geen toegang tot deze pagina.');
    location.href='/uitloggen';
    </script>"; 
}

$sql = "DELETE FROM artikelen WHERE ID = ?";
$stmt = $verbinding->prepare($sql);
try {
    $stmt->execute(array($_GET['id']));
    echo "<script>alert('Artikel is verwijderd.');
        location.href='/artikelen';</script>";
} catch(PDOException $e) {
    echo $e->getMessage();
}
?>