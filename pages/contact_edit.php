

    <main id="main">
    <div class="opmaakDivH1">
        <div class="styleFormDiv">
            <div class="divH1">
                <h1>Bewerk uw contact gegevens</h1>
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
    $contactArtikel = $_POST['contactArtikel'];
    $sql = "SELECT * FROM contact";
    $stmt = $verbinding->prepare($sql);
    $stmt->execute(array($_GET["id"]));
    $contacten = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($contacten as $contact) {
    }
    if(isset($_POST["submit"])) {
        $melding = "<ol>\n";
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            if(empty($contactArtikel)) {
                $melding .= "<li><a href=\"#editor\">Contactpagina kan niet leeg worden gelaten!</a></li>\n";
                $errorCount++;
            }
        }            
        if($errorCount == 0) {                
            $sql = "INSERT INTO contact (contactArtikel) values (?)";
            $stmt = $verbinding->prepare($sql);
            try {
                $stmt = $stmt->execute(array($contactArtikel));
                echo "<script>alert('Uw contactgegevens zijn bijgewerkt en opgeslagen.');
                location.href='/contact_edit';</script>";
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
                
                <form name="Bewerk uw contact pagina" method="POST" onsubmit="beforeSubmit()" action="/contact_edit#error">
                
                <input type="hidden" name="contactArtikel" id="contactArtikel">
                <!--
                <label class="formLabel" for="titel">Titel:
                    <strong><abbr title="required">*</abbr></strong>
                </label>
                <input class="formInput" value="<?php echo $artikel['titel'];?>" type="text" name="titel" id="titel" autofocus/>
                -->
                <?php
                    include_once('ckeditor5/contactEditor.php');
                ?>
                <!--<button class="formSubmit" onclick="location.href='/artikelen'">Terug naar artikelen</button> -->
                <input class="formBlueSubmit" type="submit" id="submit" name="submit" value="Opslaan">
                </form>
                </div>
            </div>
        </div>
    </main>
    <script>
    function beforeSubmit(){        
        var tekst = editor.getData();
        document.getElementById('contactArtikel').value = tekst;
    }
    </script>

<?php
    include_once("footer.php");
?>
