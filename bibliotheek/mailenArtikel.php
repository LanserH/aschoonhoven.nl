<?php
    // Deze dependencies laden we handmatig in:
    use PHPMailer\PHPMailer\PHPMailer;
    require 'PHPMailer-master/src/PHPMailer.php';
    require 'PHPMailer-master/src/SMTP.php';
    require 'PHPMailer-master/src/Exception.php';
    // Deze functie stuurt e-mails via Gmail:
   
    function mailen($ontvangerStraat ,$ontvangerNaam, $onderwerp, $bericht) {
        $mail = new PHPMailer();
        // Verbinden met GMail:
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Host = "mail.aschoonhoven.nl";
        $mail->Port = 465;
        //Identificeer jezelf bij Gmail:
        $mail->Username = "arjen@aschoonhoven.nl";
        $mail->Password = "schoonhoven31&Arjen";
        //Email opstellen:
        $mail->isHTML(true);
        $mail->SetFrom($ontvangerStraat);
        $ontvanger = "arjen@aschoonhoven.nl";
        $mail->Subject = $onderwerp;
        $mail->CharSet = "UTF-8";
        $bericht = $bericht;
        $mail->AddAddress($ontvanger ,$ontvangerStraat, $ontvangerNaam);
        $mail->AddEmbeddedImage('./img/logoASDdarkNormalSize.png', 'logoAS', './img/logoASDdarkNormalSize.png'); // attach file logo.jpg, and later link to it using identfier logoimg
        $mail->Body = "
        Geachte heer Schoonhoven,<br><br>
        ".$bericht."
        <br><br>
        Met vriendelijke groet,
        <br><br>
        A Schoonhoven Dienstverlening
        <br><br>
        <a href='https://www.aschoonhoven.nl'>
            <img src=\"cid:logoAS\" alt='Logo van A Schoonhoven Dienstverlening' style='max-width:100%'/>
        </a>
        ";
        //Stuur mail:
        if($mail->send()) {
            echo "<script>alert('Uw vraag is verzonden en wordt z.s.m. in behandeling genomen.');
            location.href='/actueel';</script>";
        } else {
            echo "<script>alert('Het is niet gelukt om uw aanvraag te versturen. Neem contact op via andere kanalen' );
            location.href='/contact';
            </script>";
        }
    }
?>