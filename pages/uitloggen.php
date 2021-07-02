<?php

if(!isset($_SESSION["ID"])&&$_SESSION["STATUS"]!="ACTIEF") {
    echo "<script>
    location.href='/';
    </script>"; 
}
unset($_SESSION["ID"]);
unset($_SESSION["USER_ID"]);
unset($_SESSION["USER_NAAM"]);
unset($_SESSION["STATUS"]);
unset($_SESSION["E-MAIL"]);
unset($_SESSION["ROL"]);
// Session beëindigen:
session_destroy();
// Dataverbinding afsluiten: 
$verbinding = null;
echo "<script>location.href='".$_SERVER["PHP_SELF"]."'</script>";
?>