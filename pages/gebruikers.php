

    <main id="main">
    <div class="opmaakDivH1">
        <div class="styleFormDiv">
            <div class="divH1">
                <h1>Overzicht van gebruikers</h1>
            </div>
        </div>
    </div>
        <div class="styleFormDiv">
            <div class="imglist">
                <div class="cards">
                    <ul>
                        <?php
                        if($_SESSION["ROL"]==0) {
                            echo "<script>
                            alert('U heeft geen toegang tot deze pagina.');
                            location.href='/uitloggen';
                            </script>"; 
                        }
                        $sql = "SELECT * FROM persoonlijk";
                        $stmt = $verbinding->prepare($sql);
                        $stmt->execute(array());
                        $persoonlijks = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach($persoonlijks as $persoon){ 
                            $id = $persoon['ID'];
                        echo "
                        <li class='card'>
                            <a href='/gebruikers_edit&id=".$persoon['ID']."'>
                            <div class='img'><img src='/img/imagesForCards/b&amp;w1.jpeg' alt=''></div>
                            <div class='text'>
                                <h2>".'ID '.$persoon['ID']."</h2>
                                <p>".$persoon['email']."</p>
                                <small></small>
                            </div>
                            </a>
                        </li>";
                        }
                        ?>
                    </ul>
                </div>   
            </div>
        </div> 
    </main>

<?php
    include_once("footer.php");
?>
