

    <main id="main">
        <?php
        if($_SESSION["ROL"]==0) {
            echo "<script>
            alert('U heeft geen toegang tot deze pagina.');
            location.href='/uitloggen';
            </script>"; 
        }?>
        <div class="opmaakDivH1">
            <div class="styleFormDiv">
                <div class="divH1">
                    <h1>Overzicht van artikelen</h1>
                    <!--
                    <p>To do:</p>
                    <ol>
                        <li>Afbeeldingen laten wijzigen vanuit pagina afbeelding_bewerken.php met een a-tag op de afbeelding zelf. <a href="https://codepen.io/hollyb/pen/BaavQwJ">Zie deze voorbeeld op codepen</a></li>
                        <li>Inleiding en de huidige datum toevoegen aan de artikel_toevoegen.php. Datum in de footer publiceren</li>
                        <li>Valideer bestanden die ingevoerd worden, namelijk PDF of video (transcriptie)</li>
                    </ol>
                    -->
                </div>
            </div>
        </div>
        <!--
        <div class="styleFormButton">
            <button class="formSubmit" onclick="location.href='/artikel_toevoegen'">Schrijf een nieuw artikel</button>
        </div>
        -->
        <div class="imglist">
            <ul>
            <li class="card">
                <a href="/artikel_toevoegen">
                <div class="img"><img src="/img/imagesForCards/b&amp;w2.jpeg" alt=""></div>
                <div class="text">
                    <h2>Schrijf een nieuw artikel</h2>
                    <p>Over uw werkzaamheden</p> 
                </div>
                </a>                    
            </li>
            <?php
            $sql = "SELECT * FROM artikelen 
            ORDER BY ID DESC";
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
                <a href='/artikel_bewerken&id=$id'>
                <div class='gridCards'>
                    <div class='gridCard'>
                        <div class='card-content'>
                            <h2>".$artikelen['titel']."</h2> 
                        </div>  
                        
                        ";
                        if(!isset($idGalerij['image'])) {
                            echo "
                            <div class='thumbnail'>
                                <img class='cardImg' style=object-fit:contain; src='/img/geenFotoAanwezig1.png' alt='Geen foto aanwezig bij dit artikel'/>
                            </div>
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
    </main>

<?php
    include_once("footer.php");
?>
