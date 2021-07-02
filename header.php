<!DOCTYPE html>
<html lang="nl">
<head>
  <title><?php echo $titelPagina;?></title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="A Schoonhoven Dienstverlening voor al uw ONTWERPEN / WENSEN / DROMEN op gebied van metaal en tevens inzetbaar in andere branches --> +316-30209619">
  <meta name="keywords" content="aschoonhoven, schoonhoven, aschoonhovendienstverlening, A Schoonhoven Dienstverlening, metaal, dienstverlening, ontwerpen metaal, ontwerp, lassen, 3D cad tekenwerk, 3D cad, tekenen, allround Dienstverlening">
  <meta name="web_author" content="A Schoonhoven Dienstverlening">
  <meta name="author" content="A Schoonhoven Dienstverlening">
  <meta name="designer" content="A Schoonhoven Dienstverlening">
  <meta name="publisher" content="A Schoonhoven Dienstverlening">
  <meta name="copyright" content="A Schoonhoven Dienstverlening">
  <meta name="abstract" content="A Schoonhoven is een specialist op gebied van metaalbewerking en helpt u uw wensen waar te maken.">
  <meta name=”city” content="Zwolle">
  <meta name=”country” content="Nederland"> 
  <meta name="reply-to" content="arjen@aschoonhoven.nl">
  <meta name="robots" content="index, follow">
  <meta name="googlebot" content="index, follow">
  <meta name="revisit-after" content="5 days">
  <!--Link-->
  <link href="/img/icons/logo1Dark.png" rel="shortcut icon">
  <link href="/css/navAndFooterStyles.css" rel="stylesheet">
  <link href="/css/skiplinks.css" rel="stylesheet">
  <link href="/css/logoHeader.css" rel="stylesheet">
  <link href="/css/headers.css" rel="stylesheet">
  <link href="/css/htmlAndBody.css" rel="stylesheet">
  <link href="/css/form.css" rel="stylesheet">
  <link href="/css/button.css" rel="stylesheet">
  <link href="/css/cardStyles.css" rel="stylesheet">
  <link href="/css/listbox.css" rel="stylesheet">
  <link href="/css/editorCss.css" rel="stylesheet">
  <link href="/css/galerij.css" rel="stylesheet">
  <link href="/css/breadcrumb.css" rel="stylesheet">
  <link href="/css/imageCards.css" rel="stylesheet">
  <link href="/css/fancyBox.css" rel="stylesheet">
  <link href="/css/gridCards.css" rel="stylesheet">
  <link href="/css/contactForm.css" rel="stylesheet">
  <link href="/css/searchBar.css" rel="stylesheet">
  <link href="/pages/ckeditor5/sample/css/sample.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="/css/svgIcons.css" rel="stylesheet">
  <script src="/pages/ckeditor5/ckeditor.js"></script>
  <script src="https://cdn.ckeditor.com/ckeditor5/22.0.0/classic/ckeditor.js"></script>
</head>
  <header>
  <?php
    //if(isset($_SESSION["ID"]) && $_SESSION["STATUS"] == "ACTIEF") {
      //echo 'Rol:'. $_SESSION["ROL"];
    if($_SESSION["ROL"]==0) {    
    ?>
    <div class="skiplinks">
      <a href="#main" class="skiplink visuallyHidden visuallyHiddenFocusable" id="skip-link1">Ga naar content</a>
      <a href="/#contactHomepage" class="skiplink visuallyHidden visuallyHiddenFocusable" id="skip-link2">Ga naar contactpagina</a>
      <a href="/sitemap" class="skiplink visuallyHidden visuallyHiddenFocusable" id="skip-link3">Ga naar sitemap</a> 
    </div>
    <div class="logoInHeader">
      <a href="/" class="cssLogo">
        <img src="/img/logoDark.png" alt="Logo van A Schoonhoven Dienstverlening">
      </a>
    </div>
    <nav id="main-menu" aria-labelledby="main-menu-title">
      <span id="main-menu-title" class="menu-title visually-hidden">Main</span>
      <button>Menu</button>
      <ul>
        <li><a href="/" target="_self">Home</a></li>
        <li><a href="/actueel" target="_self">Actueel</a></li>
        <li><a href="/#overOnsHomepage" target="_self">Over ons</a></li>
        <li><a href="/#contactHomepage" target="_self">Contact</a></li>
      </ul>
      <div class="searchBarMenu">
        <form class="searchBar" action="/zoeken" method="POST">
          <label class="visually-hidden" for="search">Zoek op trefwoord</label>
          <input class="searchInput" type="text" name="search" placeholder="Zoeken naar:" pattern=".*\S.*" id="search" value="<?php echo $_POST['search']?>">

          <input type="submit" id="search-button" name="submit" value="Zoeken">
        </form>
      </div>
    </nav>
    <!--
    <nav id="main-menu" aria-labelledby="main-menu-title">
      <span id="main-menu-title" class="menu-title visually-hidden">Main</span>
      <button class="menu-toggle">Menu<span class="visually-hidden"> Toggle Menu</span></button>
      <ul class="menu">
        <li onclick="location.href='/'" class="menu-item"><a href="#" target="_self" class="menu-link">Home</a></li>
        <li class="menu-item"><a href="/actueel" target="_self" class="menu-link">Actueel</a></li>
        <li class="menu-item"><a href="/over_ons" target="_self" class="menu-link">Over ons</a></li>
        <li class="menu-item"><a href="/contact" target="_self" class="menu-link">Contact</a></li>
        <li onclick="location.href='/inloggen'" class="menu-item"><a href="#" target="_self" class="menu-link">Inloggen</a></li>
      </ul>
      <div class="searchBarMenu">
        <form class="searchBar" action="/zoeken" method="POST">
          <label class="visually-hidden" for="search">Zoek op trefwoord</label>
          <input class="searchInput" type="text" name="search" placeholder="Zoeken naar:" pattern=".*\S.*" id="search" value="<?php echo $_POST['search']?>">

          <input type="submit" id="search-button" name="submit" value="Zoeken">
        </form>
      </div>
    </nav>
    -->
    <?php
      } elseif($_SESSION["ROL"]==1){  
    ?>
    <div class="skiplinks">
      <a href="#main" class="skiplink visuallyHidden visuallyHiddenFocusable" id="skip-link1">Ga naar content</a>
      <a href="/gebruikers" class="skiplink visuallyHidden visuallyHiddenFocusable" id="skip-link2">Ga naar gebruikers</a>
      <!--<a href="#" class="skiplink visuallyHidden visuallyHiddenFocusable" id="skip-link3">Ga naar sitemap</a>-->
    </div>
    <div class="logoInHeader">
      <a href="/" class="cssLogo">
        <img src="/img/logoDark.png" alt="Logo van A Schoonhoven Dienstverlening">
      </a>
    </div>
    <nav id="main-menu" aria-labelledby="main-menu-title">
      <span id="main-menu-title" class="menu-title visually-hidden">Main</span>
      <button class="menu-toggle">Menu<span class="visually-hidden"> Toggle Menu</span></button>
      <ul class="menu">
        <li onclick="location.href='/gebruikers'" class="menu-item"><a href="/gebruikers" target="_self" class="menu-link">Gebruikers</a></li>
        <li class="menu-item dropdown">
        <a href="#" class="menu-link dropdown-toggle">Media</a>
          <ul class="menu dropdown">
            <li class="menu-item"><a href="/introHomepage_edit" target="_self" class="menu-link">Homepage</a></li>
            <li class="menu-item"><a href="/artikelen" target="_self" class="menu-link">Artikelen</a></li>
            <li class="menu-item"><a href="/contact_edit" target="_self" class="menu-link">Contact</a></li>
            <li class="menu-item"><a href="/over_ons_edit" target="_self" class="menu-link">Over ons</a></li>
            <li class="menu-item"><a href="/disclaimer_edit" target="_self" class="menu-link">Disclaimer</a></li>
          </ul>
        </li>
        <li onclick="uitloggen()" class="menu-item"><a href="#" target="_self" class="menu-link">Uitloggen</a></li>
      </ul>
      <div class="searchBarMenu">
        <form class="searchBar" action="/zoeken#errorH1" method="POST">
          <label class="visually-hidden" for="search">Zoek op trefwoord</label>
          <input class="searchInput" type="text" name="search" placeholder="Zoeken naar:" pattern=".*\S.*" id="search" value="<?php echo $_POST['search']?>">

          <input type="submit" id="search-button" name="submit" value="Zoeken">
        </form>
      </div>
    </nav>
    <?php
      }
    //} 
    ?>
  </header>



