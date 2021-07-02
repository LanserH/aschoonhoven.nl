

    <main id="main">
    <div class="opmaakDivH1">
        <div class="styleFormDiv">
            <div class="divH1">
                <h1>Introduceer uw zelf</h1>
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
    $introductie = $_POST['introductie'];
    $introductie2 = $_POST['introductie2'];
    $sql = "SELECT * FROM introHomepage";
    $stmt = $verbinding->prepare($sql);
    $stmt->execute(array($_GET["id"]));
    $introHomepage = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($introHomepage as $intro) {
    }
    if(isset($_POST["submit"])) {
        $melding = "<ol>\n";
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            if(empty($introductie)) {
                $melding .= "<li><a href=\"#editor\">Het introductie invoerveld mag niet leeg worden gelaten!</a></li>\n";
                $errorCount++;
            }
            if(empty($introductie2)) {
                $melding .= "<li><a href=\"#editor2\">Het contact invoerveld mag niet leeg worden gelaten!</a></li>\n";
                $errorCount++;
            }
        }            
        if($errorCount == 0) {                
            $sql = "INSERT INTO introHomepage (introTekst, introTekst2) values (?, ?)";
            $stmt = $verbinding->prepare($sql);
            try {
                $stmt = $stmt->execute(array($introductie, $introductie2));
                echo "<script>alert('Uw introductie is bijgewerkt en opgeslagen.');
                location.href='/introHomepage_edit';</script>";
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
                <form name="Bewerk uw introductie" method="POST" onsubmit="beforeSubmit()" action="/introHomepage_edit#error">
                <h2>Introductie tekst in het banner</h2>
                    <input type="hidden" name="introductie" id="introductie">
                    <?php
                        include_once('ckeditor5/introEditor.php');
                    ?>
                    <input class="formBlueSubmit" type="submit" id="submit" name="submit" value="Opslaan">
                <form>
            </div>
        </div>
    </div>
    <div class="formCssArtikel">
        <div class="styleFormDiv">
            <div class="formCss">
            <h2>Introductie tekst in het contact pagina</h2>
                    <form name="Bewerk uw introductie" method="POST" onsubmit="beforeSubmit2()" action="/introHomepage_edit#error">
                    <input type="hidden" name="introductie2" id="introductie2">
                    <?php
                        include_once('ckeditor5/introEditor2.php');
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
        document.getElementById('introductie').value = tekst;
        var tekst2 = editor2.getData();
        document.getElementById('introductie2').value = tekst2;
        
    }
    </script>
<?php
    include_once("footer.php");
?>