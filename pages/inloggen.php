<main id="main">
<div class="opmaakDivH1">
    <div class="styleFormDiv">
        <div class="divH1">
            <h1>Inloggen</h1>
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
$wachtwoordErr = "";
$email = $wachtwoord = "";
$errorCount = 0;
if(isset($_POST["submit"])) {
    $melding = "<ol>\n";
    $email = htmlspecialchars($_POST["email"]);
    $wachtwoord = htmlspecialchars($_POST["wachtwoord"]);
    if(IsInjected($email)) {
        //echo "Bad email value!";
        echo "<script>alert('Geen juiste emailadres.');
        location.href='/';
        </script>";
        
    }
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["email"])) {
            //$emailErr = "Het emailadres is verplicht";
            $melding .= "<li><a href=\"#emailText\">Het emailadres is verplicht.</a></li>\n";
            $errorCount++;
        } else {
            $email = test_input($_POST["email"]);
            // check if e-mail address is well-formed
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            //$emailErr = "Verkeerde invoer van het emailadres";
            $melding .= "<li><a href=\"#emailText\">Het emailadres is verkeerd ingevoerd.</a></li>\n";
            $errorCount++;
            }
        }
        if (empty($_POST["wachtwoord"])) {
            //$wachtwoordErr = "Wachtwoord is verplicht";
            $melding .= "<li><a href=\"#passwordText\">U moet uw wachtwoord invoeren.</a></li>\n";
            $errorCount++;
        }
    }
    if($errorCount == 0){
        try {
            $sql = "SELECT * FROM persoonlijk WHERE email = ?";
            $stmt = $verbinding->prepare($sql);
            $stmt->execute(array($email));
            $resultaat = $stmt->fetch(PDO::FETCH_ASSOC);
            if($resultaat) {
                $wachtwoordInDatabase = $resultaat["wachtwoord"];
                $rol = $resultaat["rol"];
                if(password_verify($wachtwoord,$wachtwoordInDatabase)) {
                //if($wachtwoord == $wachtwoordInDatabase){
                    $_SESSION["ID"] = session_id();
                    $_SESSION["USER_ID"] = $resultaat["ID"];
                    $_SESSION["E-MAIL"] = $resultaat["email"];
                    $_SESSION["STATUS"] = "ACTIEF";
                    $_SESSION["ROL"] = $rol;
                    if($rol == 0) {
                        echo "<script>location.href='/inloggen';</script>";
                    } elseif($rol == 1) {
                        //echo 'u bent ingelogd...';
                        echo "<script>
                        location.href='/artikelen';</script>";
                    } else {
                        echo "<script>alert('Toegang geweigerd.');</script>";
                        //$melding .= "Toegang geweigerd<br>";
                    }
                } else {
                    $melding .= "<li><a href=\"#emailText\">Probeer nogmaals in te loggen.</a></li>\n";
                    //echo "<script>alert('Probeer nogmaals in te loggen.');</script>";
                    $errorCount++;
                }
            } else {
                $melding .= "<li><a href=\"#emailText\">De combinatie van het emailadres en wachtwoord is bij ons niet bekend.</a></li>\n";
                $errorCount++;
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        } 
    }
    //echo "<div id='melding'>$melding</div>";
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
<div class="styleFormDiv">
    <span class="error" id="error">
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
        <button class="formSubmit" onclick="location.href='/wachtwoord_vergeten'">Wachtwoord vergeten</button>
        <form name="Inloggen" method="POST" enctype="multipart/form-data" action="/inloggen#error" novalidate>
        <label class="formLabel" for="emailText">Emailadres:
            <strong><abbr title="required">*</abbr></strong>
        </label>
        <input class="formInput" value="<?php echo $email;?>" type="email" name="email" id="emailText" autocomplete="email" autofocus/>
        <label class="formLabel" for="passwordText">Paswoord:
            <strong><abbr title="required">*</abbr></strong>
        </label>
        <input class="formInput" value="<?php echo $wachtwoord;?>" type="password" name="wachtwoord" id="passwordText" autocomplete="new-password"/>
        <input class="formBlueSubmit" type="submit" id="submit" name="submit" value="Inloggen">
        </form>
    </div>
</div>
</main>
<?php
    include_once("footer.php");
?>