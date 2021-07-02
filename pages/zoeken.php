
    <main id="main">
    <?php
    function test_input ($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    if(isset($_POST['submit'])) {
    $searchKeyword = htmlspecialchars($_POST['search']);
    $sql = "SELECT * FROM artikelen WHERE titel LIKE '%$searchKeyword%' ORDER BY ID";
    $stmt = $verbinding->prepare($sql);
    $stmt->execute(array());
    $resultaten = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $lus = 0;
    foreach($resultaten as $results) {
        $id = $results['ID'];
        $lus++;
        $sqlGalerij = "SELECT * FROM galerij WHERE artikelID = $id";
        $stmtGalerij = $verbinding->prepare($sqlGalerij);
        $stmtGalerij->execute(array());
        $galerij = $stmtGalerij->fetchAll(PDO::FETCH_ASSOC);
        foreach($galerij as $idGalerij) {
        }
    }
    if(empty($searchKeyword)){
        echo "
        <div class='opmaakDivH1'>
            <div class='styleFormDiv'>
                <div class='divH1 id='errorH1'>
                    <h1><a href=./zoeken#search autofocus>U heeft geen zoekwoord ingevoerd</a></h1>
                </div>
            </div>
        </div>
        ";
        } else {
        ?>
        <div class="opmaakDivH1">
            <div class="styleFormDiv">
                <div class="divH1" id='errorH1'>
                    <h1><a href="./zoeken#rowSearch" autofocus><?php echo $lus;?> resultaten op uw zoekwoord "<?php echo $_POST['search'];?>"</a></h1>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
    <div class="searchResults">
        <div class='rowSearchHeight'>
        <?php
        function highlightWords($text, $word){
            $text = preg_replace('#'. preg_quote($word) .'#i', '<span class="searchHighlight">\\0</span>', $text);
            return $text;
        }
        ?>
        <?php
        foreach($resultaten as $results) {
            $id = $results['ID'];
            $sqlGalerij = "SELECT * FROM galerij WHERE artikelID = $id";
            $stmtGalerij = $verbinding->prepare($sqlGalerij);
            $stmtGalerij->execute(array());
            $galerij = $stmtGalerij->fetchAll(PDO::FETCH_ASSOC);
            foreach($galerij as $idGalerij) {
            }
            $title = !empty($searchKeyword)?highlightWords($results['titel'], $searchKeyword):$results['titel'];
            //$tekstArtikel = !empty($searchKeyword)?highlightWords($results['tekstArtikel'], $searchKeyword):$results['tekstArtikel'];
            if(empty($results)) {
                echo "";
            } else {
                echo "
                    <div class='rowSearch' id='rowSearch'>
                        <a href='./artikel&id=$id'>
                            <div class='columnSearch1'>
                                <h2>$title</h2>
                                ";
                                $tekst = $results['tekstArtikel'];
                                //$aantal = 1000;
                                //$out = (strlen($tekst) > $aantal) ? substr($tekst,0,12).'...' : $tekst;
                                // strip tags to avoid breaking any html
                                // strip tags to avoid breaking any html
                                $string = strip_tags($tekst);
                                if (strlen($string) > 160) {
                                    // truncate string
                                    $stringCut = substr($string, 0, 140);
                                    $endPoint = strrpos($stringCut, ' ');
                                    //if the string doesn't contain any space then it will cut without word basis.
                                    $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                    $string .= '...';
                                }
                                //$out = strlen($tekst) > 50 ? substr($tekst,0,20)."..." : $tekst;
                                echo "
                                <p>$string</p>
                                <div class='bottemColumnSearch1'>
                            <span class='inlineSpanIconSitemap'>&rarr;</span>
                            </div>
                        </div>
                            <div class='columnSearch2'>
                                <div class='columnSearch2Image'>
                                    <img src='./img/upload/".$idGalerij['image']."' alt='".$idGalerij['nameImg']."' />
                                </div>                        
                            </div>
                        </a>
                    </div>
                ";
                }
            }
        }
        ?>
        </div>
    </div>
<?php
    include_once("footer.php");
?>