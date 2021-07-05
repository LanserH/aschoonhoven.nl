

    <main id="main">
    <div class="opmaakDivH1">
        <div class="styleFormDiv">
            <div class="divH1">
                <h1>Schrijf een nieuw artikel</h1>
            </div>
        </div>
    </div>
        <?php
        function test_input ($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        if($_SESSION["ROL"]==0) {
            echo "<script>
            alert('U heeft geen toegang tot deze pagina.');
            location.href='/uitloggen';
            </script>"; 
        }
        $titelErr = "";
        $textErr = "";
        $errorCount = 0;
        $titel = htmlspecialchars($_POST["titleField"]);
        $inleiding = htmlspecialchars($_POST['inleidingName']);
        $tekstArtikel = $_POST["myDoc"];

        if(isset($_POST["submit"])) {
            $melding = "<ol>\n";
            if($_SERVER["REQUEST_METHOD"] == "POST") {
                if(empty($_POST["titleField"])) {
                    $melding .= "<li><a href=\"#titleInput\">Titel is verplicht</a></li>\n";
                    $errorCount++;
                }
                if(empty($tekstArtikel)) {
                    $melding .= "<li><a href=\"#editor\">U kunt uw boodschap niet leeg versturen.</a></li>\n";
                    $errorCount++;
                }
            }            
            if($errorCount == 0) {                
                $sql = "INSERT INTO artikelen (titel, inleiding, tekstArtikel) values (?,?,?)";
                $stmt = $verbinding->prepare($sql);
                try {
                    $stmt->execute(array(
                        $titel,
                        $inleiding,
                        $tekstArtikel
                    ));
                } catch(PDOException $e) {
                    $melding .= "Kan geen nieuwe artikel aanmaken. Neem contact op met uw ontwikkelaar" .$e->getMessage();
                }
                echo "<div id='styleFormDiv'>".$melding."</div>";
                $sqlID = "SELECT * FROM artikelen";
                $stmt = $verbinding->prepare($sqlID);
                $stmt->execute(array());
                $artikelen = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($artikelen as $artikel){ 
                    $idArtikel = $artikel['ID'];
                }
                echo "
                    <script>
                        location.href = '/artikel_afbeeldingen&id=$idArtikel';
                    </script> ";
            }
        } 
        else if(isset($_POST["saveMess"])) {
        $melding = "<ol>\n";
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            if(empty($_POST["titleField"])) {
                $melding .= "<li><a href=\"#titleInput\">Titel is verplicht</a></li>\n";
                $errorCount++;
            }
            if(empty($tekstArtikel)) {
                $melding .= "<li><a href=\"#editor\">U kunt uw boodschap niet leeg versturen.</a></li>\n";
                $errorCount++;
            }
        }            
        if($errorCount == 0) {                
            $sql = "INSERT INTO artikelen (titel, inleiding, tekstArtikel) values (?,?,?)";
            $stmt = $verbinding->prepare($sql);
            try {
                $stmt->execute(array(
                    $titel,
                    $inleiding,
                    $tekstArtikel
                ));
            } catch(PDOException $e) {
                $melding .= "Kan geen nieuwe artikel aanmaken. Neem contact op met uw ontwikkelaar" .$e->getMessage();
            }
            echo "<div id='styleFormDiv'>".$melding."</div>";
            $sqlID = "SELECT * FROM artikelen";
            $stmt = $verbinding->prepare($sqlID);
            $stmt->execute(array());
            $artikelen = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($artikelen as $artikel){ 
                $idArtikel = $artikel['ID'];
            }
            echo "
                <script>
                    location.href = '/artikelen';
                </script> ";
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
                <button class="formSubmit" onclick="location.href='/artikelen'">Terug</button>
                
                <form name="compForm" method="POST" onsubmit="beforeSubmit()" action="/artikel_toevoegen#error"> 

                <input type="hidden" name="myDoc" id="myDoc">
                
                <label class="formLabel" for="titleInput">Titel van het artikel:
                    <strong><abbr title="required">*</abbr></strong>
                </label>
                <?php
                $sql = "SELECT * FROM artikelen WHERE ID = ?";
                $stmt = $verbinding->prepare($sql);
                $stmt->execute(array($_GET["id"]));
                $artikelen = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach($artikelen as $artikel) {
                        $idArtikel = $artikel['ID'];
                    }
                $artikelID = $idArtikel;
                ?>
                <input class="formInput" value="<?php echo $titel;?>" type="text" name="titleField" id="titleInput"/>
                <label class="formLabel" for="inleiding">Inleiding op het artikel (indien van toepassing)</label>
                <textarea class="textAreaInput" name="inleidingName" id="inleiding"><?php echo $inleiding;?></textarea>
                <?php
                    include_once('tinymce/editorTMCE1.php');
                ?>
                <input class="formBlueSubmit" type="submit" id="submit" name="submit" value="Voeg afbeelding(en) toe">
                <input class="formBlueSubmit" type="submit" id="saveMess" name="saveMess" value="Sla artikel op zonder afbeelding">
                </form>
                
            </div>
        </div>
    </main>
<script>
function beforeSubmit(){        
    var tekst = editor.getData();
    document.getElementById('myDoc').value = tekst;
}
</script>

<?php
    include_once("footer.php");
?>