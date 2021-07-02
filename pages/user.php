

    <main id="main">
        <div class="opmaakDivH1">
            <div class="styleFormDiv">
                <div class="divH1">
                    <h1>Voeg nieuwe gebruiker toe</h1>
                </div>
            </div>
        </div>
        <?php
        /*
        if($_SESSION["ROL"]==0) {
            echo "<script>
            alert('U heeft geen toegang tot deze pagina.');
            location.href='/uitloggen';
            </script>"; 
        }
        */
        function test_input ($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        include("./DBconfig.php");
        include("./bibliotheek/mailen.php");
        $emailErr = "";
        $wachtwoordErr = "";
        $email = $wachtwoord = "";
        $errorCount = 0;
        if(isset($_POST["submit"])) {
            $melding = "<ol>\n";
            $email = htmlspecialchars($_POST["email"]);
            $wachtwoord = htmlspecialchars($_POST["wachtwoord"]);
            if(IsInjected($email)) {
                // Bad email value!;
                echo "<script>alert('Geen juiste emailadres.');
                location.href='/';
                </script>";
                
            }
            if($_SERVER["REQUEST_METHOD"] == "POST") {
                if(empty($_POST["email"])) {
                    //$emailErr = "Het emailadres is verplicht";
                    $melding .= "<li><a href=\"#emailText\">Het emailadres is verplicht</a></li>\n";
                    $errorCount++;
                } else {
                    $email = test_input($_POST["email"]);
                    // check if e-mail address is well-formed
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    //$emailErr = "Verkeerde invoer van het emailadres";
                    $melding .= "<li><a href=\"#emailText\">Het emailadres is verkeerd ingevoerd</a></li>\n";
                    $errorCount++;
                    }
                }
                if(empty($_POST["wachtwoord"])) {
                    $melding .= "<li><a href=\"#passwordText\">U moet verplicht een nieuw wachtwoord invoeren</a></li>\n";
                    $errorCount++;
                }
            }   
            if($errorCount == 0){
                $wachtwoordHash = password_hash($wachtwoord, PASSWORD_DEFAULT);
                // Controleer of e-mail al bestaat. (Geen dubbele adressen)
                $sql = "SELECT * FROM persoonlijk WHERE email = ?";
                $stmt = $verbinding->prepare($sql);
                $stmt->execute(array($email));
                $resultaat = $stmt->fetch(PDO::FETCH_ASSOC);
                    if($resultaat) {
                        $melding .= "<li><a href=\"#emailText\">Dit e-mailadres is al geregistreerd. Kies een ander emailadres.</a></li>\n";
                        $errorCount++;
                    } else {
                        $sql = "INSERT INTO persoonlijk (email, wachtwoord, token, rol) values (?,?,?,?)";
                        $stmt = $verbinding->prepare($sql);
                        try {
                            $stmt->execute(array(
                                $email,
                                $wachtwoordHash,
                                0,0)
                            );
                            echo "<script>alert('Nieuw account aangemaakt en u ontvangt een mail ter bevestiging van uw aangemaakte account.');
                            location.href='/';</script>";
                    } catch(PDOException $e) {
                        $melding = "Kon geen account aanmaken" . $e->getMessage();
                        $errorCount++;
                    }
                    echo "<div id='melding'>".$melding."</div>";
                    // Bevestigin per email:
                    $onderwerp = "Nieuw account"; 
                    $bericht = "Geachte $email, uw account is aangemaakt voor de website van www.aschoonhoven.nl. 
                    <br>De eigenaar zal uw account eerst moeten verifiëren alvorens u toegang ontvangt.
                    <br>
                    <br>Mocht dit te lang duren, neemt u dan alsublieft contact op met de eigenaar van de site";
                    mailen($email, $email, $onderwerp, $bericht);
                }
            }    
        }
        function IsInjected($str) {
        $injections = array('(\n+)',
                    '(\r+)',
                    '(\t+)',
                    '(%0A+)',
                    '(%0D+)',
                    '(%08+)',
                    '(%09+)'
                    );
        $inject = join('|', $injections);
        $inject = "/$inject/i";
        if(preg_match($inject,$str)) {
            return true;
            } else {
                return false;
            }
        }
        ?>
        <div class="styleFormDiv" id="error">   
            <span class="error">
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
                <button class="formSubmit" onclick="location.href='/'">Terug</button>
                <form name="Nieuwe gebruiker aanmaken" method="POST" enctype="multipart/form-data" action="/user#error" novalidate>
                <!-- Emailadres: -->
                <label class="formLabel" for="emailText" id="email">Emailadres:
                    <strong><abbr title="required">*</abbr></strong>
                </label>
                <input class="formInput" name="email" id="emailText" value="<?php echo $email?>" autofocus/>
                <!-- Paswoord: -->
                <label class="formLabel" for="passwordText">Paswoord:
                    <strong><abbr title="required">*</abbr></strong>
                </label>
                <input class="formInput" type="password" name="wachtwoord" id="passwordText" value="<?php echo $wachtwoord?>"/>
                <!-- Recaptcha
                <div class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div>
                 -->
                <input class="formBlueSubmit" type="submit" id="submit" name="submit" value="Inloggen">
                </form>
            </div>
        </div>
    </main>

<?php
    include_once("footer.php");
?>
