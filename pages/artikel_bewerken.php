<main>
    <div class="opmaakDivH1">
        <div class="styleFormDiv">
            <div class="divH1">
                <h1>Bewerk uw artikel</h1>
            </div>
        </div>
    </div>
    <?php
    if($_SESSION["ROL"]==0) {
        echo "<script>
        alert('U heeft geen toegang tot deze pagina.');
        location.href='/uitloggen';
        </script>"; 
    }
    $titelErr = "";
    $textErr = "";
    $errorCount = 0;
    $titel = htmlspecialchars($_POST['titel']);
    $inleiding = htmlspecialchars($_POST['inleidingName']);
    $myArtikel = $_POST['myArtikel'];
    $sql = "SELECT * FROM artikelen WHERE ID = ?";
    $stmt = $verbinding->prepare($sql);
    $stmt->execute(array($_GET["id"]));
    $artikelen = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($artikelen as $artikel) {
        $idArtikel = $artikel['ID'];
    }
    $artikelID = $idArtikel;
    //echo $artikelID." Op rij 41<br>";
    //echo $artikel['ID']."Op rij 42<br>";
    if(isset($_POST["submit"])) {
        $melding = "<ol>\n";
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            if(empty($_POST["titel"])) {
                $melding .= "<li><a href=\"#titel\">Titel is verplicht</a></li>\n";
                $errorCount++;
            }
            if(empty($myArtikel)) {
                $melding .= "<li><a href=\"#textBox\">Uw boodschap is verplicht</a></li>\n";
                $errorCount++;
            }
        }            
        if($errorCount == 0) {                
            $sql = "UPDATE artikelen SET titel = ?, tekstArtikel = ?, inleiding = ?  WHERE ID = $artikelID";
            $stmt = $verbinding->prepare($sql);
            try {
                $stmt = $stmt->execute(array($titel, $myArtikel, $inleiding));
                echo "<script>alert('Uw artikel is bijgewerkt en opgeslagen.');
                location.href='/artikelen';</script>";
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
    ?>
    <div class="styleFormDiv" id="error">   
        <span class="error" autofocus>
            <?php
            $melding .= "</ol>";
            if ($errorCount == 0) {
            echo ""; 
            } elseif ($errorCount == 1) {
                echo "<h2><a href=\"#errorList\">".$errorCount." fout in het formulier</a></h2>";
            } else {
                echo "<h2><a href=\"#errorList\">".$errorCount." fouten in het formulier</a></h2>";
            }
            ?>
        </span>
        <span class="errorList" id="errorList">
            <?php
            $melding .= "</ol>";
            if($errorCount > 0) {
                echo $melding;
            }
            ?>
        </span>
    </div>
    <div class="formCssArtikel">
        <div class="styleFormDiv">
            <div class="formCss">
                <button class="formSubmit" onclick="location.href='/artikelen'">Terug</button>       
                <?php
                $sqlGalerij = "SELECT * FROM galerij WHERE artikelID = $artikelID";
                $stmtGalerij = $verbinding->prepare($sqlGalerij);
                $stmtGalerij->execute(array());
                $galerij = $stmtGalerij->fetchAll(PDO::FETCH_ASSOC);
                foreach($galerij as $idGalerij) {
                }
                ?>    
                <button class="formSubmit" onclick="location.href='/artikel_verwijderen&id=<?php echo $_GET['id'] ?>'">Verwijder dit artikel</button>
                <button class="formSubmit" onclick="location.href='/artikel_afbeeldingen&id=<?php echo $_GET['id'] ?>'">Voeg afbeelding(en) toe</button>
                    <div class='cards'>
                        <ul>
                            <?php
                            $sqlGalerij = "SELECT * FROM galerij WHERE artikelID = $artikelID";
                            $stmtGalerij = $verbinding->prepare($sqlGalerij);
                            $stmtGalerij->execute(array());
                            $galerij = $stmtGalerij->fetchAll(PDO::FETCH_ASSOC);
                            foreach($galerij as $idGalerij) {
                                //echo $idGalerij['ID'];
                                echo"
                                    <li class='card'>
                                    <a href='/afbeelding_bewerken&id=".$idGalerij['ID']."'>
                                        <div class='text'>
                                            Bewerk afbeelding van ".$idGalerij['nameImg']."";
                                            //<p>".$idGalerij['altText']."</p> 
                                            echo "
                                        </div>
                                        <div class='img'>
                                            <img src='/img/upload/".$idGalerij['image']."' alt='".$idGalerij['altText']."'>
                                        </div>
                                        </a>
                                    </li>
                                ";
                            }
                            ?>
                        </ul>
                    </div>
                <form name="Bewerk uw artikel" method="POST" enctype="multipart/form-data" onsubmit="beforeSubmit()" action="/artikel_bewerken&id=<?php echo $artikelID?>#error" novalidate>
                
                <input type="hidden" name="myArtikel" id="myArtikel">
                <div class="classOutputImage">
                    <?php
                    /*
                    if(empty($artikel['afbeelding'])) {
                        echo "";        
                    } else {
                    echo "<img class='outputImage' id='output' src='/img/upload/".$artikel['afbeelding']."'>";
                    }
                    */
                    ?>
                </div>
                <label class="formLabel" for="titel">Titel van het artikel:
                    <strong><abbr title="required">*</abbr></strong>
                </label>
                <input class="formInput" value="<?php echo $artikel['titel'];?>" type="text" required name="titel" id="titel"/>
                <label class="formLabel" for="inleiding">Inleiding op het artikel (indien van toepassing)</label>
                <textarea class="textAreaInput" name="inleidingName" id="inleiding"><?php echo $artikel['inleiding'];?></textarea>
                <?php
                    include_once('ckeditor5/editor2.php');
                ?>
                <input class="formBlueSubmit" type="submit" id="submit" name="submit" value="Opslaan">
                </form>
            </div>
        </div>
    </div>
</main>
<script>
function beforeSubmit(){        
    var tekst = editor.getData();
    document.getElementById('myArtikel').value = tekst;
}
</script>
<?php
    include_once("footer.php");
?>