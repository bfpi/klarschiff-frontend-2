<?php
require_once "config/urls.php";
require_once "php/frontend_dao.php";
$frontend = new FrontendDAO();
$config = include 'config/config.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Portal,Bürgerbeteiligung,Karte,Probleme,Ideen,Verwaltung" />
    <meta name="description" content="Melden Sie via Karte Probleme und Ideen im öffentlichen Raum, die dann von einer kommunalen Verwaltung bearbeitet werden." />
    <meta name="author" content="Hansestadt Rostock" />
    <title>Klarschiff – Portal zur Bürgerbeteiligung</title>
    <link rel="shortcut icon" type="image/x-icon" href="images/icons/favicon.ico" />
    <link rel="alternate" type="application/atom+xml" title="Klarschiff-Meldungen" href="rss.php" />
    <link rel="stylesheet" type="text/css" media="all" href="styles/jquery-ui-1.11.2.min.css" />
    <link rel="stylesheet" type="text/css" media="all" href="libs/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" media="all" href="styles/index.css" />
    <script type="text/javascript" src="javascripts/build/libs.js"></script>
    <script type="text/javascript" src="javascripts/build/index.js"></script>
  </head>
  <body>
    <?php include("header.inc.php"); ?>
    <div class="container">
      <div id="eye-catcher" class="row">
        <div class="overlay guide">
          <h3><span class="italic">Klarschiff</span> – Bürgerbeteiligung</h3>
          <p>
            Rufen Sie die <a href="<?php echo MAP_URL; ?>" target="_self">
              <span class="bold">Karte</span></a> auf <span class="bold">→</span>
            setzen Sie Ihre Meldung an die passende Stelle <span class="bold">→</span>
            beschreiben Sie Ihre Meldung kurz <span class="bold">→</span>
            verfolgen Sie, wie die Stadtverwaltung die Bearbeitung übernimmt.
          </p>
          <p>
            Eine genaue Anleitung finden Sie <a href="hilfe.php" target="_blank"><span class="bold">hier</span></a>.
          </p>
        </div>
        <div class="overlay news">
          <span class="bold">Achtung!</span>
          <p>
            Da es sich bei der vorliegenden Anwendung lediglich um eine <span class="bold">Demo</span> zu Demonstrations- und Testzwecken handelt, werden eingehende Meldungen naturgemäß <span class="bold">nicht</span> als reale Fälle angesehen und von der Verwaltung auch <span class="bold">nicht</span> als solche bearbeitet.
          </p>
        </div>
        <div id="map" title="Karte aufrufen…"></div>
      </div>
      <div id="main" class="row">
        <div id="statistics" class="col-md-4">
          <h2>Statistik</h2>
          <div class="media statistic">
            <?php $new_last_month = $frontend->count_new_advices_last_month(); ?>
            <div class="media-left number red"><?php echo intval($new_last_month); ?></div>
            <div class="media-body text">neue Meldung<?php if (intval($new_last_month) != 1) echo 'en'; ?> letzten Monat</div>
          </div>
          <div class="media statistic">
            <?php $done_last_month = $frontend->count_done_advices_last_month(); ?>
            <div class="media-left number green"><?php echo intval($done_last_month); ?></div>
            <div class="media-body text">Meldung<?php if (intval($done_last_month) != 1) echo 'en'; ?> erledigt letzten Monat</div>
          </div>
          <div class="media statistic">
            <?php $new_since_start = $frontend->count_new_advices_since('2012-03-28'); ?>
            <div class="media-left number yellow"><?php echo intval($new_since_start) ?></div>
            <div class="media-body text">neue Meldung<?php if (intval($new_since_start) != 1) echo 'en' ?> seit 28.03.2012</div>
          </div>
        </div>
        <div class="col-md-4 center">
          <h2>Adressensuche</h2>
          <div id="search">
            <input id="searchtext" size="20" type="text" name="searchtext" title="Ortsteil, Straße oder Adresse eingeben…" />
            <div class="results" id="results-container"></div>
          </div>
          <a id="start" class="button" href="<?php echo MAP_URL; ?>" target="_self">Karte aufrufen</a>
        </div>
        <div id="issues" class="col-md-4">
          <h2>Kürzlich gemeldet<img id="rss" src="images/rss.png" alt="rss-feed" title="Meldungen als RSS-Feed abonnieren…" /></h2>
          <?php foreach ($frontend->newest_advices(4) as $advice) { ?>
            <div class="media issue" data-advice-id="<?php echo $advice['id']; ?>" title="Karte mit Fokus auf diese Meldung aufrufen…">
              <div class="media-left"><img src="images/icons/<?php echo $advice['type']; ?>_<?php echo $advice['status']; ?>_layer.png" alt="icon" /></div>
              <div class="media-body"><?php echo $advice['category'], "<br/>", $advice['subcategory']; ?></div>
            </div>
          <?php } ?>
        </div>
      </div>
      <div class="row footer">
        <h3><span class="italic">Klarschiff</span> mobil</h3>
        Wenn Sie diese Website mit einem Smartphone oder Tablet besuchen, wird automatisch die <a href="<?php echo MOBILE_FRONTEND_URL; ?>" target="_blank"><span class="bold">mobile Version</span></a> von <span class="italic">Klarschiff</span> gestartet.
      </div>
      <div class="row footer">
        <h3><span class="italic">Klarschiff</span> aus Sicht der Verwaltung</span></h3>
        Falls Sie daran interessiert sind, wie die „Rückseite“ von <span class="italic">Klarschiff</span> aussieht, also die Verwaltungsanwendung, dann rufen Sie dieses als <a href="<?php echo BACKEND_URL; ?>" target="_blank"><span class="bold">Backend</span></a> bezeichnete Anwendung doch einfach auf.
      </div>
      <div class="row footer">
        <h3><span class="italic">Klarschiff</span> im Verwaltungsaußendienst</span></h3>
        Falls Sie daran interessiert sind, wie <span class="italic">Klarschiff</span> im Außendienst der Verwaltung verwendet wird, dann rufen Sie den <a href="<?php echo PPC_URL; ?>" target="_blank"><span class="bold">Prüf- und Protokollclient</span></a> auf. Anmelden können Sie sich dort zum Beispiel mit dem Benutzernamen „s01“ und dem Passwort „s01“ (jeweils ohne Anführungszeichen): Dabei handelt es sich um einen exemplarischen Benutzer, der dem (ebenfalls exemplarischen) Außendiensteinheiten-Team 1 zugeordnet ist.
      </div>
    </div>
  </body>
</html>
