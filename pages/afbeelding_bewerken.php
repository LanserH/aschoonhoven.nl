

    <main id="main">
    <div class="opmaakDivH1">
            <div class="styleFormDiv">
                <div class="divH1">
                    <h1>Bewerk uw afbeelding</h1>
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
        $nameImg = htmlspecialchars($_POST['nameImg']);
        $altText = htmlspecialchars($_POST['altText']);
        $sql = "SELECT * FROM galerij WHERE ID = ?";
        $stmt = $verbinding->prepare($sql);
        $stmt->execute(array($_GET["id"]));
        $galerijID = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($galerijID as $galerij) {
            //echo $galerij['ID']."<br>";
            //echo $galerij['artikelID'];
            $artikelID = $galerij['artikelID'];
            $idGalerij = $galerij['ID'];
        }
        if(isset($_POST["submit"])) {
            $melding = "<ol>\n";
            if($_SERVER["REQUEST_METHOD"] == "POST") {
                if(empty($_POST["nameImg"])) {
                    $melding .= "<li><a href=\"#nameImg\">Naam van afbeelding is verplicht</a></li>\n";
                    $errorCount++;
                }
                if(empty($_POST["altText"])) {
                    $melding .= "<li><a href=\"#altText\">Alternatieve tekst is verplicht</a></li>\n";
                    $errorCount++;
                }
            }            
            if($errorCount == 0) {                
                $sql = "UPDATE galerij SET nameImg = ?, altText = ? WHERE ID = $idGalerij";
                $stmt = $verbinding->prepare($sql);
                try {
                    $stmt = $stmt->execute(array($nameImg, $altText));
                    echo "<script>alert('Afbeelding en tekst is bijgewerkt en opgeslagen.');
                    location.href='/artikel_bewerken&id=$artikelID';</script>";
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
                <button class="formSubmit" onclick="location.href='/artikel_bewerken&id=<?php echo $artikelID?>'">Terug</button>           
                <button class="formSubmit" onclick="location.href='/afbeelding_verwijderen&id=<?php echo $galerij['ID']?>&artikelID=<?php echo $galerij['artikelID']?>'">Verwijder deze afbeelding</button>
                
                <form name="Bewerk uw afbeelding" method="POST" enctype="multipart/form-data" action="/afbeelding_bewerken&id=<?php echo $idGalerij?>#error" novalidate>
                <?php
                echo "
                <img class='outputImage' src='/img/upload/".$galerij['image']."' alt='".$galerij['altText']."' id='output' width='150' style='border:0px'/>
                ";
                ?>
                <label class="formLabel" for="nameImg">Naam van de afbeelding:
                    <strong><abbr title="required">*</abbr></strong>
                </label>
                <input class="formInput" value="<?php echo $galerij['nameImg'];?>" type="text" name="nameImg" id="nameImg"/>
                <label class="formLabel" for="altText"> 
                        Beschrijf wat zichtbaar is op de afbeelding met ongeveer maximaal 80 woorden! 
                        <strong><abbr title="required">*</abbr></strong>
                </label>
                <div class="spanToelichtingLabel">            
                    <ol>
                        <li>Denk bijvoorbeeld aan een uitleg over een grafiek of een cirkeldiagram.</li>
                        <li>Beschrijf uw product. Bijvoorbeeld een bloem of een auto.</li>
                        <li>Uw beschrijving verhoogt ook de zichtbaarheid van uw website in de zoekmachines.</li>
                        <li>Blinde mensen kunnen met uw hulp ervaren en "zien" wat op de afbeelding staat.</li>
                    </ol> 
                </div>
                <textarea class="textAreaInput" name="altText" id="altText" cols="30" rows="10"><?php echo $galerij['altText'];?></textarea>
                <input class="formBlueSubmit" type="submit" id="submit" name="submit" value="Opslaan">
                </form>
            </div>
        </div>

        <?php
        //    }
        ?>
    </main>

<?php
    include_once("footer.php");
?>
