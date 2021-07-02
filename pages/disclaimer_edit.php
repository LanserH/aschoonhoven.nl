

    <main id="main">
    <div class="opmaakDivH1">
        <div class="styleFormDiv">
            <div class="divH1">
                <h1>Schrijf en bewerk hier uw disclaimer</h1>
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
    $disclaimerTekst = $_POST['disclaimerTekst'];
    $sql = "SELECT * FROM disclaimer";
    $stmt = $verbinding->prepare($sql);
    $stmt->execute(array($_GET["id"]));
    $disclaim = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($disclaim as $disclaimer) {
    }
    if(isset($_POST["submit"])) {
        $melding = "<ol>\n";
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            if(empty($disclaimerTekst)) {
                $melding .= "<li><a href=\"#editor\">De disclaimer mag niet leeg worden gelaten!</a></li>\n";
                $errorCount++;
            }
        }            
        if($errorCount == 0) {                
            $sql = "INSERT INTO disclaimer (disclaimerTekst) values (?)";
            $stmt = $verbinding->prepare($sql);
            try {
                $stmt = $stmt->execute(array($disclaimerTekst));
                echo "<script>alert('Het verhaal over uw zelf is bijgewerkt en opgeslagen.');
                location.href='/disclaimer_edit';</script>";
            } catch(PDOException $e) {
                $melding .= "Kan geen nieuwe disclaimer aanmaken. Neem contact op met uw ontwikkelaar" .$e->getMessage();
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
                
                <form name="Bewerk uw verhaal over ons" method="POST" onsubmit="beforeSubmit()" action="/disclaimer_edit#error">
                
                <input type="hidden" name="disclaimerTekst" id="disclaimerTekst">
                <!--
                <label class="formLabel" for="titel">Titel:
                    <strong><abbr title="required">*</abbr></strong>
                </label>
                <input class="formInput" value="<?php echo $artikel['titel'];?>" type="text" name="titel" id="titel" autofocus/>
                -->
                <?php
                    include_once('ckeditor5/disclaimerEditor.php');
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
        document.getElementById('disclaimerTekst').value = tekst;
    }
    </script>

<?php
    include_once("footer.php");
?>