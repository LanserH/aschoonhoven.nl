<?php
$sql = "SELECT * FROM artikelen WHERE ID = ?";
$stmt = $verbinding->prepare($sql);
$stmt->execute(array($_GET["id"]));
$artikelen = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach($artikelen as $artikel) {
}
?>
<main id="main">
    <div class="opmaakDivH1">
        <div class="styleFormDiv">
            <div class="divH1">
                <ol class="cd-breadcrumb custom-separator">
                    <li><a href="/">Home</a></li>
                    <li><a href="/actueel">Actueel</a></li>
                </ol>
            </div>
        </div>
    </div>
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
            $captchaResult = $_POST["rekenvraag"];
            $firstNumber = $_POST["firstNumber"];
            $secondNumber = $_POST["secondNumber"];
            $checkTotal = $firstNumber + $secondNumber;
            if ($captchaResult != $checkTotal) {
                $melding .= "<li><a href=\"#rekenvraag\">U heeft de rekenvraag niet goed beantwoord.</a></li>\n";
                $errorCount++;
                $rekenvraag = "";
            }
        }        
        if($errorCount == 0) {
            include('../DBconfig.php');
            include("./bibliotheek/mailenArtikel.php"); 
            $email = htmlspecialchars($_POST["email"]);
            $vraag = htmlspecialchars($_POST["vraag"]);
            $onderwerp = "Inzending contactformulier";
            $bericht = $vraag;
            try {
                mailen($email, "klant", $onderwerp, $vraag);
                echo "<script>
                alert('Uw vraag is verzonden en wordt z.s.m. in behandeling genomen.');
                location.href='/artikel&id=".$artikel['id']."';
                </script>"; 
            } catch(Exception $e) {
                $melding .= "Uw vraag is niet verzonden. Neem contact op via andere kanalen" + $mail->ErrorInfo;
                $errorCount++;
            }
        }
    }
    ?>
    <div class="styleFormDivArtikel">
        <div class="formCssArtikel">
            <div class="divH1Artikel">
                <?php
                $sql = "SELECT * FROM artikelen WHERE ID = ?";
                $stmt = $verbinding->prepare($sql);
                $stmt->execute(array($_GET["id"]));
                $artikelen = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($artikelen as $artikel) {  
                    $id = $_GET['id'];
                }
                $sqlGalerij = "SELECT * FROM galerij WHERE artikelID = $id";
                $stmtGalerij = $verbinding->prepare($sqlGalerij);
                $stmtGalerij->execute(array());
                $galerij = $stmtGalerij->fetchAll(PDO::FETCH_ASSOC);
                $lus = 0;
                foreach($galerij as $idGalerij) {  
                    $lus++;
                }
                if($lus == 0) {
                    echo "";
                }
                else if($lus == 1) {
                    echo "
                        <div class='divH1ArtikelIMG'>
                            <img src='/img/upload/".$idGalerij['image']."'>
                        </div>
                    ";
                } else {
                    ?>
                    <div class="container2">
                        <?php 
                            foreach($galerij as $idGalerij) {
                            ?>
                            <div class="mySlides imglist">
                                <a href="/img/upload/<?php echo $idGalerij['image'];?>" data-fancybox="images" data-caption="">
                                    <img src="/img/upload/<?php echo $idGalerij['image']?>" alt="Klik op de afbeelding <?php echo $idGalerij['altText']?> om het in een volledige schermformaat te bekijken">
                                </a>
                            </div>
                            <?php
                            }
                        ?>
                        <button class='prev' onclick='plusSlides(-1)'>
                            <span class="visually-hidden">Vorige</span>
                            &lt;
                        </button>
                        <button class='next' onclick='plusSlides(1)'>
                            <span class="visually-hidden">Volgende</span>
                            &gt;
                        </button>
                        <div class='caption-container'>
                            <!--<p id='caption'></p>-->
                        </div>
                        <div class='rowContainer'>                
                            <?php
                                $lus = 0;
                                foreach($galerij as $idGalerij) {
                                $lus++;
                                echo"
                                <div class='columnContainer'>
                                    <a href='javascript:void(0)' onclick='currentSlide($lus);'>
                                        <img class='demo cursor' src='/img/upload/".$idGalerij['image']."' alt='Klik op de afbeelding ".$idGalerij['nameImg']." om het in een groter formaat te zien'>
                                    </a>
                                </div>
                                ";
                                }
                            ?>
                        </div>
                    </div>
                <?php
                }
                echo "<h1>".$artikel['titel']."</h1>";
                if(empty($artikel['inleiding'])) {
                    echo "";
                } else {
                    echo "
                    <div class='inleidingArtikel'>
                    ".$artikel['inleiding']."
                    </div>"
                    ;
                }
                echo $artikel['tekstArtikel'];
                ?>
            </div>
        </div>
    </div>
    <div class="styleDivSharePost">
        <div class="divSharepost">
    <!--Look for share URL for the social media icons in this list-->
            <div class="sharepost">
                <h2>Deel dit artikel:</h2>
                <div class="artikelWrapper">
                    <div class="connect">
                        <?php
                        $sql = "SELECT * FROM artikelen WHERE ID = ?";
                        $stmt = $verbinding->prepare($sql);
                        $stmt->execute(array($_GET["id"]));
                        $artikelen = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach($artikelen as $artikel) {  
                            $id = $_GET['id'];
                        }
                        ?>
                        <a href="mailto:?subject=<?php echo preg_replace('/\s+/', '%020', $artikel['titel']) ?>&amp;body=Graag%20deel%20ik%20met%20u%20de%20artikel%20van%20A%20Schoonhoven%20Dienstverlening:<?php echo "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";?>" class="artikelShare artikelMail" target="_blank">
                            <svg class="svgIcon" viewBox="0 0 20 20">
                                <path d="M17.388,4.751H2.613c-0.213,0-0.389,0.175-0.389,0.389v9.72c0,0.216,0.175,0.389,0.389,0.389h14.775c0.214,0,0.389-0.173,0.389-0.389v-9.72C17.776,4.926,17.602,4.751,17.388,4.751 M16.448,5.53L10,11.984L3.552,5.53H16.448zM3.002,6.081l3.921,3.925l-3.921,3.925V6.081z M3.56,14.471l3.914-3.916l2.253,2.253c0.153,0.153,0.395,0.153,0.548,0l2.253-2.253l3.913,3.916H3.56z M16.999,13.931l-3.921-3.925l3.921-3.925V13.931z">
                            </path>
                            </svg>
                            <span class="clip">Deel dit artikel via email</span>
                        </a>
                        <!-- <a href="whatsapp://send?text=http://localhost:8888/LanserDev/./artikel&id=346" target="_blank" >Share on WhatsApp</a> -->
                        <a href="https://api.whatsapp.com/send?text=<?php echo "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";?>" class="artikelShare artikelWhatsapp" target="_blank" >
                            <svg class="svgIcon" viewBox="0 0 800 800">
                                <path d="M519 454c4 2 7 10-1 31-6 16-33 29-49 29-96 0-189-113-189-167 0-26 9-39 18-48 8-9 14-10 18-10h12c4 0 9 0 13 10l19 44c5 11-9 25-15 31-3 3-6 7-2 13 25 39 41 51 81 71 6 3 10 1 13-2l19-24c5-6 9-4 13-2zM401 200c-110 0-199 90-199 199 0 68 35 113 35 113l-20 74 76-20s42 32 108 32c110 0 199-89 199-199 0-111-89-199-199-199zm0-40c133 0 239 108 239 239 0 132-108 239-239 239-67 0-114-29-114-29l-127 33 34-124s-32-49-32-119c0-131 108-239 239-239z"/>
                            </svg>
                            <span class="clip">Deel dit artikel via Whatsapp</span>
                        </a>
                        <!-- <a href="https://www.facebook.com/sharer.php?u=http://localhost:8888/LanserDev/./artikel&id=346" target="_blank" >Share on FaceBook</a> -->
                        <a href="https://www.facebook.com/sharer.php?u=<?php echo "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";?>" rel="author" class="artikelShare artikelFacebook" target="_blank" >
                            <svg class="svgIcon" viewbox="0 -1 18 18">
                                <path d="M12 3.303h-2.285c-0.27 0-0.572 0.355-0.572 0.831v1.65h2.857v2.352h-2.857v7.064h-2.698v-7.063h-2.446v-2.353h2.446v-1.384c0-1.985 1.378-3.6 3.269-3.6h2.286v2.503z" />
                            </svg>
                            <span class="clip">Deel dit artikel via Facebook</span>
                        </a>
                        <!-- <a href="https://www.linkedin.com/shareArticle?url=http://localhost:8888/LanserDev/./artikel&id=346&title=Accessibility%20weer%20onderdeel%20van%20Bartim%C3%A9us" target="_blank" >Share on LinkedIn</a> -->
                        <a href="https://www.linkedin.com/shareArticle?url=<?php echo "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";?>&title=<?php echo preg_replace('/\s+/', '%020', $artikel['titel']) ?>"
                        class="artikelShare artikelLinkedIn" target="_blank" >
                            <svg class="svgIcon" viewBox="0 0 512 512">
                                <path d="M186.4 142.4c0 19-15.3 34.5-34.2 34.5 -18.9 0-34.2-15.4-34.2-34.5 0-19 15.3-34.5 34.2-34.5C171.1 107.9 186.4 123.4 186.4 142.4zM181.4 201.3h-57.8V388.1h57.8V201.3zM273.8 201.3h-55.4V388.1h55.4c0 0 0-69.3 0-98 0-26.3 12.1-41.9 35.2-41.9 21.3 0 31.5 15 31.5 41.9 0 26.9 0 98 0 98h57.5c0 0 0-68.2 0-118.3 0-50-28.3-74.2-68-74.2 -39.6 0-56.3 30.9-56.3 30.9v-25.2H273.8z"/>
                            </svg>
                            <span class="clip">Deel dit artikel via LinkedIn</span>
                        </a>
                    </div>    
                </div>    
            </div>
        </div>
    </div>
    <?php
        include_once('./pages/contactFormArtikel.php');
    ?>
</main>
<?php
    include_once("footer.php");
?>
<script>
    var slideIndex = 1;
    showSlides(slideIndex);

    function plusSlides(n) {
    showSlides(slideIndex += n);
    }

    function currentSlide(n) {
    showSlides(slideIndex = n);
    }

    function showSlides(n) {
        var i;
        var slides = document.getElementsByClassName("mySlides");
        var dots = document.getElementsByClassName("demo");
        //var captionText = document.getElementById("caption");
        if (n > slides.length) {slideIndex = 1}
        if (n < 1) {slideIndex = slides.length}
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", ".demo:focus", "");
        }
        slides[slideIndex-1].style.display = "block";
        dots[slideIndex-1].className += " active";
        captionText.innerHTML = dots[slideIndex-1].alt;
    }
</script>
<!--<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
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
-->