

    <main id="main">
    <div class="opmaakDivH1">
        <div class="styleFormDiv">
            <div class="divH1">
                <h1>Disclaimer</h1>
            </div>
        </div>
    </div>
    <div class="styleFormDivArtikel">
        <div class="formCssArtikel">
            <div class="divH1Artikel">
                <?php
                $sql = "SELECT * FROM disclaimer";
                $stmt = $verbinding->prepare($sql);
                $stmt->execute(array());
                $disclaim = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($disclaim as $disclaimer) {
                }
                echo $disclaimer['disclaimerTekst'];
                ?>
            </div>
        </div>
    </div>
    </main>

<?php
    include_once("footer.php");
?>