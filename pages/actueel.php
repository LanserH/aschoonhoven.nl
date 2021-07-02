<main id="main">
    <div class="opmaakDivH1">
        <div class="divH1Homepage">
            <h1>Actueel</h1>
        </div>
    </div>
    <!--
    <div class="contactBanner">
        <img src="/img/banner/luchtballonnen.webp" alt="Achtergrond foto met luchtballonnen in de lucht">
    </div-->
    <!--  // -->
    <!--<button class="button">Button</button>-->
    <div class="styleImgList">
        <div class="imglist">
            <ul>
            <?php
            $sql = "SELECT * FROM artikelen 
            ORDER BY ID DESC";
            $stmt = $verbinding->prepare($sql);
            $stmt->execute(array());
            $artikel = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($artikel as $artikelen){ 
                $id = $artikelen['ID'];
                $sqlGalerij = "SELECT * FROM galerij WHERE artikelID = $id LIMIT 3";
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
                            <h2>".$artikelen['titel']."</h2> 
                        </div>  
                        
                        ";
                        if($idGalerij['artikelID'] == 0) {
                            echo "
                            
                            ";
                        } else {
                            echo "
                            <picture class='thumbnail'>
                                <img class='cardImg' src='/img/upload/".$idGalerij['image']."' alt='".$idGalerij['nameImg']."' />
                            </picture>
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
</main>
<?php
    include_once("footer.php");
?>
