

    <main id="main">
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
        $myArtikel = $_POST['myArtikel'];
        $sql = "SELECT * FROM artikelen";
        $stmt = $verbinding->prepare($sql);
        $stmt->execute(array($_GET["id"]));
        $artikelen = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($artikelen as $artikel) {
            $idArtikel = $artikel['ID'];
        }
        $artikelID = $idArtikel;
        if(isset($_POST["submit"])) {
            $melding = "<ol>\n";
            if($_SERVER["REQUEST_METHOD"] == "POST") {
                if(empty($_POST["titel"])) {
                    $melding .= "<li><a href=\"#titel\">Titel mag niet leeg zijn</a></li>\n";
                    $errorCount++;
                }
                if(empty($myArtikel)) {
                    $melding .= "<li><a href=\"#editor\">Uw boodschap mag niet leeg zijn</a></li>\n";
                    $errorCount++;
                }
            }            
            if($errorCount == 0) {                
                $sql = "UPDATE artikelen SET titel = ?, tekstArtikel = ? WHERE ID = $artikelID";
                $stmt = $verbinding->prepare($sql);
                try {
                    $stmt = $stmt->execute(array($titel, $myArtikel));
                    echo "<script>
                    location.href='/artikel_afbeeldingen&id=$idArtikel';</script>";
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
        <div class="styleFormDiv">
            <div class="formCss">
                 
                <?php
                $sqlGalerij = "SELECT * FROM galerij WHERE artikelID = $artikelID";
                $stmtGalerij = $verbinding->prepare($sqlGalerij);
                $stmtGalerij->execute(array($_GET["id"]));
                $galerij = $stmtGalerij->fetchAll(PDO::FETCH_ASSOC);
                foreach($galerij as $idGalerij) {
                }
               
                ?>    
                <button class="formSubmit" onclick="location.href='/artikelen'">Terug</button>
                <button class="formSubmit" onclick="location.href='/artikel_verwijderen&id=<?php echo $_GET['id'] ?>'">Verwijder deze artikel</button>
                
                <form name="Bewerk uw artikel" method="POST" onsubmit="beforeSubmit()" action="/artikel_edit#error">
                
                <input type="hidden" name="myArtikel" id="myArtikel">
                <label class="formLabel" for="titel">Titel:
                    <strong><abbr title="required">*</abbr></strong>
                </label>
                <input class="formInput" value="<?php echo $artikel['titel'];?>" type="text" name="titel" id="titel" autofocus/>
                
                <?php
                    include_once('ckeditor5/editor2.php');
                ?>
                <!--<button class="formSubmit" onclick="location.href='/artikelen'">Terug naar artikelen</button> -->
                <input class="formBlueSubmit" type="submit" id="submit" name="submit" value="Terug naar de artikel">
                </form>
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