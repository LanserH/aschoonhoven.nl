
    <main id="main">
    <div class="opmaakDivH1">
        <div class="styleFormDiv">
            <div class="divH1">
                <h1>Over ons</h1>
            </div>
        </div>
    </div>
    <!--
    <div class="contactBanner">
        <img src="/img/banner/sea.webp" alt="Achtergrond foto met goudkleurige golven">
    </div>
    -->
    <?php 
    $titelErr = "";
    $textErr = "";
    $errorCount = 0;
    $email = htmlspecialchars($_POST["email"]);
    $vraag = htmlspecialchars($_POST["vraag"]);
    $rekenvraag = htmlspecialchars($_POST["rekenvraag"]);
    if(isset($_POST["submit"])) {
        $melding = "<ol>\n";
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            if(empty($_POST["email"])) {
                $melding .= "<li><a href=\"#email\">Emailadres moet ingevuld zijn</a></li>\n";
                $errorCount++;
            }
            if(empty($_POST["vraag"])) {
                $melding .= "<li><a href=\"#vraag\">Uw vraag moet ingevuld worden</a></li>\n";
                $errorCount++;
            }
            if(empty($_POST["rekenvraag"])) {
                $melding .= "<li><a href=\"#rekenvraag\">De rekenvraag moet u beantwoorden</a></li>\n";
                $errorCount++;
            }
            $captchaResult = $_POST["captchaResult"];
	        $firstNumber = $_POST["firstNumber"];
	        $secondNumber = $_POST["secondNumber"];
            if ($captchaResult != $checkTotal) {
                $$melding .= "<li><a href=\"#rekenvraag\">U heeft de rekenvraag niet goed beantwoord.</a></li>\n";
                $errorCount++;
                $rekenvraag = "";
            }
        }        
        if($errorCount == 0) { 
            echo "<script>
            alert('Uw vraag is verzonden en wordt z.s.m. in behandeling genomen.');
            location.href='/contact';
            </script>"; 
            /*             
            //$sql = "UPDATE artikelen SET titel = ?, tekstArtikel = ? WHERE ID = $artikelID";
            //$stmt = $verbinding->prepare($sql);
            
            try {
                //$stmt = $stmt->execute(array($titel, $myArtikel));
                echo "<script>
                alert('Uw vraag is verzonden.');
                location.href='/contact';</script>";
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
            */
        }
    }
    ?>
    <div class="styleFormDivArtikel">
        <div class="formCssArtikel">
            <div class="divH1Artikel">
                <?php
                $sql = "SELECT * FROM overOns";
                $stmt = $verbinding->prepare($sql);
                $stmt->execute(array());
                $intro = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($intro as $introductie) {
                }
                echo $introductie['overOnsTekst'];
                ?>
            </div>
        </div>
    </div>
    <?php
        include_once("./pages/contactForm.php");
    ?>
    </main>
<?php
    include_once("footer.php");
?>