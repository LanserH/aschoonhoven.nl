

    <main id="main">
        <div class="opmaakDivH1">
            <div class="styleFormDiv">
                <div class="divH1">
                    <h1>Nieuw wachtwoord aanvragen</h1>
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
        $emailErr = "";
        $errorCount = 0;
        if(isset($_POST["submit"])) {
            $melding = "<ol>\n";
            if(IsInjected($email)) {
                //echo "Bad email value!";
                echo "<script>alert('Geen juiste emailadres.');
                location.href='/';
                </script>";
                
            }
            if($_SERVER["REQUEST_METHOD"] == "POST") {
                if (empty($_POST["email"])) {
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
                    } else {
                        $email = htmlspecialchars($_POST["email"]);
                        $sqlEmail = "SELECT * FROM persoonlijk WHERE email = ?";
                        $stmtEmail = $verbinding->prepare($sqlEmail);
                        $stmtEmail->execute(array($email));
                        $resultaatEmail = $stmtEmail->fetch(PDO::FETCH_ASSOC);
                        if(!$resultaatEmail) {
                            $melding .= "<li><a href=\"#emailText\">Dit emailadres is niet bekend bij ons. Voer het juiste emailadres in.</a></li>\n";
                            $errorCount++;
                            //$emailErr = "";
                        }
                    } 
                }
            }
         
            if($errorCount == 0) {
                //$melding = "Test deze volle melding";
                $email = htmlspecialchars($_POST['email']);
                // Hier genereren we een token en een timestamp:
                $token = bin2hex(random_bytes(32));
                $timestamp = new DateTime("now");
                $timestamp = $timestamp->getTimestamp();
                // Hier slaan we het token voor deze klant in de database op:
                include('../DBconfig.php');
                try {
                    $sql = "UPDATE persoonlijk SET token = ? WHERE email = ?";
                    $stmt = $verbinding->prepare($sql);
                    $stmt = $stmt->execute(array($token, $email));
                    if(!$stmt) {
                        echo "<script>alert('Uw emailadres kon niet worden opgeslagen in het database.');
                        location.href='/inloggen';</script>";
                    }
                } catch(PDOException $e) {
                    echo $e->getMessage();
                }  
                // Hier configurere we de URL van de wachtwoord_resetten-pagina:
                $url = sprintf("%s://%s",isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']!='of-f'?'https':'http',$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/./wachtwoord_resetten");
                //Hier voegen we het token en de timestamp aan de URL toe: 
                $url = $url."&amp;token=".$token."&amp;timestamp=".$timestamp;
                // Hier mailen we de URL naar de klant: 
                include("./bibliotheek/mailenWachtwoord.php");
                $onderwerp = "Stel uw wachtwoord opnieuw in voor A Schoonhoven Dienstverlening";
                $bericht = "
                <p>Als u uw wachtwoord op A Schoonhoven Dienstverlening wilt resettten, klik dan 
                <a href=".$url.">op deze link en wijzig uw wachtwoord.</a>
                </p>
                ";
                try {
                    mailen($email, "klant", $onderwerp, $bericht);
                    echo "<script>alert('Open het inbox van uw opgegeven emailadres om het wachtwoord te kunnen wijzigen.');
                    location.href='/';</script>";
                } catch(Exception $e) {
                  $melding .= "Uw emailadres wordt niet herkend" + $mail->ErrorInfo;
                  $errorCount++;
                }
                //echo "<div id='melding'>".$melding."</div>";
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
                //$melding .= "<li><a href=\"#emailText\">Het emailadres is verplicht</a></li>\n";
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
                <button class="formSubmit" onclick="location.href='/inloggen'">Terug</button>
                <br>
                <!--<span class="error">* <?php echo $melding;?></span>-->
                <form name="Wachtwoord vergeten" method="POST" enctype="multipart/form-data" action="/wachtwoord_vergeten#error" novalidate>
                <label class="formLabel" for="emailText">Emailadres:
                    <strong><abbr title="required">*</abbr></strong>
                </label>
                <input class="formInput" value="<?php echo $email;?>" type="email" name="email" id="emailText" aria-labelledby="errWWV" autofocus/>
                <input class="formBlueSubmit" type="submit" id="submit" name="submit" value="Wachtwoord aanvragen">
                </form>
            </div>
        </div>
    </main>

<?php
    include_once("footer.php");
?>