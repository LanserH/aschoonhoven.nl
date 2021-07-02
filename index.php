<?php
    session_start();
    include_once("DBconfig.php");
    if(isset($_GET["page"])) {
        $page = $_GET["page"];
    } else {
        $page = "homepage";
    }
    if($page) {
        $titelPagina = $page ." | A Schoonhoven Dienstverlening";
        include_once("header.php");
        include("pages/" . $page . ".php");
        // pages/artikel
    }
?>
