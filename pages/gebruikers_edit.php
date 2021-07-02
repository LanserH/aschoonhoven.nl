

    <main id="main">
        <div class="opmaakDivH1">
            <div class="styleFormDiv">
                <div class="divH1">
                    <h1>Bewerk uw profiel</h1>
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
        $selectedRol = $_POST['rolOption'];
        $sql = "SELECT * FROM persoonlijk WHERE ID = ?";
        $stmt = $verbinding->prepare($sql);
        $stmt->execute(array($_GET["id"]));
        $persoonlijks = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($persoonlijks as $persoonlijk) {
            $idOfUser = $persoonlijk['ID'];
        }
        if(isset($_POST['submit'])) {
            $melding = "<ol>\n";
            $email = htmlspecialchars($_POST["email"]);
            if($_SERVER["REQUEST_METHOD"] == "POST") {
                if (empty($_POST["email"])) {
                    //$emailErr = "Het emailadres is verplicht";
                    $melding .= "<li><a href=\"#emailText\">Het veld van de emailadres is perongeluk leeg gelaten, wat niet is toegestaan.</a></li>\n";
                    $errorCount++;
                }
            }      
            if($errorCount == 0){         
                $sql = "UPDATE persoonlijk SET rol = ? WHERE ID = $idOfUser";
                $stmt = $verbinding->prepare($sql);
                try {
                    $stmt = $stmt->execute(array($selectedRol));
                    echo "<script>alert('Uw gekozen wijzigingen zijn doorgevoerd en opgeslagen.');
                    location.href='/gebruikers';</script>";
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
                <button class="formSubmit" onclick="location.href='/gebruikers'">Terug</button>           
                <button class="formSubmit" onclick="location.href='/gebruikers_delete&id=<?php echo $_GET['id'] ?>'">Verwijder deze gebruiker</button>

                <form name="Bewerk uw profiel" method="POST" enctype="multipart/form-data" action="/gebruikers_edit&id=<?php echo $idOfUser?>#error" novalidate>
                
                <label class="formLabel" for="email">Emailadres:
                    <strong><abbr title="required">*</abbr></strong>
                </label>
                <input class="formInput" value="<?php echo $persoonlijk['email'];?>" type="email" name="email" id="email" autocomplete="email"/>
                
                <label class="formLabel" for="rol">Toegang:
                    <strong><abbr title="required">*</abbr></strong>
                </label>
                <select class="listbox" name="rolOption" id="rol">
                    <?php
                    if($persoonlijk["rol"] == 0) {
                        echo "<option value='0'>Bezoeker</option>";
                        echo "<option value='1'>Beheerder</option>";
                    } else {
                        echo "<option value='1'>Beheerder</option>";
                        echo "<option value='0'>Bezoeker</option>";    
                    }
                    ?>
                </select>   
                <input class="formBlueSubmit" type="submit" id="submit" name="submit" value="Opslaan">
                </form>
            </div>
        </div>
    </main>

<?php
    include_once("footer.php");
?>
