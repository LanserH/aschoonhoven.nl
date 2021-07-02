<?php
$titelPagina = "Homepage A Schoonhoven Dienstverlening";
?>
<main id="main">
    <div class="divH1Homepage">
        <h1 class="visually-hidden">Homepage</h1>
    </div>
    <div class="contactBanner">
        <img src="/img/banner/metaalbewerking-01.jpg" alt="">
    </div>
    <div class="textOnBanner">
        <div class="divH1Artikel">
            <?php 
            $sql = "SELECT * FROM introHomepage";
            $stmt = $verbinding->prepare($sql);
            $stmt->execute(array($_GET["id"]));
            $introHomepage = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($introHomepage as $intro) {
            }
            echo $intro['introTekst'];
            ?>
        </div>
    </div>
    <div class="divH2Homepage">
        <div class="divH1Artikel">
            <h2>Actueel</h2>
        </div>
    </div>
    <div class="styleImgList">
        <div class="imglist">
            <ul>
            <?php
            $sql = "SELECT * FROM artikelen 
            ORDER BY ID DESC LIMIT 4";
            $stmt = $verbinding->prepare($sql);
            $stmt->execute(array());
            $artikel = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($artikel as $artikelen){ 
                $id = $artikelen['ID'];
                $sqlGalerij = "SELECT * FROM galerij WHERE artikelID = $id";
                $stmtGalerij = $verbinding->prepare($sqlGalerij);
                $stmtGalerij->execute(array());
                $galerij = $stmtGalerij->fetchAll(PDO::FETCH_ASSOC);
                foreach($galerij as $idGalerij) {
                }
                echo "
                <li class='gridCards'>
                <a href='/artikel/".$id."/" .urlencode($artikelen['titel']) . "'>
                    <div class='gridCards'>
                        <div class='gridCard'>
                       
                            <div class='card-content'>
                                <h3>".$artikelen['titel']."</h3> 
                            </div>  
                            ";
                            if($idGalerij['artikelID'] == 0) {
                                echo "
                                ";
                            } else {
                                echo "
                                <div class='thumbnail'>
                                    <img class='cardImg' src='/img/upload/".$idGalerij['image']."' alt='".$idGalerij['nameImg']."'/>
                                </div>
                                ";
                                /*
                                <footer class='cardFooter'>
                                    <div class='post-meta'>
                                        <p>".$artikelen['subtitel']."</p>
                                    </div>
                                </footer>
                                ";
                                */
                            }
                            echo"
                        </div>
                    </div>  
                    </a>
                </li>";
                }
            ?>
            </ul>
        </div>   
    </div>
    <div class="centerButton">
        <button class="buttonHomepage" onclick="location.href='/actueel'">Lees meer actueel</button>
    </div>
    <!--
    <div class="classRow">
        <div class="row">
            <div class="column1">
                <?php 
                    $sql = "SELECT * FROM introHomepage";
                    $stmt = $verbinding->prepare($sql);
                    $stmt->execute(array($_GET["id"]));
                    $introHomepage = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach($introHomepage as $intro) {
                    }
                    echo $intro['introTekst2'];
                ?>
            </div>
            <div class="column2">
                <h2>Benieuwd of jouw wens technisch of economisch haalbaar is?</h2>
                <div class="centerButtonColumn">
                    <button class="buttonHomepageColumn" onclick="location.href='/contact#email'">Neem contact op</button>
                </div>
            </div>
        </div>
    </div>
    -->
    <div class="styleFormDivArtikel" id="overOnsHomepage">
        <div class="formCssArtikel">
            <div class="divH1Artikel">
                <?php
                $sql = "SELECT * FROM overOns";
                $stmt = $verbinding->prepare($sql);
                $stmt->execute(array());
                $intro = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($intro as $introductie) {
                }
                echo $introductie['overOnsTekst'];
                ?>
            </div>
        </div>
    </div>
    <div id="contactHomepage">
    <?php
        include_once("./pages/contactForm.php");
    ?>
    </div>
</main>
<?php
    include_once("footer.php");
?>

