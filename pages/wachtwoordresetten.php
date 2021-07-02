
    <main id="main">
        <div class="opmaakDivH1">
            <div class="styleFormDiv">
                <div class="divH1">
                    <h1>Wachtwoord opnieuw instellen</h1>
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
        $wachtwoordErr1 = "";
        $wachtwoordErr2 = "";
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
            $wachtwoord1 = htmlspecialchars($_POST["wachtwoord1"]);
            $wachtwoord2 = htmlspecialchars($_POST["wachtwoord2"]);
            if(empty($_POST["wachtwoord1"])) {
                $melding .= "<li><a href=\"#password1\">Uw bent uw nieuwe wachtwoord vergeten in te voeren</a></li>\n";
                $errorCount++;
            }
            if(empty($_POST["wachtwoord2"])) {
                $melding .= "<li><a href=\"#password2\">Uw bent uw nieuwe wachtwoord vergeten te bevestigen</a></li>\n";
                $errorCount++;
            }
            if($wachtwoord1 != $wachtwoord2) {
                $melding .= "<li><a href=\"#password1\">De nieuwe wachtwoorden komen niet overeen</a></li>\n";
                $errorCount++;
            }
            
            if($errorCount == 0) {
                if(isset($_GET["token"]) && isset($_GET["timestamp"])) {
                    $token = $_GET["token"];
                    $timestamp1 = $_GET["timestamp"];
                    $melding = "<ol>\n";
                    // Zoek in database de e-mailadres en het token uit de link:
                    include("../DBconfig.php");
                    $email = htmlspecialchars($_POST["email"]);
                    $wachtwoordHash = password_hash($wachtwoord1, PASSWORD_DEFAULT);
                    try {
                        $sql = "SELECT * FROM persoonlijk WHERE email = ? AND token = ?";
                        $stmt = $verbinding->prepare($sql);
                        $stmt->execute(array($email,$token));
                        $stmt = $stmt->fetch(PDO::FETCH_ASSOC);
                        // Hier controleren we of de link is verlopen:
                        if($stmt) {
                            $timestamp2 = new DateTime("now");
                            $timestamp2 = $timestamp2->getTimestamp();
                            $dif = $timestamp2 - $timestamp1;
                            // Als de link geldig is, slaan we het nieuwe wachtwoord op:
                            if(($timestamp2 - $timestamp1) < 432000) {
                                $query = "UPDATE persoonlijk SET wachtwoord = ? WHERE email = ?";
                                $stmt = $verbinding->prepare($query);
                                $stmt->execute(array($wachtwoordHash,$email));
                                if($stmt) {
                                    echo "<script>alert('Uw wachtwoord is gereset en u kunt opnieuw inloggen.'); location.href='/inloggen';</script>";
                                }
                            } else {
                                echo "<script>alert('Deze link is verlopen en niet meer geldig.'); location.href='/';</script>";
                            }
                        }
                    }  catch(PDOException $e) {
                        echo $e->getMessage(); 
                    }
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
            <span class="error" autofocus>
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
                <button class="formSubmit" onclick="location.href='/'">Terug</button>
                <form name="wachtwoordresetten" method="POST" enctype="multipart/form-data" action="/wachtwoord_resetten&token=<?php echo $_GET["token"]?>&timestamp=<?php echo $_GET["timestamp"]?>" novalidate>
                <!--Label Emailadres -->
                <label class="formLabel" for="emailText">Emailadres:
                    <strong><abbr title="required">*</abbr></strong>
                </label>
                <input class="formInput" value="<?php echo $email;?>" type="email" name="email" id="emailText" autofocus/>
                <!--Label Wachtwoord 1 -->
                <label class="formLabel" for="password1">Uw nieuwe wachtwoord:
                    <strong><abbr title="required">*</abbr></strong>
                </label>
                <input class="formInput" value="<?php echo $wachtwoord1;?>" type="password" name="wachtwoord1" id="password1"/>
                <!--Label Wachtwoord 2 -->
                <label class="formLabel" for="password2">Bevestig uw nieuwe wachtwoord:
                    <strong><abbr title="required">*</abbr></strong>
                </label>
                <input class="formInput" value="<?php echo $wachtwoord2;?>" type="password" name="wachtwoord2" id="password2"/>
                <input class="formBlueSubmit" type="submit" id="submit" name="submit" value="Wachtwoord aanvragen">
                </form>
            </div>
        </div>
    </main>


