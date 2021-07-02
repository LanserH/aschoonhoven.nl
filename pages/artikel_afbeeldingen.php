
    <main>
        <div class="opmaakDivH1">
            <div class="styleFormDiv">
                <div class="divH1">
                    <h1>Voeg afbeeldingen toe aan uw artikel</h1>
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
        $image = $_FILES['image']['name'];
        $nameImg = htmlspecialchars($_POST['nameImg']);
        $altText = htmlspecialchars($_POST["altText"]);
        //
        $sql = "SELECT * FROM artikelen WHERE ID = ?";
        $stmt = $verbinding->prepare($sql);
        $stmt->execute(array($_GET["id"]));
        $artikelen = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($artikelen as $artikel) {
                $idArtikel = $artikel['ID'];
            }
        $artikelID = $idArtikel;
        $artikelID = $_GET["id"];
        if(isset($_POST["upload"])) {
            $melding = "<ol>\n";
            if($_SERVER["REQUEST_METHOD"] == "POST") {
                if(empty($image)){
                    $melding .= "<li><a href=\"#image\">Vergeet niet uw afbeelding toe te voegen.</a></li>\n";
                    $errorCount++;
                }
                if($image!='' && empty($nameImg)) {
                    $melding .= "<li><a href=\"#image\">De afbeelding moet zijn voorzien van een naam.</a></li>\n";
                    $errorCount++;
                } if($image!='' && empty($altText)) {
                    $melding .= "<li><a href=\"#image\">De afbeelding moet zijn voorzien van een alternatieve tekst.</a></li>\n";
                    $errorCount++;
                }
            }
            if($errorCount == 0) {
                $nameImage = $_POST['nameImg'];
                //$extensions_arr = array("jpg","jpeg","png");
                $target = "./img/upload/".basename($_FILES['image']['name']);
                //$imageFileType = strtolower(pathinfo($target,PATHINFO_EXTENSION));
                $valid_file_extensions = array('image/jpg', 'image/jpeg', 'image/png');
                $file_extension = strrchr($_FILES["image"]["name"], ".");

                $allowed = array('jpg', 'jpeg');
                $filename = $_FILES['image']['name'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                if(!in_array($ext, $allowed)) {
                    $melding .= "<li><a href=\"#image\">Alleen 'jpg', 'jpeg', 'png' bestandstypen zijn toegestaan.</a></li>\n";
                    $errorCount++;
                } else {
                    $sql = "INSERT INTO galerij (ID, artikelID, image, nameImg, altText) values (?,?,?,?,?)";
                    $stmt = $verbinding->prepare($sql);
                    try {
                        $stmt->execute(array(
                            0,
                            $artikelID,
                            $image,
                            $nameImg,
                            $altText,
                        ));
                        move_uploaded_file($_FILES['image']['tmp_name'], $target);
                        $nameImg = '';
                        $altText = '';
                        } catch(PDOException $e) {
                        $melding .= "Kon geen nieuwe afbeelding toevoegen. Neem contact op met uw ontwikkelaar<br>" .$e->getMessage();
                    }
                    echo "<div id='styleFormDiv'>".$melding."</div>";
                }

                /*
                if(in_array($file_extension, $valid_file_extensions)){
                    $sql = "INSERT INTO galerij (ID, artikelID, image, nameImg, altText) values (?,?,?,?,?)";
                    $stmt = $verbinding->prepare($sql);
                    try {
                        $stmt->execute(array(
                            0,
                            $artikelID,
                            $image,
                            $nameImg,
                            $altText,
                        ));
                        move_uploaded_file($_FILES['image']['tmp_name'], $target);
                        $nameImg = '';
                        $altText = '';
                        } catch(PDOException $e) {
                        $melding .= "Kon geen nieuwe afbeelding toevoegen. Neem contact op met uw ontwikkelaar<br>" .$e->getMessage();
                    }
                    echo "<div id='styleFormDiv'>".$melding."</div>";
                } else {
                    $melding .= "<li><a href=\"#image\">Alleen 'jpg', 'jpeg', 'png' bestandstypen zijn toegestaan.</a></li>\n";
                    $errorCount++;
                }
                */
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
                    $sqlGalerij = "SELECT * FROM galerij WHERE artikelID = $artikelID
                    LIMIT 1";
                    $stmtGalerij = $verbinding->prepare($sqlGalerij);
                    $stmtGalerij->execute(array());
                    $galerij = $stmtGalerij->fetchAll(PDO::FETCH_ASSOC);
                    foreach($galerij as $idGalerij) {
                    }
                    if($idGalerij['image']){
                        ?>
                        <button class="formSubmit" onclick="location.href='/artikel_edit&id=<?php echo $artikelID;?>'">Terug</button>
                        <button class="formSubmit" onclick="location.href='/artikel_afbeeldingen&id=<?php echo $artikelID;?>#image'">Voeg meer afbeeldingen toe</button>
                        <button class="formSubmit" onclick="location.href='/artikelen'">Sla uw artikel en afbeelding(en) op</button>
                        <?php
                    } else {
                ?>
                    <button class="formSubmit" onclick="location.href='/artikel_edit&id=<?php echo $artikelID;?>'">Terug</button>
                    <button class="formSubmit" onclick="location.href='/artikelen'">Sla stap 2 over en sla uw artikel op</button>
                <?php
                }
                ?>
                <div class="imageCards">
                    <ul>
                        <?php
                        $sqlGalerij = "SELECT * FROM galerij WHERE artikelID = $artikelID";
                        $stmtGalerij = $verbinding->prepare($sqlGalerij);
                        $stmtGalerij->execute(array());
                        $galerij = $stmtGalerij->fetchAll(PDO::FETCH_ASSOC);
                        foreach($galerij as $idGalerij) {
                        echo "
                        <li class='imageCard'>
                            <a href='/afbeelding_bewerken&id=".$idGalerij['ID']."'>
                                <div class='img'>
                                    <img src='/img/upload/".$idGalerij['image']."' alt='".$idGalerij['altText']."'>
                                </div>
                                <div class='bewerkIMGSpan'>
                                    Bewerk deze afbeelding
                                </div>
                            </a>
                        </li>";
                        }
                        ?>
                    </ul>
                </div>
                <form name="addImage" method="POST" enctype="multipart/form-data" action="/artikel_afbeeldingen&id=<?php echo $artikelID;?>#error">
                <label class="formLabel" for="image">Voeg uw afbeelding toe:</label>

                <input class="formLabel" type="file" name="image" id="image" onchange="loadFileAndText(event)">
                
                <div class="alternatieveTekst" id="idAlternatieveTekst" style="display:none;">
                    <img class="outputImage" id="output" width="150"/>
                </div>        
                
                <label class="formLabel" for="nameImg">Naam van de afbeelding:
                    <strong><abbr title="required">*</abbr></strong>
                </label>
                <input class="formInput" value="<?php echo $nameImg;?>" type="text" name="nameImg" id="nameImg" autofocus/>
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
                <textarea class="textAreaInput" name="altText" id="altText"><?php echo $altText;?></textarea>
                <input type="hidden" name="artikelId" value="<?php echo $artikelID;?>"/>
                <input class="formBlueSubmit" type="submit" id="upload" name="upload" value="Upload uw afbeelding">
                </form>
            </div>
        </div>
    </main>
<?php
    include_once("footer.php");
?>
<script>
    var loadFileAndText = function(event) {  
        var show = document.getElementById('idAlternatieveTekst');
        show.style.display = "block";
        var image = document.getElementById('output');
        image.src = URL.createObjectURL(event.target.files[0]);
    }
</script>
<script>
    function handler(e) {
        e.preventDefault();
        largeimage.setAttribute("src", this.getAttribute("href"));
        largeimage.setAttribute("alt", this.querySelector("img").getAttribute("alt"));
        largeimage.animate([
        { opacity: '0'},
        { opacity: '1'}
        ], {
        duration: 500
        });
    }
    var jgallery = document.getElementById("javascript-gallery"),
    largeimagecontainer = document.getElementById("fullimagecontainer"),
    links = jgallery.getElementsByTagName('a'),
    largeimage = document.createElement("img");

    largeimage.setAttribute("id", "fullimage");
    largeimagecontainer.appendChild(largeimage);

    for (var i=0; i<links.length; i++) {
    links[i].onclick = handler;
    }

    links[0].focus();
    links[0].click();
</script>


