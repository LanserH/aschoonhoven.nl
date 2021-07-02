

    <main id="main">
    <div class="opmaakDivH1">
        <div class="styleFormDiv">
            <div class="divH1">
                <h1>Schrijf en bewerk het verhaal van het "Over ons" pagina</h1>
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
    $overOnsTekst = $_POST['overOnsTekst'];
    $sql = "SELECT * FROM overOns";
    $stmt = $verbinding->prepare($sql);
    $stmt->execute(array($_GET["id"]));
    $overOns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($overOns as $aboutUs) {
    }
    if(isset($_POST["submit"])) {
        $melding = "<ol>\n";
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            if(empty($overOnsTekst)) {
                $melding .= "<li><a href=\"#editor\">De invoerveld met de boodschap over A Schoonhoven mag niet leeg worden gelaten!</a></li>\n";
                $errorCount++;
            }
        }            
        if($errorCount == 0) {                
            $sql = "INSERT INTO overOns (overOnsTekst) values (?)";
            $stmt = $verbinding->prepare($sql);
            try {
                $stmt = $stmt->execute(array($overOnsTekst));
                echo "<script>alert('Het verhaal over uw zelf is bijgewerkt en opgeslagen.');
                location.href='/over_ons_edit';</script>";
            } catch(PDOException $e) {
                $melding .= "Kan geen nieuwe artikel aanmaken. Neem contact op met uw ontwikkelaar" .$e->getMessage();
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
                
                <form name="Bewerk uw verhaal over ons" method="POST" onsubmit="beforeSubmit()" action="/over_ons_edit#error">
                
                <input type="hidden" name="overOnsTekst" id="overOnsTekst">
                <!--
                <label class="formLabel" for="titel">Titel:
                    <strong><abbr title="required">*</abbr></strong>
                </label>
                <input class="formInput" value="<?php echo $artikel['titel'];?>" type="text" name="titel" id="titel" autofocus/>
                -->
                <?php
                    include_once('ckeditor5/overOnsEditor.php');
                ?>
                <!--<button class="formSubmit" onclick="location.href='/artikelen'">Terug naar artikelen</button> -->
                <input class="formBlueSubmit" type="submit" id="submit" name="submit" value="Opslaan">
                </form>
                </div>
            </div>
        </div>
        <!--
        <div class="styleFormDivArtikel2">
            <div class="formCssArtikel2">
                    Style 2
            </div>
        </div>
        -->
    </main>
    <script>
    function beforeSubmit(){        
        var tekst = editor.getData();
        document.getElementById('overOnsTekst').value = tekst;
    }
    </script>

<?php
    include_once("footer.php");
?>
</html>