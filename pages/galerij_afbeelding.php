

    <main id="main">
        <div class="styleFormDiv">
            <div class="divH1">
                <h1>Afbeeldingen toevoegen aan galerij</h1>
            </div>
        </div>
        <?php
        if($_SESSION["ROL"]==0) {
            echo "<script>
            alert('U heeft geen toegang tot deze pagina.');
            location.href='/uitloggen';
            </script>"; 
        }
        ?>
        <div class="styleFormDiv">
        </div>
    </main>    

<?php
    include_once("footer.php");
?>
