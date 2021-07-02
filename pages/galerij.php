

    <main id="main">
        <div class="styleFormDiv">
            <div class="divH1">
                <h1>Galerij</h1>
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
            <button class="formSubmit" onclick="location.href='/galerij_afbeelding'">Afbeeldingen toevoegen</button>
            <?php
                include_once("fancyBox/fancyBox.php");
            ?>
        </div>
    </main>    

<?php
    include_once("footer.php");
?>
